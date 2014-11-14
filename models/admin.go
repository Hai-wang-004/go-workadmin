package models

import (
	"crypto/md5"
	"encoding/hex"
	"fmt"
	"github.com/astaxie/beego/context"
	"github.com/astaxie/beego/orm"
	"strconv"
	"strings"
	//"work/models"
	//"work/controllers"
)

// 数据库字段
type Admin struct {
	Id       int `beedb:"PK"`
	Email    string
	Nickname string
	Pwd      string
	Remark   string
}

//管理员列表结构
type AdminList struct {
	Id        int `beedb:"PK"`
	Email     string
	Nickname  string
	Pwd       string
	Remark    string
	Role_name string
	Role_id   int
}

//管理员身份
type Role_user struct {
	Id      int
	Role_id int
	Name    string
}
type Roleuser struct {
	Id      int
	Role_id int
	User_id int64
}

//角色组模型
type Role struct {
	Id     int
	Pid    int
	Name   string
	Status int
	Remark string
}

// 数据库模型类
type AdminModel struct {
	BaseModel
}

func NewAdmniModel() *AdminModel {
	o := &AdminModel{}
	o.Init()
	return o
}
func (this *AdminModel) Init() {
	this.tableName = "admin"
}

//获取管理员列表
func (this *AdminModel) GetList(where string, frist, last int) []AdminList {
	var admin []AdminList
	db.Raw("select a.*,c.name as role_name,c.id as role_id from " + this.tableName + " a left join role_user b on a.id=b.user_id left join role c on c.id=b.role_id " + where + " order by id desc limit " + strconv.Itoa(frist) + "," + strconv.Itoa(last)).QueryRows(&admin)
	return admin
}

//获取一个管理员的详细数据
func (this *AdminModel) GetOneAdminData(id int) AdminList {
	var admin AdminList
	db.Raw("select a.*,c.name as role_name,c.id as role_id from "+this.tableName+" a left join role_user b on a.id=b.user_id left join role c on c.id=b.role_id where a.id=?", id).QueryRow(&admin)
	return admin
}

//获取管理员总数
func (this *AdminModel) GetCount(where string) int {
	var count Count
	db.Raw("select count(*) as counts from " + this.tableName + " " + where).QueryRow(&count)
	return count.Counts
}

//获取角色组总数
func (this *AdminModel) GetRoleCount(where string) int {
	var count Count
	db.Raw("select count(*) as counts from role " + where).QueryRow(&count)
	return count.Counts
}

//获取搜索条件
func (this *AdminModel) GetWhere(data *context.Context) string {
	var where string = " where 1 "
	var id int
	data.Input.Bind(&id, "id")
	if id > 0 {
		where += " and id=" + strconv.Itoa(id)
	}
	var name string
	name = data.Input.Query("name")
	if name != "" {
		where += " and name like '%" + name + "%' "
	}
	return where
}

//获取搜索条件
func (this *AdminModel) GetRoleWhere(data *context.Context) string {
	var where string = " where 1 "
	var id int
	data.Input.Bind(&id, "id")
	if id > 0 {
		where += " and id=" + strconv.Itoa(id)
	}
	var name string
	name = data.Input.Query("name")
	if name != "" {
		where += " and name like '%" + name + "%' "
	}
	return where
}

//获取一条数据
func (this *AdminModel) GetOne(id int) (u Admin) {
	admin := Admin{Id: id}
	db.Read(&admin)
	return admin
}

//获取一条数据
func (this *AdminModel) GetRoleOne(id int) (u Role) {
	role := Role{Id: id}
	db.Read(&role)
	return role
}

//根据mail查找管理员数据
func (this *AdminModel) GetOneForEmail(email string) Admin {
	var admin Admin
	db.Raw("select * from " + this.tableName + " where email='" + email + "'").QueryRow(&admin)
	return admin
}

//验证密码是否正确
func (this *AdminModel) TestPwd(inpwd, adminpwd string) bool {
	h := md5.New()
	h.Write([]byte(inpwd))
	str := hex.EncodeToString(h.Sum(nil))
	return strings.EqualFold(str, adminpwd)
}

