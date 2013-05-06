/** 
* --------------------------------------------------------
* --------------------------------------------------------
  * testwell_account_admin.js 
  * Routines to handle user account admin functions
  * Location: 'CI-top'/js/testwell
  *
* --------------------------------------------------------
* --------------------------------------------------------
**/
/** 
* --------------------------------------------------------
  * Routine to change the user's password on demand and send 
  * email; 
  * if form_flag is set, just display the change password form
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function changePassword(form_flag){
	var form_data="";
	if (form_flag==0) {
		//we need to fetch the form to display
		dType="html";
		form_data='form_flag='+form_flag;
	} else {
		//Get the changed pw inputs from form
		dType="json";
		if( $("#current_password").length )
				var cur_pw=$('#current_password').val();
		if( $("#new_password").length )
				var new_pw= $('#new_password').val();
		if( $("#confirm_new_password").length )
		 		var conf_pw=$('#confirm_new_password').val();
		var form_data = 'form_flag='+form_flag+'&current_password='+ cur_pw+'&new_password='+new_pw+
								'&confirm_new_password='+conf_pw;
	}
	$.ajax({
        url: global_siteurl+'/testwell/testwell/change_password',
        data: form_data,
		dataType: dType,
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processChangePassword(form_flag,retval);
        }
    });
}
/** 
* --------------------------------------------------------
  * Routine to change the user's password on demand and send 
  * email; 
  * if form_flag is set, just display the change password form
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function processChangePassword(fflag,output) {
	if (fflag==0){
		//$('#test_sections').html("");
		$('#account_admin_div').html(output).hide();
		$("#pw_change_dialog").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 1200,
			 buttons: [{
				id:"pw-update-btn",
				text:"Update",
				click: function() {
					changePassword(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "close" );
				}
			}]
		});
	} else {
		if (output.status){
			$('#pw_change_message').html(output.message).show();
			
		} else {
			$('#pw_change_message').html(output.message).show();
		}
	}
}
/** 
* --------------------------------------------------------
  * Routine to display the populated form with the user's account details
  * Which they can change 
  * if form_flag is set, just display the form; else, make the update
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function accountUpdate(form_flag){
	var f_data="";
	if (form_flag==0) {
		//we need to fetch the form to display
		dType="html";
		f_data='form_flag='+form_flag;
	} else {
		var userType=getCurrentUserType();
		dType="json";
		var fdata=get_form_data(userType,form_flag);
	}
	$.ajax({
        url: global_siteurl+'/testwell/testwell/account_update',
        data: fdata,
		dataType: dType,
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processAccountUpdate(form_flag,retval);
        }
    });	
}
/** 
* --------------------------------------------------------
  * Routine to change the user's password on demand and send 
  * email; 
  * if form_flag is set, just display the change password form
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function processAccountUpdate(fflag,output) {
	if (fflag==0){
		//$('#test_sections').html("");
		$('#account_admin_div').html(output).hide();
		$("#account_update").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 1200,
			 buttons: [{
				id:"ac-update-btn",
				text:"Update",
				click: function() {
					accountUpdate(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "close" );
				}
			}]
		});
	} else {
		if (output.status){
			$('#account_message').html(output.message).show();
			
		} else {
			$('#account_message').html(output.message).show();
		}
	}
}
/** 
* --------------------------------------------------------
  * Utility routine to fill out the data string from the form values
  * depending on parent/student role
  * Location: 'CI-top'/js/testwell
  *
  * @return string fdata        
* --------------------------------------------------------
**/
function get_form_data(user_type,form_flag){
	if (user_type=='Parent'){
		var fdata='form_flag='+form_flag+'&update_p_f_name='+$('#p_f_name').val();
		fdata+='&update_p_l_name='+$('#p_l_name').val();
		fdata+='&update_add_line_1='+$('#add_line_1').val();
		fdata+='&update_add_line_2='+$('#add_line_2').val();
		fdata+='&update_city='+$('#city').val();
		fdata+='&update_state='+$('#state').val();
		fdata+='&update_zip='+$('#zip').val();
		fdata+='&update_ph_number='+$('#ph_number').val();
		fdata+='&update_pri_p_email='+$('#pri_p_email').val();
		if ($('#alt_p_email').length)
			fdata+='&update_alt_p_email='+$('#alt_p_email').val();
		else
			fdata+='&update_alt_p_email='+"";
	} else if (user_type=='Student'){
		var fdata='form_flag='+form_flag+'&update_s_f_name='+$('#s_f_name').val();
		fdata+='&update_s_l_name='+$('#s_l_name').val();
		fdata+='&update_s_grade='+$('#s_grade').val();
		fdata+='&update_s_email='+$('#s_email').val();
	}
	return fdata;
}