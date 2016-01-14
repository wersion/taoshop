<?php

namespace common\models;

use Yii;

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
}
