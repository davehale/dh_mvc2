<?php
namespace dh_mvc2\controllers;
use dh_mvc2\views\Base_View;

use dh_mvc2\controllers\I_Controller;

use  dh_mvc2\classes\route;
	
/**
 * @author dave
 * 
 * @property  dh_mvc2\classes\route $route

 */
class Abs_Controller implements I_Controller {
	
	protected $route ;
		
	public function __construct (Route $route){
		$this->route = $route;
	}
	/**
	 * 
	 * @var Base_View or inheritor of 
	 * @desc the action controllers view
	 * @property  dh_mvc2\views\Base_View $view made visible for development of base classes ide hinting
	 */
	public $view; 

	/**
	 * @desc the action controllers model if required
	 * @var Base_Model
	 */
	public $model;	
}