//加密密码
func (this *AdminModel) Enpwd(pwd string) string {
	h := md5.New()
	h.Write([]byte(pwd))
	newpwd := hex.EncodeToString(h.Sum(nil))
	return newpwd
}

//获得管理员身份资料
func (this *AdminModel) GetAdminRole(uid int) (res Role_user) {
	var admin Role_user
	db.Raw("select role_user.id,role.name,role_user.role_id from role_user left join role on role_user.role_id=role.id where role_user.user_id=?", uid).QueryRow(&admin)
	return admin
}

//获取角色组列表html
func (this *AdminModel) GetRoleSelectHtml(role_id, status int) string {
	var html string = "<select name='role_id'> <option value='0'>请选择..</option>"

	roleList := this.GetAllRoleList(2)

	for _, v := range roleList {
		html += "<option value='" + strconv.Itoa(v.Id) + "' "
		if v.Id == role_id {
			html += " selected='selected' "
		}

		html += ">"
		if v.Pid > 0 {
			html += "&nbsp;&nbsp;&nbsp;&nbsp;├"
		}
		html += v.Name + "</option>"
	}
	html += "</select>"
	return html
}

//获取角色组列表
func (this *AdminModel) GetAllRoleList(status int) []Role {
	var where string = ""
	var role []Role
	if status == 1 {
		where = " where status=1"
	} else if status == 2 {
		where = " where pid=0"
	}
	db.Raw("select * from role " + where + " order by pid asc").QueryRows(&role)

	return role
}

//修改用户资料
func (this *AdminModel) EditOneAdmin(data AdminList) bool {
	var adminData Admin
	oldData := this.GetOneAdminData(data.Id)
	adminData.Id = data.Id
	adminData.Nickname = data.Nickname
	adminData.Remark = data.Remark
	if data.Pwd != "" {
		adminData.Pwd = this.Enpwd(data.Pwd)
	} else {
		adminData.Pwd = oldData.Pwd
	}
	if _, err := db.Update(&adminData, "Nickname", "Remark", "Pwd"); err == nil {
		//修改角色组
		if data.Role_id != oldData.Role_id && data.Role_id > 0 {
			db.Raw("UPDATE role_user SET role_id = " + strconv.Itoa(data.Role_id) + " WHERE user_id =" + strconv.Itoa(data.Id)).Exec()
		}
		return true
	} else {
		return false
	}
}

//添加管理员
func (this *AdminModel) AddOneAdmin(data AdminList) JsonData {
	var adminData Admin
	var json JsonData
	adminData.Nickname = data.Nickname
	adminData.Remark = data.Remark
	adminData.Email = data.Email
	adminData.Pwd = this.Enpwd(data.Pwd)
	count := this.GetCount(" where email='" + data.Email + "'")
	if count > 0 {
		json.Info = "已经存在同名管理员"
		json.Status = 0
		return json
	}
	if id, err := db.Insert(&adminData); err == nil {
		_, err1 := db.Raw("Insert into role_user (user_id,role_id) values (?,?)", id, data.Role_id).Exec()
		fmt.Println("role is :", id)
		if err1 == nil {
			json.Info = "添加成功"
			json.Status = 1

		} else {
			//db.Delete(&Admin{Id: id.(int64)})
			db.Raw("delete from "+this.tableName+" where user_id=?", id).Exec()
			json.Info = "管理员赋予角色失败"
			json.Status = 0
		}

	} else {
		json.Info = "管理员添加失败"
		json.Status = 0
	}
	return json
}

//修改角色组状态
func (this *AdminModel) SetRoleStatus(id int) JsonData {
	var role Role
	var msg string
	var json JsonData
	role.Id = id
	data := this.GetRoleOne(id)
	if data.Id < 1 {
		json.Info = "没有找到角色组"
		json.Status = 1
		return json
	}
	if data.Status == 1 {
		role.Status = 0
		db.Update(&role, "Status")
		msg = "禁用角色组:" + data.Name + "  成功"
	} else {
		role.Status = 1
		db.Update(&role, "Status")
		msg = "启用角色组:" + data.Name + "  成功"
	}

	json.Info = msg
	json.Status = 1
	return json
}

