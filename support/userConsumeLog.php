<?php
/*
 *用户消费日志功能界面
 *肖亚翠
 *V1.0
 *2013-5-16
 */
require('../../config/config.php');
require('config/config.php');
require('../../lib/db.class.php');
//判断日期的有效性
function validDate($d){
	return preg_match('/^20\d{2}-\d{2}-\d{2}$/', $d);
}

//实例化数据库操作类
$db = new DB();
//设置搜索内容$q、搜索起始日期$s和结束日期$e、页码$p
$q = isset($_GET['q']) ? $_GET['q'] : '';
$s = isset($_GET['s']) && $_GET['s'] != '' ? $_GET['s'] : '';
$e = isset($_GET['e']) && $_GET['s'] != '' ? $_GET['e'] : '';
//类型转换验证日期值的有效性
$s = validDate($s) ? strtotime($s) : 0;
$e = validDate($e) ? strtotime($e) : strtotime('2030-01-01');
$p = isset($_GET['p']) ? $_GET['p'] : 1;
//判断$p是否为整数并大于0
if(!(ctype_digit($p))){
	$p = 1;
}
//设置一页显示的内容数
$pageSize = 10;
//内容的偏移量
$offset = ($p - 1) * $pageSize;
//若$q为空，读取表的全部信息；若$q不为空，读取和$q匹配的相关信息
if($q == '') {
//读取订购消费数据表user_financial
$sqlCount = "SELECT COUNT(*) FROM `user_financial` WHERE `type` = 1 AND `consumer_time` BETWEEN $s AND $e";
$sql = "SELECT `user`.`username`, `user_financial`.`fee`,
		`user_financial`.`consumer_time`,`user_financial`.`type`
		FROM `user_financial` 
		JOIN `user` ON `user`.`id` = `user_financial`.`user_id` 
		WHERE `user_financial`.`type` = 1 AND `consumer_time` BETWEEN $s AND $e
		ORDER BY `user_financial`.`consumer_time` DESC
		LIMIT $offset,$pageSize";
}else{
$sqlCount = "SELECT COUNT(*) FROM `user_financial`
			JOIN `user` ON `user`.`id` = `user_financial`.`user_id` 
			WHERE `user`.`username` LIKE '%$q%' AND `type` = 1 AND `consumer_time` BETWEEN $s AND $e";
$sql = "SELECT `user`.`username`, `user_financial`.`fee`,
		`user_financial`.`consumer_time`,`user_financial`.`type`
		FROM `user_financial` 
		JOIN `user` ON `user`.`id` = `user_financial`.`user_id` 
		WHERE (`user`.`username` LIKE '%$q%' OR `user_financial`.`fee` LIKE '%$q%')
		AND `user_financial`.`type` = 1 AND `consumer_time` BETWEEN $s AND $e
		ORDER BY `user_financial`.`consumer_time` DESC
		LIMIT $offset,$pageSize";
}
//读取数据库结果
$res = $db->select($sql);
//计算读取结果总数
$listCount = $db->count($sqlCount);
//计算出需要显示的页面数
$pageTotal = ceil($listCount / $pageSize);
//重新获取搜索起始日期$_s和结束日期$_e
$_s = isset($_GET['s']) ? $_GET['s'] : '';
$_e = isset($_GET['e']) ? $_GET['e'] : '';
//设置url的形式
$basicURL = "userConsumeLog.php?q=$q&s={$_s}&e={$_e}";
//关闭数据库
$db->close();
?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>日志信息</title>
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.9.2.custom.min.js"></script>

<link href="css/systemLog.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/systemLog.js"></script>
<link href="../../css/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<style>
	#container_left ul li.userConsumeLog{background-color:#108dbd;}
	#container_left ul li.userConsumeLog a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../../img/lbg.gif'></img>").appendTo("#container_left ul li.user-consume-log");
		});
</script>
</head>

<body>
	<?php include('../../common/admin_header.php'); ?>
    
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="right">
            <div class="cor_left"> </div>
            <div class="cor_right"> </div>
            
            <div class="right_box">
                <div class="right_list">
                    <h3>状态列表<span class="foot_list">（搜索日志）</span></h3>
                    <div class="search">
                        <div class="search_left">
                            <form action="" method="get">
                                &nbsp;&nbsp;内容：
                                <input id="query" type="text" class="input_text_search" name="q" />
                                &nbsp;&nbsp;日期:
                                <input id="start_time" type="text" class="input_text_search2" name="s" />
                                到
                                <input id="end_time" type="text" class="input_text_search2" name="e" />
                                <a href="userConsumeLog.php">清除搜索条件</a>
                                <input type="submit" class="submit" value="搜索" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right_log_list" id="right_log_list">
            	<div class="log_box">
                    <ul class="mylist">
                    <?php foreach($res as $key => $item): ?>
                        <li class="log_list">
                            <div>
                                <div class="log_title">
                                    <p id="log" class="log">
                                        <span class="date">【<?php echo date('Y-m-d', $item->consumer_time); ?>】</span>
                                        <?php echo $item->username.($item->type==1?'消费':'充值').$item->fee.'元。'; ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                    </ul>
					<?php if(!count($res)):?>
						<p style="text-align:center;">没有更多的日志信息！</p>
					<?php exit(); endif;?>
                </div>
            <!--分页功能-->
            <!--page start-->
            <div class="page">
                <a class="page_list" href="<?php echo $basicURL . "&p=1"; ?>">首页</a><span class="page_list">|</span>
                <?php if($p == 1): ?>
                <span class="page_list">上一页</span>
                <?php else: ?>
                <a class="page_list" href="<?php echo $basicURL . "&p=" . ($p - 1); ?>">上一页</a>
                <?php endif; ?>
                <span class="page_list">|</span>
                <?php if($p == $pageTotal): ?>
                <span class="page_list">下一页</span>
                <?php else: ?>
                <a class="page_list" href="<?php echo $basicURL . "&p=" . ($p + 1); ?>">下一页</a>
                <?php endif; ?>
                <span class="page_list">|</span>
                <a class="page_list" href="<?php echo $basicURL . "&p=$pageTotal"; ?>">尾页</a>
            </div>
            <!--page end-->

            </div>
        </div>
	</div>
    <?php include('../../common/admin_footer.html'); ?>
</body>
</html>