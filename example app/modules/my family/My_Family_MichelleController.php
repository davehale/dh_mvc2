<?php


use dh_mvc2\controllers\Base_Controller;

use dh_mvc2\views\Base_View;
use dh_mvc2\controllers\Authorised_Controller;

use dh_mvc2\classes\Config;



class My_Family_MichelleController extends Base_Controller{
	
	public function hug_ashley(){
		$this->view->assign("content", "<h2>michelle hugs ashley</h2>");
		$this->view->render_layout();
	}
	
	public function index(){		
	$this->view->assign("content", "<h2>michelles own controller file</h2>");
	$this->view->assign("menu_name","michelle_menu");
	$this->view->setLayout_tpl('family_member_layout.phtml');
	
	$this->view->render_layout();	
	}
	
	
	
	
	public function harvey(){
		$this->view->assign("content", "<h2>harvey home page</h2>");
		$this->view->render_layout();
	}
	public function wayne(){
		$this->view->assign("content", "<h2>wayne home page</h2>");
		$this->view->render_layout();
	}
	public function rusty(){
	$this->view->assign("content", "<h2>rusty home page</h2>");
	$this->view->render_layout();	}
	
	public function michelle(){
		$this->view->assign("content", "<h2>michelle home page</h2>");
		$this->view->render_layout();
	}
	
}