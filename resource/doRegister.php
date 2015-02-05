<?php
	/*
	 *将注册资源信息存入数据库
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
	$b->setValue(array('name' => $name, 'ip' => $ip,'description' => $descritpion,'volume' => $volume,'resource_id'=>$resource_id));
	$info = $b->create();
	if($info['operation']){
		//资源注册成功
		systemLog("资源注册成功",1,2,$db);
		header('Location: registerIndex.php?info='.urlencode('注册资源成功'));
	}else{
		//未成功定义资源，跳转到错误信息页面
		systemLog("未成功注册资源",1,5,$db);
		$back = $config['root'] . 'admin/resource/register.php';
		$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}
	//关闭数据库
	$db->close();
?>
