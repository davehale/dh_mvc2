<?php
namespace dh_mvc2\dispatchers;

use dh_mvc2\classes\Route;

/**
 * @author dave
 * @property dh_mvc2\classes\Route $route made visible for use in derived class development(ide hints)
 *
 */
abstract class Abs_Dispatcher  {
	
	protected $controller_name;
	protected $action;
	protected $controller_callback;
	protected $controller;
	protected $module_chain;
	
	
	/**
	 * @return the $controller_callback
	 */
	public function getController_callback() {
		return $this->controller_callback;
	}

	/**
	 * @param multitype:unknown NULL  $controller_callback
	 */
	public function setController_callback($controller_callback) {
		$this->controller_callback = $controller_callback;
	}

	public function __construct(Route $route=NULL){
		
		
		$this->controller_name =  $route->getController_name();
		$this->action = $route->getController_action();
		$this->module_chain = $route->getModule_chain();
		$this->controller = new $this->controller_name($route);
		
		self::setController_callback( array ( $this->controller,$this->action));
		
		//passing route to controller so it can easily be type checked. sending just the paramaters whould be uncheckable other than is_array
		$this->pre_dispatch();
		$this->dispatch();
		$this->post_dispatch();

	}
	
	
	protected  abstract function post_dispatch() ;
	
	protected abstract function pre_dispatch();
	
	protected abstract function dispatch() ;
}

