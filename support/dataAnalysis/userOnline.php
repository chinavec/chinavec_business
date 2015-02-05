<?php
/*
 *在线用户量统计功能
 */

	require('../../lib/http_client.class.php');
	require('../../lib/db.class.php');
	require('../../lib/log.php');
	
	//获取当前时间
	$strtime = date('Y-m-d');
	//将时间变量分割年月日
	$timearray = explode("-",$strtime);
	$year = $timearray[0];
	$month = $timearray[1];
	$day = $timearray[2];
	
	//实例化数据库操作类
	$db = new DB();
	//测试
	//$sql = "select count(*) from `site_visit_record` where `visit_time` >= ".$strtime;//`visit_time`大于等于当天凌晨的时间，即当天的时间

	//从user数据表中的login_time判断当天时间的登录用户数
	$sql = "select count(*) from `user` where `login_time` >= ".$strtime;//`login_time`大于等于当天凌晨的时间，即当天的时间
	$userData = $db->count($sql, $sqlOracle='');
	
	//统计当天用户数据存入user_statistics数据表	
	//设置存储数据库中的参数
	$row = array('user_total' => $userData, 'year' => $year, 'month' => $month, 'day' => $day);
	//调用数据库操作类中insert函数实行存储数据操作数，成功返回"OK"信息，失败返回"ERROR"信息
	if($db->insert('user_statistics', $row)){
		echo "OK";
	}else{
		echo "ERROR";
		//调用日志函数生成日志
		systemLog('在线用户量统计失败', 1, 5, $db);
	}
	//关闭数据库
	$db->close();
 ?>