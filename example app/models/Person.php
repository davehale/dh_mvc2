<?php
class Person {
	protected $name;
	protected $age;
	public function __get($varname) {
		//will return protected / private variables via their getters
		$func = 'get' . ucfirst ( $varname );
		if (is_callable ( __CLASS__ . '::' . $func )) {
			return $this->$func ();
		}
		
		
		
		//returns pulic vars set outside class or NULL
		return (isset ( $this->varname )) ? $this->varname : NULL;
	}
	
	public function testgit(){
		
	}
	public function __set($varname,$value) {
		//will return protected / private variables via their getters
		$func = 'set' . ucfirst ( $varname );
		if (is_callable ( __CLASS__ . '::' . $func )) {
			return $this->$func ($value);
		}
		//todo
		//sets pulic vars from outside class
		return  $this->$varname = $value;
	}
	
	
	/**
	 *
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * @return the $age
	 */
	public function getAge() {
		return $this->age;
	}
	
	/**
	 *
	 * @param field_type $name        	
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 *
	 * @param field_type $age        	
	 */
	public function setAge($age) {
		$this->age = $age;
	}
}

?>