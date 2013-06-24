/** 
* --------------------------------------------------------
  * Functions that handle user interactions.
  * Event handlers for button clicks/links etc
  * Location: 'CI-top'/js/tw_editor/tw_editor_event_handlers.js
* --------------------------------------------------------
**/
/**
* ----------------------------------------------------------
* Register all the event handlers used in tw_editor 
* @return void
* ----------------------------------------------------------
*/
function register_event_handlers() {
	main_menu_handler();
	return_main_menu_handler();
	save_question_handler();
	save_passage_handler();
	get_question_by_qid_handler();
	select_section_handler();
	mass_modify_select_section_handler();
	mass_modify_handler();
	mass_modify_load_question_handler();
	mass_modify_save_handler();
	mass_modify_cancel_handler();
	//mass_modify_load_handler();
	mass_modify_fetch_next_10_handler();
}
/**
* ----------------------------------------------------------
* Event handler for main menu options
* @return void
* ----------------------------------------------------------
*/
function main_menu_handler() {
	$('#qa_main_div').delegate('#activity_dd', 'click', function() {
		var action = $('#activity_dd option:selected').val();
		if (action=='Add_New_Q'){
			add_new_question();
		} else if (action=='Add_Passage'){
			add_new_passage();
		} else if (action=='Edit_Q'){
			modify_question();
		} else if (action=='Edit_All') {
			mass_modify_questions();
		}
	});
}
/**
* ----------------------------------------------------------
* Event handler to return to main menu from any other page
*
* @return void	displays main page with drop down options
* ----------------------------------------------------------
*/
function return_main_menu_handler() {
	$('#qa_ret_div').delegate('#mainmenubtn', 'click', function() {
		$('#qa_body_div').html("");
		$('#qa_ret_div').hide();
		$('#qa_mm_div').show();
		mmodify=0;
	});
}
/**
* ----------------------------------------------------------
* Event handler to edit 1-by-1 button so that
* all questions in the section/topic selected can be edited sequentially
* Likely to be used when there is some kind of global addtion or 
* tweak to be made like adding additional tags to main menu from 
* any other page
*
* @return void	displays first 10 question in section/topic
* 						which user can select to edit 1-by-1
* ----------------------------------------------------------
*/
function mass_modify_handler() {
	$('#qa_body_div').delegate('#editallbtn', 'click', function() {
			mmodify_section = $('#esect_dd option:selected').val();//global var
			mmodify_topic=$('#etop_dd option:selected').val(); //global var
			//console.log(form_data);
			if (mmodify_section=='No Select'){
				$('#status_msg_div').html("Error: No section selected").show();
				$('html, body').animate({ scrollTop: 0 }, 0);
				return;
			}
			var fetch_from_qid=0;
			$('#status_msg_div').html("").show();
			form_data='&section='+mmodify_section+'&topic='+mmodify_topic+'&fetch_from_qid='+fetch_from_qid;
			mmodify_cur_q_count=0;
			get_questions_in_10s(form_data);
		});	
}
/**
* ----------------------------------------------------------
* Event handler to load the selected question and the answer
 * choices in the editor so it can be modified
*
* @return void	displays question & answers in individual editors
* ----------------------------------------------------------
*/
function mass_modify_load_question_handler() {
	$('#qa_body_div').delegate('.editqlink', 'click', function() {
		var qrow= new Array();
		var qid=$(this).attr('id');
		qrow=get_mass_modify_question_from_qid(qid);
		display_question_for_edit(qrow);
		$('#edit_all_body_div').show();
		
	});
}
/**
* ----------------------------------------------------------
* Event handler to save the selected question and the answer
 * choices after it's been modified
*
* @return void	saves q&a and returns to display of 10 questions
* ----------------------------------------------------------
*/
function mass_modify_save_handler() {
	$('#qa_body_div').delegate('#editallsavebtn', 'click', function() {
		//console.log("save question and get enxt");
		save_updated_question();
	});
}
/**
* ----------------------------------------------------------
* Event handler to cancel editing selected question and the answer
 * choices 
*
* @return void	returns to display of 10 questions w/o saving
* ----------------------------------------------------------
*/function mass_modify_cancel_handler() {
	$('#qa_body_div').delegate('#editallcancelbtn1,#editallcancelbtn2', 'click', function() {
		$('#edit_all_body_div').hide();
	});
}
/**
* ----------------------------------------------------------
* Event handler fetch next 10 questions in the section/topic
*
* @return void	 display next set of 10 questions
* ----------------------------------------------------------
*/
function mass_modify_fetch_next_10_handler() {
	$('#qa_body_div').delegate('#editallnext10btn', 'click', function() {
		//console.log(" Get next 10 qs");
		if (mmodify_cur_q_count==mmodify_total_q_count){
			mmodify_cur_q_count=0;
			$('#edit_all_msg_div').html("No more questions in this section matching your criteria").show();
			$('#edit_all_body_div').hide();
			return;
		} else {
			//First get the last qid fetched in this batch of 10
			//So that we can fetch the next 10 starting from here
			var fetch_from_qid=parseInt(mmodify_local_q_arr[9]['questionId']);
			form_data='&section='+mmodify_section+'&topic='+
									mmodify_topic+'&fetch_from_qid='+fetch_from_qid;
			get_questions_in_10s(form_data);
		}
	});
}
//Handler to select the Section and populate appropriate topics
//in the Mass modify view
//Only allow them to handle questions by section and not the whole
//bank

