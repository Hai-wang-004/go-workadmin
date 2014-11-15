package controllers

import (
	//"fmt"
	"github.com/astaxie/beego"
	_ "github.com/go-sql-driver/mysql"
	//"strings"
	"strconv"
	"time"
	"work/models"
)

type IndexController struct {
	BaseController
}

func (this *IndexController) init() {
	this.Menus() //载入当前菜单
}

//我的面板
func (this *IndexController) Index() {
	var ts, ActType string
	this.NeedLogin()       //需要登录
	this.GetUrlAuthorith() //URL访问权限控制

	Data := this.Input()
	IndexModel := models.NewIndexModel()
	ts = Data.Get("ts")
	this.Data["ts"] = ts
	if ts == "add" {
		ActType = Data.Get("type")
		//添加模板输出
		if ActType == "2" {
			this.Data["start"] = Data.Get("start")
			this.Data["end"] = Data.Get("end")
			this.Data["TaskType"] = IndexModel.GetTaskHtml(0)
			this.TplNames = "index/add.html"
		} else if ActType == "3" { //添加数据处理
			var s_time, e_time int64
			title := Data.Get("title")
			if title == "" {
				this.SendError("请输入事件内容", 1)
			} else {
				task_type := 0 //初始
				task_input := Data.Get("task_type")
				task, _ := strconv.Atoi(task_input)
				if task > 0 {
					task_type = task
				}
				start := Data.Get("start")
				end := Data.Get("end")
				s_time = IndexModel.GetTimeVal(start)
				e_time = IndexModel.GetTimeVal(end)

				uid := this.GetSessUid()

				if IndexModel.AddOneTask(s_time, e_time, title, task_type, uid) == true {
					this.SendOk("添加成功", 1)
				} else {
					this.SendError("添加失败", 1)
				}
			}
		} else { //输出请求异常
			this.SendError("参数有误", 1)
		}

	} else if ts == "delete" { //删除
		id := this.GetInt1("id")
		if id > 0 {
			if IndexModel.DelOneTask(id) == true {
				this.SendOk("删除成功", 1)
			} else {
				this.SendError("删除失败.", 1)
			}
		} else {
			this.SendError("参数有误.", 1)
		}
	} else if ts == "edit" {
		ActType = Data.Get("type")
		if ActType == "3" { //修改人物内容
			id := 0 //初始
			id_input := Data.Get("id")
			id_in, _ := strconv.Atoi(id_input)
			if id_in > 0 {
				id = id_in
			} else {
				this.SendError("参数有误.", 1)
			}

			title := Data.Get("title")
			if title == "" {
				this.SendError("请输入事件内容", 1)
			} else {
				task_type := 0 //初始
				task_input := Data.Get("task_type")
				task, _ := strconv.Atoi(task_input)
				if task > 0 {
					task_type = task
				}

				if IndexModel.EditOneTask(title, task_type, id) == true {
					this.SendOk("修改成功", 1)
				} else {
					this.SendError("修改失败", 1)
				}
			}
			//this.Ctx.WriteString("hahahaha")
		} else if ActType == "2" { //修改任务模板显示
			taskId := Data.Get("id")
			if taskId != "" {
				id, _ := strconv.Atoi(taskId)
				taskData := IndexModel.GetOneTaskData(id)
				this.Data["TaskType"] = IndexModel.GetTaskHtml(taskData.Task_type)
				this.Data["Info"] = taskData
				this.TplNames = "index/add.html"
			} else {
				this.Ctx.WriteString("参数有误")
			}

		} else if ActType == "1" { //任务拖动
			var s_time, e_time int64
			taskId := Data.Get("id")
			if taskId != "" {
				id, _ := strconv.Atoi(taskId)
				start := Data.Get("start")
				end := Data.Get("end")
				if end == "" {
					end = start
				}
				s_time = IndexModel.GetTimeVal(start)
				e_time = IndexModel.GetTimeVal(end)
				if e_time < 1 {
					e_time = s_time
				}

				if IndexModel.EditOneTaskForTime(s_time, e_time, id) == true {
					this.SendOk("修改成功", 1)
				} else {
					this.SendError("修改失败", 1)
				}
			} else {
				this.SendError("参数有误.", 1)
			}
		} else { //输出请求异常
			this.SendError("参数有误", 1)
		}
		//this.Ctx.WriteString("hahahaha")
	} else {
		this.init() //实例化控制器
		Uid := this.GetSessUid()
		json_str := IndexModel.GetIndexJsonStr(Uid)

		this.Data["Json_str"] = json_str
		this.Data["day"] = beego.Date(time.Now(), "Y-m-d")
		this.Data["Title"] = "我的面板"
		this.TplNames = "index/index.html"
	}
}
