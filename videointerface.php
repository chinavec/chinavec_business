<?php
	require('../../config/config.php');
	require('../../lib/http_client.class.php');

	$interfaceAddress = 'http://'.$config['videoserver'].$config['root'].'/contentdistribution/interface/videoDB.php';//�ӿڵ�ַ  ���ṩ��Ҫ
	$http = new Http_Client();//���ӿڴ��ݲ���,HTTP_CLIENT��,��װ����POST�����ύ
	$http->addPostField('id', $videoID);
	$http->addPostField('title_cn', $titleCN);
	$http->addPostField('use_id', $useID);	
	$http->addPostField('type_id', $typeID);
	$http->addPostField('director', $director); 
	$http->addPostField('produces', $produces);
	$http->addPostField('video_url', $address);
	
	$result = json_decode($http->Post($interfaceAddress), true);
	//echo  $http->Post($interfaceAddress); //�ӿ��ļ��е����.��Ҫ���ڿ���������������û�д���ȥ
	
	//print_r($result);
	//echo $result['code'];
?>