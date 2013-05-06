<?php
/**
 * Model for the editor to fetch all sorts of data
 * Location:<CI-top>/application/model/tw_editor/tw_editor_get_model.php
 **/
class Tw_editor_get_model extends CI_Model {
	
	/**
	 * Retrieves question details for a given question
	 * id
	 *
	 * @param 	{int} 	qid		questionId to get details for
	 * @return	{array}	data	array with the question & answer details on success
	 *							NULL on failure
	 */
	function get_question_for_qid($qid) {
		$data=array();
		
		//$this->firephp->log("In get_q_for_edit_model");
		$in_table=TWELL_Q_BANK_TBL;
		//Get data on question w/ qid
		$this->db->where('questionId',$qid);
		$query=$this->db->get($in_table);
		//Make sure you add back the image path to all the q&a body
		if ($query->num_rows() == 1) {
			$row = $query->row();
			$data['questionId']=$row->questionId;
			$data['question']=$this->testwell_html_utils_model->add_img_path($row->question);
			$data['section']=$this->get_section_name($row->sectionId);
			$data['topic']=$row->questionTopic;
			$ans_arr=$this->get_answer_values($qid);
			$data['choice1']=$this->testwell_html_utils_model->add_img_path($ans_arr['choice1']);
			$data['tag1']=$ans_arr['tag1'];
			$data['choice2']=$this->testwell_html_utils_model->add_img_path($ans_arr['choice2']);
			$data['tag2']=$ans_arr['tag2'];
			$data['choice3']=$this->testwell_html_utils_model->add_img_path($ans_arr['choice3']);
			$data['tag3']=$ans_arr['tag3'];
			$data['choice4']=$this->testwell_html_utils_model->add_img_path($ans_arr['choice4']);
			$data['tag4']=$ans_arr['tag4'];
			//$this->firephp->log($data);
			return $data;
		} else {
			//Need to report the db error too - Maya Jan '13
			$this->firephp->log("getting question id for edit ".$qid." failed. Problem");
			return NULL;
		}
	}
	/**
	 * Retrieves section name for a given section id
	 *
	 * @param 	{int} 		secid	uuid identifying section
	 * @return	{string}	name	return name on success; NULL on failure
	 */
	function get_section_name($secid){
		//$this->firephp->log("In get_section_name");
		$in_table=TWELL_SECT_META_TBL;
		$this->db->where('sectionId',$secid);
		$this->db->select('sectionName');
		$query=$this->db->get($in_table);
		if ($query->num_rows() == 1) {
			$row = $query->row();
			//$this->firephp->log($row->sectionName);
			return $row->sectionName;
		} else {
			//Need to report the db error too - Maya Jan '13
			$this->firephp->log("getting section name for edit ".$secid." failed. Problem");
			return NULL;
		}
	}
	/**
	 * Retrieves section id for a given section name
	 *
	 * @param	{string}	name	return name on success; NULL on failure	 
	 * @return 	{int} 		secid	uuid identifying section on success; 0 on failure
	 */
	function get_section_id($sname){
		$this->db->select('sectionId');
		$this->db->where('sectionName',$sname);
		$query=$this->db->get("test_section_metadata");
		if ($query->num_rows()==1) {
			$row=$query->row();
			//$this->firephp->log($row->sectionId);
			return $row->sectionId;
		} else {
			$this->firephp->log("Error getting section Id");
			return 0;
		}
	}
	/**
	 * Returns topic names associated with a section name
	 *
	 * @return 	{array} 	tops	array of topic names
	 *								If we're in mass modify mode, then
	 *								need to offer a "All topics" choice
	 */
	function get_topics() {
		//$this->firephp->log("In getTopics model");
		$sect=$this->input->post('section');
		//$this->firephp->log($sect);
		$mass_modify_mode=$this->input->post('mass_modify');
		//$this->firephp->log("Edit_mode= ".$mass_modify_mode);
		if ($sect) {
			switch ($sect) {
			    case 'READING_COMP':
			    	//$this->firephp->log("Section equals REading Comp") ;
					$tops=array("READING_COMP"=>"READING_COMP");	
			        break;
			    case 'QUANT_REASON':
		        	//$this->firephp->log("Section equals Quant Reason") ;
					if($mass_modify_mode)
						$tops=array("All Topics"=>"All", "MATH_APPLICATION"=>"MATH_APPLICATION","MATH_CONCEPT"=>"MATH_CONCEPT");
					else
						$tops=array("MATH_APPLICATION"=>"MATH_APPLICATION","MATH_CONCEPT"=>"MATH_CONCEPT");
			        break;
			    case 'VERB_REASON':
		        	//$this->firephp->log("Section equals Verb Reason") ;
					if($mass_modify_mode)
						$tops=array("All Topics"=>"All","SYNONYMS"=>"SYNONYMS","SENTENCE_COMPLETION"=>"SENTENCE_COMPLETION");
					else
						$tops=array("SYNONYMS"=>"SYNONYMS","SENTENCE_COMPLETION"=>"SENTENCE_COMPLETION");
			        break;
				case 'MATH_ACH':
		        	//$this->firephp->log("Section equals Math ACH") ;
					if($mass_modify_mode)
						$tops=array("All Topics"=>"All","GEOMETRY"=>"GEOMETRY","ALGEBRA"=>"ALGEBRA","ARITHMETIC"=>"ARITHMETIC");
					else
						$tops=array("GEOMETRY"=>"GEOMETRY","ALGEBRA"=>"ALGEBRA","ARITHMETIC"=>"ARITHMETIC");
			        break;
				case 'ESSAY':
		        	//$this->firephp->log("Section equals Essay") ;
					$tops=array("ESSAY"=>"ESSAY");
			}	
		}
		//$this->firephp->log($tops);
		return $tops;
	}
	/**
	 * Retrieves answer values for a given question id
	 *
	 * @param 	{int} 		qid		id identifying question
	 * @return	{array}		ans_arr	return choices/tags on success; NULL on failure
	 */
	function get_answer_values($qid) {
		//$this->firephp->log("In get_answer_values");
		$ans_arr=array();
		
		$in_table=TWELL_ANS_TBL;
		$this->db->where('questionId',$qid);
		$this->db->select('answerValue,answerTag');
		$query=$this->db->get($in_table);
		//This is hardcoded...fix later? -- Maya Jan '13
		if ($query->num_rows() == 4) {
			$i=1;
			$ch="choice".$i;
			$tg="tag".$i;
			foreach ($query->result() as $row) {
				$ch="choice".$i;
				$tg="tag".$i;
				$ans_arr[$ch]=$row->answerValue;
				$ans_arr[$tg]=$row->answerTag;
				$i++;
			}
			//$this->firephp->log($ans_arr);
			return $ans_arr;
		} else {
			$this->firephp->log("getting answers for edit ".$qid." failed. Problem");
			return NULL;
		}
	}
	/**
	 * Retrieves entire question bank. WHY??
	 *
	 * @return	{array}		ans_arr	return choices/tags on success; NULL on failure
	 */
	function get_records() {
		$query = $this->db->get('question_bank');
		return $query;
	}
	/**
	 * Assigns uuid to a newly entered answer choice 
	 * for a new question
	 *
	 * @param 	{string} 	ans_tag	 		Qualifying tag for choice (enum)
	 * @param 	{int} 		cor_ans_uuid	uuid assigned to "correct" answer
	 * @return	{int}		uuid 			id to be assigned to answer choice
	 *										if tag is anything other than "correct"
	 * 										we generate a new uuid; else assign the 
	 *										uuid we passed in
	 */
	function get_answer_uuid($ans_tag,$cor_ans_uuid) {
		//$this->firephp->log("tag=".$ans_tag);
		$comp_res=strcmp($ans_tag,'CORRECT');
		//$this->firephp->log("comp_res=".$comp_res);
		if ($comp_res==1) {
			//$this->firephp->log("Correct aid=".$cor_ans_uuid);
			return $cor_ans_uuid;
		} else {
			return $this->uuid->v4();
		}
	}
	/**
	 * In mass modify mode, retrieve 10 questions at a time in the chosen
	 * section/topic combo
	 *
	 * @return	{array}		ret_arr 		return an array of questions
	 * 										along with number of questions
	 * 										returned (we may not always have 10);
	 *										return NULL on failure
	 */
	function get_questions_in_10s(){
		$ret_data=array();
		$q_arr=array();
		//$this->firephp->log("By 10s");
		//$this->firephp->log($this->input->post('section'));
		//$this->firephp->log($this->input->post('topic'));
		//$this->firephp->log($this->input->post('fetch_from_qid'));

		$section_name=$this->input->post('section');
		$sec_id=$this->tw_editor_get_model->get_section_id($section_name);
		//$this->firephp->log("Sec id=".$sec_id);
		
		//This was the last qid we fetched till Starts at 0 the first time
		$fetch_from_qid=intval($this->input->post('fetch_from_qid'));
		$in_table=TWELL_Q_BANK_TBL;
		$topic=$this->input->post('topic');
		if ($topic=="All Topics"){
			$count_query="SELECT COUNT(questionId) FROM ".$in_table." WHERE (sectionId='$sec_id') ORDER BY questionId";
			$query="SELECT questionId FROM ".$in_table." WHERE (sectionId='$sec_id'AND questionId>'$fetch_from_qid') ORDER BY questionId LIMIT 10";
		} else {
			$count_query="SELECT COUNT(questionId) FROM ".$in_table." WHERE (sectionId='$sec_id'AND questionTopic='$topic') ORDER BY questionId";
			$query="SELECT questionId FROM ".$in_table." WHERE (sectionId='$sec_id'AND questionTopic='$topic' AND questionId>'$fetch_from_qid') ORDER BY questionId LIMIT 10";
		}
		//$this->firephp->log($query);
		//Determine how many total questions fit our query
		//Do we have to do this each time? It wont change! --Maya, Jan '13
		$tcres=$this->db->query($count_query); 
		
		if ($tcres) {
			$trow=$tcres->row_array();
			//$this->firephp->log($trow['COUNT(questionId)']);
			//If there are any results to be had, then fetch the first 10
			if ($trow['COUNT(questionId)']>0){
				$ret_data['total_count']=$trow['COUNT(questionId)'];
				$qres=$this->db->query($query);
				$nrows=$qres->num_rows();//we could get 10 or less than 10 or even 0
				$this->firephp->log("Num rows:".$nrows);
				if ($nrows==0){
					$ret_data['num_rows']=0;
					$ret_data['q_array']="";
					//$this->firephp->log("No more questions matching criteria");
				} else {
					//Get info on each question
					$i=0;
					foreach($qres->result() as $row) {
						//$this->firephp->log($row->questionId);
						$q_arr[$i]=$this->get_question_for_qid($row->questionId);
						//$this->firephp->log($q_arr[$i]);
						$i++;
					}
					$ret_data['num_rows']=$nrows;
					$ret_data['q_array']=$q_arr;
				}
			} else {
				$ret_data['total_count']=0;
			}
			//$this->firephp->log($ret_data);
			return $ret_data;
		} else {
			$this->firephp->log("Unable to determine total number of questions matching criteria in get_10.Problem!");
			return NULL;
		}
	}
	/**
	 * When adding/modify passages, we need to associate questions with the 
	 * passage. A question can only be associated with one passage. List
	 * the questions in READING COMP topic that are not yet associated with
	 * a passage
	 *
	 * @return	{array}		q_arr 		return an array of questions
	 *										return NULL on failure
	 */
	function get_free_read_comp_questions() {
		$qarray=array();
		//Get all questions from reading comp section in question_bank table that are not already associated
		//with some passage in read_comp_passage_questions table
		//First get the section Id for REadng comp
		$sid=$this->get_section_id('READING_COMP');
		$q_table=TWELL_Q_BANK_TBL;
		$pq_table=TWELL_PASS_Q_TBL;
		if ($sid) {
			$query= "SELECT questionId,question FROM ". $q_table." qb
				WHERE NOT EXISTS (
				SELECT * 
				FROM ".$pq_table." pq
				WHERE qb.questionId = pq.questionId) AND qb.sectionId='$sid'";
			//$this->firephp->log($query);
			$qres=$this->db->query($query);
			
			//$this->firephp->log($qres->num_rows());
			if ($qres->num_rows() >0){
				$i=0;
				foreach ($qres->result() as $row) {
					$qarray[$i]=$row;
					//$this->firephp->log($qarray[$i]);
					$i++;
				}
			} //may want to return some message saying no free reading comp questions? -- Maya  Feb 1
		}else {
			//error in determining section id from name
			$this->firephp->log("error getting section id for get_free_read_comp_question(). Problem!");
			return NULL;
		}
		return $qarray;
	}
}
?>