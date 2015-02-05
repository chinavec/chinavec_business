<?php
/**
 * 数据库操作工具类,完成对数据库（resource_distribute表）的基本操作
 * 该类涉及到数据库的操作，使用该类时应该先行连接数据库
 */
class Resource
{
	private $distributeID;
	private $db;
	private $DistributeID;
	private $group_id;
	private $server_id;
	private $limit_volumeT;
	private $limit_volume;
	//构造函数
	public function __construct($db){
		$this->db = $db;
	}
	//设置资源ID
	public function setDistributeID($id){
		$this->distributeID = $id;
		return $this->getInfoById($this->distributeID);
	}
	//设置资源类各属性值
	public function setValue($values){
		foreach($values as $key => $item){
			$this->$key = $item;
		}
	}
	//获取各属性值，返回关联数组
	public function getDistributeInfo(){
		$c['DistributeID'] = $this->DistributeID;
		$c['distributeID'] = $this->distributeID;
		$c['limit_volumeT'] = $this->limit_volumeT;
		$c['limit_volume'] = $this->limit_volume;
		$c['group_id'] = $this->group_id;
		$c['server_id'] = $this->server_id;
		return $c;
	}
	//分配资源
	public function create(){
				$row = array('limit_volume' => $this->limit_volume,'limit_volumeT' => $this->limit_volumeT, 'group_id' => $this->group_id, 'server_id' => $this->server_id,  'distribute_time' => strtotime('now'));
				if($this->db->insert('resource_distribute', $row)){
					return array('operation' => 1, 'info' => '资源分配成功');
				}else{
					return array('operation' => 0, 'info' => '资源分配失败，服务器错误，请重试');
				}	
	}
	//更新资源信息
	public function update(){
					$row = array('limit_volume' => $this->limit_volume, 'limit_volumeT' => $this->limit_volumeT,'group_id' => $this->group_id, 'server_id' => $this->server_id);
					if($this->db->update('resource_distribute', $row, array('id' => $this->distributeID))){
						return array('operation' => 1, 'info' => '编辑资源成功');
					}else{
						return array('operation' => 0, 'info' => '编辑资源失败，服务器错误，请重试');
					}
	}
	//删除资源
	public function delete(){
				if($this->db->delete('resource_distribute',  array('id' => $this->distributeID ))){
					return array('operation' => 1, 'info' => '资源删除成功');
				}else{
					return array('operation' => 0, 'info' => '服务器繁忙，请稍后重试');
				}
	}
	//根据资源id查询资源信息
	private function getInfoById($_id){
		//判断是否存在对应传入id的资源	
		$result = $this->db->select_condition_one('resource_distribute', array('id' => $_id));
		if(count($result)){
			//资源存在
			$c['DistributeID'] = $result->id;
			$c['distributeID'] = $result->id;
			$c['limit_volume'] = $result->limit_volume;
			$c['limit_volumeT'] = $result->limit_volumeT;
			$c['group_id'] = $result->group_id;
			$c['server_id'] = $result->server_id;
			$c['distribute_time'] = $result->distribute_time;
			$now = strtotime('now');
			$this->setValue($c);
			return array('operation' => 1, 'info' => '成功获取并设置资源属性');
		}else{
			return array('operation' => 0, 'info' => '没有找到对应的资源');
		}
	}
}
?>