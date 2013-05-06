<?php

abstract class generic_dto {
	


	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// CONSTRUCTOR
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public function __construct() { }
	protected function _initialize() { }
	
	
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// ABSTRACT
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	abstract protected function _populateWithArray( $array = null );	
	abstract protected function _populateWithObject( $that = null );	
	abstract protected function _populateWithJSONString( $jsonString = null );
	abstract protected function _populateWithXMLString( $xmlString = null );
	abstract public function isValid();	
	abstract public function toJSONString();
 
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// PUBLIC
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	
	/*
	 * _getStringValue
	 * 
	 * This is a helper function will that ensure the object passed in will be
	 * a valid string on the way out.  (Prevents null pointers)
	 */
	// ------------------------------------------------------------------------	
	public function getStringValue($inString) {
		$outStr ="";
		if($inString == NULL){
			$outStr = "";
		}else if(is_bool($inString)){
			$outStr = "FALSE";
			if($inString){
				$outStr = "TRUE";
			}
		}else if( is_array($inString) || is_object($inString) ){
			$outStr = "";
		}else{ 
	 		$outStr = (String)$inString;
	 		if($inString == NULL){
	 			$outStr = "";
	  		}
	  	}
	  	return $outStr;
	}
	/*
	 * _getJSONStringValue
	 * 
	 * This is a helper function that will ensure the object passed in will be
	 * a valid string on the way out.  Futhermore, any special characters that 
	 * must be escaped in a JSON string value will be escaped.
	 */
	// ------------------------------------------------------------------------	
	public function getJSONStringValue($inString) {
		$value = $this->getStringValue($inString);
		
		$value = $this->unescapeJSONString($value);
		$value = $this->escapeJSONString($value);
		
		return $value;
	}
	// ------------------------------------------------------------------------	
	public function escapeJSONString($inString) {
		$value = $inString; 
		
		$value = str_replace("\"", "_DOUBLE_QUOTE_", $value);
		$value = str_replace("\\", "_BACKSLASH_", $value);
		
		$value = str_replace("_BACKSLASH_", "\\\\",$value);
		$value = str_replace("_DOUBLE_QUOTE_", "\\\"",$value);
		
		return $value;
				
	}
	// ------------------------------------------------------------------------	
	public function unescapeJSONString($inString) {
		$value = $inString; 
		
		$value = str_replace("\\\"", "_ESC_DOUBLE_QUOTE_", $value);
		$value = str_replace("\\\\", "_ESC_BACKSLASH_", $value);
		
		$value = str_replace("_ESC_BACKSLASH_", "\\",$value);
		$value = str_replace("_ESC_DOUBLE_QUOTE_", "\"",$value);
		
		return $value;		
	}

	/*
	 * populate
	 * 
	 * This function will take something in as input, examine it, and then attempt
	 * to populate self with the material that was provided.  Should we not be able
	 * to evaluate the input object, the result will be self being reset to it's
	 * default values.
	 */	
	// ------------------------------------------------------------------------
	public function populate( $obj = null ) {
		$this->_initialize();
		if ( $obj == null ) return;
		if ( is_string($obj) ) {
			$pos = strpos($obj,"<?xml");
			if( $pos === false ) {
				$this->_populateWithJSONString($this->getStringValue($obj));
			}else{
				$this->_populateWithXMLString($this->getStringValue($obj));
			}
		}else if ( is_array($obj) ) {
			$this->_populateWithArray($obj);						
		}else if (get_class($obj) == get_class($this)) {
			$this->_populateWithObject($obj);
		}else{
			throw new Exception("I can not parse an object of type [".get_class($obj)."]");
		}
	}
	
	
	/*
	 * equals
	 * 
	 * This function will tell you if the object handed in matches 'self'.
	 * I know, I coded this in a 'lame' way.  :(
	 */	
	// ------------------------------------------------------------------------
	public function equals( $obj = null ) {
		if( $obj == null ) return false;
		if ( get_class($obj) != get_class($this) ) return false;
		$this_string = "" . $this->__toString();
		$that_string = "" . $obj;
		if ( $this_string == $that_string ) return true;
		return false;
	}
	
	/*
	 * GETTER
	 * This function applies business rules to every property get you do on the
	 * object.  If we see something we can warn the user about, throw an exception
	 * so they know they need to fix something.
	 * 
	 * RULES:
	 * - You can only request properties that exist in the object.
	 */
	// ------------------------------------------------------------------------	
	public function __get($key = null ) {
		if( empty($key) ) return null;
		$class_vars = get_class_vars(get_class( $this ));
		$props = Array();
		foreach ($class_vars as $prop => $value) {
			$props[] = $prop;
		}		
		if( ! in_array($key, $props) ) throw new Exception("Variable $key is not a property on this object.");
		return $this->$key;		
    }
    /*
	 * SETTER
	 * This function applies business rules to every property set you do on the
	 * object.  If we see something we can warn the user about, throw an exception
	 * so they know they need to fix something.
	 * 
	 * RULES:
	 * - You can only set properties that exist in the object.
	 */
    // ------------------------------------------------------------------------
	public function __set( $key=null, $val=null ) {
		if( empty($key) ) throw new Exception("Variable $key can not be empty.");
		$class_vars = get_class_vars(get_class( $this ));
		$props = Array();
		foreach ($class_vars as $prop => $value) {
			$props[] = $prop;
		}		
		if( ! in_array($key, $props) ) throw new Exception("Variable $key is not property on this object.");
				
		$this->$key = $val;
	}	
	
    /*
	 * TO_STRING
	 * This function will execute if you ever try to get the string version of 
	 * the object.  
	 * 
	 * FEATURES
	 * - PHP output ready.
	 * - Shows all the data in an outline look.
	 * - Tells you if the data is valid or not.
	 */	
	// ------------------------------------------------------------------------	
 	public function __toString() {
 		
		$outString = "";
  		$outString .= "<pre>\n";
  		$outString .= "--------------------------------------[". gettype($this) ."]\n\n";
  		$outString .= $this->toJSONString();
  		if ( $this->isValid() ) {
  			$outString .= "\n--[". gettype($this) ."] is valid.\n";
  		}else{
  			$outString .= "\n--[". gettype($this) ."] is NOT valid.\n";
  		}
  		$outString .= "</pre>\n";
    	return $outString;
  	}	

	
}

/* End of file generic_dto.php */