<?php

namespace common\models;

use Yii;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $cat_name
 * @property string $keywords
 * @property string $cat_desc
 * @property integer $parent_id
 * @property integer $sort_order
 * @property string $measure_unit
 * @property integer $show_in_nav
 * @property integer $is_show
 * @property integer $grade
 * @property string $filter_attr
 * @property integer $create_time
 */
class Category extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['parent_id', 'sort_order', 'show_in_nav', 'is_show', 'grade', 'create_time'], 'integer'],
            [['cat_name'], 'string', 'max' => 64],
            [['keywords', 'cat_desc', 'filter_attr'], 'string', 'max' => 255],
            [['measure_unit'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_name' => Yii::t('app', 'Cat Name'),
            'keywords' => Yii::t('app', 'Keywords'),
            'cat_desc' => Yii::t('app', 'Cat Desc'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'measure_unit' => Yii::t('app', 'Measure Unit'),
            'show_in_nav' => Yii::t('app', 'Show In Nav'),
            'is_show' => Yii::t('app', 'Is Show'),
            'grade' => Yii::t('app', 'Grade'),
            'filter_attr' => Yii::t('app', 'Filter Attr'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
    
    /**
     * 获得指定分类下的子分类的数组
     *
     * @access  public
     * @param   int     $cat_id     分类的ID
     * @param   int     $selected   当前选中分类的ID
     * @param   boolean $re_type    返回的类型: 值为真时返回下拉列表,否则返回数组
     * @param   int     $level      限定返回的级数。为0时返回所有级数
     * @param   int     $is_show_all 如果为true显示所有分类，如果为false隐藏不可见分类。
     * @return  mix
     */
    public static function catList($cat_id=0,$selected=0,$re_type=true,$level=0,$is_show_all = true) {
        return [];
    }
}
