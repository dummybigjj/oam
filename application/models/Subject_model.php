<?php
class Subject_model extends CI_Model {

    public function __construct(){
		parent::__construct();
		$this->load->model('crud');
		$this->load->model('batch_year_model');
		$this->load->model('user_model');
        $this->load->model('student_model');

	}

	/**
	 * getSubjects function.
	 * 
	 * @access public
	 * @param char $return_type
	 * @param associative array $conditions
	 * @return associative array list or single subject on success.
	 */
	public function getSubjects($return_type,$condition){
		$data = $this->crud->getData('',$return_type,$condition,'tbl7');
		return $this->getSubjectsCreator($data);
	}

	/**
	 * getRoomsCreator function.
	 * 
	 * @access private
	 * @param associative array $users
	 * @return associative array list or single subject on success.
	 */
	private function getSubjectsCreator($subject = array()){
		if(!empty($subject)){
			if(array_key_exists('subject_id', $subject)){
				$created_by = $this->crud->getData('u_full_name','s',array('user_id'=>$subject['created_by']),'tbl1');
				$updated_by = $this->crud->getData('u_full_name','s',array('user_id'=>$subject['updated_by']),'tbl1');
				$subject['created_by'] = $created_by['u_full_name'];
				$subject['updated_by'] = $updated_by['u_full_name'];
			}else{
				for ($i=0; $i < count($subject); $i++) { 
					$created_by = $this->crud->getData('u_full_name','s',array('user_id'=>$subject[$i]['created_by']),'tbl1');
					$updated_by = $this->crud->getData('u_full_name','s',array('user_id'=>$subject[$i]['updated_by']),'tbl1');
					$subject[$i]['created_by'] = $created_by['u_full_name'];
					$subject[$i]['updated_by'] = $updated_by['u_full_name'];
				}
			}
		}
		return $subject;
	}

	/**
	 * isSCheduleValidforFaculty function.
	 * 
	 * @access private
	 * @param int $faculty_id
	 * @param int $schedule_id
	 * @return boolean TRUE on success.
	 */
	public function isSCheduleValidforFaculty($faculty_id, $schedule_id, $schedule){
		$condition = array(
			'day'  		=> $schedule['day'],
			'time'		=> $schedule['time'],
			'is_active' => $schedule['is_active'],
			'batch_year_id'	   => $schedule['batch_year_id'],
			'faculty_assigned' => $faculty_id
		);
		$validate = $this->crud->getData('','s',$condition,'tbl10');
		if($validate['schedule_id']==$schedule_id){
			return TRUE;
		}else if(empty($validate)){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * deleteMultipleSchedule function.
	 * 
	 * @access public
	 * @param array $sched_id
	 * @return boolean TRUE on success.
	 */
	public function deleteMultipleSchedule($sched_id = array()){
       	$batch_year = $this->batch_year_model->getBatchCurrentYear();
       	if(!empty($sched_id)){
            for ($i=0; $i < count($sched_id); $i++) { 
                // get schedule by id
                $schedule = $this->room_model->getSchedules(array('`schedule`.`schedule_id`'=>$sched_id[$i]),'s');
                $condition= array(
                    'subject'       => $schedule['subject_id'],
                    'subject_code'  => $schedule['subject_code'],
                    'room'          => $schedule['room_id'],
                    'day'           => $schedule['day'],
                    'time'          => $schedule['time'],
                    'batch_year'    => $batch_year['batch_year_id']
                );
                $this->crud->deleteData($condition,'tbl9');
                $this->crud->deleteData(array('schedule_id'=>$schedule['schedule_id']),'tbl10');
                $this->user_model->recordLogs('Delete Schedule',$this->session->userdata('user_id'));
            }
            return TRUE;
        }
		return FALSE;
	}

	/**
	 * deactivateMultipleSchedule function.
	 * 
	 * @access public
	 * @param array $sched_id
	 * @return boolean TRUE on success.
	 */
	public function deactivateMultipleSchedule($sched_id = array()){
       	$batch_year = $this->batch_year_model->getBatchCurrentYear();
       	if(!empty($sched_id)){
            for ($i=0; $i < count($sched_id); $i++) { 
                // get schedule by id
                $schedule = $this->room_model->getSchedules(array('`schedule`.`schedule_id`'=>$sched_id[$i]),'s');
                $condition= array(
                    'subject'       => $schedule['subject_id'],
                    'subject_code'  => $schedule['subject_code'],
                    'room'          => $schedule['room_id'],
                    'day'           => $schedule['day'],
                    'time'          => $schedule['time'],
                    'batch_year'    => $batch_year['batch_year_id']
                );
                $this->crud->updateData(array('is_active'=>'false'),$condition,'tbl9');
                $this->crud->updateData(array('is_active'=>'false'),array('schedule_id'=>$schedule['schedule_id']),'tbl10');
                $this->user_model->recordLogs($this->session->userdata('u_full_name').' Deactivate Schedule',$this->session->userdata('user_id'));
            }
            return TRUE;
        }
		return FALSE;
	}

	/**
	 * activateMultipleSchedule function.
	 * 
	 * @access public
	 * @param array $sched_id
	 * @return boolean TRUE on success.
	 */
	public function activateMultipleSchedule($sched_id = array()){
       	$batch_year = $this->batch_year_model->getBatchCurrentYear();
       	if(!empty($sched_id)){
            for ($i=0; $i < count($sched_id); $i++) { 
                // get schedule by id
                $schedule = $this->room_model->getSchedules(array('`schedule`.`schedule_id`'=>$sched_id[$i]),'s');
                $condition= array(
                    'subject'       => $schedule['subject_id'],
                    'subject_code'  => $schedule['subject_code'],
                    'room'          => $schedule['room_id'],
                    'day'           => $schedule['day'],
                    'time'          => $schedule['time'],
                    'batch_year'    => $batch_year['batch_year_id']
                );
                $con = array(
                	'room_id'		=> $schedule['room_id'],
					'day'			=> $schedule['day'],
					'time'			=> $schedule['time'],
					'is_active'		=> 'true',
					'batch_year_id' => $batch_year['batch_year_id']
                );
                // validate if schedule (room, day, time) is already existing
                if($this->student_model->isScheduleValid($con)===TRUE){
                	$this->crud->updateData(array('is_active'=>'true'),$condition,'tbl9');
                	$this->crud->updateData(array('is_active'=>'true'),array('schedule_id'=>$schedule['schedule_id']),'tbl10');
                }
                $this->user_model->recordLogs($this->session->userdata('u_full_name').' Activate Schedule',$this->session->userdata('user_id'));
            }
            return TRUE;
        }
		return FALSE;
	}

}