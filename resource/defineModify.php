<?php
	/*
	 *已定义资源编辑界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/resource.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$db = new DB();
	$b = new Resource($db);
	//设置错误操作返回页面
	$back = $config['root'] . 'admin/resource/defineIndex';
	//获取id值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置相应id信息
		$info = $b->setResourceID($id);
		if($info['operation']){
			$resourceBasicInfo = $b->getResourceInfo();
		}else{
			//未成功设置定义资源id，跳转到错误信息页面
			systemLog("编辑定义资源页面，未成功设置定义资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
			exit();
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("编辑定义资源页面，未找到对应的定义资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('未找到对应的定义资源信息')."&back=".urlencode($back);
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
<title>编辑资源--云媒体管理中心</title>
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<link href="../../css/common_fang.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<link href="css/modify.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery-1.7.1.min.js"></script>
<style>
	#container_left ul li.define{background-color:#108dbd;}
	#container_left ul li.define a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../../img/lbg.gif'></img>").appendTo("#container_left ul li.define");
		});
</script>
</head>
<body>
	<?php include('../../common/admin_header.php'); ?>
    <div id="container" class="clearfix">
    	<div id="container_left" class="left">
			<?php include("common/leftMenu.html"); ?>
        </div>
  <div id="container_right" class="rightIndex">
        	<h2 class="mytitle" id="title">编辑资源</h2>
            <form id="modifyResource" name="modifyResource" action="doDefineModify.php" method="post">
            <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:20%">
                  <tr>
                    <td width="15%" height="60px">资源名称：</td>
                    <td width="30%"><input type="text" id="resourceName" name="resourceName" style="width:200px;color:#CCC;" onfocus="myFocus_name(this,'#f4eaf1')" onblur="myblur_name(this,'white')"  value="<?php echo $resourceBasicInfo['name']; ?>"/></td>
                    <th width="55%">&nbsp;&nbsp;(*必填，20个字符以内,资源类型名称，例如视频服务器)</th>
                  </tr>
                  <tr>
                    <td height="100px">资源需求：</td>
                    <td><textarea id="required" name="required" onfocus="myFocus_required(this,'#f4eaf1')" onblur="myblur_required(this,'white')" style="width:200px;height:70px;color:#CCC;"><?php echo $resourceBasicInfo['required']; ?></textarea></td>
                    <th>&nbsp;&nbsp;(*必填，200个字符以内，资源使用对象，列如为视音频数据进行压缩编码、存储处理)</th>
                  </tr>
                  <tr>
                    <td height="120px">资源描述：</td>
                    <td><textarea id="description" name="description" onfocus="myFocus_description(this,'#f4eaf1')" onblur="myblur_description(this,'white')" style="width:200px;height:80px;color:#CCC;"><?php echo $resourceBasicInfo['description']; ?></textarea></td>
                    <th>&nbsp;&nbsp;(*必填，200个字符以内，资源性能参数，列如视音频压缩编码器、输入/输出通道、网络接口、视音频接口、RS485/RS232串行接口、软件接口等)</th>
                  </tr>
                  <tr>
                  <tr>
                    <td height="60px">创建时间：</td>
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="60px"><input type="image" id="sub" src='img/sub.jpg' value="提交" /></td>
                    <td><a href="defineIndex.php"><img style=" margin-left:60px" src='img/can.jpg'/></a></td>
                    <td><input type="hidden" id="resourceID" name="resourceID" value="<?php echo $resourceBasicInfo['resourceID']; ?>" /></td>
                  </tr>
            </table>
            </form>
    </div>
    </div>
    <?php include('../../common/admin_footer.html'); ?>
    <script type="text/javascript">
	$(function(){
		//判断输入数据有效性
		$('#resourceName').trigger('focus');
		$('#modifyResource').submit(function(e){
			var name = $('#resourceName').val();
			var required = $('#required').val();
			var description = $('#description').val();
			if(name.length == 0 || name.length > 20){
				alert('资源名称为空或者超过20个字符');
				$('#resourceName').trigger('focus');
				return false;
			}else if(required.length == 0 || required.length > 200){
				alert('资源需求为空或者超过200个字符');
				$('#required').trigger('focus');
				return false;
			}else if(description.length == 0 || description.length > 200){
				alert('资源描述为空或者超过200个字符');
				$('#description').trigger('focus');
				return false;
			}
		});	
	});
	function myFocus_name(obj,color){
		//设置文本框获取焦点时候背景颜色变换
		obj.style.backgroundColor="#F5F5F5";	
		obj.style.color="#000";
	}
	function myblur_name(obj,color){
		//当鼠标离开时候改变文本框背景颜色
		obj.style.background=color;
		obj.style.color="#000";
	}
	function myFocus_required(obj,color){
		obj.style.backgroundColor="#F5F5F5";
		obj.style.color="#000";	
	}
	function myblur_required(obj,color){
		obj.style.background=color;
		obj.style.color="#000";
	}
	function myFocus_description(obj,color){
		obj.style.backgroundColor="#F5F5F5";
		obj.style.color="#000";		
	}
	function myblur_description(obj,color){
		obj.style.background=color;
		obj.style.color="#000";
	}
	</script>
</body>
</html>