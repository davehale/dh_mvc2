<?php

use dh_mvc2\controllers\Base_Controller;
use dh_mvc2\classes\Session;
use dh_mvc2\session\Session_Controller;
use dh_mvc2\controllers\Authorised_Controller;
class LoginController extends Base_Controller {
	
	function index(){
		
		?>
		
		<form name="input" action="" method="post">
Username: <input type="text" name="user">
Password: <input type="text" name="password">

<input type="submit" value="Submit">
</form> 
		
		<?php 
		
		
		
		
	}
}