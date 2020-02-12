<?php
require_once __DIR__.'/../config.php';

class HDatabase
{
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $con;
	private $connection;
	private $result;
	private $error=null;

	private static $instance; 
	public function HDatabase(){

		$this->db_host=DB_HOST;
		$this->db_user=DB_USER;
		$this->db_pass=DB_PASSWORD;
		$this->db_name=DB_DATABASE;

	}

	public static function getInstance() {
		if(!self::$instance instanceof HDatabase) {
			self::$instance = new HDatabase();
		}
		self::$instance->connect();
		return self::$instance;
	}
	
	public function connect()   {
		if(!$this->con){
			$myconn = mysql_connect($this->db_host,$this->db_user,$this->db_pass);
			if($myconn){
				$seldb = mysql_select_db($this->db_name,$myconn);
				if($seldb) {
					$this->con = true;
					$this->connection=$myconn;
					return true;
				}
				else {
					return false;
				}
			} else
			{
				return false;
			}
		} else{
			return true;
		}
	}
	public function setDBName($name){
		$this->db_name = $name;
		return $this;
		
	}
	public function setDatabase($name){
		if($this->connection){
			if(@mysql_close()){
				$this->con = false;
				$this->results = null;
				$this->db_name = $name;
				$this->connect();
			}
		}

	}

	private function tableExists($table){
		$tablesInDb = @mysql_query('SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"',$this->connection);
		if($tablesInDb){
			if(mysql_num_rows($tablesInDb)==1){
				return true;
			}
			else{
				return false;
			}
		}
	}

	public function disconnect()    {   }


	public function select($table, $rows = '*', $where = null, $order = null,$group=null){
		$this->result = null;
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($where != null)
		$q .= ' WHERE '.$where;
		if($order != null)
		$q .= ' ORDER BY '.$order;
		if($group!=null)
		$q .= ' GROUP BY '.$group;
		$query = @mysql_query($q);
		
		if($query){
			$this->numResults = mysql_num_rows($query);
			for($i = 0; $i < $this->numResults; $i++) {
				$r = mysql_fetch_array($query);
				$key = array_keys($r);
				for($x = 0; $x < count($key); $x++){
					if(!is_int($key[$x])){
						if(mysql_num_rows($query) >= 1)
						$this->result[$i][$key[$x]] = $r[$key[$x]];
						else if(mysql_num_rows($query) < 1)
						$this->result = null;
						else
						$this->result[$key[$x]] = $r[$key[$x]];
					}
				}
			}
			return mysql_num_rows($query) > 0?true:false;
		}
		else
		{
			return false;
		}
	}

	public function insert($table,$values,$rows = null){
		if($this->tableExists($table)){
			$insert = 'INSERT INTO '.$table;
			if($rows != null){
				$insert .= ' ('.$rows.')';
			}

			for($i = 0; $i < count($values); $i++){
				if(is_string($values[$i]))
				$values[$i] = '"'.$values[$i].'"';
			}
			$values = implode(',',$values);
			$insert .= ' VALUES ('.$values.')';
			//var_dump($insert);
			$ins = @mysql_query($insert);
			if($ins){
				return true;
			}
			else {
				
				$this->error=mysql_error($this->connection);
				error_log($this->error);
				return false;
			}

		}
	}
	
	public function delete($table,$where = null){
		
		if($this->tableExists($table)){
			if($where == null){
				$delete = 'DELETE '.$table;
			}
			else{
				$delete = 'DELETE FROM '.$table.' WHERE '.$where;
			}
			$del = @mysql_query($delete);
			if($del){
				$result=$this->select($table,'*',$where);
				if($result){
					return false;
				}else{
					return true;
				}
			}
			else{
				$this->error = mysql_error($this->connection);
				return false;
			}
		}
		else{
			return false;
		}
	}

	public function update($table,$rows,$where){
		
		$update="UPDATE ".$table;
		
		if($this->tableExists($table)){
			$update.=" SET ".$rows;
			$update.=" WHERE ".$where;
			$query = @mysql_query($update);
			if($query){
					return true;
				}
				else{
					return false;
				}
		}else {
			return false;
		}
	}
	
	public function query($q){
		$query = @mysql_query($q);
		if($query){
			$this->numResults = mysql_num_rows($query);
			for($i = 0; $i < $this->numResults; $i++) {
				$r = mysql_fetch_array($query);
				$key = array_keys($r);
				for($x = 0; $x < count($key); $x++){
					if(!is_int($key[$x])){
						if(mysql_num_rows($query) >= 1)
							$this->result[$i][$key[$x]] = $r[$key[$x]];
						else if(mysql_num_rows($query) < 1)
							$this->result = null;
						else
							$this->result[$key[$x]] = $r[$key[$x]];
					}
				}
			}
			return true;
		}
		else
		{
			$this->error = mysql_error($this->connection);
		}
	}
	
	public function startTransaction(){
		@mysql_query('START TRANSACTION;');
	}
	
	public function rollbackTransaction() {
		@mysql_query('ROLLBACK;');
	}
	
	public function commitTransaction() {
		@mysql_query('COMMIT;');
	}
	
	public function getResult()
	{
		return $this->result;
	}
	
	public function getError(){
		return $this->error;
	}
	
	public function resetResult(){
		$this->result=null;
		
	}
	
	public function __destruct(){
		unset($this);
		
	}
}
