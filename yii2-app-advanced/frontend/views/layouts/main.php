<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="global-wrap">
    <div id="header">
        <div class="logo"><img src="/images/logo.jpg" alt=""></div>
        <div class="login">
            <form action="#">
                <label for="login">Логин</label>
                <input type="text" name="" id="login">
                <label for="password">Пароль</label>
                <input type="password" name="" id="password">
                <input type="submit" value="Войти">
            </form>
        </div>
        <div class="program-filter"><form action=""><label>Выберите программу</label><select name="" id=""></select></form></div>
        <div class="project-filter"><form action=""><label>Выберите проект</label><select name="" id=""></select></form></div>
        <div class="type-filter"><form action=""><label>Выберите тип помощи</label><select name="" id=""></select></form></div>

    </div>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
