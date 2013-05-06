<?php
/**
 * Routines to help save a test after it's generated
 * Each test with the sequence of questions is recorded in
 * generated_tests table; The reading comp section with passages
 * and associated questions is recorded in a separate table
 * Each test taken by a user is recorded in tests_taken table
 * Each answer selected in a multiple choice is recorded in answers_submitted
 **/
class Testwell_record_model extends CI_Model {
	/**
	 * Records a newly generated unique test in the generated_tests
	 * table and records the passages used in the reading comprehension
	 * in the generated_tests_passages table.
	 * Returns id of the saved test if test is successfully saved in the database
	 * 0 if it fails
	 *
	 * @param	enum
	 * @param	array
	 * @param	array
	 * @return	integer(uuid)
	 */
	function record_generated_test($test_type,$ques_arr,$pass_arr) {
		//$this->firephp->log("in record gen test");
		$test_id=$this->uuid->v4();
		$now = date("Y-m-d H:i:s");
		$q_status=$this->record_questions($test_type,$test_id,$now,$ques_arr);
		if (!$q_status) {
			$this->firephp->log("Unable to record questions for generated test. Problem!");
			return 0;
		}
		$p_status=$this->record_passages($test_id,$pass_arr);
	
		//return the test_id for this test
		//$this->firephp->log("Test recorded for testId".$test_id);
		return $test_id;
	}
	/**
	 * Records questions in sequence in generated_tests
	 * Returns TRUE if all questions successfully saved in the database
	 * FALSE if any fails
	 *
	 * @param	enum
	 * @param	uuid (integer)
	 * @param	time-date
	 * @param	array (of questions)
	 * @return	bool
	 */	
	function record_questions($test_type,$test_id,$now,$q_arr) {
		$data=array();
		$in_table=TWELL_GEN_TESTS_TBL;
		
		//Save each question in the table against
		//this test id. Make sure you save the sequence
		//of question too.
		$i=1;
		foreach ($q_arr as $question) {
			//$this->firephp->log($question->sectionId);
			$data = array(
				'testId' => $test_id ,
			    'testType'=>$test_type,
				'testGenerationDateTime'=>$now,
			    'sectionId' => $question->sectionId ,
			    'questionSequence' => $i,
				'questionId'=>$question->questionId
			);
			//$this->firephp->log($data);
			$this->db->insert($in_table,$data);//How do you check for success/fail here? --Maya Jan '13
			$i++;
		}
		return TRUE;
	}
	/**
	 * Records passages in sequence in generated_tests_passages for the
	 * specified test id
	 * Returns TRUE if all passages are successfully saved in the database
	 * FALSE if any fails
	 *
	 * @param	uuid (integer)
	 * @param	array (of questions)
	 * @return	bool
	 */	
	function record_passages($test_id,$p_arr) {
		$data=array();
		$num_passages=$p_arr['num_passages'];
		$in_table=TWELL_GEN_TESTS_PASS_TBL;
		//Save each passage and the associated questions against
		//this test id. 
		$i=1;
		for ($i=0;$i<$num_passages;$i++) {
			//$this->firephp->log($question->sectionId);
			$row=$p_arr[$i];
			//$this->firephp->log($row);
			$data = array(
			'testId' => $test_id ,
			   'passageId' => $row->passageId,
			   'passage'=>$row->passage,
			   'num_questions'=>$row->num_questions,
			   'q1'=>$row->q1,
			   'q2'=>$row->q2,
			   'q3'=>$row->q3,
			   'q4'=>$row->q4,
			   'q5'=>$row->q5,
			);
			//$this->firephp->log($data);
			$this->db->insert($in_table,$data);//How do you check for success/fail here? --Maya Jan '13
		}
		return TRUE;
	}
	/**
	 * When a user takes a test, records the test id for the user_id in
	 * the tests_taken table as well as which sections he has completed
	 * Returns TRUE upon success and FALSE on failure
	 *
	 * @param	uuid (integer)
	 * @param	array (of sections)
	 * @param	uuid (integer)
	 * @param	enum 
	 * @return	bool
	 */
	function record_test_taken_for_user($user_id,$sections,$test_id,$test_type,$timed_test_mode){
		$data=array();
		//$this->firephp->log("In record_test_taken_for_user");
		//$this->firephp->log("Timed test=".$timed_test_mode);
		$in_table=TWELL_TEST_TAKE_TBL;
		$now = date("Y-m-d H:i:s");
		foreach ($sections as $section) {
			//$this->firephp->log($section->sectionNumQuestions);
			if ((int)($section->sectionNumQuestions)){
				//$this->firephp->log($section);
				$data=array('internalAccountId'=>$user_id,
							'testId'=>$test_id,
							'timedTest'=>$timed_test_mode,
							'startTimeDate'=>$now,
							'finishTimeDate'=>"0000-00-00 00:00:00",
							'sectionId'=>$section->sectionId,
							'sectionComplete'=>0,
							'timeRemaining'=>0);
				//$this->firephp->log($data);
				//$this->firephp->log("Initialized time remaining to 0");
				$this->db->insert($in_table,$data);
				//$this->firephp->log("Completed insertion for $section->sectionId");	
				//Need to determine success of insert and return TRUE - Maya Jan 2013
			}	
		}	
	}
	/**
	 * Record time left for the current section in test when
	 * user is taking a timed test
	 * @return	boolean
	 */
	function record_time_left() {
		$in_table=TWELL_TEST_TAKE_TBL;
		$time_left=$this->input->post('secs_left');
		//$this->firephp->log("In record_time_left");
		//For now I'm going to update this time for all incomplete sections for this testid/userid	
		//I know it's clumsy - need to think more about this -- Maya Feb '13
		$this->db->where('testId',$this->input->post('testId'));
		$this->db->where('internalAccountId',$this->input->post('internalAccountId'));
		$this->db->where('sectionComplete',0);
		$this->db->update($in_table, array('timeRemaining'=>$time_left));
		if ($this->db->affected_rows()>0){
			//$this->firephp->log("time successfully updated");
			return TRUE;
		} else {
			//$this->firephp->log("time update failed");
			
			return FALSE;
		}
	}
	/**
	 * When a user selects an answer, record it in the answers_submitted 
	 * table for this user for this tests. If user chooses another answer 
	 * for this question, overwrite the answer. Determine if the answer selected
	 * is the right one by comparing it to the answers table and indicate that
	 * Return array with this info back to client else return NULL
	 * @return	array
	 */
	function record_answer() {
		$data=array();
		
		$in_table=TWELL_SUB_ANS_TBL;
		$create_entry=$this->input->post('create');
		
		//Determine if the answer submitted was the right one
		//Get the right answer id from question_bank for this id and check
		$correct_ans=$this->check_for_correct_answer($this->input->post('questionId'),
													$this->input->post('answerId'));
		//if we have already recorded a response for this question, update it
		if ($create_entry==0){ 
			//$this->firephp->log("submitted_answers updated ");
			//$this->firephp->log("Correct ans is $correct_ans");
			
			//Record for this question Id needs to be modified
			$data=array('answerId' => $this->input->post('answerId'),'isCorrect'=>$correct_ans);
			$this->db->where('questionId',$this->input->post('questionId'));
			$this->db->where('internalAccountId',$this->input->post('internalAccountId'));
			$this->db->where('testId',$this->input->post('testId'));
			$this->db->update($in_table, $data);
			if ($this->db->affected_rows()>0){
				$data['isCorrect']=$correct_ans;
				$data['recordAnswer']=TRUE;
			} else {
				$data['recordAnswer']=FALSE;
			}
		} else if ($create_entry==1){
			//This questions has not been answered before and so we need to make a new entry intodb
			//$this->firephp->log("submitted_answers inserted");
			//$this->firephp->log("Correct ans is $correct_ans");
			
			$data = array(
			   'internalAccountId' =>$this->input->post('internalAccountId')  ,
			   'testId' => $this->input->post('testId') ,
			   'questionId' => $this->input->post('questionId'),
			   'answerId' => $this->input->post('answerId') ,
			   'isCorrect' => $correct_ans
			);
			$this->db->insert($in_table,$data);
			if ($this->db->affected_rows()>0){
				$data['isCorrect']=$correct_ans;
				$data['recordAnswer']=TRUE;
			} else {
				$data['recordAnswer']=FALSE;
			}
		}
		//Return the correctness of the submitted answer
		//$this->firephp->log($data);
		return $data;
	}
	/**
	 * A section can be completed if the user clicks the "Section Complete"
	 * button or if the user runs out of time alloted for the section.
	 * When either of these happens, mark that section for that user in this test
	 * as complete in the tests_taken table. They can't return to this section
	 * again. In addition, if all the sections in a test are completed,
	 * then record the time of finishing test in the table
	 * Upon successfully updating the table, return TRUE; else 
	 * return FALSE. 
	 * @return	boolean
	 */
	function record_section_complete() {
		$data=array();
	
		//$this->firephp->log("in model record_section_complete");
		$in_table=TWELL_TEST_TAKE_TBL;
		$this->db->where('internalAccountId',$this->input->post('userId'));
		$this->db->where('testId',$this->input->post('testId'));
		$this->db->where('sectionId',$this->input->post('sectionId'));
		//$this->firephp->log($this->input->post('sectionId'));
		//$this->firephp->log($this->input->post('testId'));
		//$xx=$this->input->post('sectionId');
		//$this->firephp->log("Marking $xx as complete");
		
		$data=array('sectionComplete'=>1,'timeRemaining'=>0);
		$this->db->update($in_table,$data);
		//$this->firephp->log("updated section to complete");
		//$xx=$this->db->affected_rows();
		//$this->firephp->log("Affected rows= ".$xx);
		//$this->firephp->log($this->db->last_query());
		
		if ($this->db->affected_rows()>0){
			//Now check to see if all the sections are complete
			//If they are, update the testFinished time and date
			$ret=$this->check_test_complete_and_record($this->input->post('userId'),$this->input->post('testId'));
			return $ret;
		} else {
			$this->firephp->log("Unable to mark section as complete for this test. Problem!");
			return FALSE; //need to handle db_error reporting better
		}
	}
	
