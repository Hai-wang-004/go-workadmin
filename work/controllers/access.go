package controllers

import (
	//"encoding/json"
	//"fmt"
	"work/library"
	"work/models"
)

type AccessController struct {
	BaseController
}

func (this *AccessController) init() {
	this.Menus() //载入当前菜单
	//this.Ctx.WriteString("hahahaha")
}

//管理员列表
func (this *AccessController) Index() {

	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	this.init()            //实例化控制器
	admin := models.NewAdmniModel()

	where := admin.GetWhere(this.Ctx)
	count := admin.GetCount(where)

	page := library.NewPageList(this.Ctx, count)
	//page.SetListRows(1) //设置每页显示多少条
	this.Data["Page"] = page.Show()
	//获取list一定要在分页类show()后调用，show()中生成page.FristRows, page.ListRows
	this.Data["List"] = admin.GetList(where, page.FristRows, page.ListRows)
	this.Data["AdminRoleid"] = admin.GetAdminRoleID()
	this.Data["Edit"] = this.GetAccessRoleAction("access/editadmin") //编辑的权限
	this.Data["Title"] = "管理员列表"
	this.TplNames = "access/index.html"

}

//编辑管理员
func (this *AccessController) EditAdmin() {
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	var uid int
	this.Ctx.Input.Bind(&uid, "uid")
	if this.Ctx.Input.IsPost() == true {
		var adminData models.AdminList
		var json JsonOut
		adminData.Id = uid
		pwd1 := this.Ctx.Input.Query("pwd1")
		pwd := this.Ctx.Input.Query("pwd")
		if pwd != "" {
			if pwd != pwd1 {
				this.SendError("两次输入的密码不一致", 1)
				return
			}
		}
		adminData.Pwd = pwd
		adminData.Nickname = this.Ctx.Input.Query("nickname")
		adminData.Remark = this.Ctx.Input.Query("remark")
		var role_id int
		this.Ctx.Input.Bind(&role_id, "role_id")
		if role_id < 1 {
			this.SendError("没有选择角色组", 1)
			return
		}
		adminData.Role_id = role_id
		admin := models.NewAdmniModel()
		if admin.EditOneAdmin(adminData) == true {
			adminLog := models.NewAdminLogModel()
			adminname := this.GetSession("name")
			adminLog.AddLog(adminname.(string), 1, "修改管理员:"+adminData.Nickname, "")
			json.Status = 1
			json.Info = "修改成功"
			json.Url = "/access/index"
		} else {
			json.Status = 0
			json.Info = "修改失败"
		}
		this.Data["json"] = json
		this.ServeJson()

	} else {
		this.init() //实例化控制器

		admin := models.NewAdmniModel()
		adminData := admin.GetOneAdminData(uid)
		this.Data["Info"] = adminData
		this.Data["Role"] = admin.GetRoleSelectHtml(adminData.Role_id, 1)
		this.Data["Title"] = "编辑管理员"
		this.TplNames = "access/adminadd.html"
		//this.Ctx.WriteString("hahahaha")
	}
}

//添加管理员
func (this *AccessController) Addadmin() {
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	if this.Ctx.Input.IsPost() == true {
		var adminData models.AdminList
		//var json JsonOut
		email := this.Ctx.Input.Query("email")
		pwd := this.Ctx.Input.Query("pwd")
		if email == "" {
			this.SendError("请输入邮箱", 1)
			return
		}
		if pwd == "" {
			this.SendError("请输入密码", 1)
			return
		}
		adminData.Pwd = pwd
		adminData.Email = email
		adminData.Nickname = this.Ctx.Input.Query("nickname")
		adminData.Remark = this.Ctx.Input.Query("remark")
		var role_id int
		this.Ctx.Input.Bind(&role_id, "role_id")
		if role_id < 1 {
			this.SendError("没有选择角色组", 1)
			return
		}
		adminData.Role_id = role_id
		admin := models.NewAdmniModel()
		json := admin.AddOneAdmin(adminData)
		if json.Status == 1 {
			adminLog := models.NewAdminLogModel()
			adminname := this.GetSession("name")
			adminLog.AddLog(adminname.(string), 1, "添加管理员:"+adminData.Nickname, "")

			json.Url = "/access/index"
		}
		this.Data["json"] = json
		this.ServeJson()

	} else {
		this.init() //实例化控制器

		admin := models.NewAdmniModel()
		//adminData := admin.GetOneAdminData(uid)
		this.Data["Info"] = &models.AdminList{}
		this.Data["Role"] = admin.GetRoleSelectHtml(0, 1)
		this.Data["Title"] = "添加管理员"
		this.TplNames = "access/adminadd.html"
	}
}

