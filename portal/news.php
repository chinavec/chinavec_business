<?php
require "lib/connect.php";

$sql1 = "INSERT INTO `news` (`title` ) VALUES ('111111111');"; 
$sql2 = "SELECT * FROM `news` where id = 44;"; 
$sql3 = "UPDATE news SET  title = 'ggggggg' WHERE id =47;"; 
$sql = "DELETE FROM news WHERE id =47;"; 

	/* $result = mysql_query($sql,$conn);
	$row = mysql_fetch_object($result);
	echo $row->title;
	echo $row->id;
	*/

	
	if (mysql_query($sql,$conn))
	{
		echo "ok";
	}
	else{
		echo "出错";
		}
?>