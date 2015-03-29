<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 3/29/15
 * Time: 17:17
 */
use yii\widgets\ActiveForm,
	\yii\helpers\Html;

/* @var $user common\models\User */
?>
<?php $form = ActiveForm::begin([
	'id'     => 'subscription',
	'action' => ['/subscribe'],
]); ?>
<div class="row">
	<div class="col-xs-6">
		<?php if (Yii::$app->user->isGuest) : ?>
			<input type="email" class="form-control input-sm" name="email" placeholder="Email">
		<?php else : ?>
			<?php $user = Yii::$app->getUser()->getIdentity(); ?>
			<input type="email" class="form-control input-sm" name="email" value="<?= $user->email ?>">
		<?php endif; ?>
	</div>
	<div class="col-xs-6">
		<input type="hidden" name="project[]" value="<?= $model->id ?>">
		<?= Html::submitButton('Подписаться', ['class' => 'btn btn-default btn-xs', 'name' => 'login-button']) ?>
	</div>
</div>
<?php ActiveForm::end(); ?>
