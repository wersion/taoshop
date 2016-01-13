<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style>
.text{
	height:25px;
	padding-left:2px
}
</style>
<div class="easyui-panel" title="编辑支付信息" type="width:600px">
    <div style="padding: 10px 0 10px 60px;margin:10px auto">
            <table>
            <form id="payment" method="post">
                <tr>
                    <td class="label"><?=Yii::t('app', 'payment_name')?></td>
                    <td><input class="easyui-validatebox text" name="pay_name" type="text" value="<?=Html::encode($pay['pay_name'])?>" data-options="required:true"/></td>
                </tr>
                <tr>
                    <td class="label"><?=Yii::t('app', 'payment_desc')?></td>
                    <td><?=Html::textarea('pay_desc',Html::decode($pay['pay_desc']),['cols'=>60,'rows'=>8])?></td>
                </tr>
                <?php foreach ($pay['pay_config'] as $key=>$config):?>
                <tr>
                    <td class="label"><?=$config['label']?></td>
                    <td>
                        <?php if ($config['type'] == "text"):?>
                            <?=Html::input($config['type'],'cfg_value[]',$config['value'],['size'=>40])?>
                        <?php elseif ($config['type'] == 'textarea'):?>
                            <?=Html::textarea('cfg_value[]',$config['value'],['cols'=>80,'rows'=>5])?>
                        <?php elseif ($config['type'] == 'select'):?>
                            <?=Html::listBox("cfg_value[]",$config['value'],$config['range'],['width'=>200]) ?>
                        <?php endif;?>
                        <?=Html::hiddenInput('cfg_name[]',$config['name'])?>
                        <?=Html::hiddenInput('cfg_type[]',$config['type'])?>
                        <?=Html::hiddenInput('cfg_lang[]',isset($config['lang'])?$config['lang']:'')?>
                    </td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td class="label"><?=Yii::t('app', 'pay_fee')?></td>
                    <td>
                        <?php if (isset($pay['is_cod']) && $pay['is_cod']):?>
                            <?=Html::hiddenInput('pay_fee',$pay['pay_fee']?$pay['pay_fee']:0) ?><?=Yii::t('app', 'decide_by_ship') ?>
                        <?php else:?>
                            <?=Html::input('text','pay_fee',$pay['pay_fee']?$pay['pay_fee']:0) ?>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?=Yii::t('app', 'payment_is_cod')?></td>
                    <td><?php if ($pay['is_cod']):?><?=Yii::t('app', 'yes')?><?php else:?><?=Yii::t('app', 'no')?><?php endif;?></td>
                </tr>
                <tr>
                    <td class="label"><?=Yii::t('app', 'payment_is_online')?></td>
                    <td><?php if ($pay['is_online']):?><?=Yii::t('app', 'yes')?><?php else:?><?=Yii::t('app', 'no')?><?php endif;?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <?=Html::hiddenInput("pay_id",isset($pay['pay_id'])?$pay['pay_id']:0)?>
                        <?=Html::hiddenInput("pay_code",$pay['pay_code'])?>
                        <?=Html::hiddenInput("is_cod",$pay['is_cod']) ?>
                        <?=Html::hiddenInput("is_online",$pay['is_online']) ?>
                        <div style="text-align:left;padding:5px;line-height:50px">
                	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-save'">&nbsp;&nbsp;提交&nbsp;&nbsp; </a>
                	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" data-options="iconCls:'icon-undo'"> &nbsp;&nbsp;重设 &nbsp;&nbsp;</a>
                        </div>
                    </td>
                </tr>
                </form>
            </table>
    </div>
</div>
<script type="text/javascript">
function submitForm(){
	$('#payment').form('submit',{
		url: '<?= Url::to('/payment/edit-post')?>',  
		onSubmit: function(){
			if(!$(this).form('validate')) {
				return false;
			};
            return true;
		},  
		success: function(result){  
			var result = eval('('+result+')');  
			if (result.key){  
				$.messager.show({
				    title:'成功提示',
				    msg:result.keyMain
					});
			} else {  
				$.messager.show({  
					title: '错误提示',  
					msg: result.keyMain
				});
			}  
		} 
	});
}
function clearForm(){
	$('#payment').form('clear');
}

</script>