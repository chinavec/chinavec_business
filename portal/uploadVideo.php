<?php 
/*	创建时间：		2013年8月6日
	编写人：			于鉴桐
	版本号：			v1.0
	
	修改记录：		原始版本v1.0
							
					
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


    <div style="width:760px; height:600px; margin:0 auto; clear:both;border-radius: 5px;" class="change">
        <h2 class="postTitle">上传微视频</h2>
        <div style=" width:600px; margin:0 auto;" class="post">
    	<form enctype="multipart/form-data" action="uploadVideoPro.php" method="post">  
            <br/>
            <!--最大上传文件大小500M-->
            <input type="hidden" name="MAX_FILE_SIZE" value="500000000">             
            请选择文件上传：<input type="file" name="upVideo" id="upVideo" title="视频文件">            
            <input type="submit" value='上传文件'>          
        </form>
        <br/><br/>  
         <div class="tips">
                <table cellpadding="0" cellspacing="0" border="0">
                  <tbody><tr>
                    <th nowrap="nowrap" width="72">·限定大小：</th><td width="338">上传文件不能超过500MB</td>
                  </tr>
                  <tr>
                    <th>·支持格式：</th>
                    <td>微软视频：.wmv .avi .dat .asf</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>Real Player：.rm .rmvb .ram</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>MPEG视频：.mpg .mpeg</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>手机视频：.3gp</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>Apple视频：.mov</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>
                    <ul>
                      <ul>
                        <li>
                          Sony视频：.mp4 .m4v
                        </li>
                      </ul>
                    </ul></td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>DV视频：.dvix .dv</td>
                  </tr>
                  <tr>
                    <th>&nbsp;</th>
                    <td>其他：.mkv .flv .vob  .ram .qt .divx .cpk .fli .flc </td>
                  </tr>
                  <tr>
                    <th>·时长要求：</th>
                    <td>时长无限制，但5分钟以内的视频，可以达到最流畅的上传及观赏效果</td>
                  </tr>
                  <tr>
                    <th nowrap="nowrap">·最佳分辨率：</th>
                    <td>1080P</td>
                  </tr>
                  <tr>
                    <th>·码率要求：</th>
                    <td>无码率要求，但视频整体码率大于500K将会被二次转码</td>
                  </tr>
                  <tr>
                    <th>·特别提示：</th>
                    <td>禁止上传任何含有政治敏感、色情等违法内容，以及侵犯他人版权的视频</td>
                  </tr>
                  <tr>
                    <th>·友情提示：</th>
                    <td>请不要上传您不拥有版权或者未经版权人允许的视频。
                    根据国际奥委会对视频版权的规定，请您不要上传内容为奥运比赛的视频。 对此给您带来的不便，请您理解。</td>
                  </tr>
                  <tr>
                    <th colspan="2">·上传视频表示您完全接受<a href="#" target="_blank">中国微视频协作与交易平台的原则条款</a> </th>
                  </tr>
                </tbody></table>
              </div>
        </div>
    </div>
</div>
<?php
	require('common/footer.php');
?>