<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tw_auth_model extends CI_Model {
	
	// The following method prevents an error occurring when $this->data is modified.
	// Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
	public function &__get($key)
	{
		$CI =& get_instance();
		return $CI->$key;
	}

	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Login
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * login
	 * Validate the submitted login details and attempt to log the user into their account.
	 */
	function login()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$this->form_validation->set_rules('login_identity', 'Identity (Email / Login)', 'required');
		$this->form_validation->set_rules('login_password', 'Password', 'required');

		// If failed login attempts from users IP exceeds limit defined by config file, validate captcha.
		if ($this->flexi_auth->ip_login_attempts_exceeded())
		{
			/**
			 * reCAPTCHA
			 * http://www.google.com/recaptcha
			 * To activate reCAPTCHA, ensure the 'recaptcha_response_field' validation below is uncommented and then comment out the 'login_captcha' validation further below.
			 *
			 * The custom validation rule 'validate_recaptcha' can be found in '../libaries/MY_Form_validation.php'.
			 * The form field name used by 'reCAPTCHA' is 'recaptcha_response_field', this field name IS NOT editable.
			 * 
			 * Note: To use this example, you will also need to enable the recaptcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
			*/
			$this->form_validation->set_rules('recaptcha_response_field', 'Captcha Answer', 'required|validate_recaptcha');				
			
			/**
			 * flexi auths math CAPTCHA
			 * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
			 * To activate Math CAPTCHA, ensure the 'login_captcha' validation below is uncommented and then comment out the 'recaptcha_response_field' validation above.
			 * 
			 * The field value submitted as the answer to the math captcha must be submitted to the 'validate_math_captcha' validation function.
			 * The custom validation rule 'validate_math_captcha' can be found in '../libaries/MY_Form_validation.php'.
			 * 
			 * Note: To use this example, you will also need to enable the math_captcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
			*/
			# $this->form_validation->set_rules('login_captcha', 'Captcha Answer', 'required|validate_math_captcha['.$this->input->post('login_captcha').']');				
		}
		
		// Run the validation.
		if ($this->form_validation->run())
		{
			// Check if user wants the 'Remember me' feature enabled.
			$remember_user = ($this->input->post('remember_me') == 1);
	
			// Verify login data.
			$this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);

			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

			// Reload page, if login was successful, sessions will have been created that will then further redirect verified users.
			redirect('auth');
		}
		else
		{	
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}

	/**
	 * login_via_ajax
	 * Attempt to log a user in via ajax.
	 * This example is a much more simplified version of the above 'login' function example as it just returns a boolean value of
	 * whether or not the submitted details successfully logged a user in - no redirects or status messages are set.
	 */
	function login_via_ajax()
	{
		$remember_user = ($this->input->post('remember_me') == 1);

		// Verify login data.
		return $this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);
	}

	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Account Registration
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	/**
	* register_family
	* Create a new family account and individual user accounts for parent(s) and student
	**/
	function register_family(){
		
		//$this->load->library('form_validation');
		$this->tw_auth_model->set_register_form_validation();
		// Run the validation.
		if ($this->form_validation->run())
		{
			//$this->firephp->log("Validation ok!");
			//First create primary parent account
			$pri_par_id=$this->create_primary_parent_account($this->input->post('register_pri_p_email'));
			if ($pri_par_id ==0) {
				//creation of primary parent id failed
				$this->firephp->log("creation of primary parent account
				 					failed during registration. Problem!");
				return FALSE;
			}
			//Now that primary parent has an account, create family profile in family_profile table
			$fam_id=$this->create_family_profile();
			if ($fam_id==0){
				$this->firephp->log("Creation of family profile 
										failed during registration. Problem!");
				return FALSE;
			}
			//See if there is an alt parent to add
			$res=$this->create_alt_parent_account($this->input->post('register_alt_p_email'),$fam_id);
			if (!$res){
				$this->firephp->log("Creation of alt parent account 
										failed during registration. Problem!");
				return FALSE;
			}
			$res=$this->create_student_account($this->input->post('register_s_email'),$fam_id);
			if ($res){
				// Redirect user to login page if they have to accept activation
				//redirect('auth');				
				$this->firephp->log("Redirecting back to login page waiting for activation");
				$this->firephp->log("Hooooooray! we made it");
				return TRUE;	
			} else {
				//creation of student id failed
				$this->firephp->log("creation of student account
								failed during registration. Problem!");
				return FALSE;
			}
		}
		// Set validation errors.
		$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
		return FALSE;
	}
	/**
	 * register_account
	 * Create a new user account. 
	 * Then if defined via the '$instant_activate' var, automatically log the user into their account.
	 * returns user_id of the account registered
	 */
	function register_account($email,$password,$group_id)
	{
		//We are not using username only email adderss
		$username="";
		$profile_data="";
		// Set whether to instantly activate account.
		// This var will be used twice, once for registration, then to check if to log 
		// the user in after registration.
		$instant_activate = FALSE;

		// The last 2 variables on the register function are optional, these variables allow you to:
		// #1. Specify the group ID for the user to be added to (i.e. 'Parent' / 'Student'), 
		// the default is set via the config file.
		// #2. Set whether to automatically activate the account upon registration, default is FALSE. 
		// Note: An account activation email will be automatically sent if auto activate is FALSE, 
		// or if an activation time limit is set by the config file.
		$response = $this->flexi_auth->insert_user($email, $username, $password, $profile_data, $group_id, $instant_activate);
		if ($response)
		{
			// This is an example 'Welcome' email that could be sent to a new user upon registration.
			// Bear in mind, if registration has been set to require the user activates their account, they will already be receiving an activation email.
			// Therefore sending an additional email welcoming the user may be deemed unnecessary.
			//$email_data = array('identity' => $email);
			//$this->flexi_auth->send_email($email, 'Welcome', 'registration_welcome.tpl.php', $email_data);
			// Note: The 'registration_welcome.tpl.php' template file is located in the '../views/includes/email/' directory defined by the config file.
			
			###+++++++++++++++++###
			
			// Save any public status or error messages (Whilst suppressing any admin messages) 
			// to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			$this->firephp->log("Response=".$response);
			return $response; //this is the newly created user id
		} else {
			$this->firephp->log("Unable to create account for ".$email."Problem!");
			return 0;
		}
	}
	/**
	 * register_alt_parent
	 * Create a new user account for alt_parent if they are added on after initial registration 
	 * returns user_id of the account registered
	 */
	function register_alt_parent(){
		
		//Validate input first
		$validation_rules = array(
			array('field' => 'reg_alt_p_email', 
					'label' => 'Alternate Parent Email', 'rules' => 'required|valid_email|email_available'),
		);
		$this->form_validation->set_rules($validation_rules);
		if ($this->form_validation->run())
		{
			//$this->firephp->log("validation ok!");
			//First get current user id (presumably of primary parent who is the only
			//one who can add an alt_parent account
			$pri_par_id=$this->tw_auth_utils_model->get_current_user_id();
			if ($pri_par_id==0){
				$this->firephp->log("Unable to determine primary parent id; 
							registration of alt parent account failed.Problem! ");
				return FALSE;
			}
			//Get the family id
			$fam_id=$this->tw_auth_utils_model->get_family_id($pri_par_id);
			if (strlen($fam_id)==0){
				$this->firephp->log("Unable to determine family id; 
							registration of alt parent account failed.Problem! ");
				return FALSE;
			}
			//Create alt_par account
			$this->firephp->log($this->input->post('reg_alt_p_email'));
			$res=$this->create_alt_parent_account($this->input->post('reg_alt_p_email'),$fam_id);
			return $res;
		}
		// Set validation errors.
		$this->firephp->log("Validation failed");
		$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
		return FALSE;

	}
	/**
	* register_child()
	* Add a child to the family account; and set up their account too
	* when added after initial registration
	* Return true/false upon successfully adding student
	**/
	function register_child(){
		//Validate input first
		$this->firephp->log($this->input->post('register_s_grade'));
		$validation_rules = array(
			array('field' => 'register_s_f_name','label' => 'First Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_s_l_name','label' => 'Last Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_s_email', 'label' => 'Student Email', 'rules' => 'required|valid_email|identity_available'),
			array('field' => 'register_s_grade', 'label' => 'Grade', 'rules' => 'numeric|required'),	
			array('field' => 'register_s_ttype', 'label' => 'Test Type', 'rules' => 'required'),					
			);

		$this->form_validation->set_rules($validation_rules);
		if ($this->form_validation->run())
		{
			$this->firephp->log("Validation passed");
			$par_id=$this->tw_auth_utils_model->get_current_user_id();
			//$this->firephp->log("parent id=".$par_id);
			$fam_id=$this->tw_auth_utils_model->get_family_id($par_id);
			//$this->firephp->log("Family Id=".$fam_id);
			$res=$this->create_student_account($this->input->post('register_s_email'),$fam_id);
			return $res;//True/False
		}
		// Set validation errors.
		$this->firephp->log("Validation failed");
		$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
		return FALSE;
	}
	
	/**
	 * create_family_profile
	 * Create a entry in family_profile table. 
	 * returns family_id of the family registered
	 */
	function create_family_profile(){
		$family_id=$this->uuid->v4();
		$family_profile=array(
			'familyId'=>$family_id,
			'parentFirstName' => $this->input->post('register_p_f_name'),
			'parentLastName' => $this->input->post('register_p_l_name'),
			'familyAddress1' => $this->input->post('register_add_line_1'),
			'familyAddress2' => $this->input->post('register_add_line_2'),
			'familyCity' => $this->input->post('register_city'),
			'familyState' => $this->input->post('register_state'),
			'familyZip' => $this->input->post('register_zip'),
			'familyPhone' => $this->input->post('register_ph_number'),
			'parentPrimary_uacc_id' => $pri_par_id,
			'parentAlt_uacc_id'=>0
		);
		//$this->firephp->log($family_profile);
		
		if ($this->db->insert(TWELL_FAM_PROF_TBL,$prof_data)) {
			//$this->firephp->log("returning true from create_fam_profile");
			return $family_id;
		} else {
			$this->firephp->log("Issues during creation of
			 					family profile during registration. Problem!");
			return 0;
		}
	}
	/**
	 * create_primary_parent_account
	 * Create an account for primary parent. 
	 * returns id of primary_parent account; 0 on failure
	 */
	function create_primary_parent_account($email){
		//By default, pw is same as email;group_id=1=parent
		$pri_par_id=$this->register_account($email,$email,1);
		$this->firephp->log("Parent userid= ".$pri_par_id);
		return $pri_par_id;
	}
	/**
	 * create_alt_parent_account
	 * Create an account for alt parent (if specified)
	 * returns TRUE/FALSE;
	 */
	function create_alt_parent_account($email,$family_id){
		//Check to see if parentAltEmail was supplied; if so create that user		
		//$this->firephp->log("Alt email exists:".isset($email));
		if ((isset($email)) && trim($email)!='') {
			$alt_par_id=$this->register_account($email,$email,1); //1-->Parent role in user_groups
			$this->firephp->log("Alt Id=".$alt_par_id);
			if ($alt_par_id) {
				//Add alt_par_id to family_id account
				$family_profile=array(
					'parentAlt_uacc_id'=>$alt_par_id
				);
				$res=$this->add_alt_to_family_profile($family_id,$family_profile);
				//$this->firephp->log("Alt id addition= ".$res);
				if(!$res) {
					$this->firephp->log("addition of alternate parent id 
									to family profile failed during registration. Problem!");
					return FALSE;
				}else {
					//Success!
					return TRUE;
				}
			} else {
				//creation of alt parent id failed
				$this->firephp->log("creation of alternate parent id 
										failed during registration. Problem!");
				return FALSE;
			}
		}else {
			//Nothing to do - no alt_par email specified
			return TRUE;
		}
	}
	/**
	 * create_student_account
	 * Create an account for alt parent (if specified) &
	 * add to student_profile table w/ correct family id
	 * returns TRUE/FALSE;
	 */
	function create_student_account($email,$family_id){
		//Now create user account for student
		$this->firephp->log("Student email= ".$email);
		$stu_id=$this->register_account($email,$email,2);//2-->Student role in user_groups
		$this->firephp->log("Student id= ".$stu_id);
		
		if ($stu_id !=0) {
			//Add student's id into student_profile table associcated with family_id
			$student_profile=array(
				'uacc_id'=>$stu_id,
				'familyId'=>$family_id,
				'studentFirstName'=>$this->input->post('register_s_f_name'),
				'studentLastName'=>$this->input->post('register_s_l_name'),
				'grade'=>$this->input->post('register_s_grade'),
				'testType'=>$this->input->post('register_s_ttype'),
			);
			$res=$this->create_student_profile($student_profile);
			$this->firephp->log("Creation stu profile= ".$res);
			return $res;
		}else {
			$this->firephp->log("creation of student id 
							failed during registration. Problem!");
			return FALSE;
		}
	}
	/**
	 * add_alt_to_family_profile
	 * Updates entry in family_profile table matching fam_id w/ altParent email id 
	 * returns TRUE on success
	 */
	function add_alt_to_family_profile($fam_id,$prof_data){
		//$this->firephp->log("In add_alt_family_profile".$fam_id);
		
		$this->db->where('familyId',$fam_id);
		$this->db->update(TWELL_FAM_PROF_TBL,$prof_data);
		if ($this->db->affected_rows() > 0) {
			$this->firephp->log("Returning true from add_alt_family_profile");
			return TRUE;

		} else {
			$this->firephp->log("Unable to add alt id 
								into family profile. Problem!");
			return FALSE;
		}
		
	}
	/**
	 * create_student_profile
	 * adds new entry with thsi student's particulars in student_profile table w/ supplied family_id
	 * returns TRUE on success
	 */
	function create_student_profile($prof_data){
		if($this->db->insert(TWELL_STU_PROF_TBL,$prof_data)) {
			return TRUE;
		} else {
			$this->firephp->log("Error in creation of 
									student profile during registration. Problem!");
			return FALSE;
		}
	}
	/**
	* set_register_form_validation()
	* Setup the rules for validating registration form.
	**/
	function set_register_form_validation(){
		// Set validation rules.
		// The custom rules 'identity_available' and 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'register_p_f_name', 'label' => 'First Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_p_l_name', 'label' => 'Last Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_add_line_1', 'label' => 'Address Line 1', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_add_line_2', 'label' => 'Address Line 2', 'rules' => 'trim|xss_clean'),
			array('field' => 'register_city', 'label' => 'City', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_state', 'label' => 'State', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_zip', 'label' => 'Zip', 'rules' => 'numeric|required'),
			array('field' => 'register_ph_number', 'label' => 'Phone Number', 'rules' => 'numeric|required'),
			array('field' => 'register_pri_p_email', 'label' => 'Primary Parent Email ', 'rules' => 'required|valid_email|identity_available'),
			array('field' => 'register_alt_p_email', 'label' => 'Alternate Parent Email', 'rules' => 'valid_email|identity_available'),
			array('field' => 'register_s_f_name', 'label' => 'First Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_s_l_name', 'label' => 'Last Name', 'rules' => 'trim|required|xss_clean'),
			array('field' => 'register_s_email', 'label' => 'Student Email', 'rules' => 'required|valid_email|identity_available'),
			array('field' => 'register_s_grade', 'label' => 'Grade', 'rules' => 'numeric|required'),
			array('field' => 'register_s_ttype', 'label' => 'Test Type', 'rules' => 'required'),
		);
		$this->form_validation->set_rules($validation_rules);
	}
	/**
	* Utility function to fetch the family id given parent user id
	*
	**/
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Account Activation
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * User to reset their default password before account is activated for real
	*/
	function activate_password() {
		
		$this->load->library('form_validation');
		$this->firephp->log($this->input->post('current_password'));
		$this->firephp->log($this->input->post('new_password'));
		$this->firephp->log($this->input->post('confirm_new_password'));
		
		
		// Set validation rules.
		// The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'current_password', 'label' => 'Your Default Password', 'rules' => 'required'),
			array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
			array('field' => 'confirm_new_password', 'label' => 'Confirm New Password', 'rules' => 'required')
		);
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			// Get password data from input.
			$user_id=$this->input->post('act_user');
			$identity = $this->get_user_email_from_id($user_id);
			$this->firephp->log("user_id=".$user_id.";identity=".$identity);
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');		
				
			// Note: Changing a password will delete all 'Remember me' database sessions for the user, except their current session.
			$response = $this->flexi_auth->change_password($identity, $current_password, $new_password);
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			if ($response){
				return TRUE;
				
			} else {
				$this->data['message']=$this->flexi_auth->get_messages();
				return FALSE;
			}
			// Redirect user.
			// Note: As an added layer of security, you may wish to email the user that their password has been updated.
		//	($response) ? redirect('auth_public/dashboard') : redirect('auth_public/change_password');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			return FALSE;
		}
	}


	/**
	 * resend_activation_token
	 * Resends a new account activation token to a users email address.
	 */
	function resend_activation_token()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('activation_token_identity', 'Identity (Email / Login)', 'required');
		
		// Run the validation.
		if ($this->form_validation->run())
		{					
			// Verify identity and resend activation token.
			$response = $this->flexi_auth->resend_activation_token($this->input->post('activation_token_identity'));
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

			// Redirect user.
			($response) ? redirect('auth') : redirect('auth/resend_activation_token');
		}
		else
		{	
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Reseting Passwords
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * forgotten_password
	 * Sends a 'Forgotten Password' email to a users email address. 
	 * The email will contain a link that redirects the user to the site, a token within the link is verified, and the user can then manually reset their password.
	 */
	function forgotten_password()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('forgot_password_identity', 'Identity (Email / Login)', 'required');
		
		// Run the validation.
		if ($this->form_validation->run())
		{
			// The 'forgotten_password()' function will verify the users identity exists and automatically send a 'Forgotten Password' email.
			$response = $this->flexi_auth->forgotten_password($this->input->post('forgot_password_identity'));
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			// Redirect user.
			redirect('auth');
		}
		else
		{
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	/**
	 * manual_reset_forgotten_password
	 * This example lets the user manually reset their password rather than automatically sending them a new random password via email.
	 * The function validates the user via a token within the url of the current site page, then validates their current and newly submitted passwords are valid.
	 */
	function manual_reset_forgotten_password($user_id, $token)
	{
		$this->load->library('form_validation');

		// Set validation rules
		// The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
			array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			// Get password data from input.
			$new_password = $this->input->post('new_password');
		
			// The 'forgotten_password_complete()' function is used to either manually set a new password, or to auto generate a new password.
			// For this example, we want to manually set a new password, so ensure the 3rd argument includes the $new_password var, or else a  new password.
			// The function will then validate the token exists and set the new password.
			$this->flexi_auth->forgotten_password_complete($user_id, $token, $new_password);

			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			redirect('auth');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Manage User Account
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * update_account
	 * Updates a users account and profile data.
	 */
	function update_account()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		// The custom rule 'identity_available' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'update_first_name', 'label' => 'First Name', 'rules' => 'required'),
			array('field' => 'update_last_name', 'label' => 'Last Name', 'rules' => 'required'),
			array('field' => 'update_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
			array('field' => 'update_newsletter', 'label' => 'Newsletter', 'rules' => 'integer'),
			array('field' => 'update_email', 'label' => 'Email', 'rules' => 'required|valid_email|identity_available'),
			array('field' => 'update_username', 'label' => 'Username', 'rules' => 'min_length[4]|identity_available')
		);
		
		$this->form_validation->set_rules($validation_rules);
		
		// Run the validation.
		if ($this->form_validation->run())
		{
			// Note: This example requires that the user updates their email address via a separate page for verification purposes.

			// Get user id from session to use in the update function as a primary key.
			$user_id = $this->flexi_auth->get_user_id();
			
			// Get user profile data from input.
			// IMPORTANT NOTE: As we are updating multiple tables (The main user account and user profile tables), it is very important to pass the
			// primary key column and value in the $profile_data for any custom user tables being updated, otherwise, the function will not
			// be able to identify the correct custom data row.
			// In this example, the primary key column and value is 'upro_id' => $user_id.
			$profile_data = array(
				'upro_id' => $user_id,
				'upro_first_name' => $this->input->post('update_first_name'),
				'upro_last_name' => $this->input->post('update_last_name'),
				'upro_phone' => $this->input->post('update_phone_number'),
				'upro_newsletter' => $this->input->post('update_newsletter'),
				$this->flexi_auth->db_column('user_acc', 'email') => $this->input->post('update_email'),
				$this->flexi_auth->db_column('user_acc', 'username') => $this->input->post('update_username')
			);
			
			// If we were only updating profile data (i.e. no email or username included), we could use the 'update_custom_user_data()' function instead.
			$response = $this->flexi_auth->update_user($user_id, $profile_data);
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

			// Redirect user.
			($response) ? redirect('auth_public/dashboard') : redirect('auth_public/update_account');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}

	/**
	 * change_password
	 * Updates a users password.
	 */
	function change_password()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		// The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'current_password', 'label' => 'Current Password', 'rules' => 'required'),
			array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
			array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
		);
		
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			// Get password data from input.
			$identity = $this->flexi_auth->get_user_identity();
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');			
			
			// Note: Changing a password will delete all 'Remember me' database sessions for the user, except their current session.
			$response = $this->flexi_auth->change_password($identity, $current_password, $new_password);
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			if ($response){
				return TRUE;
				
			} else {
				$this->data['message']=$this->flexi_auth->get_messages();
				return FALSE;
			}
			// Redirect user.
			// Note: As an added layer of security, you may wish to email the user that their password has been updated.
			//($response) ? redirect('auth_public/dashboard') : redirect('auth_public/change_password');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			return FALSE;
		}
	}
	
	/**
	 * send_new_email_activation
	 * This demo has 2 methods of updating a logged in users email address.
	 * The first option simply allows the users to change their email address along with the rest of their account data via entering it into a form fields.
	 * The second option requires users to verify their email address via clicking a link that is sent to that same email address.
	 * The purpose of the second option is to prevent users entering a mispelt email address, which would then prevent the user from logging back in.
	 */
	function send_new_email_activation()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		// The custom rule 'identity_available' can be found in '../libaries/MY_Form_validation.php'.
		$validation_rules = array(
			array('field' => 'email_address', 'label' => 'Email', 'rules' => 'required|valid_email|identity_available'),
		);
		
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			$user_id = $this->flexi_auth->get_user_id();
			
			// The 'update_email_via_verification()' function generates a verification token that is then emailed to the user.
			$this->flexi_auth->update_email_via_verification($user_id, $this->input->post('email_address'));
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			redirect('auth_public/dashboard');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	/**
	 * verify_updated_email
	 * Verifies a token within the current url and updates a users email address. 
	 */
	function verify_updated_email($user_id, $token)
	{
		// Verify the update email token and if valid, update their email address.
		$this->flexi_auth->verify_updated_email($user_id, $token);
		
		// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		
		// Redirect user.
		// Logged in users are redirected to the restricted public user dashboard, otherwise the user is redirected to the login page.
		if ($this->flexi_auth->is_logged_in())
		{
			redirect('auth_public/dashboard');
		}
		else
		{
			redirect('auth/login');
		}
	}
	
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Manage User Address Book
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * manage_address_book
	 * Loops through a POST array of all address IDs that where checked, and then proceeds to delete the addresses from the users address book.
	 * Note: The address book table ('demo_user_address') is used in this demo as an example of relating additional user data to the auth libraries account tables. 
	 */
	function manage_address_book()
	{
		// Delete addresses.
		if ($delete_addresses = $this->input->post('delete_address'))
		{
			foreach($delete_addresses as $address_id => $delete)
			{
				// Note: As the 'delete_address' input is a checkbox, it will only be present in the $_POST data if it has been checked,
				// therefore we don't need to check the submitted value.
				$this->flexi_auth->delete_custom_user_data('demo_user_address', $address_id);
			}
		}

		// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
		
		// Redirect user.
		redirect('auth_public/manage_address_book');
	}
	
	/**
	 * insert_address
	 * Inserts a new address to the users address book.
	 * Note: The address book table ('demo_user_address') is used in this demo as an example of relating additional user data to the auth libraries account tables. 
	 */
	function insert_address()
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'insert_alias', 'label' => 'Address Alias', 'rules' => 'required'),
			array('field' => 'insert_recipient', 'label' => 'Recipient', 'rules' => 'required'),
			array('field' => 'insert_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
			array('field' => 'insert_address_01', 'label' => 'Address Line #1', 'rules' => 'required'),
			array('field' => 'insert_city', 'label' => 'City / Town', 'rules' => 'required'),
			array('field' => 'insert_county', 'label' => 'County', 'rules' => 'required'),
			array('field' => 'insert_post_code', 'label' => 'Post Code', 'rules' => 'required'),
			array('field' => 'insert_country', 'label' => 'Country', 'rules' => 'required'),
			array('field' => 'insert_company', 'label' => '', 'rules' => ''),
			array('field' => 'insert_address_02', 'label' => '', 'rules' => '')
		);
		
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			// Get user id from session to use in the insert function as a primary key.
			$user_id = $this->flexi_auth->get_user_id();
			
			// Get user address data from input.
			// You can add whatever columns you need to custom user tables.
			$address_data = array(
				'uadd_alias' => $this->input->post('insert_alias'),
				'uadd_recipient' => $this->input->post('insert_recipient'),
				'uadd_phone' => $this->input->post('insert_phone_number'),
				'uadd_company' => $this->input->post('insert_company'),
				'uadd_address_01' => $this->input->post('insert_address_01'),
				'uadd_address_02' => $this->input->post('insert_address_02'),
				'uadd_city' => $this->input->post('insert_city'),
				'uadd_county' => $this->input->post('insert_county'),
				'uadd_post_code' => $this->input->post('insert_post_code'),
				'uadd_country' => $this->input->post('insert_country')
			);		
	
			$response = $this->flexi_auth->insert_custom_user_data($user_id, $address_data);
			
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			// Redirect user.
			($response) ? redirect('auth_public/manage_address_book') : redirect('auth_public/insert_address');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
	
	/**
	 * update_address
	 * Updates an address from the users address book.
	 * Note: The address book table ('demo_user_address') is used in this demo as an example of relating additional user data to the auth libraries account tables. 
	 */
	function update_address($address_id)
	{
		$this->load->library('form_validation');

		// Set validation rules.
		$validation_rules = array(
			array('field' => 'update_alias', 'label' => 'Address Alias', 'rules' => 'required'),
			array('field' => 'update_recipient', 'label' => 'Recipient', 'rules' => 'required'),
			array('field' => 'update_phone_number', 'label' => 'Phone Number', 'rules' => 'required'),
			array('field' => 'update_address_01', 'label' => 'Address Line #1', 'rules' => 'required'),
			array('field' => 'update_city', 'label' => 'City / Town', 'rules' => 'required'),
			array('field' => 'update_county', 'label' => 'County', 'rules' => 'required'),
			array('field' => 'update_post_code', 'label' => 'Post Code', 'rules' => 'required'),
			array('field' => 'update_country', 'label' => 'Country', 'rules' => 'required'),
			array('field' => 'update_company', 'label' => '', 'rules' => ''),
			array('field' => 'update_address_02', 'label' => '', 'rules' => '')
		);
		
		$this->form_validation->set_rules($validation_rules);

		// Run the validation.
		if ($this->form_validation->run())
		{
			// Get user address data from input.
			// You can add whatever columns you need to custom user tables.
			$address_id = $this->input->post('update_address_id');
			
			$address_data = array(
				'uadd_alias' => $this->input->post('update_alias'),
				'uadd_recipient' => $this->input->post('update_recipient'),
				'uadd_phone' => $this->input->post('update_phone_number'),
				'uadd_company' => $this->input->post('update_company'),
				'uadd_address_01' => $this->input->post('update_address_01'),
				'uadd_address_02' => $this->input->post('update_address_02'),
				'uadd_city' => $this->input->post('update_city'),
				'uadd_county' => $this->input->post('update_county'),
				'uadd_post_code' => $this->input->post('update_post_code'),
				'uadd_country' => $this->input->post('update_country')
			);		
	
			// For added flexibility, to identify the table and row to update, you can either submit the table name and row id via the 
			// first 2 function arguments, or alternatively, submit the primary column name and row id value via the '$address_data' array.
			// An example of this is commented out just below. When using the second method, the function identifies the table automatically.
			$response = $this->flexi_auth->update_custom_user_data('demo_user_address', $address_id, $address_data);
			
			/**
			 *  Example of updating custom tables using just data within an array.
			 * 	$address_data = array(
			 * 		'uadd_id' => $address_id,
			 *		'uadd_alias' => $this->input->post('update_alias'),
			 *		'uadd_recipient' => $this->input->post('update_recipient')
			 * 		// ... etc ... // 
			 *	);
			 * 	$response = $this->flexi_auth->update_custom_user_data(FALSE, FALSE, $address_data);
			*/
							
			// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
			$this->session->set_flashdata('message', $this->flexi_auth->get_messages());
			
			// Redirect user.
			($response) ? redirect('auth_public/manage_address_book') : redirect('auth_public/update_address');
		}
		else
		{		
			// Set validation errors.
			$this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
			
			return FALSE;
		}
	}
}
/* End of file demo_auth_model.php */
/* Location: ./application/models/demo_auth_model.php */