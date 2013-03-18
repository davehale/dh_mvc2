<?php
namespace dh_mvc2\routers;

use dh_mvc2\classes\Config;

use dh_mvc2\classes\Route;

use dh_mvc2\routers\I_Router;

abstract class Abs_Router implements I_Router {
	
	protected $route = NULL;
	protected $router_url = NULL;
	
	public function __construct($url = NULL) {
		$this->setRouter_url ( $url );
		$this->resolve_route ();
		$this->request_dispatch ();
	}
	
	/**
	 *
	 * @return the $router_url
	 */
	public function getRouter_url() {
		return $this->router_url;
	}
	
	/**
	 *
	 * @param $url string       	
	 * @return NULL
	 */
	public function setRouter_url($url = NULL) {
		$this->route = new Route ();
		$this->router_url = NULL;
		if (isset ( $url ) && ! empty ( $url )) {
			$this->router_url = $url;
		} else if (isset ( $_REQUEST ['url'] ) && ! empty ( $_REQUEST ['url'] )) {
			$this->router_url = $_REQUEST ['url'];
		} else {
			// set url to default.
			$this->router_url = Config::get_default_request ();
		}
		$this->router_url = rtrim ( $this->router_url, '/' );
		
		$this->router_url = explode ( '/', str_replace ( "\\", "/", strtolower ( $this->router_url ) ) );
	}
	
	/**
	 *
	 * @return the $route
	 */
	public function getRoute() {
		return $this->route;
	}
	
	abstract public function request_dispatch();
	abstract public function resolve_route($url = NULL);

}

