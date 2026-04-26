<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_security".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $reset_password_token
 * @property int|null $failed_login_attempts
 * @property string|null $last_login_at
 *
 * @property Users $user
 */
class UserSecurity extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_security';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reset_password_token', 'failed_login_attempts', 'last_login_at'], 'default', 'value' => null],
            [['user_id', 'failed_login_attempts'], 'integer'],
            [['last_login_at'], 'safe'],
            [['reset_password_token'], 'string', 'max' => 255],
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
            'reset_password_token' => Yii::t('app', 'Reset Password Token'),
            'failed_login_attempts' => Yii::t('app', 'Failed Login Attempts'),
            'last_login_at' => Yii::t('app', 'Last Login At'),
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
