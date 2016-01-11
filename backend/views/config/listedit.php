<?php
use yii\helpers\Url;
use yii\helpers\Html;
$this->params['breadcrumbs'][] = '商店设置';
$area_json = ['101'=>'beijing','102'=>'gz','103'=>'sz'];
?>
<?php echo $this->render('//layouts/_breadcrumbs');?>

    <!-- /section:basics/content.breadcrumbs -->
    <div class="page-content">
            <!-- #section:settings.box -->
            
            <?php echo $this->render('//layouts/_settingsbox');?>
            <!-- /section:settings.box -->
            <div class="page-header">
                    <h1>
                            商店设置
                            <small>
                                    <i class="ace-icon fa fa-angle-double-right"></i>
                                    商城基本参数设置
                            </small>
                    </h1>
            </div><!-- /.page-header -->

            <div class="row">
                    <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="tabbable">
                                    <!-- #section:pages/faq -->
                                    <ul class="nav nav-tabs padding-18 tab-size-bigger" id="myTab">
                                            <li class="active">
                                                    <a data-toggle="tab" href="#faq-tab-1">
                                                            <i class="blue ace-icon fa fa-info-circle bigger-120"></i>
                                                            网店信息
                                                    </a>
                                            </li>

                                            <li>
                                                    <a data-toggle="tab" href="#faq-tab-2">
                                                            <i class="green ace-icon fa fa-crosshairs bigger-120"></i>
                                                            基本设置
                                                    </a>
                                            </li>

                                            <li>
                                                    <a data-toggle="tab" href="#faq-tab-3">
                                                            <i class="orange ace-icon fa fa-plus bigger-120"></i>
                                                            显示设置
                                                    </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#faq-tab-4">
                                                    <i class="light-blue ace-icon fa fa-stack-overflow bigger-120"></i>
                                                            购物流程
                                                </a>
                                            </li>
                                             <li>
                                                <a data-toggle="tab" href="#faq-tab-5">
                                                    <i class="light-red ace-icon fa fa-flickr bigger-120"></i>
                                                            商品显示设置
                                                </a>
                                            </li>
                                    </ul>

                                    <!-- /section:pages/faq -->
                                    <div class="tab-content no-border padding-24">
                                       
                                        <?php foreach ($group_list as $key=>$group):?>
                                        <div id="faq-tab-<?=$key?>" class="tab-pane fade<?php if ($key== 1):?> in active <?php endif;?>">
                                            <form class="form-horizontal"  enctype="multipart/form-data" method="post" action="<?=  Url::to('/config/post')?>">
                                                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
                                                 <div class="space-8"></div>
                                                 <div id="faq-list-<?=$key?>" class="panel-group accordion-style1 accordion-style2">
                                                     <?php if (isset($group['vars'])):?>
                                                        <?php foreach ($group['vars'] as $k=>$var):?>
                                                     <div class="form-group">
                                                         <label class="col-sm-3 control-label no-padding-right" for="<?=$var['code']?>"> <?=$var['name']?>:</label>
                                                         <div class="col-sm-3">
                                                             <!-- -->
                                                             <?php if ($var['type'] == 'text'):?>
                                                                <input type="text" id="<?=$var['code']?>" placeholder="<?=$var['notice']?>" value="<?=$var['value']?>" name="value[<?=$var['id']?>]" class="col-xs-10 col-sm-5" />
                                                             <?php elseif($var['type'] == 'textarea'):?>
                                                                <textarea class="form-control" id="<?=$var['code']?>" placeholder="<?=$var['notice']?>" value="<?=$var['value']?>" name="value[<?=$var['id']?>]"></textarea>
                                                             <?php elseif ($var['type'] == 'password'):?>
                                                                <input type="password" id="<?=$var['code']?>" placeholder="<?=$var['notice']?>" class="col-xs-10 col-sm-5" value="<?=$var['value']?>" name="value[<?=$var['id']?>]"/>
                                                             <?php elseif($var['type'] == 'select'): ?>   
                                                                <div class="radio">
                                                                    <?php foreach ($var['store_options'] as $sk=>$opt):?>
                                                                    <label>
                                                                            <input name="value[<?=$var['id']?>]" type="radio" class="ace" value="<?=$opt?>" <?php if ($var['value'] == $opt):?>checked="true"<?php endif;?>/>
                                                                            <span class="lbl"> <?=$var['display_options'][$sk]?> </span>
                                                                    </label>
                                                                    <?php endforeach;?>
								</div>
                                                             <?php elseif ($var['type'] == 'options'):?>
                                                                <select class="form-control" id="<?=$var['code']?>" name="value[<?=$var['id']?>]">
									<?php foreach ($var['store_options'] as $sk=>$opt):?>
                                                                    <option value="<?=$opt?>" <?php if($var['value'] == $opt):?>selected="selected"<?php endif;?>><?=$var['display_options'][$sk]?></option>
                                                                        <?php endforeach;?>
								</select>
                                                                
                                                             <?php elseif ($var['type'] == 'file'):?>
                                                                <input type="file" id="<?=$var['code']?>" name="<?=$var['code']?>" value=""/>
                                                                  <script type="text/javascript">
                                                                    jQuery(function($){
                                                                       $('#<?=$var['code']?>').ace_file_input({
                                                                          style:'well',
                                                                          no_file:'请选择图片',
                                                                          btn_choose:'选择',
                                                                          btn_change:'更换',
                                                                          droppable:false,
                                                                          onchange:null,
                                                                          thumbnail:true, //| true | large
                                                                          maxSize: 110000, //bytes
                                                                          allowExt:["jpeg","jpg","png","gif"],
                                                                          allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif"],
                                                                      });
                                                                    });

                                                                    </script>
                                                             <?php elseif ($var['type'] == 'city_code'):?>
                                                                  <?php echo common\widgets\area\AreaLinkage::widget([
											 'type'=>'backend',
											 'prefix'=>'shop_',
                                                                                         'name'=>'value['.$var['id'].']',
											 'selectAreaCode'=>!empty($var['value'])?$var['value']:'',
											 ]);?>
                                                              <?php elseif ($var['type'] == 'manual'):?>
                                                                    <?php if($var['code'] == 'invoice_type'):?>
                                                                    <?php $var['value'] = unserialize($var['value']);?>
                                                                    <table>
                                                                        <tr>
                                                                            <th scope="col"><?=  Yii::t('config', 'invoice_in_type')?></th>
                                                                          <th scope="col"><?=  Yii::t('config', 'invoice_in_rate')?></th>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                          <td><input name="invoice_type[]" type="text" value="<?= $var['value']['type'][0]?>" /></td>
                                                                          <td><input name="invoice_rate[]" type="text" value="<?= $var['value']['rate'][0]?>" /></td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                          <td><input name="invoice_type[]" type="text" value="<?= $var['value']['type'][1]?>" /></td>
                                                                          <td><input name="invoice_rate[]" type="text" value="<?= $var['value']['rate'][1]?>" /></td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td><input name="invoice_type[]" type="text" value="<?= $var['value']['type'][2]?>" /></td>
                                                                          <td><input name="invoice_rate[]" type="text" value="<?= $var['value']['rate'][2]?>" /></td>
                                                                        </tr>
                                                                     </table>
                                                                    
                                                                    <?php endif;?>
                                                             <?php endif;?>
                                                             <!-- -->
                                                         </div>
                                                     </div>
                                                        <?php endforeach;?>
                                                     <?php endif;?>
                                                 </div>
                                                 
                                                 <div class="clearfix form-actions">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button class="btn btn-info" type="submit">
                                                         <i class="ace-icon fa fa-check bigger-110"></i>
                                                         确定
                                                         </button>

                                                         &nbsp; &nbsp; &nbsp;
                                                         <button class="btn" type="reset">
                                                                 <i class="ace-icon fa fa-undo bigger-110"></i>
                                                                  重置 
                                                         </button>
                                                    </div>
                                                </div>
                                                 <div style="height:10px;width: 100%"></div>
                                            </form>
                                        </div>
                                        <?php endforeach;?>
                                        <!-- tab content -->
                                        
                                        <!-- tab content end-->
                                    </div>
                            </div>

                            <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
            </div><!-- /.row -->
    </div><!-- /.page-content -->
