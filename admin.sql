-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 11 月 14 日 08:13
-- 服务器版本: 5.1.42
-- PHP 版本: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限分配表';

--
-- 转存表中的数据 `access`
--

INSERT INTO `access` (`role_id`, `node_id`, `level`, `pid`, `module`) VALUES
(6, 611, 3, 610, NULL),
(2, 422, 3, 420, NULL),
(2, 421, 3, 420, NULL),
(2, 420, 2, 400, NULL),
(2, 414, 3, 410, NULL),
(2, 413, 3, 410, NULL),
(2, 412, 3, 410, NULL),
(2, 411, 3, 410, NULL),
(2, 410, 2, 400, NULL),
(2, 400, 1, 0, NULL),
(2, 321, 3, 320, NULL),
(2, 320, 2, 300, NULL),
(2, 319, 3, 310, NULL),
(2, 317, 3, 310, NULL),
(2, 316, 3, 310, NULL),
(2, 315, 3, 310, NULL),
(2, 314, 3, 310, NULL),
(2, 312, 3, 310, NULL),
(2, 311, 3, 310, NULL),
(6, 610, 2, 600, NULL),
(5, 611, 3, 610, NULL),
(5, 612, 3, 610, NULL),
(5, 610, 2, 600, NULL),
(5, 600, 1, 0, NULL),
(5, 324, 3, 320, NULL),
(5, 323, 3, 320, NULL),
(5, 322, 3, 320, NULL),
(5, 321, 3, 320, NULL),
(5, 320, 2, 300, NULL),
(5, 315, 3, 310, NULL),
(5, 314, 3, 310, NULL),
(5, 312, 3, 310, NULL),
(5, 311, 3, 310, NULL),
(5, 310, 2, 300, NULL),
(5, 300, 1, 0, NULL),
(5, 265, 3, 260, NULL),
(5, 264, 3, 260, NULL),
(5, 263, 3, 260, NULL),
(5, 262, 3, 260, NULL),
(5, 261, 3, 260, NULL),
(5, 260, 2, 200, NULL),
(5, 242, 3, 240, NULL),
(5, 241, 3, 240, NULL),
(5, 240, 2, 200, NULL),
(5, 236, 3, 230, NULL),
(5, 235, 3, 230, NULL),
(5, 234, 3, 230, NULL),
(5, 233, 3, 230, NULL),
(5, 232, 3, 230, NULL),
(5, 231, 3, 230, NULL),
(5, 230, 2, 200, NULL),
(5, 1217, 3, 210, NULL),
(5, 1215, 3, 210, NULL),
(5, 1214, 3, 210, NULL),
(5, 1218, 3, 210, NULL),
(6, 600, 1, 0, NULL),
(6, 324, 3, 320, NULL),
(2, 310, 2, 300, NULL),
(2, 300, 1, 0, NULL),
(12, 623, 3, 620, NULL),
(12, 621, 3, 620, NULL),
(6, 323, 3, 320, NULL),
(6, 321, 3, 320, NULL),
(6, 320, 2, 300, NULL),
(3, 611, 3, 610, NULL),
(3, 612, 3, 610, NULL),
(3, 610, 2, 600, NULL),
(3, 600, 1, 0, NULL),
(3, 523, 3, 520, NULL),
(3, 521, 3, 520, NULL),
(3, 520, 2, 500, NULL),
(3, 515, 3, 510, NULL),
(3, 513, 3, 510, NULL),
(3, 511, 3, 510, NULL),
(3, 510, 2, 500, NULL),
(3, 500, 1, 0, NULL),
(3, 423, 3, 420, NULL),
(3, 422, 3, 420, NULL),
(3, 421, 3, 420, NULL),
(3, 420, 2, 400, NULL),
(3, 400, 1, 0, NULL),
(3, 324, 3, 320, NULL),
(3, 323, 3, 320, NULL),
(3, 322, 3, 320, NULL),
(3, 321, 3, 320, NULL),
(3, 320, 2, 300, NULL),
(3, 317, 3, 310, NULL),
(3, 316, 3, 310, NULL),
(3, 315, 3, 310, NULL),
(3, 314, 3, 310, NULL),
(3, 312, 3, 310, NULL),
(3, 311, 3, 310, NULL),
(2, 265, 3, 260, NULL),
(2, 264, 3, 260, NULL),
(2, 263, 3, 260, NULL),
(2, 262, 3, 260, NULL),
(2, 261, 3, 260, NULL),
(2, 260, 2, 200, NULL),
(2, 253, 3, 250, NULL),
(2, 252, 3, 250, NULL),
(2, 251, 3, 250, NULL),
(2, 250, 2, 200, NULL),
(2, 242, 3, 240, NULL),
(2, 241, 3, 240, NULL),
(2, 240, 2, 200, NULL),
(2, 236, 3, 230, NULL),
(2, 235, 3, 230, NULL),
(2, 234, 3, 230, NULL),
(2, 233, 3, 230, NULL),
(2, 232, 3, 230, NULL),
(2, 231, 3, 230, NULL),
(2, 230, 2, 200, NULL),
(2, 1213, 3, 210, NULL),
(2, 1217, 3, 210, NULL),
(2, 1216, 3, 210, NULL),
(2, 1215, 3, 210, NULL),
(2, 1214, 3, 210, NULL),
(2, 1212, 3, 210, NULL),
(2, 219, 3, 210, NULL),
(2, 217, 3, 210, NULL),
(2, 215, 3, 210, NULL),
(2, 214, 3, 210, NULL),
(2, 213, 3, 210, NULL),
(2, 212, 3, 210, NULL),
(2, 211, 3, 210, NULL),
(2, 210, 2, 200, NULL),
(2, 200, 1, 0, NULL),
(2, 110, 2, 100, NULL),
(2, 100, 1, 0, NULL),
(12, 620, 2, 600, NULL),
(12, 611, 3, 610, NULL),
(12, 610, 2, 600, NULL),
(12, 600, 1, 0, NULL),
(12, 316, 3, 310, NULL),
(5, 1212, 3, 210, NULL),
(5, 219, 3, 210, NULL),
(5, 217, 3, 210, NULL),
(5, 215, 3, 210, NULL),
(5, 214, 3, 210, NULL),
(25, 242, 3, 240, NULL),
(25, 241, 3, 240, NULL),
(25, 240, 2, 200, NULL),
(25, 215, 3, 210, NULL),
(25, 211, 3, 210, NULL),
(25, 210, 2, 200, NULL),
(25, 200, 1, 0, NULL),
(7, 431, 3, 430, NULL),
(7, 430, 2, 400, NULL),
(7, 400, 1, 0, NULL),
(7, 321, 3, 320, NULL),
(7, 320, 2, 300, NULL),
(7, 312, 3, 310, NULL),
(7, 310, 2, 300, NULL),
(7, 300, 1, 0, NULL),
(12, 315, 3, 310, NULL),
(12, 314, 3, 310, NULL),
(12, 312, 3, 310, NULL),
(12, 310, 2, 300, NULL),
(12, 300, 1, 0, NULL),
(12, 253, 3, 250, NULL),
(12, 252, 3, 250, NULL),
(12, 251, 3, 250, NULL),
(12, 250, 2, 200, NULL),
(12, 242, 3, 240, NULL),
(12, 241, 3, 240, NULL),
(12, 240, 2, 200, NULL),
(12, 236, 3, 230, NULL),
(12, 235, 3, 230, NULL),
(12, 234, 3, 230, NULL),
(12, 233, 3, 230, NULL),
(12, 232, 3, 230, NULL),
(12, 231, 3, 230, NULL),
(12, 230, 2, 200, NULL),
(12, 1213, 3, 210, NULL),
(12, 1217, 3, 210, NULL),
(12, 1216, 3, 210, NULL),
(12, 1215, 3, 210, NULL),
(12, 1214, 3, 210, NULL),
(12, 1212, 3, 210, NULL),
(12, 219, 3, 210, NULL),
(12, 217, 3, 210, NULL),
(13, 200, 1, 0, NULL),
(13, 250, 2, 200, NULL),
(13, 251, 3, 250, NULL),
(13, 252, 3, 250, NULL),
(13, 253, 3, 250, NULL),
(12, 215, 3, 210, NULL),
(12, 214, 3, 210, NULL),
(12, 213, 3, 210, NULL),
(12, 212, 3, 210, NULL),
(12, 211, 3, 210, NULL),
(12, 210, 2, 200, NULL),
(12, 200, 1, 0, NULL),
(7, 242, 3, 240, NULL),
(7, 241, 3, 240, NULL),
(7, 240, 2, 200, NULL),
(7, 1216, 3, 210, NULL),
(7, 1215, 3, 210, NULL),
(7, 1213, 3, 210, NULL),
(7, 1212, 3, 210, NULL),
(7, 1211, 3, 210, NULL),
(7, 215, 3, 210, NULL),
(7, 214, 3, 210, NULL),
(7, 213, 3, 210, NULL),
(7, 212, 3, 210, NULL),
(7, 210, 2, 200, NULL),
(7, 200, 1, 0, NULL),
(7, 110, 2, 100, NULL),
(7, 100, 1, 0, NULL),
(6, 319, 3, 310, NULL),
(6, 314, 3, 310, NULL),
(6, 311, 3, 310, NULL),
(6, 310, 2, 300, NULL),
(6, 300, 1, 0, NULL),
(6, 219, 3, 210, NULL),
(6, 217, 3, 210, NULL),
(3, 310, 2, 300, NULL),
(3, 300, 1, 0, NULL),
(3, 271, 3, 270, NULL),
(3, 272, 3, 270, NULL),
(3, 270, 2, 200, NULL),
(3, 265, 3, 260, NULL),
(3, 264, 3, 260, NULL),
(3, 263, 3, 260, NULL),
(3, 262, 3, 260, NULL),
(3, 261, 3, 260, NULL),
(3, 260, 2, 200, NULL),
(3, 242, 3, 240, NULL),
(3, 241, 3, 240, NULL),
(3, 240, 2, 200, NULL),
(3, 236, 3, 230, NULL),
(3, 235, 3, 230, NULL),
(3, 234, 3, 230, NULL),
(3, 233, 3, 230, NULL),
(3, 232, 3, 230, NULL),
(5, 213, 3, 210, NULL),
(5, 212, 3, 210, NULL),
(5, 211, 3, 210, NULL),
(5, 210, 2, 200, NULL),
(5, 200, 1, 0, NULL),
(3, 231, 3, 230, NULL),
(3, 230, 2, 200, NULL),
(3, 1213, 3, 210, NULL),
(3, 1219, 3, 210, NULL),
(3, 1217, 3, 210, NULL),
(3, 1216, 3, 210, NULL),
(3, 1215, 3, 210, NULL),
(3, 1214, 3, 210, NULL),
(3, 1218, 3, 210, NULL),
(3, 1212, 3, 210, NULL),
(3, 219, 3, 210, NULL),
(3, 217, 3, 210, NULL),
(3, 215, 3, 210, NULL),
(3, 214, 3, 210, NULL),
(3, 213, 3, 210, NULL),
(3, 212, 3, 210, NULL),
(3, 211, 3, 210, NULL),
(27, 200, 1, 0, NULL),
(27, 210, 2, 200, NULL),
(27, 211, 3, 210, NULL),
(27, 212, 3, 210, NULL),
(27, 213, 3, 210, NULL),
(27, 215, 3, 210, NULL),
(27, 217, 3, 210, NULL),
(27, 219, 3, 210, NULL),
(27, 1217, 3, 210, NULL),
(27, 1213, 3, 210, NULL),
(27, 240, 2, 200, NULL),
(27, 241, 3, 240, NULL),
(27, 242, 3, 240, NULL),
(27, 300, 1, 0, NULL),
(27, 310, 2, 300, NULL),
(27, 311, 3, 310, NULL),
(27, 312, 3, 310, NULL),
(27, 314, 3, 310, NULL),
(27, 315, 3, 310, NULL),
(27, 316, 3, 310, NULL),
(27, 317, 3, 310, NULL),
(27, 320, 2, 300, NULL),
(27, 321, 3, 320, NULL),
(27, 322, 3, 320, NULL),
(27, 323, 3, 320, NULL),
(27, 324, 3, 320, NULL),
(3, 210, 2, 200, NULL),
(3, 200, 1, 0, NULL),
(6, 215, 3, 210, NULL),
(6, 214, 3, 210, NULL),
(6, 213, 3, 210, NULL),
(6, 212, 3, 210, NULL),
(6, 211, 3, 210, NULL),
(6, 210, 2, 200, NULL),
(6, 200, 1, 0, NULL),
(2, 423, 3, 420, NULL),
(2, 430, 2, 400, NULL),
(2, 431, 3, 430, NULL),
(2, 600, 1, 0, NULL),
(2, 610, 2, 600, NULL),
(2, 611, 3, 610, NULL),
(29, 611, 3, 610, NULL),
(29, 612, 3, 610, NULL),
(29, 610, 2, 600, NULL),
(29, 600, 1, 0, NULL),
(28, 611, 3, 610, NULL),
(28, 612, 3, 610, NULL),
(28, 610, 2, 600, NULL),
(28, 600, 1, 0, NULL),
(28, 515, 3, 510, NULL),
(28, 514, 3, 510, NULL),
(28, 513, 3, 510, NULL),
(28, 512, 3, 510, NULL),
(28, 511, 3, 510, NULL),
(28, 510, 2, 500, NULL),
(28, 500, 1, 0, NULL),
(28, 321, 3, 320, NULL),
(28, 320, 2, 300, NULL),
(28, 316, 3, 310, NULL),
(28, 315, 3, 310, NULL),
(28, 314, 3, 310, NULL),
(28, 317, 3, 310, NULL),
(28, 311, 3, 310, NULL),
(28, 310, 2, 300, NULL),
(28, 300, 1, 0, NULL),
(1, 1, 1, 1, NULL),
(32, 515, 3, 510, NULL),
(32, 513, 3, 510, NULL),
(32, 511, 3, 510, NULL),
(32, 510, 2, 500, NULL),
(32, 500, 1, 0, NULL),
(32, 431, 3, 430, NULL),
(32, 430, 2, 400, NULL),
(32, 423, 3, 420, NULL),
(32, 422, 3, 420, NULL),
(32, 421, 3, 420, NULL),
(32, 420, 2, 400, NULL),
(32, 414, 3, 410, NULL),
(32, 413, 3, 410, NULL),
(32, 412, 3, 410, NULL),
(32, 411, 3, 410, NULL),
(32, 410, 2, 400, NULL),
(32, 400, 1, 0, NULL),
(32, 321, 3, 320, NULL),
(32, 320, 2, 300, NULL),
(32, 300, 1, 0, NULL),
(32, 262, 3, 260, NULL),
(32, 261, 3, 260, NULL),
(32, 265, 3, 260, NULL),
(32, 264, 3, 260, NULL),
(32, 263, 3, 260, NULL),
(32, 260, 2, 200, NULL),
(32, 244, 3, 240, NULL),
(32, 245, 3, 240, NULL),
(32, 241, 3, 240, NULL),
(32, 242, 3, 240, NULL),
(32, 243, 3, 240, NULL),
(32, 246, 3, 240, NULL),
(32, 240, 2, 200, NULL),
(32, 271, 3, 270, NULL),
(32, 272, 3, 270, NULL),
(32, 273, 3, 270, NULL),
(32, 274, 3, 270, NULL),
(32, 275, 3, 270, NULL),
(32, 270, 2, 200, NULL),
(32, 231, 3, 230, NULL),
(32, 232, 3, 230, NULL),
(32, 233, 3, 230, NULL),
(32, 234, 3, 230, NULL),
(32, 230, 2, 200, NULL),
(32, 200, 1, 0, NULL),
(32, 110, 2, 100, NULL),
(32, 100, 1, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL COMMENT '邮箱地址',
  `nickname` varchar(20) NOT NULL COMMENT '用户昵称',
  `pwd` char(32) NOT NULL COMMENT '密码',
  `remark` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站管理员表' AUTO_INCREMENT=277 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `email`, `nickname`, `pwd`, `remark`) VALUES
(1, 'admin@admin.com', '氪金狗眼', 'e10adc3949ba59abbe56e057f20f883e', '我是超级管理员 ~~'),
(276, 'test@admin.com', '测试员', '96e79218965eb72c92a549dd5a330112', '测试员tester');

-- --------------------------------------------------------

--
-- 表的结构 `adminlog`
--

CREATE TABLE IF NOT EXISTS `adminlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) DEFAULT NULL COMMENT '用户名',
  `content` varchar(255) NOT NULL COMMENT '操作内容',
  `admin_name` varchar(32) NOT NULL COMMENT '管理员名',
  `add_time` int(11) NOT NULL COMMENT '操作时间',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '操作类型',
  PRIMARY KEY (`id`),
  KEY `user_name` (`user_name`),
  KEY `admin_name` (`admin_name`),
  KEY `add_time` (`add_time`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员操作数据表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `adminlog`
--

INSERT INTO `adminlog` (`id`, `user_name`, `content`, `admin_name`, `add_time`, `type`) VALUES
(1, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778017, 1),
(2, '', '修改管理员:', '氪金狗眼', 1415778129, 1),
(3, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778561, 1),
(4, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778568, 1),
(5, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778635, 1),
(6, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778641, 1),
(7, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778842, 1),
(8, '', '修改管理员:金狗眼123', '氪金狗眼', 1415778891, 1),
(9, '', '修改管理员:金狗眼123', '氪金狗眼', 1415779203, 1),
(10, '', '添加管理员:adadad', '氪金狗眼', 1415782060, 1),
(11, '', '添加管理员:11111', '氪金狗眼', 1415782734, 1),
(12, '', '添加管理员:测试员', '氪金狗眼', 1415844849, 1);

-- --------------------------------------------------------

--
-- 表的结构 `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `pid` int(11) unsigned NOT NULL,
  `sort` int(6) NOT NULL,
  `url` varchar(255) NOT NULL,
  `hide` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `icon_class` varchar(50) NOT NULL COMMENT '小图标的样式',
  PRIMARY KEY (`id`),
  KEY `url` (`url`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='后台菜单' AUTO_INCREMENT=613 ;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `title`, `pid`, `sort`, `url`, `hide`, `status`, `icon_class`) VALUES
(100, '我的面板', 0, 1, 'index/index', 0, 1, ''),
(200, '内容', 0, 1, 'goods/index', 0, 1, ''),
(300, '用户', 0, 1, 'user/index', 0, 1, ''),
(400, '系统', 0, 1, 'access/index', 0, 1, ''),
(224, '目录删除', 220, 3, 'cata/delete', 1, 1, ''),
(230, '品牌管理', 200, 2, '', 0, 1, ''),
(410, '角色管理', 400, 2, '', 0, 1, ''),
(411, '角色查看', 410, 3, 'access/rolelist', 0, 1, ''),
(412, '角色添加', 410, 3, 'access/addrole', 0, 1, ''),
(413, '角色编辑', 410, 3, 'access/editrole', 1, 1, ''),
(414, '管理员权限分配', 410, 3, 'access/changerole', 1, 1, ''),
(420, '管理员管理', 400, 2, '', 0, 1, ''),
(421, '管理员查看', 420, 3, 'access/index', 0, 1, ''),
(422, '管理员添加', 420, 3, 'access/addadmin', 0, 1, ''),
(423, '管理员编辑', 420, 3, 'access/editadmin', 1, 1, ''),
(110, '控制台', 100, 2, '', 0, 1, ''),
(111, '我的面板', 110, 2, 'index/index', 0, 1, ''),
(222, '目录添加', 220, 3, 'cata/add', 1, 1, ''),
(223, '目录编辑', 220, 3, 'cata/edit', 1, 1, ''),
(214, '分类删除', 210, 3, 'class/delete', 1, 1, ''),
(220, '目录管理', 200, 2, '', 0, 1, ''),
(221, '目录列表', 220, 3, 'cata/index', 0, 1, ''),
(310, '用户管理', 300, 2, '', 0, 1, ''),
(311, '用户列表', 310, 3, 'user/index', 0, 1, ''),
(317, '用户消息', 310, 3, 'user/index_msg', 0, 1, ''),
(612, '客服历史会话', 610, 3, 'custservice/index', 0, 1, ''),
(314, '用户编辑', 310, 3, 'user/edit', 1, 1, ''),
(315, '便捷用户状态修改', 310, 3, 'user/setstatus', 1, 1, ''),
(316, '用户收货地址', 310, 3, 'user/address', 1, 1, ''),
(246, '商品删除', 240, 3, 'goods/delete', 1, 1, ''),
(263, '专题修改', 260, 3, 'topic/edit', 1, 1, ''),
(264, '专题删除', 260, 3, 'topic/del', 1, 1, ''),
(265, '专题下线/发布', 260, 3, 'topic/setstatus', 1, 1, ''),
(275, '行家之选选定', 270, 3, 'expert/setstatus', 1, 1, ''),
(274, '行家之选删除', 270, 3, 'expert/delete', 1, 1, ''),
(273, '行家之选编辑', 270, 3, 'expert/edit', 1, 1, ''),
(272, '行家之选列表', 270, 3, 'expert/index', 0, 1, ''),
(213, '分类编辑', 210, 3, 'class/edit', 1, 1, ''),
(271, '行家之选添加', 270, 3, 'expert/add', 0, 1, ''),
(270, '行家之选', 200, 2, '', 0, 1, ''),
(240, '商品管理', 200, 2, '', 0, 1, ''),
(430, '管理员行为', 400, 2, '', 0, 1, ''),
(431, '行为日志查看', 430, 3, 'adminlog/index', 0, 1, ''),
(211, '分类列表', 210, 3, 'class/index', 0, 1, ''),
(212, '分类添加', 210, 3, 'class/add', 1, 1, ''),
(321, '留言查看', 320, 3, 'words/index', 0, 1, ''),
(320, '用户留言', 300, 2, '', 0, 1, ''),
(243, '商品编辑', 240, 3, 'goods/edit', 1, 1, ''),
(242, '商品添加', 240, 3, 'goods/add', 0, 1, ''),
(241, '商品列表', 240, 3, 'goods/index', 0, 1, ''),
(234, '品牌删除', 230, 3, 'brand/delete', 1, 1, ''),
(233, '品牌编辑', 230, 3, 'brand/edit', 1, 1, ''),
(210, '分类管理', 200, 2, '', 0, 1, ''),
(500, '调用', 0, 1, 'templatestag/index', 0, 1, ''),
(510, '模板标签', 500, 2, '', 0, 1, ''),
(511, '模板标签列表', 510, 3, 'templatestag/index', 0, 1, ''),
(512, '模板标签添加', 510, 3, 'templatestag/add', 0, 1, ''),
(513, '模板标签编辑', 510, 3, 'templatestag/edit', 1, 1, ''),
(514, '模板标签删除', 510, 3, 'templatestag/del', 1, 1, ''),
(515, '标签位推荐管理', 510, 3, 'templatestag/article', 1, 1, ''),
(260, '专题管理', 200, 2, '', 0, 1, 'icon-th-large'),
(261, '专题查看', 260, 3, 'topic/index', 0, 1, ''),
(262, '专题添加', 260, 3, 'topic/add', 0, 1, ''),
(600, '客服', 0, 1, 'custservice/chat', 1, 1, ''),
(610, '会话管理', 600, 2, '', 0, 1, ''),
(611, '会话窗口', 610, 3, 'custservice/chat', 0, 1, ''),
(245, '商品推荐', 240, 3, 'goods/templatestag', 1, 1, ''),
(244, '上架下架', 240, 3, 'goods/setstatus', 1, 1, ''),
(232, '品牌添加', 230, 3, 'brand/add', 0, 1, ''),
(231, '品牌列表', 230, 3, 'brand/index', 0, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `memberwork`
--

CREATE TABLE IF NOT EXISTS `memberwork` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `start` int(11) NOT NULL COMMENT '开始时间',
  `end` int(11) NOT NULL COMMENT '结束时间',
  `title` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '行程内容',
  `admin_uid` int(8) NOT NULL COMMENT '管理员id',
  `task_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '任务类型：0个人添加，1公司活动，2部门活动，3个人任务',
  `add_admin` int(11) NOT NULL COMMENT '任务添加人',
  PRIMARY KEY (`id`),
  KEY `admin_uid` (`admin_uid`),
  KEY `task_type` (`task_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='管理员工作表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `memberwork`
--

INSERT INTO `memberwork` (`id`, `start`, `end`, `title`, `admin_uid`, `task_type`, `add_admin`) VALUES
(1, 1407168000, 1407203883, '开发', 1, 0, 0),
(2, 1407168000, 1407203894, '开会', 1, 1, 0),
(3, 1409155200, 1409195935, '孟静签到', 1, 2, 0),
(4, 1415116800, 1415116800, 'tetet334444444211', 1, 0, 1),
(5, 1415145600, 1415145600, '上课', 1, 0, 1),
(6, 1414915200, 1414915200, '哈哈', 1, 1, 1),
(7, 1415750400, 1415750400, '啊啊啊啊啊啊啊啊啊啊', 1, 2, 1),
(8, 0, 0, 'fffff555', 0, 2, 0),
(9, 1415318400, 1415404800, '明天吃饭', 1, 2, 1),
(11, 1414627200, 1414627200, '凤飞飞', 1, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限角色表' AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `name`, `pid`, `status`, `remark`) VALUES
(1, '超级管理员', 0, 1, '系统内置超级管理员组，不受权限分配账号限制'),
(28, '测试组1', 1, 1, '测试12'),
(29, '测试2', 1, 1, ''),
(30, '测试3', 1, 0, '发方法');

-- --------------------------------------------------------

--
-- 表的结构 `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户角色表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`) VALUES
(1, 1, 1),
(2, 28, 264),
(3, 29, 3),
(4, 32, 266),
(5, 32, 267),
(6, 32, 268),
(7, 32, 269),
(8, 32, 270),
(9, 32, 271),
(10, 28, 274),
(11, 29, 275),
(12, 28, 276);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `uid` int(11) NOT NULL COMMENT 'UID',
  `nike_name` varchar(32) NOT NULL COMMENT '昵称',
  `real_name` varchar(32) NOT NULL COMMENT '真实姓名',
  `head_img` varchar(64) NOT NULL COMMENT '用户头像信息',
  `pass_code` char(4) NOT NULL COMMENT '密码密钥',
  `user_mail` varchar(64) NOT NULL COMMENT '邮箱',
  `reg_time` int(11) NOT NULL COMMENT '注册时间',
  `phone` char(12) NOT NULL COMMENT '手机',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0男 1女',
  `is_vip` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否vip 0不是，1是',
  `vip_expire_time` int(11) NOT NULL COMMENT 'vip到期时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1正常 0锁定',
  `is_nickname_modified` tinyint(1) NOT NULL DEFAULT '0' COMMENT '昵称是否修改过，1：已修改。',
  `user_birthday` date NOT NULL COMMENT '出生日期',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=46 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `uid`, `nike_name`, `real_name`, `head_img`, `pass_code`, `user_mail`, `reg_time`, `phone`, `sex`, `is_vip`, `vip_expire_time`, `status`, `is_nickname_modified`, `user_birthday`) VALUES
(1, 100000298, 'nicheng', '', '', 'J6pM', '123456@cntv.cn', 1407204060, '0', 0, 0, 0, 1, 0, '0000-00-00'),
(2, 100000300, 'nikename', '', '', 'jbKZ', 'asdfsdf@dnvt.cn', 1407205217, '0', 0, 0, 0, 1, 0, '0000-00-00'),
(3, 100000301, '你好23放放风', '', '', '4X8i', 'xiaopzi12345678901@cntv.cn', 1407205819, '0', 0, 0, 0, 1, 0, '0000-00-00'),
(4, 100000303, '你好2333放22放风', '', '', 'nMpz', 'xiaopzi123456789033111@cntv.cn', 1407288563, '0', 0, 0, 0, 1, 0, '0000-00-00'),
(5, 100000306, '你好点ss封顶', '', '', 't4um', 'xiaopz33i123456789033111@cntv.cn', 1407309018, '0', 0, 0, 0, 1, 0, '0000-00-00'),
(10, 100000110, '333333333', '刘强x', '', 'OVwP', 'xiaopzi12345678@cntv.cn', 1407315690, '15810000000', 0, 0, 0, 0, 0, '1983-01-14'),
(11, 100000332, 'nicheck', '', '', '6Wrp', 'liuqiangxu@cntv.cn', 1407475029, '', 0, 0, 0, 1, 0, '0000-00-00'),
(12, 100000332, 'nicheck222', '', '', 'jDBR', 'liuqiangxu222@cntv.cn', 1407475175, '', 0, 0, 0, 1, 0, '0000-00-00'),
(13, 100000333, 'nicheck222', '', '', 'oXl7', 'liuqiangxu222@cntv.cn', 1407475204, '', 0, 0, 0, 1, 0, '0000-00-00'),
(14, 100000333, 'nicheck222', '', '', 'C3cz', 'liuqiangxu222@cntv.cn', 1407475281, '', 0, 0, 0, 1, 0, '0000-00-00'),
(15, 100000334, 'nicheck222', '', '', 'lmHp', 'liuqiangxu222@cntv.cn', 1407475302, '', 0, 0, 0, 1, 0, '0000-00-00'),
(16, 100000335, 'nicheck222', '', '', 'oWXh', 'liuqiangxu222@cntv.cn', 1407475315, '', 0, 0, 0, 1, 0, '0000-00-00'),
(17, 100000307, 'fnci3', '', '', 'AIbV', 'nikdkd@cnf.cn', 1407897578, '', 0, 0, 0, 1, 0, '0000-00-00'),
(18, 100000308, '33333333', '', '', 'Fpmq', 'liuasdf@cntv.cn', 1407900245, '', 0, 0, 0, 1, 0, '0000-00-00'),
(19, 100000309, 'lsdfasdf', '', '', 'T9Ms', '496023850@qq.com', 1407900437, '', 0, 0, 0, 1, 0, '0000-00-00'),
(20, 100000311, '44444', '', '', 'K98d', '496023850@qq.com', 1407978698, '', 1, 1, 1451581261, 1, 1, '0000-00-00'),
(21, 100000312, 'fsdf', '', '', 'xqXR', 'sdfasdf@qq.com', 1408080865, '', 0, 0, 0, 1, 0, '0000-00-00'),
(22, 100000313, 'liudf', '', '', '9WsC', '496023850@qq.com', 1408094031, '', 0, 0, 0, 1, 0, '0000-00-00'),
(23, 100000314, 'liuff333', '', '', '7E0c', '496023850@qq.com', 1408094427, '', 0, 0, 0, 1, 1, '2014-08-05'),
(24, 100000315, 'krishna', 'aa', '', 'qF5I', '895463962@qq.com', 1408360424, '', 0, 0, 0, 1, 0, '0000-00-00'),
(25, 100000092, '王i红i昌', '', '', 'itUR', 'wanghongchang@jiemian.com', 1408417123, '', 0, 0, 0, 1, 0, '0000-00-00'),
(27, 100000317, '的发送到', '', '', 'UAht', '1522508767@qq.com', 1408424568, '', 0, 0, 0, 1, 0, '0000-00-00'),
(28, 100000318, 'liufdf', '', '', 'JHqM', '1522508767@qq.com', 1408424961, '', 0, 0, 0, 1, 0, '0000-00-00'),
(29, 100000319, '刘芳V大', '', '', 'EYct', '1522508767@qq.com', 1408426415, '', 0, 0, 0, 1, 0, '2014-08-05'),
(30, 100000320, '地方法', '', '', 'qMYu', '1522508767@qq.com', 1408427589, '', 0, 0, 0, 1, 0, '0000-00-00'),
(31, 100000321, '', '', '', 'HUEY', '1522508767@qq.com', 1408427859, '', 0, 0, 0, 1, 1, '2014-08-01'),
(32, 100000062, '123', '', '', '258b', 'wangxin305@cntv.cn', 1408518212, '', 0, 0, 0, 1, 0, '0000-00-00'),
(33, 100000071, '北方z', '', '', 'lVr3', 'lixiaojun@jiemian.com', 1408529105, '', 0, 0, 0, 1, 0, '0000-00-00'),
(34, 100000047, '小清新孟静静', '', '', 'j13H', 'mengjing61@cntv.cn', 1408529757, '', 0, 0, 0, 1, 0, '0000-00-00'),
(35, 100000064, 'test000000000001', '', '', 'xQWF', 'duanrunxiang001@cntv.cn', 1408589495, '', 0, 0, 0, 1, 0, '0000-00-00'),
(39, 100000102, 'pj', '', '', 'kW3c', 'hpj911@hotmail.com', 1408948400, '', 0, 0, 0, 1, 0, '0000-00-00'),
(36, 100000089, 'zp19840201', '', '', 'OvZK', 'zpym520@163.com', 1408604983, '', 0, 0, 0, 1, 0, '0000-00-00'),
(37, 100000048, '121212131', '', '', '9zaj', 'wanghc_1982@cntv.cn', 1408612303, '', 0, 0, 0, 1, 0, '0000-00-00'),
(38, 100000096, 'testjiemian', '', '', 'Ciy0', 'duanrunxiang@jiemian.com', 1408935116, '', 0, 0, 0, 1, 0, '0000-00-00'),
(40, 100000067, '章鱼小宝', '', '', '2JoO', 'zphawk@cntv.cn', 1408949278, '', 0, 0, 0, 1, 0, '0000-00-00'),
(41, 100000121, '郭漫思', '', '', '38kb', 'guomansi@jiemian.com', 1409034521, '', 0, 0, 0, 1, 0, '0000-00-00'),
(42, 100000112, '哒哒111', '', '', 'r0Er', '532558953@qq.com', 1409037123, '', 0, 0, 0, 1, 1, '0000-00-00'),
(43, 100000109, 'jyx', '', '', 'Bxd9', 'jiang886789@163.com', 1409137248, '', 0, 0, 0, 1, 0, '0000-00-00'),
(44, 100000337, '多大房东3', '', '', 'xnVt', '496023850@qq.com', 1409200354, '', 0, 0, 0, 1, 0, '0000-00-00'),
(45, 100000081, 'test00002', '', '', 'zgkn', 'duanrunxiang002@cntv.cn', 1409281135, '', 0, 0, 0, 1, 0, '0000-00-00');
