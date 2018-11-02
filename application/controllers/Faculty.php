<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Faculty extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('admin_model');
        $this->load->model('room_model');
        $this->load->model('user_model');
        $this->load->model('batch_year_model');
        $this->load->model('student_model');
        $this->load->model('faculty_model');
    }

    // View templating references
    public function template_reference(){
        $data['subheader'] = array('title'=>'Security Configuration','icon'=>'fa fa-cogs');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('templates/menu-bar');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/home-page');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * template_reference function.
     * 
     * @access public
     * @return render faculty dashboard
     */
    public function faculty_dashboard(){
        $this->crud->credibilityAuth(array('Faculty'));
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('templates/content-inner');
        // Page contents
        $this->load->view('oam-users/oam-faculty/faculty-home');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * faculty_assigned_subjects function.
     * 
     * @access public
     * @return render faculty assigned subjects table
     */
    public function faculty_assigned_subjects($faculty_id = NULL){
    	$this->crud->credibilityAuth(array('Faculty','Administrator'));
        $data['subheader'] = array('title'=>'Assigned Subjects','icon'=>'icon-bill');
        // Necessary page data
        // Current Batch Year
        $data['batch_year'] = $this->batch_year_model->getBatchCurrentYear();
        $condition = array(
            '`schedule`.`batch_year_id`' => $data['batch_year']['batch_year_id'],
            '`schedule`.`is_active`'     => 'true'
        );
        if(!empty($faculty_id)){
            $condition['`faculty_assigned`'] = $faculty_id;
        }else{
            $condition['`faculty_assigned`'] = $this->session->userdata('user_id');
        }
        $data['schedules']  = $this->room_model->getSchedules($condition,'a');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-faculty/faculty-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-faculty/faculty-assigned-subjects',$data);
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * faculty_schedule_outline function.
     * 
     * @access public
     * @param int $faculty_id
     * @return render faculty schedule outline
     */
    public function faculty_schedule_outline($faculty_id = NULL)
    {
        $this->crud->credibilityAuth(array('Faculty','Administrator'));
        $data['batch_year'] = $this->batch_year_model->getBatchCurrentYear();
        $condition = array('`schedule`.`batch_year_id`'=>$data['batch_year']['batch_year_id'],'`schedule`.`is_active`'=>'true');

        if(!empty($faculty_id)){
            $condition['`faculty_assigned`'] = $faculty_id;
        }else{
            $condition['`faculty_assigned`'] = $this->session->userdata('user_id');
        }
        $data['schedules'] = $this->room_model->getSchedules($condition,'a');

        if(!empty($faculty_id)){
            $con_user['user_id'] = $faculty_id;
        }else{
            $con_user = array('user_id'=>$this->session->userdata('user_id'));
        }
        $data['user_info'] = $this->crud->getData('','s',$con_user,'tbl1');
        // Page headers
        $this->load->view('templates/header-scheduling');
        // Flash data messages
        // Page contents
        $this->load->view('oam-users/oam-faculty/faculty-schedule-outline',$data);
        // Page modals
        // Page footer
    }

    /**
     * faculty_attendance function.
     * 
     * @access public
     * @return render faculty attendance table
     */
    public function faculty_attendance($schedule_id = NULL){
        $this->crud->credibilityAuth(array('Faculty','Administrator'));
        // check if schedule id is not empty
        empty($schedule_id)?redirect('faculty_assigned_subjects'):TRUE;
        $data['subheader'] = array('title'=>'Attendance','icon'=>'fa fa-table');
        // Necessary page data
        // Current Batch Year
        $data['schedule_id']= $schedule_id;
        $data['batch_year'] = $this->batch_year_model->getBatchCurrentYear();
        $data['schedules']  = $this->room_model->getSchedules(array('`schedule_id`'=>$schedule_id),'s');
        $data['attend_date']= $this->faculty_model->getScheduledDate($data['schedules']['day']);
        $data['students']   = $this->faculty_model->getStudentsEnrolledWithAttendance($data['schedules'],$data['attend_date']);
        // authenticate access
        $this->faculty_model->authenticateFacultyAssigned($schedule_id,$data['schedules']['day']);
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-faculty/faculty-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-faculty/faculty-attendance',$data);
        // Page modals
        $this->load->view('oam-users/oam-faculty/faculty-modal/edit-student-attendance-modal');
        $this->load->view('oam-users/oam-faculty/faculty-modal/update-old-student-attendance-modal');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * unauthorized_access function.
     * 
     * @access public
     * @return render unauthorized page for faculty
     */
    public function unauthorized_access(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        $this->user_model->recordLogs('Maliciously accessed unauthorized attendance',$this->session->userdata('user_id'));
        show_error('Unauthorized Access!', 401);
    }

    /**
     * faculty_attendance_records function.
     * 
     * @access public
     * @return get student attendance records
     */
    public function faculty_attendance_records(){
        $this->crud->credibilityAuth(array('Faculty'));
        $data['subheader'] = array('title'=>'Assigned Subjects','icon'=>'icon-bill');
        // Necessary page data
        // Current Batch Year
        $data['batch_year'] = $this->batch_year_model->getBatchCurrentYear();
        $condition = array(
            '`schedule`.`batch_year_id`' => $data['batch_year']['batch_year_id'],
            '`schedule`.`is_active`'     => 'true',
            '`faculty_assigned`'         => $this->session->userdata('user_id')
        );
        $data['schedules']  = $this->room_model->getSchedules($condition,'a');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-faculty/faculty-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-faculty/faculty-attendance-reports',$data);
        $this->load->view('oam-users/oam-faculty/faculty-modal/generate-subject-code-report-modal');
        $this->load->view('oam-users/oam-faculty/faculty-modal/generate-remarks-report-modal');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * get_student_attendance function.
     * 
     * @access public
     * @return get student attendance record for the current date
     */
    public function get_student_attendance($student_id, $subject_id, $subject_code, $batch_year_id){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        $condition = array(
            'student_id'      => $student_id,
            'subject_id'      => $subject_id,
            'subject_code'    => urldecode($subject_code),
            'attendance_date' => date('Y-m-d'),
            'batch_year_id'   => $batch_year_id
        );
        $data = $this->crud->getData('attendance,remarks','s',$condition,'tbl11');
        echo json_encode($data);
    }

    /**
     * faculty_update_student_attendance function.
     * 
     * @access public
     * @return update student attendance record for the current date
     */
    public function faculty_update_student_attendance(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        $alert = 'alert alert-success';
        $msg   = 'Student attendance has been updated!';
        $attendance = array(
            'attendance' => $this->input->post('status'),
            'remarks'    => trim($this->input->post('remarks')),
            'updated_by' => $this->session->userdata('user_id')
        );
        $condition = array(
            'student_id'    => $this->input->post('student_id'),
            'subject_id'    => $this->input->post('subject_id'),
            'subject_code'  => $this->input->post('subject_code'),
            'batch_year_id' => $this->input->post('batch_year_id'),
            'attendance_date' => date('Y-m-d')
        );
        if(!empty($attendance['attendance'])){
            $data = $this->crud->getData('','c',$condition,'tbl11');
            if($data > 0){
                $this->crud->updateData($attendance,$condition,'tbl11');
                $this->faculty_model->updateDailyAttendanceRecord($condition,$attendance);
                $this->user_model->recordLogs('Update Student Attendance Record',$this->session->userdata('user_id'));
            }else{
                $attendance_data = array(
                    'student_id'      => $condition['student_id'],
                    'subject_id'      => $condition['subject_id'],
                    'subject_code'    => $condition['subject_code'],
                    'attendance'      => $attendance['attendance'],
                    'remarks'         => $attendance['remarks'],
                    'attendance_date' => $condition['attendance_date'],
                    'batch_year_id'   => $condition['batch_year_id'],
                    'created_by'      => $this->session->userdata('user_id')
                );
                $this->crud->setData($attendance_data,'','tbl11');
                $this->faculty_model->updateDailyAttendanceRecord($condition,$attendance);
                $this->user_model->recordLogs('Add new Student Attendance Record',$this->session->userdata('user_id'));
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Student attendance has not been updated due to empty required fields!';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * faculty_update_old_student_attendance function.
     * 
     * @access public
     * @return update student attendance record for the current date
     */
    public function faculty_update_old_student_attendance(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert = 'alert alert-success';
        $msg   = 'Student attendance has been updated!';
        $sched_day    = $this->input->post('schedule_day');
        $schedule_day = date('w',strtotime($sched_day));
        $attend_date  = date('w',strtotime($this->input->post('attendance_date')));
        $attendance = array(
            'attendance' => $this->input->post('status'),
            'remarks'    => trim($this->input->post('remarks')),
            'updated_by' => $this->session->userdata('user_id')
        );
        $condition = array(
            'student_id'    => $this->input->post('student_id'),
            'subject_id'    => $this->input->post('subject_id'),
            'subject_code'  => $this->input->post('subject_code'),
            'batch_year_id' => $this->input->post('batch_year_id'),
            'attendance_date' => $this->input->post('attendance_date')
        );
        if($schedule_day==$attend_date && $condition['attendance_date'] <= date('Y-m-d')){
            if(!empty($attendance['attendance']) && !empty($condition['attendance_date'])){
                $data = $this->crud->getData('','c',$condition,'tbl11');
                if($data > 0){
                    $this->crud->updateData($attendance,$condition,'tbl11');
                    $this->faculty_model->updateDailyAttendanceRecord($condition,$attendance);
                    $this->user_model->recordLogs('Update Student Attendance Record',$this->session->userdata('user_id'));
                }else{
                    $attendance_data = array(
                        'student_id'      => $condition['student_id'],
                        'subject_id'      => $condition['subject_id'],
                        'subject_code'    => $condition['subject_code'],
                        'attendance'      => $attendance['attendance'],
                        'remarks'         => $attendance['remarks'],
                        'attendance_date' => $condition['attendance_date'],
                        'batch_year_id'   => $condition['batch_year_id'],
                        'created_by'      => $this->session->userdata('user_id')
                    );
                    $this->crud->setData($attendance_data,'','tbl11');
                    $this->faculty_model->updateDailyAttendanceRecord($condition,$attendance);
                    $this->user_model->recordLogs('Add new Student Attendance Record',$this->session->userdata('user_id'));
                }
                $this->user_model->recordLogs($this->session->userdata('u_full_name').' Override Student Attendance Records for the date: '.$condition['attendance_date'],$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-warning';
                $msg   = 'Student attendance has not been updated due to empty required fields!';
            }
        }else if($schedule_day==$attend_date && $condition['attendance_date'] > date('Y-m-d')){
            $alert = 'alert alert-warning';
            $msg   = 'Error occured! Updating of this "Attendance" is only allowed on or after '.date('F d, Y - l',strtotime($this->faculty_model->getScheduledDate($sched_day))).', and on the succeeding days of "this Week".';
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Error occured! due to invalid "Attendance Date".';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * faculty_change_student_attendance_status function.
     * 
     * @access public
     * @return update student attendance record for the current date
     */
    public function faculty_change_student_attendance_status(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        $student_id   = $this->input->post('student_ids');
        $schedule_id  = $this->input->post('schedule_id');
        $sched_day    = $this->input->post('schedule_day');
        $schedule_day = date('w',strtotime($sched_day));
        $attend_date  = date('w',strtotime($this->input->post('attendance_date')));
        $attendance = array(
            'updated_by' => $this->session->userdata('user_id')
        );
        $condition = array(
            'subject_id'    => $this->input->post('subject'),
            'subject_code'  => $this->input->post('subject_c'),
            'batch_year_id' => $this->input->post('batch_year'),
            'attendance_date' => $this->input->post('attendance_date')
        );
        
        if($schedule_day==$attend_date && $condition['attendance_date'] <= date('Y-m-d')){
            if(!empty($student_id)){
                if($this->input->post('present')){
                    $attendance['attendance']= 'P';
                    $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
                }else if($this->input->post('absent')){
                    $attendance['attendance']= 'A';
                    $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
                }else if($this->input->post('late')){
                    $attendance['attendance']= 'L';
                    $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
                }else if($this->input->post('excuse')){
                    $attendance['attendance']= 'E';
                    $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
                }else if($this->input->post('vacation')){
                    $attendance['attendance']= 'V';
                    $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
                }else if($this->input->post('remove')){
                    $this->faculty_model->remove_students_from_enlistment($student_id,$condition);
                    $this->session->set_flashdata('success','Students has been successfully removed from enlistment!.');
                    redirect('faculty/faculty_attendance/'.$schedule_id);
                }
                $this->session->set_flashdata('success','Students Attendance Status has been updated!.');
            }else{
                $this->session->set_flashdata('warning','No Students selected!.');
            }
        }else if($schedule_day==$attend_date && $condition['attendance_date'] > date('Y-m-d')){
            $this->session->set_flashdata('warning','Error occured! Updating of this "Attendance" is only allowed on or after '.date('F d, Y - l',strtotime($this->faculty_model->getScheduledDate($sched_day))).', and on the succeeding days of "this Week".');
        }else{
            $this->session->set_flashdata('warning','Error occured! due to invalid "Attendance Date".');
        }
        redirect('faculty/faculty_attendance/'.$schedule_id);
    }

    // /**
    //  * faculty_override_student_attendance_status function.
    //  * 
    //  * @access public
    //  * @return update student attendance record for the current date
    //  */
    // public function faculty_override_student_attendance_status(){
    //     $this->crud->credibilityAuth(array('Administrator','Registrar'));
    //     $alert = 'alert alert-success';
    //     $msg   = 'Student attendance has been updated!';
    //     $student_id = $this->input->post('student_ids');
    //     $schedule_id= $this->input->post('schedule_id');
    //     $attendance = array(
    //         'updated_by' => $this->session->userdata('user_id')
    //     );
    //     $condition = array(
    //         'subject_id'    => $this->input->post('subject'),
    //         'subject_code'  => $this->input->post('subject_c'),
    //         'batch_year_id' => $this->input->post('batch_year'),
    //         'attendance_date' => $this->input->post('attendance_date')
    //     );

    //     if(!empty($student_id) && !empty($condition['attendance_date']) && !empty($this->input->post('status'))){
    //         if($this->input->post('status')=='P'){
    //             $attendance['attendance']= 'P';
    //             $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
    //         }else if($this->input->post('status')=='A'){
    //             $attendance['attendance']= 'A';
    //             $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
    //         }else if($this->input->post('status')=='L'){
    //             $attendance['attendance']= 'L';
    //             $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
    //         }else if($this->input->post('status')=='E'){
    //             $attendance['attendance']= 'E';
    //             $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
    //         }else if($this->input->post('status')=='V'){
    //             $attendance['attendance']= 'V';
    //             $this->faculty_model->processMassAttendanceAction($student_id,$attendance,$condition);
    //         }
    //         $this->user_model->recordLogs($this->session->userdata('u_full_name').' Override Student Attendance Records for the date: '.$condition['attendance_date'],$this->session->userdata('user_id'));
    //         $this->session->set_flashdata('success','Students Attendance Status has been updated!.');
    //     }else{
    //         $alert = 'alert alert-warning';
    //         $msg   = 'Error occured due empty required fields!';
    //     }
    //     echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    // }


}