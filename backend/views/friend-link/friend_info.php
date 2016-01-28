<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii;
?>
<div class="main-layout">
    <form id="mail-form" method="post" enctype="multipart/form-data" action="<?= Url::to('/friend-link/'.$form_act)?>" >
        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
        
        <table width="100%" id="table">
             <tr>
                <td class="label" valign="top">
                    <?=yii::t('friendlink', 'link_name')?>:
                </td>
                <td>
                    <input type="text" name="link_name" class="easyui-textbox" value="<?php if (isset($arrLink['link_name'])):echo $arrLink['link_name'];endif;?>" data-options="required:true"  />
                </td>
             </tr>
             <tr>
                <td class="label" valign="top">
                    <?=yii::t('friendlink', 'link_url')?>:
                </td>
                <td>
                    <input type="text" name="link_url" class="easyui-textbox" value="<?php if (isset($arrLink['link_url'])):echo $arrLink['link_url'];endif;?>" data-options="validType:'url'"  />
                </td>
             </tr>
             <tr>
                <td class="label" valign="top">
                    <?=yii::t('friendlink', 'show_order')?>:
                </td>
                <td>
                    <input type="text" name="show_order" class="easyui-textbox" value="<?php if (isset($arrLink['show_order'])):echo $arrLink['show_order'];else:echo '50';endif;?>"  />
                </td>
             </tr>
             <tr>
                <td class="label" valign="top"><?=yii::t('friendlink', 'link_logo')?>:</td>
                <td>
                    <input type="text" name="link_img" class="easyui-filebox"  width="100px" buttonText="选择图片"/>
                </td>
             </tr>
             <tr>
                <td class="label" valign="top"><?=yii::t('friendlink', 'url_logo')?>:</td>
                <td>
                    <input type="text" name="url_logo" class="easyui-textbox" value="<?= isset($link_logo)? Html::decode($link_logo):'';?>">
                </td>
             </tr>
              <tr>
              <td class="label">&nbsp; </td>
              <td style="height:60px">
               <?=Html::input("submit","submit",Yii::t('app', 'button_submit'),['class'=>'button'])?>
                <?=Html::input("reset","reset",Yii::t("app", 'button_reset'),['class'=>'button'])?>
                <input name="id" type="hidden" value="<?= isset($arrLink['id'])?$arrLink['id']:0;?>"/>
                <input name="type" type="hidden" value="<?= isset($type)?$type:''?>" />
              </td>
            </tr>
         </table>
    </form>
</div>