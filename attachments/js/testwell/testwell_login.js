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
	var login="";
	var pw="";
	var remember="";
	
	if( $("#login").length )
			login=$('#login').val();
	 if( $("#password").length )
			pw= $('#password').val();
	if( $("#remember").length )
	 		remember=$('#remember').val();
	
	//Make ajax call to server to login username with supplied password
	//Need to know how to handle failure/exception -- MAya Jan '13
	var dataString = 'login=' + login + '&password=' + pw+ '&remember=' + remember;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/login',
        data: dataString,
		type:"POST",
        success: function (retval) {   
			processLoginUser(retval);
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			    alert('An login error was thrown.');
				console.log("XMLHTTPRequest="+XMLHttpRequest);
				console.log("textStatus="+textStatus);
				console.log("Error="+errorThrown);
				alert('All login error done');
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
	//Display the summary page view
	$('#login_dive').html(output);
	//Determine tests for this user's internal account id
	getTestsForStudent(sess_data['user_id']);
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
			processLogoutUser();
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
function processLogoutUser() {
	displayLoginForm();
	$('#test_status').html('Cool website blurb here').show();	
}
/** 
* --------------------------------------------------------
  * Ajax call to display a blank login form
  * Location: 'CI-top'/js/testwell
  *
  * @return void		retrieves form from server
* --------------------------------------------------------
**/
function displayLoginForm() {
	$.ajax({
        url: global_siteurl+'/testwell/testwell/login',
        data: "",
        success: function (retval) {   
			processDisplayLoginForm(retval);
        },
		error: function(XMLHttpRequest, textStatus, errorThrown) { 
			    alert('An login form error was thrown.');
				console.log("XMLHTTPRequest="+XMLHttpRequest);
				console.log("textStatus="+textStatus);
				console.log("Error="+errorThrown);
				alert('All login form error done');
			    
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
function processDisplayLoginForm(output) {
	$('#login_dive').html(output);
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
        url: global_siteurl+'/testwell/testwell/get_session_data',
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
		sess_data=output.sessdata;
		//console.log(sess_data);
		displayLoginForm();
		if (sess_data['logged_in']){//Not currently working as designed. Need to check - Maya Jan '13
			getTestsForStudent(sess_data['user_id']);
		} else {
			$('#test_status').html('Cool website blurb here; Log in for tests').show();
		}
	} else {
		$('#test_status').html('output.error_msg').show();
	}
}