<?php
$conn = mysql_connect("localhost","root","123456");
if (!$conn)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_query("set names utf8");
mysql_query("set global time_zone= '+08:00'");
mysql_select_db("chinavec", $conn);
?>
