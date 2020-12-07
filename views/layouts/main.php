<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\Menu;

AppAsset::register($this);

$session = \Yii::$app->session;
if (!($session->isActive)) {
    $session->open();
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <nav class="navbar navbar-static-top navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <?php
                echo Menu::widget([
                    'items' => [
                        ['label' => 'Главная', 'url' => ['site/index']],
                        ['label' => 'Новости', 'url' => ['news/index']],
                    ],
                    'activeCssClass'=>'active',
                    'options' => [
                        'class' => 'nav navbar-nav',
                    ]
                ]);
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <?= \app\components\CityWidget::widget(['object'=>'name']) ?>
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?= \app\components\CitiesWidget::widget(); ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container">

    <?= $content ?>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
