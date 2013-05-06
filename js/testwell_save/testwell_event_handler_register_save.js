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
	registerUserEventHandler()
	loginEventHandler();
	logoutEventHandler();
	timerStartEventHandler();
	timerStopEventHandler();	
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
		//retrieve and display test with tid
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
		//retrieve and display test with tid
		//alert("About to register user");
		//Now that you ahve user data, register_user=1
		var fdata='register_user='+1+'&register_first_name='+$('#first_name').val();
		fdata+='&register_last_name='+$('#last_name').val();
		fdata+='&register_phone_number='+$('#phone_number').val();
		fdata+='&register_newsletter='+$('#newsletter').val();
		fdata+='&register_email_address='+$('#remail_address').val();
		fdata+='&register_username='+$('#remail_address').val();
		fdata+='&register_password='+$('#rpassword').val();
		fdata+='&register_confirm_password='+$('#rconfirm_password').val();
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
	$('#login_dive').delegate('#logoutbtn', 'click', function() {  
		logoutUser();
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

