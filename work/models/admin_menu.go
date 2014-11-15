package models

import (
	//"fmt"
	"strconv"
	"strings"
	//"github.com/astaxie/beego/orm"
)

//菜单设计原理：
// id          pid           sorf
// 当前菜单id   上级菜单id     当前菜单级别
//分三级菜单，级别对应1---2----3   一级菜单pid=0  sort=1
//菜单id需要手动编写
//一级   100                      200   ....         一级菜单最后两位数字为0
//二级   110/120/130/1130      210/220/230/2210....  二级菜单最后一位数字为0
//三级   111/121/131/1139      211/221/231/2219....  三级菜单最后一位数字为1-9
//可以通过id快速搜索到菜单树关系
type Admin_menu struct {
	Id         int
	Title      string
	Pid        int
	Sort       int
	Url        string
	Hide       int
	Status     int
	Icon_class string
}
type Admin_menuModel struct {
	BaseModel
}

func NewAdmin_menu() *Admin_menuModel {
	o := &Admin_menuModel{}
	o.tableName = "admin_menu"
	return o
}

//根据级别和pid获取菜单数据
func (this *Admin_menuModel) GetMenuForSoft(pid, sort int) []Admin_menu {
	var menus []Admin_menu
	db.Raw("select * from "+this.tableName+" where pid = ? and sort=?", pid, sort).QueryRows(&menus)
	return menus
}

//获取所有一级菜单数据
func (this *Admin_menuModel) GetParentMenu(rid int) ([]Admin_menu, error) {
	var menu, resMenu []Admin_menu
	_, err := db.Raw("select * from " + this.tableName + " where pid = 0").QueryRows(&menu)
	//超管不限制菜单
	if AdminId == rid {
		return menu, err
	} else {
		if err == nil {
			for _, v := range menu {
				//获取一级菜单下是否有可选的菜单
				if this.GetFristMenuAccess(v.Id, rid) {
					resMenu = append(resMenu, v)
				}
			}
		}
		return resMenu, err
	}

}

//获取一级菜单是否用显示的权限
func (this *Admin_menuModel) GetFristMenuAccess(pid, rid int) bool {
	var count Count
	id := strconv.Itoa(pid)
	leftId := string(id[0])
	//检查下属的二级菜单数目
	db.Raw("select count(*) as counts from access where role_id=" + strconv.Itoa(rid) + " and left(node_id,1)=" + leftId + " and right(node_id,1)>0").QueryRow(&count)
	return (count.Counts > 0)
}

//获取当前url对应的菜单id
func (this *Admin_menuModel) GetThisMenuId(url string) (menuid, pid int) {
	var menu Admin_menu
	err := db.Raw("select * from " + this.tableName + " where url like '%" + url + "%' and pid>0 limit 1").QueryRow(&menu)
	if err != nil {
		return 0, 0
	} else {
		return menu.Id, menu.Pid
	}
}

//获取父级id
func (this *Admin_menuModel) GetFristMenuId(id int) (pid int) {
	if id < 1 {
		return 100 //默认菜单id为100的为默认一级菜单
	} else {
		idString := strconv.Itoa(id)
		Frist := string(idString[0])
		Pid, _ := strconv.Atoi(Frist)
		return Pid * 100
	}
}

//获取右侧的菜单
//id 当前url属于的一级菜单id
//sid 当前url属于的二级菜单id
//m  当前url访问的控制器
//a  当前url访问的控制器方法
func (this *Admin_menuModel) GetLeftMen(id, sid int, url string, SessRoleId int) (h string) {
	var menu, smenu []Admin_menu
	var html, html1, secondClass, menuOpen string
	var i int
	_, err := db.Raw("select * from "+this.tableName+" where status=1 and pid = ?", id).QueryRows(&menu)
	if err == nil {
		for _, v := range menu {
			if v.Id == sid {
				secondClass = "active"
			} else {
				secondClass = ""
			}
			html1 = ""
			html1 += "<li class='" + secondClass + "'><a href='javascript:;'><i class='icon-cogs'></i><span class='title'>" + v.Title + "</span><span class='selected'></span><span class='arrow open'></span></a>"
			_, err := db.Raw("select * from "+this.tableName+" where hide=0 and status=1 and pid = ?", v.Id).QueryRows(&smenu)

			i = 0
			if err == nil {
				html1 += "<ul class='sub-menu'>"

				for _, v1 := range smenu {

					//超管不受限制
					if AdminId == SessRoleId {
						if strings.EqualFold(url, v1.Url) == true {
							menuOpen = "active"
						} else {
							menuOpen = ""
						}
						html1 += " <li class='" + menuOpen + "'><a href='/" + v1.Url + "'>" + v1.Title + "</a></li>"
						i++
					} else {
						if this.GetAccessRoleAction(v1.Url, SessRoleId) == true {

							if strings.EqualFold(url, v1.Url) == true {
								menuOpen = "active"
							} else {
								menuOpen = ""
							}
							html1 += " <li class='" + menuOpen + "'><a href='/" + v1.Url + "'>" + v1.Title + "</a></li>"
							i++
						}
					}
				}

				//html += " <li class='" + menuOpen + "'><a href='/" + v1.Url + "'>" + v1.Title + "</a></li>"
				html1 += "</ul>"
				//fmt.Println(i)
			}
			html1 += "</li>"
			if i > 0 {
				html += html1
			}
		}
	}
	return html
}

//获取URL是否用访问权限
func (this *Admin_menuModel) GetAccessRoleAction(Url string, SessRoleId int) bool {
	if AdminId == SessRoleId {
		return true
	} else {
		var count Count
		Sql := "select count(*) as counts from access a left join " + this.tableName + " b on a.node_id=b.id where a.role_id=" + strconv.Itoa(SessRoleId) + " and b.url like '%" + Url + "%'"
		db.Raw(Sql).QueryRow(&count)
		return (count.Counts > 0)
	}
}
