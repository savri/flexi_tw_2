<div id="reg_child_form" style="background-color:MistyRose">
	<fieldset>
		<fieldset>
			<h2>Add Child to Family Account</h2>
		</fieldset>
		<div id="register_child_message">
		</div>
		<fieldset>
			<legend>Child Details</legend>
			<ul>
			<li class="info_req">
				<label for="register_s_f_name">First Name:</label>
				<input type="text" id="register_s_f_name" name="register_s_f_name" 
									value="<?php echo set_value('register_s_f_name');?>"/>
				(required)
			</li>
			<li class="info_req">
				<label for="register_s_l_name">Last Name:</label>
				<input type="text" id="register_s_l_name" name="register__s_l_name" 
									value="<?php echo set_value('register_s_l_name');?>"/>
				(required)
			</li>
				<li class="info_req">
					<label for="register_s_email">Child Email</label>
					<input type="text" id="register_s_email" name="register_s_email" 
									value="<?php echo set_value('register_s_email');?>"/>
					(required)
				</li>
				<li class="info_req">
					<label for="register_s_grade">Grade</label>
					<input type="text" id="register_s_grade" name="register_s_grade" 
									value="<?php echo set_value('register_s_grade');?>"/>
					(required)
				</li>				
				<li class="info_req">
					<label for="register_s_ttype">Test type:</label>

						<?php
							$js = 'id="register_s_ttype"';
							$options=array(
										'ISEE_LOW'=>'ISEE LOW',
										'ISEE_MED'=>'ISEE MEDIUM',
										'ISEE_HIGH'=>'ISEE HIGH',
										);
							echo form_dropdown('register_s_ttype',$options,'',$js);
						?>(required)
				</li>			
				<br/>
			</ul>
		</fieldset>
	</fieldset>
</div>
