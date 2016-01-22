<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\filters\VerbFilter;
use common\component\UtilD;
use yii;
use common\models\Shipping;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\AdminLog;
use common\models\common\models;
use yii\helpers\FileHelper;
class ShippingController extends BackendBaseController
{
    
    
    public function  behaviors()
    {
        return [
            'verbs' =>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'list' => ['GET'],
                    'ajax-get'=>['GET','POST'],
                    'install'=>['GET'],
                    'uninstall' => ['GET'],
                    'edit-print-template' => ['GET'],
                    'do-edit-print-template' => ['POST','GET'],
                    'print-del' => ['GET'],
                    'recovery-default-template'=>['GET','POST']
                 ]
             ]
         ];
    }
    
    /*
     * 配送列表视图
     */
    public function actionList() {
        return $this->render('shipping_list');
    }
    
    /*
     * 加载视图数据
     */
    public function actionAjaxGet() {
        $modules = UtilD::read_modules(\Yii::getAlias('@ext').'/shipping');
        
        for ($i=0;$i<count($modules);$i++){
            $sql = "SELECT id, shipping_name, shipping_desc, insure, support_cod,shipping_order FROM " .Shipping::tableName(). " WHERE shipping_code='" .$modules[$i]['code']. "' ORDER BY shipping_order";
            $row = \Yii::$app->getDb()->createCommand($sql)->queryOne();
            if ($row){
                //如果已安装插件
                $modules[$i]['id']      = $row['id'];
                $modules[$i]['name']    = $row['shipping_name'];
                $modules[$i]['desc']    = $row['shipping_desc'];
                $modules[$i]['insure_fee']  = $row['insure']?doubleval($row['insure'])."%":0;
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
                $modules[$i]['manage'] = '<a href="'.Url::toRoute(['/shipping/uninstall','code'=>$modules[$i]['code']]).'">'.\Yii::t('shipping', 'uninstall').'</a>';
                $modules[$i]['manage'] .= ' | <a href="'.Url::toRoute(['/shipping-area/list','shipping'=>$row['id']]).'">'.\Yii::t('shipping', 'shipping_area').'</a>';
                $modules[$i]['manage'] .= ' | <a href="'.Url::toRoute(['/shipping/edit-print-template','shipping'=>$row['id']]).'">'.\yii::t('shipping', 'shipping_print_edit').'</a>';
            }
            else{
                $modules[$i]['name']    = \Yii::t($modules[$i]['code'], $modules[$i]['code']);
                $modules[$i]['desc']    = \Yii::t($modules[$i]['code'], $modules[$i]['desc']);
                $modules[$i]['insure_fee']  = empty($modules[$i]['insure'])? 0 : doubleval($modules[$i]['insure'])."%";
                $modules[$i]['cod']     = $modules[$i]['cod'];
                $modules[$i]['install'] = 0;
                $modules[$i]['manage'] = '<a href="'.Url::toRoute(['/shipping/install','code'=>$modules[$i]['code']]).'">'.\yii::t('shipping', 'install').'</a>';
            }
        }
        exit(Json::encode($modules));
    }
    
    /*
     * 安装配送方式
     */
    public function actionInstall() {
        $code = \Yii::$app->request->get('code','');
        $set_modules = true;
        include_once(\Yii::getAlias('@ext').'/shipping/'.$code.".php");
        
        $sql = "SELECT id FROM ".Shipping::tableName()." WHERE shipping_code='{$code}'";
        $id = \yii::$app->getDb()->createCommand($sql)->queryScalar();
        if ($id > 0 ){
            //如果安装过 设置enable
            $sql = "UPDATE ".Shipping::tableName()." SET enabled=1 WHERE shipping_code='{$code}' LIMIT 1";
            \Yii::$app->getDb()->createCommand($sql)->execute();
        }
        else{
            $insure = empty($modules[0]['insure'])?0:$modules[0]['insure'];
            $sql = "INSERT INTO ".Shipping::tableName()." (shipping_code, shipping_name, shipping_desc, insure, support_cod, enabled, print_bg, config_lable, print_model) VALUES ".
                   " ('".addslashes($modules[0]['code'])."','".addslashes(\yii::t($code, $modules[0]['code']))."','".addslashes(\yii::t($code, $modules[0]['desc']))."','".$insure."',
                       '".intval($modules[0]['cod'])."',1,'".addslashes($modules[0]['print_bg'])."','".addslashes($modules[0]['config_lable'])."','".$modules[0]['print_model']."')";
            
            $sta = \Yii::$app->getDb()->createCommand($sql)->execute();
            if ($sta){
                $id = \yii::$app->getDb()->getLastInsertID();
            }
        }
        AdminLog::admin_log(addslashes(\yii::t($code, $modules[0]['code'])), 'install','shipping');
        $this->redirect('/shipping/list');
    }
    
    /*
     *  卸载配送方式
     */
    public function actionUninstall(){
        $code = \yii::$app->request->get('code');
        $model = new Shipping();
        $model->uninstall($code);
        $this->redirect('/shipping/list');
    }
    
    /*
     * 编辑模板
     */
    public function actionEditPrintTemplate() {
        $shipping_id = \yii::$app->request->get('shipping',0);
        /* 检查该插件是否已经安装 */
        $model = new Shipping();
        $row = $model->find()->where("id=:sid",[':sid'=>$shipping_id])->one()->attributes;
        if ($row){
            include_once(\Yii::getAlias('@ext').'/shipping/'.$row['shipping_code'].'.php');
            $row['shipping_print'] = !empty($row['shipping_print']) ? $row['shipping_print']: '';
            $row['print_model'] = empty($row['print_model'])?1:$row['print_model'];
        }
        else{
            $this->redirect('/shipping/list');
        }
        return $this->render('editmplate',['shipping'=>$row,'shipping_id'=>$shipping_id]);
    }
    
    /*
     * 模板Flash编辑器
     */
    public function actionPrintIndex(){
        $shipping_id = \yii::$app->request->get('shipping',0);
        //检查是否安装
        $model = new Shipping();
        $row = $model->find()->where("id=:sid",[':sid'=>$shipping_id])->one()->attributes;
        if ($row){
            include_once(\Yii::getAlias('@ext').'/shipping/'.$row['shipping_code'].'.php');
            $row['shipping_print'] = !empty($row['shipping_print']) ? $row['shipping_print']: '';
            $row['print_bg'] = empty($row['print_bg'])?'':\Yii::$app->request->hostInfo.$row['print_bg'];
        }
        return $this->renderPartial('print_index',['shipping_id'=>$shipping_id,'shipping'=>$row]);
    }
    
    /*
     * 编辑打印模板
     */
    public function actionDoEditPrintTemplate() {
        $print_model = \yii::$app->request->post('print_model',0);
        $shipping_id = \Yii::$app->request->post('shipping',0);
        $config_lable = \Yii::$app->request->post('config_lable');
        $shipping_print = \Yii::$app->request->post('shipping_print','');
        if ($print_model == 2){
            //所见所得模式
            $sql = "UPDATE ".Shipping::tableName()." SET config_lable='{$config_lable}',print_model='{$print_model}' WHERE id={$shipping_id}";
            \yii::$app->getDb()->createCommand($sql)->execute();
        }elseif ($print_model == 1){
            //代码模式
            $template = $shipping_print;
            $sql = "UPDATE ".Shipping::tableName()." SET shipping_print='{$template}',print_model='{$print_model}' WHERE id={$shipping_id}";
            \Yii::$app->getDb()->createCommand($sql)->execute();
        }
        AdminLog::admin_log(addslashes($_POST['shipping_name']), 'edit','shipping');
        $this->redirect('/shipping/list');
    }
    
    /*
     * 模板Flash编辑器 删除图片
     */
    public function actionPrintDel() {
        $shipping_id = (int)\yii::$app->request->get('shipping',0);
        $sql = "SELECT print_bg FROM ".Shipping::tableName()." WHERE id={$shipping_id}";
        $row = \yii::$app->getDb()->createCommand($sql)->queryOne();
        
        if ($row){
            if ($row['print_bg'] != '' && !UtilD::is_print_bg_default($row['print_bg'])){
                @unlink(\yii::getAlias('@web').$row['print_bg']);
            }
            \yii::$app->getDb()->createCommand("UPDATE ".Shipping::tableName()." SET print_bg='' WHERE id={$shipping_id}")->execute();
        }
        else{
            exit(Json::encode(['error'=>1,'message'=>\Yii::t('shipping', ['js_languages'=>'upload_del_falid'])]));
        }
        exit(Json::encode(['error'=>0,'message'=>'','content'=>$shipping_id]));
    }
    
    /*
     * 模板Flash编辑器 上传图片
     */
    public function actionPrintUpload(){
        $allow_suffix = ['jpg','png','jpeg'];
        $shipping_id = \yii::$app->request->post('shipping',0);
        $src = '';
        if (!empty($_FILES['bg']['name'])){
            if (!in_array(UtilD::getFileSuffix($_FILES['bg']['name']),$allow_suffix)){
                UtilD::toJavaScriptAlert(sprintf(\yii::t('shipping', 'js_languages_upload_falid'),implode(',', $allow_suffix)));
                \yii::$app->end();
            }
        
            $name = date('Ymd');
            for ($i=0;$i<6;$i++){
                $name .= chr(mt_rand(97, 122));
            }
            $name .= '.'.end(explode('.', $_FILES['bg']['name']));
            $target = \yii::getAlias('@webroot').'/images/receipt/'.$name;
            if (move_uploaded_file($_FILES['bg']['tmp_name'], $target)){
                $src = '/images/receipt/'.$name;
            }
        }
        if (!empty($src)){
            $sql = "UPDATE ".Shipping::tableName()." SET print_bg = '{$src}' WHERE id = {$shipping_id}";
            if (\Yii::$app->getDb()->createCommand($sql)->execute()){
                echo '<script language="javascript">';
                echo 'parent.call_flash("bg_add", "' . \Yii::$app->request->getHostInfo() . $src . '");';
                echo '</script>';
            }
        }
    }
    
    /*
     * 恢复默认
     */
    public function actionRecoveryDefaultTemplate(){
        $shipping_id = \yii::$app->request->post('shipping',0);
        $sql = "SELECT shipping_code FROM ".Shipping::tableName()." WHERE id={$shipping_id}";
        $code = \yii::$app->getDb()->createCommand($sql)->queryScalar();
        
        
        $set_modules = true;
        include_once(\yii::getAlias('@ext').'/shipping/'.$code.'.php');
        
        $sql = "UPDATE ".Shipping::tableName()." SET print_bg='".addslashes($modules[0]['print_bg'])."',config_lable='".addslashes($modules[0]['config_lable'])."' WHERE shipping_code='{$code}' LIMIT 1";
        \yii::$app->getDb()->createCommand($sql)->execute();
        
        $this->redirect(['/shipping/edit-print-template','shipping'=>$shipping_id]);
    }
    
    
    
    
    
    
}

?>