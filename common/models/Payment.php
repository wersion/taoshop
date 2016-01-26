<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%payment}}".
 *
 * @property integer $id
 * @property string $pay_code
 * @property string $pay_name
 * @property string $pay_fee
 * @property string $pay_desc
 * @property integer $pay_order
 * @property string $pay_config
 * @property integer $enabled
 * @property integer $is_cod
 * @property integer $is_online
 * @property integer $create_time
 */
class Payment extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_code', 'pay_name'], 'required'],
            [['pay_fee'], 'number'],
            [['pay_order', 'enabled', 'is_cod', 'is_online', 'create_time'], 'integer'],
            [['pay_code'], 'string', 'max' => 16],
            [['pay_name'], 'string', 'max' => 127],
            [['pay_desc'], 'string', 'max' => 512],
            [['pay_config'],'string','max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pay_code' => Yii::t('app', 'Pay Code'),
            'pay_name' => Yii::t('app', 'Pay Name'),
            'pay_fee' => Yii::t('app', 'Pay Fee'),
            'pay_desc' => Yii::t('app', 'Pay Desc'),
            'pay_order' => Yii::t('app', 'Pay Order'),
            'pay_config'=> \Yii::t('app', 'pay Config'),
            'enabled' => Yii::t('app', 'Enabled'),
            'is_cod' => Yii::t('app', 'Is Cod'),
            'is_online' => Yii::t('app', 'Is Online'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
    
    /*
     * 获取启用的支付方式
     */
    public function getEnabledPay() {
        $q = new Query();
        $result = [];
        $data = $q->select('*')
                ->from(self::tableName())
                ->where(['enabled'=>1])
                ->orderBy('pay_order')
                ->all();
        if ($data){
            foreach ($data as $val){
                $result[$val['pay_code']] = $val;
            }
        }
        return $result;
    }
    
    /**
     * 卸载支付方式
     * @param string $code
     * @return \yii\db\integer
     */
    public static function uninstall($code){
        $sql = 'UPDATE '.self::tableName()." SET enabled = 0 WHERE pay_code='{$code}' LIMIT 1";
        return \yii::$app->getDb()->createCommand($sql)->execute();
    }
}
