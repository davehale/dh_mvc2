<?php


use dh_mvc2\controllers\Base_Controller;

use dh_mvc2\views\Base_View;
use dh_mvc2\controllers\Authorised_Controller;

use dh_mvc2\classes\Config;



class My_Family_IndexController extends Base_Controller{
	
	public function ashley(){
		$this->view->setLayout_tpl('family_member_layout.phtml');
		$this->view->assign("menu_name","ashley_menu");
		
		$this->view->assign("content", "<h2>ashley home page</h2>");
		$this->view->render_layout();
	}
	public function __call($name,$params){
		$this->view->assign("content", "<h2>family $name page not implemented</h2>");
		$this->view->render_layout();
	}
	public function index(){		
	$this->view->assign("content", "<h2>family home page</h2>");

	$this->view->render_layout();	
	}
	
	public function harvey(){
		$this->view->setLayout_tpl('family_member_layout.phtml');
		$this->view->assign("menu_name","harvey_menu");
		$this->view->assign("content", "<h2>harvey home page</h2>");
		$this->view->render_layout();
	}
	public function wayne(){
		$this->view->setLayout_tpl('family_member_layout.phtml');
		$this->view->assign("menu_name","wayne_menu");
		
		$this->view->assign("content", "<h2>wayne home page</h2>");
		$this->view->render_layout();
	}
	public function rusty(){
		$this->view->setLayout_tpl('family_member_layout.phtml');
		$this->view->assign("menu_name","rusty_menu");
		
	$this->view->assign("content", "<h2>rusty home page</h2>");
	$this->view->render_layout();	}
	
	
	
}