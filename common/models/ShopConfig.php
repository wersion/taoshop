<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_config}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $code
 * @property string $type
 * @property string $store_range
 * @property string $store_dir
 * @property string $value
 * @property integer $sort_order
 * @property string $notice
 */
class ShopConfig extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['code', 'type', 'value'], 'required'],
            [['code'], 'string', 'max' => 32],
            [['type'], 'string', 'max' => 10],
            [['store_range', 'store_dir','notice'], 'string', 'max' => 255],
            [['value'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'code' => Yii::t('app', 'Code'),
            'type' => Yii::t('app', 'Type'),
            'store_range' => Yii::t('app', 'Store Range'),
            'store_dir' => Yii::t('app', 'Store Dir'),
            'value' => Yii::t('app', 'Value'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'notice' => \yii::t('app', 'notice'),
        ];
    }
    
    
    public static function getAllConfigData(){
        return self::findBySql("SELECT id,code,value");
    }
    
    /**
    * 获得设置信息
    *
    * @param   array   $groups     需要获得的设置组
    * @param   array   $excludes   不需要获得的设置组
    *
    * @return  array
    */
    public static function get_settigs($groups=null,$excludes=null){
        $config_groups = $excludes_groups = '';
        if (!count($groups)){
            foreach ($groups as $key=>$val){
                $config_groups .= " AND (id='$val' OR parent_id='$val')";
            }
        }
        
        if (!count($excludes)){
            foreach ($excludes as $key=>$val){
                $excludes_groups .= " AND (parent_id<>'$val' AND id<>'$val')";
            }
        }
        
        $sql = "SELECT * FROM ".self::tableName()." WHERE type <> 'hidden' $config_groups $excludes_groups ORDER BY parent_id,sort_order,id";
        $item_list = self::findBySql($sql)->all();
        
        /* 整理数据 */
        $group_list = [];
        foreach ($item_list as $val){
            $item = $val->getAttributes();
            $pid = $item['parent_id'];
            $item['name'] = \yii::t("config", $item['code']);
            
            if ($item['code'] == 'sms_shop_mobile'){
                $item['url'] = 1;
            }
            if ($pid == 0){
                if ($item['type'] == 'group'){
                    $group_list[$item['id']] = $item;
                }
            }
            else{
                if (isset($group_list[$pid])){
                    if ($item['store_range']){
                        $item['store_options'] = explode(',', $item['store_range']);
                        foreach ($item['store_options'] as $k=>$v){
                            $item['display_options'][$k] = \yii::t('config', $item['code'].'_'.$v);
                        }
                    }
                    $group_list[$pid]['vars'][] = $item;
                }
            }
        }
        return $group_list;
    }
}
