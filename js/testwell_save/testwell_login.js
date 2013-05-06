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
				/** If the returned login value successul.
				if (data) {
					// Empty the login form content and replace it will a successful login message.
					$('#login_message').empty().append('<h1>Login via Ajax was successful!</h1><p>Refreshing this page would now redirect you away from the login page to the user dashboard.</p>');
					
					// Hide any error message that may be showing.
					$('#login_message').hide();
				}
				// Else the login credentials were invalid.
				else {
					// Show an error message stating the users login credentials were invalid.
					$('#message').show();
				}
				**/
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
	console.log(output);
	if (output.status){
		var message=output.sessdata.flexi_auth.user_identifier+' logged in';
		$('#login_message').empty().html(message).show();
		//Hide login form and display logout button
		var html_str="";
		html_str='<button id="logoutbtn" >Logout</button>';
		$('#login_body').empty().html(html_str).show();
		
		//Determine tests for this user's internal account id
		getTestsForStudent(output.sessdata.flexi_auth.user_id);
	} else {
		$('#login_message').empty().html(output.err_message).show();
	}
	//Display the summary page view

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
	//displayLoginForm();
	$('#login_dive').empty().html(output).show();	
	$('#test_status').empty().html("Cool web stuff").show();
	console.log("Logged out");
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
        success: function (retval) {   
			//alert(retval);
			processCheckUserLoggedIn(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to see if user is logged in and if so, display their
  * tests summary
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
			getTestsForStudent(sess_data['user_id']);
		} else {
			//console.log("Not logged in");
			loginFormDisplay();
			$('#test_status').html('Cool website blurb here; Log in for tests').show();
		}
	} else {
		$('#test_status').html('output.error_msg').show();
	}
}