/** 
* =================================================================
  * tw_editor_display.js 
  * All routines to do with displaying html on screen
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/application/views/includes/tw_editor_header.php
  * Location: CI-top'/js/tw_editor/tw_editor_display.js
* =================================================================
**/
/** 
* --------------------------------------------------------
  * Populates CKEditor with question & choices details in preperation
  * for modification
  *
  * @param	{array}	data	array containing question & choices details
  * @return void	displays question/answer details in the editors and dropdowns
* --------------------------------------------------------
**/
function display_question_for_edit(data){
	//Populate the form with values of the question/answers/tags
	//so that we can edit it.
	var id= $('textarea[name=questionck]').attr('id');
	CKEDITOR.instances[id].setData(data['question']);
	var selected=$('#sect_dd');
	selected.val(data['section']);
	selected =$('#top_dd');
	selected.val(data['topic']);
	id= $('textarea[name=choice1ck]').attr('id');
	CKEDITOR.instances[id].setData(data['choice1']);
	id= $('textarea[name=choice2ck]').attr('id');
	CKEDITOR.instances[id].setData(data['choice2']);
	id= $('textarea[name=choice3ck]').attr('id');
	CKEDITOR.instances[id].setData(data['choice3']);
	id= $('textarea[name=choice4ck]').attr('id');
	CKEDITOR.instances[id].setData(data['choice4']);
	selected =$('#tag1_dd');
	selected.val(data['tag1']);
	selected =$('#tag2_dd');
	selected.val(data['tag2']);
	selected =$('#tag3_dd');
	selected.val(data['tag3']);
	selected =$('#tag4_dd');
	selected.val(data['tag4']);
	$('#add_q_div').show();
}
/** 
* --------------------------------------------------------
  * Clear CKEditor and dropdown box values in preparation for next question
  *
  * @param	{array}	data	array containing question & choices details
  * @return void	clears question/answer details in the editors and dropdowns
* --------------------------------------------------------
**/
function clear_question_input_fields() {
	var id= $('textarea[name=questionck]').attr('id');
	CKEDITOR.instances[id].setData("Enter Question");
	id= $('textarea[name=choice1ck]').attr('id');
	CKEDITOR.instances[id].setData("Enter Choice1");
	id= $('textarea[name=choice2ck]').attr('id');
	CKEDITOR.instances[id].setData("Enter Choice2");
	id= $('textarea[name=choice3ck]').attr('id');
	CKEDITOR.instances[id].setData("Enter Choice3");
	id= $('textarea[name=choice4ck]').attr('id');
	CKEDITOR.instances[id].setData("Enter Choice4");
	$('#tag1_dd').val('OTHER');
	$('#tag2_dd').val('OTHER');
	$('#tag3_dd').val('OTHER');
	$('#tag4_dd').val('OTHER');	
	if (mmodify_mode==1){ 				//If you are not in edit mode but q entry mode, leave the form up
		$('#add_q_div').hide();
	}
}
/** 
* --------------------------------------------------------
  * List "unattached" reading comp questions when entering a new
  * passage with a checkbox to allow for selection
  *
  * @param	{array}	qarr	Array of R C questions
  * @return void			Displays list of questions with associated checkboxes
* --------------------------------------------------------
**/
function display_read_comp_questions(qarr) {
    var html_str=""
    $.each(qarr, function(arr_index,qrow) {
        ques_str=strip(qrow['question'],6);
        html_str +='<input type="checkbox" name="qopts"'+'value='+qrow['questionId']+'>'+ques_str+'<br>';
    });
    //console.log(html_str);
    $('#pass_qs_div').html(html_str).show('slow');
}
/** 
* --------------------------------------------------------
  * Function to display the 10 (or however many are currently
  * available) questions we've fetched
  * User can select which one they want to edit or
  * Get the next 10 to examine
  *
  * @param	{int}	start_num	Array of R C questions
  * @param	{int}	total_q_num	Array of R C questions
  * @return void			Displays list of questions with associated checkboxes
* --------------------------------------------------------
**/
function display_10_questions(start_num, total_q_num) {
	var html_string="";
	var end_num=start_num+mmodify_local_q_arr.length-1;
	
	if ($('#edit_all_list_qs_div').length > 0) {
		$('#edit_all_list_qs_div').remove();
	}
	//List out each question and an edit link at the end
	html_string +="<div id=edit_all_list_qs_div>";
	html_string +="<p> There are "+total_q_num+" questions matching your selection.";
	html_string +=" Listing questions "+start_num+" to "+end_num+"</p>";
	$.each(mmodify_local_q_arr,function(key,row){
		html_string +="<li>"+start_num+". "+strip(row['question'],-5)+"</li>";		
		html_string += add_edit_link(row['questionId']);
		start_num++;
		mmodify_cur_q_count++;//each time we list a question bump up the number of qs we've presented
	});
	html_string+=add_next_10_button();
	html_string+="</div>";
	$('#edit_all_msg_div').html(html_string).show();
	//console.log(html_string);
}
/** 
* --------------------------------------------------------
  * Handy function to add a Edit Questionlink at end of each question 
  * body
  * Event handler for this is: mass_modify_load_question_handler()
  * Code in ./tw_editor_event_handlers.js
  *
  * @param	{int}	qid		question Id
  * @return {string} hstr	returns html fragment for a link to Edit Question
* --------------------------------------------------------
**/
function add_edit_link(qid) {
	var hstr="";
	hstr='<a href="#editq-id" class="editqlink" id="'+qid+'" span style="padding-left:40px" > Edit Question </a>';
	return hstr;
}
/** 
* --------------------------------------------------------
  * Handy function to add button to fetch next set of 10 questions
  * for this section/topic combo at the end of the list of current
  * 10 questions
  * Event handler for this is: mass_modify_fetch_next_10_handler()
  * Code in ./tw_editor_event_handlers.js
  *
  * @return {string} hstr	returns html fragment for a button 
* --------------------------------------------------------
**/
function add_next_10_button() {
	var hstr="";
	hstr="</br> </br>";
	hstr+='<input type="button" id="editallnext10btn" value="Show next set of questions" />';	
	return hstr;	
}