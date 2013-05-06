<?php
/**
 * Controller for the tool to add/delete/edit questions
 * in the question bank
 * Location:<CI-top>/application/controllers/tw_editor.php
 **/ 
class Tw_editor extends CI_Controller {
  
	public function index() {
		//Load all the models
		//$this->load->model('tw_editor/q_and_a_model');	
		//$this->load->model('tw_editor/input_questions_model');	
		//$this->load->model('tw_editor/input_passage_model');	
		//$this->load->model('tw_editor/edit_all_model');	
		
		//$this->load->model('tw_editor/tw_editor_utils_model');	
		//$this->load->model('tw_editor/tw_editor_get_model');			
		//$this->load->model('tw_editor/tw_editor_save_model');			
				
		$this->load->view('tw_editor/tw_editor_main_view');
	}
	/**
	 * Sets up page to add new question/answers
	 *
	 *
	 * @return	void	returns page to display w/ editor
	 */
	function add_new_question() {
		$this->tw_editor_utils_model->init_ck();
		$this->load->view('tw_editor/tw_editor_question_view');
	}
	/**
	 * Sets up page to add new passages
	 *
	 * @return	void	returns page to display w/ editor
	 */	
	function add_new_passage() {
		$this->tw_editor_utils_model->init_ck();
		$this->load->view('tw_editor/tw_editor_passage_view');		
	}
	/**
	 * Sets up page to enable user to modify questions
	 * in a section/topic - so that they can make mass
	 * changes - though the changes have to be made 1-by-1
	 *
	 * @return	void	returns page to display options & editor
	 */
	function mass_modify() {
		$this->tw_editor_utils_model->init_ck();
		$this->load->view('tw_editor/tw_editor_mass_modify_view');
	}
	//who calls this? - Maya Feb '13
	function read_data() {
		$this->input_questions_model->add_record();
		$this->load->view('tw_editor/input_questions_view',$data);
	}
	/**
	 * Populate the topics dropdown on input and modify views
	 * depending on which section is selected in response to ajax call
	 *
	 * @return	{array} topics	Filled out list of topics on success;
	 * 							NULL on failure
	 */
	function get_sect_topics(){
		//$this->firephp->log("In get_sect_topics");
		$topics=$this->tw_editor_get_model->get_topics();
		//$this->firephp->log($topics);
		echo json_encode($topics);
	}

	/**
	 * Retrieve all the READING COMP questions in the question_bank 
	 * table that are not already associated with some passage when
	 * you are adding a new passage to the bank
	 *
	 * @return	{array}	Returns an array of questions 
	 * 					to be associated w/ passage on success;
	 *					NULL on failure
	 */
	function get_read_comp_questions() {
		$output=array();
		$ques=$this->tw_editor_get_model->get_free_read_comp_questions();
		if (count($ques)>0){
			$output['status']=TRUE;
			$output['qarray']=$ques;
		} else {
			$output['status']=FALSE;
			$output['error']="No questions found";
		}
		echo json_encode($output);
	}
	/**
	 * Save new/modified(??) question & associated answers added
	 *
	 * @return	{void}		Returns success/failure
	 */
	function save_question() {
		$output=array();
		
		//$this->firephp->log("Save question");
		$res=$this->tw_editor_save_model->save_question();
		//$this->firephp->log("Result is: ".$res);
		if ($res){
			$output['status']=TRUE;
			$output['message']="Question & answers saved!";
		}else {
			$output['status']=FALSE;
			$output['error']="Could not save question & answers";
		}
		echo json_encode($output);
	}
	/**
	 * Save new/modified(??) passage & associated questions
	 *
	 * @return	{void}		Returns success/failure
	 */
	function save_passage() {
		$output=array();		
		//$this->firephp->log("Back here");
		$res=$this->tw_editor_save_model->save_passage();
		//$this->firephp->log("res= ".$res);
		if ($res) {
			$output['status']=TRUE;
			$output['message']="Passage saved!";
		} else {
			$output['status']=FALSE;
			$output['error']="Passage not saved";
		}
		echo json_encode($output);
	}
	/**
	 * Retrieve question details from question id
	 * for modifying
	 *
	 * @param	{int} qid	question id of interest
	 * @return	{array}		Returns question details on success
	 *						NULL on failure
	 */
	function get_question_for_qid() {
		//$this->firephp->log("In get_q_for_edit");
		$output=array();
		$qid=$this->input->post('qid');		
		$res=$this->tw_editor_get_model->get_question_for_qid($qid);
		//$this->firephp->log("res= ".$res);
		if ($res){
			$output['status']=TRUE;
			$output['data']=$res;
		} else {
			$output['status']=FALSE;
			$output['error']="Invalid question id ".$this->input->post('qid')." Enter valid question id";
		}
		echo json_encode($output);

	}
	/**
	 * Retrieve question for mass modification in
	 * batches of 10 for the specified section/topic
	 *
	 * @return	{array}		Returns array of relevant questions on success
	 *						NULL on failure
	 */
	//Once they have selected the section/topic
	//Get the questions in batches of 10
	function get_questions_in_10s(){
		$output=array();
		$res=$this->tw_editor_get_model->get_questions_in_10s();
		//Check if there are any questions at all in the table
		if ($res['total_count'] >0) {
			//Now see if this retrieval had any - since we're fetching in batches of 10
			if ($res['num_rows']>=0){
				$output['status']=TRUE;
				//$output['num_rows']=$res['num_rows'];
				$output['q_array']=$res['q_array'];
				$output['total_count']=$res['total_count'];
				
			}else {
				$output['status']=FALSE;
				$output['error']="Could not retrieve questions to edit_all";
			}
		} else if ($res['total_count'] ==0) {
			$output['status']=TRUE;	
			$output['total_count']=0;
		} else {
				$output['status']=FALSE;
				$output['error']="Error in retrieving questions! Problem";
		}
		echo json_encode($output);
	}
}