<div id="account_update_form" style="background-color:MistyRose">
	<fieldset>
		<h2>Update Account</h2>
		
		<div id="account_message" style="color:red">
		</div>
		
		<div id="account_body">
			<?php echo form_open(current_url()); ?>  	
				<fieldset>
					<legend>Student Details</legend>
					<ul>
					<li class="info_req">
						<label for="s_f_name">First Name:</label>
						<input type="text" id="s_f_name" name="update_s_f_name" 
									style="font-weight:bold;color:red;"
									value="<?php if ($s_f_name)
											echo set_value('s_f_name',$s_f_name);?>"/>
						(required)
					</li>
					<li class="info_req">
						<label for="s_l_name">Last Name:</label>
						<input type="text" id="s_l_name" name="update_s_l_name" 
									style="font-weight:bold;color:red;"
									value="<?php if ($s_l_name)
											echo set_value('s_l_name',$s_l_name);?>"/>
						(required)
					</li>
						<li class="info_req">
							<label for="s_email">Student Email</label>
							<input type="text" id="s_email" name="update_s_email" 
									style="font-weight:bold;color:red;"
									value="<?php if ($s_email)
											echo set_value('s_email',$s_email);?>"/>
							(required)
						</li>
						<li class="info_req">
							<label for="s_grade">Grade</label>
							<input type="text" id="s_grade" name="update_s_grade" 
								style="font-weight:bold;color:red;"
								value="<?php if ($grade)
										echo set_value('s_grade',$grade);?>"/>
							(required)
						</li>				
	
						<br/>
					</ul>
				</fieldset>
			<?php echo form_close();?>
		</div>
	</fieldset>
</div>
