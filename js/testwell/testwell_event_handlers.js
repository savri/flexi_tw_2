/** 
* --------------------------------------------------------
  * testwell_event_handlers.js 
  * Functions that handle user interactions.
  * Event handlers for button clicks/links etc
  * Location: 'CI-top'/js/testwell
* --------------------------------------------------------
**/
/**
* ----------------------------------------------------------
* Register all the event handlers used in testwell with main div
* @return void
* ----------------------------------------------------------
*/
function registerEventHandlers() {
	radioEventHandler();
	finishSectionEventHandler();
	newTestEventHandler();
	newTimedTestEventHandler();
	reviewTestEventHandler();
	resumeTestEventHandler();
	returnEventHandler();
	registerFormEventHandler();
	registerUserEventHandler();
	loginEventHandler();
	logoutEventHandler();
	passwordActivationEventHandler();
	passwordFormEventHandler();
	timerStartEventHandler();
	timerStopEventHandler();
	accountFormEventHandler();	
}
/**
* ----------------------------------------------------------
* From main portal, when user requests a new test
* @return void
* ----------------------------------------------------------
*/
function newTestEventHandler() {
	$('#test_status').delegate('.newbtn', 'click', function() {  
		test_review_mode=false;
		timed_test_mode=false;
		//Need to first check to see if there are generated tests that the user
		//has not taken and only if there aren't any, generate a new test -- Maya Jan '13
		generateNewTest(sess_data['user_id'],cur_test_type)
	});
}
/**
* ----------------------------------------------------------
* From main portal, when user requests a new test with timer
* @return void
* ----------------------------------------------------------
*/
function newTimedTestEventHandler() {
	$('#test_status').delegate('.newtimebtn', 'click', function() {  
		test_review_mode=false;
		timed_test_mode=true;
		//Need to first check to see if there are generated tests that the user
		//has not taken and only if there aren't any, generate a new test -- Maya Jan '13
		generateNewTest(sess_data['user_id'],cur_test_type)
	});
}
/**
* ----------------------------------------------------------
* From main portal, when user requests to resume a partially completed test
* Request server to load the appropriate test id
*
* @return void
* ----------------------------------------------------------
*/
function resumeTestEventHandler() {
	$('#test_status').delegate('.resumebtn', 'click', function() {  
		var tid=$(this).attr('id');
		//Set global variable for review to false since we're resuming
		test_review_mode=false;
		//retrieve and display test with tid
		//alert("About to display test id="+tid);
		reloadTest(tid);
	});
}
/**
* ----------------------------------------------------------
* From main portal, when user requests to review a completed test
* Request server to load the appropriate test id
*
* @return void
* ----------------------------------------------------------
*/
function reviewTestEventHandler() {
	$('#test_status').delegate('.reviewbtn', 'click', function() {  
		var tid=$(this).attr('id');
		//Set global variable for review to true
		//It controls display and input mode later on
		test_review_mode=true;
		//retrieve and display test with tid
		//alert("About to review test id="+tid);
		reloadTest(tid);
	});
}
/**
* ----------------------------------------------------------
* Handler for all radio buttons in the multiple choice questions
* Updates the display with selection and requests server to save
* the choice. If user is reviewing a test, the radio buttons are 
* not enabled
*
* @return void
* ----------------------------------------------------------
*/
function radioEventHandler() {
	var grp_name="";
	if(!test_review_mode){
		$('#test_sections').delegate('input[type=radio]', 'click', function() { 
			//console.log($(this).attr('qid'));
			 //console.log($(this).val());
			recordAnswerChoice($(this).attr('qid'),$(this).val());
		});
	}	
}

