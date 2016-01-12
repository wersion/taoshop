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
        
        var_dump($model->login());exit;
        if ($model->login()){
            return $this->goHome();
        }
        else{
            return $this->redirect(['/admin/login']);
        }
    }
    
    
    public function actionLogout(){
        \Yii::$app->user->logout(true);
        return $this->goHome();
    }
    
    
    public function actionCleancache(){
        \yii::$app->cache->gc(true,false);
        return $this->goHome();
    }
    
    public function actionResetpwd() {
        exit('正在疯狂施工中...');
    }
}
