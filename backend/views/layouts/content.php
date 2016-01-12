<?php 
use backend\assets\ContentAsset;
use yii;
use yii\helpers\Html;

ContentAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=Yii::$app->language?>" />
        <meta name="language" content="<?php echo Yii::$app->language;?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?= Html::csrfMetaTags()?>
        <title><?= Html::encode($this->title);?></title> 
        <?php $this->head() ?>
       
    </head>
    <body class="easyui-layout" style="overflow-y:hidden" scroll="no" >
    <?php $this->beginBody() ?>
     <div region="center" style="padding:0px;background:#eee;position: relative;" border="false">
        <?= $content; ?>
     </div>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>