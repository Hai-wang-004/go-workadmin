var Head = function () {
    return {
        //main function to initiate the module
        initIntro: function () {
            /*
            if ($.cookie('intro_show')) {
                return;
            }
            $.cookie('intro_show', 1);
            */
            //根据url参数获得参数的值
            function QueryStringByName(name){
                var result=window.location.search.match(new RegExp("[\?\&]" + name + "=([^\&]+)", "i"));
                if(result==null || result.length<0)
                {
                    return "";
                }
                return result[1];//返回值是数组形式。该数组的内容依赖于 regexp 是否具有全局标志 g。
            }
            //获取用户列表
            function getUserList(){
                var user_url = $('#user-list').attr("link");
                $.getJSON(user_url,function(json){
                    var number = parseInt(json.count);
                    if(number>0){
                        var userListHtml ='';
                        var userobj = eval(json.list);
                        $(userobj).each(function(index) {
                            //alert(userobj[index].to_uid);
                            if(userobj[index].from_uid==json.to_uid && json.to_uid!="0"){
                                userListHtml +='<li class="active"><a href="#"><div class="col1"><div class="cont"><div class="cont-col1">';
                                userListHtml +='<img src="'+userobj[index].avatar+'" width="40" height="40" alt="">';
                                userListHtml +='</div><div class="cont-col2"><div class="desc">'+userobj[index].from_uname+'</div></div></div></div>';
                                userListHtml +='<div class="col2"><div class="date"><span class="badge"></span></div></div></a></li>';
                                //userListHtml +='<div class="col2"><div class="date">'+userobj[index].add_time+'</div></div></a></li>';
                            }else{
                                userListHtml +='<li><a href="#"><div class="col1"><div class="cont"><div class="cont-col1">';
                                userListHtml +='<img src="'+userobj[index].avatar+'" width="40" height="40" alt="">';
                                userListHtml +='</div><div class="cont-col2"><div class="desc">'+userobj[index].from_uname+'</div></div></div></div>';
                                userListHtml +='<div class="col2"><div class="date"><span class="badge">'+userobj[index].count+'</span></div></div></a></li>';
                                //userListHtml +='<div class="col2"><div class="date">'+userobj[index].add_time+'</div></div></a></li>';
                            }
                        });
                        $('#user-list').empty();
                        $('#user-list').append(userListHtml);
                    }else{
                        return false;
                    }
                });
            }
            /*
            $("button").bind("click",function(){
                $("p").slideToggle();
            });
            */

            //设置顶部消息的通知
            function getMsgNotice(){
                var url = $('#header_inbox_bar .dropdown-toggle').attr("link");
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
                                dropdownmenu +='<li><a href="index.php?m=custservice&a=chat&ts=getusermsg&from=top&uid='+obj[index].from_uid+'">';
                                dropdownmenu +='<span class="photo"><img src="'+obj[index].avatar+'" alt=""/></span>';
                                dropdownmenu +='<span class="subject">';
                                dropdownmenu +='<span class="from">'+obj[index].from_uname+'</span><span class="time">'+obj[index].add_time+'</span>';
                                dropdownmenu +=' </span><span class="message">'+obj[index].content+'</span>';
                                dropdownmenu +='</a></li>';
                            });
                            dropdownmenu += '<li class="external"><a href="index.php?m=custservice&a=chat">查看所有消息<i class="m-icon-swapright"></i></a></li>';
                            $('#header_inbox_bar .dropdown-menu').empty();
                            $('#header_inbox_bar .dropdown-menu').append(dropdownmenu);
                            $.cookie('header_inbox_bar_html', dropdownmenu);
                            //脉动提示
                            $('#header_inbox_bar').pulsate({
                                color: "#dd5131",
                                repeat: 5
                            });
                        }
                    }else{
                        return false;
                    }
                })
            }
            //获取与客服聊天的用户消息内容
            function getUserMsg(){
                var content_url = $('#chats').attr("link");
                $.getJSON(content_url,function(json){
                    var number = parseInt(json.count);
                    if(number>0){

                    }else{
                        return false;
                    }
                })
            }
            $('#user-list .li').bind("click",getUserMsg());
            //当前正在聊天界面，页面头部不需脉动提示
            if(QueryStringByName('m')=="custservice" && QueryStringByName('a')=='chat'){
                //1.定时刷新会话列表
                setInterval(getUserList, 2000);

                //2.定时刷新当前聊天的内容
                setInterval(getUserMsg, 2000);
            }else if(QueryStringByName('a')!='chat'){
                setInterval(getMsgNotice, 10000);
            }

        }

    };

}();