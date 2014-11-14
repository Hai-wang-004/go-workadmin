package models

import (
	"time"
)

//管理员操作类型
var adminlogmaps map[int]string = map[int]string{
	1: "维护管理员",
}

// 数据库字段
type Adminlog struct {
	Id         int `beedb:"PK"`
	User_name  string
	Content    string
	Admin_name string
	Add_time   int64
	Type       int
}

// 数据库模型类
type AdminLogModel struct {
	BaseModel
}

func NewAdminLogModel() *AdminLogModel {
	o := &AdminLogModel{}
	o.Init()
	return o
}
func (this *AdminLogModel) Init() {
	this.tableName = "adminlog"
}

//添加管理员日志
func (this *AdminLogModel) AddLog(adminname string, typeid int, content, username string) bool {
	var log Adminlog
	log.User_name = username
	log.Content = content
	log.Type = typeid
	log.Add_time = time.Now().Unix()
	log.Admin_name = adminname
	id, err := db.Insert(&log)
	if err == nil && id > 0 {
		return true
	} else {
		return false
	}
}
