<?php
class Faculty_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
		$this->load->model('student_model');
		// $this->load->model('faculty_model');
		$this->load->model('user_model');
	}

	/**
	 * getStudentsEnrolledWithAttendance function.
	 * 
	 * @access public
	 * @param associative array $schedule
	 * @param mixed $attendance_date
	 * @return associative array on success.
	 */
	public function getStudentsEnrolledWithAttendance($schedule,$attendance_date){
		$condition = array(
            'subject'       => $schedule['subject_id'],
            'subject_code'  => $schedule['subject_code'],
            'room'          => $schedule['room_id'],
            'day'           => $schedule['day'],
            'time'          => $schedule['time'],
            'batch_year'    => $schedule['batch_year_id']
        );
        $students = $this->student_model->getEnrolledStudent($condition,'a');
        return $this->getStudentAttendanceAndRemarks($students,$attendance_date);
	}

	/**
	 * getStudentAttendanceAndRemarks function.
	 * 
	 * @access public
	 * @param associative array $students
	 * @return associative array on success.
	 */
	public function getStudentAttendanceAndRemarks($students,$attendance_date){
		if(!empty($students)){
			for ($i=0; $i < count($students); $i++) { 
				$condition = array(
					'student_id'	=> $students[$i]['student_id'],
					'subject_id'	=> $students[$i]['subject'],
					'subject_code'	=> $students[$i]['subject_code'],
					'batch_year_id'	=> $students[$i]['batch_year'],
					'attendance_date'=> $attendance_date
				);
				$data = $this->crud->getData('attendance,remarks','s',$condition,'tbl11');
				$students[$i]['attendance'] = $data['attendance'];
				$students[$i]['attendance_remarks'] = $data['remarks'];
			}
		}
		return $students;
	}

	/**
	 * updateDailyAttendanceRecord function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param associative array $attendance
	 * @return boolean TRUE on success.
	 */
	public function updateDailyAttendanceRecord($condition = array(), $attendance = array()){
		$con = array(
			'student_id'    => $condition['student_id'],
            'batch_year_id' => $condition['batch_year_id'],
            'attendance_date' => $condition['attendance_date']
		);
		$data = $this->crud->getData('','a',$con,'tbl11');
		$dtr  = $this->crud->getData('','c',$con,'tbl12');
		if(!empty($data)){
			$p = 0;
			$a = 0;
			$l = 0;
			$v = 0;
			for ($i=0; $i < count($data); $i++) { 
				if($data[$i]['attendance']=='P'){
					$p++;
				}else if($data[$i]['attendance']=='A'){
					$a++;
				}else if($data[$i]['attendance']=='L'){
					$l++;
				}else if($data[$i]['attendance']=='V'){
					$v++;
				}
			}
			if($p > $a || $p > $l){
				if(!empty($dtr)){
					$this->crud->updateData(array('attendance'=>'P'),$con,'tbl12');
				}else{
					$con['attendance'] = 'P';
					$this->crud->setData($con,'','tbl12');
				}
			}else if($a > $p || $a > $l){
				if(!empty($dtr)){
					$this->crud->updateData(array('attendance'=>'A'),$con,'tbl12');
				}else{
					$con['attendance'] = 'A';
					$this->crud->setData($con,'','tbl12');
				}
			}else if($l > $a || $l > $p){
				if(!empty($dtr)){
					$this->crud->updateData(array('attendance'=>'L'),$con,'tbl12');
				}else{
					$con['attendance'] = 'L';
					$this->crud->setData($con,'','tbl12');
				}
			}else if($v > 0){
				if(!empty($dtr)){
					$this->crud->updateData(array('attendance'=>'V'),$con,'tbl12');
				}else{
					$con['attendance'] = 'V';
					$this->crud->setData($con,'','tbl12');
				}
			}else{
				if(!empty($dtr)){
					$this->crud->updateData(array('attendance'=>'P'),$con,'tbl12');
				}else{
					$con['attendance'] = 'P';
					$this->crud->setData($con,'','tbl12');
				}
			}
		}else{
			if(!empty($dtr)){
				$this->crud->updateData(array('attendance'=>$attendance['attendance']),$con,'tbl12');
			}else{
				$con['attendance'] = $attendance['attendance'];
				$this->crud->setData($con,'','tbl12');
			}
		}
		return TRUE;
	}

	/**
	 * getFacultyAttendanceRecords function.
	 * 
	 * @access public
	 * @param associative array $condition
	 * @param char $return_type
	 * @return associative array on success.
	 */
	public function getFacultyAttendanceRecords($condition,$return_type){
		$select = '`attendance_record`.`student_id`, `student`.`student_no`, `student`.`arabic_name`, `attendance_record`.`subject_id`, `subject`.`subject_title`, `attendance_record`.`subject_code`, `attendance`, `attendance_record`.`remarks`, `attendance_date`, `attendance_record`.`batch_year_id`, `batch_year`.`batch_name`, `attendance_record`.`created`, `attendance_record`.`modified`';
		$join = array(
			'`student`'=>'`attendance_record`.`student_id` = `student`.`student_id`',
			'`subject`'=>'`attendance_record`.`subject_id` = `subject`.`subject_id`',
			'`batch_year`'=>'`attendance_record`.`batch_year_id` = `batch_year`.`batch_year_id`'
		);
		return $this->crud->getJoinData($select,$return_type,$condition,$join,'tbl11');
	}

	/**
	 * authenticateFacultyAssigned function.
	 * 
	 * @access public
	 * @param int $schedule_id
	 * @param string $schedule_day
	 * @return boolean array on success.
	 */
	public function authenticateFacultyAssigned($schedule_id,$schedule_day){
		$condition = array(
			'schedule_id' 		=> $schedule_id,
			'faculty_assigned'	=> $this->session->userdata('user_id')
		);
		$schedule = $this->crud->getData('','c',$condition,'tbl10');
		if($schedule > 0 && $schedule_day==strtoupper(date('l'))){
			return TRUE;
		}else if($this->session->userdata('designation')=='Administrator' || $this->session->userdata=='Registrar'){
			return TRUE;
		}else if(($schedule > 0) &&($this->session->userdata('designation')=='Faculty' && $schedule_day!=strtoupper(date('l')))){
			return TRUE;
		}
		return redirect('unauthorized_access');
	}

	/**
	 * processMassAttendanceAction function.
	 * 
	 * @access public
	 * @param array $schedule_id
	 * @param associative array $attendance
	 * @param associative array $condition
	 * @return boolean TRUE on success.
	 */
	public function processMassAttendanceAction($student_id = array(), $attendance = array(), $condition = array()){
	    for ($i=0; $i < count($student_id); $i++) { 
	        $condition['student_id'] = $student_id[$i];
	        $data = $this->crud->getData('','c',$condition,'tbl11');
	        if($data > 0){
	        	// update attendance record
	            $this->crud->updateData($attendance,$condition,'tbl11');
	            // update daily attendance record
	            $this->updateDailyAttendanceRecord($condition,$attendance);
	            $this->user_model->recordLogs('Update Student Attendance Record',$this->session->userdata('user_id'));
	        }else{
	            $attendance_data = array(
	                'student_id'      => $condition['student_id'],
	                'subject_id'      => $condition['subject_id'],
	                'subject_code'    => $condition['subject_code'],
	                'attendance'      => $attendance['attendance'],
	                'attendance_date' => $condition['attendance_date'],
	                'batch_year_id'   => $condition['batch_year_id'],
	                'created_by'      => $this->session->userdata('user_id')
	            );
	            // set attendance record
	            $this->crud->setData($attendance_data,'','tbl11');
	            // update daily attendance record
	            $this->updateDailyAttendanceRecord($condition,$attendance);
	            $this->user_model->recordLogs('Add new Student Attendance Record',$this->session->userdata('user_id'));
	        }
	    }
	    return TRUE;
	}

	/**
	 * getScheduledDate function.
	 * get schedule date by day
	 * @access public
	 * @param string $schedule_day
	 * @return boolean|date('Y-m-d') date on success.
	 */
	public function getScheduledDate($schedule_day){
		if(!empty($schedule_day)){
			$dayofweek = date('w', strtotime($schedule_day));
		    if($dayofweek>=date('w')){
		    	$result = date('Y-m-d', strtotime($schedule_day));
		    }else{
		   		$result = date('Y-m-d', strtotime('-7 days',strtotime($schedule_day)));
		    }
		    return $result;
		}
		return FALSE;
	}

}