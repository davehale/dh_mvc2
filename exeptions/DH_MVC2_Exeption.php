<?php


/**
 *
 * @author dave
 *        
 */


abstract class DH_MVC2_Exeption extends \Exception {
	
	
private $_previous = null;

public function exception_handler($exception) {
 	
 	
 	// these are our templates
 	$traceline = "#%s %s(%s): %s(%s)";
 	$msg = "%s <br/> <h3>'%s'</h3>Stack trace:<br/>%s  thrown in %s on line %s";
 	
 	// alter your trace as you please, here
 	$trace = $exception->getTrace();
 	foreach ($trace as $key => $stackPoint) {
 		// I'm converting arguments to their type
 		// (prevents passwords from ever getting logged as anything other than 'string')
 		$trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
 	}
 	
 	// build your tracelines
 	$result = array();
 	foreach ($trace as $key => $stackPoint) {
 		$result[] = sprintf(
 				$traceline,
 				$key,
 				$stackPoint['file'],
 				$stackPoint['line'],
 				$stackPoint['function'],
 				implode(', ', $stackPoint['args'])
 		);
 	}
 	// trace always ends with {main}
 	$result[] = '#' . ++$key . ' {thrown by}';
 	
 	// write tracelines into main template
 	$msg = sprintf(
 			$msg,
 			get_class($exception),
 			$exception->getMessage(),
 			implode("<br/>", $result),
 			$exception->getFile(),
 			$exception->getLine()
 	);
 	
 	// log or echo as you please
 	echo ($msg);
 	error_log($msg);
 	
 }
 
 
    /**
     * Construct the exception
     *
     * @param  string $msg
     * @param  int $code
     * @param  Exception $previous
     * @return void
     */
    public function __construct($msg = '', $code = 0, Exception $previous = null)
    {
    	
    	set_exception_handler (array($this,'exception_handler'));
    	
 	      if (version_compare(PHP_VERSION, '5.3.0', '<')) {
           parent::__construct($msg, (int) $code);
            $this->_previous = $previous;
        } else {
            parent::__construct($msg, (int) $code, $previous);
        }
    }

    /**
     * Overloading
     *
     * For PHP < 5.3.0, provides access to the getPrevious() method.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public function __call($method, array $args)
    {
        if ('getprevious' == strtolower($method)) {
            return $this->_getPrevious();
        }
        return null;
    }

    /**
     * String representation of the exception
     *
     * @return string
     */
    public function __toString()
    {
         return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Returns previous Exception
     *
     * @return Exception|null
     */
    protected function _getPrevious()
    {
        return $this->_previous;
    }
}

?>