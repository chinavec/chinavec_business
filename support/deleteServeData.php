<?php
	/*
	 *服务器监控数据定时清空
	 */
	require('../lib/db.class.php');
	require('../lib/log.php');
	
	//实例化数据库操作类
	$db = new DB();
//每天凌晨1:00，对一天前的服务器监控数据（只保留一天的数据）进行删除
	$db->delete('server_operatioing_info', '`time` <'. (strtotime('now')-200));
	//调用日志函数生成日志
	systemLog(date('Y-m-d').'恢复数据库成功', 1, 2, $db);
	//关闭数据库
	$db->close();
?>
