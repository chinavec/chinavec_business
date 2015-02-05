<!--
    创建时间：		2014年1月13日
    编写人：			于鉴桐
    版本号：			v1.0
    
    修改记录：		原始版本v1.0				
                    
    主要功能点：		该页面用于用户搜索视频及结果处理。
    
    全局配置变量：	
                              
            
-->
<?php
session_start();

	include "lib/connect.php";
	require('lib/util.class.php');
	require('lib/db.class.php');//数据库操作类
	require('config/config.php');//系统总配置文件
	
	$db = new DB();
	$u = new Util();
	$keyWord = isset($_GET['keyWord']) ? $u->inputSecurity($_GET['keyWord']) : '';
	
	if($keyWord != ''){
		$sql = "SELECT * FROM `video` WHERE `title_cn` LIKE '%$keyWord%'  OR `tags` LIKE '%$keyWord%' OR `dscrp` LIKE '%$keyWord%' ";
		//echo '0'.$sql;
		/**搜索到标题包含关键字的内容**/
		if($result = $db->select($sql)){
				//echo "1".$sql;
				$warning = '';
		}
		else{
			//echo "2".$sql;
			/**未搜索到标题包含关键字的内容**/
				$warning = '没有找到您要查询的内容!';
				$sql = "SELECT * FROM `video` GROUP  BY  title_cn ORDER BY `id` DESC limit 0,5";
				$result = $db->select($sql);
			}
	}
	else{
		//echo "3".$sql;
		/**未进行搜索时，执行以下操作**/
		$warning = '请输入您要查询的关键字！';
		$sql = "SELECT * FROM `video` GROUP  BY  title_cn ORDER BY `id` DESC limit 0,5";
		$result = $db->select($sql);
	}
	
	/**将数据库中时长的秒数转换为分钟**/
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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>微院线播放</title>
<?php date_default_timezone_set("Asia/Shanghai");?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/searchList.css" />
</head>

<style type="text/css">
body {
	text-align:center;
	background:#333 repeat 0px 1px;
}
</style>

<body>
<img src="img/vec_logo_left.jpg" width="240px" height="55" align="left">
    <div id="layout">
		<?php 
            include "common/table.php"; //索引标题栏
        ?>   
	<div>
      
    <div style=" width:400px; height:80px; margin:0 auto; clear:both;border-radius: 2px;" class="search">
        <br/>
        <form action="searchList.php" method="get">
            <input type="text" name="keyWord" placeholder="<?php echo $keyWord;?>"  class="searchBlock"/>
            <input type="submit" value="搜索" class="searchButton"/>
        </form>
    </div>
    
<div style=" background-color:#FFFFFF; width:970px; margin:0 auto; clear:both; border-radius: 2px;" >
 		
		<?php 
		//$row = mysql_fetch_array($result);
		//print_r($row);
		echo "<span class='warning'>".$warning.'</span><br/>';
		echo "<ul>";
		if($warning!=''){
			echo "<div class='orange16'><span>&nbsp;&nbsp;&nbsp;&nbsp;热门推荐</span></div>";
			}
		else{
			}
		foreach((array)$result as $key => $row){ 
		//while($row = mysql_fetch_object($result)) {
			//print_r($row);
			//echo $row->id;
		?>
        
            <li class="mediaList">
                <div class="posterV"><a href="movieDetail.php?id=<?php echo $row->id; ?>">
                 <?php 
						/*是否存在id.jpg的文件
						若存在$poster = $row['id'].".jpg"
						否则 $poster = 0.jpg*/
						$file = $config['posterV'].$row->id.".jpg";
						if(file_exists($file)){
							$poster = $row->id.".jpg";
							//echo $poster;
							//exit;
						}
						else{
							$poster = "0.jpg";
							//echo $poster;
							//exit;
							}
					?>
                    <img class="poster" src="<?php echo $config['posterV'];echo $poster;?>" />
                </a></div>
                <div class="mediaInfo">
                    <h3 class="mediaTitle">
                    	<?php echo "<span class='gray14'>[微电影]</span>" ?>
                        <a href="movieDetail.php?id=<?php echo $row->id; ?>"><span style="color:#EB6100"><?php echo $row->title_cn;?></span></a>
                    	<?php echo "<span class='gray14'>&nbsp;--".$row->title_en."</span>" ?>
                    </h3>
                    <br/>
                    
                   <div class="p_half">
						<span class='gray12'>导演：</span>
                        <span class='black12'><?php echo $row->director;?></span>
                   </div>
					<div class="p_half">
                    	<span class='gray12'>主演：</span>
                        <span class='black12'><?php echo $row->stars;?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray12'>标签：</span>	
                        <span class='black12'><?php  
							$tags = $row->tags;
							$array = explode('；',$tags);
							//print_r($array);
							foreach((array)$array as $key => $tag){
								echo "<a href='searchTagList.php?tag=".$tag."'>".$tag."</a>";
								echo "&nbsp;&nbsp;&nbsp;";
							}
						?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray12'>制片人：</span>	
                        <span class='black12'><?php echo $row->producer;?></span><br/>
                    </div>
                    <div class="p_half">
                        <span class='gray12'>年份：</span>	
                        <span class='black12'><?php echo $row->year;?></span><br/>
                    </div>
                    <div class="p_half">
                    <?php 
						$sec = $row->dur;
						$min = sec2time($sec);
					?>
                        <span class='gray12'>时长：</span>	
                        <span class='black12'><?php echo $min;?></span><br/>
                    </div>
                    <div style="height:55px;">   
                        <span class='gray12'>简介：</span>
                        <span class='gray12'><?php echo $row->dscrp;?></span><br/>
                	</div>
                <div><a href="movieDetail.php?id=<?php echo $row->id;?>"><button class="buttonGreen">立即观看</button></a></div>
                </div>
                <div><hr style=" width:925px; margin-left:15px; margin-top:10px; float:left;border:1px solid #D9D9D9" /></div>
                <div style="clear:both"></div>
            </li>
			
		<?php }
		?>
        </ul>
        <span class="black12" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        共1页&nbsp;&nbsp;&nbsp;&nbsp;上一页&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;下一页</span>
        <div></br></div>
        </div>
        
        </div>
<?php
	require('common/footer.php');
?>
		