function mass_modify_select_section_handler() {
	$('#qa_body_div').delegate('#esect_dd', 'change', function() {
			var section = $('#esect_dd option:selected').val();
			form_data='&section='+section+'&mass_modify=1';
			//console.log(form_data);
			if ($('#esect_dd').val()=='No Select'){
				$('#status_msg_div').html("Error: No section selected").show();
				return;
			}
			$('#status_msg_div').html("").show();
			get_topics_for_section(form_data,1);
		});	
}

//Depending on the section selected in the input_questions view
//Populate the appropriate topics associated with this section
function select_section_handler() {
	$('#qa_body_div').delegate('#sect_dd', 'change', function() {
			var section = $('#sect_dd option:selected').val();
			form_data='&section='+section+'&mass_modify=0';
			if ($('#sect_dd').val()=='No Select'){
				$('#add_q_msg_div').html("Error: No section selected").show();
				return;
			}
			$('#add_q_msg_div').html("").show();
			get_topics_for_section(form_data,0); 
		});	
}
/**
* ----------------------------------------------------------
* Event handler save modified passage & associated questions
*
* @return void	 saves passage+ associated questions
* ----------------------------------------------------------
*/
function save_passage_handler() {
	var selected = new Array();

	$('#qa_body_div').delegate('#savepassagebtn', 'click', function() {  
		//alert("About to submit");
		selected=[];
		//console.log(selected);
		
		$("input:checkbox[name='qopts']:checked").each(function() {
		       selected.push($(this).val());
		  });
		//console.log(selected);
		if (selected.length < 5) {
			var num_q=selected.length;
			alert('You have only selected '+num_q +' questions.You need a total of 5 per passage.');
		}else{
			save_passage(selected);
		}
	});
}
/**
* ----------------------------------------------------------
* Event handler save new question+answers
*
* @return void
* ----------------------------------------------------------
*/
function save_question_handler() {
	$('#qa_body_div').delegate('#savebtn', 'click', function() {  
		var id= $('textarea[name=questionck]').attr('id');
		var q_val=CKEDITOR.instances[id].getData();
		
		//Make sure they selected a section & topic
		if ($('#sect_dd').val()=='No Select'){
			$('#add_q_msg_div').html("Error:No section selected").show();
			$('html, body').animate({ scrollTop: 0 }, 0);
			return;
		}
		if ($('#top_dd').val()=='No Select'){
			$('#add_q_msg_div').html("Error: No topic selected").show();
			$('html, body').animate({ scrollTop: 0 }, 0);
			return;
		}
		//Need check to see if they hit save w/o entering anything meaningful
		//Check if question matches "Enter Question"
		if (mmodify_mode && ($('#qid').val()=="")) {
			return;
		} else 
			save_new_values();
	});
}
/**
* ----------------------------------------------------------
* Event handler retrieve a question from the db given a question
* id
*
* @return void
* ----------------------------------------------------------
*/
function get_question_by_qid_handler() {
	$('#qa_body_div').delegate('#qidenterbtn', 'click', function() {
		var qid=parseInt($('#qid').val());
		if (isNaN(qid)){
			console.log("Enter a valid question id");
			return;
		}	
		get_question_by_qid(qid);
	});	
}
