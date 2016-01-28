<?php 

use yii\helpers\Html;
use yii\helpers\Url;
?>
<style type="text/css">
.label{
	width:150px;
	text-align:right;
	font-size:14px;
}
td .notice{
	color:#B5B5B5
}
</style>
<div class="main-layout">
    <form id="navigator-fm" method="post">
    <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
    <table cellspacing="1" cellpadding="3" style="margin:10px auto;width:60%">
        <tr>
            <td class="label"><?=Yii::t('navigator', 'system_main')?>:</td>
            <td align="left">
                <select name="menulist" id="menulist" style="width:200px" onChange="add_main(this.value)">
                    <option value="-">-</option>
                    <?php foreach ($sysmain as $key=>$val):?>
                        <option value="<?=$key?>"><?= isset($val[2])?$val[2]:$val[0]?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_name')?>:</td>
            <td align="left">
                <?=Html::input('text','item_name',isset($rt['item_name'])?$rt['item_name']:'',['id'=>'item_name','onKeyPress'=>"javascript:key()",'class'=>'easyui-validatebox','style'=>'width:200px;','data-options'=>'required:true'])?>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_url')?>:</td>
            <td>
                <?=Html::input('text','item_url',isset($rt['item_url'])?$rt['item_url']:'',['id'=>'item_url','onKeyPress'=>'javascript:key();','class'=>'easyui-validatebox','style'=>'width:200px;','data-options'=>"required:true"])?>
                <br>
                <span class="notice"><?=Yii::t('navigator', 'notice_url')?></span>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_vieworder') ?>:</td>
            <td>    
                <?=Html::input('text','item_vieworder',isset($rt['item_vieworder'])?$rt['item_vieworder']:'',['class'=>'easyui-textbox','style'=>'width:50px;'])?>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_ifshow')?>:</td>
            <td>
                <?=Html::dropDownList('item_ifshow',isset($rt['item_ifshow'])?$rt['item_ifshow']:null,[Yii::t('app', 'no'),Yii::t('app', 'yes')],['class'=>'easyui-combobox','style'=>'width:50px;','data-options'=>'editable:false'])?>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_opennew')?>:</td>
            <td>
                <?=Html::dropDownList('item_opennew',isset($rt['item_opennew'])?$rt['item_opennew']:null,[Yii::t('app', 'no'),Yii::t('app', 'yes')],['class'=>'easyui-combobox','style'=>'width:50px;','data-options'=>'editable:false'])?>
            </td>
        </tr>
        <tr>
            <td class="label"><?=Yii::t('navigator', 'item_type')?>:</td>
            <td>
                <?=Html::dropDownList('item_type',isset($rt['item_type'])?$rt['item_type']:null,[
                    'top'=>Yii::t('app', 'top'),
                    'middle' =>Yii::t('app', 'middle'),
                    'bottom' => Yii::t('app', 'bottom'),
                ],['class'=>'easyui-combobox','style'=>'width:100px;','data-options'=>'editable:false'])?>
            </td>
        </tr>
        <tr style="height: 50px;">
            <td>&nbsp;
                <input type="hidden" name="id" value="<?=isset($rt['id'])?$rt['id']:''?>" />
            </td>
            <td>
            <div style="text-align:left;padding:5px;line-height:50px">
                	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-save'">&nbsp;&nbsp;<?=Yii::t('app', 'button_submit')?>&nbsp;&nbsp; </a>
                	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" data-options="iconCls:'icon-undo'"> &nbsp;&nbsp;<?=Yii::t('app', 'button_reset')?> &nbsp;&nbsp;</a>
                </div>
            </td>
        </tr>
    </table>
    
    </form>
</div>
<script type="text/javascript">
var last;

function add_main(key){
	var sysm = new Object;
	<?php foreach ($sysmain as $key=>$val):?>
    sysm[<?=$key?>] = Array();
    sysm[<?=$key?>][0] = '<?=$val[0]?>';
    sysm[<?=$key?>][1] = '<?=$val[1]?>';
	<?php endforeach;?>
	if (key != '-'){
	    if (sysm[key][0] != '-'){
	    	$('#item_name').val(sysm[key][0]);
	    	$('#item_url').val(sysm[key][1]);
	        last = $("#menulist").val();
	    }
	    else{
		    var v = $("#menulist").val();
	        if (last < v){
	        	$("#menulist").val(v++);
	        }
	        else{
	        	$("#menulist").val(v--);
	        }
	        last = $("#menulist").val();
	        $('#item_name').val(sysm[last-1][0]);
	    	$('#item_url').val(sysm[last-1][1]);
	    }
	}
	else
	{
	    last = $("#menulist").val(1);
	    $('#item_name').val(sysm[last-1][0]);
    	$('#item_url').val(sysm[last-1][1]);
	}
}
function key(){
	last = $("#menulist").val();
}
function submitForm(){
	$('#navigator-fm').form('submit',{
		url: '<?= Url::to('/navigator/add-post')?>',  
		onSubmit: function(){
			if(!$(this).form('validate')) {
				return false;
			};
            return true;
		},  
		success: function(result){  
			var result = eval('('+result+')');  
			if (result.key){  
				window.self.location = '<?=Url::to('/navigator/list')?>';
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
	$('#navigator-fm').form('clear');
}
</script>