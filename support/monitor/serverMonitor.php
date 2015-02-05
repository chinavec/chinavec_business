<?
require('../../config/config.php');
require('../config/config.php');
require('../../lib/db.class.php');
require('../../lib/log.php');
//实例化数据库操作类
$db = new DB();
//获取服务器数量
$sql = "SELECT max(id) AS serverNum FROM `server`";
//调用数据库操作类中select_one函数实行查询数据操作
$info = $db->select_one($sql);
$serverNum = $info->serverNum;
//$from = $config['root']."support/businessSupport.php";
$from = "../../support/userActive.php";

//验证$sid的合法性，包括是否是整形数、正数、值在正常范围内
if(isset($_GET['sid']) == TRUE){
	if(is_numeric($_GET['sid']) == FALSE){
		$errorURL =  "../common/error.php?error=".urlencode('未找到对应的服务器信息')."&back=".urlencode($from);
		echo "<script>location.href='$errorURL';</script>";
		//调用日志函数生成日志
		systemLog("未找到对应的服务器信息", 1, 3, $db);
		exit();
	}elseif($_GET['sid'] >= 1 && $_GET['sid'] <= $serverNum){
		$sid = $_GET['sid'];
		//调用日志函数生成日志
		systemLog("服务器获取参数成功", 1, 2, $db);
	}else{
		$errorURL =  "../common/error.php?error=".urlencode('未找到对应的服务器信息')."&back=".urlencode($from);
		echo "<script>location.href='$errorURL';</script>";
		//调用日志函数生成日志
		systemLog("未找到对应的服务器信息", 1, 3, $db);
		exit();
	}
}else{
	$sid = 1;
	//调用日志函数生成日志
	systemLog("服务器获取参数成功", 1, 2, $db);
}


$sql = "SELECT `server_operatioing_info`.*,`server`.`name` FROM `server_operatioing_info`
		JOIN `server` ON `server`.`id` = `server_operatioing_info`.`server_id`
		WHERE `server`.`id` = $sid
		ORDER BY `server_operatioing_info`.`time` LIMIT 1";
//调用数据库操作类中select函数实行查询数据操作
$info = $db->select_one($sql);
//print_r($info);
//判断是否返回查询数据

if(!count($info)){
	$errorURL =  "../common/error.php?error=".urlencode('未找到对应的服务器信息')."&back=".urlencode($from);
	//header("Location: " . $errorURL);
	echo "<script>location.href='$errorURL';</script>";
	//调用日志函数生成日志
	systemLog("未找到对应的服务器信息", 1, 3, $db);
	exit();
	
}
//调用数据库操作类中select_one函数实行查询服务器数据信息		
$serverInfo = $db->select_one($sql);
//调用数据库操作类中select_condition函数实行条件查询服务器数
$severList = $db->select_condition('server');
//关闭数据库
$db->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="common.css" rel="stylesheet" type="text/css" />
<link href="monitor.css" rel="stylesheet" type="text/css" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<title>服务器监控</title>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="highcharts.js"></script>
<script type="text/javascript">
	
