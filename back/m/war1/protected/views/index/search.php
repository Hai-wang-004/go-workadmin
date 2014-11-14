
<div class="container pdt10">
<div class="row">
  <div class="col-md-2">
	<ul role="tablist" class="nav nav-pills nav-stacked">
	<?php if(is_array($types1)): foreach($types1 as $k=>$v): 
		$active = $where['type1'] == $k ? 'class="active"' : '';
		
		?>
	  <li <?=$active?>  role="presentation">
	  	<a href="<?=$this->createUrl('index/search',array('where[type1]'=>$k))?>">
	  		<?=$v?>
		</a>
	  </li>
	<?php endforeach;endif;?>  
	  
	</ul>

  </div>
  <div class="col-md-10">
  	
<div class="row">		
	<form class="form-inline" method="get" role="form" action="<?=$this->createUrl('index/search')?>">
	  <input type="hidden" id="type1" name="where[type1]" value="<?=$where['type1']?>" />
	  
	  <div class="form-group">
		<label class="sr-only" for="name">小分类</label>
		<select class="form-control" name="where[type2]">
			
		<?php if( is_numeric($where['type1']) && is_array( $types2[$where['type1']] ) ): 
				foreach($types2[$where['type1']] as $k=>$v): 
					$active = $where['type2'] == $k ? 'selected="selected"' : '';
		?>
		
		<option value="<?=$k?>" <?=$active?> ><?=$v?></option>
		
		<?php endforeach;endif;?>  
		</select>
	  </div>
	  
	  <div class="form-group">
		<label class="sr-only" for="name">物品名称</label>
		<input type="text" name="where[name]" class="form-control" value="<?=$where['name']?>" id="name" placeholder="输入名称" />
	  </div>
	  
	  <button type="submit" class="btn btn-default">查询</button>
	</form>	
</div>
  	

		<?php include dirname(__file__). '/list.php'; ?>

	  
	  
  </div>
</div>
</div>
    
    
    