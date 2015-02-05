<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
    <?php date_default_timezone_set("Asia/Shanghai");?>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/campus.css" />	
    <link rel="stylesheet" type="text/css" href="css/base.css" />
</head>
<body>
	<div id="header" style="width:900px;margin:0 auto;">
	<img src="img/vec_logo2.jpg" width=800>
	</div>
	<div id="layout">

	<style>
	#layout{ margin:0 auto;text-decoration:none; font-family:"微软雅黑"; font-size:18px; text-align:left !important; text-align:center; }
	body{text-align:center}
	a:visited  {color:#FFF;text-decoration:none;}
    a:link {color:#FFF;text-decoration:none;}
	a:active {color:#0FF; text-decoration:none;}
</style>

	<!--
	 <table align="center" bgcolor="#000000" width="970" height="55" style="text-decoration:#FFF; text-align:center; border-radius: 5px;">
      <tr >
			<td><a href="">资讯|</a>
           </td>           
             <td><a href="">剧本|</a>            
           </td>           
             <td><a href="">媒体素材|</a>            
           </td>           
             <td><a href="">微剧场|</a>            
           </td>
             <td><a href="">微电影学院|</a>            
           </td>
             <td><a href="">投资合作|</a>            
           </td>
             <td><a href="index.php">返回首页|</a>
     </tr>
   </table>-->
<!--banner-->
<!--导航栏-->
     
	<?php 
		include "common/table.php";
	?>
	<!--end of 导航栏-->
	<div style="width:960px; margin:0 auto; clear:both;">
		<img src="img/niaokan2.jpg" style="width:960px; margin:0 auto;" />
	</div>
	
	
	<!--center-->
	<div class="change" style="height:600px; width:100%; background-color:#fff; margin:0 auto;  clear:both;">
		<!--right-->
		<div style="height:500px; width:970px; margin:0 auto; clear:both;" align="center">
            <div style="width:410px; margin-top:10px; margin-left:40px; float:left">
				<p style="font-size:20px; font-weight:900" align="left" >剧本</p>
				<div>
				<img src="img/1.jpg" width="100px" style="margin:5px auto auto 10px; float:left"  />
				</div>
				<div style="width:250px; margin-left:40px; float:left">
					<p style="font-size:14px" align="left">《致河流》经典剧本演绎</p>
					<p style="font-size:14px" align="left">《花盆》创意动画微电影</p>
					<p style="font-size:14px" align="left">《未来的生命形式》</p>
					<p style="font-size:14px" align="left">《东京城市交响曲》</p>
					<p style="font-size:14px" align="left">《绿洲终点站》</p>
					<p style="font-size:14px" align="right">more...</p>
				</div>
			</div>
			 <div style="width:410px; margin-top:10px; margin-left:40px; float:left">
				<p style="font-size:20px; font-weight:900" align="left">媒体素材</p>
				<img src="img/2.jpg" width="100px" style="margin:5px auto auto 10px; float:left"  />
				<div style="width:250px; margin-left:40px; float:left">
					<p style="font-size:14px" align="left">《致河流》经典剧本演绎</p>
					<p style="font-size:14px" align="left">《花盆》创意动画微电影</p>
					<p style="font-size:14px" align="left">《未来的生命形式》</p>
					<p style="font-size:14px" align="left">《东京城市交响曲》</p>
					<p style="font-size:14px" align="left">《绿洲终点站》</p>
					<p style="font-size:14px" align="right">more...</p>
				</div>
			</div>
			 <div style="width:410px; margin-top:10px; margin-left:40px; float:left">
				<p style="font-size:20px; font-weight:900" align="left">资讯</p>
				<img src="img/3.jpg" width="100px" style="margin:5px auto auto 10px; float:left"  />
				<div style="width:250px; margin-left:40px; float:left">
					<p style="font-size:14px" align="left">《致河流》经典剧本演绎</p>
					<p style="font-size:14px" align="left">《花盆》创意动画微电影</p>
					<p style="font-size:14px" align="left">《未来的生命形式》</p>
					<p style="font-size:14px" align="left">《东京城市交响曲》</p>
					<p style="font-size:14px" align="left">《绿洲终点站》</p>
					<p style="font-size:14px" align="right">more...</p>
				</div>
			</div>
			 <div style="width:410px; margin-top:10px;margin-left:40px; float:left">
				<p style="font-size:20px; font-weight:900" align="left">投资合作</p>
				<img src="img/4.jpg" width="100px" style="margin:5px auto auto 10px; float:left"  />
				<div style="width:250px; margin-left:40px; float:left">
					<p style="font-size:14px" align="left">《致河流》经典剧本演绎</p>
					<p style="font-size:14px" align="left">《花盆》创意动画微电影</p>
					<p style="font-size:14px" align="left">《未来的生命形式》</p>
					<p style="font-size:14px" align="left">《东京城市交响曲》</p>
					<p style="font-size:14px" align="left">《绿洲终点站》</p>
					<p style="font-size:14px" align="right">more...</p>
				</div>
			</div>
		</div>
        <!--end of right-->
		
	</div>
	<!--end of center-->
	
	
<?php
	require('common/footer.php');
?>