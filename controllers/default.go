package controllers

import (
	"github.com/astaxie/beego"
)

type MainController struct {
	beego.Controller
}

func (this *MainController) Get() {
	this.Data["Website"] = "go后台"
	this.Data["Email"] = "wh6213065@gmail.com"
	this.TplNames = "index1.html"
}
