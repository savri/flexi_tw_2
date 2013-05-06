<?php $this->load->view('includes/tw_editor_header')?>


	<?php echo form_open();?>
		<div id="qa_main_div">
			<div id="qa_title_dic">
				<h2> Add & Edit Questions and Answers</h2>
				<hr>
			</div>
			<div id="qa_ret_div">
				<p>
					<input type="button" id="mainmenubtn" value="Return to Main Menu" />
				</p>
				<hr>
			</div>
			<div id="qa_mm_div">
				<label for="activity">What do you want to do? 
					<p>
						<?php
							$js = 'id="activity_dd"';
							$options=array('Add_New_Q'=>'Add a new question with answers',
										'Add_Passage'=>'Add a passage for reading comprehension',
										'Edit_Q'=>'Edit a question by question id',
										'Edit_All'=>'Edit all questions in a section (one by one)',
										'Edit_last_10'=>'Edit last 10 questions entered (one by one)',
										'Edit_Passages'=>'Edit passage content and questions associated with them',
										);
							echo form_dropdown('activity',$options,'',$js);
						?>
					</p>
				</label>
			</div>
			<div id="qa_body_div">
			</div>
		</div>
	<?php echo form_close(); ?>
<?php $this->load->view('includes/tw_editor_footer')?>