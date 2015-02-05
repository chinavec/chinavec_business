<?php
	/*
	 *已注册资源编辑界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/register.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$db = new DB();
	$b = new Resource($db);
	//设置错误操作返回页面
	$back = $config['root'] . 'admin/resource/registerIndex';
	//获取id值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置相应id信息
		$info = $b->setServerID($id);
		if($info['operation']){
			$serverBasicInfo = $b->getServerInfo();
		}else{
			//未成功设置注册资源id，跳转到错误信息页面
			systemLog("编辑注册资源页面，未成功设置注册资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
			exit();
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("编辑注册资源页面，未找到对应的注册资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('未找到对应的注册资源信息')."&back=".urlencode($back);
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
	#container_left ul li.register{background-color:#108dbd;}
	#container_left ul li.register a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../../img/lbg.gif'></img>").appendTo("#container_left ul li.register");
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
            <form id="modifyServer" name="modifyServer" action="doRegisterModify.php" method="post">
 			<table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:20%">
                   <tr>
                	<td width="10%" height="60px">资源类别：</td>
                    <td>
                    	<select name="resource_id" id="resource_id" style="width:245px;">
                        <option value='<?php echo $serverBasicInfo['resource_id'];?>'><?php $i=$serverBasicInfo['resource_id']; $db = new DB();$result = $db -> select_condition_one('resource',array('id' => $i));echo $result->name; ?> </option>
						<?php
                       $result = $db -> select_condition('resource');
					   for($i=0; $i<count($result); $i++){
                        ?>
                             <option value='<?php echo $result[$i]->id;?>'> <?php echo $result[$i]->name;?> </option>
                            <?php 
							};					
                        	?>				
                    	</select>
                    </td>
                    <th>&nbsp;&nbsp;(*必选项，资源类型)</th>
                  </tr>
                  <tr>
                    <td width="20%" height="60px">资源名称：</td>
                    <td width="30%"><input type="text" id="serverName" name="serverName" onfocus="myFocus_name(this,'#f4eaf1')" onblur="myblur_name(this,'white')" style="width:240px;height:40px;color:#CCC;"  value="<?php echo $serverBasicInfo['name']; ?>"/></td>
                    <th width="50%">&nbsp;&nbsp;(*必填，20个字符以内，注册资源名，可用数字编号或资源地址命名，例如AD108或222.125.3.1)</th>
                  </tr>	
                  <tr>
                    <td height="100px">资源地址：</td>
                    <td><input type="text" id="serverIp" name="serverIp" onfocus="myFocus_ip(this,'#f4eaf1')" onblur="myblur_ip(this,'white')"  style="width:240px;height:40px;color:#CCC;" value="<?php echo $serverBasicInfo['ip']; ?>"/></td>
                    <th>&nbsp;&nbsp;(*必填，20个字符以内，资源地址，例如222.125.31.1)</th>
                  </tr>
                  <tr>
                    <td height="50px">资源容量：</td>
                    <td><input type="text" id="volume" name="volume" onfocus="myFocus_volume(this,'#f4eaf1')" onblur="myblur_volume(this,'white')" style="width:240px;height:50px;color:#CCC;" value="<?php echo $serverBasicInfo['volume']; ?>"/></td>
                    <th>&nbsp;&nbsp;(*必填，20个字符以内，储存容量，默认单位为T，例如100T容量则填写数字100)</th>
                  </tr>
                  <tr>
                    <td height="120px">资源描述：</td>
                    <td><textarea id="description" name="description" onfocus="myFocus_description(this,'#f4eaf1')" onblur="myblur_description(this,'white')" style="width:240px;height:70px;color:#CCC"><?php echo $serverBasicInfo['description']; ?></textarea></td>
                    <th>&nbsp;&nbsp;(*必填，200个字符以内，资源性能描述，例如系统参数、构成)</th>
                  </tr>
                  <tr>
                    <td height="60px">注册时间：</td>
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="60px"><input type="image" id="sub" src='img/sub.jpg' value="提交" /></td>
                    <td><a href="registerIndex.php"><img style=" margin-left:60px" src='img/can.jpg'/></a></td>
                    <td><input type="hidden" id="serverID" name="serverID" value="<?php echo $serverBasicInfo['serverID']; ?>" /></td>
                    <td>&nbsp;</td>
                  </tr>
            </table>
            </form>
    </div>
    </div>
    <?php include('../../common/admin_footer.html'); ?>
	<script type="text/javascript">
	$(function(){
		//判断输入数据有效性
		$('#serverName').trigger('focus');
		$('#modifyServer').submit(function(e){
			var name = $('#serverName').val();
			var serverIp = $('#serverIp').val();
			var volume = $('#volume').val();
			var description = $('#description').val();
			if(name.length == 0 || name.length > 20){
				alert('资源名称为空或者超过20个字符');
				$('#serverName').trigger('focus');
				return false;
			}else if(serverIp.length == 0 || serverIp.length > 20){
				alert('资源地址为空或者超过20个字符');
				$('#serverip').trigger('focus');
				return false;
			}else if(volume.length == 0 || volume.length > 200){
				alert('资源容量为空或者超过20个字符');
				$('#volume').trigger('focus');
				return false;
			}else if(isNaN(volume)|| volume< 0){
				alert("请输入容量值为大于0的数字");
				$('#volume').trigger('focus');
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
	function myFocus_ip(obj,color){
		obj.style.backgroundColor="#F5F5F5";
		obj.style.color="#000";	
	}
	function myblur_ip(obj,color){
		obj.style.background=color;
		obj.style.color="#000";
	}
	function myFocus_volume(obj,color){
		obj.style.backgroundColor="#F5F5F5";
		obj.style.color="#000";	
	}
	function myblur_volume(obj,color){
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