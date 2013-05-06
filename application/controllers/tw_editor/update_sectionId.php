<?php

class Update_sectionId extends CI_Controller {
	
	function index() {
		$temp_arr=array();
		//$this->load->view('update_view');
		echo "hello";
		//$this->db->where('newAnswerId',0);
		$query=$this->db->get_where('test_section_metadata',array('testSection'=>'QUANT_REASON'));
		echo "Number of rows affected $query->num_rows()";
		if ($query->num_rows()==1){
			$row=$query->result();
		}
		//Now to go qubannk andupdate each QUANT_REASON with this value
		/**
		foreach ($query->result() as $row) {
			$data=array('sectionId'=>$uuid_val);
			$this->db->where('testSection',$row->);
		    $this->db->update('answers',$data);
		}
		echo "all updated";
		**/
	}
	
}
?>