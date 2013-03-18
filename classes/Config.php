<?php
namespace dh_mvc2\classes;
/**
 * @author dave
 * @desc config class queried via static methods
 */
class Config {
	
	/**
	 * @var array of config values
	 */
	public static $config = array ();
	
	
	/**
	 * reads in an array of config files and calls several static methods to populate 
	 * framework and application required defines and variables
	 * @param array $files
	 * @return void|multitype:
	 * 
	 * @see Config::resolve_MySQL_creds() 
	 * @see Config::create_path_defines()
	 * @see Config::create_url_defines ()
	 * @see Config::define_misc()
	 * 
	 */
	public static function init(array $files = NULL) {
		if (! isset ( $files )) {
			return;
		}
		self::read_configs ( $files );
		self::resolve_MySQL_creds ();
		self::create_path_defines ();
		self::create_url_defines ();
		self::define_misc();
		return self::$config;
	}
	
	/**
	 * @returns applications default language
	 */
	public static function get_default_language(){
		return self::$config['default']['language'];
	}
	public static function dump_config() {
		var_dump ( self::$config );
	}
	public static function get_config() {
		return self::$config;
	}
	/**
	 * @return string the default url to use defined by module/controller/action
	 */
	public static function get_default_request() {
		return self::$config ['default'] ['module'] .DIRECTORY_SEPARATOR. self::$config ['default'] ['controller'] .DIRECTORY_SEPARATOR. self::$config ['default'] ['action'];
	}
	
	public static function get_paths() {
		return self::$config ['paths'];
	}
	
	/**
	 * @return array of mysql host, user, password
	 */
	public static function get_MySQL_creds() {
		return self::$config ['mysql'];
	}
	private static function create_path_defines() {
		
		if (! isset ( self::$config ['paths'] )) {
			return;
		}
		foreach ( self::$config ['paths'] as $key => $path ) {
			$key = strtoupper ( $key );
			defined ( $key ) || define ( $key, $path );
		}
	}
	private static function define_misc(){
		if (! isset ( self::$config ['misc'] )) {
			return;
		}
		foreach ( self::$config ['misc'] as $key => $path ) {
			$key = strtoupper ( $key );
			defined ( $key ) || define ( $key, $path );
		}
	}
	private static function create_url_defines() {
		
		if (! isset ( self::$config ['urls'] )) {
			return;
		}
		foreach ( self::$config ['urls'] as $key => $url ) {
			$key = strtoupper ( $key );
			
			defined ( $key ) || define ( $key, $url );
		
		}
	}
	private static function read_configs(array $files) {
		
		foreach ( $files as $key => $file ) {
			if (file_exists ( $file )) {
				self::$config = array_merge_recursive ( self::$config, parse_ini_file ( $file, TRUE ) );
			}
		
		}
	}
	
	/**
	 * decides on which env application is in via config entry and switched into config[mysql][user] etc the correct creds
	 */
	private static function resolve_MySQL_creds() {
		if (self::$config ['environment'] ['development']) {
			$env = "development";
		} else {
			$env = "production";
		}
		self::$config ['mysql'] ['host'] = self::$config ['mysql'] [$env] ['host'];
		self::$config ['mysql'] ['user'] = self::$config ['mysql'] [$env] ['user'];
		self::$config ['mysql'] ['password'] = self::$config ['mysql'] [$env] ['password'];
		self::$config ['mysql'] ['db_prefix'] = self::$config ['mysql'] [$env] ['db_prefix'];
		
		unset ( self::$config ['mysql'] ['development'] );
		unset ( self::$config ['mysql'] ['production'] );
	}
	
	/**
	 * @return string echo Config:: will dump all of it to screen
	 */
	public function __toString() {
		var_dump ( self::$config );
		return "";
	}

}

?>