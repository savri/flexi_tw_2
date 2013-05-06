
<div id="act_head_div">
	<h3> Add Passage</h3>
</div>
<div id="status_msg_div">
</div>
<?php echo form_open();?>
	<div id="act_body_div">
		<div id="passage_div">
			<p>
				<label for="pass"> Passage: </label>
				<?php 
				echo $this->ckeditor->editor("hester","Add  here");?>					
			</p>
		</div>
		<div id="pass_qs_div">
		</div>
		<input type="button" id="savepassagebtn" value="Save passage" />
	</div>
<?php echo form_close(); ?>

