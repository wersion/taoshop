<?php
namespace common\component;

use common\component\UtilD;
/**
 * backend of BackendBaseController
 *
 * @author tao
 */
class BackendBaseController extends BaseController{
    public $layout = 'content';
    
    public function init() {
        parent::init();
        $this->getView()->title = \Yii::$app->id;
        $this->Permission();
    }
    
    /**
     * 对访问的方法进行权限验证
     */
    protected function Permission(){
        $route = strtolower($this->getRouteAbsolute());
        if(\Yii::$app->user->isGuest){
            if (!in_array($route, \yii::$app->params['notNeedLogin'])){
                 //判断是否是ajax访问
                if (\Yii::$app->request->getIsAjax()){
                    exit(UtilD::toJson(false,'未登录，无操作权限'));
                }else{
                    return $this->redirect('/admin/login');
                }
            }
        }
    }
    
    
    /**
     * get full url
     */
    public function getRouteAbsolute(){
        $route = $this->getRoute();
        $actions = \yii::$app->request->getPathInfo();
        
        if(empty($actions)){
            $actions = \yii::$app->defaultRoute;
        }
        
        if(strlen($actions) < strlen($route)){
            $actions = $this->getModules()->defaultRoute;
        }
        if ($route === $this->getUniqueId()){
            if (strlen($actions) > strlen($route)){
                return $actions;
            }
            else{
                return $route .= '/'.$this->defaultAction;
            }
        }
        else{
            return $route;
        }
    }
}
