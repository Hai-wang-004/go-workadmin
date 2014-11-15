package routers

import (
	"github.com/astaxie/beego"
	"work/controllers"
)

func init() {
	beego.Router("/", &controllers.IndexController{}, "*:Index")
	//beego.Router("/user", &controllers.UserController{})
	//beego.Router("/user/index", &controllers.UserController{}, "*:Index")
	beego.AutoRouter(&controllers.UserController{})
	beego.AutoRouter(&controllers.LoginController{})
	beego.AutoRouter(&controllers.IndexController{})
	beego.AutoRouter(&controllers.AccessController{})
	//beego.Router("/user/Get", &controllers.UserController{})
}
