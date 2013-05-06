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
			$('#login_dive').hide();
			scrollToTop('#register_message');
			$('#register_message').html("Registration successful!");
			$('#register_message').append(output.message).show();
			
		} else {
			scrollToTop('#register_message');
			$('#register_message').html(output.message).show();
		}
	}		
}