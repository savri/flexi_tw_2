<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tw_auth_utils_model extends CI_Model {
	
	// The following method prevents an error occurring when $this->data is modified.
	// Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
	public function &__get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}
	/**
	 * login_user_type
	 * is the current user a parent or student or admin? 
	 * Look up user identifier in session data
	 * Looks up user_accounts table; Returns string - Parent, Student, Adm
	 */
	function login_user_type(){
		$fa=$this->session->userdata('flexi_auth');
		$email=$fa['user_identifier'];
		//$this->firephp->log("User type for:".$email);
		$this->db->select($this->flexi_auth->db_column('user_acc', 'group_id'));	
		$this->db->where($this->flexi_auth->db_column('user_acc', 'email'),$email);	
		$qres=$this->db->get('user_accounts');
		if ($qres->num_rows() > 0) {
			$row=$qres->row_array();
			//$this->firephp->log($row['uacc_group_fk']."for email=".$email);
			switch ($row['uacc_group_fk']) {
			    case 1:
			        return "Parent";
			    case 2:
			        return "Student";
			    case 3:
			        return "Admin";
				default:
					return NULL;
			}
		} else {
			$this->firephp->log("Could not determine user group for user");
			return NULL;
		}
	}
	/**
	 * get_user_email_from_id
	 * Returns email id of user with given uid from user_accounts table
	 */
	function get_user_email_from_id($uid)
	{
		//$this->firephp->log("In get_user_email_from_id");
		//$this->firephp->log("uid=".$uid);
		$this->db->select($this->flexi_auth->db_column('user_acc', 'email'));	
		$this->db->where($this->flexi_auth->db_column('user_acc', 'id'),$uid);	
		$qres=$this->db->get('user_accounts');
		if ($qres->num_rows() > 0) {
			$row=$qres->row_array();
			//$this->firephp->log($row['uacc_email']."for uid= ".$uid);
			return $row['uacc_email'];
		} else {
			$this->firephp->log("Could not determine user email from user id");
			return NULL;
		}
	}
	/**
	 * get_user_id_from_email
	 * Returns uid of user with given email from user_accounts table
	 */
	function get_user_id_from_email($email)
	{
		//$this->firephp->log("email=".$email);
		
		$this->db->select($this->flexi_auth->db_column('user_acc', 'id'));	
		$this->db->where($this->flexi_auth->db_column('user_acc', 'email'),$email);	
		$qres=$this->db->get('user_accounts');
		if ($qres->num_rows() > 0) {
			$row=$qres->row_array();
			$this->firephp->log($row['uacc_id']."for email=".$email);
			return $row['uacc_id'];
		} else {
			$this->firephp->log("Could not determine user id from user email");
			return NULL;
		}
	}
	/**
	 * get_current_user_id()
	 * Retrieve the internal user id for the current user
	 * return (int) user_id on success; 0 on failure
	**/
	function get_current_user_id(){
		$sd=$this->session->all_userdata();
		$fa=$sd['flexi_auth'];
		$this->firephp->log($fa);
		$this->firephp->log($fa['user_id']);
		//$this->firephp->log("Current user= ".intval($fa['user_id']));
		return $fa['user_id'];
	}
	/**
	* is_primary_parent($p_id)
	* Utility function to determine if this uid belongs to the primary or alt parent
	* Return 1 if primary; 2 if alt; 0 if error
	**/
	function is_primary_parent($p_id){
		//$this->firephp->log("Par id= ".$p_id);
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
		$this->db->where('parentAlt_uacc_id',$alt_id);
		$this->db->select('parentPrimary_uacc_id');
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		if ($qres->num_rows()==1) {
			$row=$qres->row();
			//$this->firephp->log("Pri id= ".$row->parentPrimary_uacc_id);
			return ($row->parentPrimary_uacc_id);
		}else{
			$this->firephp->log("Could not retrieve pri_parent user id");
			return 0;
		}
	}
	/**
	* alt_par_exists($pri_par_id)
	* Utility function to determine if an alt parent account has been set up
	* returns non-zero alt_par_id if account exists;0 if account does not exist
	**/
	function alt_par_exists($pri_par_id){
		//$this->firephp->log("In alt_par_exists check for ".$pri_par_id);
		if ($pri_par_id==0) {
			//This is coming over the wire and we need to decide what kind of
			//user admin menu to present
			$cur_id=$this->get_current_user_id();			
			$is_pri=$this->is_primary_parent($cur_id);
			//$this->firephp->log("Is pri=".$is_pri);
			if ($is_pri==1){
				$alt_par_id=$this->get_alt_par_id($cur_id);
			} else if ($is_pri==2) {
				//$this->firephp->log("Returning alt parent id=".$cur_id);
				$alt_par_id= $cur_id;
			} else if ($is_pri==0){
				$this->firephp->log("Unable to determine primary/alt parent");
				$alt_par_id= 0;
			}
		} else {
			$alt_par_id=$this->get_alt_par_id($pri_par_id);
		}
		return $alt_par_id;
	}
	/**
	* get_family_id($pri_id)
	* Utility function to retrieve family id given a parent id (presumably parent)
	* returns id on success; 0 on failure
	**/
	function get_family_id($par_id){
		$fam_id="";
		//$this->firephp->log("Par id= ".$par_id);
		$pp=$this->is_primary_parent($par_id);
		if ($pp==1){
			$this->db->where('parentPrimary_uacc_id',$par_id);
		}else if($pp==2){
			$this->db->where('parentAlt_uacc_id',$par_id);
		}
		$this->db->select('familyId');
		$qres=$this->db->get(TWELL_FAM_PROF_TBL);
		if ($qres->num_rows()==1) {
			$row=$qres->row();
			$this->firephp->log("Familyid=".$row->familyId);
			$fam_id=$row->familyId;
		}else{
			$this->firephp->log("Could not retrieve family id");
		}
		return $fam_id;
	}
	/**
	* get_children_data()
	* Utility function to retrieve details for all kids belonging to a family id
	* from the TWELL_STU_PROF_TBL
	* filled out $c_data array with status
	**/
	function get_children_data(){
		$cdata=array();
		$par_id=$this->get_current_user_id();
		$fam_id=$this->get_family_id($par_id);
		$status=$this->get_family_children($fam_id,$cdata);
		return $cdata;
	}	
	/**
	* get_family_children($fam_id, &$c_data)
	* Utility function to retrieve student details belonging to a family id
	* from the TWELL_STU_PROF_TBL
	* returns 1 on success; 0 on failure and filled out $c_data array
	**/
	function get_family_children($f_id,&$c_data){
		//$this->firephp->log("Family id = ".$f_id);
		$this->db->where('familyId',$f_id);
		$qres=$this->db->get(TWELL_STU_PROF_TBL);
		if ($qres->num_rows()>0) {
			$i=0;
			foreach ($qres->result() as $row) {
				$c_data[$i]['id']=$row->uacc_id;
				$c_data[$i]['f_name']=$row->studentFirstName;
				$c_data[$i]['l_name']=$row->studentLastName;
				$c_data[$i]['grade']=$row->grade;
				$c_data[$i]['ttype']=$row->testType;
				$c_data[$i]['email']=$this->get_user_email_from_id($row->uacc_id);
				//$this->firephp->log($c_data[$i]);
				$i++;
			}
			return TRUE;
		}else{
			$this->firephp->log("Could not retrieve family id");
			return FALSE;
		}
	}
}