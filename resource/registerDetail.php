<?php
	/*
	 *注册资源详细信息界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('../../lib/util.class.php');
	require('class/register.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$db = new DB();
	$b = new Resource($db);
	$u = new Util();
	//获取id值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	//设置错误操作返回页面
	$back = $config['root']."admin/resource/registerIndex.php";
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		$info = $b->setServerID($id);
		if($info['operation']){
			$serverBasicInfo = $b->getServerInfo();
		}else{
			//未成功设置资源id，跳转到错误信息页面
			systemLog("注册资源详细信息页面，未成功设置注册资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
			exit();
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("注册资源详细信息页面，未找到对应的注册资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('没有找到对应的注册资源信息')."&back=".urlencode($back);
		header("Location: " . $errorURL);
		exit();
	}
	//关闭数据库
	$db->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册资源详细信息--云媒体管理中心</title>
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<link href="../../css/common_fang.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<link href="css/detail.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php include('../../common/admin_header.php');$db = new DB(); ?>
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
        <div id="container_right" class="rightDetail">
        	<div style="font-size:16px;padding:15px;font-weight:bold;border-bottom:1px dashed #999">
            	[注册资源名称]&nbsp;&nbsp;
				<?php echo $serverBasicInfo['name']; ?>&nbsp;&nbsp;<a style="font-size:9px" href="registerIndex.php">（查看所有注册资源）</a> 
            </div>
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
           		[资源类别]&nbsp;&nbsp;
                <a href="defineDetail.php?id=<?php echo $serverBasicInfo['resource_id'] ?>"> <?php $i=$serverBasicInfo['resource_id']; $result = $db -> select_condition_one('resource',array('id' => $i));echo $result->name;?></a>
            </div>
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[地址]&nbsp;&nbsp;
				<?php echo $serverBasicInfo['ip']; ?>
            </div>
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[容量]&nbsp;&nbsp;
				<?php echo $serverBasicInfo['volume']; ?>T
            </div>           
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[描述]&nbsp;&nbsp;
            	<?php echo $serverBasicInfo['description']; ?>
            </div>
            <div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[该资源的分配对象]&nbsp;&nbsp;
            	<?php $result = $db -> select_condition('resource_distribute',array('server_id' => $serverBasicInfo['serverID']));
				if($result){
					  for($i=0; $i<count($result); $i++){ 
					?> <a href="distributeDetail.php?id=<?php echo $result[$i]->id ?>"> <?php $i=$result[$i]->group_id; $resulta = $db -> select_condition_one('group',array('id' => $i));echo $resulta->group_name;?></a>&nbsp;&nbsp;
                    <?php 
						};		
				}else echo '无';	
                        ?>
            </div>
            <div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[管理]&nbsp;&nbsp;
                <?php
					echo '<td>&nbsp;<a href="registerModify.php?id='.$serverBasicInfo['serverID'].'&from='.$u->encodeCurrentURL().'">编辑</a>&nbsp;|';	
					echo '<a id="delete" href="registerDelete.php?id='.$serverBasicInfo['serverID'].'&from='.$u->encodeCurrentURL().'">删除</a>&nbsp;&nbsp;';
					?>
            </div>
            </div>
        </div>
    </div>
    <?php include('../../common/admin_footer.html'); ?>
    <script type="text/javascript">
	$('#delete').click(function(){
		if(confirm('确定要删除吗？')){
			window.location.href = $(this).href;
		}else{
			return false;
		}
	});
	</script>
</body>
</html>