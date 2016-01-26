<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use yii;
use common\component\BackendBaseController;
use backend\models\LoginForm;
use yii\web\View;
use yii\helpers\Json;
use common\component\UtilD;
/**
 * Description of AdminController
 *
 * @author tao
 */
class AdminController extends BackendBaseController {
    public $layout = 'login';
    
    
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'height'=> 40,
                'width'=> 80,
            ],
            'error'=>[
                'class'=>'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionLogin(){
        if (!\Yii::$app->user->isGuest){
            return $this->goHome();
        }
        
        $this->getView()->title = "taoShop商城管理系统";
       return $this->render('login');
    }
    
    
    public function actionPost(){
        if (!\Yii::$app->request->getIsPost()){
            throw new yii\base\InvalidCallException("无效请求");
        }
        $model = new LoginForm();
        $model->username = $_POST['username'];
        $model->password = $_POST['password'];
        $model->rememberMe = isset($_POST['rememberMe']) && $_POST['rememberMe']=='on'? true: false;
        $model->verifyCode = $_POST['verifyCode'];
        
        if ($model->login()){
            exit(UtilD::handleResult(true, '登陆成功'));
        }
        else{
            exit(UtilD::handleResult(false,'登陆失败，账号或密码错误'));
        }
    }
    
    
    public function actionLogout(){
        \Yii::$app->user->logout(true);
        return $this->redirect(['/admin/login']);
    }
    
    
    public function actionCleancache(){
        \yii::$app->cache->gc(true,false);
        return $this->goHome();
    }
    
    public function actionResetpwd() {
        exit('正在疯狂施工中...');
    }
}
