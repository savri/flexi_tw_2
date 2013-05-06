<div id="pw_update">
	<h2>Account Activation</h2>

	<div id="pw_update_message">
	</div>
	<div id="pw_update_body">
		<?php echo form_open(current_url());	?>  	
				<ul>
					<li>
						<strong>You need to reset your password for account activation to be complete. </strong><br/>
						Password length must be more than 	
						<?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>
						Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
					</li>
					<br/>
					<li class="info_req">
						Your default password was in the email that was sent to you<br/>
						<label for="current_password">Your Default Password:</label>
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
					<li>
						<label for="change_pw_btn">Update Password:</label>
						<input type="button" name="change_password" id="changepwbtn" 
													value="Submit" class="link_button large"/>
					</li>
					<input type="hidden" name="act_pw" id="act_pw" value="activation_pw">
					<input type="hidden" name="act_tok" id="act_tok" value=<?php echo $token;?> >
					<input type="hidden" name="act_user" id="act_user" value=<?php echo $user;?> >
					
				</ul>
		<?php echo form_close();?>
	</div>
</div>
