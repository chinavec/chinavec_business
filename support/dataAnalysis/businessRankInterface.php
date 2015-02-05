<?php
/*
 *业务排行测试接口
 *肖亚翠
 *V1.0
 *2013-5-21
 */
	require('../../../lib/http_client.class.php');
	require('../../../lib/db.class.php');
	require('../../../lib/log.php');
	//require('../../../lib/interfaceAccess.php');
	
	//实例化数据库操作类
	$db = new DB();
	//清空数据表之前的数据
	$sql = "delete from `epg_business_rank`";
	//调用数据库操作类中的query函数
	$db->query($sql);
	
  	//作为测试的数据
	//$rank = '[{"view_total":"38","id":"1"},{"view_total":"4","id":"2"}]';
	//从businessRank接口获取排行榜数据
	$rank = $_POST['rank'];
	$rank = json_decode($rank, true);
	//遍历接口传过来的数据，并存储数据库中
	foreach($rank as $key => $item){
		$row = array('business_id' => $item['id'], 'view_total' => $item['view_total'], 'create_time' => strtotime('now'));
		//调用数据库操作类中的insert函数，成功返回“OK”信息，失败返回"ERROR"信息
		if($db->insert('epg_business_rank', $row)){
			echo  'OK';
		}else{
			echo  'ERROR';
			//调用日志函数生成日志
			systemLog('业务排行榜同步门户管理失败', 1, 5, $db);
		}
	}
	$db->close();
?>