<?php

namespace dh_mvc2\dispatchers;

use dh_mvc2\session\Session_Controller;

require_once ('dh_mvc2/dispatchers/Abs_Dispatcher.php');

use dh_mvc2\dispatchers\Abs_Dispatcher;
use dh_mvc2\controllers\Authorised_Controller;

class Base_Dispatcher extends Abs_Dispatcher {
	
	protected function pre_dispatch() {
		echo "<br/>pre dispatch<br/>";
		if (($this->controller instanceof Authorised_Controller) && ! Authorised_Controller::check_authorised ()) {
			Authorised_Controller::enforce_login ();
			exit ( "dont pass if not logged on" );
		} 

		else {
		}
	}
	protected function dispatch() {
		echo "<br/>dispatching callback<br/>";
		call_user_func ( self::getController_callback () );
	}
	protected function post_dispatch() {
		echo "<br/>post dispatch<br/>";
	}
}

