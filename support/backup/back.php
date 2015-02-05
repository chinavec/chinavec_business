<?php 
	/*
	 *数据库备份功能模块
	 *肖亚翠
	 *V1.0
	 *2013-5-14
	 */
	require('../../../lib/db.class.php');
	require('../../../lib/log.php');
	
	//实例化数据库操作类
	$db = new DB();
	//数据库名称、用户权限
	$cfg_dbname = 'cloudmedia';
	$cfg_dbuser = 'root';
	$cfg_dbpwd = '123456';
	$mysql_dir = 'E:/xampp/mysql/';
	// 设置SQL文件保存文件名  
	$filename=date("Y-m-d")."_".$cfg_dbname.".sql";  
	// 所保存的文件名  
	// 获取当前页面文件路径，SQL文件就导出到此文件夹内  
	$tmpFile = (dirname(__FILE__))."\\back\\".$filename;  
	// 用MySQLDump命令导出数据库  
	exec($mysql_dir . "bin/mysqldump -u$cfg_dbuser -p$cfg_dbpwd --default-character-set=utf8 $cfg_dbname > ".$tmpFile);
	//cloudmedia.sql命名复制备份文件，数据库恢复的时候读取改文件
	copy($tmpFile, dirname(__FILE__)."\\back\\cloudmedia.sql"); 
	//调用日志函数生成日志
	systemLog(date('Y-m-d').'备份数据库成功', 1, 2, $db);
	$db->close();
	exit;  
?> 