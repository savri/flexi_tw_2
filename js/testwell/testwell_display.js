/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_display.js 
  * Routines to assemble and display question/answers for
  * different sections. Each section has some peculiarity
  * that requires different handling
  * Location: 'CI-top'/js/testwell/testwell_display.js
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/
/** 
* --------------------------------------------------------
  * Displays completed and partially completed tests for user
  * Also presents option for user to get a new test
  * Eventually may want to present score on each test too? --Maya Jan '13
  * Location: 'CI-top'/js/testwell
  *
  * @param {integer} num_tests	Total number of tests to for user
  * @param {array} test_list    Array of testIds (uuid)s for user
  * @return void
* --------------------------------------------------------
**/
function displayTestsSummary(num_tests,test_list) {
	var completed_html="";
	var partial_html="";
	var new_html="";
	var completed_test_count=0;
	var partial_test_count=0;
	
	//Present option to take a new test
	new_html="<div id=new_test><u><b>New Test</b></u><br/><br/>";
	new_html+='<a href="#new_test" class="newbtn"> New test (without timer)</a>';
	new_html+='&nbsp;&nbsp;&nbsp;';
	new_html+='<a href="#new_test_timed" class="newtimebtn"> New timed test</a><br/><br/>';
	new_html+='</div>';
	
	//Loop through the test ids and sort them by finished and partially finished
	completed_html="<div id=complete_test><u><b>Completed Tests</b></u><br/><br/>";
	partial_html="<div id=partial_test><u><b>Partially Completed Tests</b></u><br/><br/>";
	$.each(test_list,function(test_id,test) {
		//console.log(test);
		if (test['finish']==0) {
			partial_html+="Test for "+test['test_type']+" started on "+test['start'];
			
			partial_html+="&nbsp;&nbsp;&nbsp;&nbsp;";
			partial_html+='<a href="#partial_test" class="resumebtn" id="';
			partial_html+= test_id+'">Resume this test';
			if (test['timedTest']==1){
				partial_html+="&nbsp;(timed)";
			}
			partial_html+='</a><br/><br/>';
			partial_test_count++;
		} else {
			completed_html+="Test for "+test['test_type']+" completed on "+test['start'];
			completed_html+="&nbsp;&nbsp;&nbsp;&nbsp;";
			completed_html+='<a href="#complete_test" class="reviewbtn" id="';
			completed_html+=test_id+'">Review this test';
			if (test['timedTest']==1){
				completed_html+="&nbsp;(timed)";
			}
			completed_html+='</a><br/>';
			completed_test_count++;
		}
	});
	completed_html+="</div>";
	partial_html+="</div>";
	//Just render the lists of tests; control visibility from soemwhere else
	if (completed_test_count) {
		$('#test_status').append(completed_html).hide();
		$('#test_status').append("<br/>");
	}
	if (partial_test_count) {
		$('#test_status').append(partial_html).hide();
	}
	$('#test_status').append(new_html).hide();	
}
/** 
* --------------------------------------------------------
  * Constructs & displays completed and partially completed tests for user
  * Constructs the html to be displayed
  * Also presents option for user to get a new test
  * Eventually may want to present score on each test too? --Maya Jan '13
  * Location: 'CI-top'/js/testwell
  *
  * @param {integer} num_tests	Total number of tests to for user
  * @param {array} test_list    Array of testIds (uuid)s for user
  * @return void
* --------------------------------------------------------
**/
function displayTest(test_data,test_type){
	sections=test_data['sections'];
	topics=test_data['topics'];
	questions=test_data['questions'];
	answers=test_data['choices'];
	passages=test_data['passages'];
	cur_test_id=test_data['cur_test_id'];
	
	var section_count=1;
	var sect_disp_name;
	var ques_start_count=1;
	var ques_end_count=1;
	var sec_body_div_html;
	var div_id;
	//Initialize global variable for total number of sections
	total_num_sections=0;
	displayTestTitle(test_type);
	$.each(sections,function(section_name,srow){
		//console.log("Section Id=",section_name, "Row=",srow);
		total_num_sections++;
		ques_start_count=1;//reset for each section
		if (parseInt(srow['sectionNumQuestions'])){
			//if you are in timer mode, record the time allocated for this section
			//Used when you go from one section to another
			if (timed_test_mode==1) {
			    section_duration[section_count]=(parseInt(srow['sectionDuration']))*60;//convert minutes to seconds
			}
			displaySectionTitle(section_name,srow,section_count);
			displaySectionBody(section_count);
/**			sec_body_div_html='<div id=section'+section_count+'_body style="display:none;"></div>';
			div_id="#section"+section_count;
			$(div_id).append(sec_body_div_html);
**/
			//Need to handle each section a little differently
			if ((section_name=='QUANT_REASON')|| (section_name=='MATH_ACH')){
				//35 questions of mixed topics
				ques_end_count=displayMathSection(srow['sectionId'],
							srow['sectionNumChoices'],section_count,srow['sectionName'],ques_start_count);
			} else if (section_name=='READING_COMP'){
				//4 passages with 5 questions each
				var num_passages=passages['num_passages'];
				var pass_count;
				for (pass_count=0;pass_count<(num_passages);pass_count++){
					//addPassage("READING_COMP",section_count,pass_count,passages[pass_count],ques_start_count);
					ques_end_count=displayReadingCompSection("READING_COMP",section_count,passages[pass_count],
											pass_count,ques_start_count);
					ques_start_count=ques_end_count;
				}
			} else if (section_name=='VERB_REASON'){
				//2 topics - synonyms and sentence completions
				var topic_count=1;
				$.each(topics,function(topic_name,trow){
					//console.log("Topic name=",topic_name, "TRow=",trow);
					if (trow['sectionId']==srow['sectionId']){
						displayTopicTitle(topic_name, trow, topic_count,section_count);					
						ques_end_count=displayVerbalSection(trow,srow['sectionId'],
									topic_name,srow['sectionNumChoices'],section_count,srow['sectionName'],ques_start_count);
						topic_count++;
						ques_start_count=ques_end_count;
					}
				});
			}
			//Add a Finish link for the section in non-review mode
			if (!test_review_mode) {
				addSectionFinish(section_count,srow['sectionId'],srow['sectionName']);
			}
			section_count++;
		}
	});
	if (test_review_mode) {
		addReturnButton();		
	}
}
/** 
* --------------------------------------------------------
  * Displays the English title for a testype
  *
  * @param {enum} ttype	Test type
  * @return {string} test title
* --------------------------------------------------------
**/
function displayTestTitle(ttype) {
	var title="";
	if (ttype='ISEE_LOW'){
		title="Practice Test<br/><br/> <b>ISEE</b><br/><i>Independent School Entrance Exam</i>";
		title += "<br/><br/>Lower Level<br/><br/>";
		$('#test_title').html(title).show();
	}
}
/** 
* --------------------------------------------------------
  * Displays the full section name as well
  * as details on how many questions,duration for section
  * and instrutions for section
  * @param {enum} ttype	section_name
  * @param {array} row details about this section
  * @param {int} section_count the sequence number for this section
  * @return void
* --------------------------------------------------------
**/
function displaySectionTitle(section_name, row,section_count) {
	var divid="";
	var html_str="";
	
	var sect_disp_name=getSectionDisplayName(section_name);
	addSectionDiv(section_count);
	//Display the title, duration, num questions and instructions for section
	html_str="<div id=sectiontitle"+section_count+">";
	html_str+="<hr><br/><p style='text-align: center'>Section "+section_count+"<br/><br/><b>"+sect_disp_name+"</b>";
	html_str+="</p><br/><hr> ";	
	html_str+="<p style='text-align: left'><b>"+row['sectionNumQuestions']+ " Questions</p>";
	html_str+="Time: "+row['sectionDuration']+" minutes</b>";
	html_str+="</p>";
	html_str+=row['sectionInstructions'];
	html_str+="</div>";
	divid="#section"+section_count;
	//console.log(divname);

	/** Just render it here and hide it. Control correct showing/hiding somewhere else**/
	$(divid).append(html_str).hide();
	return;
}
/** 
* --------------------------------------------------------
  * Adds a body div to each section - the passages, questions
  * are contained in the body - named "section<section count>_body"
  * @param {int} sect_count the sequence number for section
  * @return void
* --------------------------------------------------------
**/
function displaySectionBody(section_count) {
	var sec_body_div_html='<div id=section'+section_count+'_body style="display:none;"></div>';
	div_id="#section"+section_count;
	$(div_id).append(sec_body_div_html);
	return;
}

