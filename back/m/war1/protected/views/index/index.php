


<div class="container pdt10">
<div class="row">
  <div class="col-md-2">
	<ul role="tablist" class="nav nav-pills nav-stacked">
	<?php 
	$prefer = Prefer::model()->getData();
	if(is_array($prefer)): foreach($prefer as $k=>$v): 
		$active = $itemId == $k ? 'class="active"' : '';
		?>
	  <li <?=$active?>  role="presentation">
	  	<a href="<?=$this->createUrl('index/index',array('itemId'=>$k))?>">
	  		<?=$v['name']?>
		</a>
	  </li>
	<?php endforeach;endif;?>  
	  
	</ul>

  </div>
  <div class="col-md-10">
  	
<div class="row">		
	<div class="alert alert-success" role="alert">
		<?php if( isset($prefer[$itemId])):
			echo $prefer[$itemId]['desc'];
		endif?>
	</div>
</div>
  	
	<?php include dirname(__file__). '/list.php'; ?>
	  
	  
  </div>
</div>
</div>
    
