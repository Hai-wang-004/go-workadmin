package models

import (
//"fmt"
)

type BaseModel struct {
	tableName string
}

// 返回表名
func (this *BaseModel) GetTable() string {
	return this.tableName
}

//返回超管id
func (this *BaseModel) GetAdminRoleID() int {
	return AdminId
}

// // 添加操作
// func (this *BaseModel) Insert() bool {
// 	_, err := db.Raw("insert "+this.tableName+" SET name = ?", "your1111").Exec()
// 	return err != nil
// }

// // 更新操作
// func (this *BaseModel) Update() bool {
// 	_, err := db.Raw("UPDATE "+this.tableName+" SET name = ?", "your23332").Exec()
// 	return err != nil
// }

// // 查询操作
// func (this *BaseModel) Values(sql string) ([]orm.Params, error) {
// 	var maps []orm.Params
// 	_, err := db.Raw(sql).Values(&maps)
// 	return maps, err
// }
// func (this *BaseModel) GetOneData(sql string) (orm.Params, error) {
// 	var maps []orm.Params
// 	_, err := db.Raw(sql).Values(&maps)
// 	return maps[0], err
// }
