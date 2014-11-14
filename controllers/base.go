package controllers

import (
	"github.com/astaxie/beego"
	//"github.com/ipfans/beego-pongo2.v2"
	"fmt"
	"strconv"
	"strings"
	"work/models"
)

type BaseController struct {
	beego.Controller
}

type JsonOut struct {
	Status int
	Info   string
	Url    string
}

func (this *BaseController) Menus() {
	url := this.GetThisUrl()
	if url == "" {
		url = "index/index"
	}
	RoleId := 0 //初始
	Id := this.GetSession("role_id")
	if Id != nil {
		RoleId = Id.(int)
	}
	AdminMenu := models.NewAdmin_menu()
	ParentMenu, err := AdminMenu.GetParentMenu(RoleId) //顶级菜单
	if err != nil {
		fmt.Println(err)
	}
	MenuId, SecondId := AdminMenu.GetThisMenuId(url) //当前菜单的id，二级菜单id
	FristId := AdminMenu.GetFristMenuId(MenuId)      //当前菜单所属于的一级菜单id

	LeftMenu := AdminMenu.GetLeftMen(FristId, SecondId, url, RoleId) //左侧菜单
	Nikename := this.GetSession("name")
	if Nikename != nil {
		this.Data["Nikename"] = Nikename
	}
	this.Data["FristId"] = FristId
	this.Data["ParentMenu"] = ParentMenu
	this.Data["LeftMenu"] = LeftMenu
	this.Data["SiteName"] = "我的后台"
	this.Layout = "common/head.html"
	this.NeedLogin()
}

//URL访问权限控制，需要登录的模块加载该函数
func (this *BaseController) GetUrlAuthorith() {
	url := this.GetThisUrl()
	if url == "" {
		url = "index/index"
	}
	if this.GetAccessRoleAction(url) == false {
		this.Ctx.Redirect(302, "/index/index") //默认定向到首页
	}
}

//获取目标路径是否有权限
func (this *BaseController) GetAccessRoleAction(url string) bool {
	RoleId := 0 //初始
	Id := this.GetSession("role_id")
	if Id != nil {
		RoleId = Id.(int)
	}
	AdminMenu := models.NewAdmin_menu()
	return AdminMenu.GetAccessRoleAction(url, RoleId)
}

//字符串过滤函数，用于外部数据过滤
func (this *BaseController) FilterStr(in string) (out string) {
	return in
}

//需要登录
func (this *BaseController) NeedLogin() {
	Suid := this.GetSessUid()
	if Suid < 1 {
		this.Ctx.Redirect(302, "/login/index")
	}
}

//返回uid
func (this *BaseController) GetSessUid() int {
	Uid := 0 //初始
	Id := this.GetSession("uid")
	if Id != nil {
		Uid = Id.(int)
	}
	return Uid
}

//输出异常
func (this *BaseController) SendError(msg string, typeid int) {
	//json输出
	if typeid == 1 {
		var json JsonOut
		json.Status = 0
		json.Info = msg
		this.Data["json"] = json
		this.ServeJson()
	} else {
		this.Data["msg"] = msg
		this.TplNames = "common/error.html"
	}

}

//输出OK数据
func (this *BaseController) SendOk(msg string, typeid int) {
	//json输出
	if typeid == 1 {
		var json JsonOut
		json.Status = 1
		json.Info = msg
		this.Data["json"] = json
		this.ServeJson()
	} else {
		this.Data["msg"] = msg
		this.TplNames = "common/ok.html"
	}
}

//由于框架的this.GetInt为返回int64类型，自定义函数返回int类型的外部数据
func (this *BaseController) GetInt1(key string) int {
	id := 0 //初始
	id_input := this.Input().Get(key)
	id_in, _ := strconv.Atoi(id_input)
	if id_in > 0 {
		id = id_in
	}
	return id
}

//抓取当然请求的URL（不包括数据）
func (this *BaseController) GetThisUrl() string {
	var outurl string
	outurl = ""
	url := this.Ctx.Input.Url()
	urllen := len(url)
	if urllen > 0 {
		for i := 1; i < urllen; i++ {
			outurl += string(url[i])
		}
	}
	return strings.ToLower(outurl)
}
