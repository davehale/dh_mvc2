<?php
namespace dh_mvc2\views;

use dh_mvc2\classes\Route;
use dh_mvc2\views\Abs_View;

class Base_View extends Abs_View {
	
	
	/* (non-PHPdoc)
	 * @see dh_mvc2\views.Abs_View::render_layout()
	 */
	public function render_layout($layout_file = NULL, $return = FALSE, $include_view = TRUE) {
		
		if ($include_view) {
			self::render_view ();
		}
		
		if (isset ( $layout_file )) {
			self::setLayout_tpl ( $layout_file );
		}
		
		$view_file = self::getLayout_tpl ();
		
	
		$this->output = self::get_view_file ( $view_file );
		
		if ($return) {
			return $this->output;
		} else {
			echo $this->output;
		}
		return;
	}
	
	
	/* (non-PHPdoc)
	 * @see dh_mvc2\views.Abs_View::render_view()
	 */
	public function render_view($token_name = "content", $template_file = NULL, $return = TRUE) {
		if (isset ( $template_file )) {
			
			self::setView_tpl ( $template_file );
		}
		if (! isset ( $token_name ) or empty ( $token_name ) or ! is_string ( $token_name )) {
			$token_name = 'content';
		}
		
		$view_file = self::getView_tpl ();
		$this->$token_name = self::get_view_file ( $view_file );
		if ($return) {
			return $this->$token_name;
		} else {
			echo $this->$token_name;
		}
		return;
	
	}
	
	private function get_view_file($view_file) {
		self::make_tokens_visible ();
		ob_start ();
		include $view_file;
		$output = ob_get_contents ();
		ob_end_clean ();
		
		return $output;
	}

}
