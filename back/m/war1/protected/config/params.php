<?php
// 配置分成子块，分别规化在目录param中

$params = array();

$d = dirname(__file__);
include $d . '/param/common.php';		// 1 通用配置
include $d . '/param/wow_curl.php';		// 2 wow 采集配置
include $d . '/param/wow_prefer.php';	// 3 偏好配置

return $params;