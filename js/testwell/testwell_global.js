//global variables for this session

//Submitted answers table; Size allocation happens when I know how 
//many questions in the test. Updated on each click
var submitted_ans=new Array();
var num_qs_answered=0;//needs to be reset for each section
var sections="";
var topics="";
var questions="";
var answers="";
var question_index=0;//may be able to get rid of it
var total_num_sections=0;
var cur_test_id=0;//identified for the current test
var cur_test_type='ISEE_LOW';
var test_review_mode=false;

//Session management related globals
var is_logged_in=false;
var sess_data=new Array();

//Timed test related globals
var timer=new _timer(
    function(time) {
      if(time == 0) {
          timerRanOut();
      }
    }
);
var timed_test_mode=false;
var timer_start_flag=false;//To track if they are starting or resuming the timer after pause
var timer_init_time=0;//When you resume/start a test where you start counting from - maybe able to get rid of this global --Maya
var cur_section;//section currently being displayed;=1 for a new test;
var section_duration=new Array();