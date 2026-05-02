<?php

namespace app\models;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Url;
use yii\web\UploadedFile;


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
    public $eventImage;

const CREATE_USER_SCENARIO = 'create_user_scenario';
const UPDATE_USER_SCENARIO = 'update_user_scenario';


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
            [['eventImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['name', 'email'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'hash_password', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::CREATE_USER_SCENARIO] = ['name', 'email', 'hash_password'];
        $scenarios[self::UPDATE_USER_SCENARIO] = ['name', 'email'];

        return $scenarios;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => date('Y-m-d H:i:s'),
            ]
        ];

    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Username'),
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
//        var_dump($password);
//        die();
        return $this->hash_password = Yii::$app->security->generatePasswordHash($password);
    }
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->hash_password);

    }

    public function generateAuthKey(){
    return   $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function getAuthKey(){
        return $this->auth_key;
    }
    public function upload() {

        if (true) {
            $path = $this->uploadPath() . $this->id . "." . $this->eventImage->extension;
            $this->eventImage->saveAs($path);
            $this->image = $this->id . "." . $this->eventImage->extension;
            return $this->save();
        }
    }

    public function uploadPath() {
        return Url::to('@web/uploads/events');
    }

}
