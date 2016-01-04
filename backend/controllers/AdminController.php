<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;

use yii;
use common\component\BackendBaseController;
/**
 * Description of AdminController
 *
 * @author tao
 */
class AdminController extends BackendBaseController {
    public $layout = false;
    
    
    public function actionLogin(){
       return $this->render('login');
    }
}
