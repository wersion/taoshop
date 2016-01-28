<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\filters\VerbFilter;
use common\models\FriendLink;
use yii\helpers\Json;
use yii;
use common\component\ImageD;
use common\models\AdminLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use common\component\UtilD;

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
                    'add' => ['GET'],
                    'insert' => ['POST'],
                    'edit' => ['GET'],
                    'delete-link'=> ['GET'],
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
        $pageSize = (int)\Yii::$app->request->get('rows',20);
        $result = (new FriendLink())->getDataByPage($page, $pageSize);
        exit(Json::encode($result));
    }
    
    public function actionAdd(){
        return $this->render('friend_info',['action'=>'add','form_act'=>'insert']);
    }
    
    public function actionInsert() {
        $show_order = \Yii::$app->request->post('show_order',0);
        $link_logo = '';
        $link_name = \Yii::$app->request->post('link_name','');
        $url_logo  = \Yii::$app->request->post('url_logo','');
        $link_url  = \Yii::$app->request->post('link_url','');
        
        
        $model = new FriendLink(); 
        if ($model->is_repead($link_name,'link_name')){
            $this->system_msg('名称'.\yii::t('app', 'is_repead'));
            \yii::$app->end();
        }
        
        //处理上传的LOGO图片
        if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) 
            || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) 
                && $_FILES['link_img']['tmp_name'] != 'none')){
            $image = new ImageD();
            $img_up_info  = @basename($image->UploadImage($_FILES['link_img'],'afficheimg'));
            $link_logo = '/images/afficheimg/'.$img_up_info;
        }
        if (!empty($url_logo)){
            if (strpos($url_logo, 'http://') === false && strpos($url_logo, 'https://') === false){
                $link_logo = 'http://'.trim($url_logo);
            }
            else {
                $link_logo = trim($url_logo);
            }
        }
        
        if (strpos($link_url, 'http://') === false && strpos($link_url, 'https://') === false){
            $link_url = 'http://'.trim($link_url);
        }
        else{
            $link_url = trim($link_url);
        }
        
        $status = FriendLink::addRowFriendLink(['link_name'=>$link_name,'link_url'=>$link_url,'link_logo'=>$link_logo,'show_order'=>$show_order]);
        
        if ($status){
            AdminLog::admin_log($link_name, 'add','friendlink');
            $link =[
                ['text'=>\Yii::t('common', 'continue_add'),'href'=>Url::to('/friend-link/add')],
                ['text'=>\Yii::t('common', 'back_list'),'href'=>Url::to('/friend-link/list')]
            ];
            $this->system_msg(\Yii::t('common', 'add')."&nbsp;".Html::encode($link_name)." ".\Yii::t('common', 'attradd_succed'),0,$link);
        }
        else{
            $link[] = ['text'=>\Yii::t('common', 'go_back'),'href'=>'javascript:self.history.back(-1)'];
            $this->system_msg(\Yii::t('common', 'add_error'),0,$link);
        }
    }
    
    /*
     * 友情链接编辑页面 
     */
    public function actionEdit() {
        $id = (int)\Yii::$app->request->get('id');
        $link_info = FriendLink::find()
                    ->select(['id','link_name','link_url','link_logo','show_order'])
                    ->where('id='.$id)
                    ->one()->getAttributes();
        
        //标记是图片还是文字连接
        if (!empty($link_info['link_logo'])) {
            $type = 'img';
            $link_logo = $link_info['link_logo'];
        }
        else{
            $type = 'chara';
            $link_logo = '';
        }
        $link_info['link_name'] = StringHelper::truncate($link_info['link_name'], 250,'');
        
        return $this->render('friend_info',[
            'action'=>'edit',
            'form_act'=>'update',
            'type'=>$type,
            'link_logo'=>$link_logo,
            'arrLink'=>$link_info
        ]);
    }
    
    /*
     * 保存修改
     */
    public function actionUpdate() {
        $id = (int)\yii::$app->request->post('id',0);
        $show_order = (int)\Yii::$app->request->post('show_order',0);
        $link_name = Html::decode(trim(\yii::$app->request->post('link_name','')));
        $url_logo = \Yii::$app->request->post('url_logo','');
        $link_url = \Yii::$app->request->post('link_url','');
        
        if ((isset($_FILES['link_img']['error']) && $_FILES['link_img']['error'] == 0) ||
            (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && $_FILES['link_img']['tmp_name'] != 'none')){
            $image = new ImageD();
            $img_up_info = @basename($image->UploadImage($_FILES['link_img'],'afficheimg'));
            $link_logo = "/images/afficheimg/".$img_up_info;
        }
        elseif (!empty($url_logo)){
            $link_logo = $url_logo;
        }
        else{
            $link_logo = "";
        }
        //如果有新上传的图片，删除原来的图片
        if (!empty($img_up_info))
        {
            $old_logo = FriendLink::find()->select(['link_logo'])->where('id='.$id)->column();
            if ((strpos($old_logo, 'http://') === false) && (strpos($old_logo, 'https://') === false)){
                $image_name  = basename($old_logo);
                @unlink(\Yii::getAlias('static').'/images/afficheimg/'.$image_name);
            }
        }
        
        /* 如果没有http:// 补上 */
        if (strpos($link_url, 'http://') === false && strpos($link_url, 'https://') === false){
            $link_url = 'http://'.trim($link_url);
        }
        else{
            $link_url = trim($link_url);
        }
        
        $status = FriendLink::modRowFriendLink($id,['link_name'=>$link_name,'link_url'=>$link_url,'link_logo'=>$link_logo,'show_order'=>$show_order]);
        if ($status){
            AdminLog::admin_log($link_name, 'edit','friendlink');
        }
        $link[] = ['text'=>\Yii::t('common', 'back_list'),'href'=>Url::to('/friend-link/list')];
        $this->system_msg(\yii::t('common', 'edit')."&nbsp;".Html::encode($link_name)."&nbsp;".\Yii::t('common', 'attradd_succed'),0,$link);
    }
    
    /*
     * 删除一条链接
     */
    public function actionDeleteLink() {
        $id = (int)\Yii::$app->request->get('id',0);
        if (!$id){
            exit(UtilD::handleResult(false, '非法提交'));
        }
        $model = FriendLink::find()->where('id='.$id)->one();
        
        if ((strpos($model['link_logo'], 'http://') === false) && (strpos($model['link_logo'], 'https://') === false))
        {
            $img_name = basename($model['link_logo']);
            @unlink(\Yii::getAlias('static').'/images/afficheimg/'.$img_name);
        }
        
        $model->delete();
        AdminLog::admin_log('', 'remove','friendlink');
        exit(UtilD::handleResult(true, '删除成功'));
    }
}

?>