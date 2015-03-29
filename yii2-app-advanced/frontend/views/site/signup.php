<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title                   = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="right-part">
	<div class="right-part-wrap" id="map"></div>
</div>
<div class="left-part">
	<div class="left-part-wrap">

		<div class="site-signup">
			<h1><?= Html::encode($this->title) ?></h1>

			<p>Заполните данные для регистрации:</p>

			<div class="row">
				<div class="col-lg-12">
					<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
					<?= $form->field($model, 'username') ?>
					<?= $form->field($model, 'email') ?>
					<?= $form->field($model, 'password')->passwordInput() ?>
					<div class="form-group">
						<?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
					</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
