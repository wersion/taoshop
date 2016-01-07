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
class EditAreaLinkage extends Widget{
    
    //请求方式:frontend|backend区分请求接口
    public $type;
    
    //层级深度  2省 3市 4区县 default  区县
    public $depth = 4;
    
    //初始值 101 中国
    public $selectAreaCode;
    
    //前缀
    public $prefix = 'default_';
    
    //获取地区接口
    private $url='';
    
    public $defaultOption = [];
    


    public function init() {
        parent::init();
        $directCity = self::directCity();
        if(!(strlen($this->selectAreaCode) > 3)){
            throw new \yii\base\InvalidConfigException('配置参数错误');
        }
        if(empty($this->type) || !in_array($this->type, ['frontend','backend'])){
            throw new \yii\base\InvalidConfigException('配置参数错误');
        }
        if ('backend' == $this->type){
            $this->url = 'areacode/get_areacode';
        }
    }
    
    public function run(){
        $this->registerClientScript();
        return $this->render('@common/widgets/area/views/editarealinkage',[
            'depth'=>  $this->depth,
            'url'=>  $this->url,
            'prefix' => $this->prefix,
            'selectAreaCode' =>  $this->selectAreaCode
             ]);
    }
    
    
    protected function registerClientScript(){
        $view = $this->getView();
       AreaLinkageAsset::register($view);
    }
    
    /*
     * 直辖市
     */
    private static function directCity(){
        return [ '101101','101102','101103','101104','101132','101133','101134' ];
    }
}
