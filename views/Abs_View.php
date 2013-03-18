<?php
namespace dh_mvc2\views;

use dh_mvc2\views\I_Views;
use dh_mvc2\classes\Route;

/**
 *
 * @author dave
 * @property dh_mvc2\classes\Route $route visible for development of base classes
 *          
 */
abstract class Abs_View implements I_Views {
	
	protected $section_content_vars = array ();
	protected $content_vars = array ();
	protected $page_title = null;
	protected $layout_tpl = NULL;
	protected $view_tpl = NULL;
	protected $route;
	
	public function __construct(Route $route) {
		$this->route = $route;
		self::_set_default_view ();
		self::_set_default_layout ();
		self::set_default_page_title ();
	
	}
	
	private function set_default_page_title() {
		self::setPage_title ( APP_PAGE_NAME . " - ".str_replace ( array ('\\', '/' ), ' - ', $this->route->getModule_chain ().' - '.$this->route->getController_action() ) );
	
	}
	
	public function __set($var_name, $value) {
		$this->$var_name = $value;
	}
	
	public function __get($name) {
		return;
	}
	
	private final function _set_default_layout($layoutFile=NULL) {
		
		$d_f_name = "default_layout.phtml";
		if (isset($layoutFile)){
			$mod_prexd_f_name = $layoutFile;
		}else{
		$mod_prexd_f_name = lcfirst ( $this->route->getModule_prefix () . 'layout.phtml' );
		}
		
		$mod_chain = str_replace ( "\\", "/", trim ( $this->route->getModule_chain (), '/\\' ) );
		
		$mod_prefixs = array_reverse ( explode ( '/', $mod_chain ) );
		$current_module = $this->route->getModule_path ();
		$mod_count = count ( $mod_prefixs );
		do {
			if (file_exists ( $current_module . DIRECTORY_SEPARATOR . $mod_prexd_f_name )) {
				$this->layout_tpl = ( $current_module . DIRECTORY_SEPARATOR . $mod_prexd_f_name );
				break;
			
			} else if (file_exists ( $current_module . DIRECTORY_SEPARATOR . $d_f_name )) {
			$this->layout_tpl =  ( $current_module . DIRECTORY_SEPARATOR . $d_f_name );
				break;
			}
			$current_module = dirname ( $current_module );
		} while ( $mod_count -- );
		
		if (! self::getLayout_tpl ()) {
			// use app default layout dir
			$app_page_template_dir = APP_ROOT . DIRECTORY_SEPARATOR . 'page_templates' . DIRECTORY_SEPARATOR;
			if (file_exists ( $app_page_template_dir . DIRECTORY_SEPARATOR . $mod_prexd_f_name )) {
				$this->layout_tpl =  ( $app_page_template_dir . DIRECTORY_SEPARATOR . $mod_prexd_f_name );
			
			} else if (file_exists ( $app_page_template_dir . DIRECTORY_SEPARATOR . $d_f_name )) {
				self::setLayout_tpl ( $app_page_template_dir . DIRECTORY_SEPARATOR . $d_f_name );
			}
		
		}
		if (! self::getLayout_tpl ()) {
			// use framework default layout dir
			$fw_page_template_dir = FW_ROOT . DIRECTORY_SEPARATOR . 'page_templates' . DIRECTORY_SEPARATOR;
			if (file_exists ( $fw_page_template_dir . DIRECTORY_SEPARATOR . $mod_prexd_f_name )) {
				$this->layout_tpl =  ( $fw_page_template_dir . DIRECTORY_SEPARATOR . $mod_prexd_f_name );
			
			} else if (file_exists ( $fw_page_template_dir . DIRECTORY_SEPARATOR . $d_f_name )) {
				$this->layout_tpl = ( $fw_page_template_dir . DIRECTORY_SEPARATOR . $d_f_name );
			}
		}
	}
	
	private final function _set_default_view() {
		$view_dir = APP_ROOT . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR.$this->route->getModule_chain () . DIRECTORY_SEPARATOR;
		$view_file_name = $this->route->getModule_prefix () . ucfirst ( $this->route->getController_action () ) . 'View.phtml';
		
		if (file_exists($view_dir . $view_file_name)){
		self::setView_tpl ( $view_dir . $view_file_name );}
		else if(file_exists( APP_ROOT . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR.'default_view.phtml')){
			self::setView_tpl (APP_ROOT . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR.'default_view.phtml');
			
		}
	}
	
	/**
	 * assign visible content to replace the token name used in a template
	 *
	 * @param $token_name string       	
	 * @param $token_value string       	
	 * @example <ul><li> <b>in controller</b><code>
	 *          $this->view->assign("sub_title","my sub title");</code>
	 *          </li><li><b> in template </b> <code> &lt;?php echo
	 *          $this->sub_title;?></code></li></ul>
	 *         
	 */
	public function assign($token_name, $token_value) {
		$this->content_vars [$token_name] = $token_value;
	}
	
	public function remove_from_section($token_name) {
		if (isset ( $this->content_vars [$token_name] )) {
			unset ( $this->content_vars [$token_name] );
		
		}
	}
	
	public function assign_to_section($token_name, $token_value) {
		
		if (! array_key_exists ( $token_name, $this->section_content_vars )) {
			$this->section_content_vars [$token_name] = $token_value;
		} else {
			$this->section_content_vars [$token_name] = $this->section_content_vars [$token_name] . $token_value;
		}
	
	}
	
	/**
	 *
	 * @return the $page_title
	 */
	protected  function getPage_title() {
		return $this->page_title;
	}
	
	/**
	 *
	 * @return the $layout_tpl
	 */
	protected function getLayout_tpl() {
		return $this->layout_tpl;
	}
	
	/**
	 *
	 * @return the $view_tpl
	 */
	protected function getView_tpl() {
		return $this->view_tpl;
	}
	
	/**
	 *
	 * @param $page_title string       	
	 */
	public function setPage_title($page_title) {
		$this->page_title = $page_title;
	}
	
	/**
	 *
	 * @param $layout_tpl NULL       	
	 */
	public function setLayout_tpl($layout_tpl) {
		self::_set_default_layout( $layout_tpl);
	}
	
	/**
	 *
	 * @param $view_tpl NULL       	
	 */
	public function setView_tpl($view_tpl) {
		$this->view_tpl = $view_tpl;
	}
	
	/* (non-PHPdoc)
	 * @see dh_mvc2\views.I_Views::render_view()
	 */
	public abstract function render_view($token_name = "content", $template_file = NULL, $return = TRUE);
	/* (non-PHPdoc)
	 * @see dh_mvc2\views.I_Views::render_layout()
	 */
	public abstract function render_layout($layout_file = NULL, $return = FALSE, $include_view = TRUE);
	protected function make_tokens_visible() {
		
		foreach ( $this->content_vars as $key => $content ) {
			$this->$key = $content;
			unset($this->content_vars[$key]);
		}
		foreach ( $this->section_content_vars as $section => $content ) {
			$content = "\r\n<section id=\"$section\">\r\n$content\r\n</section><!-- .$section -->";
			$this->$section = $content;
			unset($this->section_content_vars[$section]);
				
		}
	
	}

}
