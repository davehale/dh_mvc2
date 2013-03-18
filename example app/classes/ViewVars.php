<?php
namespace classes;

class ViewVars implements \ArrayAccess{
   
    public $vars;

    function offsetExists($offset){
        return isset($this->vars[$offset]);
    }

    function offsetGet($offset){
        return isset($this->vars[$offset]) ? $this->vars[$offset] : new self;
    }

    function offsetSet($offset, $value){
        $this->vars[$offset] = $value;
    }

    function offsetUnset($offset){
        unset($this->vars[$offset]);
    }

    function __toString(){
        return '';
    }

}
