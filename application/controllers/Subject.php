<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Subject extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('subject_model');
        $this->load->model('user_model');
        $this->load->model('room_model');
        $this->load->model('batch_year_model');
        $this->load->model('admin_model');
        $this->load->model('student_model');
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
     * subjects function.
     * 
     * @access public
     * @return render subjects table
     */
    public function subjects(){
        $this->crud->credibilityAuth(array('Administrator'));
        $data['subheader'] = array('title'=>'Subejcts','icon'=>'icon-list-1');
        // Necessary page data
        $data['subject'] = $this->subject_model->getSubjects('a','');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-subject',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/edit-subject-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * subject_create function.
     * 
     * @access public
     * @return render subjects registration form
     */
    public function subject_create(){
        $this->crud->credibilityAuth(array('Administrator'));
        $data['subheader'] = array('title'=>'New Subjects','icon'=>'icon-list-1');
        // Necessary page data
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/subject-registration');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * subject_assigning function.
     * 
     * @access public
     * @return render subject assigning
     */
    public function subject_assigning(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        $data['subheader'] = array('title'=>'Assign Subject','icon'=>'icon-bill');
        // Necessary page data
        // Current Batch Year
        $data['batch_year'] = $this->batch_year_model->getBatchCurrentYear();
        // Schedules for current batch year
        $condition = array('`schedule`.`batch_year_id`'=>$data['batch_year']['batch_year_id'],'`schedule`.`is_active`'=>'true');
        $data['schedules'] = $this->room_model->getSchedules($condition,'a');
        // Options for "Subject" dropdown field
        $data['subjects'] = $this->subject_model->getSubjects('a',array('status'=>'1'));
        // Option for "Room" dropdown field
        $data['rooms'] = $this->room_model->getRooms('a',array('status'=>'1'));
        // list of Faculty
        $data['faculty'] = $this->user_model->getUsers('a',array('designation'=>'Faculty'));
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-subject-assigning');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-assign-subject',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/assign-faculty-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/delete-schedule');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * subject_save_registration function.
     * 
     * @access public
     * @return process save subjects registration request.
     */
    public function subject_save_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = array('subject_title' => $this->input->post('subject_title'));
        $new_ = $this->crud->insertBatchvalidateAndRemoveDuplicateData($data,'','subject_title','','tbl7');
        $insert = $this->crud->setDataBatch($new_,array('created_by'=>$this->session->userdata('user_id')),'tbl7');
        if($insert){
            $this->user_model->recordLogs('Create new subject(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'New subject(s) has been created!.');
            redirect('subject_create');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
            redirect('subject_create');
        }
    }

    /**
     * subject_activate_deactivate function.
     * 
     * @access public
     * @return process subject activation or deactivation request
     */
    public function subject_activate_deactivate(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate subjects
            $data = array('subject_id'=>$this->input->post('subject_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('user_id')),'subject_id','tbl7');
            $this->user_model->recordLogs('Deactivate subjects',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Subject(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Activate subjects
            $data = array('subject_id'=>$this->input->post('subject_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('user_id')),'subject_id','tbl7');
            $this->user_model->recordLogs('Activate subjects',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Subject(s) has been activated');
        }
        redirect('subjects');
    }

    /**
     * get_subject function.
     * 
     * @access public
     * @return process get subject request by id
     */
    public function get_subject($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->subject_model->getSubjects('s',array('subject_id'=>$id));
        echo json_encode($data);
    }

    /**
     * subject_update function.
     * 
     * @access public
     * @return process subject update request
     */
    public function subject_update(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'Subject has been updated!';
        $subject = trim($this->input->post('subject_title'));
        $sub_id  = $this->input->post('subject_id');
        if(!empty($subject)){
            if(empty($this->crud->getData('','s',array('subject_title'=>$subject,'subject_id !='=>$sub_id),'tbl7'))){
                $data = array('subject_title'=>$subject,'updated_by'=>$this->session->userdata('user_id'));
                $cond = array('subject_id'=>$sub_id);
                $this->crud->updateData($data,$cond,'tbl7');
                $this->user_model->recordLogs('Update subject title',$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-danger';
                $msg   = 'Subject has not been updated due to invalid subject title.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Subject has not been updated due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * get_subject_schedule function.
     * 
     * @access public
     * @return get subject schedule request by id
     */
    public function get_subject_schedule($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->room_model->getScheduleById($id);
        $data['sched'] = $this->student_model->transformScheduleRange($data['time']);
        echo json_encode($data);
    }

    /**
     * subject_update_schedule function.
     * 
     * @access public
     * @return update schedule faculty
     */
    public function subject_update_schedule(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'Schedule has been updated!';
        $faculty = $this->input->post('faculty_assigned');
        $sched_id= $this->input->post('schedule_id');
        $schedule = array('day'=>$this->input->post('day'),'time'=>$this->input->post('time'),'is_active'=>'true');
        if(!empty($faculty)){
            // validate faculty schedule
            // $schedule = $this->crud->getData('schedule_id,day,time','s',array('schedule_id'=>$sched_id),'tbl10');
            $valid = $this->subject_model->isSCheduleValidforFaculty($faculty,$sched_id,$schedule);
            if($valid===TRUE){
                $this->crud->updateData(array('faculty_assigned'=>$faculty),array('schedule_id'=>$sched_id),'tbl10');
                $this->user_model->recordLogs('Update schedule faculty assigned',$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-warning';
                $msg   = 'Action cant be completed due to conflict of faculty schedule.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Schedule Faculty assigned has not been updated! due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * subject_update_schedule_and_faculty function.
     * commit 10/11/2018
     * 
     * @access public
     * @return update schedule and faculty
     */
    public function subject_update_schedule_and_faculty(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert    = 'alert alert-success';
        $msg      = 'Schedule has been updated!';

        // current batch year
        $batch_year= $this->batch_year_model->getBatchCurrentYear();
        $faculty  = $this->input->post('faculty_assigned');
        $sched_id = $this->input->post('schedule_id');

        // request/updated schedule based on user input
        $schedule = array(
            'subject_id'    => $this->input->post('subject_id'),
            'subject_code'  => trim($this->input->post('subject_code')),
            'room_id'       => $this->input->post('room_id'),
            'day'           => $this->input->post('day'),
            'time'          => $this->input->post('time'),
            'is_active'     => 'true',
            'batch_year_id' => $batch_year['batch_year_id']
        );

        // subjects
        $subjects = array(
            'subject'       => $schedule['subject_id'],
            'subject_code'  => $schedule['subject_code'],
            'time'          => $schedule['time'],
            'room'          => $schedule['room_id'],
            'day'           => $schedule['day'],
            'batch_year'    => $schedule['batch_year_id']
        );
        // condition for room schedule validation
        $condition = array(
            'schedule_id !='=> $sched_id,
            'room_id'       => $schedule['room_id'],
            'day'           => $schedule['day'],
            'time'          => $schedule['time'],
            'is_active'     => $schedule['is_active'],
            'batch_year_id' => $schedule['batch_year_id']
        );

        $current_schedule   = $this->crud->getData('','s',array('schedule_id'=>$sched_id),'tbl10');
        $cond = array('subject_code'=>$current_schedule['subject_code'],'batch_year'=>$current_schedule['batch_year_id'],'is_active'=>'true');
        $students  = $this->crud->getData('tbl_id,student_id','a',$cond,'tbl9');

        if(!empty($schedule['subject_id']) && !empty($schedule['subject_code']) && !empty($schedule['room_id'])){
            if(!empty($faculty)){
                // validate faculty schedule
                $validate_faculty_sched = $this->subject_model->isSCheduleValidforFaculty($faculty,$sched_id,$schedule);
                // validate room schedule
                $validate_room_sched    = $this->student_model->isScheduleValid($condition);
                // validate enlisted students subject code
                $validate_student_sub   = $this->student_model->validateStudentsSubjectOnScheduleUpdate($students,$subjects);
                // validate enlisted students schedule
                $validate_student_sched = $this->student_model->validateStudentsScheduleOnScheduleUpdate($students,$subjects);

                if($validate_faculty_sched===TRUE && $validate_room_sched===TRUE && $validate_student_sub===TRUE && $validate_student_sched===TRUE){
                    // update schedule with faculty assigned
                    $schedule['faculty_assigned'] = $faculty;
                    $this->crud->updateData($schedule,array('schedule_id'=>$sched_id),'tbl10');
                    // condition for updating enlisted students on subject schedule
                    $condition_sched = array(
                        'subject'       => $current_schedule['subject_id'],
                        'subject_code'  => $current_schedule['subject_code'],
                        'room'          => $current_schedule['room_id'],
                        'day'           => $current_schedule['day'],
                        'time'          => $current_schedule['time'],
                        'batch_year'    => $current_schedule['batch_year_id']
                    );
                    // update student subject schedule
                    $this->crud->updateData($subjects,$condition_sched,'tbl9');
                    $this->user_model->recordLogs('Update Schedule Assigned Faculty and Student Subject Schedule',$this->session->userdata('user_id'));
                }else if($validate_faculty_sched===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on faculty schedule';
                    ($validate_student_sub===FALSE)?$msg.=', enlisted students subjects':'';
                    ($validate_room_sched===FALSE)?$msg.=', room schedule':'';
                    ($validate_student_sched===FALSE)?$msg.=', and enlisted students schedule':'';
                }else if($validate_room_sched===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on room schedule';
                    ($validate_student_sub===FALSE)?$msg.=', enlisted students subjects':'';
                    ($validate_faculty_sched===FALSE)?$msg.=', faculty schedule':'';
                    ($validate_student_sched===FALSE)?$msg.=', and enlisted students schedule':'';
                }else if($validate_student_sub===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on enlisted students subjects';
                    ($validate_room_sched===FALSE)?$msg.=', room schedule':'';
                    ($validate_faculty_sched===FALSE)?$msg.=', faculty schedule':'';
                    ($validate_student_sched===FALSE)?$msg.=', and enlisted students schedule':'';
                }else if($validate_student_sched===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on enlisted students schedule';
                    ($validate_room_sched===FALSE)?$msg.=', room schedule':'';
                    ($validate_faculty_sched===FALSE)?$msg.=', faculty schedule':'';
                    ($validate_student_sub===FALSE)?$msg.=', and enlisted students subjects':'';
                }else{
                    $alert = 'alert alert-danger';
                    $msg   = 'Server Error occured.';
                }
            }else{
                // validate room schedule
                $validate_room_sched    = $this->student_model->isScheduleValid($condition);
                // validate enlisted students subject code
                $validate_student_sub   = $this->student_model->validateStudentsSubjectOnScheduleUpdate($students,$subjects);
                // validate enlisted students schedule
                $validate_student_sched = $this->student_model->validateStudentsScheduleOnScheduleUpdate($students,$subjects);

                if($validate_room_sched===TRUE && $validate_student_sub===TRUE && $validate_student_sched===TRUE){
                    // update schedule
                    $this->crud->updateData($schedule,array('schedule_id'=>$sched_id),'tbl10');
                    // condition for updating student subject schedule
                    $condition_sched = array(
                        'subject'       => $current_schedule['subject_id'],
                        'subject_code'  => $current_schedule['subject_code'],
                        'room'          => $current_schedule['room_id'],
                        'day'           => $current_schedule['day'],
                        'time'          => $current_schedule['time'],
                        'batch_year'    => $current_schedule['batch_year_id']
                    );
                    // update student subject schedule
                    $this->crud->updateData($subjects,$condition_sched,'tbl9');
                    $this->user_model->recordLogs('Update Schedule Assigned Faculty and Student Subject Schedule',$this->session->userdata('user_id'));
                }else if($validate_room_sched===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on room schedule';
                    ($validate_student_sub===FALSE)?$msg.=', enlisted students subjects':'';
                    ($validate_student_sched===FALSE)?$msg.=', and enlisted students schedule':'';
                }else if($validate_student_sub===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on enlisted students subjects.';
                    ($validate_room_sched===FALSE)?$msg.=', room schedule':'';
                    ($validate_student_sched===FALSE)?$msg.=', and enlisted students schedule':'';
                }else if($validate_student_sched===FALSE){
                    $alert = 'alert alert-warning';
                    $msg   = 'Error occured due to conflict found on enlisted students schedule.';
                    ($validate_room_sched===FALSE)?$msg.=', room schedule':'';
                    ($validate_student_sub===FALSE)?$msg.=', and enlisted students subjects':'';
                }else{
                    $alert = 'alert alert-danger';
                    $msg   = 'Server Error occured.';
                }
            }
        }else{
            $alert = 'alert alert-danger';
            $msg   = 'Error occured due to empty required fields!.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /** created 9/22/2018
     * subject_update_assign_faculty function.
     * 
     * @access public
     * @return update schedule faculty
     */
    public function subject_update_assign_faculty(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $faculty = $this->input->post('faculty_assigned');
        $sched_id= $this->input->post('schedule_id');
        $day  = $this->input->post('day');
        $time = $this->input->post('time');
        if(!empty($faculty)){
            $ctr = 0;
            for ($i=0; $i < count($sched_id); $i++) { 
                // create schedule condition
                $schedule = array('day'=>$day[$i],'time'=>$time[$i],'is_active'=>'true');
                // validate faculty schedule
                $valid = $this->subject_model->isSCheduleValidforFaculty($faculty,$sched_id[$i],$schedule);
                if($valid===TRUE){
                    $this->crud->updateData(array('faculty_assigned'=>$faculty),array('schedule_id'=>$sched_id[$i]),'tbl10');
                    $ctr++;
                }else{
                    $this->user_model->recordLogs('Schedule with schedule id '.$sched_id[$i].' have conflict with faculty current class schedule',$this->session->userdata('user_id'));
                }
            }
            if($ctr==count($sched_id)){
                $this->user_model->recordLogs('Update schedule faculty assigned completed!',$this->session->userdata('user_id'));
                $this->session->set_flashdata('success','Update schedule faculty assigned completed!.');
            }else{
                $this->user_model->recordLogs('Some request schedule have conflict with faculty class schedule.',$this->session->userdata('user_id'));
                $this->session->set_flashdata('warning','Some request schedule did not completely assigned faculty due to conflict of faculty class schedule.');
            }
            redirect('subject_assigning');
        }
        $this->session->set_flashdata('danger','Error Occured');
        redirect('subject_assigning');
    }

    /**
     * get_subject_schedule function.
     * 
     * @access public
     * @param int $batch_year_id
     * @return associative array on success
     */
    public function get_batch_year_subject_code($batch_year_id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->admin_model->getSubjectCodeOpenedForSpecificBatchYear($batch_year_id);
        echo json_encode($data);
    }

    /**
     * remove_schedule function.
     * 
     * @access public
     * @return process deletion of schedule request
     */
    public function remove_schedule(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'Schedule has been deleted!';
        // current batch year
        $batch_year = $this->batch_year_model->getBatchCurrentYear();
        // schedule id
        $sched_id = $this->input->post('schedule_id');
        // get schedule by id
        $schedule = $this->room_model->getSchedules(array('`schedule`.`schedule_id`'=>$sched_id),'s');
        $condition= array(
            'subject'       => $schedule['subject_id'],
            'subject_code'  => $schedule['subject_code'],
            'room'          => $schedule['room_id'],
            'day'           => $schedule['day'],
            'time'          => $schedule['time'],
            'batch_year'    => $batch_year['batch_year_id']
        );
        $this->crud->deleteData($condition,'tbl9');
        $this->crud->deleteData(array('schedule_id'=>$sched_id),'tbl10');
        $this->user_model->recordLogs('Delete Schedule',$this->session->userdata('user_id'));
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * remove_multiple_schedule function.
     * 
     * @access public
     * @return process deletion of multiple schedule request
     */
    public function update_multiple_schedule(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('assign')){
            $data['subheader'] = array('title'=>'Assign Multiple Subject','icon'=>'icon-bill');
            // Necessary page data
            // $data['schedules']  = $this->room_model->getSchedules(array('`schedule`.`batch_year_id`'=>$data['batch_year']['batch_year_id']),'a');
            $data['schedules'] = $this->room_model->getMultipleSchedules($this->input->post('schedule_id'));
            $data['faculty']   = $this->user_model->getUsers('a',array('designation'=>'Faculty'));
            // Page headers
            $this->load->view('templates/header');
            $this->load->view('templates/header-bar');
            $this->load->view('oam-users/oam-admin/admin-menu/menu-subject-assigning');
            $this->load->view('templates/content-inner');
            $this->load->view('templates/subheader-bar',$data);
            // Flash data messages
            // Page contents
            $this->load->view('oam-users/oam-admin/admin-assign-multiple-subject',$data);
            // Page modals
            // Page footer
            $this->load->view('templates/footer');
        }else if($this->input->post('delete')){
            // permanently delete schedules
            $delete_sched = $this->subject_model->deleteMultipleSchedule($this->input->post('schedule_id'));
            if($delete_sched==TRUE){
                $this->session->set_flashdata('success','Schedules has been permanently deleted!');
            }else{
                $this->session->set_flashdata('danger','Error Occured!');
            }
            redirect('subject_assigning');
        }else if($this->input->post('deactivate')){
            // deactivate schedules
            $delete_sched = $this->subject_model->deactivateMultipleSchedule($this->input->post('schedule_id'));
            if($delete_sched==TRUE){
                $this->session->set_flashdata('success','Schedules has been deactivated!');
            }else{
                $this->session->set_flashdata('danger','Error Occured!');
            }
            redirect('subject_assigning');
        }else if($this->input->post('activate')){
            // activate schedules
            $delete_sched = $this->subject_model->activateMultipleSchedule($this->input->post('schedule_id'));
            if($delete_sched==TRUE){
                $this->session->set_flashdata('success','Schedules has been activated!');
            }else{
                $this->session->set_flashdata('danger','Error Occured!');
            }
            redirect('subject_assigning');
        }else{
            redirect('subject_assigning');
        }
    }

}