<div id="account_update_form" style="background-color:MistyRose">
	<fieldset>
		<h2>Update Account</h2>

		<div id="account_message">
		</div>

		<div id="account_body">
				<fieldset>
					<legend>Parent Details</legend>
					<ul>
						<li class="info_req">
							<label for="update_p_f_name">First Name:</label>
							<input type="text" id="p_f_name" name="update_p_f_name" 
										style="font-weight:bold;color:red;"
											value="<?php if ($p_f_name) 
												echo set_value('update_p_f_name',$p_f_name);?>"/>(required)
						</li>
						<li class="info_req">
							<label for="update_p_l_name">Last Name:</label>
							<input type="text" id="p_l_name" name="update_p_l_name" 
											style="font-weight:bold;color:red;"
										value="<?php  if ($p_l_name) 
											echo set_value('p_l_name',$p_l_name);?>"/>(required)
						</li>

						<li class="info_req">
							<label for="update_add_line_1">Address Line 1</label>
							<input type="text" id="add_line_1" name="update_add_line_1" 
									style="font-weight:bold;color:red;" 
									value="<?php if ($f_add_1) 
										echo set_value('update_add_line_1',$f_add_1);?>"/>(required)
						</li>
						<li class="info_req">
							<label for="update_add_line_2">Address Line 2</label>
							<input type="text" id="add_line_2" name="update_add_line_2" 
										style="font-weight:bold;color:red;"
										value="<?php if ($f_add_2) 
											echo set_value('update_add_line_2',$f_add_2);?>"/>
						</li>
						<li class="info_req">
							<label for="update_city">City</label>
							<input type="text" id="city" name="update_city" 
										style="font-weight:bold;color:red;"
										value="<?php if ($f_city)
											echo set_value('update_city',$f_city);?>"/>(required)
						</li>
						<li class="info_req">
							<label for="update_state">State</label>
							<input type="text" id="state" name="update_state" 
										style="font-weight:bold;color:red;"
										value="<?php if ($f_state)
											echo set_value('update_state',$f_state);?>"/>(required)
						</li>
						<li class="info_req">
							<label for="update_zip">Zip Code</label>
							<input type="text" id="zip" name="update_zip" 
										style="font-weight:bold;color:red;"
										value="<?php if ($f_zip) 
											echo set_value('update_zip',$f_zip);?>"/>(required)
						</li>
						<li class="info_req">
							<label for="update_ph_number">Phone Number:</label>
							<input type="text" id="ph_number" name="update_ph_number" 
										style="font-weight:bold;color:red;"
										value="<?php if ($f_phone) 
											echo set_value('update_ph_number',$f_phone);?>"/>
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
							<input type="text" id="pri_p_email" name="update_pri_p_email" 
										style="font-weight:bold;color:red;"
											value="<?php echo set_value('update_pri_p_email',$pri_p_email);?>"/>(required)
						</li>
						<?php if ( $alt_p_email !="" ) { ?>
							<li class="info_req">
								<label for="alt_p_email">Alternate Parent Email</label>
								<input type="text" id="alt_p_email" name="update_alt_p_email" 
										style="font-weight:bold;color:red;"
										value="<?php echo set_value('update_alt_p_email',$alt_p_email);?>"/>
							</li>
						<?php } else {?>
							<li><i>An alternate parent email has not been added to this account</i></li>
						<?php } ?>
					</ul>
				</fieldset>
			<?php echo form_close();?>
		</div>
	</fieldset>
</div>