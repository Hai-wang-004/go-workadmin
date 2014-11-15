package main

import (
	"github.com/astaxie/beego"
	//"github.com/astaxie/beego/session"
	"html/template"
	"mime"
	"net/http"
	_ "work/routers"
)

func page404(rw http.ResponseWriter, r *http.Request) {
	t, _ := template.New("404.html").ParseFiles(beego.ViewsPath + "/common/404.html")
	data := make(map[string]interface{})
	// data["content"] = "page not found"
	t.Execute(rw, data)
}

func main() {
	//	beego.AutoRender = false
	beego.ViewsPath = "tpl" //模板存储目录
	beego.SessionOn = true  //SESSION开启

	mime.AddExtensionType(".css", "text/css")              //CSS 输出页头Content-Type
	mime.AddExtensionType(".js", "application/javascript") //JS 输出页头Content-Type
	beego.SetStaticPath("/static", "static")               //注册静态文件目录
	beego.Errorhandler("404", page404)
	beego.Run()
}
