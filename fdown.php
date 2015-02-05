<?php
	$file_name = $_GET['name']; 
	$file_dir = "/var/www/ui_auth/video_auth/";
	include "encrypt.php";
// 设文件a.mpg已经创建，并且有权操作
// 但还是加上权限设定的语句，比较保险
// chmod(dirname(__FILE__), 0777); // 以最高操作权限操作当前目录
// 打开a.mpg文件，这里采用的是a+，也可以用a，a+为可读可写，a为只写，如果b.php不能存在则会创建它

$op = 'a+';
$file = fopen($file_dir . $file_name, $op); // a模式就是一种追加模式，如果是w模式则会删除之前的内容再添加
// 获取需要写入的内容

$info = 'ChinaVEC '.$file_name;



$info_encrypt = encrypt($info, 'E', $file_name.'ChinaVEC Encryption');
//echo '加密:'.encrypt($info, 'E', $file_name.'ChinaVEC Encryption');
//echo '<br>';
//echo '解密：'.encrypt($info_encrypt, 'D', $file_name.'ChinaVEC Encryption');

// 写入追加的内容
//echo '<br>'.date("Y-m-d H:i:s");
//echo " - 当前文件".__FILE__."<br>";
$str=fgets($file, 1024);
//echo "读取文件".$str."<br>";
//echo "正在写入文件($op)……<br>";
fwrite($file, $info_encrypt.'     '.$info);
// 关闭a.mpg文件
fclose($file);
//echo "写入完成……<br>";
// 销毁文件资源句柄变量
unset($file);

// http://localhost/vectest/fwrite.php
 
	if (!file_exists($file_dir . $file_name)) { //检查文件是否存在 
		echo "文件找不到"; 
		exit; 
	} else { 
		$fp = fopen($file_dir . $file_name,"r"); // 打开文件 
		// 输入文件标签 
		Header("Content-type: application/octet-stream"); 
		Header("Accept-Ranges: bytes"); 
		Header("Accept-Length: ".filesize($file_dir . $file_name)); 
		Header("Content-Disposition: attachment; filename=" . $file_name); 
		
		$buffer = 4096;
		
		//向浏览器返回数据 
		while(!feof($fp)){ 
			echo fread($fp,$buffer);
		} 
		fclose($fp);
		exit;
	}
?> 
