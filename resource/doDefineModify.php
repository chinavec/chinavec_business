<?php
	/*
	 *将编辑后的已定义资源信息存入数据库
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
	$id = isset($_POST['resourceID']) ? $_POST['resourceID'] : 0;
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置资源id
		$info = $b->setResourceID($id);
		if($info['operation']){
			$back = $config['root'] . 'admin/resource/defineModify.php?id=' . $id;
			$b->setValue(array('name' => $name, 'description' => $descritpion, 'required' => $required));
			$result = $b->update();
			if($result['operation']){
				//资源编辑成功
				systemLog("编辑定义资源成功",1,2,$db);
				header("Location: defineIndex.php?info=".urlencode('资源编辑成功'));
			}else{
				//未成功编辑资源信息，跳转到错误信息页面
				systemLog("未成功编辑定义资源",1,5,$db);
				$errorURL =  "../../common/error.php?error=".urlencode($result['info'])."&back=".urlencode($back);
				header("Location: " . $errorURL);
			}
		}else{
			//未成功设置资源id，跳转到错误信息页面
			systemLog("编辑定义资源，未成功设置定义资源id",1,5,$db);
			$back = $config['root'] . 'admin/resource/defineIndex.php';
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
		}
	}else{
		//未找到对应资源id信息，跳转到错误信息页面
		systemLog("编辑定义资源，未找到对应的定义资源信息",1,5,$db);
		$back = $config['root'] . 'admin/resource/defineIndex.php';
		$errorURL =  "../../common/error.php?error=".urlencode("没有找到对应的定义资源信息")."&back=".urlencode($back);
		header("Location: " . $errorURL);
	}
	//关闭数据库
	$db->close();
?>