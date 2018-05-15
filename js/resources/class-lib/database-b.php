<?php
/* this file has been sanitized to remove sensitive information, in order to make this work the following variable must be changed to valid information:

			$host
			$user
			$pass
			$dbname
---------------------------------------------------------------------------------
*/

Class database {
	private $host	= "localhost";// hostname
	private $user	= "njcadhosting";// db username
	private $pass	= "Njcad2820'";// db password
	private $dbname = "astar";// db name

	private $dbh;	// database handler
	private $error; // for error messages
	private $stmt;  
	private $sql;

	public function __construct() {
		// set DSN
		$dsn = 'mysql:host='.$this->host.';dbname='. $this->dbname;
		// set options
		$options = array(
			PDO::ATTR_PERSISTENT	=> true,
			PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION
		);
		// create new PDO
		try {
			$this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
		} catch (PDOexception $e){
			$this->error = $e->getMessage();
		}
	} // end constructor method

	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
		$this->sql = $query;
		
	} // end query method

	public function bind($param, $value, $type = null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	public function bind_param($param, $value, $type = null) {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
					
			}
		}
		$this->stmt->bindParam($param, $value, $type);
	}


	public function execute_array($array) {
		
		$this->stmt->execute(array_values($array));
		return $this->stmt->fetchColumn();
		
	}

	public function execute() {
		return $this->stmt->execute();
		
	}

	public function resultset() {
		$this->execute();
		
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		//return $this->count;
	}

	public function rowcount() {
		return $this->stmt->rowCount();
	}
	/* **************************************************** */
	// the next 4 methods ( begin_trans, last_id, commit, 
	// and rollback are for running transaction queries
	/* **************************************************** */

	public function begin_trans() {
		$this->dbh->beginTransaction();
	}

	public function last_id() {
		return $this->dbh->lastInsertId() ;
	}

	public function commit() {
		$this->dbh->commit();
	}

	public function rollback() {
		$this->dbh->rollBack();
	}

	public function return_count() {
		$this->execute();

		if ($result = $this->dbh->query($this->sql) ) {
			return $this->dbh->fetchColumn();
		
    				/* Check the number of rows that match the SELECT statement */
  					return ($result->fetchColumn() ); 
  		} // end if		
  				
	} // end return_count method

}

?>