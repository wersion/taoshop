<?php
/**
 * 商城配置控制器
 */
namespace backend\controllers;
use common\component\BackendBaseController;
use common\models\ShopConfig;

class ConfigController extends BackendBaseController
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionListedit(){
        $group_list = ShopConfig::get_settigs([],[5]);
        return $this->render('listedit',['group_list'=>$group_list]);
    }
    
    
    /*
     * 保存商城配置参数
     */
    public function actionPost(){
        $allow_file_types = ['jpg','jpeg','png','gif','bmp','swf'];
        $values = \yii::$app->request->post('value',[]);
        /* 保存变量值 */
        $count = count($values);
        
        $config_data = '';
        
    }

}
