/** 
* =================================================================
  * tw_editor_modify.js 
  * All routines to do with setting up questions/passages for modification
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/application/views/includes/tw_editor_header.php
  * Location: CI-top'/js/tw_editor/tw_editor_modify.js
* =================================================================
**/


/** 
* --------------------------------------------------------
  * Ajax call to request server to set up the page to allow
  * modification/editing of a question & choices
  * @return void	displays page with menu options for making mods
* --------------------------------------------------------
**/
function modify_question() {
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/add_new_question',
        data: "",
        type: 'post',
        success: function (retval) {  
			process_modify_question(retval);						
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * edit page info and display ig
  *
  * @return html        	Html data from server to display page
  * 
* --------------------------------------------------------
**/
function process_modify_question(output) {
	$('#qa_mm_div').hide();
	$('#qa_ret_div').show();
	$('#qa_body_div').html(output).show();
	$('#qid_div').show();
	$('#act_head_div').html("<h3>Edit question by question id</h3>").show();
}
/** 
* --------------------------------------------------------
  * Ajax call to request server to set up the page to allow
  * mass modification/editing of a question & choices
  * @return void	displays page with menu options for making mods
* --------------------------------------------------------
**/
function mass_modify_questions(){
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/mass_modify',
        data: "",
        type: 'post',
        success: function (retval) {
			process_mass_modify_questions(retval);
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * edit page info for making mass modifications by section/topic
  *
  * @return html        	Html data from server to display page
  * 
* --------------------------------------------------------
**/
function process_mass_modify_questions(output) {
	//console.log("Done!");
	$('#qa_mm_div').hide();
	$('#qa_ret_div').show();
	$('#qa_body_div').html(output).show();
	cur_edit_all_q_count=0;
}