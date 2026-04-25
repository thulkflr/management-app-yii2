<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ideas".
 *
 * @property int $id
 * @property int $user_id
 * @property string $owner_name
 * @property string $idea_name
 * @property string $idea_type
 * @property string $idea_description
 * @property string|null $url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Ideas extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ideas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'default', 'value' => null],
            [['user_id', 'owner_name', 'idea_name', 'idea_type', 'idea_description', 'created_at', 'updated_at'], 'required'],
            [['user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['owner_name', 'idea_name', 'idea_type', 'idea_description', 'url'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'owner_name' => Yii::t('app', 'Owner Name'),
            'idea_name' => Yii::t('app', 'Idea Name'),
            'idea_type' => Yii::t('app', 'Idea Type'),
            'idea_description' => Yii::t('app', 'Idea Description'),
            'url' => Yii::t('app', 'Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
