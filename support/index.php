
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"></link>
<title>Chinavec管理系统</title>
<style type="text/css">
.table th, .table .center{
	text-align:center;
}
</style>
</head>
<body>
<div align="center">
<img src="./img/banner.jpg" alt="biaoti" />
</div>
<div style="height:410px; width:660px; margin:auto; margin-top:60px; padding:20px 0px 0px 0px;position:relative; background-image:url(img/background.jpg); ">
	<form class="form-horizontal login" name="login" action="login1.php" method="post">
		<div class="control-group">
        	<div style="float:left;">
            
				<label class="control-label" for="inputUser" style="margin:0px 0px 0px 80px;"><b>用户名：</b></label>
         
				<div class="controls" style="margin-left:270px;">
				<input type="text" name="name">
				</div>
            </div>
		</div>
		<div class="control-group" >
        	<div style="float:left;">
				<label class="control-label" for="inputPassword" style="margin:0px 0px 0px 80px;"><b>密&nbsp;&nbsp;&nbsp;码：</b></label>
				<div class="controls" style="margin-left:270px;">
					<input type="password" name="password">
				</div>
            </div>
		</div>
		
		<div class="controls" style=" width:200px;text-align:center; margin:0px 0px 0px 280px;">
				<button type="submit" class="btn btn-info">登录</button>
				<button type="reset" class="btn" style="margin-left:15px">清除</button>
		</div>

	</form>
</div>
</body>
