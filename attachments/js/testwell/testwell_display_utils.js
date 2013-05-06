/** 
* --------------------------------------------------------
  * testwell_display_utils.js 
  * Handy functions for manipulating UI elements, controlling visibility
  * and beautifying html strings
  * Location: 'CI-top'/js/testwell
  *
* --------------------------------------------------------
**/

/** ========================================================
* Utility routines clean up html strings
* ========================================================
*/
/** 
* --------------------------------------------------------
  * handy function to strip out the <p> tag in the question 
  * so that it lines up with the checkbox
  * @param {string} 	html_str	html string with body of a question 
  * @return {string}  	strip_html	html string with the <p> tags removed				
* --------------------------------------------------------
**/
function strip(html_str) {
	//strip the <p> at start 
	strip_html=html_str.slice(3);
	//console.log(strip_html);
	//strip the </p> at the end
	strip_html=strip_html.slice(0,-4);
	//console.log(strip_html);
	return strip_html;
}
/** 
* --------------------------------------------------------
  * Clean an html string of newlines, line breaks 
  * so that it lines up with the checkbox. The clean up required
  * differs between section
  * @param {string} 		html_str		html string to be cleaned
  * @param {enum string} 	section_name 	Section in which string occurs
  * @param {bool} 			br_flag	 		Flag to decide if we remove </br>
  * @return {string}  		html_str		cleaned up html string				
* --------------------------------------------------------
**/
function cleanUpHtmlString(html_str,section_name,break_flag){
	//Remove new line in string
	html_str=html_str.replace(/(\r\n|\n|\r)/gm," ");
	//replace 2 spaces with one
	if (section_name!='QUANT_REASON')
		html_str = html_str.replace(/\s+/g," ");
	//Remove first and last <p> and </p> tag
	html_str=html_str.substring(html_str.indexOf('>') + 1, html_str.lastIndexOf('<'));
	if ((section_name=='VERB_REASON')||break_flag) {
		//Remove any </br> in string
		html_str=html_str.replace(/<br \/>/g,"");
	}
	return html_str;
}

/** 
* --------------------------------------------------------
  * Utility function to shuffle content of an array
  *
  * @param {array} 			arr	 	array to be shuffled
  * @return {string}  		arr		array with content randomly shuffled				
* --------------------------------------------------------
**/
function shuffle(arr) {
    var tmp, current, top = arr.length;
    if(top) while(--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = arr[current];
        arr[current] = arr[top];
        arr[top] = tmp;
    }
    return arr;
}
/*
* ========================================================
* Utility routines to add html artifacts to the view.
* ========================================================
*/

