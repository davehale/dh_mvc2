<?php

namespace classes;

use dh_mvc2\classes\Config;

class DHMySQL {
	private $host;
	private $user;
	private $password;
	private $database;
	private $db_link = NULL;
	private $query_result;
	private $error_no;
	public function __construct($database = NULL, $connect_now = FALSE) {
		$dbcreds = Config::get_MySQL_creds();
			$this->host = $dbcreds['host'];//MYSQL_HOST;

			$this->user = $dbcreds['user'];
			$this->password = $dbcreds['password'];;
			$this->database = $dbcreds['db_prefix'].$database;
		
		if ($connect_now == TRUE) {
			$this->connect ();
		}
	}
	public function getErrorNo() {
		return $this->error_no;
	}
	public function query($query = "") {
		try {
			$this->query_result = $this->db_link->query ( $query );
			if (mysqli_connect_errno ()) {
				throw new \Exception ( 'Database error:' . mysqli_connect_error () );
			}
		} catch ( \Exception $e ) {
			print $e->getMessage ();
		}
		return $this->query_result;
	}
	public function connect() {
		unset ( $this->error_no );
		try {
			$this->db_link = new \mysqli ( $this->host, $this->user, $this->password, $this->database );
			if (mysqli_connect_errno ()) {
				$this->error_no = mysqli_connect_errno ();
				throw new \Exception ( 'Database error:' . mysqli_connect_error () );
			}
		} catch ( \Exception $e ) {
			print $e->getMessage ();
		}
	}
}

