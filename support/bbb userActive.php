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
$from = $config['root']."support/newuserActive.php";
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
$lastyear=$year-1;
$sqly = "SELECT * FROM `user_statistics` WHERE `year`=$year ";
$sqllasty = "SELECT * FROM `user_statistics` WHERE `year`=$lastyear ";
$sqlm = "select sum(`user_total`) as sum from `user_statistics` WHERE `year`=$year group by `month`";
$sqllastm = "select sum(`user_total`) as lastsum from `user_statistics` WHERE `year`=$lastyear group by `month`";
$resultm= $db->select($sqlm);
$resultlastm= $db->select($sqllastm);
//$resultm = mysql_query($sqlm);
//$resultlastm = mysql_query($sqllastm);
/*foreach($resultlastm as $key => $item):
			echo $resultlastm{sum(`visit_total`)} ;
                        
                 endforeach;*/
				// print_r($resultlastm);
				 //while($row = mysql_fetch_array($resultm)){
	//echo $row['SUM(`visit_total`)'];

//}

$resulty= $db->select($sqly);
$resultlasty= $db->select($sqllasty);
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
	<!--**************第一个图示******************-->
	$(function () {
			$('#line-time-series').highcharts({
				chart: {
					zoomType: 'x',
					spacingRight: 20
				},
				title: {
					text: '<?php echo $year; ?>年数据'
				},
				subtitle: {
					text: document.ontouchstart === undefined ?
						'' :
						''
				},
				xAxis: {
					type: 'datetime',
					maxZoom: 14 * 24 * 3600000, // fourteen days
					title: {
						text: null
					}
				},
				yAxis: {
					title: {
						text: '在线用户量'
					}
				},
				tooltip: {
					shared: true
				},
				legend: {
					enabled: false
				},
				plotOptions: {
					area: {
						fillColor: {
							linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							]
						},
						lineWidth: 1,
						marker: {
							enabled: false
						},
						shadow: false,
						states: {
							hover: {
								lineWidth: 1
							}
						},
						threshold: null
					}
				},
		
				series: [{
					type: 'area',
					name: '<?php echo $year; ?>年在线用户量',
					pointInterval: 24 * 3600 * 1000,
					pointStart: Date.UTC(<?php echo $year; ?>, 0, 01),
					data: [<?php $str2 = ",";?>
					<?php foreach($resulty as $key => $itemy):?>
					   <?php echo $itemy->user_total . " " . $str2;?>
                        
                <?php endforeach;?>
						
					]
				}]
			});
		});
<!--*****************第二个图示********************-->
	  $(function () {
			$('#line_basic').highcharts({
				title: {
					text: '<?php echo $year; ?>年与<?php echo $year-1; ?>年数据对比',
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
						'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
				},
				yAxis: {
					title: {
						text: '在线用户量'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: ''
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					borderWidth: 0
				},
				series: [{
					name: '<?php echo $year; ?>年',
					data: [<?php $str2 = ",";?>
					
					  <?php foreach($resultm as $key => $item):?>
					   <?php echo $item->sum . " " . $str2;?>
                        
                <?php endforeach;?>]
				}, {
					name: '<?php echo $year-1; ?>年',
					data: [<?php $str2 = ",";?>
					
					  <?php foreach($resultlastm as $key => $item):?>
					   <?php echo $item->lastsum . " " . $str2;?>
                        
                <?php endforeach;?>]
				}]
			});
		}); 
<!--*******************第三幅图示**************************-->
	$(function () {
			$('#column_rotated_label').highcharts({
				chart: {
					type: 'column',
					margin: [ 50, 50, 100, 80]
				},
				title: {
					text: '<?php echo $month; ?>月统计数据'
				},
				xAxis: {
					categories: [
						<?php $str2 = ",";?>
					<?php foreach($userByDay as $key => $item):?>
					   <?php echo $key + 1 . " " . $str2;?>
                        
                <?php endforeach;?>
					],
					labels: {
						rotation: -45,
						align: 'right',
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '在线用户量'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '在线用户量',
				},
				series: [{
					name: '',
					data: [ <?php foreach($userByDay as $key => $item):?>
                   
                    
                        <?php echo $item . " " . $str2; ?>
                        
               		 <?php endforeach;?>],
					dataLabels: {
						enabled: true,
						rotation: -90,
						color: '#FFFFFF',
						align: 'right',
						x: 4,
						y: 10,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif',
							textShadow: '0 0 3px black'
						}
					}
				}]
			});
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
            <!--<img id="user" />-->
            <div style="width:750px; height:1000px;">
                	<script src="js/highcharts.js"></script>
					<script src="js/modules/exporting.js"></script>

					<div id="line-time-series" style="min-width: 310px; height: 300px; margin-bottom:30px;"></div>
                    <hr style="width:640px; height:1px; border-color:#CCC; background:#CCC">
                    <div id="line_basic" style="min-width: 310px; height: 300px; margin-top:15px; margin-bottom:30px"></div>
                    <hr style="width:640px; height:1px; border-color:#CCC; background:#CCC">
                    <div id="column_rotated_label" style="min-width: 500px; height: 310px; margin-top:15px; margin-bottom:10px"></div>
            </div>
           <!-- <table id="userDetail" class="mytable" style="width:80%;margin-left:10%;marin-top:10px">
                <thead>
                    <tr>
                        <th width="20%">日期</th>
                        <th width="20%">活跃用户数</th>
                        <th width="60%">比例</th>
                    </tr>
                </thead>
                <tbody>
                    <?php /*foreach($userByDay as $key => $item): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item; ?></td>
                        <td><div class="proportion"></div></td>
                    </tr>
                    <?php endforeach; */?>
                </tbody>
            </table>-->
		</div>
	</div>
   &
    <p align="center" style=" color:#000000; padding-top:1px; font-size:14px;">copyright © 2013-2014 中国微视频协作与交易平台<br/>All Rights Reserved. 中国传媒大学 新媒体研究院</p>
</body>
</html>
