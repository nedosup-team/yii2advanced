<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <p>
                <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
        <div class="col-lg-6">
            <h3>Новости проекта</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'content:ntext',
                    'description:ntext',
                    [
                        'attribute' => 'status',
                        'value' => $model->getTextStatus(),
                    ],
                    [
                        'attribute' => 'author_id',
                        'value' => $model->getAuthorName(),
                    ],
                    [
                        'attribute' => 'program_id',
                        'value' => $model->getProgramTitle(),
                    ],
                    'address',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
        <div class="col-lg-6">
            <h4>Создать новость</h4>
            <?= $this->render('@backend/views/news/_form', [
                'model' => new \common\models\News(),
                'project_id' => $model->id
            ]) ?>

            <?php $news = $model->getNews()->all() ?>

            <?php if (count($news)): ?>
            <h4>Опубликованные новости</h4>
                <?php foreach ($news as $item): ?>
                    <?= DetailView::widget([
                        'model' => $item,
                        'attributes' => [
                            'title',
                            'created_at:datetime',
                            [
                                'attribute' => 'author_id',
                                'value' => $model->getAuthorName(),
                            ],
                            'description:ntext',
                            [
                                'attribute' => 'actions',
                                'format'=>'raw',
                                'value' => Html::a('Изменить', ['news/edit', 'id' => $item->id], ['class' => 'btn btn-primary'])
                                    .'  '.
                                    Html::a('Удалить', ['news/delete', 'id' => $item->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Точно удаляем?',
                                            'method' => 'post',
                                        ],
                                    ])

//                                    Html::a('Изменить', \yii\helpers\Url::toRoute(['news/edit', 'id' => $model->id])) . '   ' . Html::a('Удалить', \yii\helpers\Url::toRoute(['news/delete', 'id' => $model->id]))
                            ],
                        ],
                    ]) ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>



</div>
