<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii;
?>
<p class="easyui-note">
    <?=Yii::t('config', 'mail_settings_note');?>
</p>
<div class="main-layout">
    <form id="mail-form" method="post" action="<?= Url::to('/config/post')?>" >
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
        
        <table width="100%" id="table">
            <?php foreach ($cfg as $key=>$var):?>
                <tr>
                    <td class="label" valign="top">
                    <?=$var['name']?>
                    </td>
                    <?php if ($var['type'] == 'text'):?>
			    <td><input class="easyui-textbox" type="text" name="value[<?=$var['id']?>]" size="40" value="<?=$var['value']?>"/></td>
			<?php elseif ($var['type'] == 'password'):?>
			    <td><input name="value[<?=$var['id']?>]" type="password" value="<?=$var['value'] ?>" size="40" class="easyui-textbox"/></td>
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
            <tr>
                <td class="label"><?=Yii::t('config', 'test_mail_address')?>:</td>
                <td>
                    <?=Html::input('text','test_mail_address','',['size'=>30])?>
                    <?=Html::input('button','',Yii::t('config', 'test_send'),['onclick'=>'sendTestEmail()','class'=>'button']) ?>
                </td>
            </tr>
            <tr>
              <td>
               &nbsp;
              </td>
              <td style="height:60px">
               <?=Html::input("submit","submit",Yii::t('app', 'button_submit'),['class'=>'button'])?>
                <?=Html::input("reset","reset",Yii::t("app", 'button_reset'),['class'=>'button'])?>
                <input name="type" type="hidden" value="mail_setting" class="button" />
              </td>
            </tr>
        </table>
    
    </form>
</div>