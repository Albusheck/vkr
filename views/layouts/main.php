<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Dropdown;
AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>

</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>

        <?php
            NavBar::begin([
                'brandLabel' => \Yii::$app->name,
                'brandUrl'   => '../calculator/',
                'options'    => [
                    'class' => 'navbar navbar-expand-lg navbar-light bg-warning',
                ],
            ]);

            echo Html::beginTag('div', ['class' => 'navbar-nav ms-auto']); // Меню справа

            if (Yii::$app->user->isGuest) {
                // Кнопки для незарегистрированных пользователей
                echo Html::a('Вход', ['/calculator/login'], ['class' => 'btn btn-outline-light mx-2']);
                echo Html::a('Регистрация', ['/calculator/register'], ['class' => 'btn btn-light']);
            } else {
                // Выпадающее меню для зарегистрированного пользователя
                echo Html::beginTag('div', ['class' => 'nav-item dropdown']);
                echo Html::a(
                    Yii::$app->user->identity->name . ' <span class="caret"></span>', // caret вместо ▼
                    '#',
                    [
                        'class' => 'nav-link dropdown-toggle',
                        'id' => 'navbarDropdown',
                        'role' => 'button',
                        'data-bs-toggle' => 'dropdown',
                        'aria-expanded' => 'false'
                    ]
                );

                echo Dropdown::widget([
                    'items' => [
                        ['label' => 'Профиль', 'url' => ['calculator/profile']],
                        ['label' => 'История расчетов', 'url' => ['/calculator/history']],
                        ['label' => 'Пользователи', 'url' => ['/calculator/users']],
                        '<div class="dropdown-divider"></div>',
                        [
                            'label' => 'Выход',
                            'url' => ['/calculator/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                    ],
                    'options' => ['class' => 'dropdown-menu dropdown-menu-end'], // Меню открывается вправо
                ]);

                echo Html::endTag('div');
            }

            echo Html::endTag('div'); // Закрываем navbar-nav

            NavBar::end();
        ?>
    </header>

    <main id="main" class="flex-shrink-0 mt-4" role="main">
        <div class="container">
            <?php if (empty($this->params['breadcrumbs']) === false): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?php if (!Yii::$app->user->isGuest && Yii::$app->session->get('showWelcome')): ?>
                <div id="welcomeAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    Здравствуйте, <strong><?= Yii::$app->user->identity->name ?></strong>, вы авторизовались в системе расчета стоимости доставки.
                    Теперь все ваши расчеты будут сохранены для последующего просмотра в 
                    <a href="<?= \yii\helpers\Url::to(['/calculation/history']) ?>" class="alert-link">журнале расчетов</a>.
                    
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть" id="hideAlertBtn"></button>
                </div>
            <?php endif; ?>



            <?= $content ?>
        </div>
    </main>

    <footer class="navbar navbar-light bg-light">
        <div class="container">
            <span class="navbar-text">
              &copy; Практикум "ЭФКО Цифровые решения" <?= date('Y') ?>
            </span>
        </div>
    </footer>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("hideAlertBtn")?.addEventListener("click", function () {
            fetch("<?= \yii\helpers\Url::to(['/calculator/hide-alert']) ?>", {
                method: "POST",
                headers: {
                    "X-CSRF-Token": "<?= Yii::$app->request->csrfToken ?>"
                }
            }).then(response => response.json())
            .then(data => console.log("Alert hidden:", data));
        });
    });
    </script>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>