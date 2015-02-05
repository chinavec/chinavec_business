<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
    <?php date_default_timezone_set("Asia/Shanghai");?>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css" />

</head>

<?php
    require('../lib/http_client.class.php');
	require('../lib/db.class.php');
	require('../lib/log.php');
	
	//统计网站访问数据
	//实例化数据库操作类
	$db = new DB();
	//统计不重复IP
	$sql = "select count(distinct(`user_ip`)) from `site_visit_record`";
	//调用数据库操作类中count函数实行对数据库中数据计数操作
	$visitData = $db->count($sql, $sqlOracle='');
	
	//统计数据存入数据库
	//获取当前时间
	$strtime = date('Y-m-d');
	//将时间变量分割年月日
	$timearray = explode("-",$strtime);
	$year = $timearray[0];
	$month = $timearray[1];
	$day = $timearray[2];
	//设置所需要存储的参数
	$row = array('visit_total' => $visitData, 'terminal' => 1, 'year' => $year, 'month' => $month, 'day' => $day);
	
	//调用数据库操作类中的insert函数，成功返回"OK"信息，失败返回"ERROR"信息
	if($db->insert('site_visit_statistics', $row)){
		//echo 'OK';
	}else{
		//echo 'ERROR';
	}
 ?>
 
<body>
	<div id="header" style="width:900px;margin:0 auto;">
	<img src="img/vec_logo2.jpg" width=800>
	</div>
	<div id="layout">

<style>
	#layout{ width:970px;margin:0 auto;text-decoration:none; font-family:"微软雅黑"; font-size:18px; text-align:left !important; text-align:center; }
	body{text-align:center}
	a:visited  {color:#FFF;text-decoration:none;}
    a:link {color:#FFF;text-decoration:none;}
	a:active {color:#0FF; text-decoration:none;}
</style>

	<!--banner-->
		<!--导航栏-->
	<?php 
		include "common/table.php";
	?>
	<!--end of 导航栏-->
	<!--end of banner-->
	<div style="height:400px; width:700px; background-color:#000; margin:0 auto; margin-top:80px; clear:both; border-radius: 5px;">
		<p align="center" style="color:#FFF; padding-top:15px; font-size:24px;">新片推荐</p>
		<div style="width:700px;margin:0 auto;">
			<img src="img/poster1.jpg" width="200px" height="280px" style="margin:5px auto auto 25px; float:left"  />
			<img src="img/poster2.jpg" width="200px" height="280px" style="margin:5px auto auto 25px; float:left"  />
			<img src="img/poster3.jpg" width="200px" height="280px" style="margin:5px auto auto 25px; float:left" />
		</div>
	</div>
	
<?php
	require('common/footer.php');
?>
