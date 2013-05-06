<!-- Parent User menu form  - displayed in login_body div
After parent user has successfully logged in
Offers choices to logout change password etc
-->

<div id="user_menu_div">
	<?php echo form_open(current_url());?>  
		<ul class="navigation">
			<li><a href="#change_pw" id="change_pw_form" rel="#pw_change">Change password</a></li>
			<li><a href="#update_ac" id="ac_update" rel="#account_update">Update account</a></li>
			<li><a href="#update_ac" id="ac_child_update" rel="#account_update">Update children's accounts</a></li>
			<?php  if ($altExists==0) {?>
				<li><a href="#update_ac" id="add_alt" rel="#add_alt">Add Alternate Parent</a></li>
			<?php }?>
			<li><a href="#update_ac" id="add_child" rel="#add_child">Add child</a></li>
			<li><a href="#logout" id="logout">Logout</a></li>
		</ul>
	<?php echo form_close();?>

</div>
