<?php
class Mysql {
	private $link = null;
	private $rowCount = null;
	private $last_result = null;
	
	public function __construct($config) {
		if(!is_resource($this->link = mysql_connect($config->host.':'.$config->port,$config->user,$config->password))) {
			die('Connot connect to database.');
			
		}
		mysql_select_db(trim($config->path),$this->link);
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8',
							character_set_database = 'utf8', character_set_collation = 'utf8', character_set_server = 'utf8'", $this->_link);
		return $this;
	}
	
	public function query($sql) {
		$this->rowCount = 0;
		$result = mysql_query($sql);
		if($result ===  false) { exit(); }
		else {
			$this->setRowCount($result);
		}
		$this->last_result = $result;
		return $result;
		
	}
	
	public function setRowCount($result) {
		if(is_resource($result)) {
			$this->rowCount = mysql_num_rows($result);
		}
		else {
			$this->rowCount = mysql_affected_rows($this->link);
		}
	}
	
	public function fetchArray($result) {
		if(is_resource($result)) {
			return mysql_fetch_array($result,MYSQL_ASSOC);
		}
		else {
			return array();
		}
	}
	
	public function __destruct() {
		if(is_resource($this->link)) {
			mysql_close($this->link);
		}
	} 
	
	public function __get($key) {
		if($key == 'rowCount') return $this->rowCount;
		if($key == 'lastInsertId') return $this->lastInsertId;
	}
	
	
	public function prepare($sql, $statementName = 'stmt') {
		
		$this->lastError = null;
		$this->queryBatchId = trim($statementName);
		$this->queryBatch[$this->queryBatchId] = array();
		
		
	}
 	
	
	
	
}