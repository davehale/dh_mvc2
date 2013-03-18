<?php
namespace dh_mvc2;




use dh_mvc2\dispatchers\Base_Dispatcher;

use dh_mvc2\routers\Base_router;

use dh_mvc2\autoloaders\BasicAutoloader;

use  dh_mvc2\classes\Config;


class Application {
	
	protected static $instance = NULL;
	public static $config;
	
	/**
	 *
	 * @access protected, must start class as singleton
	 * @example Dh_mv2::dir_link("path/to/application/directory")->run();
	 */
	protected function __construct() {
		set_include_path(get_include_path() . PATH_SEPARATOR . realpath(dirname(__DIR__)));
		spl_autoload_register();
	
	}
	
	/**
	 *
	 * @param $app_path string       	
	 * @return instance of Application
	 */
	public static function dir_link($app_path = NULL) {
		
		$paths = explode(PATH_SEPARATOR, get_include_path());
		 
		if (array_search($app_path, $paths) === false)
			array_push($paths, $app_path);
		 
		set_include_path(implode(PATH_SEPARATOR, $paths));
		
		if (! file_exists ( $app_path )) {
			require_once 'exeptions/DH_MVC2_Application_Exeption.php';
			throw new \DH_MVC2_Application_Exeption("Must supply a path to an application directory");
		}
		
		if (! self::$instance) {
			self::$instance = new self ();
		}
		self::$instance->init ( $app_path );
		return self::$instance;
	}
	
	protected function init($app_path) {
		
		$config_files ['DH_MVC'] = __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.ini.php';
		$config_files ['APP'] =  $app_path . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.ini.php';
		
		Config::init($config_files);
		BasicAutoloader::register();
		
		
		
		}
	
	
	public function run($url=NULL) {
		$route = new Base_router($url);
	
	}

}
