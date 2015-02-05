<?php 
     require('../cloudm/config/config.php');
	 require('../cloudm/lib/http_client.class.php');
	 $interfaceAddress = 'http://' . $config['videoserver'] . $config['root'] .
					      'contentdistribution/interface/videoBD.php';
	 $http = new Http_Client();
     $http->addPostField('video_id', $id);//$id为新建后的video_id值
	 
     $http->addPostField('type', 1); //1-新建；2-修改；3-删除
	 
	 $http->addPostField('video', array('id'=>$id ,'title_cn'=>$title_cn ,'use_id'=>$useId ,'type_id'=>$typeId ,'director'=>$director ,'produces'=>$produces ));
	 
		//$http->Post($cmsConfig['cmsSynchronousAddress']);
		
	 $result = json_decode($http->Post($interfaceAddress), true);
	 print_r($result);

?>