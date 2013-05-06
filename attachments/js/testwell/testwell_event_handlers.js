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
	reviewTestEventHandler();
	resumeTestEventHandler();
	returnEventHandler();
	userRegisterEventHandler();
	loginEventHandler();
	logoutEventHandler();
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
		//If there are any questions not yet answered, ask for confirmation 
		if (num_qs) {
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
function userRegisterEventHandler() {
	$('#login_dive').delegate('#regbtn', 'click', function() {  
		//retrieve and display test with tid
		//alert("About to register");
		$.ajax({
	        url: global_siteurl+'/testwell/testwell/register',
	        data: "",
	        success: function (retval) {   
				//alert(retval);
				$('#login_dive').html(retval);
	        },
			error: function(XMLHttpRequest, textStatus, errorThrown) { 
			        alert("Status: " + textStatus); alert("Error: " + errorThrown);
			}
	    });
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
