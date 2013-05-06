/** 
* --------------------------------------------------------
  * testwell_timer.js 
  * Functions dealing with start/stop/reset of timers and 
  * also timer complete
  * Location: 'CI-top'/js/testwell/testwell_timer.js
  *
* --------------------------------------------------------
**/
/**
*----------------------------------------------------------
* Routine used in start, stop, reset, timer & get current time
*
* @param  int - time in seconds (we count down in seconds)
* @return void
*----------------------------------------------------------
*/
function timerStart() {
	timer.start(1000);//1000 millisec=1 sec interval count
}
function timerStop() {
	timer.stop();
}
function timerReset(rtime) {
	//console.log("REset time= "+rtime);
	timer.reset(rtime);
}
function timerGetValue() {
	return timer.getTime();
}
/**
*----------------------------------------------------------
* Routine to handle when timer runs out
*
* @param  int - time in seconds (we count down in seconds)
* @return void
*----------------------------------------------------------
*/
function timerRanOut(){
	alert("Timer ran out!");
}
/** 
* --------------------------------------------------------
  * Ajax call to the server to record time left for the current section
  * Recorded in the TWELL_TEST_TAKE_TBL for this user/test
  *
  * @param 	{int} 		seconds left for the current section
  * @return {array} 	retval		array with success/failure			
* --------------------------------------------------------
**/
function timerRecord(seconds_left) {
	var form_data;
	//console.log("Testtype="+test_type);
	form_data='internalAccountId='+sess_data['user_id']+'&testId='+cur_test_id+'&secs_left='+seconds_left;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/record_time_left',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (ret_val) {   
			processTimerRecord(ret_val);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * success/failure of time record
  * Location: 'CI-top'/js/testwell
  *
  * @param {array} output  	Array output from server with:
  *							data about the test
  * @return void        	
  * 
* --------------------------------------------------------
**/
function processTimerRecord(output) {
	if (output.status) {
		//console.log('Recorded "+output.message);
	} else {
		//console.log("Could not record time");
		//need better error handling here - Maya Jan '13
	}
}