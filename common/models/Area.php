<?php

namespace common\models;

use Yii;
use common\component\UtilD;
use yii\db\Query;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $id
 * @property string $area_code
 * @property string $area_name
 * @property string $full_name
 * @property string $first_letter
 * @property string $pinyin
 * @property integer $is_open
 * @property integer $depth
 * @property integer $pid
 * @property integer $max_child
 * @property integer $sort
 * @property integer $priority
 * @property integer $sta
 * @property string $tel_code
 */
class Area extends ActiveRecordD
{
    const CACHE_KEY = 'areaCode_key';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_code', 'area_name', 'full_name', 'first_letter', 'pinyin', 'depth', 'pid', 'max_child'], 'required'],
            [['is_open', 'depth', 'pid', 'max_child', 'sort', 'priority', 'sta'], 'integer'],
            [['area_code', 'area_name', 'pinyin'], 'string', 'max' => 32],
            [['full_name'], 'string', 'max' => 256],
            [['first_letter'], 'string', 'max' => 1],
            [['tel_code'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area_code' => Yii::t('app', 'Area Code'),
            'area_name' => Yii::t('app', 'Area Name'),
            'full_name' => Yii::t('app', 'Full Name'),
            'first_letter' => Yii::t('app', 'First Letter'),
            'pinyin' => Yii::t('app', 'Pinyin'),
            'is_open' => Yii::t('app', 'Is Open'),
            'depth' => Yii::t('app', 'Depth'),
            'pid' => Yii::t('app', 'Pid'),
            'max_child' => Yii::t('app', 'Max Child'),
            'sort' => Yii::t('app', 'Sort'),
            'priority' => Yii::t('app', 'Priority'),
            'sta' => Yii::t('app', 'Sta'),
            'tel_code' => Yii::t('app', 'Tel Code'),
        ];
    }
    
    public function loadDataByCode($areaCode,$depth){
        $key = md5(self::CACHE_KEY.'_'.$areaCode."dep_".$depth);
        $data = UtilD::getCache(__CLASS__, $key);
        if(!$data){
            $sql = "SELECT area_code,area_name,depth FROM ".self::tableName()." WHERE sta=1 AND depth={$depth} AND area_code like '{$areaCode}%' ORDER BY priority ASC,sort ASC,area_code ASC";
            $data = \yii::$app->getDb()->createCommand($sql)->queryAll();
            
            UtilD::setCache(__CLASS__, $key, $data);
        }
        return $data;
    }


    public function FindAreaByCode($areaCode,$depth){
        $data = $this->loadDataByCode($areaCode, $depth);
        $reuslt = [];
        if($data){
            foreach ($data as $val){
                $reuslt[] = ['area_code'=>$val['area_code'],'area_name'=>$val['area_name']];
            }
        }
        return $reuslt;
    }
    
    
    private function getAllArea(){
        $key = md5(self::CACHE_KEY.'AllData');
        $allArea = UtilD::getCache(__CLASS__, $key);
        if (!$allArea){
            $sql = "SELECT id,area_code,area_name,depth,full_name,pid FROM ".self::tableName()." WHERE sta=1 AND depth<=4 ORDER BY priority ASC,sort ASC,area_code ASC";
            $result = \yii::$app->getDb()->createCommand($sql)->queryAll();
            
            foreach ($result as $row){
                $allArea[$row['area_code']] = $row;
                $fullName = explode(',', $allArea[$row['area_code']]['full_name']);
                if (count($fullName)){
                    unset($fullName[0]);
                    $allArea[$row['area_code']]['full_name'] = implode(',', $fullName);
                }
                else{
                    $allArea[$row['area_code']]['full_name'] = str_replace('中国', '全国', $allArea[$row['area_code']]['full_name']);
                }
            }
            UtilD::setCache(__CLASS__, $key, $allArea);
        }
                
        return $allArea;
    }
    
}
