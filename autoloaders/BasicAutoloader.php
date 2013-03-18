<?php
namespace dh_mvc2\autoloaders;

use dh_mvc2\classes\Config;

class BasicAutoloader {

	
	private static $pathsArray = array ();
	
	
	
	
	
	public static function addPaths(array $paths=NULL){
		if(!isset($paths)){
			$paths =  array();
		}
		$paths = array_merge_recursive(config::get_paths(),$paths);
		foreach ( $paths as $key => $path ) {
			$path = str_replace ( "\\", "/", (rtrim ( $path, '/' ) . "/") );
			$key = strtoupper($key);
			self::$pathsArray [$key] = $path;
			defined ( $key ) || define ( $key, $path );
		}
	}
	
	public static function register(array $pathsArray=NULL) {
		self::addPaths($pathsArray);
	
		spl_autoload_register ( array (
				__NAMESPACE__ . '\BasicAutoloader',
				'loader'
		) );
	}
	private static function loader($className) {
		// swap \ for / for namespaces to be found on unix systems
		$className = str_replace ( "\\", "/", $className ) . '.php';
		foreach ( self::$pathsArray as $key => $path ) {
			
			$fullFilePath = constant ( $key ) .DIRECTORY_SEPARATOR. $className;
			if (file_exists ( $fullFilePath )) {
	
				require ($fullFilePath);
				break;
			}
		}
	}
	
	
	
	
	
}

?>