<!-- Login form  - displayed in login_body div
-->
<?php echo form_open(current_url());?>  
			<li>
			   <?php echo form_button(array('id' => 'regbtn','content'=>'Register'));?>
			</li>
			<li>
				<label for="identity">Email:</label>
				<input type="text" id="identity" name="login_identity" value="<?php echo set_value('login_identity', 'mayamisner@gmail.com');?>" class="tooltip_parent"/>
			</li>
			<li>
				<label for="password">Password:</label>
				<input type="password" id="password" name="login_password" value="<?php echo set_value('login_password', 'test');?>"/>
			</li>
			<li>
				<label for="remember_me">Remember Me:</label>
				<?php $data= array('id'=>'remember_me',
								'name'=>'remember_me',
								'value'=>1,
								'checked'=>TRUE,
								'style'=>'margin:10px');
					echo form_checkbox($data);?>
				<input type="button" name="login_user" id="loginbtn" value="Submit" class="link_button large"/>
		
			</li>
<?php echo form_close();?>
