 <div class="row">	 	
	
	<div class="alert alert-success" role="alert">
		共<?=$total?>条
	</div>

	  <table class="table table-hover">
	  	<thead>
		<tr>
			<th>序号</th>
			<th>名称</th>
			<th>itemId</th>
			<th>实价/数量</th>
			<th>均价/组</th>
			<th>均价/个</th>
			<th>购买操作</th>
		</tr>
	  	</thead>

	<tbody>
<?php 
$preferObj = Prefer::model();
if(is_array($data)): foreach($data as $k=>$v): 
	$active = $preferObj->isNotice( $v['itemId'], $v['per'] ) ? 'class="danger"' : '';
?>
<tr <?=$active?>>
    	<td>
    		<?=$k+1?>
    	</td>
    	<td>
    		<img src="<?=$v['icon']?>" width="28" />
    		<b><?=$v['title']?></b>
    		<br />
    		<?=$v['author']?>
    	</td>
    	<td>
    		<?=$v['itemId']?>
    	</td>
    	<td>
    		<i>
        		<span class="icon-gold"><?=$v['moneys'][0]?></span>
				<span class="icon-silver"><?=$v['moneys'][1]?></span>
				<span class="icon-copper"><?=$v['moneys'][2]?></span>
    		</i>
    		<br />
    		<?=$v['quantity']?>个
    		
    	</td>
    	<td>
    		
			<span class="icon-gold"><?=$v['groups'][0]?></span>
			<span class="icon-silver"><?=$v['groups'][1]?></span>
			<span class="icon-copper"><?=$v['groups'][2]?></span>
    		
    	</td>
    	<td>
    		
			<span class="icon-gold"><?=$v['pers'][0]?></span>
			<span class="icon-silver"><?=$v['pers'][1]?></span>
			<span class="icon-copper"><?=$v['pers'][2]?></span>
			
    	</td>
    	<td>
    		<?php 
    		if($auction): 
    			$cancelUrl = $this->createUrl( "index/cancel/",array('auc'=>$v['auc'],'xsToken'=>$xsToken));
                $scanUrl= $this->createUrl( "index/index/",array('itemId'=>$v['itemId'] )); 
    			?>
    			<a target="_blank" class="btn btn-primary" href="<?=$scanUrl?>">浏览</a>
    			<button class="btn btn-danger" onclick="return wow_cancel(this,'<?=$cancelUrl?>','');">取消</button>
    		<?php else: 
    			$buyUrl = $this->createUrl( "index/buy/",array('auc'=>$v['auc'],'money'=>$v['money'],'xsToken'=>$xsToken ));
				$msg = $v['groups'][0].'金'.$v['groups'][1].'银'.$v['groups'][2].'铜/组';
				?>
    			<button class="btn btn-danger" onclick="return wow_buy(this,'<?=$buyUrl?>','<?=$msg?>');">购买</button>
    		<?php endif?>
    		
    	</td>

</tr>
<?php endforeach;endif;?>
	</tbody>
	
	  </table>
</div>