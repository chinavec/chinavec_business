<?php
	/*
	 *服务器监控信息请求并存储结果
	 *肖亚翠
	 *V1.0
	 *2013-4-4
	 */
	@ini_set('default_socket_timeout', 1);//配置超时为1s
	require('../../../config/config.php');
	require('../config/config.php');
	require('../../../lib/http_client.class.php');
	require('../../../lib/db.class.php');
	require('../../../lib/log.php');
	
	//实例化db.class.php文件中的DB类
	$db = new DB();
	$now = strtotime('now');
	
	//IP列表$serviceIP，通过查找server表中IP，从server表中获取server_id
	$sql = "SELECT `server`.`id`,`server`.`ip` FROM `server`";
	$result = $db->select($sql);
	foreach($result as $items){
		$serviceIP = $items->ip;
		$serverID = $items->id; 
		$interfaceAddress = 'http://'.$serviceIP.$config['root'].'admin/support/snmp/serverInfo.php';
		//$fp获取值正常，则operating_state值为1，否则为0；
		$fp = @fopen($interfaceAddress, 'r');//只读形式访问远程服务器监控信息
		if($fp){
			//成功获取信息
			$result = trim(fread($fp, 1000));
			$result = json_decode($result,true);
			$row = array('server_id' => $serverID, 'memory_usage_rate' => $result['memoryUsage'], 'cpu_usage_rate' => $result['cpuUsage'], 'operating_state' => 1, 'thread' => $result['thread'], 'time' => $now);
		}else{
			//获取信息失败，服务器异常
			$row = array('server_id' => $serverID,  'operating_state' => 0, 'time' => $now);
			//日志记录
			systemLog('服务器异常', 1, 5, $db);
		}
		if($db->insert('server_operatioing_info', $row)){
			echo "ture";
		}else{
			echo "false";
		}
	}
	//关闭数据库
	$db->close();
?>