/** 
* --------------------------------------------------------
  * Displays topic specific instructions if there are any
  * In some cases, there are no instructions
  * @param {enum} ttype topic_name
  * @param {array} row details about this topic
  * @param {int} topic_count the sequence number for this topic
  * @param {int} sect_count the sequence number for section
  * @return void
* --------------------------------------------------------
**/
function displayTopicTitle(topic_name,row,topic_count,sect_count) {

	var divname="";
	var classname="";
	var sect_div="";
	var html_str="";
	//First create and append a div for this topic
	sec_div="#section"+sect_count+"_body";
	classname="section"+sect_count;
	divname="\"part-"+topic_name+"\"";
	html_str="<div id="+divname+" class="+classname+">";//do we have to do this each time?check Maya Jan 13
	if (row['topicInstructions']) {
		html_str +="<p style='text-align: center'><b>Part "+topic_count+"--"+topic_name+"</b></p><br/>";
		html_str+="<b>Directions: </b>"+row['topicInstructions']+"</br><hr>";
	}
	html_str += "</div>";
	//console.log(html_str, sec_div);
	/** Just render it here and hide it. Control correct showing/hiding somewhere else**/
	$(sec_div).append(html_str).hide();

	return;
}
/** 
* --------------------------------------------------------
  * Display question with multiple choices and radio buttons
  * @param {int} 	qnum			sequence number of question
  * @param {string} question 		Body of question
  * @param {int} 	qid				question id
  * @param {array} 	mult_choices	Array of multiple choice answers
  * @param {int} 	top_div			name of div to display in
  * @param {int} 	section_name	name of section we're in
  * @param {char} 	q_caid			correct answer id (for review mode only); 0 otherwise
  * @return void					displays question w/ multiple answer choices
* --------------------------------------------------------
**/
function displayQuestion(qnum,question,qid,mult_choices,top_div,section_name,q_caid) {
	var html_str="";
	var count=["A","B","C","D","E","F"];
	var i;
	var grp_name="";
	var check_mark="";
	var color_str="";
	var check_mark_flag;//flag to track if ew've already added checkmark for question
	var color_flag;//flag to track if ew've already added colored the submitted response

	var sques= cleanUpHtmlString(question,section_name,0);
	grp_name="question-"+qid+"-group";
	html_str="<br/><b>"+qnum+". "+sques+"</b></br><br/>";
	check_mark_flag=0;
	color_flag=0;
	
	for (i=0; i<mult_choices.length; i++){
		html_str +='<input type="radio" name="'+grp_name+'" value="' + mult_choices[i]['id'];
		html_str +='"qid="'+qid+'"sec="'+section_name+ '" />';
		html_str +="   <b>"+count[i]+"</b>. ";
		if (test_review_mode && (color_flag==0)) {
			color_str=colorSubmittedChoice(qid,mult_choices[i]['id'],mult_choices[i]['value']);
			if (color_str) {
				html_str+=color_str;
				color_flag=1;
			} else if (!color_str){
				html_str+=mult_choices[i]['value'];
			}
		} else {
			html_str +=mult_choices[i]['value'];
		}
		if (test_review_mode && (check_mark_flag==0)){
			check_mark +=addCheckMark(qid,mult_choices[i]['id'],q_caid);
			if (check_mark) {
				html_str+=check_mark;
				check_mark_flag=1;
			}
		}
		html_str +='<br/>';
	}
	/** Just render it here and hide it. Control correct showing/hiding somewhere else**/
	$(top_div).append(html_str).hide;
}
/** 
* --------------------------------------------------------
  * Display body of passage for reading comp section
  * @param {int} 	scount			sequence number of section
  * @param {int} 	passcount		sequence number of passage
  * @param {array} 	pass_row		Array with passage details (see passages table)
  * @param {int} 	q_start			sequence number of first question here
  * @return void					displays passage
* --------------------------------------------------------
**/
//function displayPassage(tname,scount,passcount,pass_row,q_start){	
function displayPassage(scount,passcount,pass_row,q_start){	
	
	var html_str="";
	var pdiv_id="";
	var q_end=q_start+4;//each passage has 5 questions - Hard code or read? Maya Jan '13
	var sec_id="#section"+scount+"_body";
	
	pdiv_id="#passage"+passcount;
	html_str="<div id=passage"+passcount+"></div>";
	$(sec_id).append(html_str);
	html_str="<br/><br/><br/>";
	html_str+="<u>Questions "+q_start+"-"+q_end+"</u>";
	html_str+="<br/><br/>"
	html_str+=cleanUpHtmlString(pass_row['passage'],0);	
	html_str+"<br/><br/>";
	/** Just render it here and hide it. Control correct showing/hiding somewhere else**/
	$(pdiv_id).html(html_str).hide();
}
/** 
* --------------------------------------------------------
  * Construct and display question & choices for verbal section
  * @param {array} 	row				question details
  * @param {uuid} 	sect_id			uuid for this section
  * @param {enum} 	cur_topic		current topic
  * @param {int} 	num_choices		Number of multiple choices
  * @param {int} 	sec_count		sequence number of this section
  * @param {string} sect_name		name of section we're in
  * @param {int} 	q_count			sequence number of next question
  * @return {int}	cur_q_count		sequence number of next question to be displayed
* --------------------------------------------------------
**/
function displayVerbalSection(row,sect_id,cur_topic,num_choices,sec_count,sect_name,q_count) {
	var cur_question="";
	var cur_q_count=q_count; //initialize the question sequence count with the starting val
	var choices="";
	var tmp=1;
	var div_id="";
	div_id="#part-"+cur_topic;
	var caid;
	
	$.each(questions, function(qarr_index,qrow) {
		//console.log("key=",qarr_index,"qrow=",qrow);
		if ((questions[qarr_index]['sectionId']==sect_id)&&(questions[qarr_index]['questionTopic']==cur_topic)){
			cur_question=questions[qarr_index]['question'];
			//console.log("question in topic",cur_question);
			choices=getAnswerChoices(questions[qarr_index]['questionId'],num_choices,sect_name);
			//Now that you have the question and the multiple choices, display the radio button
			if (test_review_mode) {
				caid=questions[qarr_index]['correctAnswerId'];
			} else {
				caid=0;
			}
			displayQuestion(cur_q_count,cur_question,questions[qarr_index]['questionId'],choices,div_id,sect_name,caid);
			cur_q_count++;
		}	
	});	
	return cur_q_count;
}
/** 
* --------------------------------------------------------
  * Construct and display passages, question & choices for reading comp section
  * @param {string} sect_name		name of section we're in
  * @param {int} 	sec_count		sequence number of this section
  * @param {array} 	pass_row		passage & its question details
  * @param {int} 	pass_count		sequence number of this passage
  * @param {int} 	q_count			sequence number of next question
  * @return {int}	cur_q_count		sequence number of next question to be displayed
* --------------------------------------------------------
**/
function displayReadingCompSection(sect_name,sect_count,pass_row,pass_count,q_count) {
	var div_id="#passage"+pass_count;
	//For each of the questions associated w/ passage - get question from questions[]
	//and display
	var num_qs=pass_row['num_questions'];
	var q_index="";
	var i;
	var cur_question="";
	var cur_q_count=q_count; //initialize the question sequence count with the starting val
	var caid;
	
	displayPassage(sect_count,pass_count,passages[pass_count],q_count);
	for (i=1;i<(num_qs+1);i++) {
		q_index="q"+i;
		$.each(questions, function(qarr_index,qrow) {
			if (questions[qarr_index]['questionTopic']=="READING_COMP") {
				if(questions[qarr_index]['questionId']==pass_row[q_index]){
					cur_question=questions[qarr_index]['question'];
					//console.log("question in topic",cur_question);
					choices=getAnswerChoices(questions[qarr_index]['questionId'],4,"READING_COMP");//need to fix
					//Now that you have the question and the multiple choices, display the radio button
					if (test_review_mode) {
						caid=questions[qarr_index]['correctAnswerId'];
					} else {
						caid=0;
					}
					displayQuestion(cur_q_count,cur_question,questions[qarr_index]['questionId'],
																	choices,div_id,"READING_COMP",caid);
					cur_q_count++;
				}
			}
		});
	}
	return cur_q_count;
}
/** 
* --------------------------------------------------------
  * Construct and display question & choices for quant section
  * @param {uuid} 	sect_id			uuid for this section
  * @param {int} 	num_choices		Number of multiple choices
  * @param {int} 	sec_count		sequence number of this section
  * @param {string} sect_name		name of section we're in
  * @param {int} 	q_count			sequence number of next question
  * @return {int}	cur_q_count		sequence number of next question to be displayed
* --------------------------------------------------------
**/
function displayMathSection(sect_id,num_choices,sec_count,sect_name,q_count) {
	var cur_question="";
	var q_array=new Array();
	var count=0;
	var div_id="#section"+sec_count;
	var cur_q_count=q_count; //initialize the question sequence count with the starting val
	var choices="";	
	var caid;
	//First make up an array with all the questions in this section
	$.each(questions, function(qarr_index,qrow) {
		//console.log("key=",qarr_index,"qrow=",qrow);
		if ((questions[qarr_index]['sectionId']==sect_id)){
			//console.log("question in topic",cur_question);
			q_array[count]=questions[qarr_index];
			count++;
		}	
	});
	//Now let's shuffle this array so that we mix up the various topics
	q_array=shuffle(q_array);
	//now we compose the html
	$.each(q_array, function(qarr_index,qrow){
		//console.log("key=",qarr_index," value=",q_array[qarr_index]);
		cur_question=qrow['question'];
		choices=getAnswerChoices(qrow['questionId'],num_choices,sect_name);
		//Now that you have the question and the multiple choices, display the radio button
		//If you are in review mode, then you'l have the correct answer id
		if (test_review_mode) {
			caid=q_array[qarr_index]['correctAnswerId'];
		} else {
			caid=0;
		}
		//displayQuestion(cur_q_count,cur_question,qrow['questionId'],choices,div_id,sect_name,caid);
		displayQuestion(cur_q_count,cur_question,qrow['questionId'],choices,(div_id+"_body"),sect_name,caid);
		
		cur_q_count++;
	});
	return cur_q_count;
}
function displayTimer() {
	var html_str="";
	var sec_div="#sectiontitle"+cur_section;

	if($("#timer").length != 0) {
		$("#timer").remove();	
	}
	if($('#control').length !=0) {
		$('#control').remove();
	}
	html_str+='<br/><br/>';
	html_str+='<div id="timer" class="timer">';
	html_str+= '<span class="minute">00</span>:<span class="second">00</span>';
	html_str+= '</div>';
	html_str+= '<div id="control" class="control" >';
	html_str+= '<button id="timer_start_btn" >Start Section</button>';
	html_str+= '<button id="timer_stop_btn">Pause</button>';
	html_str+= '</div>';
	$(sec_div).append(html_str).show();
	timerReset(timer_init_time);
}

