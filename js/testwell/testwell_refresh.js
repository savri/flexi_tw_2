

function tw_refresh() {
	registerEventHandlers();
	userMenuFormDisplay();
	closeOpenDialogs();
	var xx= window.location.hash
	var tw_anchor=xx.replace('#','');
	switch(tw_anchor) {
		
		case ('pw_change'):
		{
			changePassword(0);
			break;
		}
		case ('update_ac'):
		{
			updateUserAccount(0);
			break;
		}
		case ('register_student'):
		{
			registerChild(0);
			break;
		}
		case ('child_update'):
		{
			updateChildrenAccount(0);
			break;
		}

	}
	
}

function tw_refresh_login_div(){
	
}
function tw_refresh_admin_div(){
	
}
function tw_refresh_test_div(){
	
}