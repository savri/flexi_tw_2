/** 
* --------------------------------------------------------
  * testwell_main.js 
  * Launch point for app
  * Currently only has the test summary; but will need to 
  * to have the analysis section and others as well - Maya Jan '13
  * Location: 'CI-top'/js/testwell
  * All the Javascript files are included in the header file located
  * at: 'CI-top'/views/includes/testwell/header.php
  *
* --------------------------------------------------------
**/
//This is the main() for the program
$(document).ready(function() {
	//Register all event handlers in testwell
	//with delegate you can register them even before they are created
	registerEventHandlers();
	checkUserLoggedIn();
});