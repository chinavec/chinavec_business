<?php
/*
 *门户网站访问量和视频点击量统计功能
 */
	require('../../lib/http_client.class.php');
	require('../../lib/db.class.php');
	require('../../lib/log.php');
	
	//统计网站访问数据
	//实例化数据库操作类
	$db = new DB();
	//统计不重复IP
	$sql = "select count(distinct(`user_ip`)) from `site_visit_record`";
	//调用数据库操作类中count函数实行对数据库中数据计数操作
	$visitData = $db->count($sql, $sqlOracle='');
	
	//统计数据存入数据库
	//获取当前时间
	$strtime = date('Y-m-d');
	//将时间变量分割年月日
	$timearray = explode("-",$strtime);
	$year = $timearray[0];
	$month = $timearray[1];
	$day = $timearray[2];
	//设置所需要存储的参数
	$row = array('visit_total' => $visitData, 'terminal' => 1, 'year' => $year, 'month' => $month, 'day' => $day);
	//调用数据库操作类中的insert函数，成功返回"OK"信息，失败返回"ERROR"信息
	if($db->insert('site_visit_statistics', $row)){
		echo 'OK';
	}else{
		echo 'ERROR';
	}
	
	//统计视频点击量
	//统计视频的点击次数，针对不同的video_id进行分别统计
	$sql = "select count(id) as total,video_id from `site_visit_record` where `video_id` <> 0 group by `video_id`";
	//调用数据库操作类中insert函数实行存储数据操作数
	$result = $db->select($sql);
	
	//根据label_id进行循环查询数据库中对应数据
	foreach($result as $item){
		$sql = "SELECT `type_id` FROM `video` WHERE `id` = ".$item->video_id;
		//调用数据库操作类中的select_one函数
		$info = $db->select_one($sql);
		//判断label_id的取值情况，若有对应的label_id则，取出改值，若没有则设为5
		if($info){
			$labelID = $info->type_id;
		}else{
			$labelID = 0;
		}
		
		//统计数据存入video_view_statistics数据表
		//设置存储数据库中的参数
		$row = array('video_id' => $item->video_id, 'type_id' => $labelID, 'view_total' => $item->total, 'year' => $year, 'month' => $month, 'day' => $day, 's_time' => strtotime('now'));
		//调用数据库操作类中insert函数实行存储数据操作数，成功返回"OK"信息，失败返回"ERROR"信息
		if($db->insert('video_view_statistics', $row)){
			echo 'OK';
		}else{
			echo 'ERROR';
			//调用日志函数生成日志
			systemLog('视频点播量统计失败', 1, 5, $db);
		}
	}
	
	//执行完site_visit_statistics和video_view_statistics两个表中的统计后，进行删除site_visit_record表中前一天的所有数据
	/*if($db->delete('site_visit_record', '`visit_time` <'. strtotime('now'))){
		echo "清除site_visit_record表中数据成功";
	}else{
		echo "未能成功清除site_visit_record表中数据";
	}
	//关闭数据库
	$db->close();*/
?>