//角色组列表
func (this *AccessController) Rolelist() {
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	this.init()            //实例化控制器

	admin := models.NewAdmniModel()

	this.Data["List"] = admin.GetAllRoleList(0)
	this.Data["Edit"] = this.GetAccessRoleAction("access/editrole")     //编辑的权限
	this.Data["Change"] = this.GetAccessRoleAction("access/changerole") //编辑的权限
	this.Data["AdminRoleid"] = admin.GetAdminRoleID()
	this.Data["Title"] = "角色组查看"
	this.TplNames = "access/rolelist.html"
}

//编辑角色组
func (this *AccessController) Editrole() {
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	admin := models.NewAdmniModel()
	ts := this.Ctx.Input.Query("ts")
	var id int
	this.Ctx.Input.Bind(&id, "id")
	if this.Ctx.Input.IsPost() == true {
		var roleData models.Role
		var pid int
		this.Ctx.Input.Bind(&pid, "role_id")
		roleData.Pid = pid
		roleData.Id = id
		roleData.Name = this.Ctx.Input.Query("name")
		roleData.Remark = this.Ctx.Input.Query("remark")
		if roleData.Name == "" {
			this.SendError("请输入角色组名", 1)
		}
		this.Data["json"] = admin.EditRole(roleData)
		this.ServeJson()
	} else if ts == "setstatus" {
		if id > 0 {
			json := admin.SetRoleStatus(id)
			this.Data["json"] = json
		} else {
			json := JsonOut{Status: 0, Info: "参数不完整"}
			this.Data["json"] = json
		}
		this.ServeJson()
	} else {
		this.init() //实例化控制器
		data := admin.GetRoleOne(id)
		this.Data["Info"] = data
		this.Data["Role"] = admin.GetRoleSelectHtml(data.Pid, 2)
		this.Data["Title"] = "角色组编辑"
		this.TplNames = "access/addrole.html"
	}
}

//角色组权限分配
func (this *AccessController) Changerole() {
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制
	admin := models.NewAdmniModel()
	var id int
	this.Ctx.Input.Bind(&id, "id")
	if this.Ctx.Input.IsPost() == true {
		var json JsonOut
		accessData := make([]string, 0, 2)
		this.Ctx.Input.Bind(&accessData, "data")
		res := admin.EditRoleAccess(id, accessData)
		if res == true {
			if this.GetSession("role_id") == id {
				json.Url = "/login/dologout"
				json.Info = "修改成功，需要重新登录"
				json.Status = 1
			} else {
				json.Url = "/access/rolelist"
				json.Info = "修改成功"
				json.Status = 1
			}
		} else {
			json.Info = "修改失败"
			json.Status = 0
		}
		this.Data["json"] = json
		this.ServeJson()
	} else {
		data := admin.GetRoleOne(id)
		accessAll := admin.GetOneRoleAccess(id)
		this.init() //实例化控制器
		this.Data["Info"] = data
		this.Data["Listhtml"] = admin.GetAllAdminMenuHtml() //权限菜单树
		this.Data["Access"] = accessAll
		this.Data["Title"] = "角色组权限分配"
		this.TplNames = "access/changerole.html"
	}
}
