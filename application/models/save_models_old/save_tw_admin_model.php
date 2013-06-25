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
		$id=$this->tw_auth_utils_model->get_current_user_id();
		$role=$this->tw_auth_utils_model->get_user_role($id);
		if($role=="Parent"){
			$user_data['group']="Parent";
			//Now look up family profile table for name, address etc
			$res=$this->get_family_info($user_data,$id);
		} else if ($role=="Student"){
			$user_data['group']="Student";
			$res=$this->get_student_info($user_data,$id);
		}
		//$this->firephp->log($user_data);
		return $res;//Success/fail status; $user_data is filled out
	}
	/**
	 * get_family_info()
	 * Retrieve changeable family information from family profile
	 * return filled out user_data array();
	**/
	function get_family_info(&$f_info,$uacc_id){
		//$this->firephp->log("In get_family_info");
		$is_pri=$this->tw_auth_utils_model->is_primary_parent($uacc_id);
		//$this->firephp->log("id ".$uacc_id);
		//$this->firephp->log("is_pri ".$is_pri);
		$res=$this->get_family_profile($is_pri,$uacc_id,$f_info);
		if ($res){
			//Look up the user_accounts table to get the email addresses
			//for the primary and alt (if any) parent ids
			if ($is_pri==1) {
				//User id is the primary parent
				$p_email=$this->tw_auth_utils_model->get_user_email_from_id($uacc_id);
				if ($p_email) {
					$f_info['pri_p_email']=$p_email;
				}else {
					$this->firephp->log("Unable to get primary parent email. Problem!");
					return FALSE;
				}
				$alt_id=$this->tw_auth_utils_model->get_alt_par_id($uacc_id);
				//$this->firephp->log("Alt id=".$alt_id);
				$f_info['alt_p_email']="";
				if ($alt_id>0){
					$p_email=$this->tw_auth_utils_model->get_user_email_from_id($alt_id);
					if ($p_email) {
						$f_info['alt_p_email']=$p_email;
					}else {
						$this->firephp->log("Unable to get alt parent email. Problem!");
						return FALSE;
					}
				}
				//$this->firephp->log($f_info);
				return TRUE;
			} else if ($is_pri==2) {
				//User id is the alt parent
				//$this->firephp->log("alt parent getting info");
				$pri_id=$this->tw_auth_utils_model->get_pri_par_id($uacc_id);
				//$this->firephp->log("Pri id= ".$pri_id);
				
				$p_email=$this->tw_auth_utils_model->get_user_email_from_id($pri_id);
				//$this->firephp->log("Pri email= ".$p_email);
				if ($p_email) {
					$f_info['pri_p_email']=$p_email;
				}else {
					$this->firephp->log("Unable to get primary parent email. Problem!");
					return FALSE;
				}
				$p_email=$this->tw_auth_utils_model->get_user_email_from_id($uacc_id);
				//$this->firephp->log("Alt email= ".$p_email);
				
				if ($p_email) {
					$f_info['alt_p_email']=$p_email;
				}else {
					$this->firephp->log("Unable to get alt parent email. Problem!");
					return FALSE;
				}
				//$this->firephp->log($f_info);
				return TRUE;
			}
		} else {
			$this->firephp->log("Unable to retrieve family info on record. Problem!");
			return FALSE;
		}	
	}
	
	/**
	 * get_student_info()
	 * Retrieve changeable student information from student profile
	 * return T/F; filled out user_data array();
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
			$s_email=$this->tw_auth_utils_model->get_user_email_from_id($uacc_id);
			if ($s_email){
				$s_info['s_email']=$s_email;
			} else {
				$this->firephp->log("Unable to retrieve student email. Problem!");
				return FALSE;
			}
			//$this->firephp->log($s_info);
			return TRUE;//Success! student data retrieved and populated
		} else {
			$this->firephp->log("Student information for this student not found. Problem!");
			return FALSE;
		}
	}
	/**
	 * update_account_info(&$f_info)
	 * Update changeable family information from submitted values
	 * parameters f_info array() to be filled out
	 * return  success/failure; f_info array() filled out;
	**/
	function update_account_info($user_type,&$f_info){
		//$this->firephp->log("In update_account_info ".$user_type);
		// Set & Run the validation.
		$this->set_update_form_validation($user_type);
		//$this->firephp->log("Validationresult= ".$this->form_validation->run());
		if ($this->form_validation->run()) {
			
			//Since validation is successful, update the tables
			$cur_id=$this->tw_auth_utils_model->get_current_user_id();
			$data=$this->get_update_form_input_data($user_type);
			
			if ($user_type=="Parent") {
				//find out if this id belongs to primary or alt parent
				$is_primary_par=$this->tw_auth_utils_model->is_primary_parent($cur_id);
				if ($is_primary_par==1){
					//Update family data
					$res=$this->update_family_profile('parentPrimary_uacc_id',$cur_id,$data);
					//$this->firephp->log("Update family profile result= ".$res);
					
					if (!$res) {
						//$this->firephp->log($this->db->_error_message());
						//$this->firephp->log($this->db->_error_number());
						$this->firephp->log("Issues during update of family profile  Problem!");
						return FALSE;
					}
					
					//Now update primary parent email if it has changed from what's on record
					//$this->firephp->log($this->input->post('update_pri_p_email'));
					$res=$this->update_pri_par_email($cur_id,);
	
					//If there is an alt parent email that can be updated it do it
					$alt_par_id=$this->tw_auth_utils_model->alt_par_exists($cur_id);
					if ($alt_par_id>0){
						$old_alt_p_email=$this->tw_auth_utils_model->get_user_email_from_id($alt_par_id);
						$eres=strcmp($old_alt_p_email,$this->input->post('update_alt_p_email'));
						//$this->firephp->log("REsult of old/new email alt comp= ".$eres);
						if ($eres !=0){
							$res=$this->update_email($alt_par_id,$this->input->post('update_alt_p_email'));
							if (!$res) {
								//$this->firephp->log($this->db->_error_message());
								//$this->firephp->log($this->db->_error_number());
								$this->firephp->log("Issues during update of alternate parent email  Problem!");
								return FALSE;
							}
						}
					}
					//$this->firephp->log("Returning success from update account");
					return TRUE;
				} else if ($is_primary_par==2) {
					//$cur_id belongs to alt parent
					//$this->firephp->log("alt parent");
					$res=$this->update_family_profile('parentAlt_uacc_id',$cur_id,$data);
					//$this->firephp->log("Update family profile result= ".$res);
					if (!$res) {
						//$this->firephp->log($this->db->_error_message());
						//$this->firephp->log($this->db->_error_number());
						$this->firephp->log("Issues during update of family profile  Problem!");
						return FALSE;
					}
					//Update alt parent email
					//$this->firephp->log($this->input->post('update_alt_p_email'));
					$old_alt_p_email=$this->tw_auth_utils_model->get_user_email_from_id($cur_id);
					$eres=strcmp($old_alt_p_email,$this->input->post('update_alt_p_email'));
					//$this->firephp->log("REsult of old/new email alt comp= ".$eres);
					
					if ($eres != 0) {
						$res=$this->update_email($cur_id,$this->input->post('update_alt_p_email'));
						if (!$res) {
							//$this->firephp->log($this->db->_error_message());
							//$this->firephp->log($this->db->_error_number());
							$this->firephp->log("Issues during update of alternate parent email  Problem!");
							return FALSE;
						}
					}
					//Update primary parent email if changed
					$pri_par_id=$this->tw_auth_utils_model->get_pri_par_id($cur_id);
					$old_pri_p_email=$this->tw_auth_utils_model->get_user_email_from_id($pri_par_id);
					$eres=strcmp($old_pri_p_email,$this->input->post('update_pri_p_email'));
					//$this->firephp->log("REsult of old/new email pri comp= ".$eres);
					if ($eres !=0) {
						$res=$this->update_email($pri_par_id,$this->input->post('update_pri_p_email'));
						if (!$res) {
							//$this->firephp->log($this->db->_error_message());
							//$this->firephp->log($this->db->_error_number());
							$this->firephp->log("Issues during update of primary parent email  Problem!");
							return FALSE;
						}
					}
					return TRUE;

				} else if ($is_primary_par==0) {
					$this->firephp->log("Unable to determine primary/alt parent; Problem!");
					return FALSE;
				} 
			} else if ($user_type=="Student") {
				//Update student data
				$res=$this->update_student_profile($cur_id,$data);
				if (!$res) {
					//$this->firephp->log($this->db->_error_message());
					//$this->firephp->log($this->db->_error_number());
					$this->firephp->log("Issues during update of student profile  Problem!");
					return FALSE;
				}
				//Now update student email
				//$this->firephp->log($this->input->post('update_s_email'));
				$res=$this->update_email($cur_id,$this->input->post('update_s_email'));
				if (!$res) {
					//$this->firephp->log($this->db->_error_message());
					//$this->firephp->log($this->db->_error_number());
					$this->firephp->log("Issues during update of student email  Problem!");
					return FALSE;
				}
				return TRUE;
			}
		}		
		// Set validation errors.
		//$this->firephp->log(validation_errors('<p class="error_msg">', '</p>'));
		$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
		return FALSE;	
	}

	/**
	 * update_pri_par_email($pri_par_id)
	 * Update primary parent email if it's changed from whats in the database
	**/
	function update_pri_par_email($pri_par_id){
		$old_pri_p_email=$this->tw_auth_utils_model->get_user_email_from_id($pri_par_id);
		$eres=strcmp($old_pri_p_email,$this->input->post('update_pri_p_email'));
		//$this->firephp->log("REsult of old/new email pri comp= ".$eres);
		if ($eres !=0) {
			$res=$this->update_email($pri_par_id,$this->input->post('update_pri_p_email'));
			if (!$res) {
				//$this->firephp->log($this->db->_error_message());
				//$this->firephp->log($this->db->_error_number());
				$this->firephp->log("Issues during update of primary parent email  Problem!");
				return FALSE;
			}
		}
		return TRUE;
	}
	/**
	* get_family_profile($which_parent,$id,&$fdata)
	* Utility function to retrieve family profile info based on the logged
	* in parent's internal user id and role
	* Return true/false; filled in fdata array()
	**/
	function get_family_profile($is_pri,$u_id,&$fdata){
		if($is_pri==1){
			$this->db->where("parentPrimary_uacc_id",$u_id);
		} else if ($is_pri==2){
			$this->db->where("parentAlt_uacc_id",$u_id);
		}
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		//$this->firephp->log($qres->num_rows());
		if ($qres->num_rows()==1) {
			$row=$qres->row_array();
			//$this->firephp->log($row);
			$fdata['p_f_name']=$row['parentFirstName'];
			$fdata['p_l_name']=$row['parentLastName'];
			$fdata['f_add_1']=$row['familyAddress1'];
			$fdata['f_add_2']=$row['familyAddress2'];
			$fdata['f_city']=$row['familyCity'];
			$fdata['f_state']=$row['familyState'];
			$fdata['f_zip']=$row['familyZip'];
			$fdata['f_phone']=$row['familyPhone'];
			return TRUE;
		} else {
			$this->firephp->log("Family profile for this parent not found. Problem!");
			return FALSE;
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
		//$this->firephp->log("Updating family profile");
		//$this->firephp->log($data);
		$res=$this->db->update(TWELL_FAM_PROF_TBL,$data);
		//$this->firephp->log("Res=".$res);
		return $res;
		
	}
	/**
	* update_student_profile($id,$data)
	* Utility function update student profile info b
	* Return true/false
	**/
	function update_student_profile($id,$data){
		//$this->firephp->log("Student profile update");
		$this->db->where('uacc_id',$id);
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
		//$this->firephp->log($edata);
		return ($this->flexi_auth->update_user($id, $edata));
	}

	/**
	* get_update_form_input_data($user_role)
	* Utility function extract the input field values depending
	* on role of user
	* Return array()
	**/
	function get_update_form_input_data($user_role) {
		if ($user_role=="Parent") {
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
		} else if ($user_role=="Student"){
			$data=array(
			'studentFirstName' => $this->input->post('update_s_f_name'),
			'studentLastName' => $this->input->post('update_s_l_name'),
			'grade' => $this->input->post('update_s_grade'),
			);
		}
		return $data;
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