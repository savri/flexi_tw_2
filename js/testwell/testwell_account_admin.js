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
		form_data = 'form_flag='+form_flag+'&current_password='+ cur_pw+'&new_password='+new_pw+
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
		$('#account_admin_div').html(output).show();
		$("#pw_chg_form").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 800,
			 buttons: [{
				id:"pw-update-btn",
				text:"Update",
				click: function() {
					changePassword(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "destroy" );
						$("#pw_chg_form").remove();
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
function updateUserAccount(form_flag){
	var fdata="";
	if (form_flag==0) {
		//we need to fetch the form to display
		dType="html";
		fdata='form_flag='+form_flag;
	} else {
		var userType=getCurrentUserType();
		dType="json";
		fdata=get_user_ac_form_data(userType,form_flag);
	}
	$.ajax({
        url: global_siteurl+'/testwell/testwell/update_user_account',
        data: fdata,
		dataType: dType,
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processUpdateUserAccount(form_flag,retval);
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
function processUpdateUserAccount(fflag,output) {
	if (fflag==0){
		//$('#test_sections').html("");
		$('#account_admin_div').html(output).hide();
		$("#account_update_form").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 800,
			 buttons: [{
				id:"ac-update-btn",
				text:"Update",
				click: function() {
					updateUserAccount(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "destroy" );
						$('#account_update_form').remove();
				}
			}]
		});
	} else {
		if (output.status){
			$('#account_message').html(output.message).show();
			
		} else {
			$('#account_message').html(output.message).show();
		}
		scrollToTop('#account_message');
	}
}
/** 
* --------------------------------------------------------
  * Routine to display form for parent to add a child to the 
  * family account and register them
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function registerChild(form_flag){
	var fdata="";
	if (form_flag==0) {
		//we need to fetch the form to display
		dType="html";
		fdata='form_flag='+form_flag;
	} else {
		//var userType=getCurrentUserType();
		dType="json";
		fdata='form_flag='+form_flag;
		fdata+='&register_s_f_name='+$('#register_s_f_name').val();
		fdata+='&register_s_l_name='+$('#register_s_l_name').val();
		fdata+='&register_s_email='+$('#register_s_email').val();
		fdata+='&register_s_grade='+$('#register_s_grade').val();
		fdata+='&register_s_ttype='+$('#register_s_ttype').val();
	}
	$.ajax({
        url: global_siteurl+'/testwell/testwell/register_child',
        data: fdata,
		dataType: dType,
		type: 'post',
        success: function (retval) {   
			//alert(retval);
			processRegisterChild(form_flag,retval);
        }
    });	
}
/** 
* --------------------------------------------------------
  * Routine to process adding child info
  * if form_flag is set, just display the change password form
  * if not, report success or failure of adding child
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function processRegisterChild(fflag,output) {
	if (fflag==0){
		$('#account_admin_div').html(output).hide();
		$("#reg_child_form").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 800,
			 buttons: [{
				id:"add_child-btn",
				text:"Add",
				click: function() {
					registerChild(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "destroy" );
						$('#reg_child_form').remove();
				}
			}]
		});
	} else {
		if (output.status){
			$('#register_child_message').html(output.message).show();
			
		} else {
			$('#register_child_message').html(output.message).show();
		}
		//scrollToTop('#account_message');
	}
}
/** 
* --------------------------------------------------------
  * Routine to present children's account details for parent
  * to update
  * if form_flag is set, just display the filled outform; else, make the update
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function updateChildrenAccount(form_flag){
	var fdata="";
	if (form_flag==0) {

		getChildrenData();
		displayChildrenData();
		$("#children_ac_form").dialog({
		    closeOnEscape: false,
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			modal: true,
		    draggable: true,
		    resizable: true,
		    position: ['center', 'center'],
		    show: 'blind',
		    hide: 'blind',
		    width: 800,
			 buttons: [{
				id:"child-ac-update-btn",
				text:"Update",
				click: function() {
					updateChildrenAccount(1);
				}},{
				text:"Cancel",
				click: function() {
						$( this).dialog( "destroy" );
						$("#children_ac_form").remove();
				}
			}]
		});
		
	} else {
		dType="json";
		//Number of children = length of chidata array which has info on all of them
		fdata=get_children_ac_form_data();
		updateChildrenData(fdata);
	}
}
/** 
* --------------------------------------------------------
  * Routine to process children account data
  * if form_flag is set, just display the form with filled in
  * fields for each child
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function processUpdateChildrenAccount(fflag,output) {
	if (fflag==1) {
		console.log("Success"+output.data);
		if (output.status){
			$('#account_admin_div').html(output.message).show();
			
		} else {
			$('#account_admin_div').html(output.error).show();
		}
		scrollToTop('#account_admin_div');
	}
}

/** 
* --------------------------------------------------------
  * Routine to update database with modified children data 
  * Location: 'CI-top'/js/testwell
  *
  * @return void        
* --------------------------------------------------------
**/
function updateChildrenData(fdata){
	$.ajax({
        url: global_siteurl+'/testwell/testwell/update_children_account',
        data: fdata,
        dataType: 'json',
        type: 'post',
        success: function (retval) {  
			processUpdateChildrenData(retval);
		}
    });	
}
function processUpdateChildrenData(output){
	if (output.status){
		$('#children_ac_message').html(output.message).show();
		
	} else {
		$('#children_ac_message').html(output.error).show();
	}
	scrollToTop('#children_ac_message');
	
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
function get_user_ac_form_data(user_type,form_flag){
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
		if ($('#alt_p_email').length > 0){
			fdata+='&update_alt_p_email='+$('#alt_p_email').val();
		}else{
			fdata+='&update_alt_p_email='+"";
		}
	} else if (user_type=='Student'){
		var fdata='form_flag='+form_flag+'&update_s_f_name='+$('#s_f_name').val();
		fdata+='&update_s_l_name='+$('#s_l_name').val();
		fdata+='&update_s_grade='+$('#s_grade').val();
		fdata+='&update_s_email='+$('#s_email').val();
	}
	return fdata;
}
/** 
* --------------------------------------------------------
  * Utility routine to fill out the data string from the form values
  * for children accounts modified by parent
  * Location: 'CI-top'/js/testwell
  *
  * @return string fdata        
* --------------------------------------------------------
**/
function get_children_ac_form_data(){
	
	var fdata="";
	var i;
	var num_chi=chidata.length;
	fdata='num_chi='+num_chi;
	for (i=0;i<num_chi;i++) {
		var cf_name='#child_s_f_name'+i;
		var cl_name='#child_s_l_name'+i;
		var c_grade='#child_s_grade'+i;
		var c_email='#child_s_email'+i;
		var c_ttype='#child_s_ttype'+i+' option:selected';
		fdata+='&child_id'+i+'='+$(cf_name).attr('cid');
		fdata+='&child_s_f_name'+i+'='+$(cf_name).val();
		fdata+='&child_s_l_name'+i+'='+$(cl_name).val();
		fdata+='&child_s_grade'+i+'='+$(c_grade).val();
		fdata+='&child_s_email'+i+'='+$(c_email).val();
		fdata+='&child_s_ttype'+i+'='+$(c_ttype).val();
	}
	console.log(fdata);
	return fdata;
}
/** 
* --------------------------------------------------------
  * Routine to add each child to the update account dialog
  * with info from chidata (global)
  * Location: 'CI-top'/js/testwell
  *
  * @return      
* --------------------------------------------------------
**/
function displayChildrenData(){
	var html_str="";
	html_str='<div id="children_ac_form" style="background-color:pink">';
	html_str+='<fieldset>';
	html_str+='<h2>Update Children Account</h2>';
	html_str+='<div id="children_ac_message" style="color:red">';
	html_str+='</div>';
	html_str+='<div id="children_ac_body" style="color:green">';
	html_str+='<fieldset>';
	html_str+="<ul>";
	$.each(chidata,function(child,crow){
		html_str+= '<li style="color:green"><h3>'+crow.f_name+' '+crow.l_name+ '</h3></li>';
		html_str+='<fieldset>';
		html_str+='<li>';
		html_str+='<label for="child_s_f_name'+child+'">First Name:</label>';
		html_str+='<input type="text" id="child_s_f_name'+child+'"';
		html_str+=' name="child_s_f_name'+child+'"';
		html_str+=' value='+crow.f_name;
		html_str+=' cid='+crow.id+'>(required)';
		html_str+='</li>';
		html_str+='<li>';
		html_str+='<label for="child_s_l_name'+child+'">Last Name:</label>';
		html_str+='<input type="text" id="child_s_l_name'+child+'"';
		html_str+=' name="child_s_l_name'+child+'"';
		html_str+=' value='+crow.l_name+'>(required)';
		html_str+='</li>';
		html_str+='<li>';
		html_str+='<label for="child_s_email'+child+'">Email:</label>';
		html_str+='<input type="text" id="child_s_email'+child+'"';
		html_str+=' name="child_s_email'+child+'"';
		html_str+=' value='+crow.email+'>(required)';
		html_str+='</li>';
		html_str+='<li>';
		html_str+='<label for="child_s_grade'+child+'">Grade:</label>';
		html_str+='<input type="text" id="child_s_grade'+child+'"';
		html_str+=' name="child_s_grade'+child+'"';
		html_str+=' value='+crow.grade+'>(required)';
		html_str+='</li>';
		html_str+='<li>';
		html_str+='<label for="child_s_ttype'+child+'">Test type</label>';
		html_str+='<select id="child_s_ttype'+child+'">(required)';
		/** why does this not work? it's cleaner!!
		html_str+='<option value="ISEE_LOW">ISEE_LOW</option>';
		html_str+='<option value="ISEE_MED">ISEE_MED</option>';
		html_str+='<option value="ISEE_HIGH">ISEE_HIGH</option>';
		html_str+='<option selected="'+crow.ttype+'"></option>';
		**/
		if (crow.ttype=='ISEE_LOW'){
			html_str+='<option selected="ISEE_LOW" value="ISEE_LOW">ISEE_LOW</option>';
			html_str+='<option value="ISEE_MED">ISEE_MED</option>';
			html_str+='<option value="ISEE_HIGH">ISEE_HIGH</option>';
		} else if (crow.ttype=='ISEE_MED'){
			html_str+='<option value="ISEE_LOW">ISEE_LOW</option>';
			html_str+='<option selected="ISEE_MED" value="ISEE_MED">ISEE_MED</option>';
			html_str+='<option value="ISEE_HIGH">ISEE_HIGH</option>';
		} else if (crow.ttype=='ISEE_HIGH'){
			html_str+='<option value="ISEE_LOW">ISEE_LOW</option>';
			html_str+='<option value="ISEE_MED">ISEE_MED</option>';
			html_str+='<option selected="ISEE_HIGH" value="ISEE_HIGH">ISEE_HIGH</option>';
		}
		html_str+='</select>';	
		html_str+='</li>';
		html_str+='</fieldset>';
	});
	html_str+='</ul>';
	html_str+='</fieldset>';
	html_str+='</div>';
	html_str+='</fieldset>';
	html_str+='</div>';
	//console.log(html_str);
	$('#account_admin_div').html(html_str).hide();
}