<?php
/**
 * Routines to resume a partially completed test 
 * or review a completed test 
 * 
 **/
class Testwell_resume_model extends CI_Model {
	/**
	 * Retrieve a past test and present it to the user
	 * If it's a partially completed test, then, it will 
	 * allow the user to continue from the next section
	 * Otherwise, they can review the whole test. No input.
	 *
	 * @return	array
	 */
	function reload_test() {//should we wrap this whole thing as a transaction?
		$data=array();
		$sect_arr=array();
		$top_arr=array();
		$q_arr=array();
		$p_arr=array();
		$ans_arr=array();
		$sub_ans_arr=array();
		$qid_list=array();
		
		$tid=$this->input->post('testId');
		$uid=$this->tw_auth_utils_model->get_current_user_id();
		//$this->firephp->log("Userid= ".$uid);
		$review_mode=$this->input->post('review_mode');
		
		//First determine the type of test
		$reload_test_type = $this->testwell_utils_model->get_test_type($tid);
		//$this->firephp->log("Test type is $reload_test_type");
		
		if (!$reload_test_type) {
			$this->firephp->log("Unable to reload test for ".$tid);
			return NULL;
		}
		//Read the test_section_metadata table for the testType
		$ret_status=$this->testwell_utils_model->get_section_metadata($reload_test_type,$sect_arr);
		//$this->firephp->log($sect_arr);
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve section data for testId".$tid);
			return NULL;
		}
		//For each section, get the topic data
		$ret_status=$this->testwell_utils_model->get_topic_metadata($sect_arr,$top_arr);
		//$this->firephp->log($top_arr);	
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve topic data for testId".$tid);
			return NULL;
		}
		// Get list of question ids in the test
		$ret_status = $this->get_question_list_from_generated_test($tid,$qid_list);
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve list of questions ids for test id".$tid);
			return NULL;
		}	
		//Get questions info for qids in list
		$ret_status=$this->get_questions_from_qlist($qid_list,$q_arr,$review_mode);	
		//$this->firephp->log($q_arr);	
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve list of questions for test id".$tid);
			return NULL;
		}
		//Now deal with the reading comp and fill out the passages
		$ret_status=$this->get_passages_for_test($tid,$p_arr);
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve passages for test id ".$tid);
			return NULL;
		}
		//Now get answer choices for each of the questions
		$ret_status=$this->testwell_utils_model->get_answer_choices($q_arr,$ans_arr);
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve answer choices for test id ".$tid);
			return NULL;
		}
		//Get the answers submitted by user
		$ret_status=$this->get_submitted_answers_for_test($uid,
										$tid,$sub_ans_arr);
		if (!$ret_status) {
			$this->firephp->log("Unable to retrieve answer choices for user id ".$uid." for test id".$tid);
			return NULL;
		}				
		//Finally, if not in review mode, since this test may be partially answered 
		//to see which section to display and also if they had timed the test
		//If it is a timed test, get time remaining for section
		$sec_data=$this->testwell_utils_model->get_current_section_for_user($uid,$tid);
		//$this->firephp->log("time and sec data:");
		//$this->firephp->log($sec_data);
		
		if ($sec_data['cur_section']<0){
			$this->firephp->log("Unable to determine which section to display for user id ".$uid." for test id".$tid);
			return NULL;
		}
		//Now that we have all the arrays, pass it back
		$data['sections']=$sect_arr;
		$data['topics']=$top_arr;
		$data['questions']=$q_arr;
		$data['passages']=$p_arr;
		$data['choices']=$ans_arr;
		$data['submitted_answers']=$sub_ans_arr;
		$data['cur_section']=$sec_data['cur_section'];
		$data['test_type']=$reload_test_type;
		$data['cur_test_id']=$tid;
		$data['timed_test_mode']=$sec_data['timed_test_mode'];
		$data['time_left']=$sec_data['time_left'];
		//$this->firephp->log("Resume model time left=".$data['time_left']);
		//$this->firephp->log($data);
		//$this->firephp->log("resume section id=".$data['cur_section']);
		//$this->firephp->log("timed test=".$sec_data['timed_test_mode']);
		
		return $data;
	}
	/**
	 * Given a testId retrieve the list of questions for
	 * that test. Return TRUE upon success and FALSE on 
	 * failure
	 *
	 * @param int (uuid)
	 * @param array (list of qid updated)
	 * @return	bool
	 */
	function get_question_list_from_generated_test($testId,&$qid_array){
		
		$in_table = TWELL_GEN_TESTS_TBL;
		$this->db->where('testId', $testId);
		$this->db->select('questionId,questionSequence');
		$query = $this->db->get($in_table);
		if ($query->num_rows()){
			$count = 0;
			foreach ($query->result() as $row) {
				//$this->firephp->log($row);
				$qid_array[$count] = $row;
				$count++;
			}
			//$qid_array[0]=$count-1;//total number of questions
			//$this->firephp->log($qid_array);
			return TRUE;
		} else {
			$this->log->firephp("Unable to retrieve question list for test id ".$testId);
			return FALSE;
		}
	}
	/**
	 * Given a list of qids retrieve the questions
	 * associated with them. Return TRUE upon success and FALSE on 
	 * failure. Populate the q_arr with question/passage info
	 *
	 * @param array
	 * @param array (question info populated)
	 * @param bool (test review mode or just resume test?)
	 * @return	bool
	 */
	function get_questions_from_qlist($qid_list,&$questions,$test_review_mode){
		//$this->firephp->log("In questions from list $in_table");
		
		//Get all the questions in the qlist in that order  
		//No need to sort by topic since we handle that on the js side
		
		$in_table = TWELL_Q_BANK_TBL;
		if ($test_review_mode==1){
			$this->firephp->log("review mode fetch");
			$this->db->select("questionId,question,sectionId,questionTopic,correctAnswerId");
		} else {
			$this->db->select("questionId,question,sectionId,questionTopic");
			
		}
		$i=0;
		//need to wrap this as a transaction -all or nothing - Maya Jan '13
		foreach($qid_list as $row) {
			//$this->firephp->log($row);
			$this->db->where('questionId',$row->questionId);
			$query=$this->db->get($in_table);
			if ($query->num_rows()==1) {
				$record=$query->row();
				//Resolve any image tags
				$record->question=$this->testwell_html_utils_model->add_img_path($record->question);
				$questions[$i]=$record;
				//$this->firephp->log($record->questionSequence);
  				$i++;
			} else {
				$this->firephp->log("Unable to retrive question info for question id".$record->questionId);
				return FALSE;
			}
		}
		//$this->firephp->log($questions);
		return TRUE;
	}
	/**
	 * Fetch the answers submitted by user for this test. 
	 * Return TRUE upon success (db read was good) and FALSE on 
	 * failure. Populate the sub_ans with answer info
	 *
	 * @param 	int (uuid)
	 * @param 	int (uuid)
	 * @param 	array (sub_ans array populated here)
	 * @return	bool
	 */
	function get_submitted_answers_for_test($user_id,$test_id,&$sub_ans){
		$in_table=TWELL_SUB_ANS_TBL;
		$this->db->where('internalAccountId',$user_id);
		$this->db->where('testId',$test_id);
		$this->db->select('questionId,answerId,isCorrect');
		$query=$this->db->get($in_table);
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row){
				$sub_ans[$row->questionId]=$row;
			}
			//$this->firephp->log($sub_ans);
			return TRUE;
		} else if ($query->num_rows()==0){
			//$this->firephp->log("Nothing was answered");
			return TRUE;
		} else {
			$this->firephp->log("Problem reading submitted answers for ".$user_id." for test id".$test_id);
			return FALSE;
		}
	}
	/**
	 * For this test, retrieve the  passages
	 * associated with it.Populate the pass_arr with passage info
	 * Return TRUE upon success and FALSE on 
	 * failure. 
	 *
	 * @param int (uuid)
	 * @param array (passage info populated)
	 * @return	bool
	 */
	function get_passages_for_test($testId,&$pass_arr){
		$in_table=TWELL_GEN_TESTS_PASS_TBL;
		$this->db->where('testId',$testId);
		$this->db->select('passageId,passage,num_questions,q1,q2,q3,q4,q5');
		$query=$this->db->get($in_table);
		$nrows=$query->num_rows();
		if ($nrows) {
			$i=0;
			$pass_arr['num_passages']=$nrows;
			//$this->firephp->log("Number of passages= ".$nrows);
			foreach ($query->result() as $row){
				$pass_arr[$i]=$row;
				$i++;
			}
			//$this->firephp->log("Passages= ".$pass_arr);
			return TRUE;
			
		} else {
			$this->firephp->log("Unable to retrive passages for test id".$testId);
			return FALSE;
		}
	}
}