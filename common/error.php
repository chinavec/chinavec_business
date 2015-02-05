<?php
	//权限控制 TODO
	require('../config/config.php');
	$error = isset($_GET['error']) ? $_GET['error'] : '';
	$back = isset($_GET['back']) ? $_GET['back'] : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>错误信息--chinavec管理中心</title>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php include('admin_header.php'); ?>
    
    <div id="container" style="padding:90px 0;background-color:#FFF;">
    	<div style="height:64px;line-height:64px;margin-left:150px;padding-left:70px;font-size:16px;background:url(../img/error.png) left center no-repeat">
        	[错误]<?php echo $error; ?>
        </div>
        <?php if($back != ''): ?>
        <a href="<?php echo $back; ?>" style="margin-left:250px;font-size:14px;margin-top:15px">返回>></a>
        <?php else: ?>
        <a href="<?php echo $config['root']; ?>" style="margin-left:250px;font-size:14px;margin-top:15px">返回>></a>
        <?php endif; ?>
    </div>
    <?php include('admin_footer.html'); ?>
</body>
</html>