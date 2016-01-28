<?php
namespace backend\controllers;
use common\component\BackendBaseController;
use yii\helpers\Json;
use yii\helpers\Url;

class MenuController extends BackendBaseController
{
    public function actionGet() {
        $menu = [
            'menus'=>[
                [
                   'menuid' => '0',
                    'icon' => 'icon-sys',
                    'menuname'=>'系统设置',
                    'menus' =>[
                        [
                            'menuid' =>'001',
                            'menuname'=>'商城设置',
                            'icon' => 'icon-sys',
                            'url' => Url::to('/config/listedit')
                        ],
                        [
                            'menuid' =>'002',
                            'menuname'=>'支付方式',
                            'icon' => 'icon-sys',
                            'url' => Url::to('/payment/list')
                        ],
                        [
                            'menuid' =>'003',
                            'menuname'=>'配送方式',
                            'icon' => 'icon-sys',
                            'url' => Url::to('/shipping/list')
                        ],
                        [
                            'menuid' =>'004',
                            'menuname'=>'邮件服务器配置',
                            'icon' => 'icon-sys',
                            'url' => Url::to('/config/mail-settings')
                        ],
                        [
                        'menuid' =>'005',
                        'menuname'=>'友情连接',
                        'icon' => 'icon-sys',
                        'url' => Url::to('/friend-link/list')
                        ],
                        [
                        'menuid' =>'006',
                        'menuname'=>'自定义导航',
                        'icon' => 'icon-sys',
                        'url' => Url::to('/navigator/list')
                        ],
                    ] 
                ],
                [
                    'menuid'=>'1',
                    'icon'=>'icon-sys',
                    'menuname'=>'商品管理',
                    'menus'=>[
                        [
                            'menuid' => '101',
                            'menuname'=>'商品列表',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '102',
                            'menuname'=>'添加新商品',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '103',
                            'menuname'=>'商品分类',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '104',
                            'menuname'=>'用户评论',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '105',
                            'menuname'=>'商品品牌',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '106',
                            'menuname'=>'商品类型',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '107',
                            'menuname'=>'商品回收站',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '108',
                            'menuname'=>'商品批量修改',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '109',
                            'menuname'=>'生成商品代码',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '110',
                            'menuname'=>'标签管理',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '111',
                            'menuname'=>'虚拟商品列表',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '112',
                            'menuname'=>'添加虚拟商品',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '113',
                            'menuname'=>'商品自动上下架',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                    ]
               ],
               [
                    'menuid'=>'2',
                    'icon'=>'icon-sys',
                    'menuname'=>'促销管理',
                    'menus'=>[
                        [
                            'menuid' => '201',
                            'menuname'=>'红包类型',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '202',
                            'menuname'=>'商品包装',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '203',
                            'menuname'=>'祝福贺卡',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '204',
                            'menuname'=>'拍卖活动',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '205',
                            'menuname'=>'优惠活动',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '206',
                            'menuname'=>'批发管理',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '207',
                            'menuname'=>'超值礼包',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                    ],
                ],
                
                [
                    'menuid'=>'3',
                    'icon'=>'icon-sys',
                    'menuname'=>'订单管理',
                    'menus'=>[
                        [
                            'menuid' => '301',
                            'menuname'=>'订单列表',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '302',
                            'menuname'=>'订单查询',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '303',
                            'menuname'=>'合并订单',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '304',
                            'menuname'=>'订单打印',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '305',
                            'menuname'=>'缺货登记',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '306',
                            'menuname'=>'添加订单',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '307',
                            'menuname'=>'发货单列表',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                        [
                            'menuid' => '308',
                            'menuname'=>'退货单列表',
                            'icon'    => 'icon-sys',
                            'url'     => Url::to('menu/index'),
                        ],
                    ],
               ]
                
            ],
        ];
        echo Json::encode($menu);
    }
}

?>