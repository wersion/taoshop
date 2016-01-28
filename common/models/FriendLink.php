<?php

namespace common\models;

use Yii;
use yii\db\Query;
use common\component\ActiveRecordD;

/**
 * This is the model class for table "{{%friend_link}}".
 *
 * @property integer $id
 * @property string $link_name
 * @property string $link_url
 * @property string $link_logo
 * @property integer $show_order
 * @property integer $create_time
 */
class FriendLink extends ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%friend_link}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_name', 'link_url'], 'required'],
            [['show_order', 'create_time'], 'integer'],
            [['link_name','link_url'],'required','on'=>['add','update']],
            [['link_name', 'link_url', 'link_logo'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'link_name' => Yii::t('app', 'Link Name'),
            'link_url' => Yii::t('app', 'Link Url'),
            'link_logo' => Yii::t('app', 'Link Logo'),
            'show_order' => Yii::t('app', 'Show Order'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
    
    /*
     * 后台列表页Ajax获取数据
     */
    public function getDataByPage($page,$pageSize) {
        $q = static::find();
        return $this->getListByPage($page, $pageSize,$q);
    }
    
    /**
     * 检查字段值是否重复
     * @param string $value
     * @param string $field
     */
    public function is_repead($value,$field){
        $query = static::find();
        return $query->where([$field=>$value])->count();
    }
    
    public static function addRowFriendLink($params) {
        $model = new FriendLink();
        $model->setIsNewRecord(true);
        $model->setScenario('add');
        $model->setAttributes($params);
        $model->create_time = time();
        return $model->insert();
    }
    
    /*
     * 修改内容
     */
    public static function modRowFriendLink($id,$params){
        $model = static::findOne($id);
        $model->setAttributes($params);
        return $model->save();
    }
}
