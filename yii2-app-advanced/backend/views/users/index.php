<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $column) {
                    return Html::activeDropDownList($model, 'role',
                    [
                        User::ROLE_USER => 'Пользователь',
                        User::ROLE_ADMIN  => 'Администратор'
                    ],
                    [
                        'data-id' => $model->id,
                        'onchange' => '
                           document.getElementById("user_'.$model->id.'").value = this.value;
                        '
                    ]

                    );
                },
                'format' => 'raw',
                'filter' => [
                    User::ROLE_USER => 'Пользователь',
                    User::ROLE_ADMIN  => 'Администратор'
                ]
            ],
            [
                'value' => function ($model, $key, $index, $column) {
                    /* @var User $model */
                    $html = Html::beginForm('/index.php?r=users/update&id='.$model->id);
                    $html .= Html::input('hidden','User[role]',$model->status, ['id' => 'user_'.$model->id]);
                    $html .= Html::submitButton('Обновить', ['class' => 'btn btn-success']);
                    $html .= Html::endForm();
                    return $html;
                },
                'format' => 'raw',
                'filter' => [
                    User::ROLE_USER => 'Пользователь',
                    User::ROLE_ADMIN  => 'Администратор'
                ]
            ],
        ],
    ]); ?>

</div>
<style>
    .table.table-striped > tbody > tr > td {
        vertical-align: middle;
    }
</style>
