package models

import (
	"fmt"
	"github.com/astaxie/beego/config"
	"github.com/astaxie/beego/orm"
)

var db orm.Ormer
var AdminId int //超管组id
//数据库获取行数结构
type Count struct {
	Counts int
}
type JsonData struct {
	Status int
	Info   string
	Url    string
}

func init() {
	// register model
	orm.Debug = true
	iniconf, err := config.NewConfig("ini", "conf/config.conf")
	if err == nil {
		orm.RegisterModel(new(Role_user), new(Admin_menu), new(Admin), new(Memberwork), new(Role), new(Adminlog))
		orm.RegisterDriver(iniconf.String("db_type"), orm.DR_MySQL)
		conn := iniconf.String("db_user") + ":" + iniconf.String("db_pass") + "@" + "tcp(" + iniconf.String("db_host") + ":" + iniconf.String("db_port") + ")/" + iniconf.String("db_name") + "?charset=" + iniconf.String("db_char")
		maxIdle, _ := iniconf.Int("max_idle")
		maxConn, _ := iniconf.Int("max_conn")
		orm.RegisterDataBase("default", iniconf.String("db_type"), conn, maxIdle, maxConn)
		db = orm.NewOrm()

		AdminId, _ = iniconf.Int("admin_id")
		if AdminId < 1 {
			fmt.Println("Mast set admin_id for conf/config.con!")
		}

	} else {
		fmt.Println(err)
	}
	return
}
