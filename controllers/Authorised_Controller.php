<?php

namespace dh_mvc2\controllers;

require_once ('dh_mvc2/controllers/Base_Controller.php');

use dh_mvc2\controllers\Base_Controller;
use dh_mvc2\classes\Route;
use dh_mvc2\classes\Session;

class Authorised_Controller extends Base_Controller {
	private $session_info;
	private $form_action_url;
	private $forward_url;
	public function __construct(Route $route, $form_action_url = NULL) {
		parent::__construct ( $route );
		self::ensure_session ();
		
		$is_forward_set = $this->getForward_url ();
		if (! isset ( $is_forward_set )) {
			$forward_url = WEB_ROOT . '/' . str_replace ( "url=", "", $_SERVER ['REDIRECT_QUERY_STRING'] );
			$this->setForward_url ( $forward_url );
		}
		
		$form_action_url = WEB_ROOT . self::_get_login_controller ();
		$this->setForm_action_url ( $form_action_url );
	}
	public static function __callstatic($method, $params) {
		self::ensure_session ();
		return call_user_func_array ( 'static::' . $method, $params );
		die ();
	}
	public static function logout_user() {
		session_destroy ();
	}
	
	
	private static function enforce_login($redirect = FALSE) {
		echo "forward to login screen";
		header ( "Location: " . str_replace ( "\\", "/", self::getForm_action_url () ) );
	}
	public static function getForm_action_url() {
		self::ensure_session();
		return $_SESSION ['dh_mvc_session_info']->getForm_action_url ();
	}
	private function setForward_url($forward_url) {
		self::ensure_session ();
		$_SESSION ['dh_mvc_session_info']->setForward_url ( $forward_url );
	}
	public static function getForward_url() {
		self::ensure_session();
		return $_SESSION ['dh_mvc_session_info']->getForward_url ();
	}
	private function setForm_action_url($form_action_url) {
		self::ensure_session ();
		$_SESSION ['dh_mvc_session_info']->setForm_action_url ( $form_action_url );
	}
	private static function ensure_session() {
		if (PHP_SESSION_ACTIVE === session_status ()) {
		} else {
			session_start ();
		}
		
		if (! isset ( $_SESSION ['dh_mvc_session_info'] )) {
			
			$_SESSION ['dh_mvc_session_info'] = new Session ();
		}
	}
	public static function check_authorised() {
		self::ensure_session ();
		return $_SESSION ['dh_mvc_session_info']->getAuthorised ();
	}
	
	
	public static function add_user($user){
		self::ensure_session();
		$_SESSION ['dh_mvc_session_info']->user = $user;
		
	}
	public static function remove_user(){
		self::ensure_session();
		$_SESSION['dh_mvc_session_info']->user = NULL;
	}
	
	public static function get_user(){
		self::ensure_session();
		return (isset($_SESSION['dh_mvc_session_info']->user)) ? $_SESSION['dh_mvc_session_info']->user : NULL;
	}
	
	/**
	 * will authorise a user after application specific checks are done and
	 * forward user back to where
	 * login was first required
	 *
	 * @param boolean $authorise
	 *        	will default to true
	 */
	public static function authorise($user = NULL, $authorise = TRUE,$redirect=TRUE) {
		if ( isset($user)  ) self::add_user($user);
		
		self::ensure_session ();
		
		$_SESSION ['dh_mvc_session_info']->setAuthorised ( $authorise );
		if (self::check_authorised () && $redirect) {
			$forward = str_replace ( "\\", "/", self::getForward_url () );
			header ( "Location: " . $forward );
		}
	}
	private function _get_login_controller() {
		$route = $this->route;
		$root_mod_dir = APP_ROOT . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
		$current_mod_login = $root_mod_dir . $route->getModule_chain () . DIRECTORY_SEPARATOR . $route->getModule_prefix () . 'LoginController.php';
		if (file_exists ( $current_mod_login )) {
			$loginController = "/" . $route->getModule_chain () . DIRECTORY_SEPARATOR . 'login';
		} else if (file_exists ( $root_mod_dir . 'LoginController.php' )) {
			$loginController = "/login";
		}
		
		return $loginController;
	}
}

