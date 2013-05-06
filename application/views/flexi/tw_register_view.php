
<h2>Register Account</h2>


<div id="register_message">
</div>

<div id="register_body">
	<?php echo form_open(current_url()); ?>  	
		<fieldset>
			<legend>Parent Details</legend>
			<ul>
				<li class="info_req">
					<label for="p_f_name">First Name:</label>
					<input type="text" id="p_f_name" name="register_p_f_name" 
									value="<?php echo set_value('register_p_f_name');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="p_l_name">Last Name:</label>
					<input type="text" id="p_l_name" name="register_p_l_name" 
									value="<?php echo set_value('register_p_l_name');?>"/>(required)
				</li>

				<li class="info_req">
					<label for="add_line_1">Address Line 1</label>
					<input type="text" id="add_line_1" name="register_add_line_1" 
									value="<?php echo set_value('register_add_line_1');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="add_line_2">Address Line 2</label>
					<input type="text" id="add_line_2" name="register_add_line_2" 
									value="<?php echo set_value('register_add_line_2');?>"/>
				</li>
				<li class="info_req">
					<label for="city">City</label>
					<input type="text" id="city" name="register_city" 
									value="<?php echo set_value('register_city');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="state">State</label>
					<input type="text" id="state" name="register_state" 
									value="<?php echo set_value('register_state');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="zip">Zip Code</label>
					<input type="text" id="zip" name="register_zip" 
									value="<?php echo set_value('register_zip');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="ph_number">Phone Number:</label>
					<input type="text" id="ph_number" name="register_ph_number" 
									value="<?php echo set_value('register_ph_number');?>"/>
									(no dashes or spaces)
				</li>
				
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Parent Login</legend>
			<ul>
				<li>Email addresses will be used as the login username</li>
				<br/>
				<li class="info_req">
					<label for="pri_p_email">Primary Parent Email</label>
					<input type="text" id="pri_p_email" name="register_pri_p_email" 
									value="<?php echo set_value('register_pri_p_email');?>"/>(required)
				</li>
				<li class="info_req">
					<label for="alt_p_email">Alternate Parent Email</label>
					<input type="text" id="alt_p_email" name="register_alt_p_email" 
									value="<?php echo set_value('register_alt_p_email');?>"/>
					(optional)
				</li>
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Student Details</legend>
			<ul>
			<li class="info_req">
				<label for="s_f_name">First Name:</label>
				<input type="text" id="s_f_name" name="register_s_f_name" 
									value="<?php echo set_value('register_s_f_name');?>"/>
				(required)
			</li>
			<li class="info_req">
				<label for="s_l_name">Last Name:</label>
				<input type="text" id="s_l_name" name="register_s_l_name" 
									value="<?php echo set_value('register_s_l_name');?>"/>
				(required)
			</li>
				<li class="info_req">
					<label for="s_email">Student Email</label>
					<input type="text" id="s_email" name="register_s_email" 
									value="<?php echo set_value('register_s_email');?>"/>
					(required)
				</li>
				<li class="info_req">
					<label for="s_grade">Grade</label>
					<input type="text" id="s_grade" name="register_s_grade" 
									value="<?php echo set_value('register_s_grade');?>"/>
					(required)
				</li>				
				<li class="info_req">
					<label for="s_ttype">Test type:</label>

						<?php
							$js = 'id="s_ttype"';
							$options=array(
										'ISEE_LOW'=>'ISEE LOW',
										'ISEE_MED'=>'ISEE MEDIUM',
										'ISEE HIGH'=>'ISEE HIGH',
										);
							echo form_dropdown('register_s_ttype',$options,'',$js);
						?>(required)
				</li>			
				<br/>
			</ul>
		</fieldset>
	
		<fieldset>
			<legend>Register</legend>
			<ul>
				<li>
					You only need to use this account set-up form once. Afterwards, you can always log in to add students and update your account details. 
				</li>
				<li>
					<label for="submit">Register:</label>
					<input type="button" name="register_user" id="reguserbtn" value="Submit" class="link_button large"/>
				</li>
			</ul>
		</fieldset>
	<?php echo form_close();?>
</div>