	/**
	 * Check to see if all sections for this tests are completed
	 * If so, update the testFinished time for test. Return TRUE
	 * if successfully checked (and potentially updated) and FALSE if it fails
	 * @param	uuid (int)
	 * @param	uuid (int)
	 * @return	boolean
	 */
	function check_test_complete_and_record($userId,$testId){	
		//$this->firephp->log("In check_test_complete_and_update");
		$in_table=TWELL_TEST_TAKE_TBL;
		$this->db->where('internalAccountId',$userId);
		$this->db->where('testId',$testId);
		//$this->firephp->log("TestId=$testId");
		$this->db->select('sectionComplete');
		$query=$this->db->get($in_table);
		//$this->firephp->log("Getting all sectionComplete values");
		
		$num_rows=$query->num_rows();
		$comp_status=0;
		if ($num_rows>0){
			foreach($query->result() as $row){
				//$this->firephp->log($row->sectionComplete);
				$comp_status+=$row->sectionComplete;
			}
			if ($comp_status==$num_rows){
				//all sections had been completed; update finish time
				$now=date("Y-m-d H:i:s");
				$this->db->where('testId',$testId);
				$this->db->update($in_table,array("finishTimeDate"=>$now));
				if ($this->db->affected_rows()>0) {
					//$this->firephp->log("Test complete! Updates successful");
					return TRUE;
				} else {
					$this->firephp->log("Unable to mark test as complete. Problem!");
					return FALSE;
				}
			} else {
				//$this->firephp->log("Section complete; Test partially done!");
				//Nothing more to do. check is successful. return success
				return TRUE;
			}
		} else {
			$this->firephp->log("Failure to get info from tests_taken table. Problem!");
			return FALSE;
		}
	}
	/**
	 * Each time the user selects an answer to a question
	 * we record it and also check to see if they selected
	 * the right answer. Compare the answer id submitted with
	 * the correct answer id stored in the question_bank table 
	 * for this question. Return TRUE if correct,FALSE otherwise
	 * @param	int
	 * @param	uuid (int)
	 * @return	boolean
	 */
	function check_for_correct_answer($qid,$aid) {
		$in_table=TWELL_Q_BANK_TBL;
		$this->db->select('correctAnswerId');
		$query=$this->db->get_where($in_table, array('questionId'=>$qid)); 
		if ($query->num_rows()==1){
			$row=$query->row();				
			$res=strcmp($aid, $row->correctAnswerId);//Correct way to compare 2 uuids
			//$this->firephp->log("caid=$row->correctAnswerId and ans=$aid");
			if ($res==1){
				//$this->firephp->log("about to return TRUE");
				return TRUE;
			} else{
				//$this->firephp->log("about to return FALSE");
				return FALSE;
			}
		} else {
			//need to report db error here
			$this->firephp->log("DB error in getting correct answer from $in_table. Problem!");
			return FALSE;//confusing, no? Maya Jan 13
		}
	}
}