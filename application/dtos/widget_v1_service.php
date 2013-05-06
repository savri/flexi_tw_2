<?php

/**
 * widget_v1_service   
 */

include_once(APPPATH."dtos/service_dto.php");
include_once(APPPATH."dtos/widget_v1_dto.php");

class widget_v1_service extends service_dto {
	
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// MEMBERS
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public $widget;

	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -   
	// CONSTRUCTOR
	// + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + - + -	
	// ------------------------------------------------------------------------	
	public function __construct() {
		parent::__construct();
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
		parent::_initialize();
		$this->version 		= "1.0";
		$this->resource		= "widget";
		$this->widget 		= new widget_v1_dto();
	}

	/*
	 * _populateWithArray
	 * 
	 * This function will take in an array of data.  Specifically an
	 * array from a JSON object.  The data found in the array will be
	 * mapped into this object.
	 */
	protected function _populateWithArray( $array = null ) {
		parent::_populateWithArray($array);
		$this->_initialize();
		if ( array_key_exists('version', $array) ) $this->version = $array['version'];
		if ( array_key_exists('resource', $array) ) $this->resource = $array['resource'];
		$this->widget = null;
		if ( array_key_exists('widget', $array) ) {
			$this->widget = $array->widget;
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
		parent::_populateWithObject($that);
		$this->_initialize();
		if ( get_class($that) != get_class($this) ) return;
		$this->version = $that->version;
		$this->resource = $that->resource;
		$this->widget = $that->widget;	
	}
	/*
	 * _populateWithJSONString
	 * 
	 * This object will take in a JSON string parse it and popluate the 
	 * objects properties with the data found in the JSON string.
	 */
	// ------------------------------------------------------------------------	
	protected function _populateWithJSONString( $jsonString = null ) {
		parent::_populateWithJSONString($jsonString);
		$this->_initialize();
		$obj = json_decode($jsonString, TRUE);
		if( $obj == null ) return;
		if( array_key_exists('version', $obj) ) $this->version = $obj['version'];
		if( array_key_exists('resource', $obj) ) $this->resource = $obj['resource'];
		$this->widget = null;
		if( array_key_exists('widget', $obj) ) {
			$dto = new widget_v1_dto();
			$dto->populate($obj['widget']);
			$this->widget = $dto;
		}	
	
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
		if ( ! parent::isValid() ) 							return false;
		if( $this->version != "1.0") 						return false;							
		if( $this->resource != "widget") 					return false;						
		if ( ! is_object ($this->widget) )		 			return false;
		if ( ! $this->widget->isValid() ) 					return false;
		
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
		$out .= "	\"service\":\"{$this->service}\",\n";
		$out .= "	\"version\":\"{$this->version}\",\n";
		$out .= "	\"resource\":\"{$this->resource}\",\n";
		$out .= "	\"request\":\n";
		$out .= parent::requestToJSONString();
		$out .= ",\n";		
		$out .= "	\"widget\":\n";
		if( is_object($this->widget) ) {
			$widget = new widget_v1_dto();
			$widget->populate($this->widget);
			$json = $widget->toJSONString();
			$out .=  $this->getStringValue($json) . ",";
		}
		$out = trim($out, ",");
		$out .= "}\n";

		return $out;
	}

	

}

/* End of file widget_v1_service.php */