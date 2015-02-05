<?php
	require('../../config/config.php');
	require('../../lib/http_client.class.php');

	$interfaceAddress = 'http://'.$config['videoserver'].$config['root'].'/contentdistribution/interface/videoDB.php';//接口地址  问提供方要
	$http = new Http_Client();//给接口传递参数,HTTP_CLIENT类,封装好了POST数据提交
	$http->addPostField('id', $videoID);
	$http->addPostField('title_cn', $titleCN);
	$http->addPostField('use_id', $useID);	
	$http->addPostField('type_id', $typeID);
	$http->addPostField('director', $director); 
	$http->addPostField('produces', $produces);
	$http->addPostField('video_url', $address);
	
	$result = json_decode($http->Post($interfaceAddress), true);
	//echo  $http->Post($interfaceAddress); //接口文件中的输出.主要用于看数据请求数据有没有传过去
	
	//print_r($result);
	//echo $result['code'];
?>