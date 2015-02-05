<?php
/*
 *视频观看统计功能界面
 */
require('../config/config.php');
require('config/config.php');
require('../lib/db.class.php');
require('../lib/util.class.php');

//实例化数据库操作类
$db = new DB();
$u = new Util();
//设置搜索内容$q
$q = isset($_GET['q']) ? $_GET['q'] : '';
//一页显示的条数
$pageSize = 10;
//设置页码$page
$page = isset($_GET['page']) ? $_GET['page'] : 0;
//判断$page是否为整数并大于0
if(!(ctype_digit($page))){
	$page = 1;
}
//内容的偏移量
$offset = ($page - 1) * $pageSize;
//若$q为空，读取表的全部信息；若$q不为空，读取和$q匹配的相关信息
if($q == ''){
	//读取数据表video_view_statistics
	$sqlCount = "SELECT COUNT(DISTINCT(`video_view_statistics`.`video_id`)) FROM `video_view_statistics`
				JOIN `video` ON `video`.`id` = `video_view_statistics`.`video_id`";
	$sql = "SELECT `video_type`.`name`,`video`.`title_cn`,`video`.`tags`,
			SUM(`video_view_statistics`.`view_total`) as `total`
			FROM `video_view_statistics`
			JOIN `video` ON `video`.`id` = `video_view_statistics`.`video_id` 
			LEFT JOIN `video_type` ON `video_type`.`id` = `video_view_statistics`.`type_id`
			GROUP BY `video_view_statistics`.`video_id`
			ORDER BY `total` DESC LIMIT $offset, $pageSize";
}else{
	$sqlCount = "SELECT COUNT(DISTINCT(`video_view_statistics`.`video_id`)) FROM `user_auth`
				 JOIN `video` ON `video`.`id` = `video_view_statistics`.`video_id`
				 WHERE `video`.`title_cn` LIKE '%$q%'
				";
	$sql = "SELECT `video_type`.`name`,`video`.`title_cn`,`video`.`tags`,
			SUM(`video_view_statistics`.`view_total`) as `total` 
			FROM `video_view_statistics`
			JOIN `video` ON `video`.`id` = `video_view_statistics`.`video_id` 		
			LEFT JOIN `video_type` ON `video_type`.`id` = `video_view_statistics`.`type_id`
			WHERE `video_type`.`name` LIKE '%$q%' OR `video`.`title_cn` LIKE '%$q%'
			GROUP BY `video_view_statistics`.`video_id`
			ORDER BY `total` DESC LIMIT $offset, $pageSize";

}
//wyy
$videoTypeCount = "SELECT count(*) AS `total` FROM `video` GROUP BY `type_id`";
$videoTypeCountName = "SELECT `name` AS `total` FROM `video_type`";
$videoViewCount = "SELECT `view_total` AS `total` FROM `video_view_statistics` ORDER BY `view_total` DESC LIMIT 15";

 $res_type1 = mysql_query($videoTypeCount);
 $type_arr1 = array();
	while($row_type1 = mysql_fetch_array($res_type1)){
		$type_arr1[] = $row_type1['total'];
	}

 $res_type2 = mysql_query($videoTypeCountName);
 $type_arr2 = array();
	while($row_type2 = mysql_fetch_array($res_type2)){
		$type_arr2[] = $row_type2['total'];
	}

 $res_type3 = mysql_query($videoViewCount);
 $type_arr3 = array();
 $type_arr4 = array();
 $i=0;
	while($row_type3 = mysql_fetch_array($res_type3)){
	$type_arr3[] = $row_type3['title_cn'];
	$type_arr4[] = $row_type3['view_total'];
	}

//读取数据库结果
$videoViewRank = $db->select($sql);





//设置url的形式
$basicURL = 'videoView.php?q='.$q;
//页码信息
$pageInfo = $u->page($db->count($sqlCount), $page, $pageSize);


