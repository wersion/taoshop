<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property integer $last_login
 * @property string $last_ip
 * @property string $action_list
 * @property integer $agency_id
 * @property integer $suppliers_id
 * @property string $todolist
 * @property integer $role_id
 * @property integer $status
 * @property integer $create_time
 */
class Admin extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;
    
    public $password_reset_token;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'last_login', 'last_ip', 'action_list', 'todolist'], 'required'],
            [['last_login', 'agency_id', 'suppliers_id', 'role_id','status', 'create_time'], 'integer'],
            [['action_list', 'todolist'], 'string'],
            [['username', 'email'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 255],
            [['last_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'email' => Yii::t('app', 'Email'),
            'last_login' => Yii::t('app', 'Last Login'),
            'last_ip' => Yii::t('app', 'Last Ip'),
            'action_list' => Yii::t('app', 'Action List'),
            'agency_id' => Yii::t('app', 'Agency ID'),
            'suppliers_id' => Yii::t('app', 'Suppliers ID'),
            'todolist' => Yii::t('app', 'Todolist'),
            'role_id' => Yii::t('app', 'Role ID'),
            'status' => Yii::t('app', 'status'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id){
        return static::findOne(['id'=>$id,'status'=>self::STATUS_ACTIVE]);
    }
    
    /**
     *
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token,$type=null){
        throw new \yii\base\NotSupportedException('is not implemented');
    }
    
    
    public static function findByUsername($username){
        if(is_numeric($username)){
            $param = 'id';
        }elseif (strpos($username, '@')){
            $param = 'email';
        }else{
            $param = 'username';
        }
        return static::findOne([$param=>$username,'status'=>self::STATUS_ACTIVE]);
    }
    
    /**
     * finds user by password reset token
     * @param type $token
     * @return type
     */
    public static function findByPasswordResetToken($token){
        if (!static::isPasswordResetTokenValid($token)){
            return null;
        }
        
        return static::findOne([
            'password_reset_token' => $token,
            'status' =>self::STATUS_ACTIVE,
        ]);
    }
    
    /**
     * find out if password reset token is valid
     * @param string $token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token){
        if (empty($token)){
            return false;
        }
        $expire = \yii::$app->params['passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)  end($parts);
        return $timestamp + $expire > time();
    }
    
    /**
     * @inheritdoc
     */
    public function getId(){
        return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() == $authKey;
    }
    
    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function setPassword($password){
        $this->password_hash = \yii::$app->security->generatePasswordHash($password);
    }
    
   public function generateAuthKey(){
       $this->auth_key = \Yii::$app->security->generateRandomString();
   }
    
   /**
    * Generates new password reset token
    */
   public function generatePasswordResetToken(){
       $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
   }
    
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public function findUserById(){
        return $this->findOne(['id'=>$id,'status'=>self::STATUS_ACTIVE]);
    }
}
