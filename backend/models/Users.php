<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $hash_password
 * @property string|null $auth_key
 *
 * @property UserSecurity $userSecurity
 */
class Users extends \yii\db\ActiveRecord
{

    public $password;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'hash_password', 'auth_key'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 0],
            [['hash_password'], 'required'],
            [['name', 'email'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'hash_password', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'hash_password' => Yii::t('app', 'Password'),
            'auth_key' => Yii::t('app', 'Auth Key'),
        ];
    }

    /**
     * Gets query for [[UserSecurity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSecurity()
    {
        return $this->hasOne(UserSecurity::class, ['user_id' => 'id']);
    }
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }
    public function getUserSettings(){
        return $this->hasOne(UserSettings::class,['user_id'=>'id']);
    }

    public function setPassword($password){
        return $this->hash_password = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(){
    return   $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function getAuthKey(){
        return $this->auth_key;
    }


}
