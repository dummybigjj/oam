<?php
class Batch_year_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
	}

	/**
	 * getBatchCurrentYear function.
	 * 
	 * @access public
	 * @return associative array on success.
	 */
	public function getBatchCurrentYear(){
		$select = '`batch_year_id`, `batch_name`, `is_active`, `user_credential`.`u_full_name`, `batch_year`.`created`';
		$join   = array('`user_credential`'=>'`batch_year`.`created_by` = `user_credential`.`user_id`');
		return $this->crud->getJoinDataWithSort($select,'s','',$join,'batch_year_id DESC','tbl8');
	}

}