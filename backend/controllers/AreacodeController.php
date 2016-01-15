<?php
namespace backend\controllers;

use common\component\BackendBaseController;
use yii\helpers\Json;
use common\models\Area;
use yii\filters\VerbFilter;
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
 
    public function behaviors()
    {
        return [
            'verbs'=>[
                'class' => VerbFilter::className(),
                'actions' => [
                    'get-areacode' => ['GET'],
                    'get-region'=> ['GET'],
                    ]
                ]
            ];
    }
    /**
     * base code depth get areaCode
     */
    public function actionGetAreacode(){
        $areaCode = \yii::$app->request->get('area_code',101);
        $depth  = \yii::$app->request->get('dep',2);
        $model = new Area();
        $data = $model->FindAreaByCode($areaCode,$depth);
        exit(Json::encode($data));
    }
    
    /*
     * 基于层级获取地区
     */
    public function actionGetRegion(){
        $areaCode = \yii::$app->request->get('area_code');
        $depth  = \yii::$app->request->get('dep');
        $data = [];
        if (!empty($areaCode) && !empty($depth)){
            $model = new Area();
            $data = $model->FindAreaByCode($areaCode,$depth);
        }
        $arr['regions'] = $data;
        $arr['type']    = $depth;
        $arr['target']  = !empty($_REQUEST['target']) ? stripslashes(trim($_REQUEST['target'])) : '';
        $arr['target']  = htmlspecialchars($arr['target']);
        
        exit(Json::encode($arr));
    }
    
}
