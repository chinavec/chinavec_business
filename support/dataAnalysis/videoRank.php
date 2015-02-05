<?php
	/*
	 *视频排行接口
	 */

	require('../../lib/http_client.class.php');
	require('../../lib/db.class.php');
	
	//数组变量
	$rank = array();
	//实例化数据库操作类
	$db = new DB();
	//统计过去一周的数据
	$time = strtotime('-1 week');
	//针对除去电视剧的视频类型后其他类型的循环
	$sql = "SELECT * FROM `video_type` ";
	//根据label_id进行循环查询数据库中对应数据
	foreach($db->select($sql) as $key => $item)
	{
		$sql = "select SUM(`view_total`) as total,video_id
				from `video_view_statistics`
				WHERE `s_time` > $time AND `type_id`={$item->id}
				GROUP BY `video_id` ORDER BY `total` DESC LIMIT 20";
		//调用数据库操作类中select函数实行存储数据操作数
		$rank[$item->id] = $db->select($sql);
	};
	//echo json_encode($rank);
	//地址换成门户管理的接口地址
	//$interfaceAddress = 'http://222.31.73.176/chinavec/support/dataAnalysis/rankInterface.php';
	//实例化类
	$http = new Http_Client();
	$http->addPostField('rank', json_encode($rank));
	$result = json_decode($http->Post($interfaceAddress),true);
	//关闭数据库
	$db->close();
?>