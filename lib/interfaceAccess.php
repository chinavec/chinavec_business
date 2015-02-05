<?php
	$adminToken = isset($_POST['adminToken']) ? $_POST['adminToken'] : '';
	if($adminToken != '95c8130a063a7e393c7262dc2d3d464c'){
		header("HTTP/1.1 404 Not Found");  
		header("Status: 404 Not Found");  
		exit;
	}
?>