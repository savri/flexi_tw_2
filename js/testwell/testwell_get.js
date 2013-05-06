/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_get.js 
  * Routines to get all sorts of data
  * Location: 'CI-top'/js/testwell/testwell_get.js
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/
/** 
* --------------------------------------------------------
  * Gets user id, user email(also login name) of the logged in user from sessdata which is global
  *
  * @return {int} user_id
* --------------------------------------------------------
**/
function getCurrentUserId(){
	return sessdata.flexi_auth.user_id;
}
function getCurrentUserEmail(){
	return sessdata.flexi_auth.user_identifier;
}
function getCurrentUserType(){
	//First convert the group object to array to get the first element
	var xx = $.map(sessdata.flexi_auth.group, function(k, v) {
	    return [k];
	});
	console.log("User type="+xx[0]);
	
	return xx[0];
}
/** 
* --------------------------------------------------------
  * Gets the English section name for a section
  *
  * @param {enum} ttype	section_name
  * @return {string} verbose section name
* --------------------------------------------------------
**/
function getSectionDisplayName(section_name) {
	if (section_name=="QUANT_REASON"){
		return "Quantitative Reasoning";
	}else if (section_name=="VERB_REASON"){
		return"Verbal Reasoning";	
	} else if (section_name=="READING_COMP"){
		return"Reading Comprehension";
	} else if	(section_name=="MATH"){
		return"Math Achievement";
	} else if	(section_name=="VOCAB"){
		return"Vocabulary";	
	} else if	(section_name=="MATH_ACH"){
		return"Math Achievement";	
	}
}

/** 
* --------------------------------------------------------
  * Get the multiple choice answers for a question
  * @param {int} qid question id as listed in question_bank
  * @param {int} num_choices the number of multiple answers to 
  *							   get from global array of answers retrieved: answers
  * @param {enum} sect_name  name of the section for qid
  * @return {array} mult_choice  num_choices of answer choices; NULL on failure
* --------------------------------------------------------
**/
function getAnswerChoices(qid,num_choices,sect_name) {
	var mult_choice=new Array();
	var count=0;
	var br_flag=0;//Flag used in html clean up; Only if flag, then remove line breaks
	if ((sect_name=="READING_COMP")||(sect_name=="VERB_REASON"))	br_flag=1;

	$.each(answers, function(arr_index,arow) {
		//console.log("key=",arr_index,"arow=",arow);
		 if (arow['questionId']==qid && (count <num_choices)){
			//var ans=strip(arow['answerValue']);
			var ans=cleanUpHtmlString(arow['answerValue'],sect_name,br_flag);
			mult_choice[count]={value:ans, id:arow['answerId']};
			count++;
		} else if (count == num_choices) {
			//console.log("Retrieved enough answer choices; stop looking for more");
			return false;//this breaks out of the .each loop which is what I want
		}
	});
	//Shuffle the contents so that the ordering of the choices is random
	//console.log("Before:",mult_choice);	
	return (shuffle(mult_choice));
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
		clearSummary();
		displayTestsSummary(output.num_tests,output.test_list);
		showSummary();
	} else {
		alert("GetTestsForUser failed");//Need to find out how to handle failure in js - Maya Jan '13
	}
}
/** 
* --------------------------------------------------------
  * Ajax call to the server to retrieve summary info
  * for all kids for this parent
  *
  * @param {uuid} user_id	Unique internal account or user id 
  * @return {array} retval  Array returned from server with:
  *				for each kid,total number of tests, list of test ids
* --------------------------------------------------------
**/

function getSummaryForParent(user_id) {
	var form_data="";
	form_data='userId='+user_id;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/get_summary_for_parent',
        data: form_data,
        type: 'post',
        success: function (retval) {   
			processGetSummaryForParent(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information regarding the summary for the parent to display
  * Location: 'CI-top'/js/testwell
  *
  * @param {array} output  	Array output from server with:
  *							total number of tests, list of test ids
  * @return void        	At the end, the summary and status of tests
  *							is displayed on the screen
  * 
* --------------------------------------------------------
**/
function processGetSummaryForParent(output) {
	$('#test_status').hide();
	$('#test_sections').html(output).show();

}
