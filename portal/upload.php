<?php 
/*	创建时间：		2013年8月4日
	编写人：			于鉴桐
	版本号：			v1.0
	
	修改记录：		原始版本v1.0
					2013.8.6修改v1.1		修改上传界面内容
					2013.8.24修改v1.2			
					
	已实现主要功能点：
	
	待实现主要功能点：	1. 计算视频时长的脚本文件及文件的说明文档
					2. 整合本文件的css文件
					3. 对已上传视频的帧截图功能
					4. 上传方式可否使用ftp协议，在网页形式上上传		
*/
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<?php date_default_timezone_set("Asia/Shanghai");?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/base.css" />

<title>微电影上传</title>
<link rel="stylesheet" type="text/css" href="css/upload.css" />
</head>

<body>
<div id="header" style="width:900px;margin:0 auto;">
	<img src="img/vec_logo2.jpg" width=800>
</div>

<div id="layout">
	<?php 
		include "common/table.php";
	?>

<div style="width:760px; margin:0 auto; clear:both;border-radius: 5px;" class="change">
	<h2 class="post_title">上传微视频</h2>
	<div style=" width:600px; margin:0 auto;" class="post_left">
		<form id="news" method="post" action="uploadVideoPro.php" enctype="multipart/form-data">
            <table>
                <tbody>
                    <tr>
                        <td class="label">视频名称（中文）：</td>
                        <td><input name="titleCn" id="titleCn" title="视频中文名称" type="text" /></td>
                        
                    </tr>
                    <tr>
                        <td class="label">视频名称（英文）：</td>
                        <td><input name="titleEn" id="titleEn" title="视频英文名称" type="text" /></td>
                    </tr>
                    <tr>
                        <td class="label">导演：</td>
                        <td><input type="text" id="director" name="director" title="导演"  /></td> 
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">多个导演用“,”隔开</p></td>
                    </tr>
                    <tr>
                        <td class="label">制作：</td>
                        <td><input type="text" id="producer" name="producer" title="制作"  /></td> 
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">多个制作用“,”隔开</p></td>
                    </tr>
                    <tr>
                        <td class="label">主演：</td>
                        <td><input name="stars" id="stars" title="主演" type="text" /></td>
                    </tr>
                     <tr>
                        <td></td>
                        <td><p class="tips">多个主演用“,”隔开</p></td>
                    </tr>
                    <tr>
                        <td class="label">时长：</td>
                        <td><input name="dur" id="dur" title="时长" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">请填写秒数，格式为：200</p></td>
                    </tr>
                    <tr>
                        <td class="label">标签：</td>
                        <td><input name="tags" id="tags" title="标签" type="text" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">请填写标签，多个标签请用分号隔开</p></td>
                    </tr>
                    <tr>
                        <td class="label">视频类型：</td>
                         <td>
                            <select name="videoType" id="videoType" title="视频分类">
                                <option value="" selected="selected">请选择分类</option>
                                <option value="1">微电影</option>
                                <option value="2">微纪录</option>
                                <option value="3">微栏目</option>
                                <option value="4">微动漫</option>
                                <option value="5">创意视频</option>
                                <option value="6">信息视频</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">视频封面图：</td>
                        <td><input type="file" name="poster" id="poster" title="海报" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">没有海报请上传一张精彩的视频截图。大小建议不小于120*170</p></td>
                    </tr>
                    <tr>
                        <td class="label">视频地址：</td>
                        <td><input type="file" name="video" id="video" title="视频文件" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">请上传作品文件</p></td>
                    </tr>
                    <tr>
                        <td>剧情简介：</td>
                        <td><textarea name="dscrp" id="dscrp" title="剧情简介" rows="8" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><p class="tips">内容不能少于20个字</p></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="button"><input id="submit" type="submit" name="submit" value="确定" /></td>
                        <td class="button"><input id="reset" type="reset" name="reset" value="重置" /></td>
                    </tr>
                </tbody>
            </table>
		</form>
	</div>
	</div>
</div>


<script type="text/javascript">
    $(function() {
        $("#titleCn").focus();
        
        $("form").submit(function() {
            if ($("#titleCn").val() && $("#director").val()&& $("#videoType").val()&& $("#dur").val()&& $("#poster").val()&& $("#video").val()&& $("#dscrp").val()) {
                return true;
            }
            else {
                alert("请输入完整信息！");
                return false;
            }
        });
    })
</script>
	
<?php
	require('common/footer.php');
?>