function Charts() {
	Highcharts.setOptions({global:{useUTC : false}});
}
Charts.prototype = $.extend(Charts.prototype, {
	initSpline  : function(timestamp, item, renderTo, name, unit, flag) {
		var opt = {
			chart: {
				renderTo: renderTo,
				type: "spline"
			},
			title: {text: null},
			xAxis: {
				type: "datetime",
				tickPixelInterval: 150
			},
			yAxis: {
				title: {text: name+'('+unit+')'},
				labels:{
					formatter:function() {
						return this.value
					}
				},
				max:100
			},
			tooltip: {
				formatter: function() {
					return "<b>"+ this.series.name+": </b>"+
						(this.y).toFixed(1)+' '+unit;
				}
			},
			plotOptions: {
				spline: {
					lineWidth: 2,
					states: {
						hover: {
							lineWidth: 3
						}
					},
					marker: {
						enabled: false
					},
					allowPointSelect: true,
					cursor: "pointer"
				}
			},
			exporting: {enabled: false},
			series:[]
		};

		for (var i in item) {
			opt.series.push({
				name:flag(i),
				data:(function(timestamp, y) {
					var data = [];
					for (var i = -19; i <= 0; i++) {
						data.push({
							x: timestamp + i*1000,
							y: y
						});
					}
					return data;
				})(timestamp, item[i])
			});
		}
		return new Highcharts.Chart(opt);
	},
	initPie 	: function(item, renderTo, unit) {
		var opt = {
			chart: {
				renderTo: renderTo,
				type: "pie"
			},
			title: {text: null},
			legend: {enabled: false},
			exporting: {enabled: false},
			tooltip: {
				formatter: function() {
					return "<b>"+ this.point.name +"</b>: "+this.point.y+' '+unit;
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: "pointer",
					dataLabels: {
						formatter: function() {
							return "<b>"+ this.point.name +"</b>: "+ Highcharts.numberFormat(this.percentage, 2) +'%';
						}
					}
				}
			},
			series: [item]
		};

		return new Highcharts.Chart(opt);
	},
	initBar : function(item, renderTo, name, totalname, unit) {
		var opt = {
			chart: {
				renderTo: renderTo,
				type: "column"
			},
			title: {text:null},
			xAxis: {
				categories: ['']
			},
			yAxis: {
				min: 0,
				title: {text : name+'('+unit+')'}
			},
			tooltip: {
				formatter: function() {
					return "<b>"+this.series.name +"：</b>"+ this.y + unit + "<br><b>"+totalname+"：</b>"+ this.point.stackTotal+unit;
				}
			},
			plotOptions: {
				column: {
					stacking: "normal",
					allowPointSelect: true,
					cursor: "pointer"
				}
			},
			series: []
		};

		for (var i in item) {
			opt.series.push(item[i]);
		}

		return new Highcharts.Chart(opt);
	}
});



