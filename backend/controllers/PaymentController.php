<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use common\models\Payment;
use common\component\UtilD;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class PaymentController extends BackendBaseController
{
    public $enableCsrfValidation = false;
    
    public function  behaviors()
    {
        return [
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['get'],
                    //'ajaxget'=> ['get'],
                    ]
                ]
            ];
    }
    /*
     * 支付接口列表
     */
    public function actionList(){
        
        return $this->render('payment_list');
    }
    
    public function actionAjaxGet() {
        $mode = new Payment();
        $pay_list = $mode->getEnabledPay();
        $modules = UtilD::read_modules(\Yii::getAlias('@ext').'/payment');
        $data = ['total'=>0,'rows'=>[]];
        
        foreach ($modules as $key=>$val){
            $code = $val['code'];
            $data['rows'][$key] = $val;
            $data['rows'][$key]['pay_code'] = $code;
            //如果数据库中有支付方式，取数据库中的名称和描述
            if (isset($pay_list[$code])){
                $data['rows'][$key]['name'] = $pay_list[$code]['pay_name'];
                $data['rows'][$key]['pay_fee'] = $pay_list[$code]['pay_fee'];
                $data['rows'][$key]['is_cod'] = $pay_list[$code]['is_cod'];
                $data['rows'][$key]['desc'] = $pay_list[$code]['desc'];
                $data['rows'][$key]['pay_order'] = $pay_list[$code]['pay_order'];
                $data['rows'][$key]['install'] = true;
                $data['rows'][$key]['manage'] = '安装';
            }
            else{
                $data['rows'][$key]['name'] = \Yii::t($val['code'], $val['code']);
                if (!isset($val['pay_fee'])){
                    $data['rows'][$key]['pay_fee'] = 0;
                }
                else{
                    $data['rows'][$key]['pay_fee'] = $val['pay_fee'];
                }
                $data['rows'][$key]['is_cod'] = $val['is_cod'];
                $data['rows'][$key]['pay_order'] = 1;
                $data['rows'][$key]['desc'] = \Yii::t($val['code'], $val['desc']);
                $data['rows'][$key]['install'] = false;
                $data['rows'][$key]['manage'] = '安装';
            }
            $data['total']++;
        }
        exit(Json::encode($data));
    }
}

?>