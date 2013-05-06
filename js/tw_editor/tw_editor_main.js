/** 
* --------------------------------------------------------
  * tw_editor_main.js 
  * Launch point for app to add/edit questions in the bank
  * Location: 'CI-top'/js/tw_editor/tw_editor_main.js
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/views/includes/tw_editor_header.php
  *
* --------------------------------------------------------
**/
var first_time=0;
$(document).ready(function() {	
	
	//Register event handlers
	register_event_handlers();	
	if (!first_time) {
		$('#qa_ret_div').hide();
		first_time=1;
	}        
});


