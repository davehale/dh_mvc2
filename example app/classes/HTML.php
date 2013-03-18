<?php

namespace classes;

class HTML {
	function __construct() {
	}
	function __destruct() {
	}
	
	
	/**
	 * 
	 * 
	 * produces a verticle boxed list of links, 
	 * where link has href title and <p> clickable href description
	 * default css is in global css nav#boxedLinksWithDescription
	 * 
	 * @param array(array()) $linkArray
	 * 
	 * array supplied in the format
	 * array('text to show' => array ('path'=>"", 'description'=>"") 
	 * 
	 * @return string
	 */
	public static function boxedLinksWithDescription($linkArray) {
		ob_start ();
		echo "<nav id='boxedLinksWithDescription'><ul>";
		foreach ( $linkArray as $linkName => $info ) {
			echo "\r\n<li><a href=\"".WEBROOT_URL."/{$info['searchURL']}\">{$info['name']}<p>{$info['description']}</p></a></li>";
		}
		echo "</ul></nav>";
		$catagoriesHtml = ob_get_contents ();
		ob_end_clean ();
		return $catagoriesHtml;
	}
}

?>