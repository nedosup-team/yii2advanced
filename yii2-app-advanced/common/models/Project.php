<?php

namespace common\models;

use backend\models\Program;
use backend\models\Type;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $description
 * @property string $lat
 * @property string $lng
 * @property string $address
 * @property integer $status
 * @property integer $author_id
 * @property integer $program_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property News[] $news
 * @property Program $program
 * @property Subscriber[] $subscribers
 * @property Type[] $types
 * @property User $user
 */
class Project extends \yii\db\ActiveRecord
{
    const PROJECT_ACTIVE = 10;
    const PROJECT_COMPLETED = 20;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['program'] = function () {
            return $this->getProgram()->one();
        };
        $fields['author'] = function () {
            return $this->getAuthor()->one();
        };
        $fields['types'] = function () {
           return $this->getTypes()->all();
        };

        unset($fields['program_id'], $fields['author_id'], $fields['created_at'], $fields['updated_at']);
        return $fields;
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
            [['content', 'description', 'lat', 'lng', 'address'], 'string'],
            [['status', 'author_id', 'program_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['types_list'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'description' => 'Description',
            'program_id' => 'Программа',
            'types_list' => 'Типы помощи',
            'address' => 'Адресс'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribers()
    {
        return $this->hasMany(Subscriber::className(), ['id' => 'subscriber_id'])
            ->viaTable('project_subscriber', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypes()
    {
        return $this->hasMany(Type::className(), ['id' => 'type_id'])
            ->viaTable('project_type', ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return array
     */
    public function getProgramsList()
    {
        return ArrayHelper::map(Program::find()->asArray()->all(), 'id', 'title');
    }

    /**
     * @return array
     */
    public function getSubscribersList()
    {
        return ArrayHelper::map($this->getSubscribers()->asArray()->all(), 'id', 'email');
    }

    /**
     * @return array
     */
    public function getTypesList()
    {
        return ArrayHelper::map(Type::find()->asArray()->all(), 'id', 'title');
    }

    /**
     * @return array
     */
    public function getNewsList()
    {
        return ArrayHelper::map(News::find()->asArray()->all(), 'id', 'title', 'content', 'author_id', 'create_at');
    }
    
    /**
     * @return string
     */
    public function getTextStatus()
    {
        $status = 'Активен';
       if ( $this::PROJECT_ACTIVE == $this->status ) {
            $status = 'Активен';
        } elseif ($this::PROJECT_COMPLETED == $this->status ) {
            $status = 'Завершён';
        }

        return $status;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        $user = $this->getAuthor()->one();

        return $user->username;
    }

    /**
     * @return string
     */
    public function getProgramTitle()
    {
        $program = $this->getProgram()->one();

        return $program->title;
    }
}
