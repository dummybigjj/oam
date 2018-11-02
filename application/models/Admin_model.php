<?php
class Admin_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
	}

	/**
	 * getHistoryLogs function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param int $limit
	 * @param int $start
	 * @return associative array on success.
	 */
	public function get_history_logs($condition = array(),$limit,$start)
	{
		$select = '`tbl_id`, `activity`, `user_credential`.`u_full_name`, `user_credential`.`u_email_address`, `user_credential`.`designation`, `device_use`, `history_logs`.`device_name`, `history_logs`.`device_ip_address`, `history_logs`.`created`';
		$join = array('`user_credential`'=>'`history_logs`.`created_by` = `user_credential`.`user_id`');
		$order= '`history_logs`.`created` DESC';
		if(!empty($condition)){
			return $this->crud->getJoinDataWithSort($select,'s',$condition,$join,$order,'tbl4');
		}
		return $this->crud->get_paginated_data($select,$condition,$join,$order,array($limit,$start),'tbl4');
	}

	/**
	 * getHistoryLogsById function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @return associative array on success.
	 */
	public function getHistoryLogsById($condition = array()){
		$select = '`tbl_id`, `activity`, `user_credential`.`u_full_name`, `user_credential`.`u_email_address`, `user_credential`.`designation`, `device_use`, `history_logs`.`device_name`, `history_logs`.`device_ip_address`, `history_logs`.`created`';
		$join   = array('`user_credential`'=>'`history_logs`.`created_by` = `user_credential`.`user_id`');
		return $this->crud->getJoinDataWithSort($select,'s',$condition,$join,'`history_logs`.`created` ASC','tbl4');
	}

	/**
	 * getSecurityConfig function.
	 * 
	 * @access public
	 * @return associative array on success.
	 */
	public function getSecurityConfig(){
		$select = '`max_login_attempt`, `soft_lock`, `max_password_age`, `user_credential`.`u_full_name`, `user_credential`.`designation`, `security_config`.`modified`';
		$join   = array('`user_credential`'=>'`security_config`.`updated_by` = `user_credential`.`user_id`');
		return $this->crud->getJoinData('','s','',$join,'tbl3');
	}

	/**
	 * getStudentsBasicInfo function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param char $return_type
	 * @return associative array on success.
	 */
	public function getStudentsBasicInfo($condition,$return_type){
		$select = '`student_subject`.`student_id`, `student`.`student_no`, `student`.`arabic_name`, `student`.`english_name`, `student`.`remarks` as preferred_course';
		$join   = array('`student`'=>'`student_subject`.`student_id` = `student`.`student_id`');
		$data   = $this->crud->getJoinDataWithSort($select,$return_type,$condition,$join,'`student`.`arabic_name` ASC','tbl9');
		return $this->removeDuplicateData($data,'student_id');
	}

	/**
	 * getStudentsBasicInfo function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param char $return_type
	 * @return associative array on success.
	 */
	public function getStudentsInfo($condition,$return_type){
		$select = '`student_subject`.`student_id`, `student`.`student_no`, `student`.`arabic_name`, `student`.`english_name`, `student`.`remarks` as preferred_course';
		$join   = array('`student`'=>'`student_subject`.`student_id` = `student`.`student_id`');
		$data   = $this->crud->getJoinDataWithSort($select,$return_type,$condition,$join,'`student`.`arabic_name` ASC','tbl9');
		return $this->removeDuplicateDataOnAssociativeArray($data,'student_id');
	}

	/**
	 * getSubjectCodeOpenedForSpecificBatchYear function.
	 * 
	 * @access public
	 * @param int $batch_year_id
	 * @return associative array on success.
	 */
	public function getSubjectCodeOpenedForSpecificBatchYear($batch_year_id){
		$condition = array('batch_year' => $batch_year_id);
		$data = $this->crud->getDataWithSort('','a',$condition,'subject_code ASC','tbl9');
		return $this->removeDuplicateData($data,'subject_code');
	}

	/**
	 * removeDuplicateData function.
	 * 
	 * @access public
	 * @param associative array $data
	 * @param mixed $unique_key
	 * @return associative array on success.
	 */
	public function removeDuplicateData($data = array(),$unique_key){
		$temp = '';
		$new_data = array();
		for ($i=0; $i < count($data); $i++) { 
			if($data[$i][$unique_key]!=$temp){
				$new_data[] = $data[$i];				
			}
			$temp = $data[$i][$unique_key];
		}
		return $new_data;
	}

	/**
	 * removeDuplicateDataOnAssociativeArray function.
	 * 
	 * @access public
	 * @param associative array $data
	 * @param mixed $unique_key
	 * @return associative array on success.
	 */
	public function removeDuplicateDataOnAssociativeArray($data = array(),$unique_key){
		$temp = array();
		$new_data = array();
		for ($i=0; $i < count($data); $i++) { 
			if(!empty($temp)){
				$ct = 0;
				for ($a=0; $a < count($temp); $a++) { 
					if($data[$i][$unique_key]==$temp[$a]){
						$ct++;
					}
				}
				if($ct==0){
					$new_data[] = $data[$i];
				}
			}else{
				$new_data[] = $data[$i];
			}
			$temp[] = $data[$i][$unique_key];
		}
		return $new_data;
	}

	/**
	 * getStudentDailyAttendanceRecord function.
	 * 
	 * @access public
	 * @param associative array $students
	 * @return associative array on success.
	 */
	public function getStudentDailyAttendanceRecord($students = array(), $range1, $range2, $batch_year_id){
		if(!empty($students)){

			$condition = array(
				'attendance_date <=' => $range2,
				'attendance_date >=' => $range1,
				'batch_year_id' 	 => $batch_year_id
			);
			for ($i=0; $i < count($students); $i++) { 
				$condition['student_id'] = $students[$i]['student_id'];
				// GET ABSENCES
				$condition['attendance'] = 'A';
				$absences = $this->crud->getData('','c',$condition,'tbl12');
				$students[$i]['absences'] = $absences;
				// GET LATES
				$condition['attendance'] = 'L';
				$lates = $this->crud->getData('','c',$condition,'tbl12');
				$students[$i]['lates'] = $lates;

				// GET EXCUSE
				$condition['attendance'] = 'E';
				$excuses = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['excuses'] = $excuses;

				// GET VACATIONS
				$condition['attendance'] = 'V';
				$vacations = $this->crud->getData('','c',$condition,'tbl12');
				$students[$i]['vacations'] = $vacations;
				// GET PRESENTS AND COUNT POINTS
				$condition['attendance'] = 'P';
				$presents = $this->crud->getData('','c',$condition,'tbl12');
				$students[$i]['presents'] = $presents;
				$students[$i]['points'] = ($presents * 2) + ($vacations * 2) + $lates;
				// SET REMARKS
				if($absences > 0 && $absences <= 2){
					$students[$i]['remarks'] = 'W1';
				}else if($absences >= 3 && $absences <= 5){
					$students[$i]['remarks'] = 'W2';
				}else if($absences >= 6 && $absences <=13){
					$students[$i]['remarks'] = 'W3';
				}else if($absences > 13){
					$students[$i]['remarks'] = 'DN/For Removal';
				}else{
					$students[$i]['remarks'] = 'SA';
				}
			}
		}
		return $students;
	}

	/**
	 * getStudentSubjectCodeAttendanceRecord function.
	 * 
	 * @access public
	 * @param associative array $students
	 * @return associative array on success.
	 */
	public function getStudentSubjectCodeAttendanceRecord($students = array(), $range1, $range2, $subject_code, $batch_year_id){
		if(!empty($students)){
			$condition = array(
				'subject_code'	 	 => $subject_code,
				'attendance_date <=' => $range2,
				'attendance_date >=' => $range1,
				'batch_year_id' 	 => $batch_year_id
			);
			for ($i=0; $i < count($students); $i++) { 
				$condition['student_id'] = $students[$i]['student_id'];
				// GET ABSENCES
				$condition['attendance'] = 'A';
				$absences = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['absences'] = $absences;
				// GET LATES
				$condition['attendance'] = 'L';
				$lates = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['lates'] = $lates;

				// GET EXCUSE
				$condition['attendance'] = 'E';
				$excuses = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['excuses'] = $excuses;
				
				// GET VACATIONS
				$condition['attendance'] = 'V';
				$vacations = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['vacations'] = $vacations;
				// GET PRESENTS AND COUNT POINTS
				$condition['attendance'] = 'P';
				$presents = $this->crud->getData('','c',$condition,'tbl11');
				$students[$i]['presents'] = $presents;
				$students[$i]['points'] = ($presents * 2) + ($vacations * 2) + $lates;
				// SET REMARKS
				if($absences > 0 && $absences <= 2){
					$students[$i]['remarks'] = 'W1';
				}else if($absences >= 3 && $absences <= 5){
					$students[$i]['remarks'] = 'W2';
				}else if($absences >= 6 && $absences <=13){
					$students[$i]['remarks'] = 'W3';
				}else if($absences > 13){
					$students[$i]['remarks'] = 'DN/For Removal';
				}else{
					$students[$i]['remarks'] = 'SA';
				}
			}
		}
		return $students;
	}

	/** 
	 * getStudentAttendanceBySubjectCode function.
	 * 10/10/2018 commit
	 * 
	 * @access public
	 * @param date $range1
	 * @param date $range2
	 * @param mixed $subject_code
	 * @param int $batch_year_id
	 * @return associative array|boolean attendance record by subject code on success.
	 */
	public function getStudentAttendanceBySubjectCode($range1, $range2, $subject_code, $batch_year_id){
		$condition = array(
			'subject_code'	 	 => $subject_code,
			'attendance_date <=' => $range2,
			'attendance_date >=' => $range1,
			'batch_year_id' 	 => $batch_year_id
		);
		return $this->crud->getDataWithSort('','a',$condition,'attendance_date ASC','tbl11');
	}

	/** 
	 * getStudentAttendanceByVocationalProgram function.
	 * 10/11/2018 commit
	 * 
	 * @access public
	 * @param associative array $students
	 * @param date $range1
	 * @param date $range2
	 * @param int $batch_year_id
	 * @return associative array|boolean attendance record by vocational program on success.
	 */
	public function getStudentAttendanceByVocationalProgram($students = array(),$range1,$range2,$batch_year_id){
		$condition = array(
			'range2' => $range2,
			'range1' => $range1,
			'batch_year_id' => $batch_year_id
		);
		$this->db->select('*');
		$this->db->from('attendance_daily_record');
		for ($i=0; $i < count($students); $i++) { 
			$this->db->or_where('student_id',$students[$i]['student_id']);
		}
		$this->db->order_by('attendance_date ASC');
		$query = $this->db->get();
		return $this->getAttendanceWithinDateRange($query->result_array(),$condition);
	}

	/** 
	 * getStudentsDailyAttendanceRecord function.	 
	 * 
	 * @access public
	 * @param int $batch_year_id
	 * @param date $range1
	 * @param date $range2
	 * @return associative array attendance record on success.
	 */
	public function getStudentsDailyAttendanceRecord($batch_year_id,$range1,$range2){
		$this->db->select('*');
		$this->db->from('attendance_daily_record');
		$this->db->where('batch_year_id',$batch_year_id);
		$this->db->where('attendance_date >=',$range1);
		$this->db->where('attendance_date <=',$range2);
		$this->db->order_by('attendance_date ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	/** 
	 * getAttendanceWithinDateRange function.
	 * 10/11/2018 commit
	 * 
	 * @access public
	 * @param associative array $attendance
	 * @param associative array $condition
	 * @return associative array|boolean attendance record by vocational program on success.
	 */
	public function getAttendanceWithinDateRange($attendance = array(),$condition = array()){
		$new_attendance = array();
		for ($i=0; $i < count($attendance); $i++) { 
			if($attendance[$i]['attendance_date']>=$condition['range1'] && $attendance[$i]['attendance_date']<=$condition['range2'] && $attendance[$i]['batch_year_id']==$condition['batch_year_id']){
				$new_attendance[] = $attendance[$i];
			}
		}
		return $new_attendance;
	}

	/** 
	 * getStudentAttendanceRecord function.
	 * 10/7/2018 commits
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param char $return_type
	 * @return associative array on success.
	 */
	public function getStudentAttendanceRecord($condition,$return_type){
		$select = '`attendance_record`.`student_id`, `subject`.`subject_title`, `subject_code`, `student`.`student_no`, `student`.`arabic_name`, `student`.`english_name`, `student`.`remarks` as preferred_course, `attendance`, `attendance_record`.`remarks`';
		$join   = array(
			'`student`'=>'`attendance_record`.`student_id` = `student`.`student_id`',
			'`subject`'=>'`attendance_record`.`subject_id` = `subject`.`subject_id`'
		);
		return $this->crud->getJoinDataWithSort($select,$return_type,$condition,$join,'`attendance_date` ASC','tbl11');
	}

}