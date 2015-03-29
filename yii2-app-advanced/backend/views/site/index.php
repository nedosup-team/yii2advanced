<?php
/* @var $this yii\web\View */

$this->title = 'Помогатор 9000';
?>
<div class="site-index">
    <?php if (!Yii::$app->user->isGuest && \common\models\User::ROLE_USER == Yii::$app->user->identity->role): ?>
    <div class="jumbotron">
        <h1>Извините, доступ только для администраторов</h1>
    </div>
    <?php else: ?>
    <div class="jumbotron">
        <h1>Админка</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Список действий</h2>
            </div>
            <div class="col-lg-4">
                <h2>Список действий</h2>
            </div>
            <div class="col-lg-4">
                <h2>Список действий</h2>
            </div>
        </div>

    </div>
    <?php endif ?>
</div>
