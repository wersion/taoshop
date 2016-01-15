<?php
use yii;
use yii\helpers\Url;
?>
<style type="text/css">
.label{
	text-align:right;
	width:250px;
}
.text{
	text-align:left;
	width:350px;
}
.inputext{
	height:25px;
}
</style>
<script type="text/javascript" src="/js/region.js"></script>
<div class="easyui-panel" style="height:600px;padding:5px;width:100%;">
<form method="post" action="shipping_area.php" name="theForm" id="theForm" onsubmit="return validate()" style="background:#FFF">
    <fieldset style="border:1px solid #DDEEF2">
        <div class="list-div" style="width:100%;text-align:center">
            <table id="general-table" align="center" width="600" cellpadding="3" cellspacing="1" border="0">
                <tr>
                    <td class="label"><?=Yii::t('shipping', 'shipping_area_name') ?>:</td>
                    <td class="text">
                        <input type="text" class="easyui-validatebox inputext" data-options="required:true,validType:'max[60]'" name="shipping_area_name" size="30" value="<?=isset($shipping_area['shipping_area_name'])?$shipping_area['shipping_area_name']:''?>" />
                        <?=Yii::t('app', 'require_field')?>
                    </td>
                </tr>
                <?php if (in_array($shipping_area['shipping_code'],['ems','yto','zto','sto_express','post_mail','sf_express','post_express'])):?>
                <tr>
                    <td class="label"><?=Yii::t('shipping', 'fee_compute_mode')?>:</td>
                    <td class="text">
                    <input type="radio"  <?php if (isset($fee_compute_mode) && $fee_compute_mode != 'by_number'):?>checked="true"<?php endif;?> onclick="compute_mode('<?=$shipping_area['shipping_code'] ?>','weight')" name="fee_compute_mode" value="by_weight" /><?=Yii::t('shipping', 'fee_by_weight')?>
                    <input type="radio" <?php if (isset($fee_compute_mode) && $fee_compute_mode == 'by_number'):?>checked="true"<?php endif;?>  onclick="compute_mode('<?=$shipping_area['shipping_code'] ?>','number')" name="fee_compute_mode" value="by_number" /><?=Yii::t('shipping', 'fee_by_number')?>
                    </td>
                </tr>
                <?php endif;?>
                <?php if ($shipping_area['shipping_code'] != 'cac'):?>
                    <?php foreach ($fields as $field):?>
                        <?php if (isset($fee_compute_mode) && $fee_compute_mode == 'by_number'):?>
                            <?php if (in_array($field['name'], ['item_fee','free_money','pay_fee'])):?>
                            <tr id="<?=$field['name']?>" >
                              <td class="label"><?=$field['label']?>:</td>
                              <td class="text"><input type="text" class="inputext" name="<?=$field['name']?>"  maxlength="60" size="20" value="<?=$field['value']?>" /> <?=Yii::t('app', 'require_field')?></td>
                            </tr>
                            <?php else:?>
                            <tr id="<?=$field['name']?>" style="display:none">
                              <td class="label"><?=$field['label']?>:</td>
                              <td class="text"><input type="text" class="inputext" name="<?=$field['name']?>"  maxlength="60" size="20" value="<?=$field['value']?>" /> <?=Yii::t('app', 'require_field')?></td>
                            </tr>
                            <?php endif;?>
                        <?php else:?>
                            <?php if ($field['name'] != 'item_fee'):?>
                                <tr id="<?=$field['name']?>">
                                  <td class="label"><?=$field['label']?>:</td>
                                  <td class="text"><input type="text" class="inputext" name="{$field.name}"  maxlength="60" size="20" value="<?=$field['value']?>" /><?=Yii::t('app', 'require_field')?></td>
                                </tr>
                            <?php else:?>
                                <tr id="<?=$field['name']?>" style="display:none">
                                  <td class="label"><?=$field['label']?>:</td>
                                  <td class="text"><input type="text" class="inputext" name="<?=$field['name']?>"  maxlength="60" size="20" value="<?=$field['value']?>" /><?=Yii::t('app', 'require_field')?></td>
                                </tr>
                           <?php endif;?>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            </table>
            
        </div>
    </fieldset>
    <p style="width: 100%;height:10px"></p>
    <div class="easyui-panel" title="<?=Yii::t('shipping', 'byArea')?>:">
        <div>
            <table style="width: 600px;" align="center">
                <tr>
                    <td id="regionCell" height="50">
                        <?php if (isset($resions)):?>
                            <?php foreach ($resions as $id=>$region):?>
                                <input type="checkbox" name="regions[]" value="<?=$id ?>" checked="true" /><?=$region?>&nbsp;&nbsp;
                            <?php endforeach;?>
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="vertical-align: top"><?=Yii::t('app', 'label_province')?>:</span>
                        <select name="province" id="selProvinces" onchange="region.changed(this,3,'selCities')" size="10" style="width: 80px">
                            <option value=''><?=Yii::t('app', 'select_please')?></option>
                        </select>
                         <span  style="vertical-align: top"><?=Yii::t('app', 'label_city')?></span>
                        <select name="city" id="selCities" onchange="region.changed(this, 4, 'selDistricts')" size="10" style="width:80px">
                          <option value=''><?=Yii::t('app', 'select_please')?></option>
                        </select>
                         <span  style="vertical-align: top"><?=Yii::t('app', 'label_district')?></span>
                        <select name="district" id="selDistricts" size="10" style="width:130px">
                          <option value=''><?=Yii::t('app', 'select_please')?></option>
                        </select>
                        <span  style="vertical-align: top"><input type="button" value="+" class="button" onclick="addRegion()" /></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
 <div style="width: 100%;height:50px">   
 <table style="margin: 30px auto 0">
  <tr>
    <td colspan="2" align="center">
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-save'">&nbsp;&nbsp;<?=Yii::t('app', 'button_submit')?>&nbsp;&nbsp; </a>
                	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" data-options="iconCls:'icon-undo'"> &nbsp;&nbsp;<?=Yii::t('app', 'button_reset')?> &nbsp;&nbsp;</a>
      <input type="hidden" name="act" value="{$form_action}" />
      <input type="hidden" name="id" value="{$shipping_area.shipping_area_id}" />
      <input type="hidden" name="shipping" value="{$shipping_area.shipping_id}" />
    </td>
  </tr>
