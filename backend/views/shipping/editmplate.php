<?php 
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="easyui-panel" title="<?=Yii::t('shipping', 'shipping_print_template')?>" type="width:100%">
    <div class="list-div" style="margin-bottom: 5px">
        <table id="general-table" align="center" width="100%" cellpadding="3" cellspacing="1" border="0">
          <tr>
            <td colspan="2" width="100%"><strong>请选择模板的模式：</strong><input type="radio" name="model" id="model_1" value="1" <?php if ($shipping['print_model'] == 1):?>checked="checked"<?php endif;?> onclick="javascript:model_change('1');">代码模式&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="model" id="model_2" value="2" <?php if ($shipping['print_model'] == 2):?>checked="checked"<?php endif;?> onclick="javascript:model_change('2');">所见即所得模式
            <br/><span class="notice-span" id="noticeGoodsSN">选择“代码模式”可以切换到以前版本。建议您使用“所见即所得模式”。所有模式选择后，同样在打印模板中生效。</span></td>
          </tr>
          <tr>
            <th colspan="2" width="100%">编辑模板</th>
          </tr>
          <tr id="visual" <?php if ($shipping['print_model'] == 1):?>style="display:none"<?php endif;?>>
             <td colspan="2" width="100%">
             <!--Flash播放器 start-->
             <iframe id="goods_desc___Frame" src="<?=Url::toRoute(['/shipping/print-index','shipping'=>$shipping_id])?>" width="99%" height="675" frameborder="0" scrolling="no"></iframe>
             <!--Flash播放器 end-->
             </td>
         </tr>
         <form method="post" name="theForm" action="<?=Url::toRoute(['/shipping/do-edit-print-template','shipping'=>$shipping['id']])?>">
            <input type="hidden" name="print_model" value="1">
            <input type="hidden" name="shipping_name" value="<?=$shipping['shipping_name']?>">
          <tr id="code_shipping_print" <?php if ($shipping['print_model'] == 2):?>style="display:none"<?php endif;?>>
            <td width="75%"><textarea id="shipping_print" name="shipping_print" rows="26" cols="100" ><?=Html::encode($shipping['shipping_print'])?></textarea></td>
            <td align="left" valign="top" width="25%"><?=Yii::t('shipping', 'shipping_template_info')?></td>
          </tr>
          <tr id="code_submit" <?php if ($shipping['print_model'] == 2):?>style="display:none"<?php endif;?>>	
            <td colspan="2" align="center" width="100%"><input type="submit" value="确定" class="button" /></td>
          </tr>
         
         </form>
        </table>
    </div>
</div>
<script type="text/javascript" src="/js/utils.js"></script>
<script type="text/javascript" src="/js/validator.js"></script>
<script type="text/javascript">
<!--
var display_yes = (Browser.isIE) ? 'block' : '';

/**
 * 切换编辑模式
 */
function model_change(type)
{
  //获取表单对象
  switch (type)
  {
    case '1': //代码模式
        document.getElementById('code_shipping_print').style.display = display_yes;
        document.getElementById('code_submit').style.display = display_yes;
        document.getElementById('visual').style.display = 'none';
    break;

    case '2': //所见即所得模式
        document.getElementById('code_shipping_print').style.display = 'none';
        document.getElementById('code_submit').style.display = 'none';
        document.getElementById('visual').style.display = display_yes;
    break;
  }

  return true;

}
//-->
</script>