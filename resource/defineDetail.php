<?php
	/*
	 *定义资源详细信息界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('../../lib/util.class.php');
	require('class/resource.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$db = new DB();
	$b = new Resource($db);
	$u = new Util();
	//获取id值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	//设置错误操作返回页面
	$back = $config['root']."admin/resource/defineIndex.php";
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		$info = $b->setResourceID($id);
		if($info['operation']){
			$resourceBasicInfo = $b->getResourceInfo();
		}else{
			//未成功设置资源id，跳转到错误信息页面
			systemLog("定义资源详细信息页面，未成功设置定义资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
			exit();
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("定义资源详细信息页面，未找到对应的定义资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('没有找到对应的定义资源信息')."&back=".urlencode($back);
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
<title>资源详细信息--云媒体管理中心</title>
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
            	[名称]&nbsp;&nbsp;
				<?php echo $resourceBasicInfo['name']; ?>&nbsp;&nbsp;<a style="font-size:9px" href="defineIndex.php">（查看所有资源类别）</a> 
            </div> 
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[需求]&nbsp;&nbsp;
				<?php echo $resourceBasicInfo['required']; ?>
            </div>
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[描述]&nbsp;&nbsp;
            	<?php echo $resourceBasicInfo['description']; ?>
            </div>
            <div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[该资源类别下的注册资源]&nbsp;&nbsp;
            	<?php $result = $db -> select_condition('server',array('resource_id' => $resourceBasicInfo['resourceID']));
				if($result){
					  for($i=0; $i<count($result); $i++){ 
					?> <a href="registerDetail.php?id=<?php echo $result[$i]->id ?>"> <?php echo $result[$i]->name; ?></a>&nbsp;&nbsp;
                    <?php 
						};		
				}else echo '无';	
                        ?>
            </div>
        	<div style="font-size:14px;padding:15px;border-bottom:1px dashed #999">
            	[管理]&nbsp;&nbsp;
                <?php
					echo '<td>&nbsp;<a href="defineModify.php?id='.$resourceBasicInfo['resourceID'].'&from='.$u->encodeCurrentURL().'">编辑</a>&nbsp;|';	
					echo '<a id="delete" href="defineDelete.php?id='.$resourceBasicInfo['resourceID'].'&from='.$u->encodeCurrentURL().'">删除</a>&nbsp;&nbsp;';
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