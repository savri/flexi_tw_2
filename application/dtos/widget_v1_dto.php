<?php

include_once(APPPATH."dtos/generic_dto.php");

class widget_v1_dto extends generic_dto{
	
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// MEMBERS
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public $id;
	public $name;
	public $type;
	public $price;

	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// CONSTRUCTOR
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public function __construct() {
		$this->_initialize();
	}
 
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// PRIVATE
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -
	// ------------------------------------------------------------------------
	/*
	 * _initialize()
	 * 
	 * This function will set the default values for this object.
	 */	
	// ------------------------------------------------------------------------
	protected function _initialize() {
		$this->id			= "";
		$this->name 		= "";
		$this->type			= "";
		$this->price		= "";
	}
	/*
	 * _populateWithArray
	 * 
	 * This function will take in an array of data.  Specifically an
	 * array from a JSON object.  The data found in the array will be
	 * mapped into this object.
	 */
	protected function _populateWithArray( $array = null ) {
		$this->_initialize();
		if( $array == null ) return;	
		if( empty($array) ) return;	
		if ( ! is_array($array) ) return;
		if ( array_key_exists('id', $array) ) $this->id = $array['id'];
		if ( array_key_exists('name', $array) ) $this->name = $array['name'];
		if ( array_key_exists('type', $array) ) $this->type = $array['type'];
		if ( array_key_exists('price', $array) ) $this->price = $array['price'];
	}
	/*
	 * _populateWithObject
	 * 
	 * This object will take in another object of this type and populate the data
	 * in this object with the data from the input object.
	 */
	// ------------------------------------------------------------------------	
	protected function _populateWithObject( $that = null ) {
		$this->_initialize();
		if( $that == null ) return;		
		if ( get_class($that) != get_class($this) ) return;
		$this->id = $that->id;
		$this->name = $that->name;
		$this->type = $that->type;
		$this->price = $that->price;
	}
	/*
	 * _populateWithJSONString
	 * 
	 * This object will take in a JSON string parse it and popluate the 
	 * objects properties with the data found in the JSON string.
	 */
	// ------------------------------------------------------------------------	
	protected function _populateWithJSONString( $jsonString = null ) {
		
		$this->_initialize();
		if( $this->getStringValue( $jsonString ) == "" ) return;
		$obj = json_decode($jsonString, TRUE);
		if( $obj == null ) return;
		if( array_key_exists('id', $obj) ) $this->id = $obj['id'];
		if( array_key_exists('name', $obj) ) $this->name = $obj['name'];
		if( array_key_exists('type', $obj) ) $this->type = $obj['type'];
		if( array_key_exists('price', $obj) ) $this->price = $obj['price'];		
	}
	/*
	 * _populateWithXMLString
	 * 
	 * This object will take in an XML string parse it and popluate the 
	 * objects properties with the data found in the XML string.
	 */
	// ------------------------------------------------------------------------	
	protected function _populateWithXMLString( $xmlString = null ) {
		throw new Exception('This objet does not support XML ... yet.');
	}
	
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// PUBLIC
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	

	/*
	 * isValid
	 * 
	 * This function will tell you if the data found in this object is valid or not.
	 * By valid I mean is all the required data found and does the data correspond
	 * to the type of object we are.
	 */	
	// ------------------------------------------------------------------------
	public function isValid() {
		if( empty( $this->id ) ) 					return false;
		if( empty( $this->name ) )		 			return false;
		if( empty( $this->type ) ) 					return false;
		if( empty( $this->price ) ) 				return false;	
		return true;
	}	
	/*
	 * toJSONString
	 * 
	 * This function will turn the object into a string that can be parsed into
	 * an object via a JSON parser.
	 */		
	// ------------------------------------------------------------------------
	public function toJSONString() {
		$out = "";
		$out .= "{\n";
		$out .= "	\"id\": \"". $this->getJSONStringValue($this->id) ."\",\n";
		$out .= "	\"name\": \"". $this->getJSONStringValue($this->name) ."\",\n";
		$out .= "	\"type\": \"". $this->getJSONStringValue($this->type) ."\",\n";
		$out .= "	\"price\": \"". $this->getJSONStringValue($this->price) ."\"\n";
		$out .= "}\n";

		return $out;
	}

}

/* End of file widget_v1_dto.php */