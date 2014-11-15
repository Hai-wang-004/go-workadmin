package controllers

import (
	//"fmt"
	"work/models"
)

type LoginController struct {
	BaseController
}

func (this *LoginController) init() {
	//this.Menus("login", action) //载入当前菜单
	//this.Layout = "common/loginhead.html"
}

//登录页面
func (this *LoginController) Index() {
	this.Data["Title"] = "登录后台"
	this.TplNames = "login/index.html"
}

//注销
func (this *LoginController) Dologout() {
	//this.SetSession("uid", 0)
	//this.SetSession("role_id", 0)
	sess := this.StartSession()
	sess.Flush()
	this.Ctx.Redirect(302, "/login/index")
}

//登录响应
func (this *LoginController) Dologin() {
	var json JsonOut
	adminModel := models.NewAdmniModel()
	mail := this.FilterStr(this.GetString("email"))
	pwd := this.FilterStr(this.GetString("pwd"))
	Data := adminModel.GetOneForEmail(mail)

	if Data.Id == 0 {
		json.Status = 0
		json.Info = "没有找到该管理员"
	} else {
		if s := adminModel.TestPwd(pwd, Data.Pwd); s == false {
			json.Status = 0
			json.Info = "您输入的密码错误"
		} else {
			this.SetSession("uid", Data.Id)
			this.SetSession("name", Data.Nickname) //昵称
			role := adminModel.GetAdminRole(Data.Id)
			//记录管理员角色组session
			if role.Role_id > 0 {
				this.SetSession("role_id", role.Role_id)
				this.SetSession("role_name", role.Name)
			}

			json.Status = 1
			json.Info = "登录成功"
		}

	}

	this.Data["json"] = json
	this.ServeJson()
}
