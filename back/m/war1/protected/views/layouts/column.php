<!DOCTYPE html>
<html lang="zh-cn">
<?php
$nav = Yii::app()->params['navbar'];
$modelname  = Yii::app()->controller->id;  
$methodname = $this->getAction()->getId();
$cururl = $modelname.'/'.$methodname;
?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>wow</title>

    <!-- Bootstrap -->
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/common.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/js/artDialog/css/ui-dialog.css">
  </head>
  <body>

<div class="container pdt10">


	<ul class="nav nav-tabs" role="tablist">
	  <?php 
	  	foreach( $nav as $v ): 
	  		$active = $cururl == $v['url'] ? 'class="active"' : '';
	  ?>
	  	<li <?=$active?> role="presentation" ><a href="<?=$this->createUrl($v['url'])?>"><?=$v['title']?></a></li>
	  <?php endforeach ?>
	  
	</ul>
</div>

<!-- content start -->
<?php

$this->beginContent('/layouts/main');
echo $content;
$this->endContent();

?>
<!-- content end -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js"></script>
    
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/artDialog/dist/dialog-min.js"></script>
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/common.js" type="text/javascript" charset="utf-8"></script>

  </body>
</html>