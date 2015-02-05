<?php
/*日志公共函数
 *参数：
 *$message	string	需要记录的日志内容
 *$adminID	int		管理员ID
 *$level	int		日志级别（1为管理员登陆日志，2为管理员创建、编辑、删除等操作日志，3为注入、分发失败错误，5为系统错误（操作数据库失败等））
 *$db		Object	类DB的实例化对象
 */
	function systemLog($message, $adminID, $level, $db){
		//$db->insert('system_log', array('admin_id' => $adminID, 'level' => $level, 'messages' => $message, 'time' => strtotime('now')));暂时关闭系统日志
	}
?>