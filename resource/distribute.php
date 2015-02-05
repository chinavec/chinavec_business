<?php
	/*
	 *资源分配界面
	 *陈鑫
	 *V1.0
	 *2013-6-5
	 */
	require('config/config.php');
	require('../../lib/http_client.class.php');
	require('../../lib/db.class.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>资源分配--云媒体管理中心</title>
<link href="../../css/base.css" rel="stylesheet" type="text/css" />
<link href="../../css/common_fang.css" rel="stylesheet" type="text/css" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
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
        	<h2 class="mytitle" id="title">分配资源</h2>
            <form id="distributeResource" name="distributeResource" action="doDistribute.php" method="post">
            <table width="70%" border="0" cellspacing="0" cellpadding="0" style="margin-left:20%">
                  <tr>
                	<td  width="12%" height="70px">资源名称：</td>
                    <td>
                    	<select name="server_id" id="server_id" style="width:235px;">
                        <option value='null'>请选择资源名称</option>
						<?php
					    $db = new DB();
                        $result = $db -> select_condition('server');
					    for($i=0; $i<count($result); $i++){
                        ?>
                             <option value='<?php echo $result[$i]->id;?>'> <?php echo $result[$i]->name;?> (<?php $ia=$result[$i]->resource_id;$resulta = $db -> select_condition_one('resource',array('id' => $ia));echo $resulta->name; ?>)	 </option>
                            <?php 
							};					
                        	?>				
                    	</select>
                    </td>
                    <th>&nbsp;&nbsp;(*必选项，已注册资源，括号内为资源类型)</th>
                  </tr>
                  <tr>
                	<td  height="70px">集团用户：</td>
                    <td>
                    	<select name="group_id" id="group_id" style="width:235px;">
                        <option value='null'>请选择集团用户</option>
						<?php
                        $interfaceAddress = 'http://localhost' . $config['root'] .
						'admin/resource/interface/groupList.php';
						$http = new Http_Client();
						$result = json_decode($http->Post($interfaceAddress), true);
						for($i=0;$i<$result[1];$i++){
						$result1 = $db -> select_condition_one('resource_distribute',array('group_id' => $result[0][$i]['id'])); 
						if(!($result1->group_id)){
                        ?>
                             <option value='<?php echo $result[0][$i]['id'];?>'> <?php echo  $result[0][$i]['group_name'];?> </option>
                            <?php 
							};
						};
                        	?>				
                    	</select>
                    </td>
                    <th>&nbsp;&nbsp;(*必选项，资源分配对象，每一分配对象有且仅有一条分配记录)</th>
                  </tr>
                  <tr>
                    <td  height="70px">分配容量：</td>
                    <td ><input type="text" id="limit_volumeT" name="limit_volumeT"  onfocus="myFocus_limit_volumeT(this,'#f4eaf1')" onblur="myblur_limit_volumeT(this,'white')" style="width:235px;height:20px;color:#CCC" value="请输入分配容量，如50（默认单位为TB）" /></td>
                    <th>&nbsp;&nbsp;(*必填，20个字符以内,分配使用空间的数值，单位为T,例如分配50T至填写数字50)</th>
                  </tr>
                  <tr>
                  <tr>
                    <td height="100px">分配时间：</td>
                    <td><?php echo date('Y-m-d H:i:s');?></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
               	    <td height="60px"><input type="image" id="sub" src='img/sub.jpg' value="提交" /></td>
                    <td><a href="distributeIndex.php"><img style=" margin-left:60px" src='img/can.jpg'/></a></td>
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
		$('#distributeResource').submit(function(e){
			var limit_volumeT = $('#limit_volumeT').val();
			var server_id = $('#server_id').val();
			var group_id = $('#group_id').val();
			if(server_id == 'null'){
				alert('请选择资源名称');
				$('#server_id').trigger('focus');
				return false;
			}else if(group_id == 'null'){
				alert('请选择集团用户');
				$('#group_id').trigger('focus');
				return false;
			}else if(limit_volumeT == "请输入分配容量，如50（默认单位为TB）" || limit_volumeT.length > 20){
				alert('资源容量为空或者超过20个字符');
				return false;
			}else if(isNaN(limit_volumeT) || limit_volumeT< 0){
				alert("请输入容量值为大于0的数字");
				$('#volume').trigger('focus');
				return false;
			}
		});
	});
	function myFocus_limit_volumeT(obj,color){
		//判断文本框中的内容是否是默认内容
		if(obj.value=="请输入分配容量，如50（默认单位为TB）"){
			obj.value="";
		}
		//设置文本框获取焦点时候背景颜色变换
			obj.style.backgroundColor="#F5F5F5";
			obj.style.color="#000";	
	}
	function myblur_limit_volumeT(obj,color){
		//当鼠标离开时候改变文本框背景颜色
		obj.style.background=color;
		if(obj.value==""){
			obj.value="请输入分配容量，如50（默认单位为TB）";
			obj.style.color="#CCC";
		}
		else{
			obj.style.color="#000";
		}
	}
	</script>
</body>
</html>