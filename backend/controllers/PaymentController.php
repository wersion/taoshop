<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use common\models\Payment;
use common\component\UtilD;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii;
use yii\helpers\Html;
use common\models\AdminLog;

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
                    'ajaxget'=> ['get'],
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
                $data['rows'][$key]['desc'] = $pay_list[$code]['pay_desc'];
                $data['rows'][$key]['pay_order'] = $pay_list[$code]['pay_order'];
                $data['rows'][$key]['install'] = true;
                $data['rows'][$key]['manage'] = '<a href="'.Url::to(['/payment/uninstall','code'=>$code]).'" onclick="if(confirm(\'确定删除吗？\') == false) return false">卸载</a>
                    &nbsp;&nbsp;<a href="'.Url::to(['/payment/edit','code'=>$code]).'">编辑</a>';
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
                if (in_array($code, ['tenpay','tenpayc2c'])){
                    if ($code == 'tenpay'){
                        $data['rows'][$key]['manage'] = '<a href="'.Url::to(['/payment/install','code'=>$code]).'">安装即时到账</a><br>';
                    }else{
                        $data['rows'][$key]['manage'] = '<a href="'.Url::to(['/payment/install','code'=>$code]).'">安装中介担保</a><br>';
                    }
                }else{
                    $data['rows'][$key]['manage'] = '<a href="'.Url::to(['/payment/install','code'=>$code]).'">安装</a>';
                }
                
            }
            $data['total']++;
        }
        exit(Json::encode($data));
    }
    
    
    /*
     * 安装
     */
    public function actionInstall() {
        $code = \Yii::$app->request->get('code');
        $set_modules = true;
        include_once(\Yii::getAlias('@ext').'/payment/'.$code.'.php');
        
        $data = $modules[0];
        if (isset($data['pay_fee'])){
            $data['pay_fee'] = trim($data['pay_fee']);
        }
        else{
            $data['pay_fee'] = 0;
        }
        $pay['pay_code'] = $data['code'];
        $pay['pay_name'] = \Yii::t($data['code'], $data['code']);
        $pay['pay_desc'] = \Yii::t($data['code'], $data['desc']);
        $pay['is_cod'] = $data['is_cod'];
        $pay['pay_fee']  = $data['pay_fee'];
        $pay['is_online'] = $data['is_online'];
        $pay['pay_config'] = [];
        
        foreach ($data['config'] as $key=>$value){
            $config_desc = \Yii::t($data['code'], $value['name']."_desc");
            $pay['pay_config'][$key] = $value + 
                ['label'=>\Yii::t($data['code'], $value['name']),'value'=>$value['value'],'desc'=>$config_desc];
            
            if ($pay['pay_config'][$key]['type'] == 'select' ||
                $pay['pay_config'][$key]['type'] == 'radiobox')
            {
                $pay['pay_config'][$key]['range'] = \Yii::t($data['code'], $pay['pay_config'][$key]['name'].'_range');
            }
        }
        return $this->render('edit',['pay'=>$pay]);
    }
    
    /*
     * 安装编辑支付方式
     */
    public function actionEditPost(){
        $pay_name = \Yii::$app->request->post('pay_name');
        $pay_code = \Yii::$app->request->post('pay_code');
        $pay_desc = Html::encode(\yii::$app->request->post('pay_desc',''));
        $is_cod   = (int)\yii::$app->request->post('is_cod',0);
        $is_online   = (int)\yii::$app->request->post('is_online',0);
        if (empty($pay_name)){
            exit(Json::encode(['key'=>false,'keyMain'=>\Yii::t('app', 'payment_name').'不能为空']));
        }
        $sql = "SELECT COUNT(*) FROM ".Payment::tableName()." WHERE pay_name='{$pay_name}' AND pay_code <>'{$pay_code}'";
        if (\Yii::$app->db->createCommand($sql)->queryScalar() > 0){
            exit(Json::encode(['key'=>false,'keyMain'=>\Yii::t('app', 'payment_name')."已存在"]));
        }
        
        //取得配置信息
        $pay_config = [];
        if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])){
            for ($i=0; $i<count($_POST['cfg_value']);$i++){
                $pay_config[] = [
                    'name' => trim($_POST['cfg_name'][$i]),
                    'type' => trim($_POST['cfg_type'][$i]),
                    'value'=> trim($_POST['cfg_value'][$i])
                ];
            }
        }
        $pay_config = serialize($pay_config);
        //支付手续费
        $pay_fee = \yii::$app->request->post('pay_fee',0);
        $pay_id  = (int)\yii::$app->request->post('pay_id',0);
        //判断是编辑还是安装
        if($pay_id){
            $sql = "UPDATE ".Payment::tableName()." SET pay_name='{$pay_name}'," .
                   " pay_desc='{$pay_desc}',".
                   " pay_config='{$pay_config}', ".
                   " pay_fee = '{$pay_fee}'" .
                   " WHERE pay_code='{$pay_code}' LIMIT 1";
            $status = \yii::$app->getDb()->createCommand($sql)->execute();
            AdminLog::admin_log($pay_name, 'edit','payment');
            $msg = '修改成功';
        }else{
            $sql = "SELECT COUNT(*) FROM ".Payment::tableName()." WHERE pay_code='{$pay_code}'";
            if (\yii::$app->getDb()->createCommand($sql)->queryScalar()){
                $sql = "UPDATE ".Payment::tableName()." SET pay_name='{$pay_name}'," .
                " pay_desc='{$pay_desc}',".
                " pay_config='{$pay_config}', ".
                " pay_fee = '{$pay_fee}'," .
                " enabled = 1 " .
                " WHERE pay_code='{$pay_code}' LIMIT 1";
                $status = \yii::$app->getDb()->createCommand($sql)->execute();
                $msg = '修改成功';
            }
            else{
                $sql = "INSERT INTO ".Payment::tableName()." (pay_code, pay_name, pay_desc, pay_config, is_cod, pay_fee, enabled, is_online)" .
                       "VALUES ('{$pay_code}','{$pay_name}','{$pay_desc}','{$pay_config}','{$is_cod}','{$pay_fee}',1,'{$is_online}')";
                $status = \yii::$app->getDb()->createCommand($sql)->execute();
                $msg = '安装成功';
            }
            if ($status){
                AdminLog::admin_log($pay_name, 'install','payment');
            }
        }
        exit(Json::encode(['key'=>true,'keyMain'=>$msg]));
    }
    
    /*
     * 编辑
     */
    public function actionEdit(){
        $code = \yii::$app->request->get('code','');
        if (empty($code)){
            UtilD::toJavaScriptAlert(\yii::t('app', 'invalid_parameter','back'));
            \yii::$app->end();
        }
        $sql = "SELECT * FROM ".Payment::tableName()." where pay_code='{$code}' AND enabled=1";
        $pay = \yii::$app->getDb()->createCommand($sql)->queryOne();
        if (empty($pay)){
            UtilD::toJavaScriptAlert(\yii::t('app', 'payment_not_available','back'));
            \yii::$app->end();
        }
        //获取插件信息
        $set_modules = true;
        include_once(\yii::getAlias('@ext').'/payment/'.$code.".php");
        $data = $modules[0];
        
        if (is_string($pay['pay_config'])){
            $store = unserialize($pay['pay_config']);
            $code_list = [];
            foreach ($store as $key=>$val){
                $code_list[$val['name']] = $val['value'];
            }
            $pay['pay_config'] = [];
            /* 循环插件中所有属性 */
            foreach ($data['config'] as $key=>$value){
                $messge = \yii::t($data['code'], $value['name'].'_desc');
                $pay['pay_config'][$key]['desc'] = ($messge == $value['name'].'_desc')?'':$messge;
                $pay['pay_config'][$key]['label'] = \yii::t($data['code'], $value['name']);
                $pay['pay_config'][$key]['name'] = $value['name'];
                $pay['pay_config'][$key]['type'] = $value['type'];
                
                if (isset($code_list[$value['name']])){
                    $pay['pay_config'][$key]['value'] = $code_list[$value['name']];
                }
                else{
                    $pay['pay_config'][$key]['value'] = $value['value'];
                }
                
                if ($pay['pay_config'][$key]['type'] == 'select' ||
                    $pay['pay_config'][$key]['type'] == 'radiobox')
                {
                    $pay['pay_config'][$key]['range'] = \Yii::t($data['code'], $pay['pay_config'][$key]['name'].'_range');
                }
            }
        }
        
        if (!isset($pay['pay_fee'])){
            if (isset($data['pay_fee']))
            {
                $pay['pay_fee'] = $data['pay_fee'];
            }
            else
            {
                $pay['pay_fee'] = 0;
            }
        }
        return $this->render('edit',['pay'=>$pay]);
    }
    
    /*
     * 卸载支付方式
     */
    public function actionUninstall(){
        $code = \yii::$app->request->get('code');
        if(empty($code)){
            UtilD::toJavaScriptAlert(\yii::t('app', 'invalid_parameter'),'back');
            \yii::$app->end();
        }
        $sta = Payment::uninstall($code);
        if ($sta){
            AdminLog::admin_log($code, 'uninstall','payment');
        }
        $this->redirect(Url::to('/payment/list'));
    }
    
    
    
    
    
    
    
    
    
    
}

?>