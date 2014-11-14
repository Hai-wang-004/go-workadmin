function aConfirm(msg,callback){
	var d = dialog({
	title: '提示',
	content: msg,
	button: [
	     {value: '确定',callback: callback,autofocus: true},
		{ value: '取消'}
		]
	});
	d.showModal();
}
function aAlert(msg,callback){
	msg = msg || '';
	callback = callback || function(){};
	var d = dialog({
		title: '提示',
		content: msg,
		button: [
			{value: '确定',callback: callback,autofocus: true}
		]
	});
	d.showModal();
}

// 购买
function wow_buy( o, url, msg ){
	msg = msg || '';
	aConfirm( msg+',您确实要购买吗?', function(){
		$.getJSON( url, function(data){
			if( data.status ){
				var a = $(o).parents('tr');
				a.find('td').css('background','#fcc');
				setTimeout(function(){
					a.remove();
				},300);
			}else{
				aAlert(data.data);
			}
		});
	});
}
// 取消拍卖
function wow_cancel( o, url ){
	aConfirm( '您确实要取消吗?', function(){
		$.getJSON( url, function(data){
			if( data.status ){
				var a = $(o).parents('tr');
				a.find('td').css('background','#fcc');
				setTimeout(function(){
					a.remove();
				},300);
			}else{
				aAlert(data.data);
			}
		});
	});
}

// 创建拍卖
function wow_createAuction( itemId, nums, name, icon ){
	// 基本参数设置
	$('#itemId').val(itemId);
	$('#name').html(name);
	if( nums > 20 ){
		$('#quantity').val(20);
		$('#stacks').val( Math.floor( nums / 20 ) );
	}else{
		$('#quantity').val(nums);
		$('#stacks').val( 1 );
	}
	$('#icon').attr("src",icon).show();
	$('#createAuction').show();
	
	// 设置参照值
	var url = $("#findurl").val();
	$('#refer').html('<div role="alert" class="alert alert-warning pdn">正在加载中...</div>');// 参照内容重新置空
	setPrice([0,0,0]);//参照值清零
	// 从服务器上获取参照内容列表
	$.get(url,{itemId:itemId},function(data){
		if(data){
			// 加载列表
			$('#refer').html(data);
			// 获取最小值
			var price = chknum( $("#minprice").val() ) ;
			// 最小值减1加到一口价表单中
			if( typeof(price) != undefined && price > 0 ){
				price = price -1;
				var minprice = value2Arr( price );
				if( minprice !== null ){
					setPrice( minprice );
				}
			}
		}else{
			$('#refer').html('<div role="alert" class="alert alert-danger pdn">无参照值</div>');
		}
		
	});
	
}
/**
 * 设置一口价
 */
function setPrice( price ){
	$("#buy_1").val( price[0] );
	$("#buy_2").val( price[1] );
	$("#buy_3").val( price[2] );
}
/**
 * 获取一口价
 */
function getPrice(){
	var buy1 = chknum( $("#buy_1").val(), 10 );
	var buy2 = chknum( $("#buy_2").val(), 10 );
	var buy3 = chknum( $("#buy_3").val(), 10 );
	if( !buy1 ){
		buy1 = 0;
	}
	if( !buy2 ){
		buy2 = 0;
	}
	if( !buy3 ){
		buy3 = 0;
	}
	
	return 10000 * buy1 + 100 * buy2 + buy3;
}
/**
 * 检测数字
 */
function chknum(v){
	v = parseInt(v,10);
	return isNaN(v) ? undefined : v;
}
/**
 * 2372511->[237,25,11]
 */
function value2Arr(v) {
  v = parseInt(v,10);
  if( isNaN(v) ){
  	return null;
  }
  var output = [];
  var farr = [10000,100,1];
  var len = farr.length;
  for(var i=0; i < len; i++){
    if ( v >= farr[i] ){
    	output.push(Math.floor( v / farr[i] ) );
    }else{
    	output.push(0);
    }
    v %= farr[i];
  }
  return output;
}

// 提交拍卖
function wow_sumitAuction(){
	// 1 参数获取与验证
	var itemId 	 = $('#itemId').val();
	var quantity = $('#quantity').val();
	var stacks 	 = $('#stacks').val();
	var duration = $('#duration').val();
	var buyout   = getPrice();
	
	var url		 = $('#sumbiturl').val();
	var success = total = 0;
	
	// 2 提交回调
	var create = function(){
		$.post( url,
			
				{itemId :  itemId,
				 quantity : quantity < 20 ? quantity : 20,
				 stacks : 1, //只能一组一组的提交
				 duration : duration,
				 buyout :  buyout
				},
				
				function(data){
					total ++ ;
					if( data.status ){
						success++;
						processControl( success, stacks );
					}else{
						$("#error").append( ' ' + total + ':' + data.data ).show();
					}
					/*if( total == stacks ){
						aAlert( '成功进度: ' + success + ' / ' + stacks ,function(){
							window.location.reload();
						});
					}*/
				},
				
				'json');
	}
	
	// 3 执行方法
	var run = function(){
		// 打开进度条
		processOpen(); 
		$("#process").html('');
		$("#error").html('');
		
		for(var i=1; i<=stacks; i++){
			create();
		}
	}

	// 4 初始化验证
	var init = function(){
		if( !chknum( itemId ) ){
			aAlert("必须指定一个商品");
			return false;
		}
		
		if( !chknum( quantity ) ){
			aAlert("堆叠数量必须是在1-20之间的数字");
			return false;
		}
		if( quantity > 20 ){
			aAlert("堆叠数量不能大于20");
			return false;
		}
		
		if( !chknum( stacks ) ){
			aAlert("堆叠组数必须是在1-50之间的数字");
			return false;
		}
		if( stacks > 50 ){
			aAlert("组太多了,少于50个吧");
			return false;
		}
		
		if( !chknum( duration ) ){
			aAlert("请您选择一个持续时间");
			return false;
		}
		
		if( !chknum( buyout ) ){
			aAlert("请您设置有效的一口价，必须是大于0的数字");
			return false;
		}
		if( buyout<=0 ){
			aAlert("一口价必须大于0");
			return false;
		}
		
		// 执行提交操作
		if( buyout < 50000 ){
			aConfirm( "您设置金额的过小,确实要这样做吗?", function(){
				run();
			});
		}else{
			run();
		}
	};
	
	// 5 执行
	init();
}

/**
 * 进度条弹出层
 */
function processOpen(){
	// 显示弹出层
	var p = $("#processContent");
	p.show();
	var elem = p[0];
	dialogProcess = dialog({
		title: '进度信息',
	    content: elem,
	    width: 640,
	    height:200,
	    quickClose:true,
	    backdropOpacity:'0.7',
	    onclose:function(){
	    	window.location.reload();
	    }
	}).showModal();
}
/**
 * 进度百分比控制
 */
function processControl( sucess, total ){
	// 1 控制百分比
	var percent = Math.floor( sucess / total * 100);
	var html = '<div class="progress-bar" role="progressbar" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percent+'%;">'+percent+'%</div>';
	$("#process").html(html);
}

