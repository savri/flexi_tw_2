function assembleTest(test_data,test_type){
	sections=test_data['sections'];
	topics=test_data['topics'];
	questions=test_data['questions'];
	answers=test_data['choices'];
	passages=test_data['passages'];
	cur_test_id=test_data['cur_test_id'];
	
	var section_count=1;
	var topic_count;
	var sect_disp_name;
	var ques_start_count=1;
	var ques_end_count=1;

	if (test_review_mode) {
		submitted_ans=test_data['submitted_answers'];
	}
	//recordAnswerChoice('CREATE',questions.length,0,0,0,0);
	retrieveTestTitle(test_type);
	$.each(sections,function(section_name,srow){
		//console.log("Section Id=",section_name, "Row=",srow);
		topic_count=1;
		ques_start_count=1;
		ques_end_count=1;
		if (parseInt(srow['sectionNumQuestions'])){
			sect_disp_name=retrieveSectionDisplayName(section_name);
			addSectionDiv(section_count);
			retrieveSectionTitle(sect_disp_name, srow,section_count);
			//Need to handle reading comprehension w/ passage differently
			$.each(topics,function(topic_name,trow){
				//console.log("Topic name=",topic_name, "TRow=",trow);
				if (trow['sectionId']==srow['sectionId']){
					retrieveTopicTitle(topic_name, trow, topic_count,section_count);
					if (trow['topicInstructions']) {
						ques_start_count=1;
					}else {
						ques_start_count=ques_end_count;
					}
					//Need to handle reading comprehension w/ passage differently
					if (section_name=='READING_COMP'){
						var num_passages=passages[0];
						var pass_count;
						for (pass_count=1;pass_count<(num_passages+1);pass_count++){
							addPassage(topic_name,pass_count,passages[pass_count],ques_start_count);
							ques_end_count=retrievePassageQuestionsAndChoices(passages[pass_count],
													pass_count,ques_start_count);
							ques_start_count=ques_end_count;
						}
					} else {
						ques_end_count=retrieveQuestionsAndChoices(trow,srow['sectionId'],
									topic_name,srow['sectionNumChoices'],section_count,srow['sectionName'],ques_start_count);
					}
					
					topic_count++;
				}
			});
			//Add a Finish link for the section in non-review mode
			if (!test_review_mode) {
				addSectionFinish(section_count,srow['sectionId'],srow['sectionName']);
			}
			section_count++;
		}
	});
	total_num_sections=section_count-1;
	if (test_review_mode) {
		addReturnButton();
	}
}
function processGenerateNewTest(rval,test_type) {
	if (rval.status) {
		//console.log("got test\n");
		//recordTestDetails(output.test_data);
		clearSummary();
		assembleTest(rval.test_data,test_type);
		showSection(1);//we always display the firstsection in a new test
	} else {
		console.log("get_sections failed\n");
	}
}
function generateNewTest(user_id,test_type) {
	var form_data;
	//console.log("Testtype="+test_type);
	form_data='userId='+user_id+'&testType='+test_type;
	$.ajax({
        url: global_siteurl+'/testwell/testwell/get_new_test',
        data: form_data,
        dataType: 'json',
        type: 'post',
        success: function (ret_val) {   
			processGenerateNewTest(ret_val,test_type);
        }
    });
}
