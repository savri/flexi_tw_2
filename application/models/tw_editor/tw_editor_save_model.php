<?php
/**
 * Model for the editor to save questions/answers, passages/questions
 * Location:<CI-top>/application/model/tw_editor/tw_editor_save_model.php
 **/
class Tw_editor_save_model extends CI_Model {

	/**
	 * Saves question and answers - new and modified
	 *
	 * @param 	{int} 	qid		questionId to get details for
	 * @return	{array}	data	array with the question & answer details on success
	 *							NULL on failure
	 */
	function save_question() {
		$qdata=array();
		$adata=array();
		
		//If question field is blank, do nothing
		if (!$this->input->post('question')) {
			$this->firephp->log("Blank question");
			return FALSE;
		}
		//Now get various values for the question/answers
		$section_id=$this->tw_editor_get_model->get_section_id($this->input->post('questionSection'));
		$top=$this->input->post('questionTopic');
		//$this->firephp->log($section_id);
		//$this->firephp->log("Topic is:".$top);
		
		//If we have a quid, then it means we update an existing question
		//else insert new question.
		$qid=$this->input->post('qid');
		//$this->firephp->log("question id: ".$qid);
		
		if ($qid!=0) {
			//Update existing question & answers
			//$this->firephp->log("update question");
			$ret_val=$this->save_existing_question_and_answers($section_id,$top,$qid);
		}else {
			//add new question
			//$this->firephp->log("new question");
			$this->save_new_question_and_answer($section_id,$top);
		}
		//$this->firephp->log("Returning to controller");
		return TRUE;
	}
	/**
	 * Updates an existing question and answers that's been modified
	 *
	 * @param 	{int} 		sect_id		uuid for section for question
	 * @param 	{string} 	top			topic name for question
	 * @param 	{int} 		q_id		questionId modify
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_existing_question_and_answers($sect_id,$top,$q_id) {
		$cor_ans_id=$this->save_existing_answers($q_id);
		if ($cor_ans_id) {
			return ($this->save_existing_question($sect_id,$top,$q_id,$cor_ans_id));
		} else {
			$this->firephp->log("Unable to modify existing question's answer choices. Problem!");
			return FALSE;
		}
	}
	/**
	 * Updates an existing question's answers that's been modified
	 *
	 * @param 	{int} 		q_id		questionId modified
	 * @return	{int}					correct answer's uuid on success; 0 on failure
	 */
	function save_existing_answers($qid) {
		$in_table=TWELL_ANS_TBL;
		$this->db->where("questionId",$qid);
		$qres1=$this->db->get($in_table);
		if ($qres1->num_rows()==4){ //Hardcode to 4. Need to think about this- Maya Feb '13
			$i=1;
			foreach ($qres1->result() as $row){
				//$this->firephp->log("Choice".$i);
				$ans_id=$row->answerId;
				$val_str='choice'.$i;
				//Sanitize the new choice values by stripping out configurable image path
				$html_str=$this->testwell_html_utils_model->strip_img_path($this->input->post($val_str));
				$tag_str='choice'.$i.'_tag';
				$tag=$this->input->post($tag_str);
				//$this->firephp->log("tag= ".$tag);
				//$this->firephp->log("Ansid= ".$ans_id);
				if ($tag=='CORRECT'){
					//$this->firephp->log("Correct compare");
					$tc=1;
				}
				$this->firephp->log("Tag comp= ".$tc);
				if ($tc==1){
					$c_aid=$ans_id;
					//$this->firephp->log("Correct Ansid= ".$ans_id);
					//$this->firephp->log("Correct Ansval= ".$html_str.", Correct Tag= ".$tag);
				}
				$this->db->where("answerId",$ans_id);
				$this->db->update($in_table,array("answerValue"=>$html_str,"answerTag"=>$tag));//check for success -- Maya Feb '13
				$i++;
			}
			//$this->firephp->log("Correct answ id= ".$c_aid);
			return $c_aid;
		} else {
			$this->firephp->log("Unable to original answer choices for ".$qid." to save with new values");
			return 0;
		}
	}
	/**
	 * Updates an existing question that's been modified
	 *
	 * @param 	{int} 		sect_id		uuid for section for question
	 * @param 	{string} 	top			topic name for question
	 * @param 	{int} 		q_id		questionId modify
	 * @param 	{int} 		c_aid		Id of correct answer
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_existing_question($section_id,$top,$qid,$c_aid){
		$this->firephp->log("In save existing question");
		$in_table=TWELL_Q_BANK_TBL;
		$this->db->where('questionId',$qid);
		//Sanitize the question body html
		$qhtml=$this->testwell_html_utils_model->strip_img_path($this->input->post('question'));
		//$this->firephp->log($qhtml);
		$data=array('sectionId'=>$section_id,'questionTopic'=>$top,'question'=>$qhtml,'correctAnswerId'=>$c_aid);
		//$this->firephp->log($data);
		$this->db->update($in_table,$data); //Success check? -- Maya Feb '13
		//$this->firephp->log("Question updated");
		return TRUE;
	}
	/**
	 * Insert new question and answers
	 *
	 * @param 	{int} 		sect_id		uuid for section for question
	 * @param 	{string} 	top			topic name for question
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_new_question_and_answer($section_id,$top) {
		//Generate answer id to be assigned to the correct answer
		$ans_uuid=$this->uuid->v4();
		$last_id=$this->save_new_question($section_id, $top,$ans_uuid);
		if ($last_id){
			return ($this->save_new_answers($last_id,$ans_uuid));
		} else {
			$this->firephp->log("Unable to save new question");
			return FALSE;
		}
	}
	/**
	 * Insert new question
	 *
	 * @param 	{int} 		sect_id		uuid for section for question
	 * @param 	{string} 	top			topic name for question
	 * @param 	{int} 		a_uuid		uuid for the correct answer
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_new_question($section_id, $top,$a_uuid) {
		$qhtml=$this->testwell_html_utils_model->strip_img_path($this->input->post('question'));
		$qdata = array(
			'question'=>$qhtml,
			'sectionId'=>$section_id,
			'questionTopic'=> $this->input->post('questionTopic'),
			'correctAnswerId'=>$a_uuid
			);
		//$this->firephp->log($qdata);
		$in_table=TWELL_Q_BANK_TBL;
		$this->db->insert($in_table,$qdata);
		$last_id=$this->db->insert_id();
		return $last_id;
	}
	/**
	 * Insert new answer choices for q_id question
	 *
	 * @param 	{int} 		q_id		q_id for question
	 * @param 	{int} 		a_uuid		uuid for the correct answer
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_new_answers($q_id,$a_uuid) {
		//$this->firephp->log("Inserted question $last_id");
		$adata = array(
		   array(
		      'questionId' => $q_id ,
		      'answerValue' => $this->testwell_html_utils_model->strip_img_path($this->input->post('choice1')),
			  'answerTag'=> $this->input->post('choice1_tag'),
			  'answerId'=> $this->tw_editor_get_model->get_answer_uuid($this->input->post('choice1_tag'),$a_uuid)
		   ),
		   array(
		      'questionId' => $q_id ,
		      'answerValue' => $this->testwell_html_utils_model->strip_img_path($this->input->post('choice2')),
			  'answerTag'=> $this->input->post('choice2_tag'),
			  'answerId'=>$this->tw_editor_get_model->get_answer_uuid($this->input->post('choice2_tag'),$a_uuid)
		   ),
		   	array(
			  'questionId' => $q_id ,
		      'answerValue' => $this->testwell_html_utils_model->strip_img_path($this->input->post('choice3')),
			  'answerTag'=> $this->input->post('choice3_tag'),
			  'answerId'=>$this->tw_editor_get_model->get_answer_uuid($this->input->post('choice3_tag'),$a_uuid)
		   ),
		   array(
		      'questionId' => $q_id ,
		      'answerValue' => $this->testwell_html_utils_model->strip_img_path($this->input->post('choice4')),
			  'answerTag'=> $this->input->post('choice4_tag'),
			  'answerId'=>$this->tw_editor_get_model->get_answer_uuid($this->input->post('choice4_tag'),$a_uuid)
		   )
		);
		//$this->firephp->log($adata);
		$in_table=TWELL_ANS_TBL;
		$this->db->insert_batch($in_table, $adata);//how to check for success here? --Maya - Feb '13
		return TRUE;
	}
	/**
	 * Save new passage body and the associated question ids
	 *
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_passage() {
		$qlist=array();
		//$this->firephp->log("In model's save_passage_routine");
	
		$passage=$this->input->post('passage');
		if ($passage){
			//$this->firephp->log($passage);
			//$this->firephp->log($qlist);
			
			//First save the body of the passage
			//Use passage_id as the reference id to store the questions
			//associated with this passage
			$pass_id=$this->save_passage_body($passage);
			//$this->firephp->log("Passage id=".$pass_id);
			
			//Now save the associated questions
			//Make qlist an array
			$qarr=explode(',', $this->input->post('question_list'));
			if (count($qarr)) {
				$ret=$this->save_passage_questions($qarr,$pass_id);
				return $ret;
			} else {
				$this->firephp->log("No questions to associate with passage. Problem!");
				return FALSE;
			}
			
		} else {
			return FALSE;
		}
	}
	/**
	 * Save new passage body
	 *
	 * @return	{boolean}				TRUE on success; FALSE on failure
	 */
	function save_passage_body($pass) {
		
		$in_table=TWELL_PASS_TBL;
		$this->db->insert($in_table,array('passage'=>$pass));
		
		//Return passage_id as the reference id to store the questions
		//associated with this passage
		return ($this->db->insert_id());
	}
	/**
	 * Save questions associated with this above new passage
	 *
	 * @param	{array}		array of qids for this passage
	 * @param	{int}		uuid for this passage
	 * @return	{boolean}	TRUE on success; FALSE on failure
	 */
	function save_passage_questions($q_arr, $p_id) {
		$in_table=TWELL_PASS_Q_TBL;
		//$this->firephp->log("num array".count($q_arr));
		foreach ($q_arr as $value) {
			//$this->firephp->log("about to handle questions".$value);
			$qid=$value;
			//$this->firephp->log("quid=".$qid);
			$this->db->insert($in_table,array('questionId'=>$qid,'passageId'=>$p_id));
			//$this->firephp->log('insert id='.$this->db->insert_id());	
		}
		return TRUE;
	}
}