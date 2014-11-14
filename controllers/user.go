package controllers

import (
//"fmt"
//"github.com/astaxie/beego"
// "github.com/go-sql-driver/mysql"
//"strings"
//"strconv"
)

type UserController struct {
	BaseController
}

type Testv struct {
	Id   int
	Name string
}

func (this *UserController) init() {
	this.Menus() //载入当前菜单
}

//用户列表
func (this *UserController) Index() {
	//fmt.Println(this.Ctx.Input.Params)

	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	this.init()            //实例化控制器
	this.Data["Title"] = "我的面板"
	this.TplNames = "user/index.html"
}

//JSON响应  不需要页面输出
func (this *UserController) Addval() {
	//fmt.Println(this.Ctx.Input.Params)
	mystruct := &Testv{Id: 1, Name: "aaa"}
	this.Data["json"] = &mystruct
	this.ServeJson()
}
func (this *UserController) Edit() {
	//fmt.Println(this.Ctx.Input.Params)
	this.SendError("请输入参数", 0)
}
func (this *UserController) Get() {
	//this.init("index") //实例化控制器
	//a := &GlobalVal{}

	//r := this.Input()
	////Action = r["action"]
	//for k, v := range r {
	//	fmt.Println("key:", k)
	//	fmt.Println("val:", strings.Join(v, ","))
	//}
	//fmt.Println(r.FormValue("action"))
	//fmt.Println("Action:", r.action)

	//this.TplNames = "user/index.html"

	this.Data["SiteName"] = "我的后台"
	this.TplNames = "common/loginhead.html"
}
