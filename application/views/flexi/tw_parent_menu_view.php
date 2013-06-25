<!-- Parent User menu form  - displayed in login_body div
After parent user has successfully logged in
Offers choices:logout change password, admin account etc
-->

<div id="user_menu_div">
	<?php echo form_open(current_url());?>  
		<ul class="navigation">
			<li><a href="#pw_change" id="pw_chg" rel="#pw_chg">Change password</a></li>
			<li><a href="#account_update" id="ac_update" rel="#ac_update">Update parent account</a></li>
			<?php  if ($altExists==0) {?>
				<li><a href="#register_alt" id="reg_alt" rel="#reg_alt">Register alternate parent account</a></li>
			<?php }?>
			<li><a href="#child_update" id="chi_update" rel="#chi_update">Update children's accounts</a></li>
			<li><a href="#register_student" id="reg_student" rel="#reg_student">Add child</a></li>
			<li><a href="#" id="logout">Logout</a></li>
		</ul>
	<?php echo form_close();?>

</div>
