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
     * 返回全路由
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
    
    /**
     * 加载系统信息页面
     * @param string $msg_detail 消息内容
     * @param integer $msg_type  消息类型， 0消息，1错误，2询问
     * @param array $links       可选的链接
     * @param bool $auto_redirect 是否需要自动跳转
     */
    public function system_msg($msg_detail,$msg_type=0,$links=[],$auto_redirect = true){
        if (!count($links)){
            $links[0]['text'] = \Yii::t('common', 'go_back');
            $links[0]['href'] = 'javascript:self.history.go(-1)';
        }
        echo $this->render('@backend/views/system/message',[
            'msg_detail'=>$msg_detail,
            'msg_type' => $msg_type,
            'links'    => $links,
            'default_url'=>$links[0]['href'],
            'auto_redirect' =>$auto_redirect
        ]);
        \Yii::$app->end();
    }
}
