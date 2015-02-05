<?php
	require('../../../lib/db.class.php');
	$db = new DB();
	$d = $db->select_condition('group');
	for($i=0;$i<count($d);$i++){
	 $d[$i]->group_name;
	 $d[$i]->id;
	}
	$m=array($d,count($d));
	echo json_encode($m);
?>