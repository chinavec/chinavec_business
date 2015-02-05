<?php
/**
 * 数据库操作工具类,完成对数据库（server表）的信息读取
 * 该类涉及到数据库的操作，使用该类时应该先行连接数据库
 */
class ResourceManage
{
	private $db;
	//构造函数
	public function __construct($db){
		$this->db = $db;
	}
	//资源列表，按资源名称升序，资源id倒序
	public function resourceLists($offset=0, $len=0, $state=array(0,1,2,10)){
		$state = implode(',', $state);
		$sql = "SELECT COUNT(`id`) FROM `server` ";
		$result['total'] = $this->db->count($sql);
		$sql = "SELECT `id`,`name`,`description`,`register_time`,`ip`,`resource_id`,`volume`	
				FROM `server` 
				ORDER BY `name` ASC ,`resource_id` DESC ";
		if($len > 0){
			$sql .= " LIMIT $offset,$len";
		}
		$result['list'] = $this->db->select($sql);
		return $result;
	}
}
?>