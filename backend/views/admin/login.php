<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LoginAsset;
use backend\assets\Ie9HeadAsset;
use backend\assets\Ie8HeadAsset;
use yii\captcha\Captcha;
use yii\widgets\ActiveForm;

LoginAsset::register($this);
Ie9HeadAsset::register($this);
Ie8HeadAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= yii::$app->language;?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
        
        <title><?=yii::$app->id?> Login</title>

        <meta name="description" content="管理员登录" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <?= Html::csrfMetaTags()?>
        <?php $this->head() ?>
        <style type="html/css">
            .left{float: left}
        </style>
    </head>
    <body class="login-layout blur-login">
        <?php $this->beginBody() ?>
       
        <div class="main-container">
                <div class="main-content">
                        <div class="row">
                                <div class="col-sm-10 col-sm-offset-1">
                                        <div class="login-container">
                                                <div class="center">
                                                        <h1>
                                                                <i class="ace-icon fa fa-leaf green"></i>
                                                                <span class="red">taoshop</span>
                                                                <span class="white" id="id-text2">管理员登录</span>
                                                        </h1>
                                                </div>

                                                <div class="space-6"></div>

                                                <div class="position-relative">
                                                            <div id="login-box" class="login-box visible widget-box no-border">
                                                                    <div class="widget-body">
                                                                        <div class="widget-main">
                                                                            <h4 class="header blue lighter bigger">
                                                                                    <i class="ace-icon fa fa-coffee green"></i>
                                                                                    请输入您的账号和密码
                                                                            </h4>

                                                                            <div class="space-6"></div>

                                                                            <form id="loginForm" method="post" action="<?= Url::to(['admin/loginpost'])?>">
                                                                                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                                                                <fieldset>
                                                                                    <label class="block clearfix">
                                                                                            <span class="block input-icon input-icon-right">
                                                                                                <input type="text" class="form-control" placeholder="账号" name="username" id="username"/>
                                                                                                    <i class="ace-icon fa fa-user"></i>
                                                                                            </span>
                                                                                    </label>

                                                                                    <label class="block clearfix">
                                                                                            <span class="block input-icon input-icon-right">
                                                                                                <input type="password" class="form-control" placeholder="密码" name="password"/>
                                                                                                    <i class="ace-icon fa fa-lock"></i>
                                                                                            </span>
                                                                                    </label>

                                                                                    <label>
                                                                                        <span class="block clearfix">
                                                                                            <input type="text" class="form-control" placeholder="验证码" name="verifyCode" style="width:100px;float: left"/>
                                                                                            <?php echo Captcha::widget([ 
                                                                                                'name'=>'verifyCode',
                                                                                                'captchaAction'=>'admin/captcha',
                                                                                                'imageOptions'=>[
                                                                                                    'alt'=>'验证码',
                                                                                                    'style'=>'cursor:pointer;float:left',
                                                                                                    ],
                                                                                                'template'=>"{image}",
                                                                                              ])?>
                                                                                        </span>
                                                                                    </label>

                                                                                    <div class="space"></div>

                                                                                    <div class="clearfix">
                                                                                            <label class="inline">
                                                                                                    <input type="checkbox" class="ace" name="rememberMe"/>
                                                                                                    <span class="lbl"> 记住我</span>
                                                                                            </label>

                                                                                            <button type="button" class="width-35 pull-right btn btn-sm btn-primary" onclick="submitForm()">
                                                                                                    <i class="ace-icon fa fa-key"></i>
                                                                                                    <span class="bigger-110">立即登录</span>
                                                                                            </button>
                                                                                    </div>

                                                                                    <div class="space-4"></div>
                                                                                    </fieldset>
                                                                                </form>
                                                                        </div><!-- /.widget-main -->


                                                                    </div><!-- /.widget-body -->
                                                        </div><!-- /.login-box -->
                                                </div><!-- /.position-relative -->
                                        </div>
                                </div><!-- /.col -->
                        </div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->
        <script type="text/javascript">
                if('ontouchstart' in document.documentElement) document.write("<script src='<?= Yii::getAlias('@web')?>/js/jquery.mobile.custom.js'>"+"<"+"/script>");
        </script>
         <script type="text/javascript">
                function submitForm(){
                   var name = $('#username').val();
                   var pwd  = $('#password').val();
                   var code = $('#verifyCode').val();
                   if (name=='' || pwd == '' || code == ''){
                       return false;
                   }
                   $("#loginForm").submit();
                }
	</script>
        <?php $this->endBody();?>
       
    </body>
</html>
<?php $this->endPage()?>