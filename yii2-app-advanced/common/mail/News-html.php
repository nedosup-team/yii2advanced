<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $project common\models\Project */

$resetLink = Yii::$app->urlManagerFrontEnd->createAbsoluteUrl(['site/project', 'id' => $project->id]);
?>
<div class="news">

    <p>Новости на проекте <?= $project->title ?></p>

    <p><?= Html::a(Html::encode('Подробнее'), $resetLink) ?></p>
</div>
