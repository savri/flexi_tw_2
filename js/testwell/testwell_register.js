function registerUser(form_data,register_user) {
			var dtype='';
			if (register_user==0) {//form only
				dtype='html';
			} else {
				dtype='json';//registration data
			}
			$.ajax({
		        url: global_siteurl+'/testwell/testwell/register_account',
		        data: form_data,
				type: 'POST',
				dataType: dtype,
		        success: function (retval) {   
					//alert(retval);
					processRegisterUser(retval,register_user);
		        },
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
				        alert("Status: " + textStatus); alert("Error: " + errorThrown);
				}
		    });
}
function processRegisterUser(output,reg_user) {
	if (reg_user==0) {//reg_user=0 --display form
		$('#test_status').empty();
		$('#test_sections').empty().html(output).show();
	} else {
		if (output.status) {
			$('#register_body').empty();
			//$('#login_dive').hide();
			scrollToTop('#register_message');
			$('#register_message').html("Registration successful!");
			$('#register_message').append(output.message).show();
			
		} else {
			scrollToTop('#register_message');
			$('#register_message').html(output.message).show();
		}
	}		
}
/** 
* --------------------------------------------------------
  * Routine to register alt parent email after initial set up
  * of account
  * if form_flag is set, just display the add alt parent form
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function registerAltParent(form_flag){
	var f_data="";
	if (form_flag==0) {
		//we need to fetch the form to display
		dType="html";
		f_data='form_flag='+form_flag;
	} else {
		//var userType=getCurrentUserType();
		dType="json";
		f_data='form_flag='+form_flag+'&reg_alt_p_email='+$('#reg_alt_p_email').val();
		//console.log("fdata= "+f_data);
	}
	$.ajax({
        url: global_siteurl+'/testwell/testwell/register_alt_parent',
        data: f_data,
		dataType: dType,
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processRegisterAltParent(form_flag,retval);
        }
    });	
}
/** 
* --------------------------------------------------------
  * Routine to register alt parent email after initial set up
  * of account
  * if form_flag is set, just display the add alt parent form
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function processRegisterAltParent(fflag,output) {
	if (fflag==0){
		//$('#test_sections').html("");
		$('#account_admin_div').html(output).hide();
		$("#add_alt_form").dialog({
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
				id:"reg-alt-btn",
				text:"Update",
				click: function() {
					registerAltParent(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "close" );
				}
			}]
		});
	} else {
		$('#account_message_alt').html("");
		
		if (output.status){
			
			$('#account_message_alt').append("<b>"+output.message+"</b>").show();
			
		} else {
			$('#account_message_alt').append(output.message).show();
		}
	}
	
}