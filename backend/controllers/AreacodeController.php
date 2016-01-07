<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\helpers\Json;
use common\models\Area;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AreaCodeController
 *
 * @author tao
 */
class AreacodeController extends BackendBaseController{
    
    public function init() {
        parent::init();
    }

    /**
     * base code depth get areaCode
     */
    public function actionGet_areacode(){
        $areaCode = \yii::$app->request->get('area_code',101);
        $depth  = \yii::$app->request->get('dep',2);
       /* $data = [
            ['area_code'=>'101101','area_name'=>'beijing'],
            ['area_code'=>'101102','area_name'=>'shanghai'],
            ['area_code'=>'101103','area_name'=>'guangzhou'],
            ['area_code'=>'101104','area_name'=>'shengzhen']
        ];*/
        $model = new Area();
        $data = $model->FindAreaByCode($areaCode,$depth);
        exit(Json::encode($data));
    }
    
    
    public function actionGet_areacode_all(){
        $model = new Area();
        $data = $model->FindAreaAll();
        exec(json_encode($data));
    }
}
