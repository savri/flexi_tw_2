<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
-----------------------------------------------------------------------------------
/ Testwell constants- I'm sure it needs to move to it's own file. but will do for now
-----------------------------------------------------------------------------------
*/
define('TWELL_Q_BANK_TBL','question_bank');
define('TWELL_ANS_TBL','answers');
define('TWELL_GEN_TESTS_TBL','generated_tests');
define('TWELL_GEN_TESTS_PASS_TBL','generated_tests_passages');
define('TWELL_PASS_TBL','passages');
define('TWELL_PASS_Q_TBL','passage_questions');
define('TWELL_SUB_ANS_TBL','submitted_answers');
define('TWELL_TEST_TAKE_TBL','tests_taken');
define('TWELL_SECT_META_TBL','test_section_metadata');
define('TWELL_TOP_META_TBL','test_topic_metadata');
define('TWELL_FAM_PROF_TBL','family_profile');
define('TWELL_STU_PROF_TBL','student_profile');




/* End of file constants.php */
/* Location: ./application/config/constants.php */