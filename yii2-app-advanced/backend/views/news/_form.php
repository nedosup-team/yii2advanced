<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php if (isset($project_id)): ?>
        <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::toRoute('news/create')]); ?>
        <?= $form->field($model, 'project_id')->hiddenInput(['value' => $project_id])->label(false) ?>
        <?= $form->field($model, 'in_project')->hiddenInput(['value' => 1])->label(false) ?>
    <?php else: ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'project_id')->dropDownList($model->getProjectsList()) ?>
    <?php endif ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => isset($project_id)?3:6]) ?>

    <?= $form->field($model, 'author_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
