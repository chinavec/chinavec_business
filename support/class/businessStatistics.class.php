<?php
/**
 * 业务运营统计类完成对业务的运营统计数据汇总
 * 该类涉及到数据库的操作，使用该类时应该先行连接数据库.
 */
 
class BusinessStatistics
{
	private $db;
	//构造函数
	public function __construct($db){
		$this->db = $db;
	}
		
	//按天统计所有业务运营情况
	public function getAllDataByDay($year, $month){
		$sql = "SELECT `order_times`,`income`,`day`
				FROM `business_statistics`
				WHERE `year`=$year AND `month`=$month";
		$result = $this->db->select($sql);
		return $result;
	}
}
?>