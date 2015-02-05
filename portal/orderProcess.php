<?php
	session_start();
	header("content-type:text/html;charset=utf-8");
	
	include('lib/connect.php');

	$id = $_GET['id'];
		
		//检查该页面是否已合法获取视频ID及ID是否为数值型
		if (!(isset($_GET['id']) && ctype_digit($_GET['id']))) {
			header("Location:movie.php?msg=invalid");
			exit;
		}
		
	//$username =  $_SESSION['username'] ;	//用户名
	$email = $_POST['email'];				//电子邮箱
	$realName = $_POST['realName'];			//真实姓名
	$address = $_POST['address'];			//联系地址
	$contact = $_POST['contact'];			//联系电话
	$gender = $_POST['gender'];				//性别
	$purpose = $_POST['purpose'];			//授权目的
	/*echo $email;
	echo $realName;
	echo $address;
	echo $contact;
	echo $gender;
	echo $purpose;
	*/
	
	$sql="UPDATE `chinavec`.`user` SET `email` = '$email',
										`real_name` = '$realName',
										`address` = '$address',
										`contact` = '$contact',
										`gender` = '$gender'
										
										WHERE `user`.`id` =1";
	//echo $sql;
	
	if (mysql_query($sql))
	{
		//$row=mysql_fetch_object($result);
		//print_r($row);
		//ECHO "OK1";
		$sql1="INSERT INTO `user_auth` (`user_id`, `video_id`, `purpose`) 
							VALUES ('1', '$id', '$purpose')";
		if (mysql_query($sql1)){
				//echo "授权表ok";
				$url = "movie.php"; 
				$msg = "申请成功！请耐心等待工作人员与您联系！";
				
			}
		else{
				$url = "movie.php"; 
				$msg = "申请失败！请稍后尝试重新申请！欢迎将此问题反馈给我们，我们将尽快解决：jiantongyu@cuc.edu.cn";

				//echo "授权表error";
				
			}
	}
	else
	{
		$url = "movie.php"; 
		$msg = "申请失败！请稍后尝试重新申请！欢迎将此问题反馈给我们，我们将尽快解决：jiantongyu@cuc.edu.cn";

		
	}
	
	mysql_close($conn);
	
?>

<html>   
<head>   
<meta http-equiv="refresh" content="3; url=<?php echo $url; ?>"> 
<title>申请授权结果</title>
<?php date_default_timezone_set("Asia/Shanghai");?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/movieDetail.css" />
</head>

<style type="text/css">
	body {
		text-align:center;
		background:#333 repeat 0px 1px;
	}
	.change{
		width:970px;
		margin:0px 200px 0 250px;
		}
</style>  
  
<body>  
<img src="img/vec_logo_left.jpg" width="240px" height="55" align="left">

	<?php 
		include "common/table.php"; 
		
		echo "<div class='change'><br/><br/><br/><br/><br/>".$msg."<br/><br/>3秒后将跳转....若未跳转，请<a href=".$url.">点击此处</a></div>";
	?>
    </br>
<?php
	require('common/footer.php');
?>