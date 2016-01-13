<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $log_info
 * @property string $ip_address
 * @property integer $log_time
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'log_time'], 'integer'],
            [['log_info', 'ip_address'], 'required'],
            [['log_info'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'log_info' => Yii::t('app', 'Log Info'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'log_time' => Yii::t('app', 'Log Time'),
        ];
    }
    
    /**
    * 记录管理员的操作内容
    *
    * @access  public
    * @param   string      $sn         数据的唯一值
    * @param   string      $action     操作的类型
    * @param   string      $content    操作的内容
    * @return  void
    */
    public static function admin_log($sn='',$action,$content)
    {
        $log_info = \yii::t('log', $action) . \yii::t('log', $content) . ":".Html::encode($sn);
        $time = time();
        $sql = "INSERT INTO ".self::tableName()." (log_time,user_id,log_info,ip_address) " .
                " VALUES ('{$time}','".\yii::$app->user->id."','".Html::encode($log_info)."','".\yii::$app->request->userIP."')";
        return \yii::$app->getDb()->createCommand($sql)->execute();     
    }
}
