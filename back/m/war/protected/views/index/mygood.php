<div class="container pdt10">
	
<div class="row">

  <!--左侧开始-->
  <div class="col-md-8">

	  <?php if(is_object($data)): ?>
	  <table class="table table-hover">
	  	<thead>
		<tr>
			<th>序号</th>
			<th>名称</th>
			<th>itemId</th>
			<th>所有</th>
			<th>背包</th>
			<th>银行</th>
			<th>邮箱</th>
			<th>出售</th>
		</tr>
	  	</thead>

		<tbody>
			<?php $i=0; foreach($data as $k=>$v): $i++ ?>
			<tr>
				<td>
		    		<b><?=$i?></b>
		    	</td>
		    	<td>
		    		<img src="<?=$v->icon?>" width="28" />
		    		<b><?=$v->name?></b>
		    	</td>
		    	<td>
		    		<?=$v->id?>
		    	</td>
		    	<td><?=$v->q0?></td>
		    	<td><?=$v->q1?></td>
		    	<td><?=$v->q2?></td>
		    	<td><?=$v->q3?></td>
		    	<td>
			    	<?php $scanUrl= $this->createUrl( "index/index/?itemId={$v->id}" ); ?>
	    			<a target="_blank" class="btn btn-primary" href="<?=$scanUrl?>">浏览</a>
		    		<button class="btn btn-danger" onclick="return wow_createAuction('<?=$v->id?>','<?=$v->q0?>','<?=$v->name?>','<?=$v->icon?>');">出售</button>
		    	</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php endif; ?>


  </div>
  <!--左侧结束-->
  
  <!--右侧开始-->
  <div class="col-md-4">
	
     <!--创建开始-->
     <div id="createAuction" style="display:none;">
     	  <input type="hidden" name="searchurl" id="findurl" value="<?=$this->createUrl('index/find')?>">
		  <input type="hidden" name="sumbiturl" id="sumbiturl" value="<?=$this->createUrl('index/createAuction')?>">
		  <input type="hidden" name="itemId"    id="itemId" value="">
		  
		  <div class="form-group">
		    <label for="name">
		    <img id="icon" src="" width="56" style="display:none;" />
			</label>
		    <div id="name"></div>
		  </div>
		  
		  <div class="form-group">
		    <label for="quantity">堆叠数量</label>
		    <input type="text" size="2"  name="quantity" id="quantity" value="20"  maxlength="2">
		  </div>
		  
		  <div class="form-group">
		    <label for="stacks">堆叠组数</label>
		    <input type="text" size="2" name="stacks" id="stacks" maxlength="2">
		  </div>
		  
		  <div class="form-group">
		    <label for="duration">持续时间</label>
			<select id="duration" name="duration">
				<option value="0">12小时</option>
				<option value="1" selected="selected">24小时</option>
				<option value="2">48小时</option>
			</select>
		  </div>
		
		  <div class="form-group">
		    <label for="buyout">一口价</label>
			<input type="hidden" name="buyout" id="buyout" class="form-control" >
			<span class="icon-gold">  <input id="buy_1" maxlength="6" type="text" size="2"></span>
			<span class="icon-silver"><input id="buy_2" maxlength="2" type="text" size="2"></span>
			<span class="icon-copper"><input id="buy_3" maxlength="2" type="text" size="2"></span>
		  </div>
		
		  <button type="button" onclick="return wow_sumitAuction()" class="btn btn-default">出售</button>
     </div><!--创建结束-->	

	 <!--参照价格 start-->	
	 <div id="refer">
		 
	</div><!--参照价格 end-->	
	
  </div><!-- 右侧结束 -->

	
</div><!-- row end -->


<div class="row" id="processContent" style="display:none;">
	<div class="progress" id="process">
		<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
	</div>
   	<div id="error"></div>
</div>


</div><!-- container end -->
    