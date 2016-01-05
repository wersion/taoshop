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

}
