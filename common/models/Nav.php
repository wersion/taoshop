<?php

namespace common\models;

use Yii;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%nav}}".
 *
 * @property integer $id
 * @property string $ctype
 * @property integer $cid
 * @property string $name
 * @property integer $is_show
 * @property integer $view_order
 * @property integer $open_new
 * @property string $url
 * @property string $type
 */
class Nav extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%nav}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'name', 'type'], 'required'],
            [['cid', 'is_show', 'view_order', 'open_new'], 'integer'],
            [['ctype', 'name', 'url'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ctype' => Yii::t('app', 'Ctype'),
            'cid' => Yii::t('app', 'Cid'),
            'name' => Yii::t('app', 'Name'),
            'is_show' => Yii::t('app', 'Is Show'),
            'view_order' => Yii::t('app', 'View Order'),
            'open_new' => Yii::t('app', 'Open New'),
            'url' => Yii::t('app', 'Url'),
            'type' => Yii::t('app', 'Type'),
        ];
    }
    
    /*
     * 按分页查找
     */
    public static function getDataByPage($page,$pageSize) {
        $q = static::find();
        return (new self())->getListByPage($page, $pageSize,$q,false);
    }
    
    /*
     * 获取系统列表
     */
    public static function getSysnav() {
        $sysmain = [
            [\Yii::t('navigator', 'view_cart'),'flow.php'],
            [\Yii::t('navigator', 'pick_out'),'flow.php'],
            [\Yii::t('navigator', 'group_buy_goods'),'flow.php'],
            [\Yii::t('navigator', 'snatch'),'flow.php'],
            [\Yii::t('navigator', 'tag_cloud'),'flow.php'],
            [\Yii::t('navigator', 'user_center'),'flow.php'],
            [\Yii::t('navigator', 'wholesale'),'flow.php'],
            [\Yii::t('navigator', 'activity'),'flow.php'],
            [\Yii::t('navigator', 'myship'),'flow.php'],
            [\Yii::t('navigator', 'message_board'),'flow.php'],
            [\Yii::t('navigator', 'quotation'),'flow.php'],
        ];
        $sysmain[] = ['-','-'];
        $catlist = array_merge(Category::catList(0,0,false),['-'],ArticleCat::articleCatList(0,0,false));
        foreach ($catlist as $key=>$val){
            if (is_array($val)){
                $val['view_name'] = $val['cat_name'];
                
                for ($i=0;$i<$val['level'];$i++){
                    $val['view_name'] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $val['view_name'];
                }
                $val['url'] = str_replace('&amp;','&',$val['url']);
                $val['url'] = str_replace('&', '&amp;', $val['url']);
                $sysmain[] = [
                    $val['cat_name'],
                    $val['url'],
                    $val['view_name']
                ];
            }
        }
        return $sysmain;
    }
    
    /**
     * 确定其为商品分类还是文章分类
     * @param string $uri
     * @todo 方法未完成
     */
    public static function analyse_uri($uri) {
        return false;
    }
    /**
     * 是否显示
     * @param string $type
     * @param integer $id
     * @param string $val
     */
    public static function setShowInNav($type,$id,$val) {
        if ($type == 'c'){
            $tablename = Category::tableName();
        } else {
            $tablename = ArticleCat::tableName();
        }
        $conn = \Yii::$app->getDb();
        return $conn->createCommand("UPDATE $tablename SET show_in_nav='$val' WHERE id=$id")->execute();
    }
}
