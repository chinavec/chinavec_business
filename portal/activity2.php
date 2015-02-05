<?php
require "lib/connect.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- saved from url=(0036)http://nmi.cuc.edu.cn/v/activity.php -->
<HTML><HEAD><META content="IE=7.0000" http-equiv="X-UA-Compatible">

<META charset=UTF-8>
<SCRIPT type=text/javascript src="activity_files/jquery-1.7.1.min.js"></SCRIPT>
<LINK rel=stylesheet type=text/css href="activity_files/campus.css"><LINK 
rel=stylesheet type=text/css href="activity_files/base.css">
<META name=GENERATOR content="MSHTML 10.00.9200.16635">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
body,td,th {
	font-size: 14px;
}
</style>
</HEAD>
<BODY>
<DIV id=header style="MARGIN: 0px auto; WIDTH: 900px"><IMG 
src="activity_files/vec_logo2.jpg" width=800> </DIV>
<DIV id=layout>
<STYLE>#layout {
	FONT-SIZE: 18px; FONT-FAMILY: "微软雅黑"; TEXT-ALIGN: left !important; TEXT-DECORATION: none; MARGIN: 0px auto
}
BODY {
	TEXT-ALIGN: center
}
A:visited {
	 COLOR: #fff;TEXT-DECORATION: none
}
A:link {
	COLOR: #fff; TEXT-DECORATION: none
}
A:active {
	COLOR: #0ff; TEXT-DECORATION: none
}
</STYLE>

   <!--导航栏-->
	<?php 
		include "common/table.php";
	?>
    <!--end of 导航栏-->
    <!--center-->

<DIV style="HEIGHT: 35px; WIDTH: 110px; background-color:#111; color:#FFFFFF; border-radius: 5px; text-align:center; font-size: 20px; margin-left:10" align="center"><p>团队招募</p> </DIV>
<DIV style="HEIGHT: 1100px;WIDTH: 970px ;border-radius: 20px;background-image:url(activity_files/QQ%E5%9B%BE%E7%89%8720130719163127.jpg)
">

<div style="width:670px;height:1000px;float:left; color:#EEE">
<IMG style=" margin-left:15px; margin-right:15px; margin-top:25px; float:left" src="activity_files/广告图.jpg" width="180">  
<h1 style="margin-top:50px; margin-bottom:50px" align="center">西安微电影直招演员</h1>
<?php
 
$sql = "SELECT * FROM `news` where id = 44;"; 
$result = mysql_query($sql,$conn);
$row = mysql_fetch_object($result);

?>
<p style="margin-left:15px" align="justify"> 
<?php echo $row->title; echo $row->content; ?></p>
<p style=";margin-left:500px;margin-top:200px">
<u>上一页</u> &nbsp;&nbsp;&nbsp;<u>下一页</u></p>

</div>

<div style="width:270px; float:right;margin-right:30px;margin-top:30px; color:#EEE">

<DIV style="line-height: 6px; float:right; HEIGHT: 35px; WIDTH: 65px; margin-right:117px; background-color:#222; color:#FFF; font-size:14px; border-radius: 5px; text-align: center;" align="left">
<p>近期热门</p></DIV><!--右上第一个标签--> 
<DIV style="line-height: 6px; margin-right:3px;float:right; HEIGHT: 35px; WIDTH: 65px; background-color:#222; color:#FFF; font-size:14px; border-radius: 5px" >
<p style="margin-left:5px">最新文章</p></DIV><!--右上第2个标签-->

<div style="width:250px; height:370px; float:right; border-radius: 5px; background-image:url(activity_files/QQ%E5%9B%BE%E7%89%8720130722155411.jpg)">
<p style="color:#000;font-size:18px;margin-top:47px;margin-left:5px;line-height:42px"><u>微电影与广告关系</u>
<br />
<u>故事简单，创意很难</u>
<br />
<u>营销人的自我修养与提升</u>
<br />
<u>一定要赏识你的人合作</u>
<br />
<u>电影制作流程图</u>
<br />
<u>世界著名品牌的十个秘密</u>
<br />
<u>陈秋平分享编剧技巧</u>
<br />
<u>创意视频360度定格画面</u>
</p>
</div><!--右上第一个框-->

<DIV style="float:right;line-height: 6px; HEIGHT: 35px;  WIDTH: 65px; margin-right:185px; margin-top:20px;  background-color:#222;font-size:14px; color:#FFFFFF; border-radius: 5px" align="center"><p>站内搜索</p> 
</DIV>
<div style="width:250px; height:190px; float:right; background-color:#E4E4E4; border-radius: 5px;align:center">
<table style="border-spacing:10px 10px; border-collapse:separate" cellpadding="5">
<tr><td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">全部</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">原创</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">爱情</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">搞笑</td></tr>
<tr><td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">创意</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">青春</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">励志</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">公益</td></tr>
<tr><td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">悬疑</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">科幻</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">广告</td>
<td style="border:1 solid #CCCCCC" bgcolor="#FFFFFF">特效</td></tr></table>
<input type="text" style="height:35px; width:180px; border-radius: 5px; float:left; margin-left:3px; margin-top:2px">
<input style=" float:right; background-image:url(activity_files/search%E6%8C%89%E9%92%AE.jpg); height:35px; width:64px; margin-right:3px; border-radius: 5px" type="submit" value="">
</div>
<DIV style="line-height: 35px; text-align: center; float:right; HEIGHT: 35px; WIDTH: 65px; margin-right:185px; margin-top:20px; background-color:#222; color:#FFF; font-size:14px; border-radius: 5px" align="center">本站推荐</p> 
</DIV>


<div style="width:250px; height:290px; float:right; background-image:url(activity_files/%E6%9C%AC%E7%AB%99%E6%8E%A8%E8%8D%90%E5%9B%BE%E7%89%87.jpg); border-radius: 5px">
<p style="color:#000;font-size:18px;margin-top:3px;margin-left:5px;line-height:42px"><u>微电影与广告关系</u>
<br />
<u>故事简单，创意很难</u>
<br />
<u>营销人的自我修养与提升</u>
<br />
<u>一定要赏识你的人合作</u>
<br />
<u>电影制作流程图</u>
<br />
<u>世界著名品牌的十个秘密</u>
<br />
<u>陈秋平分享编剧技巧</u>
</p>
</div></DIV>



</DIV><!--上下页-->

<?php
	require('common/footer.php');
?>
