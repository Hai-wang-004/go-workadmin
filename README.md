go-workadmin
============
欢迎来到Hai-wang-004空间 这是一款语言采用GO开发，框架采用beego,模板使用Metronic的小玩意， 开发它的出发点在于：

熟悉go的web开发模式和beego框架。
结合自己以前其他语言项目（主要是PHP），做出一款易用的后台（虽然go做后台程序并不是那么敏捷）
说明：后台有完整的web系统，目前加入权限，角色，菜单，管理员，首页面板系统，其他系统并未添加，提供一些后台常用的功能。 由于边学习边开发，因此代码风格前后差异较大。

安装： 1. 安装beego框架，安装在$GOPATH/src/github.com/astaxie/下; 2. 下载go-workadmin的zip包（git命令行下载会因为检查包支持而失败：包里没有包含beego框架）; 3. 将包内的work目录放在$GOPATH/src/下; 4. 将work/admin.sql导入进数据库; 5. 修改work/conf/config.conf里数据库配置; 6. 使用命令行 cd $GOPAHT/src/work; 7. 运行项目 bee run

登录： 默认使用http://localhost:8080/可登录。（端口可自己配置） login: admin@admin.com 123456

联系方式 email: wh6213065@gmail.com or 470452970@qq.com
