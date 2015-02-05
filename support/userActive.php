<?php
/*
 *在线用户统计功能界面
 */
require('../config/config.php');
require('config/config.php');
require('../lib/db.class.php');
require('../lib/util.class.php');

//是否设置日期，若设置则直接获取，若为设置则设置当天日期
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
//设置当前文件路径变量
$from = $config['root']."support/userActive.php";
//实例化生成页码类
$u = new Util();

//实例化数据库操作类
$db = new DB();
//判断日期的有效性
if($u->validID($year) && $u->validID($month)){
	$year = intval($year);
	$month = intval($month);
	//年和月的有效范围
	if($year >= $dataAnalysisConfig['dataAnalysisStartYear'] && $year <= intval(date('Y')) && $month >= 1 && $month <= 12){
		//用户统计函数
		function userStatistics($year, $month, $db, $u){
			$sql = "SELECT * FROM `user_statistics` WHERE `year` = $year AND `month` = $month";
			$userActive = $db->select($sql);
			$userByDay = array();
			$days = array(31,29,31,30,31,30,31,31,30,31,30,31);
			//判断是否为瑞年
			if($u->isleap($year)){
				$days[1] = 28;
			}
			//值的初始化
			for($i = 0; $i < $days[$month-1]; $i++){
				$userByDay[$i] = 0;
			}
			//循环读取每月中每天的情况
			foreach($userActive as $item){
				$userByDay[$item->day - 1] = $item->user_total;
			}
			return $userByDay;
		}		
	}else{
			//跳转到错误信息页面
			$errorURL =  "../common/error.php?error=".urlencode('没有该月的在线用户量统计信息')."&back=".urlencode($from);
			header("Location: " . $errorURL);
			exit();
	}
}else{
		//跳转到错误信息页面
		$errorURL =  "../common/error.php?error=".urlencode('没有该月的在线用户量统计信息')."&back=".urlencode($from);
		header("Location: " . $errorURL);
		exit();
}

$userByDay = userStatistics($year, $month, $db, $u);
//关闭数据库
$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线用户量统计</title>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../css/common_fang.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="css/userActive.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/userActive.js"></script>
<script type="text/javascript">
	var userByDay = <?php echo json_encode($userByDay); ?>;
	var startYear = <?php echo $dataAnalysisConfig['dataAnalysisStartYear']; ?>;
	var startMonth = <?php echo $dataAnalysisConfig['dataAnalysisStartMonth']; ?>;
</script>
<style>
	#container_left ul li.userActive{background-color:#108dbd;}
	#container_left ul li.userActive a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../img/lbg.gif'></img>").appendTo("#container_left ul li.userActive");
		});
</script>
</head>

<body>
	<?php include('../common/admin_header.php'); ?>
    
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="right">
            <div class="rtf">
				<p><span>在线用户量统计</span></p>
			</div>	
			<div id="u1" class="u1">
				<div id="u1_line" class="u1_line"></div>
			</div>
            <div class="selTittle">
            	<span>选择月份：</span>
                <select id="selectMonth">
                </select>
            </div>
            <p class="caption"><?php echo $year; ?>年<?php echo $month; ?>月统计数据</p>
            <img id="user" />
            <table id="userDetail" class="mytable" style="width:80%;margin-left:10%;marin-top:10px">
                <thead>
                    <tr>
                        <th width="20%">日期</th>
                        <th width="20%">活跃用户数</th>
                        <th width="60%">比例</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($userByDay as $key => $item): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item; ?></td>
                        <td><div class="proportion"></div></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
		</div>
	</div>
   <p align="center" style=" color:#000000; padding-top:1px; font-size:14px;">copyright © 2013-2014 中国微视频协作与交易平台<br/>All Rights Reserved. 中国传媒大学 新媒体研究院</p>
</body>
</html>
