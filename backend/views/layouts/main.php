<?php 
use backend\assets\AppAsset;

use yii;
use yii\helpers\Html;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=Yii::$app->language?>" />
        <meta name="language" content="<?php echo Yii::$app->language;?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?= Html::csrfMetaTags()?>
        <title><?= Html::encode($this->title);?></title> 
        <?php $this->head() ?>
         <script type="text/javascript">
     $(function(){   
        	InitLeftMenu();

            $('#loginOut').click(function() {
                $.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

                    if (r) {
                        location.href = '<?= Url::to('login/logout')?>';
                    }
                });
            })
        });

        //初始化左侧
        function InitLeftMenu() {
        	$("#nav").accordion({animate:false});
      		 $.getJSON("<?= Url::to('menu/get');?>", function(data){
    			 var _menus= data;

  			   $.each(_menus.menus, function(i, n) {
	        		var menulist ='';
	        		menulist +='<ul>';
	                $.each(n.menus, function(j, o) {
	        			menulist += '<li><div><a ref="'+o.menuid+'" href="javascript:void(0);" rel="' + o.url + '" ><span class="icon '+o.icon+'" >&nbsp;</span><span class="nav">' + o.menuname + '</span></a></div></li> ';
	                })
	        		menulist += '</ul>';

	        		$('#nav').accordion('add', {
	                    title: n.menuname,
	                    content: menulist,
	                    iconCls: 'icon ' + n.icon
	                });

	            });
	            
 				$('.easyui-accordion li a').click(function(){
  	        		var tabTitle = $(this).children('.nav').text();

  	        		var url = $(this).attr("rel");
  	        		var menuid = $(this).attr("ref");
  	     
  	        		addTab(tabTitle,url);
  	        		$('.easyui-accordion li div').removeClass("selected");
  	        		$(this).parent().addClass("selected");
  	        	}).hover(function(){
  	        		$(this).parent().addClass("hover");
  	        	},function(){
  	        		$(this).parent().removeClass("hover");
  	        	});
  	        	
	 			 	//选中第一个
	 	        	var panels = $('#nav').accordion('panels');
	 	        	var t = panels[0].panel('options').title;
	 	            $('#nav').accordion('select', t);
    			});             
        }

        function editPassword(){
        	addTab("修改密码","<?= Url::to('admin/resetpwd');?>");
        }

        </script>
    </head>
    <body class="easyui-layout" style="overflow-y:hidden" scroll="no" >
    <?php $this->beginBody() ?>
     <div region="north" split="true"  class="main-div" border="false" style="height: 51px;">
        <div style="background: url('./images/logo1.jpg') no-repeat left top;width:330px;height:46px;float:left;margin-left:10px;_margin-left:4px;">
            <div style="margin-top: 18px; margin-left:300px;_margin-top: 18px; _margin-left:300px;font-size:14px"> <?= Yii::$app->params['version'];?></div>
        </div>
        <div  class="head" style="float:right;padding-right:20px;margin-top:17px;">欢迎回来:admin <a href="javascript:void(0)"   style="padding-left:10px;" onclick="editPassword()">修改密码</a><a href="javascript:void(0)"   id="loginOut" style="padding-left:10px;">安全退出</a></div>
         
   </div>
    <div region="south" split="true" style="height: 30px; background: #D2E0F2; ">
        <div class="footer">版权信息  深圳市创扬科技有限公司</div>
    </div>
    <div region="west" hide="true" split="true" title="导航菜单" style="width:180px;" id="west">
		<div id="nav" class="easyui-accordion" fit="true" border="false">
			</div>

    </div>
    <div id="mainPanle" region="center" style="background: #eee; overflow-y:hidden">
        <div id="tabs" class="easyui-tabs"  fit="true" border="false" >
			<div title="欢迎使用" style="padding:20px;overflow:hidden; color:red; " >
				 
			</div>
		</div>
    </div>
    
    


	<div id="mm" class="easyui-menu" style="width:150px;">
		<div id="mm-tabupdate">刷新</div>
		<div class="menu-sep"></div>
		<div id="mm-tabclose">关闭</div>
		<div id="mm-tabcloseall">全部关闭</div>
		<div id="mm-tabcloseother">除此之外全部关闭</div>
		<div class="menu-sep"></div>
		<div id="mm-tabcloseright">当前页右侧全部关闭</div>
		<div id="mm-tabcloseleft">当前页左侧全部关闭</div>
		<div class="menu-sep"></div>
		<div id="mm-exit">退出</div>
	</div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>