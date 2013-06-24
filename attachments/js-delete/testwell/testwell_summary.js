/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_summary.js 
  * Routines to retrieve and display test history for the
  * the user.
  * Location: 'CI-top'/js/testwell
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/

/** 
* --------------------------------------------------------
  * Displays completed and partially completed tests for user
  * Also presents option for user to get a new test
  * Eventually may want to present score on each test too? --Maya Jan '13
  * Location: 'CI-top'/js/testwell
  *
  * @param {integer} num_tests	Total number of tests to for user
  * @param {array} test_list    Array of testIds (uuid)s for user
  * @return void
* --------------------------------------------------------
**/
function displayTestsSummary(num_tests,test_list){
	var completed_html="";
	var partial_html="";
	var new_html="";
	var completed_test_count=0;
	var partial_test_count=0;
	
	//Present option to take a new test
	new_html="<div id=new_test><u><b>New Test</b></u><br/><br/>";
	new_html+='<a href="#new_test" class="newbtn"> Generate a new test</a><br/><br/></div>';
	//Loop through the test ids and sort them by finished and partially finished
	completed_html="<div id=complete_test><u><b>Completed Tests</b></u><br/><br/>";
	partial_html="<div id=partial_test><u><b>Partially Completed Tests</b></u><br/><br/>";
	$.each(test_list,function(test_id,test) {
		//console.log(test);
		if (test['finish']==0) {
			partial_html+="Test for "+test['test_type']+" started on "+test['start'];
			partial_html+="&nbsp;&nbsp;&nbsp;&nbsp;";
			partial_html+='<a href="#partial_test" class="resumebtn" id="'
			partial_html+= test_id+'">Resume this test</a><br/><br/>';
			partial_test_count++;
		} else {
			completed_html+="Test for "+test['test_type']+" completed on "+test['start'];
			completed_html+="&nbsp;&nbsp;&nbsp;&nbsp;";
			completed_html+='<a href="#complete_test" class="reviewbtn" id="';
			completed_html+=test_id+'">Review this test</a><br/>';
			completed_test_count++;
		}
	});
	completed_html+="</div>";
	partial_html+="</div>";
	//Just render the lists of tests; control visibility from soemwhere else
	if (completed_test_count) {
		$('#test_status').append(completed_html).hide();
	}
	if (partial_test_count) {
		$('#test_status').append(partial_html).hide();
	}
	$('#test_status').append(new_html).hide();	
}
/** 
* --------------------------------------------------------
  * Ajax call to the server to retrieve all tests
  * taken by this user id
  *
  * @param {uuid} user_id	Unique internal account or user id 
  * @return {array} retval  Array returned from server with:
  *							total number of tests, list of test ids
* --------------------------------------------------------
**/

function getTestsForStudent(user_id) {
	var form_data="";
	form_data='userId='+user_id;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/get_tests_for_student',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {   
			processGetTestsForUser(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information regarding the tests for the user to display
  * Location: 'CI-top'/js/testwell
  *
  * @param {array} output  	Array output from server with:
  *							total number of tests, list of test ids
  * @return void        	At the end, the summary and status of tests
  *							is displayed on the screen
  * 
* --------------------------------------------------------
**/
function processGetTestsForUser(output) {
	if (output.status) {
		//console.log ("Got "+output.num_tests+" tests");
		clearTest();
		displayTestsSummary(output.num_tests,output.test_list);
		showSummary();
	} else {
		alert("GetTestsForUser failed");//Need to find out how to handle failure in js - Maya Jan '13
	}
}