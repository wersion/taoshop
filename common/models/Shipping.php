<?php

namespace common\models;

use Yii;
use common\component\UtilD;
use common\component\ActiveRecordD;
define('SHIP_LIST', 'cac|city_express|ems|flat|fpd|post_express|post_mail|presswork|sf_express|sto_express|yto|zto');
/**
 * This is the model class for table "{{%shipping}}".
 *
 * @property integer $id
 * @property string $shipping_code
 * @property string $shipping_name
 * @property string $shipping_desc
 * @property string $insure
 * @property integer $support_cod
 * @property integer $enabled
 * @property string $shipping_print
 * @property string $print_bg
 * @property string $config_lable
 * @property integer $print_model
 * @property integer $shipping_order
 * @property integer $create_time
 */
class Shipping extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_code', 'shipping_name', 'shipping_desc', 'shipping_print'], 'required'],
            [['insure'], 'number'],
            [['support_cod', 'enabled', 'print_model', 'shipping_order', 'create_time'], 'integer'],
            [['shipping_print'], 'string'],
            [['shipping_code'], 'string', 'max' => 32],
            [['shipping_name'], 'string', 'max' => 127],
            [['shipping_desc', 'print_bg'], 'string', 'max' => 255],
            [['config_lable'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shipping_code' => Yii::t('app', 'Shipping Code'),
            'shipping_name' => Yii::t('app', 'Shipping Name'),
            'shipping_desc' => Yii::t('app', 'Shipping Desc'),
            'insure' => Yii::t('app', 'Insure'),
            'support_cod' => Yii::t('app', 'Support Cod'),
            'enabled' => Yii::t('app', 'Enabled'),
            'shipping_print' => Yii::t('app', 'Shipping Print'),
            'print_bg' => Yii::t('app', 'Print Bg'),
            'config_lable' => Yii::t('app', 'Config Lable'),
            'print_model' => Yii::t('app', 'Print Model'),
            'shipping_order' => Yii::t('app', 'Shipping Order'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
    
    /*
     * 卸载配送方式
     */
    public function uninstall($code) {
        $row = (new \yii\db\Query())
            ->select(['id','shipping_name','print_bg'])
            ->from(self::tableName())
            ->where(['shipping_code'=>$code])
            ->limit(1)
            ->one();
        if (!$row) return true;
        $shipping_id = $row['id'];
        $shipping_name = $row['shipping_name'];
        //获取配送地区id
        $rows  = (new \yii\db\Query())
            ->select(['id'])
            ->from(ShippingArea::tableName())
            ->where(['shipping_id'=>$shipping_id])
            ->all();
        $all = UtilD::getCol($rows);
        $in = UtilD::db_create_in(join(',', $all));
        $conn = \Yii::$app->getDb();
        $transaction = $conn->beginTransaction();
        try{
            $sql1 = "DELETE FROM ".AreaRegion::tableName()." WHERE shipping_area_id ".$in;
            $sql2 = "DELETE FROM ".ShippingArea::tableName()." WHERE id=".$shipping_id;
            $sql3 = "DELETE FROM ".Shipping::tableName()." WHERE id=".$shipping_id;
            $conn->createCommand($sql1)->execute();
            $conn->createCommand($sql2)->execute();
            $conn->createCommand($sql3)->execute();
            $transaction->commit();
        } catch (\Exception $e){
            $transaction->rollBack();
            return false;
        }
        //删除上传的非默认快递单
        if ($row['print_bg'] != '' && !UtilD::is_print_bg_default($row['print_bg'])){
            @unlink(\Yii::getAlias('@web').DIRECTORY_SEPARATOR.$row['print_bg']);
        }
        AdminLog::admin_log(addslashes($shipping_name), 'uninstall','shipping');
        return true;
    }
}
