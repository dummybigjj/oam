<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Student extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("pagination");
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->model('crud');
        $this->load->model('user_model');
        $this->load->model('student_model');
        $this->load->model('batch_year_model');
        $this->load->model('subject_model');
        $this->load->model('room_model');
        $this->load->model('vocational_program_model');
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
     * student_import_registration function.
     * 
     * @access public
     * @return render uploading of students data for mas registration
     */
    public function student_import_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Import Students','icon'=>'fa fa-user-o');
        // Necessary page data
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-student');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-import-student');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * students function.
     * 
     * @access public
     * @return render students table
     */
    public function students(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Students','icon'=>'fa fa-user-o');
        // Necessary page data
        $data['students']  = $this->student_model->getStudents('a','');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-student');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-student',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/view-student-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/edit-student-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/delete-student');
        $this->load->view('oam-users/oam-admin/admin-modals/import-students-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * student_registration function.
     * 
     * @access public
     * @return render students registration form
     */
    public function student_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data['subheader'] = array('title'=>'New Students','icon'=>'fa fa-user-o');
        // Necessary page data
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-student');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/student-registration-table');
        // $this->load->view('oam-users/oam-admin/student-registration');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * student_enrollment_registration function.
     * 
     * @access public
     * @return render enrollment registration table
     */
    public function student_enrollment_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Register Student','icon'=>'fa fa-user-o');
        // Active student subject table count
        $data['count']  = $this->crud->count_table_rows(array('is_active'=>'true'),'tbl9');
        // Pagination config
        $config = $this->crud->pagination_config(500,$data['count'],'register_student',2);
        // initialize pagination
        $this->pagination->initialize($config);
        // set start query page
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        // Necessary page data
        $data['batch_year']= $this->batch_year_model->getBatchCurrentYear();
        // set condition to current batch year
        $cond = array('`student_subject`.`batch_year`'=>$data['batch_year']['batch_year_id'],'`student_subject`.`is_active`'=>'true');
        // enrolled students
        $data['enrolled'] = $this->student_model->getPaginationEnrolledStudents($config["per_page"],$page,$cond);
        // Options for "Subject" dropdown field
        $data['subjects'] = $this->subject_model->getSubjects('a',array('status'=>'1'));
        // Option for "Room" dropdown field
        $data['rooms'] = $this->room_model->getRooms('a',array('status'=>'1'));
        // Option for "Vocational Program" dropdown field
        $data['voc_program'] = $this->vocational_program_model->getVocationalPrograms('a',array('status'=>'1'));
        // paginiation links
        $data["links"] = $this->pagination->create_links();

        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-student');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-student-enrollment-registration',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/view-student-registration-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/edit-student-registration-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/remove-student-registration-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * register_students function.
     * 
     * @access public
     * @return render student registration of subjects and schedule
     */
    public function register_students($schedule_id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data['subheader'] = array('title'=>'Register Students','icon'=>'fa fa-user-o');
        // Necessary page data
        // Current Batch Year
        $data['batch_year']  = $this->batch_year_model->getBatchCurrentYear();
        // Get schedule
        $data['schedule']    = $this->room_model->getSchedules(array('schedule_id'=>$schedule_id,'`schedule`.`is_active`'=>'true'),'s');
        // Options for "Student" dropdown field
        $data['students']    = $this->student_model->getStudents('a',array('status'=>'1'));
        // Options for "Subject" dropdown field
        $data['subjects']    = $this->subject_model->getSubjects('a',array('status'=>'1'));
        // Option for "Room" dropdown field
        $data['rooms']       = $this->room_model->getRooms('a',array('status'=>'1'));
        // Option for "Vocational Program" dropdown field
        $data['voc_program'] = $this->vocational_program_model->getVocationalPrograms('a',array('status'=>'1'));
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu-student');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/students-registration');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * set_students function.
     * 
     * @access public
     * @return set new students
     */
    public function set_students(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = array(
            'student_no'    => $this->input->post('student_no'),
            'national_id'   => $this->input->post('national_id'),
            'email_address' => $this->input->post('email_address'),
            'mobile_no'     => $this->input->post('mobile_no'),
            'english_name'  => $this->input->post('english_name'),
            'arabic_name'   => $this->input->post('arabic_name'),
            'nationality'   => $this->input->post('nationality'),
            'sign_contract' => $this->input->post('sign_contract'),
            'remarks'       => $this->input->post('remarks')
        );
        $n_data = $this->crud->insertBatchvalidateAndRemoveDuplicateData($data,'','student_no','','tbl2');
        $insert = $this->crud->insertBatch($n_data,array('student_no'),array('created_by'=>$this->session->userdata('email')),'tbl2');
        if($insert){
            $this->user_model->recordLogs('Register students',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'Students has been registered!.');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
        }
        redirect('student_registration');
    }

    /**
     * student_activate_deactivate function.
     * 
     * @access public
     * @return process activation or deactivation request
     */
    public function student_activate_deactivate(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate student
            $data = array('student_id'=>$this->input->post('student_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('email')),'student_id','tbl2');
            $this->user_model->recordLogs('Deactivate student record',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Subject(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Activate student
            $data = array('student_id'=>$this->input->post('student_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('email')),'student_id','tbl2');
            $this->user_model->recordLogs('Activate student record',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Subject(s) has been activated');
        }
        redirect('students');
    }

    /**
     * get_student function.
     * 
     * @access public
     * @return process get student request by id
     */
    public function get_student($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->student_model->getStudents('s',array('student_id'=>$id));
        echo json_encode($data);
    }

    /**
     * student_update function.
     * 
     * @access public
     * @return process update student request
     */
    public function student_update(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'Student has been updated!';
        $stud_id = $this->input->post('student_id');
        $data    = array(
            'student_no'    => trim($this->input->post('student_no')),
            'national_id'   => trim($this->input->post('national_id')),
            'email_address' => trim($this->input->post('email_address')),
            'mobile_no'     => trim($this->input->post('mobile_no')),
            'english_name'  => trim($this->input->post('english_name')),
            'arabic_name'   => trim($this->input->post('arabic_name')),
            'nationality'   => trim($this->input->post('nationality')),
            'sign_contract' => trim($this->input->post('sign_contract')),
            'remarks'       => trim($this->input->post('remarks'))
        );
        $condition = array('student_id !=' => $stud_id);
        if(!empty($data['student_no']) && !empty($data['arabic_name'])){
            $std_no = $this->crud->isDataValid(array('student_no' => $data['student_no']),$condition,'tbl2');
            $email  = $this->crud->isDataValid(array('email_address' => $data['email_address']),$condition,'tbl2');
            $mobile = $this->crud->isDataValid(array('mobile_no' => $data['mobile_no']),$condition,'tbl2');
            if($std_no==TRUE){
                if((!empty($data['email_address']) && $email==FALSE) || (!empty($data['mobile_no']) && $mobile==FALSE)){
                    $alert = 'alert alert-danger';
                    $msg   = 'Student has not been updated due to invalid input.';
                }else{
                    $cond = array('student_id'=>$stud_id);
                    $this->crud->updateData($data,$cond,'tbl2');
                    $this->user_model->recordLogs('Update Student Information',$this->session->userdata('user_id'));
                }
            }else{
                $alert = 'alert alert-danger';
                $msg   = 'Student has not been updated due to invalid input.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Student has not been updated due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * set_students_subjects function.
     * 
     * @access public
     * @return set student subjects and schedules
     */
    public function set_students_subjects(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $student_subject = array(
            'student_id'    => trim($this->input->post('student_id')),
            'subject'       => trim($this->input->post('subject')),
            'subject_code'  => trim($this->input->post('subject_code')),
            'time'          => $this->input->post('time'),
            'room'          => trim($this->input->post('room')),
            'day'           => trim($this->input->post('day')),
            'vocational_program' => trim($this->input->post('vocational_program')),
            'batch_year'    => $this->input->post('batch_year'),
            'created_by'    => $this->session->userdata('user_id')
        );
        $schedule = array(
            'subject_id'    => $student_subject['subject'],
            'subject_code'  => $student_subject['subject_code'],
            'room_id'       => $student_subject['room'],
            'day'           => $student_subject['day'],
            'time'          => $student_subject['time'],
            'batch_year_id' => $student_subject['batch_year'],
        );
        $validate_subject = $this->student_model->isSubjectValid($student_subject);
        if($validate_subject==TRUE){
            $process_schedule = $this->student_model->processStundentSchedule($schedule);
            if($process_schedule==TRUE){
                $count = $this->crud->getData('','c',$schedule,'tbl9');
                if($count <= 25){
                    $this->crud->setData($student_subject,'','tbl9');
                    $this->user_model->recordLogs('Register New Student Subject and Schedule',$this->session->userdata('user_id'));
                    $this->session->set_flashdata('success','Student has been successfully registered!.');
                }else{
                    $this->session->set_flashdata('warning','Subject Code have reached its maximum enlistment capacity (25 Students). Student will not be registered!.');
                }
            }else{
                $this->session->set_flashdata('danger','Students has not been registered! due to conflict of room schedule.');
            }
        }else{
            $this->session->set_flashdata('danger','Student is not allowed to have Duplicate "Subject" and "Subject Code".');
        }
        redirect('register_students');
    }

    /**
     * set_students_subjects_mass_reg function.
     * 
     * @access public
     * @return set student subjects and schedules
     */
    public function set_students_subjects_mass_reg(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if(isset($_FILES["file"]["name"])){
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $student_number = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $students[] = trim($student_number);
                }
            }
        }
        $students = $this->student_model->getStudentId($students);
        $batch_year = $this->input->post('batch_year');
        // student subjects and schedule
        $subject_schedule = array(
            'subject'       => $this->input->post('subject'),
            'subject_code'  => $this->input->post('subject_code'),
            'time'          => $this->input->post('time'),
            'room'          => $this->input->post('room'),
            'day'           => $this->input->post('day'),
            'vocational_program' => $this->input->post('vocational_program')
        );

        if(!empty($students)){
            for ($i=0; $i < count($subject_schedule['subject']); $i++) { 
                $student_subject = array(
                    'subject'       => $subject_schedule['subject'][$i],
                    'subject_code'  => $subject_schedule['subject_code'][$i],
                    'time'          => $subject_schedule['time'][$i],
                    'room'          => $subject_schedule['room'][$i],
                    'day'           => $subject_schedule['day'][$i],
                    'batch_year'    => $batch_year,
                    'vocational_program' => $subject_schedule['vocational_program'][$i],
                    'created_by'    => $this->session->userdata('user_id')
                );
                $schedule = array(
                    'subject_id'    => $student_subject['subject'],
                    'subject_code'  => $student_subject['subject_code'],
                    'room_id'       => $student_subject['room'],
                    'day'           => $student_subject['day'],
                    'time'          => $student_subject['time'],
                    'is_active'     => 'true',
                    'batch_year_id' => $student_subject['batch_year'],
                );
                // validate students subject for current batch year
                $valid_students1 = $this->student_model->validateStudentsSubject($students,$student_subject);
                // validate students schedule for current batch year
                $valid_students  = $this->student_model->validateStudentsSchedule($valid_students1,$student_subject);
                if(count($valid_students) > 0){
                    // check if schedule is already existing, if not - create new schedule
                    $process_schedule = $this->student_model->processStundentSchedule($schedule);
                    if($process_schedule==TRUE){
                        $con = array(
                            'subject'       => $student_subject['subject'],
                            'subject_code'  => $student_subject['subject_code'],
                            'room'          => $student_subject['room'],
                            'day'           => $student_subject['day'],
                            'time'          => $student_subject['time'],
                            'is_active'     => 'true',
                            'batch_year'    => $student_subject['batch_year']
                        );
                        $count = $this->crud->getData('','c',$con,'tbl9') + count($valid_students);
                        if($count <= 40){
                            $this->crud->setDataBatch(array('student_id'=>$valid_students),$student_subject,'tbl9');
                            $this->user_model->recordLogs('Register New Student Subject and Schedule',$this->session->userdata('user_id'));
                            
                        }else{
                            $diff = $count - 40;
                            $this->user_model->recordLogs('Enrollment Registration stopped. Subject Code will/have reached its 40 enlistment capacity ('.$diff.' left). Students will not be registered!.',$this->session->userdata('user_id'));
                            $this->session->set_flashdata('warning','Enrollment Registration stopped. Subject Code have reached its 40 enlistment capacity ('.$diff.' left). Students will not be registered!.');

                        }
                    }else{
                        $this->session->set_flashdata('warning','Some students has not been registered due to conflict of room schedule!.');
                    }
                }else{
                    $this->session->set_flashdata('warning','Some students has not been registered due to conflict of student subjects and schedule!.');
                }
            }
            $this->session->set_flashdata('success','Students has been successfully registered!.');
        }else{
            $this->session->set_flashdata('warning','Error occured, no student records found on the requested file.');
        }
        redirect('register_students');
    }

    /**
     * student_update_student_registration_schedule function.
     * 
     * @access public
     * @return update student registration schedule and subject load
     */
    public function student_update_student_registration_schedule(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert  = 'alert alert-success';
        $msg    = 'Student Subject and Schedule has been updated!';
        $tbl_id = $this->input->post('tbl_id');
        $student_id = $this->input->post('student_id');
        $student_subject = array(
            'subject'       => $this->input->post('subject'),
            'subject_code'  => trim($this->input->post('subject_code')),
            'time'          => $this->input->post('time'),
            'room'          => $this->input->post('room'),
            'day'           => $this->input->post('day'),
            'vocational_program' => $this->input->post('vocational_program'),
            'batch_year'    => $this->input->post('batch_year'),
            'updated_by'    => $this->session->userdata('user_id')
        );
        $schedule = array(
            'subject_id'    => $student_subject['subject'],
            'subject_code'  => $student_subject['subject_code'],
            'room_id'       => $student_subject['room'],
            'day'           => $student_subject['day'],
            'time'          => $student_subject['time'],
            'batch_year_id' => $student_subject['batch_year'],
        );

        // validate if requested update of student subject is valid
        $valid_student_subject  = $this->student_model->isStudentSubjectValid($student_id,$student_subject,$tbl_id);
        // validate if requested update of student schedule is valid
        $valid_student_schedule = $this->student_model->isStudentScheduleValid($student_id,$schedule,$tbl_id);
        if($valid_student_subject==TRUE && $valid_student_schedule==TRUE){
            // check if schedule is already existing, if not - insert new schedule
            $check_schedule = $this->student_model->processStundentSchedule($schedule);
            if($check_schedule==TRUE){
                $con = array(
                    'subject'       => $student_subject['subject'],
                    'subject_code'  => $student_subject['subject_code'],
                    'room'          => $student_subject['room'],
                    'day'           => $student_subject['day'],
                    'time'          => $student_subject['time'],
                    'batch_year'    => $student_subject['batch_year'],
                );
                $count = $this->crud->getData('','c',$con,'tbl9') + 1;
                if($count <= 30){
                    $this->crud->updateData($student_subject,array('tbl_id'=>$tbl_id),'tbl9');
                    $this->user_model->recordLogs('Update Student Subject and Schedule',$this->session->userdata('user_id'));
                }else{
                    $alert = 'alert alert-warning';
                    $msg   = 'Student Subject and Schedule has not been updated due to Subject Code enlistment limit(30 Students) have already reached!.';
                }
            }else{
                $alert = 'alert alert-warning';
                $msg   = 'Student Subject and Schedule has not been updated due to conflict of room schedule!.';
            }
        }else if($valid_student_subject==FALSE){
            $alert = 'alert alert-warning';
            $msg   = 'Student Subject and Subject Code is not valid.';
        }else if($valid_student_schedule==FALSE){
            $alert = 'alert alert-warning';
            $msg   = 'Student Class Schedule is not valid. It will result to conflict of student class schedule.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * get_student_registration function.
     * 
     * @access public
     * @return get student registration information with schedule for the current batch year
     */
    public function get_student_registration($id = NULL,$batch_year){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $conn = array(
            '`student_subject`.`batch_year`'=>$batch_year,
            '`student_subject`.`student_id`'=>$id
        );
        $data = $this->student_model->getEnrolledStudent($conn,'s');
        echo json_encode($data);
    }

    /**
     * get_student_registration function.
     * 
     * @access public
     * @return get student registration information with schedule for the current batch year
     */
    public function get_student_enrollment_registration_details($tbl_id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $conn = array('`student_subject`.`tbl_id`'=>$tbl_id);
        $data = $this->student_model->getEnrolledStudent($conn,'s');
        echo json_encode($data);
    }

    /**
     * student_remove_registration function.
     * 
     * @access public
     * @return remove student registration
     */
    public function student_remove_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $this->crud->deleteData(array('tbl_id'=>$this->input->post('tbl_id')),'tbl9');
        $this->user_model->recordLogs('Remove Student Registration',$this->session->userdata('user_id'));
        echo json_encode(array("status"=>TRUE));
    }

    /**
     * student_delete_permanently function.
     * 
     * @access public
     * @return delete student permanently
     */
    public function student_delete_permanently(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // tables where student record should be deleted
        // attendance_daily_record, attendance_record, student, student_subject
        // delete student in attendance_daily_record table
        $this->crud->deleteData(array('student_id'=>$this->input->post('student_id')),'tbl12');
        // delete student in attendance_record table
        $this->crud->deleteData(array('student_id'=>$this->input->post('student_id')),'tbl11');
        // delete student in student table
        $this->crud->deleteData(array('student_id'=>$this->input->post('student_id')),'tbl2');
        // delete student in student_subject table
        // $this->crud->deleteData(array('student_id'=>$this->input->post('student_id')),'tbl9');
        $this->user_model->recordLogs('Delete Student Records',$this->session->userdata('user_id'));
        echo json_encode(array("status"=>TRUE));
    }

    /**
     * student_remove_enrollment_registration function.
     * 
     * @access public
     * @return delete student entollment registration
     */
    public function student_remove_enrollment_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // remove students enrollment registration
        $this->student_model->removeStudentRegistration($this->input->post('tbl_id'));
        $this->user_model->recordLogs('Remove Student Registration',$this->session->userdata('user_id'));
        $this->session->set_flashdata('success','Students Registration has been removed!');
        redirect('register_student');
    }


    /**
     * import_students function.
     * 
     * @access public
     * @return import students
     */
    public function import_students(){
        if(isset($_FILES["file"]["name"])){
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=2; $row<=$highestRow; $row++){
                    $student_number = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $arabic_name    = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $english_name   = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    // count if student number is already existing
                    $count = $this->crud->getData('','c',array('student_no'=>$student_number),'tbl2');
                    // student number is valid
                    if($count==0){
                        $students[] = array(
                            'student_no'    => $student_number,
                            'english_name'  => $english_name,
                            'arabic_name'   => $arabic_name,
                            'created_by'    => $this->session->userdata('email')
                        );
                    }
                }
            }
        }
        // insert batch data (students)
        $insert = $this->crud->basicInsertBatch($students,'tbl2');
        if($insert){
            // success
            $this->session->set_flashdata('success','Students has been registered!.');
        }else{
            // error
            $this->session->set_flashdata('danger','Error occured!.');
        }
        redirect('students');
    }

}