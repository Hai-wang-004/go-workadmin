var Chat = function () {
    //根据url参数获得参数的值
    function QueryStringByName(name){
        var result=window.location.search.match(new RegExp("[\?\&]" + name + "=([^\&]+)", "i"));
        if(result==null || result.length<0)
        {
            return "";
        }
        return result[1];//返回值是数组形式。该数组的内容依赖于 regexp 是否具有全局标志 g。
    }
    var url_model  = QueryStringByName('m');
    var url_action = QueryStringByName('a');
    //url_ts与url_uid 有两种方式设置，一种是从头部提醒点击过来，一种是从左边的用户列表异步点击过来。
    //var url_ts     = QueryStringByName('ts');
    //var url_uid    = QueryStringByName('cuid');

    return {
        //1.定时刷新，设置顶部消息提醒
        initNotice: function () {
            /* if ($.cookie('intro_show')) {return;} $.cookie('intro_show', 1); */
            //获得顶部消息的通知
            function getMsgNotice(){
                var url = "index.php?m=custservice&a=notice"//$('#header_inbox_bar .dropdown-toggle').attr("link");
                $.getJSON(url,function(json){
                    var number = parseInt(json.count);
                    if(number>0){
                        $('#header_inbox_bar .badge').text(number);
                        //与cookie中的msgid匹配，如果不同则重新设置cookie，并且在顶部脉动提示用户。
                        var msgid = new Array();
                        var obj = eval(json.list);
                        $(obj).each(function(index) {
                            msgid.push(obj[index].messageid);
                        });

                        //排序，sort()方法是基于ASCII值进行排序的，故定义一个比较函数
                        msgid = msgid.sort(function(a,b){
                            return a-b;
                        });
                        if($.cookie('intro_msgid')==msgid){
                            $('#header_inbox_bar .dropdown-menu').empty();
                            $('#header_inbox_bar .dropdown-menu').append($.cookie('header_inbox_bar_html'));
                            return false;
                        }else{
                            //重置消息ID的cookie
                            $.cookie('intro_msgid', msgid);
                            //设置dropdown-menu
                            $('#header_inbox_bar .dropdown-menu').empty();
                            var dropdownmenu ='<li><p>你有'+number+'条新消息</p></li>';
                            $(obj).each(function(index) {
                                dropdownmenu +='<li class="msg"><a href="index.php?m=custservice&a=index&cuid='+obj[index].from_uid+'">';
                                dropdownmenu +='<span class="photo"><img src="'+obj[index].avatar+'" alt=""/></span>';
                                dropdownmenu +='<span class="subject">';
                                dropdownmenu +='<span class="from">'+obj[index].from_uname+'</span><span class="time">'+obj[index].add_time+'</span>';
                                dropdownmenu +=' </span><span class="message">'+obj[index].content+'</span>';
                                dropdownmenu +='</a></li>';
                            });
                            dropdownmenu += '<li class="external"><a href="index.php?m=custservice&a=index">查看所有消息<i class="m-icon-swapright"></i></a></li>';
                            $('#header_inbox_bar .dropdown-menu').empty();
                            $('#header_inbox_bar .dropdown-menu').append(dropdownmenu);
                            $.cookie('header_inbox_bar_html', dropdownmenu);
                            //脉动提示
                            $('#header_inbox_bar').pulsate({
                                color: "#dd5131",
                                repeat: 3
                            });
                        }

                    }else{
                        return false;
                    }
                })
            }
            //当不在聊天的页面，设置顶部消息的通知
            if(url_model=='custservice' && url_action=='index'){
                return false;
            }else{
                setInterval(getMsgNotice, 2000);
            }
            /*
            $("#header_inbox_bar ul li.msg").live('click',function(){
                window.location.href = $(this).find("input").val();
            });
            */
        },
        //2.设置用户列表
        initUser:function(){
            var cuid = $('#cuid').val();
            function getUserList(){
                var user_url =  "index.php?m=custservice&a=user&cuid="+cuid; //$('#user-list').attr("link");
                $.getJSON(user_url,function(json){
                    if(json){
                        var number = parseInt(json.count);
                        if(number>0){
                            var userListHtml ='';
                            var userobj = eval(json.list);
                            $(userobj).each(function(index) {
                                //alert(userobj[index].to_uid);
                                if(userobj[index].cuid==json.cuid && json.cuid!="0"){
                                    userListHtml +='<li class="active"><input type="hidden" value="'+userobj[index].cuid+'"/><a href="#"><div class="col1"><div class="cont"><div class="cont-col1">';
                                    userListHtml +='<img src="'+userobj[index].avatar+'" width="40" height="40" alt="">';
                                    userListHtml +='</div><div class="cont-col2"><div class="desc">'+userobj[index].cuname+'</div></div></div></div>';
                                    userListHtml +='<div class="col2"><div class="date"><span class="badge"></span></div></div></a></li>';
                                    //userListHtml +='<div class="col2"><div class="date">'+userobj[index].add_time+'</div></div></a></li>';
                                }else{
                                    userListHtml +='<li><input type="hidden" value="'+userobj[index].cuid+'"/><a href="#"><div class="col1"><div class="cont"><div class="cont-col1">';
                                    userListHtml +='<img src="'+userobj[index].avatar+'" width="40" height="40" alt="">';
                                    userListHtml +='</div><div class="cont-col2"><div class="desc">'+userobj[index].cuname+'</div></div></div></div>';
                                    userListHtml +='<div class="col2"><div class="date"><span class="badge">'+userobj[index].count+'</span></div></div></a></li>';
                                    //userListHtml +='<div class="col2"><div class="date">'+userobj[index].add_time+'</div></div></a></li>';
                                }
                            });
                            $('#user-list').empty();
                            $('#user-list').append(userListHtml);
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                });
            }
            //当在聊天页面，定时获取会话列表
            if(url_model=="custservice" && url_action=='index'){
                //setInterval(getUserList, 2000);
                getUserList();
            }else{
                return false;
            }
        },
        //3.初始化聊天内容
        // 2014/07/13 未完成
        initMsg: function(){
            var cuid = $('#cuid').val(); //用户
            var content_url = "index.php?s=custservice&a=msg&cuid="+cuid; //$('#chats').attr("link");
            function getUserMsg(){
                $.getJSON(content_url,function(json){
                    if(json){
                        var number = parseInt(json.count);
                        var msgHtml = '';
                        if(number>0){
                            var msgObj = eval(json.list);
                            $(msgObj).each(function(index) {
                                if(msgObj[index].from_uid==cuid){
                                    msgHtml += '<li class="in">';
                                }else{
                                    msgHtml += '<li class="out">';
                                }
                                msgHtml += '<img class="avatar" alt="" src="http://cdn-img.easyicon.net/png/5053/505395.png">';
                                msgHtml += '<div class="message"><span class="arrow"></span><a href="#" class="name">'+msgObj[index].from_uname+'</a>';
                                msgHtml += '<span class="datetime">'+msgObj[index].add_time+'</span><span class="body">';
                                msgHtml +=  msgObj[index].content;
                                msgHtml += '</span></div></li>';

                            });
                            $('#chat-list').empty();
                            $('#chat-list').append(msgHtml);
                            /*
                             <li class="out">
                             <img class="avatar" alt="" src="http://cdn-img.easyicon.net/png/5053/505395.png">
                             <div class="message">
                             <span class="arrow"></span>
                             <a href="#" class="name">Lisa Wong</a>
                             <span class="datetime">2014/06/01 11:09</span>
                             <span class="body">
                             Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
                             </span>
                             </div>
                             </li>
                             */
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }

                })
            }
            getUserMsg();
            if(cuid!=''){
                //setInterval(getUserMsg, 200000);
                getUserMsg();
            }else{
                return false;
            }
        },
        //4.发送聊天内容
        //2014/07/13 未完成
        initSentChat: function () {
            var cont = $('#chats');
            var list = $('.chats', cont);
            var form = $('.chat-form', cont);
            var input = $('#right_msg', form);
            var btn = $('.btn', form);
            var handleClick = function (e) {
                e.preventDefault();
                var text = input.val();
                var myface = $('#cface').val();  //客服头像
                var myname  = $('cname').val(); //客服姓名
                var cuid   = $('#cuid').val();  //对方的uid

                if (text.length == 0) {
                    return;
                }
                var time = new Date();
                var time_str = time.toString('MMM dd, yyyy hh:mm');
                var tpl = '';
                tpl += '<li class="out">';
                tpl += '<img class="avatar" alt="" src="'+myface+'"/>';
                tpl += '<div class="message">';
                tpl += '<span class="arrow"></span>';
                tpl += '<a href="#" class="name">'+myname+'</a>&nbsp;';
                tpl += '<span class="datetime">at ' + time_str + '</span>';
                tpl += '<span class="body">';
                tpl += text;
                tpl += '</span>';
                tpl += '</div>';
                tpl += '</li>';
                var msg = list.append(tpl);
                input.val("");
                $('.scroller', cont).slimScroll({
                    scrollTo: list.height()
                });
            }
            btn.click(handleClick);
            input.keypress(function (e) {
                if (e.which == 13) {
                    handleClick();
                    return false; //<---- Add this line
                }
            });
        }
    };
    /*
    function sendMsg(){
        $.ajax({
            type: "GET",
            url: "",
            //将目标和聊天内容发送给msgInsert.php
            data: "dest="+ $("#dest").val() +"&msg="+$("#msg").val(),
            //发送成功后，将内容框清空
            success: function(v){
                $("#msg").val("");
            }
        });
    }
    //点击"发送"按钮的时候发送
    $("input:button").click(sendMsg);
    //在文本框上按回车也能发送
    $("#msg").keypress(function(){
        if(event.keyCode == 13){ //判断按键是回车
            sendMsg();
        }
    });
    */
}();
