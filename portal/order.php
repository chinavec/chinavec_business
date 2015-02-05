<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>申请授权</title>
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
.apply{
	background-color:#F60;
	color:#FFFFFF;
	font-family:微软雅黑;
	border-radius:3px;
	width:120px;
	height:40px;
	BORDER-LEFT: #ff9966 1px solid;/*左边框*/
	BORDER-RIGHT: #ff9966 1px solid;/*右边框*/
	BORDER-TOP: #ff9966 1px solid;/*上边框*/
	BORDER-BOTTOM: #ff9966 1px solid;/*下边框*/
	PADDING-LEFT: 2px;/*左间隙*/
	PADDING-RIGHT: 2px; /*右间隙*/
	PADDING-TOP: 2px;/*上间隙*/
	PADDING-BOTTOM: 2px;/*下间隙*/
	FONT-SIZE: 16px;/*字号*/
	CURSOR: pointer;/*光标类型*/
	
	}
</style>

<body>
<img src="img/vec_logo_left.jpg" width="240px" height="55" align="left">
<?php 
		session_start();
		$id = $_GET['id'];
		$userId = "1";
		
		//检查该页面是否已合法获取视频ID及ID是否为数值型
		if (!(isset($_GET['id']) && ctype_digit($_GET['id']))) {
			header("Location:movie.php?msg=invalid");
			exit;
		}
		
		include "common/table.php";
		require "lib/connect.php";
		
		
		$sql="select * from user WHERE `id` = $userId";
		$result=mysql_query($sql);
		$row=mysql_fetch_object($result);
		//print_r($row);
	?>
<span style="float:right; color:#FFFFFF; font-size:14px; margin-right:10px;">您好，请登录</span>

<!---->

<div style="width:970px; margin:0 auto; clear:both; border-radius: 1px;" class="change">
    <div style="width:600px;height:580px; float:left; margin:10px 10px 10px 10px;">
        <img src="img/beiyong.jpg" width="400"/>
        <p>授权业务简介<br/><br/>
            通过我们的获取授权功能，您可以将您喜爱的微视频加上水印，<br/>您作为该微视频的授权人，拥有该视频一定时限以内的使用权。    
        </p>
    </div>
    
    <div style="width:300px;height:580px; float:left;">
    	<br/><br/><br/><p>请务必填写清楚个人信息<p><br/>
       <br/><br/>
       <form method="post" action="orderProcess.php?id=<?php echo $id; ?>">
        <fieldset>
            <label for="name">用户名：</label>
			<?php echo $row->username; ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="font1">性别：</span>
			<select name="gender" id="gender" title="选择性别">
				<?php 
					if($row->gender == 0){
						echo '<option value="0" selected="selected">女</option>
                			  <option value="1">男</option>';
					}
					else{
						echo '<option value="0">女</option>
                			  <option value="1" selected="selected">男</option>';
					}
                ?> 
			</select>
        </fieldset><br/>
        <fieldset>
            <span class="font1">电子邮箱：</span>
		<input type="text" name="email" id="email" value="<?php  echo $row->email; ?>" />
        </fieldset><br/>
        <fieldset>
            <span class="font1">真实姓名：</span>
			<input type="text" name="realName" id="realName" value="<?php echo $row->real_name; ?>" />
        </fieldset><br/>
          <fieldset>
            <span class="font1">联系电话：</span>
			<input type="text" name="contact" id="contact" value="<?php echo $row->contact; ?>" />
        </fieldset><br/>
          <fieldset>
            <span class="font1">联系地址：</span>
			<input type="text" name="address" id="address" value="<?php echo $row->address; ?>" />
        </fieldset><br/>
        <fieldset>
            <span class="font1">授权目的：</span>
			<input type="text" name="purpose" id="address" value="<?php echo $row->address; ?>" />
        </fieldset><br/>
        <fieldset>
            <input type="submit" value="申请授权" class="apply"/>
        </fieldset>
    </form>
    </div>
</div>
<!---->    
    
    

<?php
	require('common/footer.php');
?>
