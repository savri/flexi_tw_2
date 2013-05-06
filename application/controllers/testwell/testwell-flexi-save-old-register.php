<?php
class Testwell extends CI_Controller {
	/**
	 * Testwell main controller - all the main interaction commands
	 * from the portal come here
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}
	function index() {
		$this->load->view("includes-tw/tw_header");
		$this->load->view("testwell/testwell_portal_view");
		$this->load->view("testwell/testwell_test_view");
		$this->load->view("includes-tw/tw_footer");
		//$this->load->model('flexi_auth_model');
		//$this->load->model('flexi_auth_lite_model');
	}
	/**
	 * Get info on past tests the user has taken. Return TRUE if successful
	 * (along with an array of list of tests and the number of tests), otherwise FALSE.
	 *
	 * @return	array
	 */
	function get_tests_for_user(){
		$output=array();
		$result=$this->testwell_portal_model->get_tests_for_user();
		if (($result['num_tests'] >0)|| ($result['num_tests']==0)) {
			$output['status']=TRUE;
			$output['num_tests']=$result['num_tests'];
			$output['test_list']=$result['test_list'];
		} else if ($result['num_tests'] < 0) {
			//error
			$output['status']=FALSE;
			$output['error_msg']="Getting old tests for user failed";
			$this->firephp->log("Failure");
		}
		//$this->firephp->log($output);
		echo json_encode($output);
	}
	/**
	 * Get a new test for this user. Return TRUE if successful
	 * (along with an array with the test data), otherwise FALSE.
	 *
	 * @return	array
	 */
	function get_new_test() {
		$output=array();
		//$this->firephp->log("create is".$this->input->post('create'));
			//$this->firephp->log($user_id);			
			$result=$this->testwell_new_model->generate_new_test();
			//$this->firephp->log($result);
			if ($result) {
				$output['status']=TRUE;
				$output['test_data']=$result;
				//$this->firephp->log($result);	
				//$this->firephp->log("about to json");					
			} else {
				$output['status']=FALSE;
				$output['errors']="Get test failed";	
			}
			echo json_encode($output);
			//$this->response($output);
	}
	/**
	 * Record a response made by user to a question. Return TRUE if successful
	 * (along with info if the choice was the correct response to the question), 
	 *  otherwise FALSE.
	 *
	 * @return	array
	 */
	function record_answer() {
		$output=array();
		//$this->firephp->log("in record_answer");
		$result=$this->testwell_record_model->record_answer();
		//$this->firephp->log("out of model");
		
		//$this->firephp->log($result);
		if ($result['recordAnswer']){
			$output['status']=TRUE;
			$output['isCorrect']=$result['isCorrect'];
		}else {
			$output['status']=FALSE;
			$output['error_message']="Record answer failed";
		}
		echo json_encode($output);
	}
	/**
	 * Record the completion of a section of the test. This could have
	 * happened if the time ran out for the section or the user chose to say
	 * that he had completed the section by clicking the button. Once completed,
	 * user cannot return to the section. Return TRUE if successful
	 *  otherwise FALSE.
	 *
	 * @return	array
	 */
	function record_section_complete(){
		$ret_val=$this->testwell_record_model->record_section_complete();	
		if ($ret_val){
			$output['status']=TRUE;
		} else {
			$output['status']=FALSE;
			$output['error_msg']="Recording section complete status failed";
		}
		echo json_encode($output);		
	}
	/**
	 * Retrieve either partially or fully completed test for the user
	 * to either resume or review.  Return TRUE if successful 
	 * (along with an array containing the specific test data)
	 *  otherwise FALSE.
	 *
	 * @return	array
	 */
	function reload_test() {
		$output=array();
		//$this->firephp->log("Generating Test for testId = ".$this->input->post('testId'));
		$result=$this->testwell_resume_model->reload_test();
		//$this->firephp->log($result);
		if ($result) {
			$output['status']=TRUE;
			$output['test_data']=$result;
			$output['message']="I did it!";
			//$this->firephp->log($result);			
		} else {
			$output['status']=FALSE;
			$output['errors']="reload test failed";	
		}
		echo json_encode($output);
	}
	function record_time_left() {
		$output=array();
		//$this->firephp->log("Recording for testId = ".$this->input->post('testId'));
		$result=$this->testwell_record_model->record_time_left();
		//$this->firephp->log($result);
		if ($result) {
			$output['status']=TRUE;	
			$output['message']=$this->input->post('secs_left');		
		} else {
			$output['status']=FALSE;
		}
		echo json_encode($output);
	}
	/**===========================================Flexi_AUTH controller===========================**/
	/**
	 * Controller routines to handle login/logout follows. I had to import it
	 * from auth.php controller
	 */

