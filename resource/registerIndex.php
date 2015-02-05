<?php
	/*
	 *注册资源报表界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('../../lib/util.class.php');
	require('class/registerManage.class.php');
	require('class/register.class.php');
	//设置接收对应info值的返回信息
	$infoValid = array('编辑资源成功', '注册资源成功');
	//实例化数据库操作类
	$db = new DB();
	$rm = new ResourceManage($db);
	$u = new Util();
	$rma = new Resource($db);
	$serverBasicInfo = $rma->getServerInfo();
	//获得info值
	$info = isset($_GET['info']) ? $_GET['info'] : '';
	//设置一页显示的资源数
	$pageSize = 10;
	$page = isset($_GET['page']) ? $_GET['page'] : 0;
	if(!(ctype_digit($page) && $page > 0)){
		$page = 1;
	}
	$offset = ($page - 1) * $pageSize;
	$q = isset($_GET['q']) ? $_GET['q'] : '';
	if($q != ''){
		$q = $u->inputSecurity($q);
		$resourceLists = $rm->searchResourceByName($q, $offset, $pageSize, array(0,1,2));
	}else{
		$resourceLists = $rm->resourceLists($offset, $pageSize, array(0,1,2));
	}
	$basicURL = 'registerIndex.php?q='.$q;
	$pageInfo = $u->page($resourceLists['total'], $page, $pageSize);
	//关闭数据库
	$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源监控--云媒体管理中心</title>
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<style>
	#container_left ul li.registerIndex{background-color:#108dbd;}
	#container_left ul li.registerIndex a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../../img/lbg.gif'></img>").appendTo("#container_left ul li.registerIndex");
		});
</script>
<link href="css/index.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php include('../../common/admin_header.php'); $db = new DB();?>
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="right">
        	<table class="ctable" width="96%" style="margin-left:2%;margin-top:10px">
            	<thead>
                	<tr>
                    	<th width="15%">资源名称</th>
                        <th width="13%">资源类型</th>
                        <th width="15%">资源地址</th>
                        <th width="10%">资源容量</th>
                        <th width="24%">描述</th>
                        <th width="11%">注册时间</th>
                        <th width="12%">管理</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($resourceLists['list'] as $item): ?>
                	<tr>
                    	<td style="word-break:break-all"><a href="registerDetail.php?id=<?php echo $item->id; ?>"><?php echo $item->name; ?></a></td>
                    	<td style="word-break:break-all"><?php $i=$item->resource_id; $result = $db -> select_condition_one('resource',array('id' => $i));echo $result->name; ?></td>
                        <td style="word-break:break-all" ><?php echo $item->ip; ?></td>
                        <td style="word-break:break-all" ><?php echo $item->volume; ?>T</td>
                        <td style="word-break:break-all" ><?php echo $item->description; ?></td>
                        <td ><?php echo date('Y-m-d', $item->register_time); ?></td>
                        <?php
							echo '<td>&nbsp;<a href="registerModify.php?id='.$item->id.'&from='.$u->encodeCurrentURL().'">编辑</a>&nbsp;|';				
							echo '<a id="delete" href="registerDetail.php?id='.$item->id.'&from='.$u->encodeCurrentURL().'">删除</a>'.'</td>';		
						?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!--page start-->
            <div class="page">
            <?php if($pageInfo['pages'] <= 1): ?>
                <p class="sysinfo">仅有当前一页</p>
            <?php else: ?>
                <a class="mybutton ib" href="<?php echo $basicURL;?>&page=1">第一页</a>
                <?php 
                if($pageInfo['now'] == 1){
                    echo '<span class="mybutton ib">上一页</span>';
                }else{
                    echo '<a class="mybutton ib" href="'.$basicURL.'&page='.($pageInfo['now']-1).'">上一页</a>';
                }
                ?>
            <?php foreach($pageInfo['range'] as $item): ?>
            <?php 
            if($pageInfo['now'] == $item){
                echo '<span class="cur">'.$item.'</span>';
            }else{
                echo '<a class="ib mybutton" href="'.$basicURL.'&page='.$item.'">'.$item.'</a>';
            }
            ?>
            <?php endforeach; ?>
                <?php 
                if($pageInfo['now'] == $pageInfo['pages']){
                    echo '<span class="mybutton ib">下一页</span>';
                }else{
                    echo '<a class="mybutton ib" href="'.$basicURL.'&page='.($pageInfo['now']+1).'">下一页</a>';
                }
                ?>
                <a class="mybutton ib" href="<?php echo $basicURL.'&page='.$pageInfo['pages']; ?>">最后页</a>
            <?php endif; ?>
            </div>
            <!--page end-->
        </div>
    </div>
    <?php include('../../common/admin_footer.html'); ?>
    <?php if(in_array($info, $infoValid)): ?>
    <div id="sysinfo"><span><?php echo $info; ?></span></div>
    <?php endif; ?>
</body>
</html>