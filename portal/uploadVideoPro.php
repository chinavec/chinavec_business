<?php 
/*	创建时间：		2013年8月7日
	编写人：			于鉴桐
	版本号：			v1.0
	
	修改记录：		原始版本v1.0
								
					
	已实现主要功能点：
	
	待实现主要功能点：			
*/
?>
<?php

function getnameV($videoExname,$videoName){ 
	$dir = "video/"; 
	$i = mysql_insert_id ();
	 
//判断是否存在该目录，若不存在，创建指定目录并赋予最大可能的访问权
	if(!is_dir($dir)){ 
		mkdir($dir,0777); 
	} 
	
	while(true){ 
		if(!is_file($dir.$i.".".$videoExname)){
			$name = $i.".".$videoExname;
			break;
		 }
		 //如果以此id命名的文件已存在（此情况不应发生），暂用一下机制处理，待改进。
		 else{
			if(!is_file($dir.$videoName."_".$i.".".$videoExname)){
				$name=$videoName."_".$i.".".$videoExname;
				break;
				 }
			 }		
			$i++; 
	} 
	return $name; 
} 

function getnameP($posterExname,$posterName){ 
	$dir = "poster/"; 
	$i = mysql_insert_id ();
//判断是否存在该目录，若不存在，创建指定目录并赋予最大可能的访问权
	if(!is_dir($dir)){ 
		mkdir($dir,0777); 
	} 
	
	while(true){ 
		if(!is_file($dir.$i.".".$posterExname)){
			$name = $i.".".$posterExname;
			break;
		 }
		 //如果以此id命名的文件已存在（此情况不应发生），暂用一下机制处理，待改进。
		 else{
			if(!is_file($dir.$posterName."_".$i.".".$posterExname)){
				$name=$posterName."_".$i.".".$posterExname;
				break;
				 }
			 }		
			$i++; 
	} 
	return $name; 
}


	//接收数据
	$titleCn 	= $_POST["titleCn"]		? $_POST['titleCn']    : '';
	$titleEn 	= $_POST["titleEn"]		? $_POST['titleEn']    : '';
	$director 	= $_POST["director"]	? $_POST['director']    : '';
	$producer 	= $_POST["producer"]	? $_POST['producer']    : '';
	$stars 		= $_POST["stars"]		? $_POST['stars']    : '';
	$dur 		= $_POST["dur"]			? $_POST['dur']    : '';
	$videoType 	= $_POST["videoType"]	? $_POST['videoType']    : '';
	$tags 		= $_POST["tags"]		? $_POST['tags']    : '';
	$dscrp 		= $_POST["dscrp"]		? $_POST['dscrp']    : '';
	
	
	require('lib/connect.php');
	
	$sql = "INSERT INTO `chinavec`.`video` (`title_cn` ,`title_en` ,`type_id` ,`dscrp` ,`dur` ,`director` ,`producer` ,`stars` ,`tags` ) 
									VALUES ('$titleCn' ,'$titleEn' ,'$videoType' ,'$dscrp' ,'$dur' ,'$director' ,'$producer' ,'$stars' ,'$tags' );"; 
	//echo $sql;
	//exit;
	if (mysql_query($sql,$conn))
	{	
		//数据插入成功后，开始处理图片和视频文件，两者都应以插入的id值为文件名
		//取出刚刚插入的id值，赋值给i变量

		//strtolower函数将文件名转换为小写，substr函数为返回的字符串，strrpos函数规定从字符串的第二个字母开始，直到字符串结尾。
		$videoName = strtolower(substr($_FILES['video']['name'],0,(strrpos($_FILES['video']['name'],'.'))));
		$videoExname = strtolower(substr($_FILES['video']['name'],(strrpos($_FILES['video']['name'],'.')+1))); 
		$uploadVideo = getnameV($videoExname,$videoName);
		
		if (move_uploaded_file($_FILES['video']['tmp_name'], "video/".$uploadVideo))
			{
				
				
			}
			else
			{
				echo "<script type=\"text/javascript\">alert('视频文件不符合要求，请重新上传！');</script>";
				echo "<script type=\"text/javascript\">window.location.href=\"upload.php\";</script>";
				exit;
			}
		
		
		if ((($_FILES["poster"]["type"] == "image/gif")
			|| ($_FILES["poster"]["type"] == "image/jpeg")
			|| ($_FILES["poster"]["type"] == "image/jpg")
			|| ($_FILES["poster"]["type"] == "image/pjpeg"))
			&& ($_FILES["poster"]["size"] < 90000000))
			{
				if ($_FILES["poster"]["error"] > 0)
				{
					echo "错误：" . $_FILES["poster"]["error"] . "<br />";
				}
				else	
				{
					$posterName = strtolower(substr($_FILES['poster']['name'],0,(strrpos($_FILES['poster']['name'],'.'))));
					$posterExname = strtolower(substr($_FILES['poster']['name'],(strrpos($_FILES['poster']['name'],'.')+1))); 
					$uploadPoster = getnameP($posterExname,$posterName);
					if (move_uploaded_file($_FILES['poster']['tmp_name'], "poster/".$uploadPoster))
					{
					}
					else
					{
						echo "<script type=\"text/javascript\">alert('图片文件不符合要求，请重新上传！');</script>";
						echo "<script type=\"text/javascript\">window.location.href=\"upload.php\";</script>";
						exit;
					}
				}
			}
		$id = mysql_insert_id ();
			
		$sql1 = "UPDATE `chinavec`.`video`  SET `video_url` = '$uploadVideo',
												`poster` = '$uploadPoster' 
											WHERE `video`.`id` =$id;"; 
		//echo $sql1;
		//exit;
		if (mysql_query($sql1,$conn))
		{
			echo "<script type=\"text/javascript\">alert('信息录入成功');</script>";
			echo "<script type=\"text/javascript\">window.location.href=\"upload.php\";</script>";
		}
		else{
			echo "<script type=\"text/javascript\">alert('22信息录入失败');</script>";
			echo "<script type=\"text/javascript\">window.location.href=\"upload.php\";</script>";
			}
		}
		
	//数据库插入不成功
	else   
	{	
		echo "<script type=\"text/javascript\">alert('11信息录入失败');</script>";
		echo "<script type=\"text/javascript\">window.location.href=\"upload.php\";</script>";
		
	}

		mysql_close($conn);


/*echo "下面是文件上传的一些信息： 

    <br>原文件名：".$_FILES['video']['name'] . 

    "<br>类型：" .$_FILES['video']['type'] . 

    "<br>临时文件名：".$_FILES['video']['tmp_name']. 

    "<br>文件大小：".$_FILES['video']['size'] . 

    "<br>错误代码：".$_FILES['video']['error']; 
*/
?>