<?php
/*
 同步video表接口
 */
	require('../lib/http_client.class.php');
	require('../lib/db.class.php');
	//门户管理的接口地址222.31.73.176
	//$interfaceAddress = 'http://' . $config['videoServer'] . $config['root'] .'video/interface/videoDB.php';
	//实例化http post请求类
	$http = new Http_Client();
	//设置传过去的数据
	$http->addPostField('rank', json_encode($rank));
	//用jason传数据
	$result = json_decode($http->Post($interfaceAddress), true);
	//关闭数据库
	print_r($result);
?>