<?php
/*
 *视频排行测试接口
 *肖亚翠
 *V1.0
 *2013-4-11
 */
	require('../../../lib/http_client.class.php');
	require('../../../lib/db.class.php');
	require('../../../lib/interfaceAccess.php');
	require('../../../lib/log.php');
	
	//实例化数据库操作类
	$db = new DB();
	//清空数据表之前的数据
	$sql = "delete from `epg_video_rank`";
	//调用数据库操作类中的query函数
	$db->query($sql);
	
/*  	//作为测试的数据
		$rank = '{"1":[{"total":"60","video_id":"2"},{"total":"14","video_id":"1"}],
		"2":[{"total":"22","video_id":"2"},{"total":"4","video_id":"1"}],
		"3":[],
		"4":[],
		"5":[]}';
 */	
	//从videoRank接口获取排行榜数据
	$rank = $_POST['rank'];
	$rank = json_decode($rank, true);
	//遍历二维数组
	//第一层循环遍历一维数组label_id
	//第二层循环遍历二维数组中的数据信息
	foreach($rank as $key => $item){
		foreach($item as $item1){
			$row = array('video_id' => $item1['video_id'], 'label_id' => $key, 'view_total' => $item1['total'], 'create_time' => strtotime('now'));
			//调用数据库操作类中的insert函数，成功返回"OK"信息，失败返回"ERROR"信息
			if($db->insert('epg_video_rank', $row)){
				echo  'OK';
			}else{
				echo  'ERROR';
				//调用日志函数生成日志
				systemLog('点播视频排行榜同步门户管理失败', 1, 5, $db);
			}
		}
	}
	//关闭数据库
	$db->close();
?>