</table>
</div>
</form>
</div>

<script type="text/javascript">
region.isAdmin = true;
onload = function()
{
	region.loadProvinces(101);
}

/*
 * 添加一个区域
 */
function addRegion()
{
	var selProvince = document.forms['theForm'].elements['province'];
	var selCity     = document.forms['theForm'].elements['city'];
	var selDistrict = document.forms['theForm'].elements['district'];
	var regionCell = document.getElementById("regionCell");
    
    if (selDistrict.selectedIndex > 0){
    	//如果选择区/县
        regionId = selDistrict.options[selDistrict.selectedIndex].value;
        regionName = selDistrict.options[selDistrict.selectedIndex].text;
    }
    else{
        if (selCity.selectedIndex > 0){
        	//如果选择市
            regionId = selCity.options[selCity.selectedIndex].value;
            regionName = selCity.options[selCity.selectedIndex].text;
        }
        else{
        	if (selProvince.selectedIndex > 0)
            {
        		//如果选择省
                regionId = selProvince.options[selProvince.selectedIndex].value;
                regionName = selProvince.options[selProvince.selectedIndex].text;
            }
            else
            {
               return;
            }
        }
    }
	//检查改地区是否存在
	exists = false;
	for (i=0;i<document.forms['theForm'].elements.length;i++)
	{
    	 if (document.forms['theForm'].elements[i].type=="checkbox")
          {
            if (document.forms['theForm'].elements[i].value == regionId)
            {
              exists = true;
              alert(region_exists);
            }
          }
	}
	 // 创建checkbox
    if (!exists)
    {
      regionCell.innerHTML += "<input type='checkbox' name='regions[]' value='" + regionId + "' checked='true' /> " + regionName + "&nbsp;&nbsp;";
    }
}

function compute_mode(shipping_code,mode){
	var base_fee  = document.getElementById("base_fee");
    var step_fee  = document.getElementById("step_fee");
    var item_fee  = document.getElementById("item_fee");
    if(shipping_code == 'post_mail' || shipping_code == 'post_express')
    {
     var step_fee1  = document.getElementById("step_fee1");
    }

    if(mode == 'number')
    {
      item_fee.style.display = '';
      base_fee.style.display = 'none';
      step_fee.style.display = 'none';
      if(shipping_code == 'post_mail' || shipping_code == 'post_express')
      {
       step_fee1.style.display = 'none';
      }
    }
    else
    {
      item_fee.style.display = 'none';
      base_fee.style.display = '';
      step_fee.style.display = '';
      if(shipping_code == 'post_mail' || shipping_code == 'post_express')
      {
       step_fee1.style.display = '';
      }
    }
}

function submitForm(){
	$('#theForm').form('submit',{
		url: '<?= Url::to('/shipping-area/'.$form_action)?>',  
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
	$('#theForm').form('clear');
}
</script>