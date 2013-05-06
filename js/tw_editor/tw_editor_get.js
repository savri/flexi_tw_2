/** 
* =================================================================
  * tw_editor_get.js 
  * All routines to do with retrieving info either from server or screen
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/application/views/includes/tw_editor_header.php
  * Location: CI-top'/js/tw_editor/tw_editor_get.js
* =================================================================
**/
/** 
* --------------------------------------------------------
  * Ajax call to get list of topics associated with a section
  *
  * @param	{string}	form_data	AJAX formatted string with section info
  * @param	{bool}		mm_flag		Flag to indicate mass modification mode
  * @return {array}		retval		Upon success, returns array of topics; NULL on failure			
* --------------------------------------------------------
**/
function get_topics_for_section(form_data,mm_flag) {
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/get_sect_topics',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {  
			process_get_topics_for_section(retval,mm_flag);	
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information to populate topic details in the dropdown menu
  *
  * @param	{bool}		mm_flag		Flag to indicate mass modification mode
  * @return {array}		output		array of topics; NULL on failure
  * @return void        			Populate dropdown menu with correct topics
  * 
* --------------------------------------------------------
**/
function process_get_topics_for_section(output,mm_flag) {
	if (output){
		//mm_flag true for mass modify mode; false for new question mode
		if (mm_flag){
			$('#etop_dd').empty();
	        var unassigned = $('#etop_dd').attr('options');
			var topSelect=$('#etop_dd');
	        $.each(output, function(val, text) {
			    topSelect.append(
			        $('<option></option>').val(val).html(text)
			    );
			});
		} else {
			$('#top_dd').empty();
	        var unassigned = $('#top_dd').attr('options');
			var topSelect=$('#top_dd');
	        $.each(output, function(val, text) {
			    topSelect.append(
			        $('<option></option>').val(val).html(text)
			    );
			});
		}
	}
}
/** 
* --------------------------------------------------------
  * Ajax call to get question details associated with a question id
  *
  * @param	{int}		qid			question Id
  * @return {array}		retval		Upon success, returns array of question details; 
  *										NULL on failure			
* --------------------------------------------------------
**/
function get_question_by_qid(qid) {
	form_data='&qid='+(qid);
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/get_question_for_qid',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {   
			process_get_question_by_qid(retval);
			//console.log(retval);
        }
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server about the question
  *
  * @param {array}		output		array details about the question with the qid
  * @return void        			Populate dropdown menus and CKEditors with question data
  *									for modification
  * 
* --------------------------------------------------------
**/
function process_get_question_by_qid(output) {
	if (output.status) {
		//var data=output.data;
		//Update the fields with question's current values
		$('#qid_err_div').hide();
		$('#add_q_msg_div').html("");
		mmodify=1;
		display_question_for_edit(output.data);
		$('#q_body_div').show();
		
	}else {
		$('#add_q_div').hide();
		$('#qid_err_div').html(output.error).show();
		$('#qid').val("");
		//console.log("Getquestions failed");
	}
	$('html, body').animate({ scrollTop: 0 }, 0);
}
/** 
* --------------------------------------------------------
  * Ajax call to get list of unattached reading comp questions 
  *
  * @return {array}		retval		Upon success, returns array of questions; 
  *										NULL on failure			
* --------------------------------------------------------
**/
function get_read_comp_questions() {
    $.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/get_read_comp_questions',
        data: "",
        dataType: 'json',
        type: 'post',
        success: function (retval) {
            process_get_read_comp_questions(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * unattached reading comp question
  *
  * @param {array}		output		array of RC questions; NULL on failure
  * @return {void}        			Displays list of free questions for passage
  * 
* --------------------------------------------------------
**/
function process_get_read_comp_questions(output) {
	if (output.status){
		//console.log(output.qarray);
		display_read_comp_questions(output.qarray);
		
	} else {
		$('#pass_qs_div').html(output.error).show('slow');
	}
	
}
//Fetch the question in batches of 10 - lateron we can up this since it may become
//cumbersome
function get_questions_in_10s(form_data) {
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/get_questions_in_10s',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {  
			process_get_questions_in_10s(retval);
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information to populate next 10 (or remaining question in
  * the desired section/topic(s)
  *
  * @param {array}		output		array of question details; NULL on failure
  * @return void        			Displays the next 10 questions for mass modification
  * 
* --------------------------------------------------------
**/
//Function to present the 10 questions for editing
function process_get_questions_in_10s(output){
	if (output.status){
		//console.log(output.qarray);
		//hide the main menu div for edit_all
		$('#edit_all_mm_div').hide();

		if (output.total_count==0){
			$('#edit_all_msg_div').html("There are no questions available for this section/topic").show();
		} else {
			mmodify_total_q_count=output.total_count;
			mmodify_local_q_arr=output.q_array;
			//Though the array count starts from 0 but we have to list message as though from 1
			display_10_questions((mmodify_cur_q_count+1),mmodify_total_q_count);
		}
	} else {
		$('#status_msg_div').html(output.error).show('slow');
	}
}
/** 
* --------------------------------------------------------
  * Routine to identify the question in the list of 10 fetched
  * that the user wants to modify
  *
  * @param {int}		qid			question Id of question to be edited
  * @return {array}		q_row		array containing editable details about question
  * 
* --------------------------------------------------------
**/
function get_mass_modify_question_from_qid(qid){
	var q_row;
	$.each(mmodify_local_q_arr,function(key,row){
		if(row['questionId']==qid){
			console.log(key,row['question']);
			q_row=row;
			return false;//breaks out of the .each loop
		}
	});
	return q_row;
}
/** 
* --------------------------------------------------------
  * Routine to read the contents of the editors and dropdown from
  * the screen with the modified values so that we can save them
  *
  * @return {string}	fd		AJAX formatted string with modified data about question
  * 
* --------------------------------------------------------
**/
function get_input_field_values() {
	var fd="";
	var id= $('textarea[name=questionck]').attr('id');
	var question=CKEDITOR.instances[id].getData();
	id= $('textarea[name=choice1ck]').attr('id');
	var ch1=CKEDITOR.instances[id].getData();
	id= $('textarea[name=choice2ck]').attr('id');
	var ch2=CKEDITOR.instances[id].getData();
	id= $('textarea[name=choice3ck]').attr('id');
	var ch3=CKEDITOR.instances[id].getData();
	id= $('textarea[name=choice4ck]').attr('id');
	var ch4=CKEDITOR.instances[id].getData();
	fd+=' &question='+escape(question);
	fd+=' &choice1='+ch1+' &choice2='+ch2+' &choice3='+ch3+' &choice4='+ch4;
	fd+=' &choice1_tag='+$('#tag1_dd').val()+' &choice2_tag='+$('#tag2_dd').val();
	fd+=' &choice3_tag='+$('#tag3_dd').val()+' &choice4_tag='+$('#tag4_dd').val();
	//console.log("Form data from read_question_input_field: "+fd);
	return fd;
}