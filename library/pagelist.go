package library

import (
	//"fmt"
	"github.com/astaxie/beego/context"
	"math"
	"regexp"
	"strconv"
	"strings"
)

type PageList struct {
	Url        string           //当然页面URL
	Input      *context.Context //输入输出对象
	RolePage   int              //分页HTML显示的页数
	ListRows   int              //默认列表页显示行数
	FristRows  int              //开始行数
	TotalPages int              //页码总数
	TotalRows  int              //数据总行数
	NowPage    int              //当前页码
	CoolPage   int              //分页栏的总页数
}

//初始化
func NewPageList(ctx *context.Context, count int) *PageList {
	o := &PageList{}
	o.Input = ctx
	o.Url = o.Input.Input.Uri()

	var page int
	o.Input.Input.Bind(&page, "page")
	//当前页码
	if page < 1 {
		o.NowPage = 1
	} else {
		o.NowPage = page
	}
	o.ListRows = 20     //每页多少条
	o.RolePage = 5      //分页栏显示几条页码
	o.TotalRows = count //数据总数

	return o
}

//页码显示
func (this *PageList) Show() string {
	var html, upPage, downPage, theFirst, theEnd, linkPage string = "", "", "", "", "", ""
	if this.TotalRows == 0 {
		return html
	}

	this.TotalPages = LibCeilInt(this.TotalRows, this.ListRows) //页码总数
	//如果页码大于分页总数，则页码为分页总数
	if this.NowPage > this.TotalPages {
		this.NowPage = this.TotalPages
	}
	this.FristRows = this.ListRows * (this.NowPage - 1) //开始页码
	//上下页
	upRow := this.NowPage - 1
	downRow := this.NowPage + 1
	html += "<div class=\"row-fluid\"><div class=\"span6\"><div class=\"dataTables_info\" id=\"sample_2_info\">总共 " + strconv.Itoa(this.TotalRows) + "条数据 "
	html += strconv.Itoa(this.NowPage) + "/" + strconv.Itoa(this.TotalPages) + " 页 </div></div><div class=\"span6\"><div class=\"dataTables_paginate paging_bootstrap pagination\"><ul>"
	if upRow > 0 {
		upPage += "<li><a href='" + this.GetPageUrl(upRow) + "'> <span class=\"hidden-480\">上一页</span></a></li>"
	}
	if downRow <= this.TotalPages {
		downPage += "<li><a href='" + this.GetPageUrl(downRow) + "'> <span class=\"hidden-480\">下一页</span></a></li>"
	}
	//有多页码
	nowCoolPage := LibCeilInt(this.NowPage, this.RolePage)

	if this.NowPage > 1 {
		//preRow := this.NowPage - this.RolePage
		//prePage += "  <li class=\"prev disabled\"><a href='" + this.GetPageUrl(preRow) + "' title=''>← <span class=\"hidden-480\">上" + strconv.Itoa(this.RolePage) + "页</span></a></li>"
		theFirst += "<li class=\"prev \"><a href='" + this.GetPageUrl(1) + "' > <span class=\"hidden-480\">第一页</span></a></li>"
	}
	//有下一页
	if nowCoolPage < this.TotalPages && this.NowPage < this.TotalPages {
		//nextRow := this.NowPage + this.RolePage
		//nextPage += "  <li class=\"next\"><a href='" + this.GetPageUrl(nextRow) + "' title=''>← <span class=\"hidden-480\">下" + strconv.Itoa(this.RolePage) + "页</span></a></li>"
		theEnd += "<li class=\"next \"><a href='" + this.GetPageUrl(this.TotalPages) + "' > <span class=\"hidden-480\">最后一页</span></a></li>"
	}
	//页码
	for i := 1; i <= this.RolePage; i++ {
		page := (nowCoolPage-1)*this.RolePage + i

		if page > this.TotalPages {
			continue
		}
		if page != this.NowPage {
			//if page <= this.RolePage {
			linkPage += "<li><a href='" + this.GetPageUrl(page) + "'>" + strconv.Itoa(page) + "</a></li>"
			//}
		} else {
			if this.RolePage != 1 {
				linkPage += "<li class='active'><a href='#'>" + strconv.Itoa(page) + "</a></li>"
			}
		}
	}
	html += theFirst + upPage + linkPage + downPage + theEnd
	html += "</ul></div></div></div>"

	return html
}

//设置页面每页显示多少条数据
func (this *PageList) SetListRows(row int) {
	this.ListRows = row
}

//求整除的整数
func LibCeilInt(a, b int) int {
	c, _ := math.Modf(float64(a / b))
	d := a % b
	if int(d) > 0 {
		c++
	}
	return int(c)
}

//获取指定page页码的url
func (this *PageList) GetPageUrl(page int) string {
	var str string
	reg := regexp.MustCompile(`page=(\d)*`)
	str = reg.ReplaceAllString(this.Url, "page="+strconv.Itoa(page))
	if strings.Contains(str, "page=") == false {
		if strings.Contains(str, "?") == false {
			str = str + "?page=" + strconv.Itoa(page)
		} else {
			str = str + "&page=" + strconv.Itoa(page)
		}
	}
	return str
}
