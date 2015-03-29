<?php
/**
 * Created by PhpStorm.
 * User: ibndoom
 * Date: 28.03.15
 * Time: 18:12
 */

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class SubscribeController extends ActiveController
{
    public $modelClass = 'common\models\Subscriber';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'index' => ['POST'],
        ];
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
//        if ('create' != $action) {
//            return new ForbiddenHttpException('Нет доступа', 1);
//        }
    }
}