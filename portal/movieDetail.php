<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>微院线播放</title>
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
</style>

<body>
<img src="img/vec_logo_left.jpg" width="240px" height="55" align="left">
<?php 
		session_start();
		$id = $_GET['id'];
		
		//检查该页面是否已合法获取视频ID及ID是否为数值型
		if (!(isset($_GET['id']) && ctype_digit($_GET['id']))) {
			header("Location:movie.php?msg=invalid");
			exit;
		}
		
		include "common/table.php";
		require "lib/connect.php";
		
		function sec2time($sec){	
			$sec = round($sec/60);
			if ($sec >= 60){
				$hour = floor($sec/60);
				$min = $sec%60;
				$res = $hour.'小时';
				$min != 0  &&  $res .= $min.'分';
			}else{
				$res = $sec.'分钟';
			}
			return $res;
			}
			
		$sql="select * from video WHERE `id` = $id";
		$result=mysql_query($sql);
		$row=mysql_fetch_object($result);
		//print_r($row);
	?>
<span style="float:right; color:#FFFFFF; font-size:14px; margin-right:10px;">您好，请登录</span>

<div id="layout">

    	<div id="movieTitle">
			<div style="float:left;">
            <p style="color:#FFFFFF; font-size:15px;"><?php echo $row->title_cn;?>
            &nbsp;&nbsp;<span style="color:#AAAAAA;font-size:12px;"><?php echo $row->title_en;?></span></p>
            <span style="color:#AAAAAA;font-size:12px;">ChinaVEC首页 >微院线&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row->tags;?></span>
            </div>
            <div style="float:right;">
            <form action="searchList.php" method="get">
                <input type="text" name="keyWord" placeholder="输入名称查询"  class="searchBlock"/>
                <input type="submit" value="搜索" class="searchButton"/>
            </form>
            </div>
        </div>
		
        <div style="margin-left:0;width:100%">
        <!--HTML5的video标签-->
			<video width="100%" controls id="video">
            	<?php 
					/*是否存在id.jpg的文件
					若存在$poster = $row['id'].".jpg"
					否则 $poster = 0.jpg*/
					$file = $config['videoRoot'].$config['video'].$row->id.".mp4";
					//echo $row->video_url;
					echo $file;
					//exit;
					if(file_exists($file)){
						$videoUrl = $file;
						echo $videoUrl."存在";
						//exit;
					}
					else{
						$videoUrl = $config['videoRoot'].$config['video']."0.mp4";
						//echo $videoUrl;
						//exit;
						}
				?>
			 	<source src="<?php echo $videoUrl;?>" type="video/mp4">
				<p>抱歉，您的浏览器不支持视频video标签</p>
                
             	<embed
					width="100%"
					type="application/x-shockwave-flash"
					id="player2"
					name="player2"
					src="swf/player.swf" 
					allowscriptaccess="always" 
					allowfullscreen="true"
					flashvars="file=<?php echo  $videoUrl;?>&image=<?php # ?>" 
				/>
				
			</video>
    	</div> 
</div> 
<a href="order.php?id=<?php echo $id; ?>"><button class="xuanze">加入到我的选择</button></a>
<!--movieDetail Start-->        
	<?php 
		$sec = $row->dur;
		$min = sec2time($sec);
	?>
    <div class="movieDetail"> 
    	<br/>
		<div class="movieDetail2">
            <div style="width:600px;margin:25px 10px 0px 30px;float:left;">
                <br/>
                <p class="jieshaoT">视频信息</p>
                <br/><br/>
                <!--<p>名称：<span><?php echo $row->title_cn;?></span></p>
                <p>制片人：<span><?php echo $row->producer;?></span></p>
                <p>导演：<span><?php echo $row->director;?></span></p>
                <p>演员：<span><?php echo $row->stars;?></span></p>
                <p>片长：<span><?php echo $min;?></span></p>
                <p>标签：<span><?php echo $row->tags;?></span></p>
                <br/><br/>
                <p>简介：<span class="greySmall"><?php echo $row->dscrp;?></span></p>-->
                <div class="p_half">
						<span class='gray14'>导演：</span>
                        <span class='black14'><?php echo $row->director;?></span>
                   </div>
					<div class="p_half">
                    	<span class='gray14'>主演：</span>
                        <span class='black14'><?php echo $row->stars;?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray14'>标签：</span>	
                        <span class='black14'><?php 
							$tags = $row->tags;
							$array = explode('；',$tags);
							//print_r($array);
							foreach((array)$array as $key => $tag){
								echo "<a href='searchTagList.php?tag=".$tag."'>".$tag."</a>";
								echo " ";
							}
						?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray14'>制片人：</span>	
                        <span class='black14'><?php echo $row->producer;?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray14'>年份：</span>	
                        <span class='black14'><?php echo $row->year;?></span><br/>
                    </div>
                    <div class="p_half">
                    <?php 
						$sec = $row->dur;
						$min = sec2time($sec);
					?>
                        <span class='gray14'>时长：</span>	
                        <span class='black14'><?php echo $min;?></span><br/>
                    </div>
                    <div style=" margin-top:30px;">   
                        <span class='gray14'>简介：</span>
                        <span class='gray14'><?php echo $row->dscrp;?></span><br/>
                	</div>
            </div>
            <div style="margin:25px 5px 0px 5px;float:right;">
            	<br/>
                <p class="jieshaoT">本周热播榜</p>
                <br/><br/>
                <table width="300px">
                <tr>
                    <td>1</td>
                    <td class="grey12">阿根达斯</td>
                    <td class="grey12">微电影</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="grey12">音乐星期五</td>
                    <td class="grey12">微栏目</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td class="grey12">爱的画工</td>
                    <td class="grey12">微动漫</td>
                </tr>
                <tr>
                	<td>4</td>
                    <td class="grey12">千百个</td>
                    <td class="grey12">微纪录</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td class="grey12">寒战</td>
                    <td class="grey12">微电影</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td class="grey12">假面骑士</td>
                    <td class="grey12">创意视频</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td class="grey12">爱嘉</td>
                    <td class="grey12">微电影</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td class="grey12">蠕动</td>
                    <td class="grey12">微电影</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td class="grey12">爱情的样子</td>
                    <td class="grey12">微电影</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td class="grey12">27岁</td>
                    <td class="grey12">微电影</td>
                </tr>
                </table>
              </div>
        </div>
    </div>
<!--movieDetail END-->       
    
    

<?php
	require('common/footer.php');
?>
