<?php
class Vocational_program_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
	}

	/**
	 * getRooms function.
	 * 
	 * @access public
	 * @param char $return_type
	 * @param associative array $conditions
	 * @return associative array list or single vocational program on success.
	 */
	public function getVocationalPrograms($return_type,$condition){
		return $this->crud->getData('',$return_type,$condition,'tbl6');
		
	}

}