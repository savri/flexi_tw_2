/** 
* =================================================================
  * tw_editor_save.js 
  * All routines to do with saving modified questions/choices/passages
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/application/views/includes/tw_editor_header.php
  * Location: CI-top'/js/tw_editor/tw_editor_save.js
* =================================================================
**/


/** 
* --------------------------------------------------------
  * Function to retrieve all the data in CKEditor and drop down menus
  * for a question/choices
  * @return void	makes Ajax call to server to save these values
* --------------------------------------------------------
**/
function save_new_values() {
	var form_data="";
	var quid;
	
	if ($('#qid').val()=="")
		quid=0;
	else
	quid=parseInt($('#qid').val());
	form_data=get_input_field_values();
	form_data+='&ttype='+$('#ttype_dd option:selected').val()+'&qid='+quid+'&questionTopic='
																	+$('#top_dd option:selected').val();
	form_data+=' &questionSection='+$('#sect_dd option:selected').val();
	//form_data+=' &choice1='+ch1+' &choice2='+ch2+' &choice3='+ch3+' &choice4='+ch4;
	//form_data+=' &choice1_tag='+$('#tag1_dd').val()+' &choice2_tag='+$('#tag2_dd').val();
	//form_data+=' &choice3_tag='+$('#tag3_dd').val()+' &choice4_tag='+$('#tag4_dd').val();
	//console.log(form_data);
	save_question(form_data);
}
/** 
* --------------------------------------------------------
  * Ajax call to request server to save question with info in the submitted
  * data
  *
  * @param	{string}	AJAX formatted data with all details from the editor
  * @return {array}		result of save from server
* --------------------------------------------------------
**/
function save_question(form_data){
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/save_question',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {   
			process_save_question(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server on save
  * 
  * @param	{array}	output	TRUE on success; FALSE on failure to save
  * @return {void}        	Displays success/failure message and preps editor for new
  *							question
  * 
* --------------------------------------------------------
**/
function process_save_question(output) {
	if(output.status) {
		//Clear out all the input fields and get ready for next entry
		$('#qid').val("");
		clear_question_input_fields();
		$('#add_q_msg_div').html("Question successfuly saved").show().fadeOut(4800);
	} else {
		$('#add_q_msg_div').append(output.error).show().fadeOut(6400);	
	}
	$('html, body').animate({ scrollTop: 0 }, 0);
}
/** 
* --------------------------------------------------------
  * Ajax call to request server to save passage content and list of associated
  * questions
  *
  * @param	{array}		array of queston Ids of associated questions
  * @return {array}		result of save from server
* --------------------------------------------------------
**/
function save_passage(qarr) {
	var passage;
	var form_data="";

	var id=	$('textarea[name=hester]').attr('id');
	passage=CKEDITOR.instances[id].getData();

	form_data='&passage='+escape(passage)+'&question_list='+qarr;
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/save_passage',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (retval) {   
			process_save_passage(retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server 
  *
  * 
  * @param	{array}	output	TRUE on success; FALSE on failure to save
  * @return {void}        	Displays success/failure message and preps editor for new
  *							question including updating list of free RC questions
  * 
* --------------------------------------------------------
**/
function process_save_passage(output) {
	var html_retbut="";
	if(output.status) {
		$('#status_msg_div').append(output.message).show().fadeOut(6400);
		var id= $('textarea[name=hester]').attr('id');
		CKEDITOR.instances[id].setData("");
		get_read_comp_questions();
	} else {
		$('#status_msg_div').append(output.error).show().fadeOut(6400);
	}
	
}