<input type="hidden" id="minprice" value="<?=$data[0]['group']?>" />
<table class="table table-hover" id="refer">
  	<thead>
	<tr>
		<th colspan="2">参照最低价(<?=$total?>个)</th>
	</tr>
  	</thead>
	<tbody>
	<?php foreach($data as $k=>$v): ?>
	<tr>
    	<td><?=$v['title']?></td>
    	
    	<td>
    		<i>
				<span class="icon-gold"><?=$v['groups'][0]?></span>
				<span class="icon-silver"><?=$v['groups'][1]?></span>
				<span class="icon-copper"><?=$v['groups'][2]?></span>
			</i>
    	</td>
    	
	</tr>
	<?php endforeach;?>
</tbody>
</table>