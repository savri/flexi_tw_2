/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_new.js 
  * Routines to create and retrieve data for a new test
  *
  * Location: 'CI-top'/js/testwell
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/
/** 
* --------------------------------------------------------
  * Ajax call to the server to retrieve a new test of test type
  *
  * @param 	{int} 		user_id		uuid - Unique internal account or user id 
  * @param 	{string} 	test_type	enumerated type of test
  * @return {array} 	retval		array with all the data for a new test			
* --------------------------------------------------------
**/
function generateNewTest(user_id,test_type) {
	var form_data;
	//console.log("Testtype="+test_type);
	form_data='userId='+user_id+'&testType='+test_type;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/get_new_test',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (ret_val) {   
			processGenerateNewTest(ret_val,test_type);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information regarding the new test for the user to display
  * Location: 'CI-top'/js/testwell
  *
  * @param {array} output  	Array output from server with:
  *							data about the test
  * @param {string}			enumerated type of test
  * @return void        	At the end,test
  *							is displayed on the screen
  * 
* --------------------------------------------------------
**/
function processGenerateNewTest(output,test_type) {
	if (output.status) {
		//console.log("got test\n");
		//recordTestDetails(output.test_data);
		clearSummary();
		displayTest(output.test_data,test_type);
		showSection(1);//we always display the first section in a new test
	} else {
		console.log("get new test failed\n");
		//need better error handling here - Maya Jan '13
	}
}

