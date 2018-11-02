<?php
class Room_model extends CI_Model {

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
	 * @return associative array list or single room on success.
	 */
	public function getRooms($return_type,$condition){
		$data = $this->crud->getData('',$return_type,$condition,'tbl5');
		return $this->getRoomsCreator($data);
	}

	/**
	 * getRoomsCreator function.
	 * 
	 * @access private
	 * @param associative array $users
	 * @return associative array list or single room on success.
	 */
	private function getRoomsCreator($room = array()){
		if(!empty($room)){
			if(array_key_exists('room_id', $room)){
				$created_by = $this->crud->getData('u_full_name','s',array('user_id'=>$room['created_by']),'tbl1');
				$updated_by = $this->crud->getData('u_full_name','s',array('user_id'=>$room['updated_by']),'tbl1');
				$room['created_by'] = $created_by['u_full_name'];
				$room['updated_by'] = $updated_by['u_full_name'];
			}else{
				for ($i=0; $i < count($room); $i++) { 
					$created_by = $this->crud->getData('u_full_name','s',array('user_id'=>$room[$i]['created_by']),'tbl1');
					$updated_by = $this->crud->getData('u_full_name','s',array('user_id'=>$room[$i]['updated_by']),'tbl1');
					$room[$i]['created_by'] = $created_by['u_full_name'];
					$room[$i]['updated_by'] = $updated_by['u_full_name'];
				}
			}
		}
		return $room;
	}

	/**
	 * getRoomsCreator function.
	 * 
	 * @access public
	 * @param int $batch_year
	 * @return associative array list of schedules on success.
	 */
	public function getSchedules($condition,$return_type){
		$select = '`schedule_id`, `subject`.`subject_id`, `subject`.`subject_title`, `subject_code`, `time`, `schedule`.`room_id`, `room`.`room_name`, `day`, `schedule`.`batch_year_id`, `batch_year`.`batch_name`, `schedule`.`created`, `faculty_assigned`, `user_credential`.`u_full_name`, `schedule`.`is_active`';
		$join = array(
			'`subject`'		=>'`schedule`.`subject_id` = `subject`.`subject_id`',
			'`room`'		=>'`schedule`.`room_id` = `room`.`room_id`',
			'`batch_year`'	=>'`schedule`.`batch_year_id` = `batch_year`.`batch_year_id`',
			'`user_credential`'=>'`schedule`.`faculty_assigned` = `user_credential`.`user_id`'
		);
		return $this->crud->getJoinData($select,$return_type,$condition,$join,'tbl10');
	}

	/**
	 * getRoomsCreator function.
	 * 
	 * @access public
	 * @param int $schedule_id
	 * @return associative array of schedules on success.
	 */
	public function getScheduleById($schedule_id){
		$select = '`schedule_id`, `schedule`.`schedule_id`,	`schedule`.`subject_id`, `subject`.`subject_title`, `subject_code`, `time`, `schedule`.`room_id`, `room`.`room_name`, `day`, `schedule`.`batch_year_id`, `batch_year`.`batch_name`, `schedule`.`created`, `faculty_assigned`';
		$join = array('`subject`'=>'`schedule`.`subject_id` = `subject`.`subject_id`','`room`'=>'`schedule`.`room_id` = `room`.`room_id`','`batch_year`'=>'`schedule`.`batch_year_id` = `batch_year`.`batch_year_id`');
		$condition = array('`schedule`.`schedule_id`'=>$schedule_id);
		return $this->crud->getJoinData($select,'s',$condition,$join,'tbl10');
	}

	/**
	 * getFacultyAssigned function.
	 * 
	 * @access public
	 * @param associative array $schedule
	 * @return associative array on success.
	 */
	public function getFacultyAssigned($schedule = array()){
		$faculty = $this->crud->getData('u_full_name','s',array('user_id'=>$schedule['faculty_assigned']),'tbl1');
		$schedule['faculty_assigned'] = $faculty['u_full_name'];
		return $schedule;
	}

	/**
	 * getFacultyAssigned function.
	 * 
	 * @access public
	 * @param associative array $schedule
	 * @return boolean TRUE on success.
	 */
	public function deleteRoomPermanently($room_id = array()){
		if(!empty($room_id)){
			for ($i=0; $i < count($room_id); $i++) { 
				$this->crud->deleteData(array('room_id'=>$room_id[$i]),'tbl5');
				$this->crud->deleteData(array('room_id'=>$room_id[$i]),'tbl10');
				$this->crud->deleteData(array('room'=>$room_id[$i]),'tbl9');
			}
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * getMultipleSchedules function.
	 * 
	 * @access public
	 * @param array $schedule_id
	 * @return associative array on success.
	 */
	public function getMultipleSchedules($schedule_id = array()){
		$schedules = array();
		if(!empty($schedule_id)){
			for ($i=0; $i < count($schedule_id); $i++) { 
				$schedules[$i] = $this->getScheduleById($schedule_id[$i]);
			}
			return $schedules;
		}
		return FALSE;
	}

}