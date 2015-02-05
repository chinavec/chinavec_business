<?php
	/*
	 *已分配资源编辑界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/db.class.php');
	require('class/distribute.class.php');
	require('../../lib/log.php');
	//实例化数据库操作类
	$db = new DB();
	$b = new Resource($db);
	//设置错误操作返回页面
	$back = $config['root'] . 'admin/resource/distributeIndex';
	//获取id值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置相应id信息
		$info = $b->setDistributeID($id);
		if($info['operation']){
			$distributeBasicInfo = $b->getDistributeInfo();
		}else{
			//未成功设置分配资源id，跳转到错误信息页面
			systemLog("编辑分配资源页面，未成功设置分配资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($back);
			header("Location: " . $errorURL);
			exit();
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("编辑分配资源页面，未找到对应的分配资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('未找到对应的分配资源信息')."&back=".urlencode($back);
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
	#container_left ul li.distribute{background-color:#108dbd;}
	#container_left ul li.distribute a{color:#FFF;}
</style>
<script type="text/javascript">
	$(function(){
			$("<img src='../../img/lbg.gif'></img>").appendTo("#container_left ul li.distribute");
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
            <form id="modifyDistribute" name="modifyDistribute" action="doDistributeModify.php" method="post">
            <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:20%">
                  <tr>
                	<td width="12%" height="60px">资源名称：</td>
                    <td>
                    	<select name="server_id" id="server_id" style="width:235px;">
                        <option value='<?php echo $distributeBasicInfo['server_id'];?>'><?php $sid=$distributeBasicInfo['server_id'];$db = new DB(); $result = $db -> select_condition_one('server',array('id' => $sid));echo $result->name; ?>(<?php $ia=$result->resource_id;$resulta = $db -> select_condition_one('resource',array('id' => $ia));echo $resulta->name; ?>)</option>
						<?php
                       $result = $db -> select_condition('server');
					   for($i=0; $i<count($result); $i++){
                        ?>
                             <option value='<?php echo $result[$i]->id;?>'> <?php echo $result[$i]->name;?>(<?php $ib=$result[$i]->resource_id;$resultb = $db -> select_condition_one('resource',array('id' => $ib));echo $resultb->name; ?>) </option>
                            <?php 
							};					
                        	?>				
                    	</select>
                    </td>
                    <th>&nbsp;&nbsp;(*必选项，已注册资源，括号内为资源类型)</th>
                  </tr>
                  <tr>
                	<td height="70px">集团用户：</td>
                    <td>
                    	<select name="group_id" id="group_id" style="width:235px;">
                        <option value='<?php echo $distributeBasicInfo['group_id'];?>'><?php $gid=$distributeBasicInfo['group_id']; $result = $db -> select_condition_one('group',array('id' => $gid));echo $result->group_name; ?></option>			
                    	</select>
                    </td>
                    <th>&nbsp;&nbsp;(*必选项，资源分配对象，此页面不可修改)</th>
                  </tr>
                  <tr>
                    <td height="70px">分配容量：</td>
                    <td><input type="text" id="limit_volumeT" name="limit_volumeT"  onfocus="myFocus_limit_volumeT(this,'#f4eaf1')" onblur="myblur_limit_volumeT(this,'white')" style="width:235px;height:20px;color:#CCC" value="<?php echo $distributeBasicInfo['limit_volumeT']; ?>"></td>
                    <th>&nbsp;&nbsp;(*必填，20个字符以内,分配使用空间的数值，单位为T,例如分配50T至填写数字50)</th>
                  </tr>
                  <tr>
                  <tr>
                    <td height="100px">分配时间：</td>
                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="60px"><input type="image" id="sub" src='img/sub.jpg' value="提交" /></td>
                    <td> <a href="distributeIndex.php"><img style=" margin-left:60px" src='img/can.jpg'/></a></td>
                    <td><input type="hidden" id="distributeID" name="distributeID" value="<?php echo $distributeBasicInfo['distributeID']; ?>" /></td>
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
		$('#resource_id').trigger('focus');
		$('#modifyDistribute').submit(function(e){
			var limit_volumeT = $('#limit_volumeT').val();
			if(limit_volumeT.length == 0 || limit_volumeT.length > 20){
				alert('资源容量为空或者超过20个字符');	
				return false;
			}else if(isNaN(limit_volumeT || limit_volumeT< 0)){
				alert("请输入容量值为大于0的数字");
				$('#limit_volume').trigger('focus');
				return false;
			}
		});
	});
	function myFocus_limit_volumeT(obj,color){
		//设置文本框获取焦点时候背景颜色变换
		obj.style.backgroundColor="#F5F5F5";
		obj.style.color="#000";	
	}
	function myblur_limit_volumeT(obj,color){
		//当鼠标离开时候改变文本框背景颜色
		obj.style.background=color;
		obj.style.color="#000";
	}
	</script>
</body>
</html>