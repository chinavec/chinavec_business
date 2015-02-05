<?php
	/*
	 *将编辑后的已注册资源信息存入数据库
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/register.class.php');
	require('../../lib/util.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$u = new Util();
	$db = new DB();
	$b = new Resource($db);
	//设置变量接收POST值
	$resource_id = $u->inputSecurity($_POST['resource_id']);	
	$name = $u->inputSecurity($_POST['serverName']);
	$ip = $u->inputSecurity($_POST['serverIp']);
	$descritpion = $u->inputSecurity($_POST['description']);
    $volume = $u->inputSecurity($_POST['volume']);
	$id = isset($_POST['serverID']) ? $_POST['serverID'] : 0;
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置资源id
		$info = $b->setServerID($id);
		if($info['operation']){
			$back = $config['root'] . 'admin/resource/registerModify.php?id=' . $id;
			$b->setValue(array('name' => $name, 'ip' => $ip,'description' => $descritpion,'volume' => $volume,'resource_id'=>$resource_id));
			$result = $b->update();
			if($result['operation']){
				//资源编辑成功
				systemLog("编辑注册资源成功",1,2,$db);
				header("Location: registerIndex.php?info=".urlencode('编辑资源成功'));
			}else{
				//未成功编辑资源信息，跳转到错误信息页面
				systemLog("未成功编辑注册资源",1,5,$db);
				$errorURL =  "../../common/error.php?error=".urlencode($result['info'])."&back=".urlencode($back);
				header("Location: " . $errorURL);
			}
		}else{
			//未成功设置资源id，跳转到错误信息页面
			systemLog("编辑注册资源，未成功设置注册资源id",1,5,$db);
			$back = $config['root'] . 'admin/resource/registerIndex.php';
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
		}
	}else{
		//未找到对应资源id信息，跳转到错误信息页面
		systemLog("编辑注册资源，未找到对应的注册资源信息",1,5,$db);
		$back = $config['root'] . 'admin/resource/registerIndex.php';
		$errorURL =  "../../common/error.php?error=".urlencode("没有找到对应的注册资源信息")."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}
	//关闭数据库
	$db->close();
?>