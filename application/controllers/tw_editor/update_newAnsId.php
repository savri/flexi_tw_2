<?php

class Update_newAnsId extends CI_Controller {
	
	function index() {
		$temp_arr=array();
		//$this->load->view('update_view');
		echo "hello";
		//$this->db->where('newAnswerId',0);
		$query=$this->db->get_where('answers',array('newAnswerId'=>0));
		echo "Number of rows affected $query->num_rows()";
		foreach ($query->result() as $row) {
			$data=array('newAnswerId'=>$this->uuid->v4());
			$this->db->where('id',$row->id);
		    $this->db->update('answers',$data);
		}
		echo "all updated";
	}
	
}
?>