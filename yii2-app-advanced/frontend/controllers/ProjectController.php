<?php
/**
 * Created by PhpStorm.
 * User: ibndoom
 * Date: 28.03.15
 * Time: 18:12
 */

namespace frontend\controllers;

use yii\rest\ActiveController;

class ProjectController extends ActiveController
{
    public $modelClass = 'common\models\Project';
}