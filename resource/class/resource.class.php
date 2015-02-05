<?php
/**
 * 数据库操作工具类,完成对数据库（resource表）的基本操作
 * 该类涉及到数据库的操作，使用该类时应该先行连接数据库
 */
class Resource
{
	private $resourceID;
	private $name;
	private $description;
	private $db;
	private $ResourceID;
	private $required;
	//构造函数
	public function __construct($db){
		$this->db = $db;
	}
	//设置资源ID
	public function setResourceID($id){
		$this->resourceID = $id;
		return $this->getInfoById($this->resourceID);
	}
	//设置资源类各属性值
	public function setValue($values){
		foreach($values as $key => $item){
			$this->$key = $item;
		}
	}
	//获取各属性值，返回关联数组
	public function getResourceInfo(){
		$c['ResourceID'] = $this->ResourceID;
		$c['resourceID'] = $this->resourceID;
		$c['name'] = $this->name;
		$c['description'] = $this->description;
		$c['required'] = $this->required;
		return $c;
	}
	//创建资源
	public function create(){
			//判断资源名称是否已经存在
			if(count($this->db->select_condition('resource', array('name' => $this->name)))){
				return array('operation' => 0, 'info' => '资源定义失败，已存在的资源名');
			}else{
				//资源名不重复
				$row = array('name' => $this->name, 'description' => $this->description, 'required' => $this->required, 'create_time' => strtotime('now'));
				if($this->db->insert('resource', $row)){
					return array('operation' => 1, 'info' => '资源定义成功');
				}else{
					return array('operation' => 0, 'info' => '资源定义失败，服务器错误，请重试');
				}
			}			
	}
	//更新资源信息
	public function update(){
				//判断资源名称是否已经存在
				$result = $this->db->select_condition_one('resource', array('name' => $this->name));
				if($result && $result->id != $this->resourceID){
					//资源名重复
					return array('operation' => 0, 'info' => '编辑资源失败，已存在的资源名');
				}else{
					$row = array('name' => $this->name, 'description' => $this->description, 'required' => $this->required);
					if($this->db->update('resource', $row, array('id' => $this->resourceID))){
						return array('operation' => 1, 'info' => '编辑资源成功');
					}else{
						return array('operation' => 0, 'info' => '编辑资源失败，服务器错误，请重试');
					}
				}			
	}
	//删除资源
	public function delete(){
				if($this->db->delete('resource',  array('id' => $this->resourceID ))){
					return array('operation' => 1, 'info' => '资源删除成功');
				}else{
					return array('operation' => 0, 'info' => '服务器繁忙，请稍后重试');
				}
	}
	//根据资源id查询资源信息
	private function getInfoById($_id){
		//判断是否存在对应传入id的资源	
		$result = $this->db->select_condition_one('resource', array('id' => $_id));
		if(count($result)){
			//资源存在
			$c['ResourceID'] = $result->id;
			$c['resourceID'] = $result->id;
			$c['name'] = $result->name;
			$c['description'] = $result->description;
			$c['required'] = $result->required;
			$c['createTime'] = $result->create_time;
			$now = strtotime('now');
			$this->setValue($c);
			return array('operation' => 1, 'info' => '成功获取并设置资源属性');
		}else{
			return array('operation' => 0, 'info' => '没有找到对应的资源');
		}
	}
}
?>