$(document).ready(function(e){
		
		//var sock = null;
		//var wsuri = "ws://222.31.64.201:8889";


		//if ("WebSocket" in window) {
		//	sock = new WebSocket(wsuri);
		//} else if ("MozWebSocket" in window) {
		//	sock = new MozWebSocket(wsuri);
		//}

		//window.onload = function() {

		//	sock.onopen = function() {
		//		console.log("connected to " + wsuri);
		//	}

		//	sock.onclose = function(e) {
		//		console.log("connection closed (" + e.code + ")");
		//	}

		//	sock.onmessage = function(e) {
		//		console.log("message received: " + e.data);
		//	}
		//};
/*
$.get(
	"system_api.php",
	{apiuri:["system/server", "system/cpu", "system/harddisk", "system/loadavg"]},
	function(data){$("#aaa").text(55);
	},
	"json"
);
*/


function CPU(data) {
	if (data.status) {
		$("#CPUBasic").html(
			"型号：<span>"+data.brand+"</span> 内核数：<span>"+data.num+"</span> 频率：<span>"+Number((data.freq)).toFixed(2)+"</span> 缓存：<span>"+data.cache+"</span>"
		);
		this.num = data.num;
		this.timestamp = data.timestamp;
	}

	var cpuchart = null;
	this.init = function() {
		var chart = new Charts(), item = new Array();
		for (var i=0; i<this.num; i++) {
			item.push(0);
		}
		cpuchart = chart.initSpline(this.timestamp, item, "CPULine", "占用率", '%', function(i) {
			return (parseInt(i)+1)+"# CPU";
		});

	}

	this.update = function(timestamp, cpu) {
		for (var i in cpu) {
			cpuchart.series[i].addPoint([timestamp, cpu[i]], true, true);
		}
	}
}

function Memory() {
	var memorychart = null;

	this.init = function() {
		var chart = new Charts();
		memorychart = chart.initBar(
			[
				{
					name: "已使用",
					data: [0]
				},
				{
					name: "未使用",
					data: [100]
				}
			],
			"Memory", "使用量", "总容量", 'M'
		);
	}

	this.update = function(memory) {
		for (var i in memory) {
			memorychart.series[i].setData([memory[i]]);
		}
	}
}

function HardDisk() {
	setInterval($.proxy(function() {
		var apiuri = ["system/harddisk"];
		$.get(
			"restful/proxy",
			{api:apiuri},
			$.proxy(function(data) {
				var hd_api = data[apiuri[0]];
				if (hd_api.status) {
					this.update(hd_api);
				}
			}, this),
			"json"
		);
	}, this), 15*60*1000);

	var chart = new Charts(), hdchart = null;

	this.init = function(data) {
		hdchart = chart.initPie({
				data: [
					["已使用", data.used],
					["未使用", data.available]
				]
			},
			"Harddisk", data.unit
		);
	}

	this.update = function(data) {
		hdchart.series[0].setData([
			["已使用", data.used],
			["未使用", data.available]
		]);
	}
}

function LoadAVG() {
	setInterval($.proxy(function() {
		var apiuri = ["system/loadavg"];
		$.get(
			"restful/proxy",
			{api:apiuri},
			$.proxy(function(data) {
				var load_api = data[apiuri[0]];
				if (load_api.status) {
					this.update(load_api);
				}
			}, this),
			"json"
		);
	}, this), 60000);

	function insert(data) {
		delete data.status;
		for (var i in data) {
			$("#"+i).text(data[i]);
		}
	}

	this.init = function(data) {
		$("#loadavg").css("backgroundImage", "none");
		insert(data);
	}

	this.update = insert;
}



var apiuri = ["system/server", "system/cpu", "system/harddisk", "system/loadavg"];

$.get(
	"system_api.php",
	{apiuri:["system/server", "system/cpu", "system/harddisk", "system/loadavg"]},
	//{apiuri:""},
	function(data) {
		//$("#aaa").text(5554344);
		

		
		var server_api = data[apiuri[0]],
			cpu_api    = data[apiuri[1]],
			hd_api     = data[apiuri[2]],
			load_api   = data[apiuri[3]];

		if (server_api.status) {
			$("#basic").css("backgroundImage", "none");
			$("#ip").text(server_api.ip);
			$("#sysid").text(server_api.sysid);
			$("#oscore").text(server_api.oscore);
			$("#webserver").text(server_api.webserver);
			$("#webport").text(server_api.webport);

			var seconds = parseInt(server_api.update);
			function insetTime() {
				var min = seconds / 60,
					hours = min / 60,
					days = Math.floor(hours / 24);
				hours = Math.floor(hours - (days * 24));
				min = Math.floor(min - (days * 60 * 24) - (hours * 60));
				$("#update").text(
					days+"天"+
						hours+"小时"+
						min+"分钟 ("+seconds+"秒)"
				);
			}
			insetTime();
			setInterval(function() {
				seconds += 1;
				insetTime();
			}, 1000);

			if (hd_api.status) {
				var hd = new HardDisk();
				hd.init(hd_api);
			}

			if (load_api.status) {
				var ldavg = new LoadAVG();
				ldavg.init(load_api);
			}

			var sock = null,
				wsuri = "ws://"+server_api.ip+":"+server_api.wsport;

			if ("WebSocket" in window) {
				sock = new WebSocket(wsuri);
			} else if ("MozWebSocket" in window) {
				sock = new MozWebSocket(wsuri);
			}

			if (sock) {
				var cpu = new CPU(cpu_api), memory = new Memory();
				
				sock.onopen = function() {
					cpu.init();
					memory.init();
				}

				sock.onclose = function() {
					sock = null;
					$(".panelws").each(function(i, item) {
						$(item).css("backgroundImage", "none");
						$(item).find(".allowdel").empty()
						.append(
							$("<div>").addClass("tips").text("无法检测到 ["+$(item).find(">h2").text()+"] 的动态指标")
						);
					});
				}

				sock.onmessage = function(e) {
					$(".panelws").css("backgroundImage", "none");

					var wsresponse = JSON.parse(e.data);

					cpu.update(wsresponse.timestamp, wsresponse.cpu);
					memory.update(wsresponse.memory);

					$("#send").text(wsresponse.network[0]);
					$("#recv").text(wsresponse.network[1]);

				}
			}
		}

	},
	"json"
);

});

	</script>