//关闭数据库
$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>视频订购量统计</title>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/base.js"></script>
<link href="../css/common_fang.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="css/videoView.css" rel="stylesheet" type="text/css" />
<style>
	#container_left ul li.videoView{background-color:#108dbd;}
	#container_left ul li.videoView a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../img/lbg.gif'></img>").appendTo("#container_left ul li.videoView");
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
			<div>
               <!-- <form id="searchInput" action="" method="get">
                    <input type="text" style="width:200px" placeholder="输入视频或者类型名称查询" name="q" />
                    <input class="btn #he##btn-info" type="submit" value="搜索" />
                   <span class="font-lan14cu"><a href="videoView.php">清除搜索条件</a></span>
                </form>-->
            </div>
            <div class="rtf">
				<p><span>视频订购量统计</span></p>
                
			</div>	
			<div id="u1" class="u1">
				<div id="u1_line" class="u1_line"></div>
			</div>
			<table class="mytable" width="80%">
				<thead>
					<!--<tr>
						<th width="25%">视频名称</th>
                        <th width="15%">视频集数</th>
                        <th width="15%">视频类型</th>
                        <th width="15%">视频点播量</th>
                        <th width="15%">排行</th>
					</tr>-->
                    <tr>
                        <th width="1%"><img src="img/bl.jpg" alt="" width="16" height="31" /></th>
                        <th width="24%" align="center" valign="middle" background="img/bm.jpg" class="font-hui14">视频名称</th>
                        <th width="1%" align="center" valign="middle" background="img/bm.jpg"><img src="img/hsx.gif" alt="" width="1" height="7" /></th>
                        <th width="14%" align="center" valign="middle" background="img/bm.jpg" class="font-hui14">视频标签</th>
                        <th width="1%" align="center" valign="middle" background="img/bm.jpg"><img src="img/hsx.gif" alt="" width="1" height="7" /></th>
                        <th width="14%" align="center" valign="middle" background="img/bm.jpg" class="font-hui14">视频类型</th>
                        <th width="1%" align="center" valign="middle" background="img/bm.jpg"><img src="img/hsx.gif" alt="" width="1" height="7" /></th>
                        <th width="14%" align="center" valign="middle" background="img/bm.jpg" class="font-hui14">视频订购量</th>
                        <th width="1%" align="center" valign="middle" background="img/bm.jpg"><img src="img/hsx.gif" alt="" width="1" height="7" /></th>
                        <th width="12%" align="center" valign="middle" background="img/bm.jpg" class="font-hui14">排行</th>
                        <th width="1%" align="center" valign="middle" background="img/bm.jpg"><img src="img/hsx.gif" alt="" width="1" height="7" /></th>
                        <th width="1%"><img src="img/br.jpg" alt="" width="14" height="31" /></th>
                    </tr>
        
				</thead>
            </table>
            <table class="mytable" width="80%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
                <?php foreach($videoViewRank as $key => $item):?>
                	<tr>
						<td width="30%" align="center" valign="middle" class="font-hui"><?php echo $item->title_cn;?></td>
                        <td width="18%" align="center" valign="middle" class="font-hui"><?php echo $item->tags;?></td>
                        <td width="18%" align="center" valign="middle" class="font-hui"><?php echo $item->name;?></td>
                        <td width="18%" align="center" valign="middle" class="font-hui"><?php echo $item->total;?></td>
                        <td width="16%" align="center" valign="middle" class="font-hui"><?php echo ($key+1) + (($page-1) * $pageSize);?></td>
					</tr>
                <?php endforeach;?>
				</tbody>
			</table>
            <script src="js/highcharts.js"></script>
            <script src="js/modules/exporting.js"></script>
