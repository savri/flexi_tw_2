/** 
* =================================================================
  * tw_editor_utils.js 
  * Useful utility routines used for tw_editor
  * at: 'CI-top'/application/views/includes/tw_editor_header.php
  * Location: CI-top'/js/tw_editor/tw_editor_utils.js
* =================================================================
**/

/**
* ----------------------------------------------------------
* function to trim out trailing spaces as well as the the leading
* <p> tag and the trailing </p> tag. 
*
* @param {string}	html	Html string to clean up
* @param {int}		offset	number of characters to slice off at end of string
*
* @return {string}  strip_html	returns cleaned up string
* ----------------------------------------------------------
*/
function strip(html,offset) {
	//Trim trailing spaces
	html=html.trim();
	//strip the <p> at start 
	strip_html=html.slice(3);
	//console.log(strip_html);
	//strip the </p> at the end
	//strip_html=strip_html.slice(0,-6);
	strip_html=strip_html.slice(0,(offset));
	//console.log(strip_html);
	return strip_html;
}