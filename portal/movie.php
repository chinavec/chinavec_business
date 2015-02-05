<!DOCTYPE HTML>
<html>
<head runat="server">
<meta charset="utf-8">
<title>微院线</title>

<?php
/*
 *在线用户量统计功能
 */

	require('../lib/http_client.class.php');
	require('../lib/db.class.php');
	require('../lib/log.php');
	
	//获取当前时间
	$strtime = date('Y-m-d');
	//将时间变量分割年月日
	$timearray = explode("-",$strtime);
	$year = $timearray[0];
	$month = $timearray[1];
	$day = $timearray[2];
	
	//实例化数据库操作类
	$db = new DB();
	//测试
	//$sql = "select count(*) from `site_visit_record` where `visit_time` >= ".$strtime;//`visit_time`大于等于当天凌晨的时间，即当天的时间

	//从user数据表中的login_time判断当天时间的登录用户数
	$sql = "select count(*) from `user` where `login_time` >= ".$strtime;//`login_time`大于等于当天凌晨的时间，即当天的时间
	$userData = $db->count($sql, $sqlOracle='');
	
	//统计当天用户数据存入user_statistics数据表	
	//设置存储数据库中的参数
	$row = array('user_total' => $userData, 'year' => $year, 'month' => $month, 'day' => $day);
	//调用数据库操作类中insert函数实行存储数据操作数，成功返回"OK"信息，失败返回"ERROR"信息
	if($db->insert('user_statistics', $row)){
		//echo "OK";
	}else{
		echo "ERROR";
		//调用日志函数生成日志
		systemLog('在线用户量统计失败', 1, 5, $db);
	}
	//关闭数据库
	$db->close();
 ?>
<?php date_default_timezone_set("Asia/Shanghai");
//('../support/dataAnalysis/userOnline.php');?>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/movie.js"></script>
<script type="text/javascript">
	//通过传图片的形式传当前网址新加入
	var img = new Image();
	img.src = 'http://localhost/chinavec/support/dataAnalysis/pageRecord.php?page=' + encodeURIComponent(window.location.href);//window.location.href获取网页网址新加入
</script>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/movie.css" />
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
		include('lib/connect.php'); //数据库连接文件

        $arr = array(
            "type_id" => 0,
            "dur" => 0,
            "year" => 0
        );
        if (isset($_POST['videotype'])) {
            $arr["type_id"] = $_POST['videotype'];
        }
        if (isset($_POST['dur'])) {
            $arr["dur"] = $_POST['dur'];
        }
        if (isset($_POST['year'])) {
            $arr["year"] = $_POST['year'];
        }
        // print_r($arr);

		//$type = $_GET['type']? $_GET['type']: '';//视频类型
		//$dur = $_GET['dur']? $_GET['dur']: '';//视频类型
		//$year = $_GET['year']? $_GET['year']: '';//视频类型
	?>
   
