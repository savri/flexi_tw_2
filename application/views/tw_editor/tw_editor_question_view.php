
<div id="act_head_div">
	<h3> Add New Questions</h3>
</div>
<div id="act_body_div">
	<?php echo form_open();?>
		<div id="qid_div" style="display:none">
			<p>
				<label for="qid_num">Enter question id: 
					<?php 
						$data = array('id'=> 'qid',);
						echo form_input($data);
						?>
				</label>
				<div id="qid_err_div">
				</div>
			</p>
			<p>
				<input type="button" id="qidenterbtn" value="Get it!" />
			</p>
			<hr>	
		</div>
		<div id="q_body_div" style="display:none">
			<?php 
				$this->load->view('tw_editor/question_view');
			?>
			<p>
				<input type="button" id="savebtn" value="Save" />
			</p>
		</div>
	<?php echo form_close(); ?>
</div>