<?php


namespace classes;
use classes\DHMySQL;





class DHNavMenu 
{
	
	static $START_MENU_OBJECT = "\t\t<li>\n";
	static $END_MENU_OBJECT ="\t\t</li>\n";
	static $START_MENU_LAYER = "\t<ul>\n";
	static $END_MENU_LAYER ="\t</ul>\n";
	static $START_MENU = "<nav id='DHNavMenu'>\n";
	static $END_MENU="</nav>\n";
	static $HTML_LINK ="\t\t\t<a href=\"%s%s\">%s</a>\n";
	static $TAB ="\t";
	private $tab_base_set = FALSE;
	

	public static $instance;	
	
	var $database ;
	

	public function __construct()
	{
		
		self::init();
		
	}

public function __destruct() {
}
	private function init(){
		$this->database = new DHMySQL ('DHNavMenu',TRUE);
		$this->tab_base_set = FALSE;
		
	}


	public static function getMenuHTML($menuName,$urlRoot=null,$parent_id=0,$tab_indent=0){
		if (!isset($instance)){
			$instance = new DHNavMenu();
		}
		
		if(!isset($urlRoot) && defined('WEB_ROOT')){
			$urlRoot = WEB_ROOT.URL_SPERATOR;
		}
		
		ob_start();
		$instance->buildMenuHTML($menuName,$urlRoot,$parent_id,$tab_indent);
		 $html = ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
	
	public static function printMenuHTML($menuName,$urlRoot=null,$parent_id=0,$tab_indent=0){
		$html = self::getMenuHTML($menuName,$urlRoot,$parent_id,$tab_indent);
		echo $html;
		return $html;
	}
	
	public static function printMenuCSS($urlPath=NULL){
		$html = self::getMenuCSS($urlPath);
		echo $html;
		return $html;
	}
	public static function getMenuCSS($cssPath=null){
		if (!isset($instance)){
			$instance = new DHNavMenu();
		}
	ob_start();
	
		$instance->getCSSLink($cssPath);
		$html= ob_get_contents();
		ob_end_clean();
		
		return $html;
	}
	
	private function buildMenuHTML($menuName,$urlRoot=null,$parent_id=0,$tab_indent=0) 
	{		
		static $tab_base_set = FALSE;
		static $INDENT_BASE = 0;
		
		$tab_string = str_repeat(self::$TAB,$tab_indent);
		
		if ($this->tab_base_set===FALSE) 
		{
			
			$INDENT_BASE = $tab_indent;
			$this->tab_base_set = TRUE;		
			$query =  "SELECT * from $menuName where is_child_of=$parent_id OR allways_on_top=1 ORDER BY display_order";
			print $tab_string.self::$START_MENU;
		}
		
		else 
		{
			$query =  "SELECT * from $menuName where is_child_of=$parent_id  ORDER BY display_order";
		
		}
		
		$result = $this->database->query($query);
	
	
		if ( $result )
		{
			if (!$result->num_rows>0) 
			{
				return;
			}
				
			print $tab_string.self::$START_MENU_LAYER;
			
			
			while ($row = $result->fetch_array())
				
			{
				//var_dump($row);
				print $tab_string.self::$START_MENU_OBJECT ;
				print $tab_string;
				printf(self::$HTML_LINK,"",$urlRoot.$row["html_link"],$row["display_name"]);
				
				//recursion to check for sub menu of current menu object
				$this->buildMenuHTML($menuName,$urlRoot,$row["menu_id"],$tab_indent+2);
				print $tab_string.self::$END_MENU_OBJECT ;
			}
			
			print $tab_string.self::$END_MENU_LAYER;
						
			if ($INDENT_BASE==$tab_indent)	
			{
				print $tab_string.self::$END_MENU;
			}
		}
		
	}

	


	private function getCSSLink($cssPath=NULL)
	{
		
	
		if (!isset($cssPath) && defined ('WEB_ROOT')){
			
		
		
			$cssPath = WEB_ROOT."/css/dhnavmenu.css";
		}
	 echo "<link href=\"$cssPath\" type=\"text/css\" rel=\"stylesheet\"/>\n";
		
	}

	

}






