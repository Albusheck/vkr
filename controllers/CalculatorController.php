<?php

namespace app\controllers;

use app\models\RegisterForm;
use app\models\Year;
use yii\web\Controller;
use app\models\{
    CalculationForm,
    CalculationRepository,
    LoginForm,
    User,
    RoleForm,
    CalculationHistory,
    CalculationHistorySearch,
};
use app\components\calculator\CalculationResultsService;
use app\models\ArchivePrice;
use app\models\Month;
use app\models\Tonnage;
use app\models\Type;
use yii\filters\AccessControl;
class CalculatorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['users'], // Только для действия 'users'
                        'allow' => true,
                        'roles' => ['administrator'], // Доступ только для администраторов
                    ],
                    [
                        'actions' => ['index', 'validate', 'register', 'login', 'logout', 'hide-alert'], 
                        'allow' => true, // Разрешаем всем пользователям
                    ],
                    [
                        'actions' => ['history', 'profile'], // Только для действия 'users'
                        'allow' => true,
                        'roles' => ['administrator', 'user'], // Доступ только для администраторов                        
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                \Yii::$app->session->setFlash('error', 'У вас нет доступа к этой странице.');
                return \Yii::$app->response->redirect(['calculator/index']); // Редирект на главную
                },
            ],
        ];
    }

    public function actionIndex(): string
    {
        $model = new CalculationForm();
        $prices = ArchivePrice::find()->with(['rawType', 'month', 'tonnage', 'year'])->all();

    
        $priceList = [];
        $monthOrder = [
            'Январь' => 1, 'Февраль' => 2, 'Март' => 3, 'Апрель' => 4, 
            'Май' => 5, 'Июнь' => 6, 'Июль' => 7, 'Август' => 8, 
            'Сентябрь' => 9, 'Октябрь' => 10, 'Ноябрь' => 11, 'Декабрь' => 12
        ];
        
        foreach ($prices as $price) {
            $rawTypeName = $price->rawType->type;
            $monthName = $price->month->name;
            $tonnageValue = $price->tonnage->tonnage;
            $yearValue = $price->year->year;
            $priceList[$rawTypeName][$monthName][$yearValue][$tonnageValue] = $price->price;
        }
        
        // Сортируем месяцы в правильном порядке
        foreach ($priceList as &$rawTypeData) {
            uksort($rawTypeData, function ($a, $b) use ($monthOrder) {
                return $monthOrder[$a] <=> $monthOrder[$b];
            });
        }
        unset($rawTypeData); // Разорвать ссылку для безопасности
        
        //print_r($priceList);
        
        $repository = new CalculationRepository(
            [
                'months' => \yii\helpers\ArrayHelper::getColumn(Month::find()->all(), 'name'), 
                'tonnages' => \yii\helpers\ArrayHelper::getColumn(Tonnage::find()->all(), 'tonnage'),
                'raw_types' => \yii\helpers\ArrayHelper::getColumn(Type::find()->all(), 'type'),
                'years' => \yii\helpers\ArrayHelper::getColumn(Year::find()->all(),'year')
            ],
            $priceList,
        );

        $showCalculation = false;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            (new CalculationResultsService($repository))->handle($model);
//            print_r($priceList);
//            print_r($repository->getPrice($model->month, (int) $model->tonnage, $model->type));
            if ($repository->isPriceExists($model->month, (int) $model->tonnage, $model->type, $model->year) === true) {

                $showCalculation = true;
                if (!\Yii::$app->user->can('guest')) { // Только для авторизованных пользователей
                    $history = new CalculationHistory();
                    $history->user_id = \Yii::$app->user->id;
                    $history->raw_type = $model->type;
                    $history->tonnage = $model->tonnage;
                    $history->month = $model->month;
                    $history->price = $repository->getPrice($model->month, (int)$model->tonnage, $model->type, $model->year);
                    $history->save();
                }
            }

            if ($repository->isPriceExists($model->month, (int) $model->tonnage, $model->type, $model->year) === false) {

                \Yii::$app->session->setFlash('error', 'Стоимость для указанных параметров отсутствует');

                \Yii::$app->response->statusCode = 404;
            }
        }

        return $this->render('index', [
            'repository' => $repository,
            'model' => $model,
            'showCalculation' => $showCalculation,
        ]);
    }

    public function actionValidate()
    {
        $model = new CalculationForm();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }
    }
    public function actionRegister()
    {
        $model = new RegisterForm();
        $this->layout = 'main';
    // Если форма загружена и прошла валидацию
    if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
        $newUser = new User();
        $newUser->name = $model->name;
        $newUser->email = $model->email;
        $newUser->password = \Yii::$app->getSecurity()->generatePasswordHash($model->password);

        if ($newUser->save()) {
            // Сохраняем email и пароль для автозаполнения формы авторизации
            \Yii::$app->session->setFlash('loginData', [
                'email' => $model->email,
                'password' => $model->password,
            ]);

            // Устанавливаем флеш-сообщение об успешной регистрации
            \Yii::$app->session->setFlash('success', 'Регистрация успешна!');

            // Перенаправляем на страницу авторизации
            return $this->redirect(['calculator/login']);            
        }

    }
        return $this->render('register', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['calculator/index']);
        }

        $model = new LoginForm();
    
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            \Yii::$app->session->set('showWelcome', true);
            return $this->redirect(['calculator/index']); // редирект на калькулятор после входа
        }
    
        return $this->render('login', ['model' => $model]);
    }
    
    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect('/calculator'); // Перенаправляем на главную страницу
    }

    public function actionHideAlert()
    {
        \Yii::$app->session->remove('showWelcome'); // Убираем флаг показа
        return $this->asJson(['status' => 'success']);
    }
    
    public function actionUsers()
    {
        $model = new RoleForm();
    
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            // Если была выбрана роль для назначения
            if (\Yii::$app->request->post('assign')) {
                // Проверка на назначение той же роли одному и тому же пользователю
                $userRoles = \Yii::$app->authManager->getRolesByUser($model->userId);
                if (array_key_exists($model->roleName, $userRoles)) {
                    \Yii::$app->session->setFlash('error', 'Пользователю уже назначена эта роль.');
                } else {
                    // Назначение роли
                    if ($model->assignRole()) {
                        \Yii::$app->session->setFlash('success', 'Роль успешно назначена!');
                    } else {
                        \Yii::$app->session->setFlash('error', 'Ошибка при назначении роли.');
                    }
                }
            }
            
            // Если была выбрана роль для снятия
            elseif (\Yii::$app->request->post('revoke')) {
                // Проверка, есть ли у пользователя такая роль
                $userRoles = \Yii::$app->authManager->getRolesByUser($model->userId);
                if (!array_key_exists($model->roleName, $userRoles)) {
                    \Yii::$app->session->setFlash('error', 'У пользователя нет этой роли.');
                } else {
                    // Снятие роли
                    if ($model->revokeRole()) {
                        \Yii::$app->session->setFlash('success', 'Роль успешно снята!');
                    } else {
                        \Yii::$app->session->setFlash('error', 'Ошибка при снятии роли.');
                    }
                }
            }
        }
    
        // Получаем всех пользователей и их роли
        $usersWithRoles = RoleForm::getUsersWithRoles();
    
        return $this->render('users', [
            'model' => $model,
            'usersWithRoles' => $usersWithRoles,
        ]);
    }
    
    public function actionHistory()
    {
        $query = CalculationHistory::find();

        if (!\Yii::$app->user->can('administrator')) { // Обычный пользователь видит только свои расчеты
            $query->where(['user_id' => \Yii::$app->user->id]);
        }

        $searchModel = new CalculationHistorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProfile()
    {
        $user = \Yii::$app->user->identity; // Получаем текущего пользователя
        
        if (!$user) {
            return $this->redirect(['calculator/login']); // Если не авторизован, перенаправляем на вход
        }

        return $this->render('profile', [
            'user' => $user,
        ]);
    }
}