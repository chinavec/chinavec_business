<?php
	require('../../../lib/connect.php');
	require('../../../lib/db.class.php');
	require('../../../config/config.php');
	require('../../../lib/http_client.class.php');
	$size=$_POST['size'];
	$group_id=$_POST['group_id'];
	$str = 0;
	$db = new DB();
	$d = $db->select_condition_one('resource_distribute',array('id' => $group_id));
	$volume = $d->limit_volume;
	$e = $db->select_condition('video', array('group_id' => $group_id));
	for($i=0; $i<count($e); $i++){
	$str = $str + $e[$i]->file_size;
	}
	$row=array('used_volume' => $str);
	$f=$db->update('resource_distribute',$row, array('group_id' => $group_id));
	$re=$volume-$str;
	if($size>$re){
	$siz1e=1;
	echo json_encode($siz1e);
	}
	else{
	$siz1e=0;
	echo json_encode($siz1e);
	}
?>
