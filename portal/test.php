<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>
<?php
require "lib/connect.php";

//$sql="INSERT INTO `college` (`college_type_id`, `title`, `content`, `picture`, `create_time`, `admin_id`) VALUES ('1', '拍摄教555', '123456', '2.jpg', '1', '1')";

//$sql="UPDATE `college` SET `title`=  '拍摄教566' WHERE `id`= 5";

//$sql="SELECT * FROM `college` WHERE  `id`= 5";

$sql="DELETE FROM `college` WHERE  `id`= 5";

if ($result = mysql_query($sql))
	{
		//$row=mysql_fetch_object($result);
		//print_r($row);
		ECHO "OK";
		exit;
	}
	else
	{
		echo "error";
		exit;
	}
	
	mysql_close($conn);
?>
</body>
</html>