<?php
class Testwell_html_utils_model extends CI_Model {
	
	function strip_img_path($str){
		$html = str_get_html($str);//from simple_html_dom library's dom_helper
		// Find all images
		foreach($html->find('img') as $element){
			//echo $element->src.'</br>';
			$myArray=explode('/',$element->src);
			$xx=count($myArray).'</br>';
	        $element->src=$myArray[$xx-1];
			//echo $element->src.'</br>';
		}
		return $html->save(); //store this in the question or answer.
	}
	function add_img_path($str) {
		$html = str_get_html($str);
		//$this->firephp->log("in add img_path");
		foreach($html->find('img') as $element){
			//strip any </br> at the end of this
			$element->src=preg_replace('/(<\/br>)+$/', '', $element->src);
			$element->src=$this->config->item('img_loc').$element->src;
			//$this->firephp->log($element->src);
		}		
		//$this->firephp->log($html->save());
		return $html->save(); //store this in the question or answer.
	}
}