<?php






use dh_mvc2\classes\Config;

class User extends Person {
	
	protected $id;
	protected $authorised_modules;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	
	/**
	 * @return array of authorised modules
	 */
	public function getAuthorised_modules() {
		return (array) $this->authorised_modules;
	}

	
	
	public function login($name,$password){

		$creds = Config::get_MySQL_creds();
		$dsn = "mysql:host={$creds['host']};dbname=dh_rbac";
		try{
		$dbh = new PDO($dsn, $creds['user'], $creds['password'],array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit;
		}
		
		$stmt = $dbh->prepare ("SELECT * FROM users WHERE name=:name AND password =:password");
	
		$stmt -> bindParam(":name", $_POST['user']);
		$stmt -> bindParam(":password", $_POST['password']);
		$stmt -> execute();
		if ( $stmt->rowCount()===1){
			$user =  $stmt->fetchObject("User");
			return $user;
		} else {
			return null;
		}
		
		
		
	return null; 
	}
	
	
}

?>