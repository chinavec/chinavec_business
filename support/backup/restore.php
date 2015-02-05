<?php
	/*
	 *数据库恢复功能模块
	 *肖亚翠
	 *V1.0
	 *2013-5-10
	 */
 	require('../../../lib/db.class.php');
	require('../../../lib/log.php');
	
	//实例化数据库操作类
	$db = new DB();
	$cfg_dbname = 'cloudmedia';
	$cfg_dbuser = 'root';
	$cfg_dbpwd = '123456';
	$mysql_dir = 'E:/xampp/mysql/';
	// 设置SQL文件保存文件名  
	$filename="cloudmedia.sql";  
	// 所保存的文件名  
	// 获取当前页面文件路径，SQL文件就导出到此文件夹内  
	$backFile = (dirname(__FILE__))."\\back\\".$filename;  
	// 用MySQLDump命令导出数据库  
	exec($mysql_dir . "bin/mysql -u$cfg_dbuser -p$cfg_dbpwd $cfg_dbname < ".$backFile);
	//调用日志函数生成日志
	systemLog(date('Y-m-d').'恢复数据库成功', 1, 2, $db);
	//关闭数据库
	$db->close();
	exit;  
?>