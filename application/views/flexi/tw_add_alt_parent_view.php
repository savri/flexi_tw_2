<div id="add_alt_form" style="background-color:MistyRose">
	<fieldset>
		<h2>Add Alternate Parent</h2>

		<div id="account_message_alt">
		hello
		</div>

		<div id="account_body_alt">
				<fieldset>
					<legend>Alternate Parent Account</legend>
					Email addresses will be used as the login username. 
					Account activation email will be sent to this address
					<br/>
					<ul>
						<li class="info_req">
							<label for="reg_alt_p_email">Alternate Parent Email</label>
							<input type="text" id="reg_alt_p_email" name="reg_alt_p_email" 
											value="<?php echo set_value('reg_alt_p_email');?>"/>
						</li>
					</ul>
				</fieldset>
			<?php echo form_close();?>
		</div>
	</fieldset>
</div>