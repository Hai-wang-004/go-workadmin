package models

import (
	//"fmt"
	"github.com/astaxie/beego"
	_ "github.com/go-sql-driver/mysql" // import your used driver
	"strconv"
	"strings"
	"time"
)

type IndexModel struct {
	BaseModel
}
type Memberwork struct {
	Id        int
	Start     int64
	End       int64
	Title     string
	Admin_uid int
	Task_type int
	Add_admin int
}

type TaskJson struct {
	Id    int
	Title string
	Color string
	Start string
	End   string
}

//任务级别
var TaskType map[int]string = map[int]string{0: "普通", 1: "一般", 2: "紧急"}

func NewIndexModel() *IndexModel {
	o := &IndexModel{}
	o.Init()
	return o
}
func (this *IndexModel) Init() {
	this.tableName = "memberwork"
}

//获取日历json数据
func (this *IndexModel) GetIndexJsonStr(uid int) (j []TaskJson) {
	var work []Memberwork
	//var json_str, fuhao string
	db.Raw("select * from "+this.tableName+" where admin_uid=? order by start desc limit 50", uid).QueryRows(&work)

	var jsonData []TaskJson
	//fmt.Println(times)
	for _, v := range work {
		jsons := TaskJson{}
		jsons.Color = this.GetTaskColor(v.Task_type)
		jsons.Id = v.Id
		jsons.Title = v.Title
		times := beego.Date(time.Unix(v.Start, 0), "Y-m-d H:i:s")
		jsons.Start = times
		if v.End > 0 {
			timee := beego.Date(time.Unix(v.End, 0), "Y-m-d H:i:s")
			jsons.End = timee
		}
		jsonData = append(jsonData, jsons)
	}
	return jsonData
}

//获取任务颜色提示
func (this *IndexModel) GetTaskColor(typeid int) string {
	color := map[int]string{0: "#2071a1", 1: "#F99406", 2: "#B94846"}
	col := color[typeid]
	if typeid > 2 {
		col = color[0]
	}
	return col
}

//获取任务级别html
func (this *IndexModel) GetTaskHtml(id int) string {
	var html string
	for k, v := range TaskType {
		html += "<label><input type='radio'   name='task_type' value='" + strconv.Itoa(k) + "'"
		if k == id {
			html += " checked='checked'"
		}
		html += ">" + v + "</label>&nbsp;&nbsp;"
	}

	return html
}

//转化为时间戳
func (this *IndexModel) GetTimeVal(f_datetime string) int64 {
	times := strings.Split(f_datetime, " ")
	ts := "Mon, " + string(times[2]) + " " + string(times[1]) + " " + string(times[3]) + " " + string(times[4]) + " MST"
	tt, _ := time.Parse(time.RFC1123, ts)
	return tt.Unix()
}

//添加一条任务
func (this *IndexModel) AddOneTask(start, end int64, title string, task_type, uid int) bool {
	data := Memberwork{Start: start, End: end, Title: title, Task_type: task_type, Admin_uid: uid, Add_admin: uid}
	id, err := db.Insert(&data)
	if err == nil {
		if id > 0 {
			return true
		} else {
			return false
		}

	} else {
		return false
	}
}

//修改一条任务(编辑内容)
func (this *IndexModel) EditOneTask(title string, task_type, id int) bool {
	data := Memberwork{Title: title, Task_type: task_type, Id: id}
	_, err := db.Update(&data, "title", "task_type")
	if err == nil {
		return true
	} else {
		return false
	}
}

//修改一条任务(拖动)
func (this *IndexModel) EditOneTaskForTime(s, e int64, id int) bool {
	data := Memberwork{Start: s, End: e, Id: id}
	_, err := db.Update(&data, "start", "end")
	if err == nil {
		return true
	} else {
		return false
	}
}

//查找一条任务数据
func (this *IndexModel) GetOneTaskData(id int) (d Memberwork) {
	data := Memberwork{Id: id}
	db.Read(&data)
	return data
}

//删除一条任务数据
func (this *IndexModel) DelOneTask(id int) bool {
	if _, err := db.Delete(&Memberwork{Id: id}); err == nil {
		return true
	} else {
		return false
	}
}
