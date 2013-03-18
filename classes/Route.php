<?php
namespace dh_mvc2\classes;

/**
 * @desc simple class used to collect info derived from the url request
 * @author dave
 *
 */
class Route {

	/**
	 * @var string abs. path to url requested module
	 */
	private $module_path = "";
	/**
	 * @var string modules prefix 
	 * @example Tutorials_
	 */
	private $module_prefix ="" ;
	/**
	 * @var string containing path from module dir root
	 * @example my family/admin
	 */
	private $module_chain="";
	/**
	 * @var string controllers name found via url requrest
	 */
	private $controller_name="";
	/**
	 * @var string path to controller file
	 */
	private $controller_file="";
	/**
	 * @var string reuested url action for the controler
	 */
	private $controller_action="";
	/**
	 * @var array of any remaining url paramaters
	 */
	private $params=array();
	
	/**
	 * @return the $module_chain
	 */
	public function getModule_chain() {
		return trim($this->module_chain,'\\/');
	}

	/**
	 * @param field_type $module_chain
	 */
	public function setModule_chain($module_chain) {
		$this->module_chain = $module_chain;
	}

	/**
	 * @return the $params
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @param field_type $params
	 */
	public function setParams($params) {
		$this->params = $params;
	}

	/**
	 * @return the $controller_file
	 */
	public function getController_file() {
		return $this->controller_file;
	}

	/**
	 * @param field_type $controller_file
	 */
	public function setController_file($controller_file) {
		$this->controller_file = $controller_file;
	}

	/**
	 * @return the $module_path
	 */
	public function getModule_path() {
		return $this->module_path;
	}

	/**
	 * @return the $module_prefix
	 */
	public function getModule_prefix() {
		return $this->module_prefix;
	}

	/**
	 * @return the $controller_name
	 */
	public function getController_name() {
		return $this->controller_name;
	}

	/**
	 * @return the $controller_action
	 */
	public function getController_action() {
		return $this->controller_action;
	}

	/**
	 * @param string $module_path
	 */
	public function setModule_path($module_path) {
		$this->module_path = $module_path;
	}

	/**
	 * @param string $module_prefix
	 */
	public function setModule_prefix($module_prefix) {
		$this->module_prefix = $module_prefix;
	}

	/**
	 * @param string $controller_name
	 */
	public function setController_name($controller_name) {
		$this->controller_name = $controller_name;
	}

	/**
	 * @param string $controller_action
	 */
	public function setController_action($controller_action) {
		$this->controller_action = $controller_action;
	}

	
}

?>