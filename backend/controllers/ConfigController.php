<?php
/**
 * 商城配置控制器
 */
namespace backend\controllers;
use common\component\BackendBaseController;

class ConfigController extends BackendBaseController
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    
    public function actionListedit(){
        return $this->render('listedit');
    }
    
    
    public function actionTest(){
        $model = new \common\models\Area();
        $data = $model->FindAreaAll();
        var_dump($data);exit;
    }

}
