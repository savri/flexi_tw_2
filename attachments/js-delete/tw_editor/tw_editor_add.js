/** 
* --------------------------------------------------------
  * Ajax call to bring up view to add a new question w/ answer choices
  *
  * @return void		display page with editor to input new question			
* --------------------------------------------------------
**/
function add_new_question() {
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/add_new_question',
        data: "",
        type: 'post',
        success: function (retval) {  
			process_add_new_question(retval);
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information to display question input page
  *
  * @param {array} output  	Array output from server with:
  *							view page for new questions
  * @return void        	At the end,question editor
  *							is displayed on the screen
  * 
* --------------------------------------------------------
**/
function process_add_new_question(output){
	$('#qa_mm_div').hide();
	$('#qa_ret_div').show();
	$('#qa_body_div').html(output).show();
	$('#q_body_div').show();
}

/** 
* --------------------------------------------------------
  * Ajax call to bring up view to add a new passage w/ questions
  *
  * @return void	display page with editor to input new passage			
* --------------------------------------------------------
**/
function add_new_passage() {
	$.ajax({
        url: global_siteurl+'/tw_editor/tw_editor/add_new_passage',
        data: "",
        type: 'post',
        success: function (retval) { 
	 		process_add_new_passage(retval);
		}
	});
}
/** 
* --------------------------------------------------------
  * Routine to process the response from the server with 
  * information to display passage input page
  *
  * @param {array} output  	Array output from server with:
  *							view page for adding new passage
  * @return void        	At the end,question editor
  *							is displayed on the screen
  * 
* --------------------------------------------------------
**/
function process_add_new_passage(output){
	$('#qa_mm_div').hide();
	$('#qa_ret_div').show();					
	$('#qa_body_div').html(output).show();
	get_read_comp_questions();
	//savePassageEventHandler();
}