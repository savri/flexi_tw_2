
<div id="act_head_div">
	<h4> Add Questions</h4>
</div>
<div id="act_body_div">
	<?php echo form_open('/testwell/input_questions/read_data');?>

		<div id="qid_div">
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
		<div id="add_q_div">
			<div id="add_q_msg_div">
				
			</div>
			<p>
				<label for="Question"> Question: </label>
				<?php 
					$this->ckeditor->config['bodyId']="bob";
					echo $this->ckeditor->editor("questionck","Enter Question");?>						
			</p>
			<p>
				<label for="TestType">Test Type: 
					<?php
						$js = 'id="ttype_dd"';
						$options=array('ISEE_LOW'=>'ISEE_LOW',
								'ISEE_MED'=>'ISEE_MED',
								'ISEE_HI'=>'ISEE_HI',);
						echo form_dropdown('testType',$options,"",$js);
					?>
				</label>
			</p>
			<p>
				<label for="QSection">Question Section: 
					<?php
						$js = 'id="sect_dd"';
						$options=array('No Select'=>'Select Section First', 
								    'READING_COMP'=>'READING_COMP',
									'MATH_ACH'=>'MATH_ACH',
									'QUANT_REASON'=>'QUANT_REASON',
									'VERB_REASON'=>'VERB_REASON',
									'ESSAY'=>'ESSAY');
						echo form_dropdown('questionSection',$options,"",$js);
					?>
				</label>
			</p>
			<p>
				<label for="QTopic">Question Topic: 
					<?php
						$js = 'id="top_dd"';
						$options=array('No Select'=>'Select Topic', 
										'SYNONYMS'=>'SYNONYMS',
										'READING_COMP'=>'READING_COMP',
										'SENTENCE_COMPLETION'=>'SENTENCE COMPLETION',
										'ARITHMETIC'=>'ARITHMETIC',
										'ALGEBRA'=>'ALGEBRA',
										'GEOMETRY'=>'GEOMETRY',
										'MATH_CONCEPT'=>'MATH CONCEPT',
										'MATH_APPLICATION'=>'APPLICATION',
										'QUANTITATIVE_COMPARISON'=>'QUANTITATIVE COMPARISON');
						echo form_dropdown('questionTopic',$options,'',$js);
					?>
				</label>
			</p> 
			<p>
				<label for="Choice1"> Choice 1: </label>
				
				<?php 
					$this->ckeditor->config['bodyId']="choice1ck";
					echo $this->ckeditor->editor("choice1ck","Enter Choice1");?>						
			</p>
			<p>
				<label for="Choice1_tag">Tag: 
					<?php
						$js = 'id="tag1_dd"';
						$options=array('CORRECT'=>'CORRECT',
										'CARELESS'=>'CARELESS',
										'OTHER'=>'OTHER',
										'OOB'=>'Out Of Bounds'
									);
						echo form_dropdown('choice1_tag',$options,'OTHER',$js);
					?>
				</label>
			</p>
			<p>
				<label for="Choice2"> Choice 2: </label>
				<?php 
					$this->ckeditor->config['bodyId']="choice2ck";
					echo $this->ckeditor->editor("choice2ck","Enter Choice2");?>						
			</p>
			<p>
				<label for="Choice2_tag">Tag: 
					<?php
						$options=array('OTHER'=>'OTHER',
										'CORRECT'=>'CORRECT',
										'CARELESS'=>'CARELESS',
										'OOB'=>'Out Of Bounds'
									);
						$js = 'id="tag2_dd"';
						echo form_dropdown('choice2_tag',$options,'OTHER',$js);
					?>
				</label>
			</p>	
			<p>
				<label for="Choice3"> Choice 3: </label>
				<?php 
					$this->ckeditor->config['bodyId']="choice3ck";
					echo $this->ckeditor->editor("choice3ck","Enter Choice3");?>						
			</p>
			<p>
				<label for="Choice3_tag">Tag: 
					<?php
						$options=array('CORRECT'=>'CORRECT',
										'CARELESS'=>'CARELESS',
										'OTHER'=>'OTHER',
										'OOB'=>'Out Of Bounds'
									);
						$js = 'id="tag3_dd"';
						echo form_dropdown('choice3_tag',$options,'OTHER',$js);
					?>
				</label>
			</p>	
			<p>
				<label for="Choice4"> Choice 4: </label>
				<?php 
					$this->ckeditor->config['bodyId']="choice4ck";
					echo $this->ckeditor->editor("choice4ck","Enter Choice4");?>						
			</p>
			<p>
				<label for="Choice4_tag">Tag: 
					<?php
						$options=array('CORRECT'=>'CORRECT',
										'CARELESS'=>'CARELESS',
										'OTHER'=>'OTHER',
										'OOB'=>'Out Of Bounds'
									);
						$js = 'id="tag4_dd"';	
						echo form_dropdown('choice4_tag',$options,'OTHER',$js);
					?>
				</label>
			</p>
			<p>
				<input type="button" id="savebtn" value="Enter" />
			</p>
		</div>
	<?php echo form_close(); ?>
</div>