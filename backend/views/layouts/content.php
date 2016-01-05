<?php
use yii;
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="<?=yii::$app->language?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="<?=Yii::$app->charset ?>" />  
        <?= Html::csrfMetaTags()?>
        <title><?=  yii::$app->id;?> - <?= Html::encode($this->title);?></title>
        <?php $this->head() ?>
   </head>
</html>