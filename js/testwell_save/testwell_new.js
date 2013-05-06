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
	var tt;
	//console.log("Testtype="+test_type);
	if (timed_test_mode==1){
		tt=1;
	}else{
		tt=0;
	}
	form_data='userId='+user_id+'&testType='+test_type+'&timed_test_mode='+tt;
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
		clearSummary();
		displayTest(output.test_data,test_type);
		timed_test_mode=output.test_data['timed_test_mode'];
		console.log("Time left="+output.test_data['time_left']);
		cur_section=1;//global var
		if (timed_test_mode==1) {
			timer_init_time=output.test_data['time_left'];//timer_init_time used by displayTimer
			displayTimer();
			timer_start_flag=true;//Starting the test - not resuming it from part way
			timerReset(output.test_data['time_left']);
			showSectionTitleAndTimer(cur_section);
		} else {
			showSection(cur_section);//we always display the first section in a new test
		}
	} else {
		console.log("get new test failed\n");
		//need better error handling here - Maya Jan '13
	}
}
