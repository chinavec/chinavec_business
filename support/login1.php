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


?>
<?php
require_once("./lib/connect.php");
$name=$_POST['name'];
//$passowrd=md5($_POST['password']);
$passowrd=md5($_POST['password']);
if ($name && $passowrd){
 $sql = "SELECT * FROM user WHERE name= '$name' and password='$passowrd'";
 $res = mysql_query($sql);
 $rows=mysql_num_rows($res);
	if($rows){
		systemLog("管理员登录", 1, 3, $db);
		header("refresh:0;url=../../chinavec_cd/contentdistribution");//跳转页面
		exit;
	}else{
		systemLog("登录员登录错误", 1, 1, $db);
		echo "<script language=javascript>alert('用户名或密码错误');history.back();</script>";
	}
}else {
 echo "<script language=javascript>alert('用户名密码不能为空');history.back();</script>";
}
?>
<?php
//关闭数据库
$db->close();
?>
