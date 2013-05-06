<?php

include_once(APPPATH."dtos/generic_dto.php");

abstract class service_dto extends generic_dto {
	
	
	public $service;
	public $version;
	public $resource;
	public $request;


	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// CONSTRUCTOR
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public function __construct() { 
		parent::__construct();
		$this->service 	= "";
		$this->version 	= "";
		$this->resource 	= "";
		$this->request 	= array();
	}
	
	/*
	 * _initialize()
	 * 
	 * This function will set the default values for this object.
	 */	
	// ------------------------------------------------------------------------
	protected function _initialize() {
		$this->service		= "WidgetServices";
		$this->version 		= "";
		$this->resource		= "";
		$this->request 		= Array();
	}		
	
 
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// PUBLIC
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public function addRequestParam($key, $value) {
		$this->request[] = array($key => $value);
	}
	// ------------------------------------------------------------------------
	public function requestToJSONString() {
		return json_encode($this->request);
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
		if ( array_key_exists('service', $array) ) $this->service = $array['service'];
		if ( array_key_exists('version', $array) ) $this->version = $array['version'];
		if ( array_key_exists('resource', $array) ) $this->resource = $array['resource'];
		$this->request = array();
		if ( array_key_exists('request', $array) ) {
			if( ! empty($array->request)) {
				$this->request = $array->request;
			}					
		}
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
		$this->service = $that->service;
		$this->version = $that->version;
		$this->resource = $that->resource;
		$this->request = $that->request;	
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
		if( $this->getStringValue( $jsonString ) == null ) return;
		if( $this->getStringValue( $jsonString ) == "" ) return;
		$obj = json_decode($jsonString, TRUE);
		if( $obj == null ) return;
		if( array_key_exists('service', $obj) ) $this->service = $obj['service'];
		if( array_key_exists('version', $obj) ) $this->version = $obj['version'];
		if( array_key_exists('resource', $obj) ) $this->resource = $obj['resource'];
		$this->request = array();
		if( array_key_exists('request', $obj) ) {
			foreach($obj['request'] as $array) {
				foreach($array as $key=>$value) {
					$this->addRequestParam($key, $value);
				}
			}						
		}		
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
	/*
	 * toXMLString
	 * 
	 * This function will turn the object into a string that can be parsed into
	 * an object via an XML parser.
	 */		
	// ------------------------------------------------------------------------
	public function toXMLString() {
		$out = "";
		$out .= "<WidgetServices version=\"\" service=\"\">\n";
		$out .= "</WidgetServices>\n";
		return $out;
	}
		
	// ------------------------------------------------------------------------
	public function isValid() {
		if( $this->service != "WidgetServices") 			return false;			
		return true;
	}	

	
}

/* End of file service_dto.php */