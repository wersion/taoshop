<?php
namespace backend\controllers;

use common\models\Nav;
use common\component\BackendBaseController;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use common\component\UtilD;
class NavigatorController extends BackendBaseController
{
    public function  behaviors()
    {
        return [
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['GET'],
                    'ajax-get'=> ['POST','GET'],
                    'add'  => ['GET'],
                    'add-post'=>['POST'],
                ]
                ]
            ];
    }
    /*
     * 自定义导航列表
     */
    public function actionList(){
        return $this->render('navigator');
    }
    
    public function actionAjaxGet() {
        $page = (int)\Yii::$app->request->post('page',1);
        $pageSize = (int)\Yii::$app->request->post('rows',20);

        $navdb = Nav::getDataByPage($page,$pageSize);
        exit(Json::encode($navdb));
    }
    
    public function actionAdd(){
        $sysmain = Nav::getSysnav();
        return $this->render('navigator_add',['sysmain'=>$sysmain]);
    }
    
    public function actionAddPost() {
        $item_name = \Yii::$app->request->post('item_name','');
        $item_url  = \Yii::$app->request->post('item_url','');
        $item_ifshow = \Yii::$app->request->post('item_ifshow','');
        $item_opennew = \Yii::$app->request->post('item_opennew','');
        $item_type = \Yii::$app->request->post('item_type','');
        
        if (empty($item_name || empty($item_url))){
            exit(UtilD::handleResult(false, '必要参数不能为空'));
        }
        
        $vieworder = Nav::find()->select("max(view_order)")
                     ->where("type='{$item_type}'")
                     ->scalar();
        $vieworder = (is_null($vieworder)?0:$vieworder)+1;
        $item_vieworder = \Yii::$app->request->post('item_vieworder','');
        $item_vieworder = !empty($item_vieworder)?$item_vieworder:$vieworder;
        $sql = '';
        //如果设置在中部显示 
        if ($item_ifshow == 1 && $item_type == 'middle'){
            $arr = Nav::analyse_uri($item_url); //分析URI
            if ($arr){
                //设置为显示 
                Nav::setShowInNav($arr['type'], $arr['id'], 1);
                $sql = "INSERT INTO ".Nav::tableName()." (name,ctype,cid,is_show,view_order,open_new,url,type) VALUES 
                    ('$item_name','".$arr['type']."','".$arr['id']."','$item_ifshow','$item_vieworder','$item_opennew','$item_url','$item_type')";
            }
        }
        
        if (empty($sql)){
            $sql = "INSERT INTO ".Nav::tableName()." (name,is_show,view_order,open_new,url,type) VALUES ('$item_name','$item_ifshow','$item_vieworder','$item_opennew','$item_url','$item_type')";
        }
        $status = \Yii::$app->db->createCommand($sql)->execute();
        if (!$status){
            exit(UtilD::handleResult(false, '添加失败，请稍后再试'));
        }
        exit(UtilD::handleResult(true, '保存成功'));
    }
}

?>