//修改角色组
func (this *AdminModel) EditRole(data Role) JsonData {
	var json JsonData
	var newData Role
	//oldData := this.GetRoleOne(data.Id)
	newData.Id = data.Id
	newData.Name = data.Name
	newData.Remark = data.Remark
	newData.Pid = data.Pid

	count := this.GetRoleCount(" where name='" + data.Name + "' and id !=" + strconv.Itoa(data.Id))
	if count > 0 {
		json.Info = "已经存在同名角色组"
		json.Status = 0
		return json
	}

	if _, err := db.Update(&newData, "Name", "Remark", "Pid"); err == nil {
		json.Info = "修改成功"
		json.Status = 1
		json.Url = "/access/rolelist"
	} else {
		json.Info = "修改失败"
		json.Status = 0
	}
	return json
}

//获取一个角色组全部的权限节点
func (this *AdminModel) GetOneRoleAccess(id int) []orm.Params {
	var maps []orm.Params
	db.Raw("select CONCAT(`node_id`,':',`level`,':',`pid`) as val from access where role_id=" + strconv.Itoa(id)).Values(&maps)
	return maps
}

//获取所有权限数HTML
func (this *AdminModel) GetAllAdminMenuHtml() string {
	var html string = ""
	admin_menu := NewAdmin_menu()
	data1 := admin_menu.GetMenuForSoft(0, 1)
	for _, v1 := range data1 {
		html += " <tr><td style=\"font-size: 14px;\"><label><input name=\"data[]\" level=\"1\" type=\"checkbox\" obj=\"node_" + strconv.Itoa(v1.Id) + "\" value=\"" + strconv.Itoa(v1.Id) + ":1:0\"/> <b>[项目]</b>" + v1.Title + "</label></td></tr>"
		data2 := admin_menu.GetMenuForSoft(v1.Id, 2)
		for _, v2 := range data2 {
			html += "<tr><td style=\"padding-left: 30px; font-size: 14px;\"><label><input name=\"data[]\" level=\"2\" type=\"checkbox\" obj=\"node_" + strconv.Itoa(v1.Id) + "_" + strconv.Itoa(v2.Id) + "\" value=\"" + strconv.Itoa(v2.Id) + ":2:" + strconv.Itoa(v2.Pid) + "\"/><b>[模块]</b>" + v2.Title + "</label></td></tr> <tr><td style=\"padding-left: 50px;\">"
			data3 := admin_menu.GetMenuForSoft(v2.Id, 3)
			for _, v3 := range data3 {
				html += "<label><input name=\"data[]\" level=\"3\" type=\"checkbox\" obj=\"node_" + strconv.Itoa(v1.Id) + "_" + strconv.Itoa(v2.Id) + "_" + strconv.Itoa(v3.Id) + "\" value=\"" + strconv.Itoa(v3.Id) + ":3:" + strconv.Itoa(v3.Pid) + "\"/>"
				if v3.Hide == 1 {
					html += "<span style='color:green;'>" + v3.Title + "</span>"
				} else {
					html += v3.Title
				}
				html += "</label>&nbsp;&nbsp;&nbsp;"
			}
			html += "</td></tr>"
		}
	}
	return html
}

//修改角色组权限
func (this *AdminModel) EditRoleAccess(id int, data []string) bool {
	var sql string = "insert into access(role_id,node_id,level,pid) values "
	idstring := strconv.Itoa(id)
	var fuhao string = ""
	for _, v := range data {
		if v != "" {
			arry := strings.Split(v, ":")
			id := string(arry[0])
			if len(id) > 1 {
				sql += fuhao + "(" + idstring + "," + arry[0] + "," + arry[1] + "," + arry[2] + ")"
				fuhao = ","
			}
		}

	}
	db.Raw("delete from access where role_id = ?", id).Exec()
	_, err := db.Raw(sql).Exec()
	if err == nil {
		return true
	} else {
		return false
	}
}
