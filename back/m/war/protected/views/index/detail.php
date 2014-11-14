
<div class="container pdt10">
<div class="row">
  <div class="col-md-2">
	<ul role="tablist" class="nav nav-pills nav-stacked">

	  <li class="active" role="presentation">
	  	<a href="#">
	  		<?=$role->name?>
		</a>
	  </li>

	  
	</ul>

  </div>
  <div class="col-md-10">
  	

<div class="row">		
	<div class="alert alert-success" role="alert">
		金额：
		<span class="icon-gold"><?=$money_str[0]?></span>
		<span class="icon-silver"><?=$money_str[1]?></span>
		<span class="icon-copper"><?=$money_str[2]?></span>
	</div>
</div>

<div class="row">		
		
		<?php	print_test($role); ?>
	
</div> 
	  
  </div>
</div>
</div>
    
