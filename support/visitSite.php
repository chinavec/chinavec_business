
<?php
/*
 *门户访问量统计功能界面
 */
require('../config/config.php');
require('config/config.php');
require('../lib/db.class.php');
require('../lib/util.class.php');



//是否设置日期和类型终端，若设置则直接获取，若为设置则设置当天日期
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$terminal = isset($_GET['terminal']) ? $_GET['terminal'] : 1;
//设置当前文件路径变量
$from = $config['root']."support/visitSite.php";
$u = new Util();

//实例化数据库操作类
$db = new DB();

//验证日期的合法性和正确性

if($u->validID($year) && $u->validID($month) && $u->validID($terminal)){
	$year = intval($year);//intval()变量转成整数类型
	$month = intval($month);
	$terminal = intval($terminal);
	//年和月的有效范围
	if($year >= $dataAnalysisConfig['dataAnalysisStartYear'] && $year <= intval(date('Y')) && $month >= 1 && $month <= 12){
		//站点统计函数
		function siteStatistics($year, $month, $terminal, $db, $u){
			$sql = "SELECT * FROM `site_visit_statistics` WHERE `year`=$year AND `month` = $month AND `terminal`=$terminal";
			$visitSite = $db->select($sql);
			$siteByDay = array();
			$days = array(31,29,31,30,31,30,31,31,30,31,30,31);
			//判断是否为瑞年
			if($u->isleap($year)){
				$days[1] = 28;
			}
			//值的初始化
			for($i = 0; $i < $days[$month-1]; $i++){
				$siteByDay[$i] = 0;
			}
			//循环读取每月中每天的情况
			foreach($visitSite as $item){
				$siteByDay[$item->day - 1] = $item->visit_total;
			}
			return $siteByDay;
		}
	}else{
			//跳转到错误信息页面
			$errorURL =  "../common/error.php?error=".urlencode('没有所需的访问量统计信息')."&back=".urlencode($from);
			header("Location: " . $errorURL);
			exit();
	}
}else{
		//跳转到错误信息页面
		$errorURL =  "../common/error.php?error=".urlencode('没有所需的访问量统计信息')."&back=".urlencode($from);
		header("Location: " . $errorURL);
		exit();
}


$siteByDay = siteStatistics($year, $month, $terminal, $db, $u);
//关闭数据库
$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>门户访问量统计</title>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="../css/common_fang.css" rel="stylesheet" type="text/css" />

<link href="css/visitSite.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/visitSite.js"></script>
<script type="text/javascript">
	var siteByDay = <?php echo json_encode($siteByDay); ?>;
	var startYear = <?php echo $dataAnalysisConfig['dataAnalysisStartYear']; ?>;
	var startMonth = <?php echo $dataAnalysisConfig['dataAnalysisStartMonth']; ?>;
	var year = <?php echo $year; ?>;
	var month = <?php echo $month; ?>;
	
	$(function(){
			$("<img src='../img/lbg.gif'></img>").appendTo("#container_left ul li.visitSite");
		});
</script>
<style type="text/css">
	#container_left ul li.visitSite{background-color:#108dbd;}
	#container_left ul li.visitSite a{color:#FFF;}
</style>
</head>

<body>
	<?php include('../common/admin_header.php'); ?>
    
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="right">
            <div class="rtf">
				<p><span>门户访问量统计</span></p>
			</div>	
			<div id="u1" class="u1">
				<div id="u1_line" class="u1_line"></div>
			</div>
            <div class="selTittle clearfix">
            	<span>选择月份：
                <select id="selectMonth">
                </select>
                </span>
                <span style="position:absolute;right:74px;top:4px;">选择统计终端：
                    <select id="terminal">
                        <option value="1"<?php echo $terminal == 1 ? '  selected="selected"' : ''; ?>>PC门户网站</option>
                        <option value="2"<?php echo $terminal == 2 ? '  selected="selected"' : ''; ?>>手机门户网站</option>
                    </select>
                </span>
            </div>
            <p class="caption"><?php echo $year; ?>年<?php echo $month; ?>月统计数据</p>
            <img id="site" />
			<table id="siteDetail" class="mytable" width="80%" style="margin-left:10%;margin-top:10px;">
				<thead>
					<tr>
                        <th width="20%">日期</th>
                        <th width="20%">访问量</th>
                        <th width="60%">比例</th>
					</tr>
				</thead>
				<tbody>
                <?php foreach($siteByDay as $key => $item):?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item; ?></td>
                        <td><div class="proportion"></div></td>
                    </tr>
                <?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
    <div>
    <p align="center" style=" color:#000000; padding-top:1px; font-size:14px;">copyright © 2013-2014 中国微视频协作与交易平台<br/>All Rights Reserved. 中国传媒大学 新媒体研究院</p>
</div>
</body>
</html>