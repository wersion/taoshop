<?php
namespace common\component;

/**
 * backend of BackendBaseController
 *
 * @author tao
 */
class BackendBaseController extends BaseController{
    
    public function init() {
        parent::init();
    }
    
    public function behaviors() {
        return [
            'access'=>[
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login','register','error'],
                        'allow' => true,
                    ],
                    [
                      'actions' => ['*'],
                       'allow'  => true,
                       'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
