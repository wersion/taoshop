<?php
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
                                            <div id="faq-tab-1" class="tab-pane fade in active">
                                                <div class="col-xs-12">
                                                    <form class="form-horizontal" role="form">
                                                            <div class="form-group">
                                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-select-1"> 所在省份:</label>
                                                                <div class="col-sm-1">
                                                                    <!--<select class="form-control col-xs-1 col-sm-1" id="form-field-select-1">
                                                                        <option value=""></option>
                                                                        <option value="2" >北京</option>
                                                                        <option value="3" >安徽</option>
                                                                        <option value="4" >福建</option>
                                                                        <option value="5" >甘肃</option>
                                                                        <option value="6" selected>广东</option>
                                                                        <option value="7" >广西</option>
                                                                    </select>-->
                                                                     <?php echo common\widgets\area\AreaLinkage::widget([
                                                                        'name'=>'area_pro',
                                                                        'areaData'=> $area_json,
                                                                        'options'=>[
                                                                            ['class'=>'form-control col-xs-1 col-sm-1 province','id'=>'province'],
                                                                            ['class'=>'form-control col-xs-1 col-sm-1 city','id'=>'city'],
                                                                            ['class'=>'form-control col-xs-1 col-sm-1 district','id'=>'district'],
                                                                         ],
                                                                    ]);?>
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="form-group">
                                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商店名称: </label>

                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="form-field-1" placeholder="商店名称" name="value[101]" class="col-xs-10 col-sm-5" />
                                                                    </div>
                                                            </div>
                                                         <div class="form-group">
                                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-2"> 商店标题: </label>

                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="form-field-2" placeholder="商店标题" name="value[101]" class="col-xs-10 col-sm-5" />
                                                                    </div>
                                                            </div>
                                                         <div class="form-group">
                                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-3"> 商店描述: </label>

                                                                    <div class="col-sm-5">
            
                                                                        <textarea class="form-control" id="form-field-3" placeholder="商店描述:"></textarea>
                                                                    </div>
                                                            </div>
                                                         <div class="form-group">
                                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 商店关键字: </label>

                                                                    <div class="col-sm-5">
                                                                        <input type="text" id="form-field-1" placeholder="商店名称" name="value[101]" class="col-xs-10 col-sm-5" />
                                                                    </div>
                                                            </div>
                                                    </form> 
                                                </div>
                                            </div>

                                            <div id="faq-tab-2" class="tab-pane fade">
                                                    2
                                            </div>

                                            <div id="faq-tab-3" class="tab-pane fade">
                                                   3
                                            </div>

                                            <div id="faq-tab-4" class="tab-pane fade">
                                                  4 
                                            </div>
                                            <div id="faq-tab-5" class="tab-pane fade">
                                                  5 
                                            </div>
                                           
                                       
                                    </div>
                            </div>

                            <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
            </div><!-- /.row -->
    </div><!-- /.page-content -->