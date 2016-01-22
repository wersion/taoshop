<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\filters\VerbFilter;

class FriendLinkController extends BackendBaseController
{
    public function behaviors()
    {
        return [
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list'=>['GET'],
                    'ajax-get'=>['POST','GET'],
                ]
             ]
        ];
    }
    
    /*
     * 友情列表
     */
    public function actionList() {
        return $this->render('link_list');
    }
    
    public function actionAjaxGet(){
        $page = (int)\Yii::$app->request->get('page',1);
        var_dump($_GET);exit;
    }
}

?>