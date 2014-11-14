<div class="Register">
	<div class="foot">
		<?php if(Yii::app()->user->getId()):?>
		<a href="<?php echo $this->createUrl('site/logout')?>" class="logout">退出</a>
		<?php endif;?>
		<a href="http://www.focus.cn/" class="btn_reg"></a>
	</div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/index.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/dialog.js"></script>

</body>
</html>