<br/>
            <div>
                <div style="width:49.7%; float:left; border-right:#DDDDDD solid;">
                    <div style="height:30px;"><span style="font-family:'微软雅黑'; font-size:18px; color:#555555;">定购量占比</span></div>
                    <div id="pie_basic" style="height: 280px; margin: 0 auto"></div>
                </div>
                <div style="width:49%; float:right;">
                    <div style="height:30px;"><span style="font-family:'微软雅黑'; font-size:18px; color:#555555;">视频类型占比</span></div>
                    <div id="pie_gradient" style="height: 280px; margin: 0 auto"></div>
                </div>
			</div>
            <!--page start-->
            <div class="page">
            <?php if($pageInfo['pages'] <= 1): ?>
                <p class="sysinfo">仅有当前一页</p>
            <?php else: ?>
                <!--<a class="mybutton ib" href="<?php echo $basicURL;?>&page=1">第一页</a>-->
                <?php 
                if($pageInfo['now'] == 1){
                    echo '<span class="mybutton ib"><img src="../img/ljt.gif" alt="" width="22" height="20" border="0" /></span>';
                }else{
                    echo '<a class="mybutton ib" href="'.$basicURL.'&page='.($pageInfo['now']-1).'"><img src="../img/ljt.gif" alt="" width="22" height="20" border="0" /></a>';
                }
                ?>
            <?php foreach($pageInfo['range'] as $item): ?>
            <?php 
            if($pageInfo['now'] == $item){
                echo '<span class="cur">'.$item.'</span>';
            }else{
                echo '<a class="ib mybutton" href="'.$basicURL.'&page='.$item.'">'.$item.'</a>';
            }
            ?>
            <?php endforeach; ?>
                <?php 
                if($pageInfo['now'] == $pageInfo['pages']){
                    echo '<span class="mybutton ib"><img src="../img/rjt.gif" alt="" width="22" height="20"  border="0"/></span>';
                }else{
                    echo '<a class="mybutton ib" href="'.$basicURL.'&page='.($pageInfo['now']+1).'"><img src="../img/rjt.gif" alt="" width="22" height="20"  border="0"/></a>';
                }
                ?>
                <!--<a class="mybutton ib" href="<?php echo $basicURL.'&page='.$pageInfo['pages']; ?>">最后页</a>-->
            <?php endif; ?>
            </div>
            <!--page end-->
		</div>
	</div>
<br/>
   <p align="center" style=" color:#000000; padding-top:1px; font-size:14px;">copyright © 2013-2014 中国微视频协作与交易平台<br/>All Rights Reserved. 中国传媒大学 新媒体研究院</p>
<script type="text/javascript">
	
<!--*****************第一个饼图***********************-->
	$(function () {
		$('#pie_basic').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title:{
				text: ''
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Browser share',
				data: [
					['<?php echo  $type_arr3[0];?>',<?php echo  $type_arr4[0];?>],
					['<?php echo  $type_arr3[1];?>',<?php echo  $type_arr4[1];?>],
					['<?php echo  $type_arr3[2];?>',<?php echo  $type_arr4[2];?>],
					['<?php echo  $type_arr3[3];?>',<?php echo  $type_arr4[3];?>],
					['<?php echo  $type_arr3[4];?>',<?php echo  $type_arr4[4];?>],
					['<?php echo  $type_arr3[5];?>',<?php echo  $type_arr4[5];?>],
					['<?php echo  $type_arr3[6];?>',<?php echo  $type_arr4[6];?>],
					['<?php echo  $type_arr3[7];?>',<?php echo  $type_arr4[7];?>],
					['<?php echo  $type_arr3[8];?>',<?php echo  $type_arr4[8];?>],
					['<?php echo  $type_arr3[9];?>',<?php echo  $type_arr4[9];?>],
					['<?php echo  $type_arr3[10];?>',<?php echo  $type_arr4[10];?>],
					['<?php echo  $type_arr3[11];?>',<?php echo  $type_arr4[11];?>],
					['<?php echo  $type_arr3[12];?>',<?php echo  $type_arr4[12];?>],
					['<?php echo  $type_arr3[13];?>',<?php echo  $type_arr4[13];?>],
					['<?php echo  $type_arr3[14];?>',<?php echo  $type_arr4[14];?>],
				]
			}]
		});
	});
<!--*****************第二个饼图***********************-->
	$(function () {
    	
    	// Radialize the colors
		Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		    return {
		        radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
		        stops: [
		            [0, color],
		            [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
		        ]
		    };
		});
		
		// Build the chart
        $('#pie_gradient').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: ''
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
					['<?php echo  $type_arr2[0];?>',<?php echo  $type_arr1[0];?>],
					['<?php echo  $type_arr2[1];?>',<?php echo  $type_arr1[1];?>],
					['<?php echo  $type_arr2[2];?>',<?php echo  $type_arr1[2];?>],
					['<?php echo  $type_arr2[3];?>',<?php echo  $type_arr1[3];?>],
					['<?php echo  $type_arr2[4];?>',<?php echo  $type_arr1[4];?>],
					['<?php echo  $type_arr2[5];?>',<?php echo  $type_arr1[5];?>],
                ]
            }]
        });
    });
</script>
   </body>
</html>
