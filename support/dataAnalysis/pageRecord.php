<?php
/*
 *站点信息记录功能
 */
	require('../../lib/http_client.class.php');
	require('../../lib/db.class.php');
	require('../../lib/log.php');
	
 	//实例化数据库操作类
	$db = new DB();
	
	//测试数据
	//$_GET['page'] = 'http://mobile.clouemedia.com/cloudm/portal/mobile/static/video/videoPlay_215_1.html';
	//判断终端类型（1为PC端，2为手机端），解析网址$_GET['page']
	$urlPrefix = array(
					1	=>	'pc.chinavec.com',
					2	=>	'mobile.chinavec.com'
					
				);
	//默认终端为0
	$terminal = 0;
	
	//循环3种终端类型
	$_GET['page'] = "http://localhost/chinavec/portal/movie.php";
	foreach($urlPrefix as $key => $value){
		//正则表达式判断，和网址信息$_GET['page']有匹配字符串，则设置终端为对应值
		if(preg_match('/'.$value.'/', $_GET['page'])){
			$terminal = $key;
			break;
		}
	}
	//正则表达式获取video的id和video_type的id
	if(preg_match('/videoPlay_([0-9]+)_(\d+)\.html/',$_GET['page'],$match)){
		$videoID = $match[1];
	}else{
		//如果没有视频ID则设置为0（1为微电影，2为微纪录，3为微栏目，4为微动漫，5为创意视频，6为信息视频）
		$videoID = 0;
	}
	//设置参数，给对应参数赋值
	$row = array('user_ip' => getIP(), 'page' => urldecode($_GET['page']), 'terminal' => $terminal, 'video_id' => $videoID, 'visit_time' => strtotime('now'));
	//调用数据库操作类中insert函数实行存储数据操作数，成功返回"OK"信息，失败返回"ERROR"信息
	if($db->insert('site_visit_record', $row)){
		echo "OK";
	}else{
		echo "ERROR";
		//调用日志函数生成日志
		systemLog('站点记录失败', 1, 5, $db);
	}
	//关闭数据库
	$db->close();

//获取客户IP
function getIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
   return($ip);
}

?>