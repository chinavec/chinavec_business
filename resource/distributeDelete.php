<?php
	/*
	 *删除已分配资源
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
	//获取id及from值
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$from = isset($_GET['from']) ? $_GET['from'] : $config['root']."admin/resource/distributeIndex.php";
	//判断id值有效性
	if(ctype_digit($id) && $id > 0){
		//查询数据库，设置资源id
		$info = $b->setDistributeID($id);
		if($info['operation']){
			$result = $b->delete();
			if($result['operation']){
				//删除资源成功
				systemLog("删除分配资源成功",1,2,$db);
				header('Location: ' . "distributeIndex.php");
			}else{
				//未成功删除资源，跳转到错误信息页面
				systemLog("未成功删除分配资源",1,5,$db);
				$errorURL =  "../../common/error.php?error=".urlencode($result['info'])."&back=".urlencode($from);
				header("Location: " . $errorURL);
			}
		}else{
			//未成功设置资源id，跳转到错误信息页面
			systemLog("删除分配资源，未成功设置分配资源id",1,5,$db);
			$errorURL =  "../../common/error.php?error=".urlencode($info['info'])."&back=".urlencode($from);
			header("Location: " . $errorURL);
		}
	}else{
		//未找到对应id的资源信息，跳转到错误信息页面
		systemLog("删除分配资源，未找到对应的分配资源信息",1,5,$db);
		$errorURL =  "../../common/error.php?error=".urlencode('没有找到对应的分配资源信息')."&back=".urlencode($from);
		header("Location: " . $errorURL);
	}
	//关闭数据库
	$db->close();
?>
    <script type="text/javascript">
	$(function(){
		$('.delete').click(function(){
			if(confirm('确定要删除吗？')){
				window.location.href = $(this).href;
			}else{
				return false;
			}
		});
	});
	</script>