<div>
    <div style=" width:400px; height:80px; margin:0 auto; clear:both;border-radius: 2px;" class="search">
        <br/>
        <form action="searchList.php" method="get">
            <input type="text" name="keyWord" placeholder="输入名称查询" class="searchBlock"/>
            <input type="submit" value="搜索" class="searchButton"/>
        </form>
    </div>
    
    <div style="background-color:#FFFFFF; width:970px; height:260px; margin:0 auto; clear:both; border-radius: 2px;" >
        <div style=" width:970px; height:230px; margin:0 auto;">
         <br/>
		<form id="form1" method="post" action="movie.php" runat="server"> 
        <ul class="select">
            <li class="select-list">
                <dl id="select1">
                    <dt>视频类型：</dt>
                    <?php
                        $videotype = array('全部','微电影','微纪录','微栏目','微动漫','创意视频','信息视频');
                        foreach ($videotype as $key => $value) {
                            $class = array();
                            if ($key == 0) {
                                $class[] = "select-all";
                            }
                            if ($key == intval($arr['type_id'])) {
                                $class[] = "selected";
                            }
                            $class = implode(" ", $class);
                            echo <<<DD
                            <dd class="$class"><span tag="$key">$value</span></dd>
DD;
                        }
                    ?>
                    <!--dd class="select-all selected"><span tag="0">全部</span></dd>
                    <dd><span tag="1">微电影</span></dd>
                    <dd><span tag="2">微纪录</span></dd>
                    <dd><span tag="3">微栏目</span></dd>
                    <dd><span tag="4">微动漫</span></dd>
                    <dd><span tag="5">创意视频</span></dd>
                    <dd><span tag="6">信息视频</span></dd-->
                </dl>
            </li>
            <li class="select-list">
                <dl id="select2">
                    <dt>视频时长：</dt>
                    <?php
                        $videodur = array(
                            "0" => "全部",
                            "300" => "5分钟内",
                            "900" => "5-15",
                            "1800" => "15-30",
                            "1801" => "30分钟以上"
                        );

                        foreach ($videodur as $key => $value) {
                            $class = array();
                            if ($key == 0) {
                                $class[] = "select-all";
                            }
                            if ($key == $arr['dur']) {
                                $class[] = "selected";
                            }
                            $class = implode(" ", $class);
                            echo <<<DD
                            <dd class="$class"><span tag="$key">$value</span></dd>
DD;
                        }
                    ?>

                    <!--dd class="select-all selected"><span tag="0">全部</span></dd>
                    <dd><span tag="300">5分钟内</span></dd>
                    <dd><span tag="900">5-15</span></dd>
                    <dd><span tag="1800">15-30</span></dd>
                    <dd><span tag="1801">30分钟以上</span></dd-->
                </dl>
            </li>
            <li class="select-list">
                <dl id="select3">
                    <dt>上映时间：</dt>
                    <?php
                        $videoyear = array(
                            "0" => "全部",
                            "2014" => "2014",
                            "2013" => "2013",
                            "2012" => "2012",
                            "2011" => "其他"
                        );

                        foreach ($videoyear as $key => $value) {
                            $class = array();
                            if ($key == 0) {
                                $class[] = "select-all";
                            }
                            if ($key == $arr['year']) {
                                $class[] = "selected";
                            }
                            $class = implode(" ", $class);
                            echo <<<DD
                            <dd class="$class"><span tag="$key">$value</span></dd>
DD;
                        }
                    ?>
                    <!--dd class="select-all selected"><span tag="0">全部</span></dd>
                    <dd><span tag="2014">2014</span></dd>
                    <dd><span tag="2013">2013</span></dd>
                    <dd><span tag="2012">2012</span></dd>
                    <dd><span tag="2011">其他</span></dd-->
                </dl>
            </li>
            <li class="select-result">
                <dl>
                    <dt>已选条件：</dt>
                    <?php
                        $isset = 0;
                        foreach ($arr as $key => $value) {
                            if ($value != 0) {
                                switch ($key) {
                                    case 'type_id':
                                        echo <<<DD
                                        <dd class="selected" id="selectA"><span tag="$value">{$videotype[$value]}</span></dd>
DD;
                                        break;
                                    case 'dur':
                                        echo <<<DD
                                        <dd class="selected" id="selectB"><span tag="$value">{$videodur[$value]}</span></dd>
DD;
                                        break;
                                    case 'year':
                                        echo <<<DD
                                        <dd class="selected" id="selectC"><span tag="$value">{$videoyear[$value]}</span></dd>
DD;
                                        break;
                                }
                            } else {
                                if ((++$isset) == 3) {
                                    echo <<<DD
                                <dd class="select-no">暂时没有选择过滤条件</dd>
DD;
                                }
                                
                            }
                        }
                    ?>
                    <!--dd class="selected" id="selectB"><span tag="300">5分钟内</span></dd>
                    <dd class="select-no">暂时没有选择过滤条件</dd-->
                </dl>
       		</li>
       </ul> 
       <div><input type="submit" id="submit"  style=" float:right" class="filterButton" value="提交筛选" /></div>
	   <?php
            echo <<<HIDDEN
    		<input type="hidden" id="type" name="videotype" value="{$arr['type_id']}" />
            <input type="hidden" id="dur" name="dur" value="{$arr['dur']}" />
            <input type="hidden" id="year" name="year" value="{$arr['year']}" />
