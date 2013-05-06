<?php
/**
 * Utility functions to initialize various things for the
 * editor
 * Location:<CI-top>/application/model/tw_editor_utils_model.php
 **/ 
class Tw_editor_utils_model extends CI_Model {
	/**
	 * Initializes the html editor - CKEditor - third party
	 * used to create/edit questions and passages
	 * Also configures use of CKFinder module used to handle images
	 * The 3rd party libraries for both are found in:
	 * <CI-top>/application/libraries
	 * The modules for ckeditor are found in
	 * <CI-top>/assets directory
	 *
	 * @return	void
	 */
	function init_ck() {
		$this->load->library('ckeditor');
        $this->load->library('ckfinder');

        //configure base path of ckeditor folder
        $this->ckeditor->basePath = base_url().'assets/ckeditor/';
        //$this->ckeditor->config['toolbar'] = 'Full';

		$this->ckeditor->config['toolbar'] =array(	//Setting a custom toolbar
							array('Source'),
							array(),
							array('Bold', 'Italic'),
							array('Underline', 'Strike','Subscript','Superscript', 'Font','FontSize'),
							array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
							array('Image',),
							array('ckeditor_wiris_formulaEditor', 'ckeditor_wiris_CAS'),
							'/'
						);
        $this->ckeditor->config['language'] = 'en';
		$this->ckeditor->config['width'] = '700px';
		$this->ckeditor->config['height'] = '100px';
       
        //configure ckfinder with ckeditor config
        $this->ckfinder->SetupCKEditor($this->ckeditor,base_url().'assets/ckfinder/');
	}
}