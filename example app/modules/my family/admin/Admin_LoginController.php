<?php

use dh_mvc2\controllers\Base_Controller;
use dh_mvc2\classes\Session;
use dh_mvc2\session\Session_Controller;
use dh_mvc2\controllers\Authorised_Controller;
class Admin_LoginController extends Base_Controller {
	
	
	function index() {
		session_start ();
		
		// @todo change auth from db - once authorised via own db selects toggle
		// on
		
		$user = new User();
		
		echo $this->route->getModule_chain();
		if (isset ( $_POST ['user'] ) && isset($_POST['password'])) {
			$user = $user->login($_POST['user'], $_POST['password']);
			if ($user){
				echo $user->address;
				Authorised_Controller::authorise($user,TRUE,FALSE);
				var_dump(Authorised_Controller::get_user());
				echo Authorised_Controller::get_user()->name = 'fred';
				echo Authorised_Controller::get_user()->dob;
				var_dump(Authorised_Controller::get_user());
			}
		}
		
		$url = str_replace ( "\\", "/", Authorised_Controller::getForm_action_url () );
		$forward = Authorised_Controller::getForward_url();
		
		// @todo assign_from_file todo
		$this->view->assign ( "content", "<h3>login needed for " . $forward . "</h3>
				<form name=\"input\" action=\"$url\" method=\"post\">
				Username: <input type=\"text\" name=\"user\">
				Password: <input type=\"text\" name=\"password\">
					
				<input type=\"submit\" value=\"Submit\">
				</form> " );
		
		$this->view->render_layout ();
	}
}