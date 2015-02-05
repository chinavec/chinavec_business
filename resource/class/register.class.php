<?php
/**
 * 数据库操作工具类,完成对数据库（server表）的基本操作
 * 该类涉及到数据库的操作，使用该类时应该先行连接数据库
 */
class Resource
{
	private $serverID;
	private $name;
	private $description;
	private $db;
	private $ServerID;
	private $ip;
	private $volume;
	private $resource_id;
	//构造函数
	public function __construct($db){
		$this->db = $db;
	}
	//设置资源ID
	public function setServerID($id){
		$this->serverID = $id;
		return $this->getInfoById($this->serverID);
	}
	//设置资源类各属性值
	public function setValue($values){
		foreach($values as $key => $item){
			$this->$key = $item;
		}
	}
	//获取各属性值，返回关联数组
	public function getServerInfo(){
		$c['ServerID'] = $this->ServerID;
		$c['serverID'] = $this->serverID;
		$c['name'] = $this->name;
		$c['description'] = $this->description;
		$c['ip'] = $this->ip;
		$c['volume'] = $this->volume;
		$c['resource_id'] = $this->resource_id;
		return $c;
	}
	//注册资源
	public function create(){
			//判断资源名称是否已经存在
			if(count($this->db->select_condition('server', array('name' => $this->name)))){
				return array('operation' => 0, 'info' => '资源注册失败，已存在的资源名');
			}else{
				//资源名不重复
				$row = array('name' => $this->name, 'description' => $this->description, 'ip' => $this->ip, 'volume' => $this->volume, 'resource_id' => $this->resource_id, 'register_time' => strtotime('now'));
				if($this->db->insert('server', $row)){
					return array('operation' => 1, 'info' => '资源注册成功');
				}else{
					return array('operation' => 0, 'info' => '资源注册失败，服务器错误，请重试');
				}
			}			
	}
	//更新资源信息
	public function update(){
				//判断资源名称是否已经存在
				$result = $this->db->select_condition_one('server', array('name' => $this->name));
				if($result && $result->id != $this->serverID){
					//资源名重复
					return array('operation' => 0, 'info' => '编辑资源失败，已存在的资源名');
				}else{
					$row = array('name' => $this->name, 'description' => $this->description, 'ip' => $this->ip, 'volume' => $this->volume, 'resource_id' => $this->resource_id);
					if($this->db->update('server', $row, array('id' => $this->serverID))){
						return array('operation' => 1, 'info' => '编辑资源成功');
					}else{
						return array('operation' => 0, 'info' => '编辑资源失败，服务器错误，请重试');
					}
				}			
	}
	//删除资源
	public function delete(){
				if($this->db->delete('server',  array('id' => $this->serverID ))){
					return array('operation' => 1, 'info' => '资源删除成功');
				}else{
					return array('operation' => 0, 'info' => '服务器繁忙，请稍后重试');
				}
	}
	//根据资源id查询资源信息
	private function getInfoById($_id){
		//判断是否存在对应传入id的资源	
		$result = $this->db->select_condition_one('server', array('id' => $_id));
		if(count($result)){
			//资源存在
			$c['ServerID'] = $result->id;
			$c['serverID'] = $result->id;
			$c['name'] = $result->name;
			$c['description'] = $result->description;
			$c['ip'] = $result->ip;
			$c['volume'] = $result->volume;
			$c['resource_id'] = $result->resource_id;
			$c['registerTime'] = $result->register_time;
			$now = strtotime('now');
			$this->setValue($c);
			return array('operation' => 1, 'info' => '成功获取并设置资源属性');
		}else{
			return array('operation' => 0, 'info' => '没有找到对应的资源');
		}
	}
}
?>