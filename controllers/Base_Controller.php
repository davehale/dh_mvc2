<?php
namespace dh_mvc2\controllers;

use dh_mvc2\views\Base_View;
use dh_mvc2\classes\Route;
use dh_mvc2\controllers\Abs_Controller;
/**
 * @author dave
 *
 */
class Base_Controller extends Abs_Controller {	
	public function __construct(Route $route){
		parent::__construct($route);
		$this->view =  new Base_View($route);
	}
}