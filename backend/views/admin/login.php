<?php 
use yii\captcha\Captcha;
use yii\helpers\Url;
?> 
<style>
<!--
body{
        margin:0px;
        padding:0px;
        font-size:12px;
    	background:#fff
    }
    .loginBox{
        width:1000px;
        height:574px;
        margin:0 auto;
        position:relative;
    	background:#fff
    }
    .loginCon{
        padding-top:210px;
        _padding-top:200px;
    }
    .inputText{
        height:28px;
        line-height:28px;
        border:1px solid #ccc;
    }
    .loginBtn{
        background: url('../images/loginBtn1.gif') no-repeat left top;
        width:144px;
        height:50px;
        display:block;
    }
    .loginBtn:hover{
        background: url('../images/loginBtn2.gif') no-repeat left top;
    }
-->
</style>		
<div id="dlg"  class="loginBox">
    <div class="loginCon">
	    <form id="ff" method="post" >
	     <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>" />
	    	<table style="width:330px;margin:0 auto;">
	    		<tr>
	    			<td style="padding-bottom:15px;padding-right: 10px;font-weight: bold; width:45;text-align: right;">帐<span style="display: inline-block;height:1px;width:1em;"></span>号 :</td>
	    			<td  style="padding-bottom:15px;"><input class="easyui-validatebox inputText" style="width:185px;" type="text" id="username" name="username" data-options="required:true,validType:'length[5,30]'" value=""></input>
	    			</td>
	    		</tr>
	    		<tr>
                            <td style="padding-bottom:15px;padding-right: 10px;font-weight: bold; width:45;text-align: right;">密<span style="display: inline-block;height:1px;width:1em;"></span>码 :</td>
	    			<td  style="padding-bottom:15px;"><input style="width:185px;" class="inputText easyui-validatebox" type="password" id="password" name="password" data-options="required:true,validType:'length[6,30]'"></input></td>
	    		</tr>
	    		<tr>
	    			<td style="padding-bottom:15px;padding-right: 10px;font-weight: bold; width:45;text-align: right;">验证码 :</td>
	    			<td  style="padding-bottom:15px;">
	    			 <input class="easyui-validatebox inputText" placeholder="验证码" name="verifyCode" id="verifyCode" style="width:100px;float: left"/>
                        <?php echo Captcha::widget([ 
                            'name'=>'verifyCode',
                            'captchaAction'=>'admin/captcha',
                            'imageOptions'=>[
                                'alt'=>'验证码',
                                'style'=>'cursor:pointer;float:left',
                                ],
                            'template'=>"{image}",
                          ])?>
	    			</td>
	    		</tr>
                        <tr>
                            <td style="padding-bottom:15px;padding-right: 10px;font-weight: bold; width:45;text-align: right;">&nbsp;</td>
	    			<td  style="padding-bottom:15px;"><a href="javascript:void(0)" class="loginBtn" onclick="submitForm()"></a>	 </td>
	    		</tr>
	    	</table>
	    </form>
	    </div>
	</div>
<div class="footer">
    <p style="margin-top:38px;text-align: center;">Copyright ©　创扬科技  2015 - <?php echo date('Y',time());?> All Right Reserved</p>
</div>
	<script type="text/javascript">
        var ua = (/(msie) ([\w.]+)/.exec(navigator.userAgent.toLowerCase())),isIE7=false;
        if(document.all && (ua[2]=="6.0")){
                    isIE7=true;
                    $.messager.alert('提示','您当前使用的浏览器版本过低，请升级到IE7及其以上版本或者使用Chrome、Firefox等浏览器！');
        }
        var enterKey=true;
        $("body").bind('keyup',function(event){
                 if(isIE7) return false;
                 if(event.keyCode==13 && enterKey){
                     submitForm();
                 }
                 enterKey=true;
	 	})
		function submitForm(){
                if(isIE7) return false;
                $('#ff').form('submit',{ 
        			url: '<?= Url::to('/admin/post')?>',  
        			onSubmit: function(){
        				if(!$(this).form('validate')) {
            				return false;
            			};
                        if($('#verifyCode').val() == '' || $('#verifyCode').val().length != 4){
                                    $.messager.alert('错误提示', '请输入4位字符的验证码！','info',function(){
                                      enterKey=false;
                                    })
                                    $("#password").val('');
        							return false;
                        }
                        return true;
        			},  
        			success: function(result){  
        				var result = eval('('+result+')');  
        				if (result.key){  
        					window.top.location = '<?=Url::to('/')?>';
        				} else {  
        					$("#password").val('');
        					$.messager.show({  
        						title: '错误提示',  
        						msg: result.keyMain
        					});
        					$('#refresh_a').click();
        				}  
        			}  
      		});
		}  
		
	</script>