<?php


use dh_mvc2\views\Base_View;
use dh_mvc2\controllers\Authorised_Controller;

use dh_mvc2\classes\Config;



class Admin_IndexController extends Authorised_Controller{
	
	public function hobbies(){
		$this->view->assign("content", "<h2>Hobbies Admin Page</h2>");
		$this->view->render_layout();
	}
	
	public function calendar(){
		$this->view->assign("content", "<h2>Calandar Admin Page</h2>");
		$this->view->render_layout();
	}
	public function __call($name,$params){
		$this->view->assign("content", "<h2>$name missing</h2>");
		$this->view->render_layout();
	}
	public function index(){		
		$this->view->assign("content", "<h2>admin home</h2>");
	$this->view->assign_to_section("sectionone", "section one test text");
	$this->view->assign_to_section("sectionone", "<br/>more section one test text");
	$this->view->assign_to_section("sectiontwo", "need flee");
	$this->view->render_layout();	
	}
	
	public function diary(){
		$this->view->assign("content", "<h2>Diary Admin Page</h2>");
		$this->view->render_layout();
	}
	public function photos(){
	$this->view->assign("content", "<h2>Photos Admin Page</h2>");
	$this->view->render_layout();	}
	
	public function logout(){
		self::logout_user();
		$this->view->assign("content", "<h2>You have been logged out, thanks</h2>");
		$this->view->render_layout();
	}
	
}