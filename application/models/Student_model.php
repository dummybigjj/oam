<?php
class Student_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
		$this->load->model('user_model');
	}

	/** 9/9/2018
	 * getStudents function.
	 * 
	 * @access public
	 * @param char $return_type
	 * @param associative array $conditions
	 * @return associative array list or single student on success.
	 */
	public function getStudents($return_type,$condition){
		return $this->crud->getDataWithSort('',$return_type,$condition,'created ASC','tbl2');
	}

	/** 
	 * getEnrolledStudent function.
	 * 
	 * @access public
	 * @param mixed $current_batch_year
	 * @return associative array list of enrolled student on success.
	 */
	public function getEnrolledStudent($condition,$return_type){
		$select = '`student_subject`.`tbl_id`, `student_subject`.`student_id`, `student`.`student_no`, `student`.`arabic_name`, `subject`.`subject_title`, `subject_code`, `time`, `room`.`room_name`, `day`, `vocational_program`.`voc_program_acronym`, `batch_year`.`batch_name`, `student_subject`.`subject`, `student_subject`.`room`, `student_subject`.`vocational_program`, `student_subject`.`batch_year`, `student_subject`.`created_by`, `student_subject`.`created`, `student_subject`.`updated_by`, `student_subject`.`modified`';
		$join = array(
			'`student`'				=> '`student_subject`.`student_id` = `student`.`student_id`',
			'`subject`'				=> '`student_subject`.`subject` = `subject`.`subject_id`',
			'`room`'				=> '`student_subject`.`room` = `room`.`room_id`',
			'`vocational_program`' 	=> '`student_subject`.`vocational_program` = `vocational_program`.`voc_program_id`',
			'`batch_year`' 			=> '`student_subject`.`batch_year` = `batch_year`.`batch_year_id`'
		);
		return $this->crud->getJoinDataWithSort($select,$return_type,$condition,$join,'`student`.`arabic_name` ASC ,`subject`.`subject_title` ASC','tbl9');
	}

	/**
	 * processStundentSchedule function.
	 * 
	 * @access private
	 * @param associative array $schedule
	 * @return boolean TRUE on success.
	 */
	public function processStundentSchedule($schedule = array()){
		$condition = array(
			'room_id'		=> $schedule['room_id'],
			'day'			=> $schedule['day'],
			'time'			=> $schedule['time'],
			'is_active'		=> $schedule['is_active'],
			'batch_year_id' => $schedule['batch_year_id']
		);
		if($this->isScheduleValid($condition)==TRUE){
			$this->crud->setData($schedule,'','tbl10');
			$this->user_model->recordLogs('New Schedule has been created',$this->session->userdata('user_id'));
			return TRUE;
		}else{
			if($this->isScheduleValid($schedule)==FALSE){
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * isScheduleValid function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @return boolean TRUE on valid.
	 */
	public function isScheduleValid($condition = array()){
		if($this->crud->getData('','c',$condition,'tbl10') > 0){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * isSubjectValid function.
	 * 
	 * @access private
	 * @param mixed $subejct
	 * @return boolean TRUE on valid.
	 */
	public function isSubjectValid($subject = array()){
		$condition = array(
			'student_id'	=> $subject['student_id'],
			'subject' 		=> $subject['subject'],
			'subject_code'	=> $subject['subject_code'],
			'batch_year'	=> $subject['batch_year']
		);
		$valid = $this->crud->getData('','c',$condition,'tbl9');
		if($valid > 0){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * validateStudentsSubject function.
	 * 
	 * @access private
	 * @param array $students
	 * @param associative array $subjects
	 * @return array list of valid students.
	 */
	public function validateStudentsSubject($students = array(),$subjects = array()){
		$new_students = array();
		$con = array(
			'subject' 		=> $subjects['subject'],
			'subject_code'	=> $subjects['subject_code'],
			'is_active'		=> 'true',
			'batch_year'	=> $subjects['batch_year']
		);
		for ($i=0; $i < count($students); $i++) { 
			$con['student_id'] = $students[$i];
			$count = $this->crud->getData('','c',$con,'tbl9');
			if($count > 0){
				
			}else{
				$new_students[] = $students[$i];
			}
		}
		return $new_students;
	}

	/**
	 * validateStudentsSubjectOnScheduleUpdate function.
	 * commit 10/12/2018
	 * 
	 * @access private
	 * @param array $students
	 * @param associative array $subjects
	 * @return boolean true on success.
	 */
	public function validateStudentsSubjectOnScheduleUpdate($students = array(),$subjects = array()){
		$new_students = array();
		$con = array(
			'subject' 		=> $subjects['subject'],
			'subject_code'	=> $subjects['subject_code'],
			'is_active'		=> 'true',
			'batch_year'	=> $subjects['batch_year']
		);
		for ($i=0; $i < count($students); $i++) { 
			$con['student_id'] = $students[$i]['student_id'];
			$con['tbl_id !=']  = $students[$i]['tbl_id'];
			$count = $this->crud->getData('','c',$con,'tbl9');
			if($count > 0){
				
			}else{
				$new_students[] = $students[$i];
			}
		}
		if(count($students)==count($new_students)){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * validateStudentsSchedule function.
	 * 
	 * @access private
	 * @param array $students
	 * @param associative array $subjects
	 * @return array list of valid students.
	 */
	public function validateStudentsSchedule($students = array(),$subjects = array()){
		$new_students = array();
		$con = array(
			'day'		=> $subjects['day'],
			'time'		=> $subjects['time'],
			'is_active'	=> 'true',
			'batch_year'=> $subjects['batch_year']
		);
		for ($i=0; $i < count($students); $i++) { 
			$con['student_id'] = $students[$i];
			$count = $this->crud->getData('','c',$con,'tbl9');
			if($count > 0){
				
			}else{
				$new_students[] = $students[$i];
			}
		}
		return $new_students;
	}

	/**
	 * validateStudentsScheduleOnScheduleUpdate function.
	 * commit 10/12/2018
	 * 
	 * @access private
	 * @param array $students
	 * @param associative array $subjects
	 * @return boolean true on success.
	 */
	public function validateStudentsScheduleOnScheduleUpdate($students = array(),$subjects = array()){
		$new_students = array();
		$con = array(
			'day'		=> $subjects['day'],
			'time'		=> $subjects['time'],
			'is_active'	=> 'true',
			'batch_year'=> $subjects['batch_year']
		);
		for ($i=0; $i < count($students); $i++) { 
			$con['student_id'] = $students[$i]['student_id'];
			$con['tbl_id !=']  = $students[$i]['tbl_id'];
			$count = $this->crud->getData('','c',$con,'tbl9');
			if($count > 0){
				
			}else{
				$new_students[] = $students[$i];
			}
		}
		if(count($students)==count($new_students)){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * isStudentSubjectValid function.
	 * 
	 * @access private
	 * @param int $student_id
	 * @param associative array $subjects
	 * @param int $tbl_id
	 * @return boolean TRUE on success.
	 */
	public function isStudentSubjectValid($student_id,$subjects = array(),$tbl_id){
		$con = array(
			'subject' 		=> $subjects['subject'],
			'subject_code'	=> $subjects['subject_code'],
			'batch_year'	=> $subjects['batch_year'],
			'student_id'	=> $student_id,
			'tbl_id !='		=> $tbl_id
		);
		$count = $this->crud->getData('','c',$con,'tbl9');
		if($count > 0){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * isStudentScheduleValid function.
	 * 
	 * @access private
	 * @param int $student_id
	 * @param associative array $schedule
	 * @param int $tbl_id
	 * @return boolean TRUE on success.
	 */
	public function isStudentScheduleValid($student_id,$schedule = array(),$tbl_id){
		$condition = array(
			'day'		 => $schedule['day'],
			'time'		 => $schedule['time'],
			'is_active'	 => 'true',
			'batch_year' => $schedule['batch_year_id'],
			'student_id' => $student_id,
			'tbl_id !='	 => $tbl_id
		);
		$count = $this->crud->getData('','c',$condition,'tbl9');
		if($count > 0){
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * transformScheduleRange function.
	 * 
	 * @access private
	 * @param mixed $time
	 * @return mixed time range on success.
	 */
	public function transformScheduleRange($time){
		$start_time = "";
		$end_time	= "";
		if($time<='12:00:00'){
			$start_time = rtrim(rtrim($time,'0'),':').'AM';
			if($time=='11:30:00'){
				$end_time	= rtrim(rtrim(date('H:i:s', strtotime('+1 hour +30 minutes',strtotime($time))),'0'),':').'PM';
			}else{
				$end_time	= rtrim(rtrim(date('H:i:s', strtotime('+1 hour +30 minutes',strtotime($time))),'0'),':').'AM';
			}
		}else{
			if($time=='12:30:00'){
				$start_time = rtrim(rtrim($time,'0'),':').'PM';
			}else{
				$start_time = rtrim(rtrim(date('H:i:s', strtotime('-12 hours',strtotime($time))),'0'),':').'PM';
			}
			$end_time	= rtrim(rtrim(date('H:i:s', strtotime('-10 hours -30 minutes',strtotime($time))),'0'),':').'PM';
		}
		return $start_time." - ".$end_time;
	}

	/**
	 * removeStudentRegistration function.
	 * 
	 * @access public
	 * @param array $table_id
	 * @return boolean TRUE on success.
	 */
	public function removeStudentRegistration($table_id = array()){
		if(!empty($table_id)){
			for ($i=0; $i < count($table_id); $i++) { 
				$this->crud->deleteData(array('tbl_id'=>$table_id[$i]),'tbl9');
			}
			return TRUE;
		}
		return FALSE;
	}

	// /**
	//  * countTableRows function.
	//  * 
	//  * @access public
	//  * @return int count of table rows on success.
	//  */
	// public function countTableRows(){
	// 	return $this->crud->getData('','c',array('is_active'=>'true'),'tbl9');
	// 	// return $this->db->count_all($table_name);
	// }

	/**
	 * getPaginationEnrolledStudents function.
	 * 
	 * @access public
	 * @param int $limit
	 * @param int $start
	 * @param associative array $condition
	 * @return boolean|associative array on success.
	 */
	public function getPaginationEnrolledStudents($limit,$start,$condition){
		$select = '`student_subject`.`tbl_id`, `student_subject`.`student_id`, `student`.`student_no`, `student`.`arabic_name`, `subject`.`subject_title`, `subject_code`, `time`, `room`.`room_name`, `day`, `vocational_program`.`voc_program_acronym`, `batch_year`.`batch_name`, `student_subject`.`subject`, `student_subject`.`room`, `student_subject`.`vocational_program`, `student_subject`.`batch_year`, `student_subject`.`created_by`, `student_subject`.`created`, `student_subject`.`updated_by`, `student_subject`.`modified`';
		$join = array(
			'`student`'				=> '`student_subject`.`student_id` = `student`.`student_id`',
			'`subject`'				=> '`student_subject`.`subject` = `subject`.`subject_id`',
			'`room`'				=> '`student_subject`.`room` = `room`.`room_id`',
			'`vocational_program`' 	=> '`student_subject`.`vocational_program` = `vocational_program`.`voc_program_id`',
			'`batch_year`' 			=> '`student_subject`.`batch_year` = `batch_year`.`batch_year_id`'
		);
		$order = '`student`.`arabic_name` ASC ,`subject`.`subject_title` ASC';
		return $this->crud->get_paginated_data($select,$condition,$join,$order,array($limit,$start),'tbl9');
		// $this->db->select($select);
		// $this->db->from('student_subject');
		// // join table
		// foreach ($join as $key => $value) {
		// 	$this->db->join($key,$value);
		// }
		// // where condition
		// foreach ($condition as $key => $value) {
		// 	$this->db->where($key,$value);
		// }
		// $this->db->order_by($order);
		// $this->db->limit($limit,$start);
		// $query = $this->db->get();
		// return $query->result_array();
	}

	// /**
	//  * paginationConfig function.
	//  * 
	//  * @access public
	//  * @param int $per_page
	//  * @return pagination config on success.
	//  */
	// public function paginationConfig($per_page,$total_rows){
	// 	// pagination config
 //        $config = array();
 //        $config["base_url"] = base_url() . "register_student";
 //        $config["total_rows"] = $total_rows;
 //        $config["per_page"] = $per_page;
 //        $config["uri_segment"] = 2;

 //        //config for bootstrap pagination class integration
 //        $config['full_tag_open'] = '<ul class="pagination">';
 //        $config['full_tag_close'] = '</ul>';
 //        $config['first_link'] = false;
 //        $config['last_link'] = false;
 //        $config['first_tag_open'] = '<li>';
 //        $config['first_tag_close'] = '</li>';
 //        $config['prev_link'] = '&laquo';
 //        $config['prev_tag_open'] = '<li class="paginate_button page-item previous page-link" id="example_previous">';
 //        $config['prev_tag_close'] = '</li>';
 //        $config['next_link'] = '&raquo';
 //        $config['next_tag_open'] = '<li class="paginate_button page-item next page-link" id="example_next">';
 //        $config['next_tag_close'] = '</li>';
 //        $config['last_tag_open'] = '<li>';
 //        $config['last_tag_close'] = '</li>';
 //        $config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="#" aria-controls="example" data-dt-idx="2" tabindex="0" class="page-link">';
 //        $config['cur_tag_close'] = '</a></li>';
 //        $config['num_tag_open'] = '<li class="paginate_button page-item page-link">';
 //        $config['num_tag_close'] = '</li>';
 //        return $config;
	// }

	/**
	 * getStudentId function.
	 * 
	 * @access public
	 * @param array $student_no
	 * @return array|false array on success.
	 */
	public function getStudentId($student_no = array()){
		if(!empty($student_no)){
			$student_id = array();
			for ($i=0; $i < count($student_no); $i++) { 
				$condition = array('student_no'=>$student_no[$i]);
				$student = $this->crud->getData('student_id','s',$condition,'tbl2');
				if(!empty($student)){
					$student_id[] = $student['student_id'];
				}
			}
			return $student_id;
		}
		return FALSE;
	}

}