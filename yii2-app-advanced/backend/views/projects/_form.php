<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'program_id')->dropDownList($model->getProgramsList()) ?>

    <?= $form->field($model, 'types_list')->checkboxList($model->getTypesList()) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255, 'id' => 'input_address']) ?>

    <button id="map_reset">Сброс</button>

    <?= $form->field($model, 'lat')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'lng')->hiddenInput()->label(false) ?>

    <p id="map_container" style="width: 100%; height: 350px;"></p>

    <?= $form->field($model, 'status')->hiddenInput(['value' => $model::PROJECT_ACTIVE])->label(false) ?>

    <?= $form->field($model, 'author_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>
    
    <?= $form->field($model, 'status')->hiddenInput(['value' => $model::PROJECT_ACTIVE])->label(false) ?>

    <?= $form->field($model, 'author_id')->hiddenInput(['value' => Yii::$app->user->getId()])->label(false) ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