HIDDEN;
        ?>
	</form> 
       <!-- <form action="" method="post">
            <input type="hidden" id="filterA" name="filterA"/>
            <input type="hidden" id="filterB" name="filterB"/>
            <input type="hidden" id="filterC" name="filterC"/>
            <input type="submit" id="submit" value="确定" class="searchButton"/>
        </form>-->
        </div>
    </div>
    
    <div style="height:15px;"></div>
    
	<div style=" background-color:#FFFFFF; width:970px; height:670px; margin:0 auto; clear:both; border-radius: 2px;" >       
    <?php
        $tmp = array();
        foreach ($arr as $key => $value) {
            if ($value != 0) {
                $tmp[] = "$key=$value";
            }
        }
        $condition = implode(' and ', $tmp);
        if (!$condition) {
            $condition = 1;
        }

        $Page_size=8; //每页显示的条目数
		$sql="select * from video where $condition
				group by title_cn 
				ORDER BY `id` DESC ";
        // print_r($sql);

        $result=mysql_query($sql);
		//$row=mysql_fetch_array($result);
		//print_r($row);
		
        $count = mysql_num_rows($result); 
        $page_count = ceil($count/$Page_size); //总显示页数
        if($page_count<=0){$page_count=1;}
        $init=1; 
        $page_len=7; 
        $max_p=$page_count;
        $pages=$page_count;
        
        //判断当前页码 
        if (empty($_GET['page'])||$_GET['page']<1) { 
            $page=1; 
        } else { 
            $page=$_GET['page']; 
        } 
        $offset=$Page_size*($page-1); 




    	$sql="select * from video where $condition
    		group by title_cn 
    		ORDER BY `id` DESC 
    		limit $offset,$Page_size";  
    	$result=mysql_query($sql);
			
	?>
 <!--显示视频图片及名称列表List START-->           
           <?php  while ($row=mysql_fetch_array($result)) { ?>
           <div style="width:200px; margin-top:40px; margin-left:27px; float:left; border-radius: 5px;">    
                <div style="margin:0px auto;">
                    <a href="movieDetail.php?id=<?php echo $row['id']?>">
                    <?php 
						/*是否存在id.jpg的文件
						若存在$poster = $row['id'].".jpg"
						否则 $poster = 0.jpg*/
						$file = $config['posterV'].$row['id'].".jpg";
						if(file_exists($file)){
							$poster = $row['id'].".jpg";
							//echo $poster;
							//exit;
						}
						else{
							$poster = "0.jpg";
							//echo $poster;
							//exit;
							}
					?>
                    <img src="<?php echo $config['posterV'];echo $poster;?>" width="150px" height="210px" style="margin-left:30px;"/>
                	</a>
                </div>
                <div style="width:200px; margin:0px auto;">
                    <a href="movieDetail.php?id=<?php echo $row['id']?>">
                    <p align="center" class="black14"><?php echo $row['title_cn']?></p></a>
                    <a href="movieDetail.php?id=<?php echo $row['id']?>">
                    <p align="center" class="stars"><?php echo $row['stars']?></p></a>
                </div>
            </div>
            <?php } ?>
  <!--List END-->                
            
            <?php
                $page_len = ($page_len%2)?$page_len:$pagelen+1;//页码个数 
                $pageoffset = ($page_len-1)/2;//页码个数左右偏移量 
                
                $key='<div class="page">'; 
                $key.="<span>$page/$pages&nbsp;&nbsp;</span> "; //第几页,共几页 
                if($page!=1){ 
                $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=1\"><span>&nbsp;第一页&nbsp;</span></a> "; //第一页 
                $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\"><span>&nbsp;上一页&nbsp;</span></a>"; //上一页 
                }else { 
                $key.="&nbsp;第一页&nbsp;";//第一页 
                $key.="&nbsp;上一页&nbsp;"; //上一页 
                } 
                if($pages>$page_len){ 
                //如果当前页小于等于左偏移 
                if($page<=$pageoffset){ 
                $init=1; 
                $max_p = $page_len; 
                }else{//如果当前页大于左偏移 
                //如果当前页码右偏移超出最大分页数 
                if($page+$pageoffset>=$pages+1){ 
                $init = $pages-$page_len+1; 
                }else{ 
                //左右偏移都存在时的计算 
                $init = $page-$pageoffset; 
                $max_p = $page+$pageoffset; 
                } 
                } 
                } 
                for($i=$init;$i<=$max_p;$i++){ 
                if($i==$page){ 
                $key.=' <span>'.$i.'</span>'; 
                } else { 
                $key.=" <a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a>"; 
                } 
                } 
                if($page!=$pages){ 
                $key.="<a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\">&nbsp;下一页&nbsp;</a> ";//下一页 
                $key.="<a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">&nbsp;最后一页&nbsp;</a>"; //最后一页 
                }else { 
                $key.="&nbsp;下一页&nbsp; ";//下一页 
                $key.="&nbsp;最后一页&nbsp;"; //最后一页 
                } 
                $key.='</div>'; 
                ?>
				<div class="page"><?php echo $key?></div>
		
      <!--  <div style="width:200px; margin-top:40px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/yirenyihua.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="black14"><?php //echo $row['title_cn']?></p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>
 		<div style="width:200px; margin-top:40px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/bianshenmunv.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">变身母女</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>

 		<div style="width:200px;; margin-top:40px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/mingriqihang.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">明日起航</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>

 		<div style="width:200px; margin-top:40px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/xiyouxiangmo.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">西游降魔</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>

 		<div style="width:200px; margin-top:10px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/xiyouxiangmo.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">西游降魔</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>
		
        
        <div style="width:200px;; margin-top:10px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/mingriqihang.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">明日起航</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>
        
        <div style="width:200px; margin-top:10px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/bianshenmunv.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">变身母女</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>
        
        <div style="width:200px; margin-top:10px; margin-left:27px; float:left; border-radius: 5px;">
            <div style="margin:0px auto;">
            	<img src="img/yirenyihua.jpg" width="150px" height="210px" style="margin-left:30px;"/>
            </div>
            <div style="width:200px; margin:0px auto;">
                <p align="center" class="name">一人一花</p>
                <p align="center" class="actor">主演：甲乙丙丁</p>
            </div>
        </div>-->
</div>
</div>

<?php

	require('common/footer.php');
?>