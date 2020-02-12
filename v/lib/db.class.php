<?php
/*
 * Database library for Accounting-ERP project
 */
class Db
{
/*
 * defining basic configurations. database name, database user etc.
 */
	
	private static $_instance = null;
	/*
	 * @param string $db_host name of the database host
	 * @access private
	 */
	private $_db_host;
	
	/*
	 * @param string $db_user name of the database user
	 * @access private
	 */
	private $_db_user;
	
	
	/*
	 * @param bool $con database connection
	 * @access private
	 */
	private $_con;
	/*
	 * @param bool $connection database connection
	 * @access private
	 */
	private $_connection;
	/*
	 * @param array $result 
	 * @access private
	 */
	private $_result;
	/*
	 * @param string $error the mysql error string 
	 * @access private
	 */
	public $_lastInsertId;
	
	private $_error=null;

	public function __construct(){
		$this->_db_host = DB_HOST;
		$this->_db_user = DB_USER;
		$this->_db_pass = DB_PASSWORD;
		$this->_db_name = DB_NAME;
		
	}

	public static function getInstance() {
		if(!self::$_instance instanceof Db) {
			self::$_instance = new Db();
		}
		self::$_instance->connect();
		self::$_instance->resetResult();
		return self::$_instance;
	}
	
	public function connect(){
		if(!$this->_con) {	
			$myconn = mysql_connect($this->_db_host,$this->_db_user,$this->_db_pass);

			if(!$myconn) { return false; }
			$seldb = mysql_select_db($this->_db_name,$myconn);
				
			if(!$seldb) { return false; }
					$this->_con = true;
					$this->_connection = $myconn;
					return true;
		}
		else {
			return false;
		}
		
	}

    public function setDatabase($name) {
        if ($this->con) {
            if (@mysql_close()) {
                $this->con = false;
                $this->results = null;
                $this->db_name = $name;
                $this->connect();
            }
        }
    }
/*
 * checking table existance in the database
 */
	private function tableExists($table){
		$tableName = $this->getTableName($table);
		$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->_db_name.' LIKE "'.$tableName.'"');
		
		if($tablesInDb) {
			return (mysql_num_rows($tablesInDb) == 1) ? true : false;
		}
	}


	/*
	* implemeting select function.
	* 
	* @param string $table The table name to be queried.
	* @param string $rows selecting column names 
	* @param string $where the where clause string
	* @param string $order the order by clause string
	* @param string $group the group by clause string
	* 
	*/
	private function getTableName($given) {
		$understroke = substr($given, 2,1);
		if($understroke == '_') {
			return $given;
		}
		return DB_TABLE_PREFIX.'_'.$given;
	}
	
	public function select($table, $rows = '*', $where = null, $order = null,$group=null){
		$tableName = $this->getTableName($table);

		if(strpos($table, ",")) {
			$temp = explode(",", $table);
			$array = array();
			foreach ($temp as $tmp) {
				array_push($array,$tableName."_".trim($tmp) );
			}
			$q = 'SELECT '.$rows.' FROM '.implode(",", $array);
			
		}
		else {
			$q = 'SELECT '.$rows.' FROM '.$tableName;
			
		}
		$this->resetResult();
		if($where != null) { $q .= ' WHERE '.$where; }
		
		if($order != null) { $q .= ' ORDER BY '.$order; }
		
		if($group!=null) { $q .= ' GROUP BY '.$group; }
		$query = @mysql_query($q);
		
		if($query) {
			$this->numResults = mysql_num_rows($query);
			/* rearrange the result */
			for($i = 0; $i < $this->numResults; $i++) {
				$r = mysql_fetch_array($query);
				$key = array_keys($r);
				for($x = 0; $x < count($key); $x++){
					if(!is_int($key[$x])){
						if(mysql_num_rows($query) >= 1) { $this->_result[$i][$key[$x]] = $r[$key[$x]]; }
						else if(mysql_num_rows($query) < 1) { $this->_result = null; }
						else { $this->_result[$key[$x]] = $r[$key[$x]]; }
					}
				}
			}
		}
		return $this;
		
	}

	/*
	 * implementing insert function.
	 * 
	 * @param string $table the table name string
	 * @param array $values inserting value array
	 * @param string $rows inserting column names string
	 */


	public function insert($table,$values,$rows = null) {
		$tableName = $this->getTableName($table);
		
		if($this->tableExists($table)) {
			$insert = 'INSERT INTO '.$tableName;

			if($rows != null) { $insert .= ' ('.$rows.')'; }
			for($i = 0; $i < count($values); $i++) {
				if(is_string($values[$i])) { $values[$i] = '"'.$values[$i].'"'; }
			}
			$values = implode(',',$values);
			$insert .= ' VALUES ('.$values.')';
			Log::put($insert);
			$ins = @mysql_query($insert);
		
			if($ins) {
				return ($id = mysql_insert_id($this->_connection)) ? $id : true;  
			}
			else {
				$this->_error = mysql_error($this->_connection);
				error_log($this->_error);
				return false;
			}
		}
	}
	/*
	 * implementing delete function.
	 * 
	 *  @param string $table the table name string
	 *  @param string $where the where clause string 
	 */
	
	public function delete($table,$where = null) {
		$tableName = $this->getTableName($table);
		if(!$this->tableExists($table)) { return false; }
		$delete = is_null($where) ? 'DELETE '.$table : 'DELETE FROM '.$tableName.' WHERE '.$where;
		$del = @mysql_query($delete);
		
		if($del) {
			return true;
		}
		else {
			$this->_error = mysql_error($this->_connection);
			return false;
		}
	}

	/*
	 * implementing update function.
	 * 
	 * @param string $table the table name string
	 * @param string $rows update string 
	 * @param string $where the where clause string
	 */
	
	public function update($table,$rows,$where) { 
		$tableName = $this->getTableName($table);
		$update = "UPDATE ".$tableName;
		if(!$this->tableExists($table)) { return false;} 
		$update .= " SET ".$rows;
		$update .= " WHERE ".$where;
		$query = @mysql_query($update);
		if($query) { return true; }
		else { 
			$this->_error = mysql_error($this->_connection);
			Log::put($this->_error);
			return false;
		}
	}
	
	public function getResult() {
		$temp = $this->_result;
		$this->_result = null;
		return $temp;
	}

	public function getError() {
		return $this->_error;
	}

	public function resetResult() {
		$this->_result =null;
		return $this;
	}
	
	public function __destruct() {
		unset($this);
	}

	public function startTransaction() {
		Log::put(__METHOD__);
		@mysql_query('START TRANSACTION;',$this->_connection);
	}
	
	public function commitTransaction() {
		Log::put(__METHOD__);
		@mysql_query('COMMIT;',$this->_connection);
	}
	
	public function rollBackTransaction() {
		Log::put(__METHOD__);
		@mysql_query('ROLLBACK;',$this->_connection);
	}
	
	public function disconnect(){}
	
}
?>