<?php
	/*
	 *将分配资源信息存入数据库
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/distribute.class.php');
	require('../../lib/util.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$u = new Util();
	$db = new DB();
	$b = new Resource($db);
	//设置变量接收POST值
	$server_id = $u->inputSecurity($_POST['server_id']);
    $group_id = $u->inputSecurity($_POST['group_id']);
    $limit_volumeT = $u->inputSecurity($_POST['limit_volumeT']);
	$limit_volume = $limit_volumeT*1024*1024*1024;
	$b->setValue(array('limit_volumeT' => $limit_volumeT,'limit_volume' => $limit_volume, 'group_id' => $group_id, 'server_id' => $server_id));	
	//判断分配容量是否超过资源剩余量
	$result = $db -> select_condition_one('server',array('id' => $server_id));
	$all=$result->volume;
	$str=0;
	$e = $db->select_condition('resource_distribute', array('server_id' => $server_id));
	for($i=0; $i<count($e); $i++){
	$str = $str + $e[$i]->limit_volumeT;
	}
	$re=$all-$str;
	if($limit_volumeT>$re){
		//分配容量超过资源剩余量，跳转到错误信息页面
		systemLog("分配资源，分配资源容量超过资源剩余量",1,5,$db);
		$back = $config['root'] . 'admin/resource/distribute.php';
		$errorURL =  "../../common/error.php?error=".urlencode('分配容量超过资源剩余量')."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}else{
		$info = $b->create();
		if($info['operation']){
			//资源分配成功
			systemLog("资源分配成功",1,2,$db);
			header('Location: distributeIndex.php?info='.urlencode('分配资源成功'));
		}else{
			//未成功分配资源，跳转到错误信息页面
			systemLog("未成功分配资源",1,5,$db);
			$back = $config['root'] . 'admin/resource/distribute.php';
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
		}
	}
	//关闭数据库
	$db->close();
?>
