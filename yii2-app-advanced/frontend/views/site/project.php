<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \common\models\Project */
$this->title = 'Проект - ' . $model->title;
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="right-part">
	<div class="right-part-wrap">
		<div class="col-md-6"><h4>Новости проекта</h4></div>
		<div class="col-md-6"><?= $this->render('subscription', ['model' => $model]) ?></div>
		<?php
		$news = $model->getNews()->all();
		if (count($news)): ?>
			<table class="table table-striped">
				<?php foreach ($news as $item):
					/* @var $item common\models\News */ ?>
					<tr>
						<td>
							<h5><?= Html::encode($item->title) ?></h5>

							<p><?= Html::encode($item->description) ?></p>
						</td>
					</tr>
				<?php endforeach ?>
			</table>
		<?php endif ?>
	</div>
</div>
<div class="left-part">
	<div class="left-part-wrap">
		<h4>Описание</h4>

		<p><?= Html::encode($model->content); ?></p>
		<h4>Адресс</h4>

		<p>
			<?= Html::a(Html::encode($model->address), "http://maps.google.com/maps?q=" . Html::encode($model->address) . "%40" . (float) $model->lat . "," . (float) $model->lng, ['target' => "_blank"]); ?>
		</p>

		<img
			src="http://maps.google.com/maps/api/staticmap?center=<?= (float) $model->lat ?>,<?= (float) $model->lng ?>&zoom=16&size=400x400&sensor=false&markers=color:blue%7Clabel:A%7C<?= (float) $model->lat ?>,<?= (float) $model->lng ?>"
			style="width: 400px; height: 400px;"/>
	</div>
</div>