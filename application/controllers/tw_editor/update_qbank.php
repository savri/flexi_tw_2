<?php

class Update_qbank extends CI_Controller {
	
	function index() {
		$temp_arr=array();
		//$this->load->view('update_view');
		echo "hello<br/>";
		//$this->db->where('newAnswerId',0);
		$query=$this->db->get('question_bank');
		echo "Number of questions  $query->num_rows()";
		
		foreach ($query->result() as $row) {
			echo "QID=$row->questionId<br/>";
			$this->db->where('questionId',$row->questionId);
			$this->db->where('answerTag','CORRECT');
			$this->db->select('newAnswerId');
			$tquery=$this->db->get('answers');
			$tquery=$this->db->get_where('answers',array('questionId'=>$row->questionId,'answerTag'=>'CORRECT'));
			echo"numrows=$tquery->num_rows<br/>";
			$trow = $tquery->row(); 
			echo "Correct Answer Id=$trow->newAnswerId<br/>";
			$this->db->where('questionId',$row->questionId);
			$this->db->update('question_bank',array('newCorrectAnswerId'=>$trow->newAnswerId));
		}
		echo "all updated";
		
	}
	
}
?>