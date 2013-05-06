/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_reload.js 
  * Routines to retrieve partially finished tests (for resumption) 
  * or fully finished tests (for review) from the server
  *
  * Location: 'CI-top'/js/testwell/testwell_reload.js
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/
/** 
* --------------------------------------------------------
  * Ajax call to retrieve test content from server
  * 
  * @param {int} test_id    UUid identifier of the test to be fetched from server
  * @return {array} retval	Upon success, contents of test
* --------------------------------------------------------
**/
function reloadTest(test_id) {
		//alert ("Reloading Test\n");
		form_data='testId='+test_id+'&userId='+sess_data['user_id'];
		$.ajax({
	        url: global_siteurl+'/testwell/testwell/reload_test',
	        data: form_data,
	        dataType: 'json',
	        type: 'post',
	        success: function (retval) {   
				processReloadTest(retval);
	        }
	    });
}
/** 
* --------------------------------------------------------
  * Routine to process the data from the server with 
  * information regarding test for specified test id
  *
  * @param {array} output  	Array output from server with:
  *							questions, choices and other test details
  * @return void        	At the end, displays contents of test
  * 
* --------------------------------------------------------
**/
function processReloadTest(output){
	var submitted_answers="";
	var cur_sec=0;
	if (output.status) {
		//console.log(rval.message);
		clearSummary();
		displayTest(output.test_data,output.test_data.test_type);
		//console.log(rval.test_data);
		selectSubmittedAnswers(output.test_data['submitted_answers']);
		if (test_review_mode) {
			disableRadioButtons();
			showAllSections();
			scrollToTop('#test_sections'); //go to the top of the test
		} else {
			//determine which section to display if oyu are
			//resuming
			showSection(output.test_data['cur_section']);
		}
	} else {
		console.log(output.error_message);
		//need to return something here and fail somehow - Maya Jan 13
	}
}
