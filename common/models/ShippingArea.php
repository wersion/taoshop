<?php

namespace common\models;

use Yii;
use common\component\UtilD;
use yii\helpers\Url;
use yii\data\Pagination;

/**
 * This is the model class for table "{{%shipping_area}}".
 *
 * @property integer $id
 * @property string $shipping_area_name
 * @property integer $shipping_id
 * @property string $configure
 */
class ShippingArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shipping_area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_area_name', 'configure'], 'required'],
            [['shipping_id'], 'integer'],
            [['sa_name'], 'string', 'max' => 127],
            [['configure'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shipping_area_name' => Yii::t('app', 'shipping Area Name'),
            'shipping_id' => Yii::t('app', 'Shipping ID'),
            'configure' => Yii::t('app', 'Configure'),
        ];
    }
    
    /*
     * 取得配送区域列表
     */
    public function getShipingAreaList($shipping_id,$page=1,$pageSize=10) {
        $q = (new yii\db\Query())
            ->select('*')
            ->from(self::tableName());
        if ($shipping_id){
            $q->where(['id'=>$shipping_id]);
        }
        $pages = new Pagination(['totalCount'=>$q->count(),'defaultPageSize'=>$pageSize]);
        $result = $q->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        $list = [];
        foreach ($result as $key=>$row) {
            $sql = "SELECT r.area_name FROM ".AreaRegion::tableName()." AS a, " .
                    Area::tableName()." AS r " .
                   " WHERE a.region_area = r.area_code " .
                   " AND a.shipping_area_id = {$shipping_id}";
            $regions = UtilD::getCol(\Yii::$app->getDb()->createCommand($sql)->queryAll());
            
            $row['shipping_area_regions'] = empty($regions) ?
            '<a href="'.Url::toRoute(['/shipping-area/region','id'=>$row['shipping_area_id']]).
            '" style="color:red">' .\Yii::t('shipping', 'empty_regions'). '</a>': $regions;
            
            $list[] = $row;
        }
        return $list;
    }
}
