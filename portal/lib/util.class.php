<?php
/**
 * 包括一些经常使用的实用工具.
 */

class Util{
	
	/**
	 * 生成页码
	 * @param int nums 记录总数
	 * @param int now 当前页码 页码从1开始
	 * @param int per 每页显示记录数
	 * @param int len 显示页码数目
	 */
	public function page($nums, $now, $per=5, $len=7)
	{
		//进一法取整
		$pages	= ceil($nums/$per);
		//舍弃法取整
		$half	= floor($len/2);
		$range	= array();
		if ($len >= $pages)
		{
			$start	= 1;
			$end	= $pages;
		}
		else if (abs($now-1) <= $half)
		{
			$start	= 1;
			$end	= $len;
		}
		else if (abs($pages-$now) <= $half)
		{
			$start	= $pages-$len+1;
			$end	= $pages;
		}
		else
		{
			$start	= $now-$half;
			$end	= $now+$half;
		}
		
		for ($i=$start; $i<=$end; $i++) {
			$range[] = $i;
		}
		
		if ($pages == 0) {
			$pages = 1;
		}
		
		$result =	array(
						"pages"	=> $pages,
						"range"	=> $range,
						"now"	=> $now
					);
		return $result;
	}
	
	public function encodeCurrentURL(){
		return urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
	}
	
	public function inputSecurity($s){
		$s = !get_magic_quotes_gpc() ? addcslashes($s, "'") : $s;
		return htmlentities($s,ENT_QUOTES, 'UTF-8');
	}
	
	public function validID($id){
		$id .= "";
		return preg_match('/^[123456789]\d*$/', $id);
	}
		
	function isleap($y){
		if(($y%4==0)&&($y % 100!=0)||($y % 400==0)){
			return true;
		}
		else{
			return false;
		}
	}
}
?>