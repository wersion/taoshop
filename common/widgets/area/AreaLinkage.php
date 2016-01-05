<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\widgets\area;

use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Description of AreaLinkage
 *
 * @author tao
 */
class AreaLinkage extends Widget{
    
    public $areaData = '';
    
    public $name = 'area_code';
    
    public $options = [];
    
    private $html='';


    public function init() {
        parent::init();
    }
    
    public function run(){
        $this->html.= '<div class="selectList">';
        $this->html.= Html::dropDownList($this->name, '101', $this->areaData, $this->options[0]);
        $this->html.= Html::dropDownList($this->name, '101101', $this->areaData, $this->options[1]);
        $this->html.= Html::dropDownList($this->name, '101102103', $this->areaData, $this->options[2]);
        $this->html .= '</div>';
        //echo Html::dropDownList($this->name,null,  $this->areaData,  $this->options);
        echo $this->html;
    }
}
