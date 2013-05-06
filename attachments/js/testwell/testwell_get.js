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