<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subscribers".
 *
 * @property integer $id
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribers';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => \common\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'project' => 'projects',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'project'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['project'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['id' => 'project_id'])
            ->viaTable('project_subscriber', ['subscriber_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getProjectsList()
    {
        return ArrayHelper::map(Project::find()->asArray()->all(), 'id', 'title');
    }
}
