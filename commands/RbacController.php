<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();


        // Очистка всех данных (если уже были созданы)
        $auth->removeAll();

        // Создание разрешений
        $calculate = $auth->createPermission('calculate');
        $calculate->description = 'Perform a calculation';
        $auth->add($calculate);

        $viewHistory = $auth->createPermission('viewHistory');
        $viewHistory->description = 'View calculation history';
        $auth->add($viewHistory);

        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $viewAllCalculations = $auth->createPermission('viewAllCalculations');
        $viewAllCalculations->description = 'View all users’ calculations';
        $auth->add($viewAllCalculations);

        // Создание ролей
        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $calculate);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $calculate);
        $auth->addChild($user, $viewHistory);

        $admin = $auth->createRole('administrator');
        $auth->add($admin);
        $auth->addChild($admin, $calculate);
        $auth->addChild($admin, $viewHistory);
        $auth->addChild($admin, $manageUsers);
        $auth->addChild($admin, $viewAllCalculations);

        echo "RBAC успешно настроен!\n";
    }
}
