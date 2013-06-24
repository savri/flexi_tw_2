<?php
class Testwell_new_model extends CI_Model {
	/**
	 * create a new test for the user. This would happen if there 
	 * were no tests in the generated_tests table that the user
	 * had not already taken. (Currently however, we gen a new test
	 * each time - need to fix - Maya Jan 13)
	 * Return TRUE if successful 
	 * (along with an array containing the new test data)
	 *  otherwise NULL.
	 *
	 * @return	array
	 */
	function generate_new_test() {
		$data=array();
		$sect_arr=array();
		$top_arr=array();
		$q_arr=array();
		$p_arr=array();
		$ans_arr=array();
		
		$user_id=$this->tw_auth_utils_model->get_current_user_id();
		$this->firephp->log("The user's id is=".$user_id);
		
		$test_type=$this->input->post('testType');
		//$this->firephp->log($test_type);
		
		//First read the test_section_metadata table
		$s_status=$this->testwell_utils_model->get_section_metadata($test_type,$sect_arr);
		//$this->firephp->log("Section array follows: ");
		//$this->firephp->log($sect_arr);
		
		if ($s_status) {
			//For each section, read the test_topic_metadata
			$t_status=$this->testwell_utils_model->get_topic_metadata($sect_arr,$top_arr);
			//$this->firephp->log("Topic array follows: ");
			//$this->firephp->log($top_arr);
			
			if ($t_status) {
				//For each topic get questions from question_bank
				//$this->firephp->log("about to get questions");
				$q_status=$this->get_new_questions($sect_arr,$top_arr,$q_arr,$p_arr);
				
				//$q_arr=$qdata['questions'];
				//$p_arr=$qdata['passages'];
				//$this->firephp->log("Questions from new model= ".$q_arr);
				//$this->firephp->log(count($q_arr));
				//$this->firephp->log($qdata['questions']);
				
				//Now get answer choices for each of the questions
				if (count($q_arr)) {
					$a_status=$this->testwell_utils_model->get_answer_choices($q_arr,$ans_arr);
					//$this->firephp->log(count($ans_arr));
					if (!$a_status) {
						$this->firephp->log("No answer choices retrieved!! Problem!!");
						return NULL;
					}
				} else {
					$this->firephp->log("No questions retrieved!! Problem!!");
					return NULL;
				}
			} else {
				$this->firephp->log("Could not retrieve from topics_meta table! Problem!!");
				return NULL; 
			}
			//Since this is a new test, save it in generated_test table
			//Also update the user's tests_taken table with this testId
			//$this->firephp->log("About to record generated test");
			$current_test_id=$this->testwell_record_model->record_generated_test($test_type,$q_arr,$p_arr);
			$this->firephp->log("Test created for userid= ".$user_id);
			$this->testwell_record_model->record_test_taken_for_user($user_id,
											$sect_arr,$current_test_id,$test_type,$this->input->post('timed_test_mode'));
			
			//Now make up the data array to return
			$data['sections']=$sect_arr;
			$data['topics']=$top_arr;
			$data['questions']=$q_arr;
			$data['passages']=$p_arr;
			$data['choices']=$ans_arr;
			$data['cur_test_id']=$current_test_id;
			$data['timed_test_mode']=$this->input->post('timed_test_mode');
			//Duration for first section
			$temp=(array(array_shift($sect_arr)));//returns first array element in sect_array
			$data['time_left']=($temp[0]->sectionDuration)*60; //in seconds
			//$this->firephp->log($data);
			return $data;
		} else
			$this->firephp->log("Could not retrieve from sections_meta table! Problem!!");
			return NULL;
	}
	/**
	 * Retrieve questions for the new test. Fill out array of questions and 
	 * associated multiple choice answers if successful
	 * (able to get questions for each section), return TRUE, otherwise FALSE.
	 *
	 * @param	array	(array of sections for test)
	 * @param	array   (array of topics for each section)
	 * @return	bool
	 */
	function get_new_questions($sections,$topics,&$questions,&$passages) {
	
		$qdata=array();
		$temp_array=array();

		$i=0;//Index for the array of questions in the test
		$q_table=TWELL_Q_BANK_TBL;
		//$this->firephp->log($topics);
		foreach ($topics as $topic) {
			//First see if there are questions from this section to be included
			$sec_num_q=$this->testwell_utils_model->get_num_questions_for_section($sections,$topic->sectionId);
			//$this->firephp->log("Number of qs in section ".$sec_num_q);
			
			//Need to determine when we can have topicNumQuestions if sec_num_q is zero(Maya Jan 13)
			if (($sec_num_q)&&($topic->topicNumQuestions)){
				//$this->firephp->log($topic->topicName);
				//We need to handle reading comprehension differently b/c of passages
				if ($topic->topicName=="READING_COMP") {
					$status=$this->get_new_reading_comp_questions($i,$questions,$passages);
					if (!$status){
						$this->firephp->log("Could not retrieve Reading Comprehension questions");
						return FALSE;
					}
					//End of the reading_comp section
				} else {
					//For the other sections
					//This query needs more thought. 
					//Eventually - we need to find questions that have not been used before - Maya Jan 13
					$query="SELECT questionId,question,sectionId,questionTopic FROM ".$q_table ." WHERE (sectionId='$topic->sectionId'AND questionTopic='$topic->topicName') ORDER BY RAND() LIMIT ".$topic->topicNumQuestions;
					$qres=$this->db->query($query);
					
					//$this->firephp->log($qres->num_rows());
					if ($qres->num_rows()) {
						//$this->firephp->log("Got questions for ".$topic->topicName);
						foreach ($qres->result() as $row) {
							//Resolve any image tags
							$row->question=$this->testwell_html_utils_model->add_img_path($row->question);
							$questions[$i]=$row;
							//$this->firephp->log($questions[$i]);
							$i++;
						}
					} else {
						$this->firephp->log("Not enough questions retrieved for ".$topic->topicName);
						return FALSE;
					}
				}
			}
		}
		return TRUE;
	}
	/**
	 * Get questions for Reading Comp section - need to get the required
	 * number of passages and the questions associated with them. If successful
	 * (the num of passages is available, questions are retrieved), modify passage array
	 * questions array and question count,return TRUE otherwise return FALSE.
	 *
	 * @param	integer	(index into the array of all questions in the test which is modified here)
	 * @param	array (of questions in the test which is modified in this routine)
	 * @param	array (of passages and their associated question ids in the test which is modified here)
	 * @return	boolean
	 */
	function get_new_reading_comp_questions(&$q_index,&$q_arr,&$p_arr) {
		
		//Num of passages is stored in section table's custom field
		$num_passages=$this->testwell_passage_model->get_num_passages();//check if this is alwaysfixed?
		//$this->firephp->log("Got ".$num_passages." passages");
		if ($num_passages) {
			$in_table=TWELL_PASS_TBL;
			$q_table=TWELL_Q_BANK_TBL;
			$query="SELECT passageId,passage FROM ".$in_table ." ORDER BY RAND() LIMIT ".$num_passages;
			$qres=$this->db->query($query);
			//$this->firephp->log($qres->num_rows());
			if ($qres->num_rows==$num_passages) {
				//$this->firephp->log("Got passages");
				//$p_arr[0]=$num_passages;//Can't i use $p_arr['num_passages'] here? Maya Jan 13
				$p_arr['num_passages']=$num_passages;
				$j=0;
				foreach ($qres->result() as $row) {
					//$this->firephp->log($row);
					$temp_row=new stdClass();
					$temp_row->passageId=$row->passageId;
					$temp_row->passage=$row->passage;
					//Now look in the passage_questions table for all question ids
					//associated with this passageId
					$in_table=TWELL_PASS_Q_TBL;
					$this->db->where('passageId',$row->passageId);
					$res=$this->db->get($in_table);
					//$this->firephp->log("Num ques for passage ".$res->num_rows());
					if ($res->num_rows()) {
						$k=1;
						$qstr="";
						foreach ($res->result() as $qrow){
							$qstr="q".$k;//Will generate "q1,q2,q3,q4 as the index Revisit this idea. Maya Jan 13
							$this->db->select('questionId,question,sectionId,questionTopic');
							$this->db->where('questionId',$qrow->questionId);
							$gres=$this->db->get($q_table);
							//$this->firephp->log("Num ques retrieved ".$gres->num_rows());
							if ($gres->num_rows()==1) {
								$grow=$gres->row();
								$q_arr[$q_index]=$grow;
								//$this->firephp->log($q_arr[$i]);
								$temp_row->$qstr=$qrow->questionId;
								//$this->firephp->log($temp_row);
								$q_index++;
								$k++;
							}else {
								$this->firephp->log("Getting question for passage failed!");
								return FALSE;
							}
						}
					} else {
						$this->firephp->log("No questions with this passage! Problem");
						return FALSE;
					}
					//$this->firephp->log($temp_row);
					//$temp_array[]=$temp_row;
					//$this->firephp->log($temp_array);
					$temp_row->num_questions=$k-1;//There are $k-1 questions since we started w/ k=1
					$p_arr[$j]=$temp_row;								
					//$this->firephp->log($p_arr[$j]);
					$j++;
				}
				//$this->firephp->log($p_arr);
			} else { //if ($qres->num_rows==$num_passages) match
				$this->firephp->log("Not enough passages retrieved! Only".$qres->num_rows());
				return FALSE;
			}
		} else {//if ($num_passages) match
			$this->firephp->log("Zero passages to get!Check sectionNumQuestions entry for READING COMP");
			return FALSE;
		}
		return TRUE;
	}
}		