<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\widgets\area;

use yii\web\AssetBundle;
/**
 * Description of AreaLinkageAsset
 *
 * @author tao
 */
class AreaLinkageAsset extends AssetBundle{
   
    public $sourcePath = '@common/widgets/area/views/assets';
    
    public $js = [
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