/**
* ----------------------------------------------------------
* Handler when user clicks on section finished button in test. Prompts user about
* unfinished questions, if any, and records section as completed
*
* @return void
* ----------------------------------------------------------
*/
function finishSectionEventHandler() {
	$('#test_sections').delegate('.secfinbtn', 'click', function() {
		var num_qs=checkNumQuestionsUnanswered($(this).attr('sname')); 
		//If there are any questions not yet answered ask for confirmation (handle timed test correctly)
		if (((num_qs)&&(!timed_test_mode))||((timed_test_mode)&& (timerGetValue()!=0)&&(num_qs))){
			if (confirm('You have '+num_qs+' unanswered in this section. Are you sure you want to submit?')) {
				//console.log("I'm gonna submit!");
			     recordSectionComplete($(this).attr('sid'),$(this).attr('scount'));
			} else {
				//console.log("I'm gonna continue working on the problems!");
			}
		} else {
			//console.log("All questions have been answered");
			recordSectionComplete($(this).attr('sid'),$(this).attr('scount'));
		}
	});
}
/**
* ----------------------------------------------------------
* Handler for button to return from reviewing a completed test
* back to the main portal. Also displays the overall test status
* for the user
*
* @return void
* ----------------------------------------------------------
*/
function returnEventHandler() {
	$('#test_sections').delegate('.returnbtn', 'click', function() {  
		//Set review mode to false
		test_review_mode=false;
		getTestsForStudent(sess_data['user_id']);//Need to figure out a way to see if session has timed out  - Maya Jan '13
	});
}
/**
* ----------------------------------------------------------
* Handler for login page to register first time user
* Will present the registration window with datafields
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function registerFormEventHandler() {
	$('#login_dive').delegate('#regbtn', 'click', function() {  
		//alert("About to show register forms");
		//If register_user is 0, it just displays the registration form
		var fdata='register_user='+0;
		registerUser(fdata,0);

	});
}
/**
* ----------------------------------------------------------
* Handler for sumitting registration information
* Will present the registration window with datafields
*
* @return void
* ----------------------------------------------------------
*/

function registerUserEventHandler() {
	$('#test_sections').delegate('#reguserbtn', 'click', function() {  
		//alert("About to register user");
		//Now that you have user data, register_user=1 - this is just a mode switch
		var fdata='register_user='+1+'&register_p_f_name='+$('#p_f_name').val();
		fdata+='&register_p_l_name='+$('#p_l_name').val();
		fdata+='&register_add_line_1='+$('#add_line_1').val();
		fdata+='&register_add_line_2='+$('#add_line_2').val();
		fdata+='&register_city='+$('#city').val();
		fdata+='&register_state='+$('#state').val();
		fdata+='&register_zip='+$('#zip').val();
		fdata+='&register_ph_number='+$('#ph_number').val();
		fdata+='&register_pri_p_email='+$('#pri_p_email').val();
		fdata+='&register_alt_p_email='+$('#alt_p_email').val();
		fdata+='&register_s_f_name='+$('#s_f_name').val();
		fdata+='&register_s_l_name='+$('#s_l_name').val();
		fdata+='&register_s_email='+$('#s_email').val();
		fdata+='&register_s_grade='+$('#s_grade').val();
		fdata+='&register_s_ttype='+$('#s_ttype option:selected').val();
		//console.log(fdata);
		registerUser(fdata,1);
	});
}
/**
* ----------------------------------------------------------
* Handler from login page to log in user
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function loginEventHandler() {
	$('#login_dive').delegate('#loginbtn', 'click', function() {  
		//alert("About to login");
		loginUser();
	});
}
/**
* ----------------------------------------------------------
* Handler from login page to log out user
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function logoutEventHandler() {
	
	$('#login_dive').delegate('#logout', 'click', function() {  
		if (confirm('Are you sure you want to log out?')) {
		     logoutUser();
		} else {
			//console.log("I'm gonna stay logged in");
		}
	});
}
/**
* ----------------------------------------------------------
* Handler from activation page to change default pw of user
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function passwordActivationEventHandler() {
	$('#account_admin_div').delegate('#changepwbtn', 'click', function() {  
		activatePassword();
	});
}
/**
* ----------------------------------------------------------
* Handler for timer start button for timed tests
*
* @return void
* ----------------------------------------------------------
*/
function timerStartEventHandler() {
	$('#test_sections').delegate('#timer_start_btn', 'click', function() {  
		timer.mode(0);//countdown mode
		showSectionBody(cur_section);
		timerStart();
	});
}
/**
* ----------------------------------------------------------
* Handler for timer start button for timed tests
*
* @return void
* ----------------------------------------------------------
*/
function timerStopEventHandler() {
	$('#test_sections').delegate('#timer_stop_btn', 'click', function() {  
		timerStop();
		hideSectionBody(cur_section);		
		if (timer_start_flag) {
			$("#timer_start_btn").html('Resume Section').show();
			timer_start_flag=false;
		}
	});
}
/**
* ----------------------------------------------------------
* Handler to display change password form for user
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function passwordFormEventHandler() {
	$('#login_dive').delegate('#change_pw_form', 'click', function() {  
		var fflag=0;
		changePassword(fflag);
	});
}
/**
* ----------------------------------------------------------
* Handler to display account form for user
* Depending on user role they will be able to change 
* settings for their kids as well or just themselves
* Need to think more about exceptions --Maya Jan '2013
*
* @return void
* ----------------------------------------------------------
*/
function accountFormEventHandler() {
	$('#login_dive').delegate('#ac_update', 'click', function() {  
		var fflag=0;
		accountUpdate(fflag);
	});
}