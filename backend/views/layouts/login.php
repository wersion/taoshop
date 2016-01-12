<?php 
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\web\View;
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh_cn" />
	<?= Html::csrfMetaTags()?>
	<title><?= Html::encode($this->title);?> -- 登录</title> 
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody()?>
    <?= $content; ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>