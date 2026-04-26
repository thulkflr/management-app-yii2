<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_settings".
 *
 * @property int $id
 * @property int $user_id
 * @property string $language
 * @property int $dark_mode
 * @property int $enable_notification
 *
 * @property Users $user
 */
class UserSettings extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enable_notification'], 'default', 'value' => 0],
            [['user_id', 'language'], 'required'],
            [['user_id', 'dark_mode', 'enable_notification'], 'integer'],
            [['language'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'language' => Yii::t('app', 'Language'),
            'dark_mode' => Yii::t('app', 'Dark Mode'),
            'enable_notification' => Yii::t('app', 'Enable Notification'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

}
