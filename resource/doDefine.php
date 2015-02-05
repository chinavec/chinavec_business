<?php
	/*
	 *将定义资源信息存入数据库
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/resource.class.php');
	require('../../lib/util.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$u = new Util();
	$db = new DB();
	$b = new Resource($db);
	//设置变量接收POST值
	$name = $u->inputSecurity($_POST['resourceName']);
	$descritpion = $u->inputSecurity($_POST['description']);
    $required = $u->inputSecurity($_POST['required']);
	$b->setValue(array('name' => $name, 'description' => $descritpion,'required' => $required));
	$info = $b->create();
	if($info['operation']){
		//资源定义成功
		systemLog("资源定义成功",1,2,$db);
		header('Location: defineIndex.php?info='.urlencode('资源定义成功'));
	}else{
		//未成功定义资源，跳转到错误信息页面
		systemLog("未成功定义资源",1,5,$db);
		$back = $config['root'] . 'admin/resource/define.php';
		$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}
	//关闭数据库
	$db->close();
?>
