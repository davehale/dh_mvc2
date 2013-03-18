<?php
namespace dh_mvc2\routers;

use dh_mvc2\dispatchers\Base_Dispatcher;

use dh_mvc2\classes\Config;

use classes\Languages;
use Core;
use dh_mvc2\classes\Route;

require_once ('dh_mvc2/routers/Abs_Router.php');

use dh_mvc2\routers\Abs_Router;

class Base_Router extends Abs_Router {
	
	public function resolve_route($url=NULL) {
		
		if (isset($url)){
			self::setRouter_url();
		}
		
		$language = Languages::getLanguage ( $this->router_url );
		defined ( 'APP_LANGUAGE' ) or define ( 'APP_LANGUAGE', $language ['language'] );
		defined ( 'APP_COUNTRY_CODE' ) or define ( 'APP_COUNTRY_CODE', $language ['code'] );
		$this->set_router_module ( $this->router_url, $this->route );
		$this->set_router_controller ( $this->router_url, $this->route );
		$this->set_router_action ( $this->router_url, $this->route );
		return $this->route;
	}
	
	public function request_dispatch(){
		
		$dispatcher = new Base_Dispatcher($this->route);
	}
	
	
	private function set_router_action(&$url, &$route) {
		if (! isset ( Config::$config ['default'] ['action'] )) {
			exit ( "Must declare default action in app config" );
		}
		$default_action = Config::$config ['default'] ['action'];
		
		
		$action = isset ( $url [0]) ? $url[0] : $default_action;
		$action = str_replace(" ","_",$action);
		
		
		$class = $route->getController_name ();
		if (! class_exists ( $class )) {
			require_once ($route->getController_file ());
		}
		
		
		if (method_exists ( $class, $action )) {
			$route->setController_action ( $action );
			array_shift ( $url );
		} else if (method_exists ( $class, "__call" )) {
			$route->setController_action ( $action );
		} else if (method_exists ( $class, $default_action )) {
			$route->setController_action ( $default_action );
		} else {
			exit ( "no availiable action {$action} in {$class} in " . $route->getController_file () );
			
		}echo "{$action}";
		$route->setParams ( $url );
	
	}
	
	private function set_router_controller(&$url, &$route) {
		
		if (! isset ( Config::$config ['default'] ['controller'] )) {
			exit ( "Must declare default controller in app config" );
		}
		
		if (! isset ( $url [0] )) {
			
			$url [0] = Config::$config ['default'] ['controller'];
		
		}
		
		$module_path = $route->getModule_path ();
		$module_prefix = $route->getModule_prefix ();
		$controller_name = $module_prefix . str_replace ( " ", "", ucwords ( $url [0] ) ) . 'Controller';
		$controller = $module_path . DIRECTORY_SEPARATOR . $controller_name . '.php';
		$default_controller = $module_path . DIRECTORY_SEPARATOR . $module_prefix . ucfirst ( Config::$config ['default'] ['controller'] ) . 'Controller.php';
		
		if (! file_exists ( $controller ) && file_exists ( $default_controller )) {
			$controller = $default_controller;
			$controller_name = $module_prefix . ucfirst ( Config::$config ['default'] ['controller'] ) . 'Controller';
		} else if (! file_exists ( $controller )) {
			$msg = ' Controller(s) not found at <br/>' . $controller . '<br/>' . $default_controller . '<br/>';
			exit ( $msg );
		} else if (file_exists($controller)){
			array_shift($url);
		}
		$route->setController_file ( $controller );
		$route->setController_name ( $controller_name );
	}
	
	private function set_router_module(&$url, &$route) {
		$module_prefix = null;
		$moduleFolderPath = APP_ROOT . DIRECTORY_SEPARATOR . 'modules';
		$module_chain =null;
		
		
		if (! is_dir ( $moduleFolderPath )) {
			exit ( "no modules folder availiable in APP_ROOT set as " . APP_ROOT );
		}
		
		foreach ( $url as $dirToCheck ) {
			if (is_dir ( $moduleFolderPath . DIRECTORY_SEPARATOR . $dirToCheck )) {
				$moduleFolderPath = $moduleFolderPath . DIRECTORY_SEPARATOR . $dirToCheck;
				$module_chain=$module_chain.DIRECTORY_SEPARATOR . $dirToCheck;
				$module_prefix = str_replace ( " ", "_", ucwords ( $dirToCheck ) ) . '_';
				array_shift ( $url );
			}
		}
		
		$route->setModule_path ( $moduleFolderPath );
		$route->setModule_prefix ( $module_prefix );
		$route->setModule_chain($module_chain);
		return $moduleFolderPath;
	}
}
