<?php
/**
 * Model that deals with launching into three main parts 
 * of the portal - presenting tests to user,
 * presenting results of current and past tests
 * and analysis of the past test performances
 */

/**
 * For this user, find out all the tests
 * they have completed, partially completed
 * or offer to present a new test. Upon success return 
 * array with the test details; on failire, return NULL
 * @return array (of tests)
 */
class Testwell_portal_model extends CI_Model {
	function get_tests_for_student(){
		$data=array();
		$test_list=array();
		$test=array();
		
		$in_table=TWELL_TEST_TAKE_TBL;
		$user_id=$this->tw_auth_utils_model->get_current_user_id();
		
		//First get unique testIds for this user
		$this->db->select('testId,startTimeDate,finishTimeDate,timedTest');
		$this->db->group_by('testId');
		$query = $this->db->get_where($in_table,array('internalAccountId'=>$user_id));
		$num_rows=$this->db->affected_rows();
		//$this->firephp->log("num_rows=$num_rows");
		if ($num_rows >= 0) {
			foreach ($query->result() as $row) {
				//For each testId they have taken, get the other details
				$test['test_type']=$this->testwell_utils_model->get_test_type($row->testId);
				$test['testId']=$row->testId;
				$test['timedTest']=$row->timedTest;
				$test['start']=$row->startTimeDate;
				//If they are midway, then finish time will be 0
				if ($row->finishTimeDate=='0000-00-00 00:00:00'){
					//$this->firephp->log($row->finishTimeDate);
					$test['finish']=0;
				}else {
					$test['finish']=1;
				}
				$test_list[$row->testId]=$test;	
			}	
			$data['num_tests']=$num_rows;
			$data['test_list']=$test_list;
		} else {
			$this->firephp->log("Should not be here");
			$tests['num_tests']=-1;//return NULL? Check this. Maya Jan 13
		}
		//$this->firephp->log($tests['num_tests']);
		return $data;
	}
}