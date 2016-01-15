<?php
namespace common\widgets\area;

use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Json;
/**
 * Description of AreaLinkage
 *
 * @author tao
 */
class AreaLinkage extends Widget{
    
    //请求方式:frontend|backend区分请求接口
    public $type;
    
    //层级深度  2省 3市 4区县 default  区县
    public $depth = 4;
    
    //初始值 101 中国
    public $selectAreaCode = '101';
    
    //前缀
    public $prefix = 'default_';
    
    public $name = '';
    
    //获取地区接口
    private $url='';
    
    public $defaultOption = [];
    


    public function init() {
        parent::init();
        if(empty($this->type) || !in_array($this->type, ['frontend','backend'])){
            throw new \yii\base\InvalidConfigException;
        }
        if ('backend' == $this->type){
            $this->url = '/areacode/get-areacode';
        }
    }
    
    public function run(){
        $this->registerClientScript();
        return $this->render('@common/widgets/area/views/arealinkage',[
            'depth'=>  $this->depth,
            'url'=>  $this->url,
            'prefix' => $this->prefix,
            'selectAreaCode' =>  $this->selectAreaCode,
            'name'=>  $this->name
             ]);
    }
    
    
    protected function registerClientScript(){
        $view = $this->getView();
       AreaLinkageAsset::register($view);
    }
}
