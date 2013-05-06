function processRecordAnswer(output,qid) {
	if (output.status){
		//var row=array();
		//console.log(submitted_ans[qid.toString()]['isCorrect']);
		submitted_ans[qid.toString()]['isCorrect']=output.isCorrect;
	}else {
		alert (output.error_msg);
	}
}
function recordAnswer(ans_record){
	var form_data="";
	//console.log(ans_record['question_id']);
	//console.log("update_or_create is".ans_record['update_or_create']);
	
	form_data='internalAccountId='+sess_data['user_id'] + '& testId='+cur_test_id +'&questionId='+ans_record['question_id'];
	form_data+=' &answerId='+ans_record['selection_id'];
	form_data+=' &create='+ans_record['create'];
	//console.log(form_data);
	$.ajax({
        url: global_siteurl+'/testwell/testwell/record_answer',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (ret_val) {   
			processRecordAnswer(ret_val,ans_record['question_id']);
        }
    });
}
function alreadyAnswered(qid) {
	if (submitted_ans[qid.toString()])
		return 1;// yes - we have recorded a response to this question before
	else 
		return -1; //no - no answer recorded
}
function recordAnswerChoice(question_id,selection_id) {
	//See if we've already recorded an answer for this question id
	var response=alreadyAnswered(question_id);
	if (response==-1) {
		//means we have never recorded a response for this question
		var new_qarr= new Array();
		new_qarr['question_id']=question_id;
		new_qarr['selection_id']=selection_id;
		new_qarr['isCorrect']=0;
		new_qarr['create']=1;
		submitted_ans[question_id.toString()]=new_qarr;
		//bump up number of questions that have been answered
		num_qs_answered++;
	} else {
		//First check to see if same value is be resubmitted
		//if he clciked on same answer again
		if(submitted_ans[question_id.toString()]['selection_id']==selection_id){
			return;
		}
		//we are going to update an existing response
		submitted_ans[question_id.toString()]['create']=0;
		submitted_ans[question_id.toString()]['selection_id']=selection_id;	
	}
	//console.log(submitted_ans[question_id.toString()]);
	recordAnswer(submitted_ans[question_id.toString()]);	
}
function processRecordSectionComplete(rval,sec_count){
	if (rval.status) {
		//Reset number of questions answered in section
		//Reset submitted answers
		num_qs_answered=0;
		submitted_ans.length=0;
		showNextSection(sec_count);
	} else {
		console.log("Record secton complete failed\n");
	}
}
function recordSectionComplete(sid,scount){
	
	var form_data="";
	form_data='userId='+sess_data['user_id']+' & testId='+cur_test_id+' &sectionId='+sid;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/record_section_complete',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {   
			processRecordSectionComplete(retval,scount);
        }
    });
}
function checkNumQuestionsUnanswered(sec_name) {
	//console.log(sections);
	
	var sec_arr=sections[sec_name];
	//if length of answers array is same as total number of 
	//questions in section, return true
	//console.log(sec_arr['sectionNumQuestions']-num_qs_answered);
	
	return (sec_arr['sectionNumQuestions']-num_qs_answered);
}
