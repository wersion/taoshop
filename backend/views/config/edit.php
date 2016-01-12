<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
<style scoped="scoped">
		.tt-inner{
			display:inline-block;
		
		}
		.easyui-tabs p{
			padding:10px;
			border-color:#eee;
		}
</style>
<form id="ff" class="easyui-form" enctype="multipart/form-data" method="post" action="<?=  Url::to('/config/post')?>" >
<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
<div class="easyui-tabs" data-options="tabWidth:80,tabHeight:30" style="width:98%;height:auto; margin:10px auto;background:#eee">
    <?php foreach ($group_list as $group):?>
		<div title="<span class='tt-inner'><?= $group['name'];?></span>">
		<p>
		  <table cellpadding="5" style="margin:10px auto 0">
		  <?php foreach ($group['vars'] as $key=>$var):?>
		       <tr>
	    			<td><?=Html::encode($var['name'])?>:</td>
			<?php if ($var['type'] == 'text'):?>
			    <td><input class="easyui-textbox" type="text" name="value[<?=$var['id']?>]" size="40" value="<?=$var['value']?>"/></td>
			<?php elseif ($var['type'] == 'password'):?>
			    <td><input name="value[<?=$var['id']?>]" type="password" value="<?=$var['value'] ?>" size="40" /></td>
			<?php elseif ($var['type'] == 'textarea'):?>
			     <td><input class="easyui-textbox" name="value[<?=$var['id']?>]" data-options="multiline:true" style="height:60px;width:260px" value="<?=$var['value']?>"></td>
			<?php elseif ($var['type'] == 'select'):?>
			      <td>
			        <?php foreach ($var['store_options'] as $k=>$opt):?>
			         <label for="value_<?=$var['id']?>_<?=$k?>">
			         <input type="radio" name="value[<?=$var['id']?>]" id="value_<?=$var['id']?>_<?=$k?>" value="<?=$opt?>"
            <?php if($var['value'] == $opt):?>checked="true"<?php endif;?>/><?=$var['display_options'][$k]?></label>
			        <?php endforeach;?>
			      </td>
			<?php elseif ($var['type'] == 'options'):?>
			      <td>
			         <select class="easyui-combobox" name="value[<?=$var['id']?>]" id="value_<?=$var['id']?>_<?=$key?>">
			         <?php foreach ($var['store_options'] as $sk=>$opt):?>
                        <option value="<?=$opt?>" <?php if($var['value'] == $opt):?>selected="selected"<?php endif;?>><?=$var['display_options'][$sk]?></option>
                     <?php endforeach;?>
			         </select>
			      </td> 
			<?php elseif ($var['type'] == 'file'):?>
			       <td>
			         <input type="text" id="value_<?=$var['id']?>_<?=$key?>" name="<?=$var['code']?>"  style="width:200px">&nbsp;&nbsp;
			         <?php if (!empty($var['value'])):?>
                        <img src="/images/ok.png" alt="yes" />
                    <?php else:?>
                        <img src="/images/no.png" alt="no" />
                    <?php endif;?>
			         <script type="text/javascript">
			         $('#value_<?=$var['id']?>_<?=$key?>').filebox({
			             buttonText:'上传文件',
			             buttonAlign:'right'
			         });
			         </script>
			       </td>
            <?php elseif ($var['type'] == 'city_code'):?>
                    <td>
                    <?php echo common\widgets\area\AreaLinkage::widget([
											 'type'=>'backend',
											 'prefix'=>'shop_',
                                              'name'=>'value['.$var['id'].']',
											 'selectAreaCode'=>!empty($var['value'])?$var['value']:'',
											 ]);?>
                    </td>			       
			<?php elseif ($var['type'] == 'manual'):?>
			      <td>
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
			      </td>
			<?php endif;?>
			    </tr>
		  <?php endforeach;?>
		  </table>
		</p>
		</div>
	<?php endforeach;?>
	</div>
</form>
<div style="width:99%;height:auto; margin:10px auto;background:#fff;padding-top:8px;padding-bottom:8px">
    <div style="text-align:center;padding:5px">
    	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" data-options="iconCls:'icon-save'">&nbsp;&nbsp;提交&nbsp;&nbsp; </a>
    	    	<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" data-options="iconCls:'icon-undo'"> &nbsp;&nbsp;重设 &nbsp;&nbsp;</a>
    </div>
</div>

<script>
		function submitForm(){
			$('#ff').form('submit',{
				onSubmit:function(){
					return true;
				}
			});
		}
		function clearForm(){
			$('#ff').form('clear');
		}
	</script>