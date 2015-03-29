<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $project_id
 * @property integer $author_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
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
                    'types_list' => 'types',
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
            [['title'], 'required'],
            [['description'], 'string'],
            [['project_id', 'author_id', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'project_id' => 'Проект',
            'created_at' => 'Создан',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return array
     */
    public function getProjectsList()
    {
        return ArrayHelper::map(Project::find()->asArray()->all(), 'id', 'title');
    }

    /**
     * @return string
     */
    public function getProjectTitle()
    {
        $project = $this->getProject()->one();
        return $project->title;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        $author = $this->getAuthor()->one();
        return $author->username;
    }
}
