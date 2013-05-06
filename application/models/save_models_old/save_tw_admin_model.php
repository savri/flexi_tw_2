<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tw_admin_model extends CI_Model {
	// The following method prevents an error occurring when $this->data is modified.
	// Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
	public function &__get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Get user account related info
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	/**
	 * get_user_account_info()
	 * Retrieve basic user information from user accounts
	 * Depending on their role. get more info from family_profile
	**/
	function get_user_account_info(&$user_data){
		$id=$this->get_current_user_id();
		$role=$this->get_user_role($id);
		//$this->firephp->log("User role for:".$id." is ".$role);
		/**$this->db->select($this->flexi_auth->db_column('user_acc', 'group_id'));	
		$this->db->where($this->flexi_auth->db_column('user_acc', 'id'),$id);	
		$qres=$this->db->get($this->auth->tbl_user_account);
		if ($qres->num_rows() > 0) {
			$row=$qres->row_array();
			//$this->firephp->log($row['uacc_group_fk']."for email=".$email);
			switch ($row['uacc_group_fk']) {
				case (1):
					{
						$user_data['group']="Parent";
						$xx=1;
						//Now look up family profile table for name, address etc
						$res=$this->get_family_info($user_data,$id);
						//$this->firephp->log("Family info status".$res);
						//$this->firephp->log($user_data);
					}
			        break;
				case (2):
					{
						$user_data['group']="Student";
						$res=$this->get_student_info($user_data,$id);
					}
			        break;
			    case (3):
					{
						$user_data['group']="Admin";
					}
			        break;
				default:
					{
						$user_data['group']=NULL;
						$this->firephp->log("Unknown group for this user. Problem!");
					}
			}**/
			if($role=="Parent"){
				$user_data['group']="Parent";
				//Now look up family profile table for name, address etc
				$res=$this->get_family_info($user_data,$id);
			} else if ($role=="Student"){
				$user_data['group']="Student";
				$res=$this->get_student_info($user_data,$id);
			}
			$this->firephp->log($user_data);
			return $res;//Success/fail status; $user_data is filled out
		/**} else {
				$this->firephp->log("Could not determine user group for user");
				return NULL;
		}**/
	}
	/**
	 * get_current_user_id()
	 * Retrieve the internal user id for the current user
	 * return (int) user_id on success; 0 on failure
	**/
	function get_current_user_id(){
		$sd=$this->session->all_userdata();
		$fa=$sd['flexi_auth'];
		$email=$fa['user_identifier'];
		return $fa['user_id'];
	}
	/**
	 * get_family_info()
	 * Retrieve changeable family information from family profile
	 * return filled out user_data array();
	**/
	function get_family_info(&$f_info,$uacc_id){
		$this->db->where("parentPrimary_uacc_id",$uacc_id);
		$this->db->or_where("parentAlt_uacc_id",$uacc_id);
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		//$this->firephp->log($qres->num_rows());
		if ($qres->num_rows()==1) {
			$row=$qres->row_array();
			//$this->firephp->log($row);
			$f_info['p_f_name']=$row['parentFirstName'];
			$f_info['p_l_name']=$row['parentLastName'];
			$f_info['f_add_1']=$row['familyAddress1'];
			$f_info['f_add_2']=$row['familyAddress2'];
			$f_info['f_city']=$row['familyCity'];
			$f_info['f_state']=$row['familyState'];
			$f_info['f_zip']=$row['familyZip'];
			$f_info['f_phone']=$row['familyPhone'];
			//Look up the user_accounts table to get the email addresses
			//for the primary and alt (if any) parent ids
			$xx=$this->tw_auth_model->get_user_email_from_id($row['parentPrimary_uacc_id']);
			if ($xx){
				$f_info['pri_p_email']=$xx;
			} else {
				$this->firephp->log("Unable to get primary parent email. Problem!");
				return NULL;
			}
			//Check to see if there is an alt address listed
			if ($row['parentAlt_uacc_id']!=0){
				$xx=$this->tw_auth_model->get_user_email_from_id($row['parentAlt_uacc_id']);
				if ($xx){
					$f_info['alt_p_email']=$xx;
				}else {
					$this->firephp->log("Unable to get alternate parent email. Problem!");
					return NULL;
				}
			} else {
				$f_info['alt_p_email']="";
			}
			return 1;//Success! familiy data retrieved and populated
		} else {
			$this->firephp->log("Family information for this parent not found. Problem!");
			return NULL;
		}	
	}
	/**
	 * get_student_info()
	 * Retrieve changeable student information from student profile
	 * return filled out user_data array();
	**/
	function get_student_info(&$s_info,$uacc_id){
		$this->db->where("uacc_id",$uacc_id);
		$qres=$this->db->get(TWELL_STU_PROF_TBL);
		//$this->firephp->log($qres->num_rows());
		if ($qres->num_rows()==1) {
			$row=$qres->row_array();
			//$this->firephp->log($row);
			$s_info['s_f_name']=$row['studentFirstName'];
			$s_info['s_l_name']=$row['studentLastName'];
			$s_info['grade']=$row['grade'];
			//Look up the user_accounts table to get the email address 
			$xx=$this->tw_auth_model->get_user_email_from_id($uacc_id);
			if ($xx){
				$s_info['s_email']=$xx;
			} else {
				$this->firephp->log("Unable to retrieve student email. Problem!");
				return NULL;
			}
			$this->firephp->log($s_info);
			return 1;//Success! student data retrieved and populated
		} else {
			$this->firephp->log("Student information for this student not found. Problem!");
			return NULL;
		}
	}
	/**
	 * update_account_info(&$f_info)
	 * Update changeable family information from submitted values
	 * parameters f_info array() to be filled out
	 * return  success/failure; f_info array() filled out;
	**/
	function update_account_info($user_type,&$f_info){
		//$this->firephp->log("In update_account_info".$user_type);

		// Set & Run the validation.
		$this->set_update_form_validation($user_type);
		//$this->firephp->log("Validationresult= ".$this->form_validation->run());
		if ($this->form_validation->run()) {
			//Since validation is successful, update the tables
			//$this->firephp->log("Validation success");
			$cur_id=$this->get_current_user_id();
			if ($user_type=="Parent") {
				$data=array(
					'parentFirstName' => $this->input->post('update_p_f_name'),
					'parentLastName' => $this->input->post('update_p_l_name'),
					'familyAddress1' => $this->input->post('update_add_line_1'),
					'familyAddress2' => $this->input->post('update_add_line_2'),
                    'familyCity' => $this->input->post('update_city'),
					'familyState' => $this->input->post('update_state'),
					'familyZip' => $this->input->post('update_zip'),
					'familyPhone' => $this->input->post('update_ph_number'),
					);
				//find out if this id belongs to primary or alt parent
				$is_primary_par=$this->is_primary_parent($cur_id);
				if ($is_primary_par==1){
					$this->firephp->log("Primary parent");
					//Update family data
					$res=$this->update_family_profile('parentPrimary_uacc_id',$cur_id,$data);
					if (!$res) {
						$this->firephp->log($this->db->_error_message());
						$this->firephp->log($this->db->_error_number());
						$this->firephp->log("Issues during update of family profile  Problem!");
						return FALSE;
					}
					//Now update primary parent email
					$this->firephp->log($this->input->post('update_pri_p_email'));
					$res=$this->update_email($cur_id,$this->input->post('update_pri_p_email'));
					if (!$res) {
						$this->firephp->log($this->db->_error_message());
						$this->firephp->log($this->db->_error_number());
						$this->firephp->log("Issues during update of primary parent email  Problem!");
						return FALSE;
					}
					//If there is an alt parent email that can be updated it do it
					if ($this->input->post('update_alt_p_email')!=""){
						$alt_par_id=$this->get_alt_parent_id($cur_id);
						$res=$this->update_email($alt_par_id,$this->input->post('update_alt_p_email'));
						if (!$res) {
							$this->firephp->log($this->db->_error_message());
							$this->firephp->log($this->db->_error_number());
							$this->firephp->log("Issues during update of alternate parent email  Problem!");
							return FALSE;
						}
						return TRUE;
					}
				} else if ($is_primary_par==2) {
					$this->firephp->log("alt parent");

				} else if ($is_primary_par==0) {
					$this->firephp->log("Unable to determine primary/alt parent; Problem!");
					return FALSE;
				} 
			} else if ($user_type=="Student") {
				$data=array(
					'studentFirstName' => $this->input->post('update_s_f_name'),
					'studentLastName' => $this->input->post('update_s_l_name'),
					'grade' => $this->input->post('update_s_grade'),
					);
				//Update student data
				$res=$this->update_student_profile($cur_id,$data);
				if (!$res) {
					$this->firephp->log($this->db->_error_message());
					$this->firephp->log($this->db->_error_number());
					$this->firephp->log("Issues during update of student profile  Problem!");
					return FALSE;
				}
				//Now update student email
				$this->firephp->log($this->input->post('update_s_email'));
				$res=$this->update_email($cur_id,$this->input->post('update_s_email'));
				if (!$res) {
					$this->firephp->log($this->db->_error_message());
					$this->firephp->log($this->db->_error_number());
					$this->firephp->log("Issues during update of student email  Problem!");
					return FALSE;
				}
				return TRUE;
			}
		}		
		// Set validation errors.
		$this->firephp->log(validation_errors('<p class="error_msg">', '</p>'));
		$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
		return FALSE;	
	}
	/**
	* is_primary_parent($p_id)
	* Utility function to determine if this uid belongs to the primary or alt parent
	* Return 1 if primary; 2 if alt; 0 if error
	**/
	function is_primary_parent($p_id){
		$this->db->where('parentPrimary_uacc_id',$p_id);
		$this->db->or_where('parentAlt_uacc_id',$p_id);
		$this->db->select('parentPrimary_uacc_id');
		$res=$this->db->get(TWELL_FAM_PROF_TBL);
		if ($res->num_rows()==1) {
			$fam_profile=$res->row();
			If (intval($fam_profile->parentPrimary_uacc_id)==intval($p_id)) {
				$this->firephp->log("Primary parent!");
				return 1;
			} else {
				$this->firephp->log("Alt parent!");
				return 2;
			}
		} else {
			$this->firephp->log("Not able to determine primary/alt parent status for uid".$p_id);
			return 0;
		}
	}
	/**
	* get_user_role($id)
	* Utility function to determine if user is parent or student
	* or admin
	* Return "Parent"/"Student"/Admin on success; NULL on fail
	**/
	function get_user_role($u_id){
		$this->db->select($this->flexi_auth->db_column('user_acc', 'group_id'));	
		$this->db->where($this->flexi_auth->db_column('user_acc', 'id'),$u_id);	
		$qres=$this->db->get($this->auth->tbl_user_account);
		if ($qres->num_rows() > 0) {
			$row=$qres->row_array();
			//$this->firephp->log($row['uacc_group_fk']."for email=".$email);
			switch ($row['uacc_group_fk']){
				case (1):
					return "Parent";
				case (2):
					return "Student";
				case (3):
					return "Admin";
				default:
					return NULL;
			}
		}
	}
	/**
	* update_family_profile($which_parent,$id,$data)
	* Utility function update family profile info based on the logged
	* in parent's internal user id
	* Return true/false
	**/
	function update_family_profile($which_parent,$id,$data){
		$this->db->where($which_parent,$id);
		$this->firephp->log($data);
		return ($this->db->update(TWELL_FAM_PROF_TBL,$data));
	}
	/**
	* update_student_profile($id,$data)
	* Utility function update student profile info b
	* Return true/false
	**/
	function update_student_profile($id,$data){
		$this->firephp->log("Student profile update");
		$this->firephp->log($id);
		$this->firephp->log($data);
		$this->db->where('uacc_id',$id);
		$this->firephp->log($data);
		return ($this->db->update(TWELL_STU_PROF_TBL,$data));
	}
	/**
	* update_email($id,$email)
	* Utility function update email address of user
	* Return true/false
	**/
	function update_email($id,$email){
		//Figgure out a way to check if it's same as what's in the database later.
		//Also send out email - but to whom?
		$edata=array(
			$this->flexi_auth->db_column('user_acc', 'email')=>$email,
			);
		$this->firephp->log($edata);
		return ($this->flexi_auth->update_user($id, $edata));
	}
	/**
	* get_alt_par_id($pri_id)
	* Utility function to return user id of alt_parent based on
	* on user_id of pri_parent
	* returns (int) alt_par_id on success and 0 on fail
	**/
	function get_alt_par_id($pri_id){
		$this->db->where('parentPrimary_uacc_id',$pri_id);
		$this->db->select('parentAlt_uacc_id',$pri_id);
		
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		if ($qres->num_rows()==1) {
			$row=$qres->row();
			return ($row->parentAlt_uacc_id);
		}else{
			$this->firephp->log("Could not retrieve alt_parent user id");
			return 0;
		}
	}
	/**
	* get_pri_par_id($alt_id)
	* Utility function to return user id of pri_parent based on
	* on user_id of alt_parent
	* returns (int) pri_par_id on success and 0 on fail
	**/
	function get_pri_par_id($alt_id){
		$this->db->where('parentAlt_uacc_id',$pri_id);
		$this->db->select('parentPrimary_uacc_id',$pri_id);
		
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		if ($qres->num_rows()==1) {
			$row=$qres->row();
			return ($row->parentPrimary_uacc_id);
		}else{
			$this->firephp->log("Could not retrieve pri_parent user id");
			return 0;
		}
	}
	/**
	* alt_par_exists()
	* Utility function to determine if an alt parent account has been set up
	* returns 1 if account exists;0 if account does not exist
	**/
	function alt_par_exists(){
		$cur_id=$this->get_current_user_id();
		$pri_par=$this->is_primary_parent($cur_id);
		if ($pri_par){
			$alt_par_id=$this->get_alt_par_id($cur_id);
			if ($alt_par_id==0)
				return 0;
			else
				return 1;
		} else {
			return 1;
		}
		
	}
	/**
	* set_update_form_validation()
	* Utility function to set up the validation
	* rules for the update form
	* returns void
	**/
	function set_update_form_validation($u_type){
		if ($u_type=="Parent") {
			//Think a bit about the rule for email - don't we need identity_available?
			// Set validation rules. and check to see if all fields were filled in right
			// The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
			$validation_rules = array(
				array('field' => 'update_p_f_name', 'label' => 'First Name', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_p_l_name', 'label' => 'Last Name', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_add_line_1', 'label' => 'Address Line 1', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_add_line_2', 'label' => 'Address Line 2', 'rules' => 'trim|xss_clean'),
				array('field' => 'update_city', 'label' => 'City', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_state', 'label' => 'State', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_zip', 'label' => 'Zip', 'rules' => 'numeric|required'),
				array('field' => 'update_ph_number', 'label' => 'Phone Number', 'rules' => 'numeric|required'),
				array('field' => 'update_pri_p_email', 'label' => 'Primary Parent Email ', 'rules' => 'required|valid_email'),
				array('field' => 'update_alt_p_email', 'label' => 'Alternate Parent Email', 'rules' => 'valid_email'),
			);
		} else if ($u_type=="Student"){
			$validation_rules = array(
				array('field' => 'update_s_f_name', 'label' => 'First Name', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_s_l_name', 'label' => 'Last Name', 'rules' => 'trim|required|xss_clean'),
				array('field' => 'update_s_email', 'label' => 'Student Email', 'rules' => 'required|valid_email'),
				array('field' => 'update_s_grade', 'label' => 'Grade', 'rules' => 'numeric|required'),
			);
		}
		$this->form_validation->set_rules($validation_rules);
	}
	
}
/* End of file tw_admin_model.php */
/* Location: ./application/models/testwell/tw_admin_model.php */