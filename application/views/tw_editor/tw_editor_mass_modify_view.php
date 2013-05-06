
<div id="act_head_div">
	<h3> Edit all questions in a section - One By One</h3>
</div>
<div id="status_msg_div">
</div>
<?php echo form_open();?>
	<div id="act_body_div">
		<div id="edit_all_mm_div">
			<label for="EditQ">Select the section/topic for the questions you would like to edit:
			(Not advisable to get all the questions in the bank all at once!)
			<p>
				<label for="QSection">Question Section: 
					<?php
						$js = 'id="esect_dd"';
						$options=array('No Select'=>'Select Section First', 
									'READING_COMP'=>'READING_COMP',
									'MATH_ACH'=>'MATH_ACH',
									'QUANT_REASON'=>'QUANT_REASON',
									'VERB_REASON'=>'VERB_REASON',
									'ESSAY'=>'ESSAY');
						echo form_dropdown('equestionSection',$options,"",$js);
					?>
				</label>
			</p>
			<p>
				<label for="QTopic">Question Topic: 
					<?php
						$js = 'id="etop_dd"';
						$options=array('All'=>'All Topics', 'SYNONYMS'=>'SYNONYMS',
										'READING_COMP'=>'READING_COMP',
										'SENTENCE_COMPLETION'=>'SENTENCE COMPLETION',
										'ARITHMETIC'=>'ARITHMETIC',
										'ALGEBRA'=>'ALGEBRA',
										'GEOMETRY'=>'GEOMETRY',
										'MATH_CONCEPT'=>'MATH CONCEPT',
										'MATH_APPLICATION'=>'APPLICATION',
										'QUANTITATIVE_COMPARISON'=>'QUANTITATIVE COMPARISON');
						echo form_dropdown('equestionTopic',$options,'',$js);
					?>
				</label>
			</p>
			<input type="button" id="editallbtn" value="Edit 1-by-1" />
		</div>
		<div id="edit_all_q_div">
		</div>
		<div id="edit_all_msg_div">
		</div>
		<div id="edit_all_body_div" style="display:none">
			<br/>
			<hr>
			<h4>Edit question:<h4>
			<br/>			
			<?php
				$this->load->view('tw_editor/question_view');
			?>
			<p>
				<input type="button" id="editallsavebtn" value="Save question" />
				<input type="button" id="editallcancelbtn2" value="Cancel" />
				
				<input type="button" id="editalltopbtn" value="Top" />
			
			</p>
		</div>
	</div>
<?php echo form_close(); ?>

