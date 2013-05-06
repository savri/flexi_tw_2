<div id="pw_change_dialog" class="admin_overlay" style="border:1px solid black;background-color:white">
	<fieldset>

	<h2>Change password</h2>

	<div id="pw_change_message" style="color:red">
	</div>
	<div id="pw_change_body">
		<fieldset>
			<?php echo form_open(current_url());?>  
					<strong>You need to re-enter your current password first in order to 
					change it to a new value. </strong><br/>
					Password length must be more than 	
					<?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>
					Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
				<ul>
		
					<br/>
					<li class="info_req">
						<label for="current_password">Your Current Password:</label>
						<input type="password" id="current_password" name="current_password" 
															value="<?php echo set_value('current_password');?>"/>
					</li>
					<li class="info_req">
						<label for="new_password">New Password:</label>
						<input type="password" id="new_password" name="new_password" 
															value="<?php echo set_value('new_password');?>"/>
					</li>
					<li class="info_req">
						<label for="confirm_new_password">Confirm New Password:</label>
						<input type="password" id="confirm_new_password" name="confirm_new_password" 
													value="<?php echo set_value('confirm_new_password');?>"/>
					</li>
				</ul>
			<?php echo form_close();?>
		</fieldset>
	</div>
	</fieldset>
</div>
