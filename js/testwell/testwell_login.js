/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_login.js 
  * Routines to login/logout for the the user.
  * Location: 'CI-top'/js/testwell
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/

/** 
* --------------------------------------------------------
  * Ajax call to login username by presenting their credentials
  * Location: 'CI-top'/js/testwell
  *
  * @param {string} login		Login name for user
  * @param {string} password    pw
  * @param {boolean} remember   Flag to remember the pw for future (optional)
  * @return void				Upon success logs in user and displays summary page
* --------------------------------------------------------
**/
function loginUser() {

		//event.preventDefault(); find out what this is
		// Get the form data.
		var $form_inputs = $(this).find(':input');
		var login="";
		var pw="";
		var remember="";

		if( $("#identity").length )
				login=$('#identity').val();
		 if( $("#password").length )
				pw= $('#password').val();
		if( $("#remember_me").length )
		 		remember=$('#remember_me').val();
		var form_data = 'login_identity=' + login + '&login_password=' + pw+ '&remember_me=' + remember;
			
		$.ajax( {
			url: global_siteurl+'/testwell/testwell/login',
			type: 'POST',
			data: form_data,
			dataType: 'json',
			success:function(retval)
			{
				processLoginUser(retval);
			}
		});
}

/** 
* --------------------------------------------------------
  * Routine to process the successful response from the server with 
  * information login - clear out blurb view , display test summary for user 
  * Location: 'CI-top'/js/testwell
  *
  * @param {array} output  	Array output from server with:
  *							view to display for portal page
  * @return void        	At the end, portal is displayed for user
  * 						with their tests
* --------------------------------------------------------
**/
function processLoginUser(output) {
	//DIsplay login success message
	//console.log(output);
	if (output.status){
		var message=output.sessdata.flexi_auth.user_identifier;
		$('#login_message').html(message).show();
		$('#account_admin_div').hide().children().hide();
		login_session_data(output);
		//Display user menu in place of login fields
		userMenuFormDisplay();
		//First check to see if it's a parent or a student and display 
		//appropriate view; 
		var userType=getCurrentUserType();
		//If student,determine tests for this user's internal account id
		if (userType=="Student") {
			getTestsForStudent(output.sessdata.flexi_auth.user_id);
		} else if (userType=="Parent"){
			//If parent, display summary progress view
			//console.log("Parent logged in");
			getSummaryForParent(getCurrentUserId());
		} else if (output.userType=="Admin"){
			console.log("Admin logged in");
		} 
	} else {
		$('#login_message').html(output.err_message).show();
	}
}
/**
* Helper function to save the session data in a global
**/
function login_session_data(output){
	sess_data=output.sessdata;//sess_data is a global in testwell_global.js
}
/** 
* --------------------------------------------------------
  * Ajax call to logout current session user
  * Location: 'CI-top'/js/testwell
  *
  * @return void		Upon success logs out user and displays login page
* --------------------------------------------------------
**/
function logoutUser() {
	$.ajax({
        url: global_siteurl+'/testwell/testwell/logout',
        data: "",
        success: function (retval) {   //what is in retval?
			processLogoutUser(retval);
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
				console.log('An logout error was thrown.');
				console.log(XMLHttpRequest);
				console.log(textStatus);
				console.log(errorThrown);
		}
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the successful response from the server with 
  * information login - clear out blurb view , display test summary for user 
  * Location: 'CI-top'/js/testwell
  *
  * @return void        	At the end, user is logged out and login form displayed
* --------------------------------------------------------
**/
function processLogoutUser(output) {
	//Clearout the global variable for session data
	$('#login_body').html(output).show();
	$('#login_message').html("Logged out");	
	 $('#test_title').html("").hide();
	$('#test_status').html("Cool web stuff").show();
	$('#test_sections').html("").hide();
	$('#account_admin_div').html("").hide();
	closeOpenDialogs();	
	//console.log("Logged out");
}
/** 
* --------------------------------------------------------
  * Ajax call to display a blank login form
  * Location: 'CI-top'/js/testwell
  *
  * @return void		retrieves form from server
* --------------------------------------------------------
**/
function loginFormDisplay() {
	$.ajax({
        url: global_siteurl+'/testwell/testwell/login_form',
        data: "",
        success: function (retval) {   
			processLoginFormDisplay(retval);
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { //need to understand this form of error better - Maya Feb '13
			    alert('An login form error was thrown.');
				console.log("XMLHTTPRequest="+XMLHttpRequest);
				console.log("textStatus="+textStatus);
				console.log("Error="+errorThrown);
				alert('login form error done');
			    
			}
    });	
}
/** 
* --------------------------------------------------------
  * Routine to display the empty login form retrieved from server
  * Location: 'CI-top'/js/testwell
  *
  * @return void        	At the end, empty login form displayed
* --------------------------------------------------------
**/
function processLoginFormDisplay(output) {
	$('#login_body').html(output).show();
}
/** 
* --------------------------------------------------------
  * Ajax call to see if user is currently logged in by retrieving
  * current session data
  * Location: 'CI-top'/js/testwell
  *
  * @return {array}	retval	session data for current user if any
* --------------------------------------------------------
**/

function checkUserLoggedIn() {
	$.ajax({
        url: global_siteurl+'/testwell/testwell/check_logged_in',
        data: "",
		dataType: 'json',
		type: 'post',
		async:"false",
        success: function (retval) {   
			//alert(retval);
			processCheckUserLoggedIn(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to see if user is logged in and if so, display their
  * tests summary if they are a student - else kids summary for parent
  * Location: 'CI-top'/js/testwell
  *
  * @return void        If user is logged in, summary page is displayed
  *						If not, then login page is displayed
* --------------------------------------------------------
**/
function processCheckUserLoggedIn(output) {
	if (output.status) {
		//console.log(sess_data);
		if (output.isLoggedIn) {
			sess_data=output.sessdata;
			//console.log("Logged in Userid is:".$sessdata['user_id']);
			if ($('#user_menu_div').length==0){
				userMenuFormDisplay();
			}
			 var userType=getCurrentUserType();
			//If student,determine tests for this user's internal account id
			if (userType=="Student") {
				getTestsForStudent();
			} else if (userType=="Parent"){
				//If parent, display summary progress view
				//console.log("Parent logged in");
				getSummaryForParent();
			} else if (output.userType=="Admin"){
				console.log("Admin logged in");
			}
		} else {
			//console.log("Not logged in");
			loginFormDisplay();
			$('#test_status').html('Cool website blurb here; Log in for tests').show();
		}
	} else {
		$('#test_status').html('output.error_msg').show();
	}
}
/** 
* --------------------------------------------------------
  * Routine set the user's password from the default before activating the account
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function activatePassword(){
	
	//Need to make sure this is securely sent and
	//not in the clear
	var cur_pw, new_pw, conf_pw;
	
	if( $("#current_password").length )
			cur_pw=$('#current_password').val();
	if( $("#new_password").length )
			new_pw= $('#new_password').val();
	if( $("#confirm_new_password").length )
	 		conf_pw=$('#confirm_new_password').val();
	var act_user=$('#act_user').val();
	var act_token=$('#act_tok').val();
	var form_data = 'act_user='+ act_user + '&act_tok=' + act_token+ 
						'&current_password='+ cur_pw+'&new_password='+new_pw+
							'&confirm_new_password='+conf_pw;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/activate_password',
        data: form_data,
		dataType: 'json',
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processActivatePassword(retval);
        }
    });
}
function processActivatePassword(output) {
	if (output.status){
		$('#pw_update_message').html(output.message).show();
		hideActivateBody();
		loginFormDisplay();
	} else {
		$('#pw_update_message').html(output.message).show();
	}	
}
/** 
* --------------------------------------------------------
  * Ajax call to display user menu after they have logged in
  * Replacing the login/pw fields
  * Location: 'CI-top'/js/testwell
  *
  * @return void		retrieves form from server
* --------------------------------------------------------
**/
function userMenuFormDisplay() {
	$.ajax({
        url: global_siteurl+'/testwell/testwell/user_menu_form',
        data: "",
		async:false,
        success: function (retval) {   
			processUserMenuFormDisplay(retval);
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { //need to understand this form of error better - Maya Feb '13
			    alert('An login form error was thrown.');
				console.log("XMLHTTPRequest="+XMLHttpRequest);
				console.log("textStatus="+textStatus);
				console.log("Error="+errorThrown);
				alert('user menu form error done');
			    
			}
    });	
}
/** 
* --------------------------------------------------------
  * Routine to display the user menu form retrieved from server
  * Location: 'CI-top'/js/testwell
  *
  * @return void        	At the end, drop down list of items they can do
  * like logout
* --------------------------------------------------------
**/
function processUserMenuFormDisplay(output) {
	$('#login_body').html(output).show();
}