	/**
	 * Retrive all session data for current session
 	 * Return TRUE if successful 
	 * (along with an array containing the specific session data)
	 *  otherwise FALSE.
	 *
	 * @return	array
	 */
	function check_logged_in() {
		$output=array();
		$sessdata=$this->session->all_userdata();
		//$this->firephp->log($sessdata);
		if (!array_key_exists('user_data', $sessdata)||$sessdata['user_data']==""){
			//$this->firephp->log("Not logged in");
			$output['sessdata']=$sessdata;
			$output['isLoggedIn']=FALSE;
			$output['status']=TRUE;
		} else if ($this->tank_auth->is_logged_in()){
			$this->firephp->log("Logged in Userid is:".$sessdata['user_id']);
			$output['isLoggedIn']=TRUE;
			$output['sessdata']=$sessdata;
			$output['status']=TRUE;
		} else {
			$this->firephp->log("Why am I here?");
		}
		echo json_encode($output);
	}
	/**
	 * Retrive the login form to display - flexi/login_view.php
	 *
	 * @return	array
	 */
	function login_form(){
		return ($this->load->view('flexi/login_view'));
	}
	
	function login() {
		$output=array();
		
		$this->firephp->log("In login");	
		if ($this->input->is_ajax_request()){
			$remember_user = ($this->input->post('remember_me') == 1);
			// Verify login data.
			$result= $this->flexi_auth->login($this->input->post('login_identity'), 
									$this->input->post('login_password'), $remember_user);
			$this->firephp->log("Login result=".$result);	
			if ($result==1) {
				$sessdata=$this->session->all_userdata();
				$output['isLoggedIn']=TRUE;
				$output['sessdata']=$sessdata;
				$output['status']=TRUE;	
				$this->firephp->log("Logged in");	
				
			} else {
				$output['isLoggedIn']=FALSE;
				$output['status']=FALSE;
				$output['err_message']=$this->flexi_auth->get_messages();
			}
			$this->firephp->log($output);
			
			echo json_encode($output);
			//die($this->flexi_auth->is_logged_in()); //need to figure out die
		}
	}
	/**
	 * logout
	 * This logs the user out of all sessions on all computers they may be logged into.
	 * accessed via a link once a user is logged in.
	 */
	function logout() 
	{
		// By setting the logout functions argument as 'TRUE', all browser sessions are logged out.
		$this->flexi_auth->logout(TRUE);
		
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());		
 
		//redirect('auth');
		$data=array();
		$data['login_message']=$this->flexi_auth->get_messages();
		$this->load->view('flexi/login_view',$data);
    }
	/**
	 * Retrive the register form to display - flexi/register_view.php
	 *
	 * @return	array
	 */
	function register_form(){
		return ($this->load->view('flexi/register_view'));
	}
	/**
	 * register_account
	 * User registration page used by all new users wishing to create an account.
	 * Note: This page is only accessible to users who are not currently logged in, else they will be redirected.
	 */ 
	function register_account()
	{
		$output=array();
		
		//$this->load->library('flexi_auth');
		$xx=$this->input->post('register_user');
		$this->firephp->log("register_user=".$xx);
		// Redirect user away from registration page if already logged in.
		if ($this->flexi_auth->is_logged_in()) 
		{
			$this->firephp->log("Logged in");
			redirect('auth');
		}
		// If 'Registration' form has been submitted, attempt to register their details as a new account.
		else if ($this->input->post('register_user')==1)
		{						
			//$this->load->model('demo_auth_model');
			$res=$this->demo_auth_model->register_account();
			
			if ($res) {
				$this->data['register_message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		
				$output['message']=$this->flexi_auth->get_messages();				
				$output['status']=TRUE;
			} else {
				$output['message']=$this->data['message'];
				$output['status']=FALSE;	
			}
			echo json_encode($output);
			return;
		}
		// Get any status message that may have been set.
		$this->data['register_message'] = (! isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];		
		//The use case of just loading the register form
		$this->load->view('flexi/register_view', $this->data);
	}
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
	// Account Activation
	###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

	/**
	 * activate_account
	 * User account activation via email.
	 * The default setup of this demo requires that new account registrations must be authenticated via email before the account is activated.
	 * In this demo, this page is accessed via an activation link in the 'views/includes/email/activate_account.tpl.php' email template.
	 */ 
	function activate_account($user_id, $token = FALSE)
	{
		// The 3rd activate_user() parameter verifies whether to check '$token' matches the stored database value.
		// This should always be set to TRUE for users verifying their account via email.
		// Only set this variable to FALSE in an admin environment to allow activation of accounts without requiring the activation token.
		$this->flexi_auth->activate_user($user_id, $token, TRUE);

		// Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
		$this->session->set_flashdata('message', $this->flexi_auth->get_messages());

		//redirect('auth');
		$data=array();
		$data['login_message']=$this->flexi_auth->get_messages();
		$this->load->view("includes-tw/tw_header");
		$this->load->view("testwell/testwell_portal_view",$data);
		$this->load->view("testwell/testwell_test_view");
		$this->load->view("includes-tw/tw_footer");
	}

}