</head>
<body>
<?php include('../common/admin_header.php'); ?>
<div id="container" class="clearfix">
    	<div id="container_left" class="left">
		﻿<div style="vertical-align:top;padding-top:30px; repeat-y;">
        <ul style="width:90%;">          
            <li class="font-lan14cu">网站数据分析
                <ul>
                    <li class="font-lan14 userActive"><a href="../newuserActive.php">网站用户量的统计</a></li>
                    <li class="font-lan14 visitSite"><a href="../newvisitSite.php">门户访问量的统计</a></li>
                    <li class="font-lan14 videoView"><a href="../newvideoView.php">视频订购量的统计</a></li>
                </ul>
            </li>
            <li class="font-lan14cu">日志
                <ul>
                    <li class="font-lan14 operatorLog" style="font-weight:normal;"><a href="../operatorLog.php">操作员日志</a></li>
                    
                </ul>
            </li>
            <li class="font-lan14cu">服务器监控
            <ul>
               <li class="font-lan14 businessSupport"><a href="serverMonitor.php">媒体服务器的监控</a></li>
            </ul>
            </li>
        </ul>
     </div>
        </div>
	<div id="container_right" class="right">
		<div class="inner">
		<div id="basic" class="panel hastable">
			<h2 class="option">基础参数</h2>
			<table>
				<tr>
					<td class="key">服务器标识</td>
					<td class="val" colspan="3" id="sysid"></td>
				</tr>
				<tr>
					<td class="key">操作系统内核</td>
					<td class="val" colspan="3" id="oscore"></td>
				</tr>
				<tr>
					<td class="key">正常运行时间</td>
					<td class="val" id="update"></td>
					<td class="key">IP地址</td>
					<td class="val" id="ip"></td>
				</tr>
				<tr class="last">
					<td class="key">Web服务环境</td>
					<td class="val" id="webserver"></td>
					<td class="key">Web服务端口</td>
					<td class="val" id="webport"></td>
				</tr>
			</table>
		</div>
		<div class="panelws">
			<h2 class="option">CPU</h2>
			<div id="CPU" class="chart">
				<div id="CPUBasic"></div>
				<div id="CPULine" class="allowdel midpanel"></div>
			</div>
		</div>
		<div class="panelws" style="width:48%; float:left">
			<h2 class="option">内存</h2>
			<div id="Memory" class="chart allowdel midpanel">
			</div>
		</div>
		<div class="panel" style="width:48%; float:right">
			<h2 class="option">硬盘</h2>
			<div id="Harddisk" class="chart midpanel">
			</div>
		</div>
		<div class="panelws hastable" style="width:48%; float:left">
			<h2 class="option">网络</h2>
			<div class="allowdel">
				<table class="table">
					<tr>
						<td class="tc"><span id="send" class="txt">0</span> bytes</td>
						<td class="tc"><span id="recv" class="txt">0</span> bytes</td>
					</tr>
					<tr>
						<th class="tc">发送流量</th>
						<th class="tc">接收流量</th>
					</tr>
				</table>
			</div>
		</div>
		<div id="loadavg" class="panel hastable" style="width:48%; float:right">
			<h2 class="option">系统平均负载</h2>
			<table class="table">
				<tr style="height:92px;">
					<td class="tc"><span id="proc1" class="txt">0</span></td>
					<td class="tc"><span id="proc5" class="txt">0</span></td>
					<td class="tc"><span id="proc15" class="txt">0</span></td>
					<td class="tc"><span id="curproc" class="txt">0</span></td>
				</tr>
				<tr>
					<th class="tc">平均进程数(1min)</th>
					<th class="tc">平均进程数(5min)</th>
					<th class="tc">平均进程数(15min)</th>
					<th class="tc">运行中进程比例</th>
				</tr>
			</table>
		</div>
		</div>	
	</div>	
		
</div>
<p align="center" style=" color:#000000; padding-top:1px; font-size:14px;">copyright © 2013-2014 中国微视频协作与交易平台<br/>All Rights Reserved. 中国传媒大学 新媒体研究院</p>
</body>
</html>
