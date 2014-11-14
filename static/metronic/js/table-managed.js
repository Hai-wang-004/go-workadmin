
var TableManaged = function () {
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            // begin article_list_1 table
            $('#articlelist_1').dataTable({
                //"bProcessing": true,
                "bServerSide": true,
                //"bDestory": true,
                "bPaginate" : true, //是否显示分页
                "bLengthChange" : false, //是否允许用户通过一个下拉列表来选择分页后每页的行数。行数为 10，25，50，100。这个设置需要 bPaginate 支持。默认为 true
                "bInfo" : true,

                "iDisplayLength": 10, //每页行数
                //多语言配置
                "oLanguage": {
                    "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "前一页",
                        "sNext": "后一页",
                        "sLast": "尾页"
                    },
                    "sSearch":"搜索："
                },
                "sPaginationType": "bootstrap", //分页样式
                "sAjaxSource": "?m=article&a=index", //"http://seradmin.com.cn/index.php?s=Article/index",
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                //使用post方式传递数据
                "fnServerData": function ( sAjaxSource, aoData, fnCallback ) {
                    $.ajax( {
                        "dataType": 'json',
                        "type": "POST",
                        "url": sAjaxSource,
                        "data": aoData,
                        "success": fnCallback
                    } );
                },
                "aoColumns": [
                    {
                        "mDataProp": "checkone",
                        "bSortable": false,
                        "bSearchable":false
                    },
                    {   "mDataProp": "id",
                        "bSortable": true,
                        "bSearchable":false
                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "title",
                        "bSortable": true,
                        "bSearchable":true
                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "genre",
                        "bSortable": true,
                        "bSearchable":false
                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "cids",
                        "bSortable": false,
                        "bSearchable":false
                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "weights",
                        "bSortable": true,
                        "bSearchable":false

                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "img",
                        "bSortable": false,
                        "bSearchable":false
                    },
                    {
                        "sClass": "center hidden-480",
                        "mDataProp": "publishtime_str",
                        "bSortable": true,
                        "bSearchable":false
                    },
                    {
                        "sClass": "",
                        "mDataProp": "myaction",
                        "bSortable": false,
                        "bSearchable": false
                    }
                ]
            });

            jQuery('#articlelist_1 .group-checkable').change(function () {
                var set = jQuery(this).attr("data-set");
                var checked = jQuery(this).is(":checked");
                jQuery(set).each(function () {
                    if (checked) {
                        $(this).parent().addClass("checked"); //为span增加选择样式
                        $(this).attr("checked", true);
                    } else {
                        $(this).parent().removeClass("checked"); //为span删除选择样式
                        $(this).attr("checked", false);
                    }
                });
                jQuery.uniform.update(set);
            });
            jQuery('#articlelist_1_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
            jQuery('#articlelist_1_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
            //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
        }
    };
}();