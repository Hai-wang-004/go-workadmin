<?php
// 采集配置

// 1 登陆匹配
$params['wow_login'] = array(
	'csrftoken' =>  array(array( 'match' => '<input type="hidden" name="csrftoken" value="[内容]" />')), 
	'welcome'   =>  array(array( 'match' => '<li class="service-cell service-welcome">[内容]</li>')),			 
);

// 2 查询列表
$params['wow_list'] = array(
	'total'   =>  array(array( 'match' => '<strong class="results-total">[内容]</strong>')),
	'table'   =>  array(array( 'match' => '<div class="table">[内容]<div class="table-options data-options ">')),
	'xsToken' =>  array(array( 'match' => "var xsToken = '[内容]';")),
);

// 2 查询列表子项
$params['wow_item'] = array(
	// 精确匹配
	'title'   =>  array(array( 'match' => '<td class="item"[内容]</td>'),
				  		array( 'match' => '<strong>[内容]</strong>'),
	
				),
				
	'icon'   =>  array(array( 'match' => '<td class="item"[内容]</td>'),
				  	   array( 'match' => 'style="background-image: url(\'[内容]\');">'),
	
				),
				
	'itemId'  =>  array(array( 'match' => '<td class="item"[内容]</td>'),
	              		array( 'match' => '<a href="/wow/zh/item/[内容]" data-item'),
				),
				
	'author'  =>  array(array( 'match' => '<td class="item"[内容]</td>'),
	 			  		array( 'method'=> 'match', 'regex'=>'/<a href="\/wow\/zh\/character\/[^>]*">(.*)<\/a>/i'),
				),
				
	// 数量
	'quantity'  =>  array(array( 'match' => '<td class="quantity">[内容]</td>')), 
	
	//'time'   =>  array(array(  'match' => '<td class="time">[内容]</td>')), 
	
	//'price'  =>  array(array(  'match' => '<td class="price"[内容]</td>')), 
	
	'options'=> array(array( 'match' => '<td class="options">[内容]</td>'),
				 	  array( 'match' => '<a href="javascript:;" class="ah-button" onclick="Auction.openBuyout([内容]);">一口价</a>'),
	
				),  
);


// 3 我的商品 是个json数据
$params['wow_mygood'] = array(
	'data'   =>  array(array( 'match' => 'AuctionCreate.items = [内容]});')), 	
);


// 4 拍卖列表
$params['wow_auction_list'] = array(
	'total'   =>  array(array( 'match' => '<span id="total-auctions-active">[内容]</span>')), 	
	'table'   =>  array(array( 'match' => '<div class="auction-house auctions">[内容]<div id="auctions-sold" class="table-section">')), 
	'xsToken' =>  array(array( 'match' => "var xsToken = '[内容]';")),		
);

// 4 拍卖列表子项

$wow_auction = array(
        
    'auc'  =>  array(array(  'match' => '<a href="javascript:;" class="ah-button" onclick="Auction.openCancel([内容]);">取消</a>')),
    
    'm1'=> array(array( 'match' => '<div class="price-buyout">[内容]</div>'),
                 array( 'match' => '<span class="icon-gold">[内容]</span>'),
           ),  
    'm2'=> array(array( 'match' => '<div class="price-buyout">[内容]</div>'),
                 array( 'match' => '<span class="icon-silver">[内容]</span>'),
           ), 
    'm3'=> array(array( 'match' => '<div class="price-buyout">[内容]</div>'),
                 array( 'match' => '<span class="icon-copper">[内容]</span>'),
           ), 
);
$params['wow_auction'] = array_merge($params['wow_item'] , $wow_auction);

