<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/project', 'id' => 2]);
?>
Новости на проекте!

<?= $resetLink ?>
