<?php
/**
 * Utility functions that read various fields
 * typically from a table.  I use get_ as the verb
 * for these instead of read_
 * 
 *
 * @param	int
 * @return	string (enum)
 */
class Testwell_utils_model extends CI_Model {
	/**
	 * Determine the type of test from the
	 * test_id from the generated_tests table
	 * If unable to read a value, return NULL
	 *
	 * @param	int
	 * @return	string (enum)
	 */
	function get_test_type($testId){
		$in_table = TWELL_GEN_TESTS_TBL;
		$this->db->where('testId', $testId);
		$this->db->group_by('testId');//Get for unique value of testIds
		$this->db->select('testType');
		$query = $this->db->get($in_table);
		//$this->firephp->log($query->num_rows());
		if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->testType;
		} else {
			$this->firephp->log("Unable to get a valid test_type. Problem!");
			return NULL;
		}
	}
	/**
	 * Determine the number of questions in a section given
	 * the section_id
	 *
	 * @param	array (full list of sections)
	 * @param	int 
	 * @return	integer
	 */
	function get_num_questions_for_section($sec_array,$sec_id) {
		//$this->firephp->log($sec_array);
		//$this->firephp->log($sec_id);
		$num_q=0;
		foreach ($sec_array as $key=>$section) {
			$res=strcmp($section->sectionId, $sec_id);//success if res=0
			//$this->firephp->log("res is: ".$res);
			if ($res==0){
				//$this->firephp->log("Section is ".$section->sectionName);
				$num_q=$section->sectionNumQuestions;
				break; 
			}
		}
		//$this->firephp->log("About to return ".$xx);
		return $num_q;
	}
	/**
	 * Read in all the sections for this test type. 
	 * Returns TRUE if the sections were read in successfully
	 * FALSE if the table read fails
	 *
	 * @param	enum 
	 * @param   array  (section array updated here)
	 * @return	bool
	 */
	function get_section_metadata($test_type,&$sections) {
		$in_table=TWELL_SECT_META_TBL;
		//$sections=array();
		//echo "My table=$my_table<br/>";
		$this->db->where('testType',$test_type);
		$query= $this->db->get($in_table);
		if ($query->num_rows) {
			foreach ($query->result() as $row) {
				$sections[$row->sectionName]=$row;
			    //$this->firephp->log($sections[$row->sectionName]);
			}
			return (TRUE);
			
		} else
			return FALSE;
	}
	/**
	 * Get info on all the topics for each section from
	 * topic metadata table.. REturn TRUE if you could
	 * successfully fetch the topic data for each section
	 * return FALSE if any one fails
	 *
	 * @param	array 
	 * @param	array (topic array updated here)
	 * @return  bool
	 */
	function get_topic_metadata($sections,&$topics) {
		$in_table=TWELL_TOP_META_TBL;
		//$this->firephp->log($sections);
	    $ret_status=TRUE;
		foreach($sections as $section) {
			//$this->db->where('sectionName',$section->sectionName);
			//$this->firephp->log($section);
			$this->db->where('sectionId',$section->sectionId);
			$query=$this->db->get($in_table);
			if ($query->num_rows()) {
				foreach ($query->result() as $row) {
					$topics[$row->topicName]=$row;
				    //$this->firephp->log($topics[$row->topicName]);
				}
			} else {
				$ret_status=FALSE;//Means one of the sections could not retrieve topics;bail out
				break;
			}
		}
		return $ret_status;
	}
	/**
	 * Determine which section a user stopped in this particular
	 * test. Get this by checking the test_taken table for this
	 * user and finding the incomplete section for this test_id. 
	 * On success, return the number of the section to resume in
	 * on failure, return NULL
	 *
	 * @param	uuid (int) 
	 * @param	uuid (int)
	 * @return  array
	 */
	function get_current_section_for_user($user_id,$test_id){
		$sec_info=array();
		//$this->firephp->log("Userid= ".$user_id." Test id= ".$test_id);
		$in_table=TWELL_TEST_TAKE_TBL;
		$this->db->where('internalAccountId',$user_id);
		$this->db->where('testId',$test_id);
		//$this->db->select('sectionId,sectionComplete,timedTest,timeRemaining');
		$query=$this->db->get($in_table);
		//Find the first section that is not complete
		$secount=1;
		$sec_info['time_left']=0;
		$sec_info['cur_section']=0;
		if ($query->num_rows() >0) {
			foreach ($query->result() as $row){
				//$this->firephp->log("$row->sectionId has complete status of $row->sectionComplete at $secount");
				$sec_info['timed_test_mode']=$row->timedTest;
				if ($row->sectionComplete==0) {
					//$this->firephp->log("About to determine incomplete section");
					//$this->firephp->log($row);
					$sec_info['time_left']=$row->timeRemaining;
					$sec_info['cur_section']=$secount;
					//$this->firephp->log("Utils model time left=".$row->timeRemaining);
					break;
				}else {
					$secount++;
				}
			}
			//$this->firephp->log($sec_info);
			return $sec_info;
		} else {
			$this->firephp->log("Unable to determine the section to resume test in. Problem!");
			return NULL;
		}
	}
	/**
	 * For each question, get the multiple choice answers
	 * Returns TRUE if the answers were read in successfully
	 * FALSE if the table read fails
	 *
	 * @param	array (questions) 
	 * @param   array (answers to be filled out)
	 * @return	bool
	 */
	function get_answer_choices($questions,&$answers) {
		$in_table=TWELL_ANS_TBL;
		
		//$this->firephp->log($questions);
		$i=0;
		foreach ($questions as $question) {
			//$this->firephp->log("Getting answer choices");
			//$this->firephp->log($question);
			//$this->firephp->log("Id=".$question->questionId);
			
			$this->db->where('questionId',$question->questionId);
			$query=$this->db->get($in_table);
			//$this->firephp->log("num rows= ".$query->num_rows());
			if ($query->num_rows()) {
				foreach ($query->result() as $row) {
					//we should get 4 rows for each questionId
					$row->answerValue=$this->testwell_html_utils_model->add_img_path($row->answerValue);
					//$this->firephp->log($row->answerValue);
					$answers[$i]=$row;
					$i++;
				}
			} else
				return FALSE;
		}
		//$this->firephp->log($answers);
		return TRUE;
	}
}
	
