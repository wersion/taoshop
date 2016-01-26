<?php

namespace common\models;

use Yii;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%area_region}}".
 *
 * @property integer $shipping_area_id
 * @property string $region_area
 */
class AreaRegion extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area_region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shipping_area_id'], 'integer'],
            [['region_area'],'string','max'=>32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'shipping_area_id' => Yii::t('app', 'Shipping Area ID'),
            'region_area' => Yii::t('app', 'Region Area'),
        ];
    }
}