/** 
* --------------------------------------------------------
  * Create a div for this section
  * @param {int} 	scount		sequence number for this section 
  * @return void	Div named "section<scount>" created and appended to main test_sections div				
* --------------------------------------------------------
**/
function addSectionDiv(scount){
	var html_str="";
	html_str="<div id=section"+scount+"></div>";
	//Just render it; control correct showing/hiding somewhere else
	$('#test_sections').append(html_str).hide();
}
/** 
* --------------------------------------------------------
  * Add a button at the end of each section to signal completion
  * of the section
  * @param {int} 	sec_count		sequence number for this section 
  * @param {int} 	sid				uuid identifier for this section 
  * @param {string} sname			section name 
  * @return void					Section finish button appended to this section's div
* --------------------------------------------------------
**/
function addSectionFinish(sec_count,sid,sname) {
	var sec_div_id="#section"+sec_count;
	var finish_button_id
	var html_str="";
	
	finish_button_id="finish-btn-"+sec_count;
	html_str= '<br/><input type="button" class="secfinbtn" value="Finish Section"';
	html_str+= ' id='+finish_button_id+' sid='+sid+' sname='+sname+' scount='+sec_count+'>';
	//Just render it; Control correct hide/showing somewhere else
	$(sec_div_id).append(html_str).hide();	
}
/** 
* --------------------------------------------------------
  * Add a button at the end of test review to return to main menu
  * @return void					Return button appended to this main test_sections div
* --------------------------------------------------------
**/
function addReturnButton(){
	var html_str="";
	html_str= '<input type="button" value="Return"';
	html_str+= ' class=returnbtn>';
	//Just render it; Control correct hide/showing somewhere else
	$('#test_sections').append(html_str).hide();
}
/** 
* ========================================================
  * Utility routines to control viewing of divs.
* ========================================================
**/
/** 
* --------------------------------------------------------
  * Scroll to the start of the specified section
  * @return void				
* --------------------------------------------------------
**/
function scrollToTop(sec_div) {
	//$('html, body').animate({scrollTop:$('#test_sections').offset().top - 20}, 'slow');
	$('html, body').animate({scrollTop:$(sec_div).offset().top - 20}, 'slow');
	
}
/** 
* --------------------------------------------------------
  * Makes section visible 
  *
  * @param {int} sec_count	sequence numeber of this section
  * @return void			sets section div identified by "section<sec_count>"	
  * 							to visible
* --------------------------------------------------------
**/
function showSection(sec_count) {
	var sec_div_id="#section"+sec_count;
	//If we're in review mode, show the section w/o question
	//If not, make sure we have not overshot
	if ((sec_count <= total_num_sections)||(test_review_mode)){
		//Make this section and its children visible
		//Make sure the parent is also visible
		$(sec_div_id).show().parent().show()
		$(sec_div_id).children().show();
		scrollToTop(sec_div_id);
		 //$(this).siblings(sec_div_id).show();
	} else{
		alert("Test complete! You're all done\n");
		clearTest();
		getTestsForStudent(sess_data['user_id']);
	}
}
/** 
* --------------------------------------------------------
  * Hides this section 
  *
  * @param {int} sec_count	sequence numeber of this section
  * @return void			sets section div identified by "section<sec_count>"	
  * 							to invisible
* --------------------------------------------------------
**/
function hideSection(sec_count) {
	var sec_div_id="#section"+sec_count;
	$(sec_div_id).hide().children().hide();
}
/** 
* --------------------------------------------------------
  * Makes next sequential section visible 
  *
  * @param {int} sec_count	sequence numeber of this section
  * @return void			hides current section; makes next one
  * 							in sequence visible
* --------------------------------------------------------
**/
function showNextSection(sec) {
	//Hide this section & show the next one in line
	hideSection(sec);
	var next_sec=Number(sec)+1;
	showSection(next_sec);
}
/** 
* --------------------------------------------------------
  * Pair of functions to make all test sections visible/invisible
  *
  * @return void		all sections in test are visible/visible
* --------------------------------------------------------
**/
function showAllSections() {
	$('#test_sections').show().children().show();;	
	$('#test_sections').children().children().show();//show children of children
}
function hideAllSections() {
	$('#test_sections').hide().children().hide();
}
/** 
* --------------------------------------------------------
  * Pair of functions to make summary view of user's tests 
  * portal view visible/invisible
  *
  * @return void		all sections in test are visible/invisible
* --------------------------------------------------------
**/
function showSummary(){
	$('#test_status').show().children().show();
}
function hideSummary(){
	$('#test_status').hide().children().hide();
}
/** 
* --------------------------------------------------------
  * Function to empty out the contents of the summary view
  * @return void			summary view contents deleted
* --------------------------------------------------------
**/
function clearSummary(){
	if ($('#test_status').length!=0) {
		$('#test_status').empty();
	}	
}
/** 
* --------------------------------------------------------
  * Function to empty out the contents of the test view
  * @return void			test view contents deleted
* --------------------------------------------------------
**/
function clearTest(){
	if ($('#test_sections').length!=0) {
		$('#test_sections').empty();
	}	
}
/** 
* --------------------------------------------------------
  * Function to empty out the contents of entire view
  * @return void			all contents deleted
* --------------------------------------------------------
**/
function clearAll() {
	clearSummary();
	clearLogout();
	clearTest();
}
/**
function showTest() {
	$('#test_sections').show().children().show();
}
function hideTest() {
	$('#test_sections').hide().children().hide();
}
**/

function showLogout(){
	if ($('#logout').length!=0) {
		$('#logout').show();
	}	
}
function hideLogout(){
	if ($('#logout').length!=0) {
		$('#logout').hide();
	}	
}
function showLogin(){
	if ($('#login').length!=0) {
		$('#login').show();
	}	
}
function hideLogin(){
	if ($('#login').length!=0) {
		$('#login').hide();
	}	
}
/**
*==========================================================
* Functions to help with UI interactions - radio buttons
*==========================================================
*/
/**
*----------------------------------------------------------
* Routine used in review mode to mark the questions
* with the answer selected by the user
* And in future, mark the correct answer as well --MAya Jan '13
*
* @param {array} submit_ans  Array of submitted answerIds for this test
* @return void
*----------------------------------------------------------
*/
function selectSubmittedAnswers(submit_ans) {
	//console.log(submit_ans);
	$.each(submit_ans,function(key,row) {
		var radio_btn_val="";
		radio_btn_val='input[value='+row['answerId']+']';
		//console.log(radio_btn_val);
		//$('input[value=radio_btn_val').prop('checked', true);
		$(radio_btn_val).prop('checked', true);
		num_qs_answered++;
	});
}
/**
*----------------------------------------------------------
* Routine used in review mode disable all the radio buttons
*
* @return void
*----------------------------------------------------------
*/
function disableRadioButtons() {
	    //$("#test-sections input[type=radio]").attr('disabled',true);
		$('input[type=radio]').attr('disabled', 'disabled');
}


