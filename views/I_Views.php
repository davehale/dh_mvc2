<?php
namespace dh_mvc2\views;

use dh_mvc2\Dh_mvc2;

interface I_Views {
	
	
	
	
	/**
	 * @desc assign content to a template token name
	 * @param string $token_name
	 * @param string $token_value
	 */
	 public function assign($token_name,$token_value); 


	/**
	 * @desc assign content to a template 'id=section' token name
	 * @param string $token_name
	 * @param string $token_value
	 */
	 public function assign_to_section($token_name,$token_value);
	
	 
	
	
	 
	 /**
	  * @param string $token_name  the token name the view content can be refered to within layout template
	  * @param string $template_file
	  * @param boolean $return return output as string or output to buffer if false
	  */
	 public function render_view($token_name = "content",$template_file=NULL,$return = TRUE);
	 
	 /**
	  *
	  * @desc display the view content if view token name exist, within the layout.<br/>will be inserted as 'content' unless named by rendering view first
	  * @see Base_View::render_view(string $token_name, string $template_file, boolean $return)
	  * @param string $layout_file
	  * @param boolean $return return output as string or output to buffer if false
	  * @param boolean $include_view whether display the view content
	  */
	public function render_layout($layout_file=NULL,$return = FALSE,$include_view = TRUE);
	 	 
}
