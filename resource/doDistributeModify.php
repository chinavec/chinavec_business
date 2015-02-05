<?php
	/*
	 *将编辑后的已分配资源信息存入数据库
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
	$id = isset($_POST['distributeID']) ? $_POST['distributeID'] : 0;
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
		systemLog("编辑分配资源，分配资源容量超过资源剩余量",1,5,$db);
		$back = $config['root'] . 'admin/resource/distributeModify.php?id=' . $id;
		$errorURL =  "../../common/error.php?error=".urlencode('分配容量超过资源剩余量')."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}else{
		//判断id值有效性
		if(ctype_digit($id) && $id > 0){
			//查询数据库，设置资源id
			$info = $b->setDistributeID($id);
			if($info['operation']){
				$back = $config['root'] . 'admin/resource/distributeModify.php?id=' . $id;
				$b->setValue(array('limit_volumeT' => $limit_volumeT,'limit_volume' => $limit_volume, 'group_id' => $group_id, 'resource_id' => $resource_id, 'server_id' => $server_id));
				$result = $b->update();
				if($result['operation']){
					//资源编辑成功
					systemLog("编辑分配资源成功",1,2,$db);
					header("Location: distributeIndex.php?info=".urlencode('编辑资源成功'));
				}else{
					//未成功编辑资源信息，跳转到错误信息页面
					systemLog("未成功编辑分配资源",1,5,$db);
					$errorURL =  "../../common/error.php?error=".urlencode($result['info'])."&back=".urlencode($back);
					header("Location: " . $errorURL);
				}
			}else{
				//未成功设置资源id，跳转到错误信息页面
				systemLog("编辑分配资源，未成功设置分配资源id",1,5,$db);
				$back = $config['root'] . 'admin/resource/distributeIndex.php';
				$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
				header("Location: " . $errorURL);
			}
		}else{
			//未找到对应资源id信息，跳转到错误信息页面
			systemLog("编辑分配资源，未找到对应的分配资源信息",1,5,$db);
			$back = $config['root'] . 'admin/resource/distributeIndex.php';
			$errorURL =  "../../common/error.php?error=".urlencode("没有找到对应的分配资源信息")."&back=".urlencode($back);
			header("Location: " . $errorURL);
		}
	}
	//关闭数据库
	$db->close();
?>