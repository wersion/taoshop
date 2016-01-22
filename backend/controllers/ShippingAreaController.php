<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\filters\VerbFilter;
use yii;
use common\models\ShippingArea;
use yii\helpers\Json;
use common\models\Shipping;
class ShippingAreaController extends BackendBaseController
{
    
    public function behaviors()
    {
        return [
            'verbs'=>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['GET'],
                    'ajax-get'=> ['POST'],
                ]
            ]
        ];
    }
    
    public function actionList() {
        $shiping_id = (int)\Yii::$app->request->get('shipping'); 
        return $this->render('shipping_area_list',['shipping_id'=>$shiping_id]);
    }
    
    /*
     * 获取列表数据
     */
    public function actionAjaxGet() {
        $shipping_id = (int)\yii::$app->request->get('shipping');
        $page = (int)\Yii::$app->request->post('page',1);
        $pageSize = (int)\Yii::$app->request->post('rows',10);
        $list = (new ShippingArea())->getShipingAreaList($shipping_id,$page,$pageSize);
        
        exit(Json::encode(['total'=>count($list),'rows'=>$list]));
    }
    
    /*
     * 添加
     */
    public function actionAdd() {
        $shipping_id = (int)\yii::$app->request->get('shipping',0);
        $sql = "SELECT shipping_name,shipping_code FROM ".Shipping::tableName()." WHERE id={$shipping_id}";
        $shipping = \yii::$app->getDb()->createCommand($sql)->queryOne();
        
        $set_modules = 1;
        include_once(\yii::getAlias('@ext').'/shipping/'.$shipping['shipping_code'].'.php');
        
        $fields = [];
        foreach ($modules[0]['configure'] as $key=>$val){
            $fields[$key]['name'] = $val['name'];
            $fields[$key]['value'] = $val['value'];
            $fields[$key]['label'] = \yii::t('shipping', $val['name']);
        }
        $count = count($fields);
        $fields[$count]['name'] = "freee_money";
        $fields[$count]['value'] = "0";
        $fields[$count]['label'] = \yii::t('shipping', 'free_money');
        
        //如果支持货到付款，则允许设置货到付款支付费用
        if ($modules[0]['cod']){
            $count++;
            $fields[$count]['name'] = "pay_fee";
            $fields[$count]['value'] = "0";
            $fields[$count]['label'] = \yii::t('shipping', 'pay_fee');
        }
        $shipping_area['shipping_id'] = 0;
        $shipping_area['free_money']  = 0;
        return $this->render('shipping_area_info',[
            'shipping_area'=>['shipping_id'=>$shipping_id,'shipping_code'=>$shipping['shipping_code']],
            'fields' => $fields,
            'form_action' => 'insert'
        ]);
    }
    
    
    
    
    
    
    
    
    
    
    
    
}

?>