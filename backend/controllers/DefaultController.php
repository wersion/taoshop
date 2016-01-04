<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace backend\controllers;
use common\component\BackendBaseController;
use yii\db\Query;
/**
 * Description of DefaultController
 *
 * @author tao
 */
class DefaultController extends BackendBaseController{
    public $layout = 'main';
    
    public function actionIndex(){
        return $this->render('index');
    }
}
