<?php

namespace classes;

use dh_mvc2\classes\Config;

define ( 'LANGS', 'french => fr,' . 'english=> en,' . 'italian=>it,' . 'spanish=>sp' );
class Languages {
	function __construct() {
	}
	function __destruct() {
	}
	public static function getLanguage(&$url = null) {
		
		if (isset ( $url [0] )) {
			$country_code = $url [0];
		} else if (isset ( $url )) {
			$country_code = $url;
		} else {
			$country_code = NULL;
		}
		
		foreach ( explode ( ",", LANGS ) as $country_and_code ) {
			$temp = explode ( "=>", $country_and_code );
			$languageArray [trim ( $temp [0] )] = trim ( $temp [1] );
		}
		
		$languageName = (array_search ( $country_code, $languageArray ));
		
		if ($languageName) {
			array_shift ( $url );
		} else {
			$languageName = (array_search ( Config::get_default_language (), $languageArray ));
		
		}
		
		return array ('language' => $languageName, 'code' => $country_code );
	
	}
}
