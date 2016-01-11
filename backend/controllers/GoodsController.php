<?php
/**
 * shop controller
 */
namespace backend\controllers;
use common\component\BackendBaseController;

/**
 * Description of GoodsController
 *
 * @author tao
 */
class GoodsController extends BackendBaseController{
    public $layout = '//content';
    /*
     * goods list
     */
    public function actionList(){
        return $this->render('list');
    }
}
