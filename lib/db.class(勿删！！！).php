<?php
/**
 * 数据库操作工具类, 方便数据库操作.
 */
class DB{
    var $conn;

    public function __construct($c = array('port'=>3306, 'host'=>'localhost', 'username'=>'root', 'password'=>'', 'dbname'=>'cloudmedia2', 'charset'=>'utf8', 'time_zone'=>'+08:00')){
        if(!isset($c['port'])){
            $c['port'] = '3306';
        }
        $server = $c['host'] . ':' . $c['port'];
        $this->conn = mysql_connect($server, $c['username'], $c['password'], true) or die('connect db error');
        mysql_select_db($c['dbname'], $this->conn) or die('select db error');
        if($c['charset']){
            mysql_query("SET NAMES " . $c['charset'], $this->conn);
        }
        if($c['time_zone']){
            mysql_query("SET GLOBAL TIME_ZONE=" . $c['charset'], $this->conn);
        }
    }
		
    /**
     * 执行 mysql_query 并返回其结果.
	 * @param string sql MySQL语句
	 * @param string sqlOralce Oracle SQL语句
     */
    public function query($sql, $sqlOracle=''){
        $result = mysql_query($sql, $this->conn);
        if($result === false){
            throw new Exception(mysql_error($this->conn)." in SQL: $sql");
        }
        return $result;
    }
	
    /**
     * 事务处理
	 * @param string operation 事务操作指令
	*/
    public function transaction($operation){
		$operation = strtoupper($operation);
		if($operation == "BEGIN" || $operation == "COMMIT" || $operation == "ROLLBACK" || $operation == "END"){
			$this->query($operation);
		}
	}
	
    /**
     * 返回查询结果集
	 * @param string sql SQL语句
	 * @param string sqlOralce Oracle SQL语句
	 * @param string record_type 返回的记录集数据类型 array, assoc或者object
     */
    public function select($sql, $sqlOracle='', $record_type='object'){
        $data = array();
		$record_type = strtolower($record_type);
        $result = $this->query($sql, $sqlOracle);
		switch($record_type)
		{
			case "array":
				while($row = mysql_fetch_array($result)){
					$data[] = $row;	
				}
				break;
			case "assoc":
				while($row = mysql_fetch_assoc($result)){
					$data[] = $row;	
				}
				break;
			default:
				while($row = mysql_fetch_object($result)){
					$data[] = $row;	
				}
				break;
		}
        return $data;
    }
	
    /**
     * 执行 SQL 语句, 返回结果的第一条记录
	 * @param string sql SQL语句
	 * @param string sqlOralce Oracle SQL语句
	 * @param string record_type 返回的记录集数据类型 array, assoc或者object
     */
    public function select_one($sql, $sqlOracle='', $record_type="object"){
		$data = null;
		$record_type = strtolower($record_type);
        $result = $this->query($sql, $sqlOracle);
		switch($record_type)
		{
			case "array":
				if($row = mysql_fetch_array($result)){
					$data = $row;	
				}
				break;
			case "assoc":
				if($row = mysql_fetch_assoc($result)){
					$data = $row;	
				}
				break;
			default:
				if($row = mysql_fetch_object($result)){
					$data = $row;	
				}
				break;
		}
		return $data;
    }


    /**
     * 执行一条带有结果集计数的 count SQL 语句, 并返该计数.
	 * @param string sql SQL语句
	 * @param string sqlOralce Oracle SQL语句
     */
    public function count($sql, $sqlOracle=''){
        $result = $this->query($sql, $sqlOracle);
        if($row = mysql_fetch_array($result)){
            return (int)$row[0];
        }else{
            return 0;
        }
    }
	
    /**
     * 将条件数组连接成符合SQL语法的字符串
	 * @param array||string condition 条件键值对
	 * @param string connector 连接符
     */
	function _condition_to_string($condition, $connector='AND')
	{
		$_condition = array();
		if(is_array($condition)){
			foreach($condition as $field => $value){
				$_condition[] = "`{$field}`='{$value}'";
			}
			$_condition = join(' ' . $connector . ' ', $_condition);
		}else{
			$_condition = $condition;
		}
		return $_condition == '' ? 1 : $_condition;
	}
    /**
     * 获取指定条件的记录.
	 * @param string table 表名
     * @param array||string condition 条件的键值对
	 * @param string connector 连接符
     * @param string $record_type 返回数据类型 默认object
     */
    function select_condition($table, $condition=array(), $connector='AND', $record_type='object'){
		
        $sql = "SELECT * FROM `{$table}` WHERE " . $this->_condition_to_string($condition, $connector);
        return $this->select($sql, "", $record_type);
    }
	
    /**
     * 获取指定条件的一条记录.
	 * @param string table 表名
     * @param array||string condition 条件的键值对
	 * @param string connector 连接符
     * @param string $record_type 返回数据类型 默认object
     */
    function select_condition_one($table, $condition=array(), $connector='AND', $record_type='object'){
		
        $sql = "SELECT * FROM `{$table}` WHERE " . $this->_condition_to_string($condition, $connector);
        return $this->select_one($sql, "", $record_type);
    }

    /**
     * 保存一条记录
     * @param array $row
     * @param array||string condition 条件的键值对
	 * @param string connector 连接符
     */
    function insert($table, $row){
        $sqlA = '';
        foreach($row as $k=>$v){
			$sqlA .= "`$k` = '$v',";
        }

        $sqlA = substr($sqlA, 0, strlen($sqlA)-1);
        $sql  = "INSERT INTO `{$table}` SET $sqlA";
		if($this->query($sql, "")){
			return $this->last_insert_id();
		}else{
			return false;
		}
    }

    /**
     * 获取最近一条插入数据库的记录id
     */

    public function last_insert_id(){
        return mysql_insert_id($this->conn);
    }

    /**
     * 更新指定的记录.
     * @param string $table 表名
     * @param array $row 要更新的记录
     * @param array||string condition 条件的键值对
	 * @param string connector 连接符
     */
    function update($table, $row, $condition, $connector='AND'){
        $sqlA = '';
        foreach($row as $k=>$v){
			$sqlA .= "`$k` = '$v',";
        }
        $sqlA = substr($sqlA, 0, strlen($sqlA)-1);
		
        $sql  = "UPDATE `{$table}` SET $sqlA WHERE " . $this->_condition_to_string($condition, $connector);
        return $this->query($sql, "");
    }

    /**
     * 删除一条记录.
     * @param string $table 表名
     * @param array||string condition 条件的键值对
	 * @param string connector 连接符
     */
    function delete($table, $condition=array(), $connector='AND'){
        $sql  = "DELETE FROM `{$table}` WHERE ". $this->_condition_to_string($condition, $connector);
        return $this->query($sql, "");
    }

	function close()
	{
		mysql_close($this->conn);
	}
	
    function escape(&$val){
        if(is_object($val) || is_array($val)){
            $this->escape_row($val);
        }
    }

    function escape_row(&$row){
        if(is_object($row)){
            foreach($row as $k=>$v){
                $row->$k = mysql_real_escape_string($v);
            }
        }else if(is_array($row)){
            foreach($row as $k=>$v){
                $row[$k] = mysql_real_escape_string($v);
            }
        }
    }

    function escape_like_string($str){
        $find = array('%', '_');
        $replace = array('\%', '\_');
        $str = str_replace($find, $replace, $str);
        return $str;
    }
}
?>