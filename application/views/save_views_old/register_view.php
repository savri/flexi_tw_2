
<h2>Register Account</h2>


<div id="register_message">
</div>

<div id="register_body">
	<?php echo form_open(current_url()); ?>  	
		<fieldset>
			<legend>Personal Details</legend>
			<ul>
				<li class="info_req">
					<label for="first_name">First Name:</label>
					<input type="text" id="first_name" name="register_first_name" value="<?php echo set_value('register_first_name');?>"/>
				</li>
				<li class="info_req">
					<label for="last_name">Last Name:</label>
					<input type="text" id="last_name" name="register_last_name" value="<?php echo set_value('register_last_name');?>"/>
				</li>
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Contact Details</legend>
			<ul>
				<li class="info_req">
					<label for="phone_number">Phone Number:</label>
					<input type="text" id="phone_number" name="register_phone_number" value="<?php echo set_value('register_phone_number');?>"/>
				</li>
				<li>
					<label for="newsletter">Subscribe to Newsletter:</label>
					<input type="checkbox" id="newsletter" name="register_newsletter" value="1" <?php echo set_checkbox('register_newsletter',1);?>/>
				</li>
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Login Details</legend>
			<ul>
				<li class="info_req">
					<label for="remail_address">Email Address:</label>
					<input type="text" id="remail_address" name="register_email_address" value="<?php echo set_value('register_email_address');?>" class="tooltip_trigger"
						title="You will need to activate your account via clicking a link that is sent to your email address."
					/>
				</li>
				<br/>
				<li>							
					<small>
						Password length must be more than <?php echo $this->flexi_auth->min_password_length(); ?> characters in length.<br/>Only alpha-numeric, dashes, underscores, periods and comma characters are allowed.
					</small>
				</li>
				<li class="info_req">
					<label for="rpassword">Password:</label>
					<input type="password" id="rpassword" name="register_password" value="<?php echo set_value('register_password');?>"/>
				</li>
				<li class="info_req">
					<label for="rconfirm_password">Confirm Password:</label>
					<input type="password" id="rconfirm_password" name="register_confirm_password" value="<?php echo set_value('register_confirm_password');?>"/>
				</li>
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Register</legend>
			<ul>
				<li>
					<label for="submit">Register:</label>
					<input type="button" name="register_user" id="reguserbtn" value="Submit" class="link_button large"/>
				</li>
			</ul>
		</fieldset>
	<?php echo form_close();?>
</div>
