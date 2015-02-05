<?php
/*
 *服务器运行信息监控界面
 *肖亚翠
 *V1.0
 *2013-4-12
 */
require('../config/config.php');
require('config/config.php');
require('../lib/db.class.php');
require('../lib/log.php');
//实例化数据库操作类
$db = new DB();
//获取服务器数量
$sql = "SELECT max(id) AS serverNum FROM `server`";
//调用数据库操作类中select_one函数实行查询数据操作
$info = $db->select_one($sql);
$serverNum = $info->serverNum;
//$from = $config['root']."support/businessSupport.php";
$from = "../support/userActive.php";

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
	systemLog("服务器参数未设置", 1, 1, $db);
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
<meta http-equiv="refresh" content="20">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>chinavec管理中心</title>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link href="css/index.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php include('../common/admin_header.php'); ?>
    
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="right">
			<div class="rtf">
				<p><span>服务器监控</span></p>
			</div>	
			<div id="u1" class="u1">
				<div id="u1_line" class="u1_line"></div>
			</div>
            <div class="clearfix" style="margin-bottom:30px;">
                <div class="left" style="width:200px">
                	<ul id="serverList">
                    <?php foreach($severList as $key => $item): ?>
                    	<?php if($sid == $item->id): ?>
                        <li style="color:red;"><?php echo $item->name; ?></li>
                        <?php else: ?>
                        <li><a href="businessSupport.php?sid=<?php echo $item->id; ?>"><?php echo $item->name; ?></a></li>
                        <?php endif; ?>
                    	
                    <?php endforeach; ?>
                    </ul>
                </div>
				<div class="right" style="width:500px;margin-right:58px;">
                   <div id="cpu">
                        <div class="rate" style="width:<?php echo $serverInfo->cpu_usage_rate;?>%"></div>
                        <div class="rateValue">CPU使用率：<?php echo $serverInfo->cpu_usage_rate;?>%</div>
                    </div>
                    <div id="memory">
                        <div class="rate" style="width:<?php echo $serverInfo->memory_usage_rate;?>%"></div>
                        <div class="rateValue">内存使用率：<?php echo $serverInfo->memory_usage_rate;?>%</div>
                    </div>
                    <div id="state">服务器运行状态：
                    	<?php if($serverInfo->operating_state == 1):?>
                        <span style="color:green;font-weight:bold;">正常</span>
                        <?php else:?>
                        <span style="color:red;font-weight:bold;">停止</span>
                        <?php endif;?>
                    </div>
                    <div id="thread">门户线程：<span style="font-weight:bold;"><?php echo $serverInfo->thread;?></span></div>
                </div>
    		</div>
		</div>
	</div>
    <?php include("../common/admin_footer.html");?>
</body>
</html>
