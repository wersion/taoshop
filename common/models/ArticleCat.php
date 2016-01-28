<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article_cat}}".
 *
 * @property integer $id
 * @property string $cat_name
 * @property integer $cat_type
 * @property string $keywords
 * @property string $cat_desc
 * @property integer $sort_order
 * @property integer $show_in_nav
 * @property integer $parent_id
 * @property integer $create_time
 */
class ArticleCat extends \common\component\ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_cat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_type', 'sort_order', 'show_in_nav', 'parent_id', 'create_time'], 'integer'],
            [['cat_name', 'keywords', 'cat_desc'], 'string', 'max' => 255]
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
            'cat_type' => Yii::t('app', 'Cat Type'),
            'keywords' => Yii::t('app', 'Keywords'),
            'cat_desc' => Yii::t('app', 'Cat Desc'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'show_in_nav' => Yii::t('app', 'Show In Nav'),
            'parent_id' => Yii::t('app', 'Parent ID'),
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
     * @return  mix
     */
    public static function articleCatList($cat_id=0,$selected=0,$re_type=true,$level=0) {
        return [];
    }
}
