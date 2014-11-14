$(function() {
	//删除一条文章
	$(".del").click(
			function() {
				var delLink = $(this).attr("link");
				popup.confirm('删除【<b>' + $(this).attr("name") + '</b>】吗?', '删除提示', function(action) {
					if (action == 'ok') {
						top.window.location.href = delLink;
					}
				});
				return false;
			});
	//上下线一条文章
	$(".status").click(
			function() {
				var statusLink = $(this).attr("link");
				var statusActStr = $(this).attr("title");
				popup.confirm(statusActStr + '【<b>' + $(this).attr("name") + '</b>】吗?', '状态提示', function(action) {
					if (action == 'ok') {
						top.window.location.href = statusLink
					}
				});
				return false;
			});
	//排序
	$(".order").change(
			function() {
				var orderLink = $(this).attr("link");
				var orderval = $(this).val();
				// orderval = orderval.replace("/0","");
				if (!isNaN(orderval)) {
					orderLink += "/order/" + orderval;
					popup.confirm('排序<b>' + $(this).attr("name") + '</b>】吗?', '排序提示', function(action) {
						if (action == 'ok') {
							top.window.location.href = orderLink
						}
					});
					return false;
				} else {
					alert("排序必须为整数");
				}
			});
	//全选与反选
	$("#selectIDs").click(function() {
		if ($("#selectIDs").html() == "[全选]") {
			$("#selectIDs").html("[取消]");
			var ids = document.getElementsByName("ids[]");
			for ( var i = 0; i < ids.length; i++) {
				ids[i].checked = true;
			}
		} else {
			$("#selectIDs").html("[全选]");
			var ids = document.getElementsByName("ids[]");
			for ( var i = 0; i < ids.length; i++) {
				ids[i].checked = false;
			}
		}
	});
	//加入newsletter
	$("#addnewsletter_btn").click(
			function() {
				var AllIDs = document.getElementsByName("ids[]");
				var ids = new Array();
				var j = 0;
				for ( var i = 0; i < AllIDs.length; i++) {
					if (AllIDs[i].checked == true) {
						ids[j] = AllIDs[i].value;
						j++;
					}
				}
				popup.confirm('加入最新newsletter列表吗?', '温馨提示', function(action) {
					if (action == 'ok') {
						// alert(ids.join(";"));
						$.getJSON("/index.php?s=Article/addnewsletter/ids/"+ ids, function(data) {
							if (data.status == 1) {
								alert("加入成功！");
							} else {
								alert("加入失败！");
							}
						});
					}
				});
				return false;
			});
	// 批量删除文章
	$("#delmulti_btn")
			.click(
					function() {
						var AllIDs = document.getElementsByName("ids[]");
						var ids = new Array();
						var j = 0;
						for ( var i = 0; i < AllIDs.length; i++) {
							if (AllIDs[i].checked == true) {
								ids[j] = AllIDs[i].value;
								j++;
							}
						}
						popup.confirm('批量删除所选文章吗?','温馨提示', function(action) {
							if (action == 'ok') {
								// alert(ids.join(";"));
								$.getJSON("/index.php?s=Article/del/ids/"+ ids, function(data) {
									if (data.status == 1) {
										// alert("删除成功！");
										top.window.location.href = "index.php?s=Article/index";
									} else {
										alert("加入失败！");
									}
								});
							}
						});
						return false;
					});
	// 批量发布文章
	$("#addmulti_btn")
			.click(
					function() {
						var AllIDs = document.getElementsByName("ids[]");
						var ids = new Array();
						var j = 0;
						for ( var i = 0; i < AllIDs.length; i++) {
							if (AllIDs[i].checked == true) {
								ids[j] = AllIDs[i].value;
								j++;
							}
						}
						popup.confirm('批量发布所选文章吗?','温馨提示',function(action) {
							if (action == 'ok') {
								$.getJSON("/index.php?s=Article/setstatus/status/1/ids/"+ ids, function(data) {
									if (data.status == 1) {
										top.window.location.href = "index.php?s=Article/index";
									} else {
										alert("发布失败！");
									}
								});
							}
						});
						return false;
					});
	// 批量下架文章
	$("#closemulti_btn")
			.click(
					function() {
						var AllIDs = document.getElementsByName("ids[]");
						var ids = new Array();
						var j = 0;
						for ( var i = 0; i < AllIDs.length; i++) {
							if (AllIDs[i].checked == true) {
								ids[j] = AllIDs[i].value;
								j++;
							}
						}
						popup.confirm('批量下架所选文章吗?','温馨提示',function(action) {
							if (action == 'ok') {
								$.getJSON("/index.php?s=Article/setstatus/status/0/ids/"+ ids, function(data) {
									if (data.status == 1) {
										top.window.location.href = "index.php?s=Article/index";
									} else {
										alert("下线失败！");
									}
								});
							}
						});
						return false;
					});
	// 从newsletter中删除
	$("#delnewsletter_btn").click(
			function() {
				var AllIDs = document.getElementsByName("ids[]");
				var ids = new Array();
				var j = 0;
				for ( var i = 0; i < AllIDs.length; i++) {
					if (AllIDs[i].checked == true) {
						ids[j] = AllIDs[i].value;
						j++;
					}
				}
				popup.confirm('从最新newsletter列表删除吗?', '温馨提示', function(action) {
					if (action == 'ok') {
						// alert(ids.join(";"));
						$.getJSON("/index.php?s=Article/delnewsletter/ids/" + ids, function(data) {
							if (data.status == 1) {
								alert("删除成功！");
							} else {
								alert("删除失败！");
							}
						});
					}
				});
				return false;
			});
	// 我发布的文章
	$("#myadd_btn").click(function() {
		var myaddLink = $(this).attr("link");
		window.location.href = myaddLink;
	});
	//增加文章
	$("#add_btn").click(function() {
		window.location.href = $(this).attr("link");
	});
	
	$("#substitube_btn").click(function() {
		window.location.href = $(this).attr("link");
	});
});