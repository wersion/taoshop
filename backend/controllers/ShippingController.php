<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\filters\VerbFilter;
use common\component\UtilD;
use yii;
use common\models\Shipping;
class ShippingController extends BackendBaseController
{
    public $enableCsrfValidation = false;
    
    
    public function  behaviors()
    {
        return [
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    'ajax-get'=>['GET','POST'],
                 ]
             ]
         ];
    }
    
    
    public function actionList() {
        return $this->render('shipping_list');
    }
    
    public function actionAjaxGet() {
        $modules = UtilD::read_modules(\Yii::getAlias('@ext').'/shipping');
        
        for ($i=0;$i<count($modules);$i++){
            $sql = "SELECT shipping_id, shipping_name, shipping_desc, insure, support_cod,shipping_order FROM " .Shipping::tableName(). " WHERE shipping_code='" .$modules[$i]['code']. "' ORDER BY shipping_order";
            $row = \Yii::$app->getDb()->createCommand($sql)->queryOne();
            if ($row){
                //如果已安装插件
                $modules[$i]['id']      = $row['shipping_id'];
                $modules[$i]['name']    = $row['shipping_name'];
                $modules[$i]['desc']    = $row['shipping_desc'];
                $modules[$i]['insure_fee']  = $row['insure'];
                $modules[$i]['cod']     = $row['support_cod'];
                $modules[$i]['shipping_order'] = $row['shipping_order'];
                $modules[$i]['install'] = 1;
                
                if (isset($modules[$i]['insure']) && ($modules[$i]['insure'] === false))
                {
                    $modules[$i]['is_insure']  = 0;
                }
                else
                {
                    $modules[$i]['is_insure']  = 1;
                }
            }
            else{
                $modules[$i]['name']    = \Yii::t($modules[$i]['code'], $modules[$i]['code']);
                $modules[$i]['desc']    = \Yii::t($modules[$i]['code'], $modules[$i]['desc']);
                $modules[$i]['insure_fee']  = empty($modules[$i]['insure'])? 0 : $modules[$i]['insure'];
                $modules[$i]['cod']     = $modules[$i]['cod'];
                $modules[$i]['install'] = 0;
            }
        }
    }
}

?>