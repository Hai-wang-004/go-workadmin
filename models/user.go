package models

import (
	"fmt"
	"github.com/astaxie/beego/orm"
	_ "github.com/go-sql-driver/mysql" // import your used driver
)

type User struct {
	Id        int
	Uid       int
	Nike_name string
	Pass_code string
	User_mail string
}

// 数据库模型类
type UserModel struct {
	BaseModel
}

func NewUserModel() *UserModel {
	o := &UserModel{}
	o.Init()
	return o
}
func (this *UserModel) Init() {
	this.tableName = "user"
}

////获取一条数据
//func (this *UserModel) GetOne(id int) (u Role_user) {
//	user := Role_user{Id: id}

//	err := db.Read(&user)

//	if err == orm.ErrNoRows {
//		fmt.Println("查询不到")
//	} else if err == orm.ErrMissPK {
//		fmt.Println("找不到主键")
//	}
//	return user
//}

func (this *UserModel) GetOneForEmail(email string) (data User) {
	user := User{User_mail: email}
	err := db.Read(&user)
	if err == orm.ErrNoRows {
		fmt.Println("查询不到email为:" + email + "的用户")
	}
	return user
}
