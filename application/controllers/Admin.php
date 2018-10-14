<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Admin extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('admin_model');
        $this->load->model('vocational_program_model');
        $this->load->model('user_model');
        $this->load->model('admin_report_model');
    }

    // View templating references
    public function template_reference(){
        // set your header icon and title
        $data['subheader'] = array('title'=>'Template Reference Header','icon'=>'fa fa-cogs');
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
     * admin_dashboard function.
     * 
     * @access public
     * @return render admin dashboard
     */
    public function admin_dashboard(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('templates/content-inner');
        // Page content
        if($this->session->userdata('designation')=='Administrator'):
        // administrator home/landing page after login
        $this->load->view('oam-users/oam-admin/admin-home');
        else:
        // registrar home/landing page after login
        $this->load->view('oam-users/oam-admin/registrar-home');
        endif;
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * admin_history function.
     * 
     * @access public
     * @return render admin history logs
     */
    public function admin_history(){
        $this->crud->credibilityAuth(array('Administrator'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'History Logs','icon'=>'fa fa-history');
        // Necessary page data
        $data['history']   = $this->admin_model->getHistoryLogs('');
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Page contents
        $this->load->view('oam-users/oam-admin/admin-history');
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/view-history-modal',$data);
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * admin_security function.
     * 
     * @access public
     * @return render admin security config
     */
    public function admin_security(){
        $this->crud->credibilityAuth(array('Administrator'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Security Configuration','icon'=>'fa fa-cog');
        // Necessary page data
        $data['config']    = $this->admin_model->getSecurityConfig();
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
        $this->load->view('oam-users/oam-admin/admin-security',$data);
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * attendance_report function.
     * 
     * @access public
     * @return render admin attendance reporting
     */
    public function attendance_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Batch Year Reports','icon'=>'icon-padnote');
        // Necessary page data
        $data['batch_year']  = $this->crud->getData('','a','','tbl8');
        $data['voc_program'] = $this->vocational_program_model->getVocationalPrograms('a','');
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
        $this->load->view('oam-users/oam-admin/admin-report',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/generate-voc-program-report-modal',$data);
        $this->load->view('oam-users/oam-admin/admin-modals/generate-voc-program-enlistment-report-modal',$data);
        $this->load->view('oam-users/oam-admin/admin-modals/generate-subject-code-report-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/generate-subject-code-enlistment-report-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/generate-subject-code-remarks-report-modal');

        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * admin_update_security_config function.
     * 
     * @access public
     * @return process update security config action
     */
    public function admin_update_security_config(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $login_attempt = trim($this->input->post('login_attempt'));
        $soft_lock     = trim($this->input->post('soft_lock'));
        $password_age  = trim($this->input->post('password_age'));
        $update_config = $this->crud->updateData(array('max_login_attempt'=>$login_attempt,'soft_lock'=>$soft_lock,'max_password_age'=>$password_age),'','tbl3');
        if($update_config){
            $this->user_model->recordLogs('Update Security Configuration',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Security Configuration has been updated!.');
            redirect('admin_security');
        }
        $this->session->set_flashdata('danger','Error occured!.');
        redirect('admin_security');
    }

    /**
     * get_history function.
     * 
     * @access public
     * @return array on success
     */
    public function get_history($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->admin_model->getHistoryLogs(array('tbl_id'=>$id));
        echo json_encode($data);
    }

    // /**
    //  * admin_generate_voc_program_attendance_report function.
    //  * Deprecated 10/11/2018
    //  * 
    //  * @access public
    //  * @return csv|pdf attendance report by vocational program
    //  */
    // public function admin_generate_voc_program_attendance_report(){
    //     $this->crud->credibilityAuth(array('Administrator','Registrar'));
    //     // get students with vocational program
    //     $condition= array('vocational_program'=>$this->input->post('vocational_program'),'batch_year'=> $this->input->post('batch_year_id'));
    //     $range1 = $this->input->post('date_range1');
    //     $range2 = $this->input->post('date_range2');
    //     $voc_program= $this->vocational_program_model->getVocationalPrograms('s',array('voc_program_id'=>$condition['vocational_program']));
    //     $students   = $this->admin_model->getStudentsBasicInfo($condition,'a');
    //     $attendance = $this->admin_model->getStudentDailyAttendanceRecord($students,$range1,$range2,$condition['batch_year']);

    //     if((!empty($condition['vocational_program']) && !empty($range1) && !empty($range2)) && ($range1 <= $range2)){
    //         if(!empty($attendance)){
    //             if($this->input->post('export_csv')){
    //                 $this->admin_report_model->generateVocProgramAttendanceReportCsv($attendance,$voc_program,$range1,$range2);
    //                 exit;
    //             }else if($this->input->post('export_pdf')){
    //                 $this->admin_report_model->generateVocProgramAttendanceReportPdf($attendance,$voc_program,$range1,$range2);
    //             }
    //         }
    //         $this->session->set_flashdata('warning', 'No reports found!.');
    //         redirect('attendance_report');
    //     }
    //     $this->session->set_flashdata('danger', 'Invalid input.');
    //     redirect('attendance_report');
    // }

    // /**
    //  * admin_generate_subject_code_attendance_report function.
    //  * Deprecated 10/11/2018
    //  * 
    //  * @access public
    //  * @return csv|pdf attendance report by subject code
    //  */
    // public function admin_generate_subject_code_attendance_report(){
    //     $this->crud->credibilityAuth(array('Administrator','Registrar'));
    //     // get students with vocational program
    //     $condition= array('subject_code'=>$this->input->post('subject_code'),'batch_year'=> $this->input->post('batch_year_id'));
    //     $range1 = $this->input->post('date_range1');
    //     $range2 = $this->input->post('date_range2');
        
    //     $students   = $this->admin_model->getStudentsBasicInfo($condition,'a');
    //     $attendance = $this->admin_model->getStudentSubjectCodeAttendanceRecord($students,$range1,$range2,$condition['subject_code'],$condition['batch_year']);
        
    //     if((!empty($condition['subject_code']) && !empty($range1) && !empty($range2)) && ($range1 <= $range2)){
    //         if(!empty($attendance)){
    //             if($this->input->post('export_csv')){
    //                 $this->admin_report_model->generateSubjectCodeAttendanceReportCsv($attendance,$condition,$range1,$range2);
    //                 exit;
    //             }else if($this->input->post('export_pdf')){
    //                 $this->admin_report_model->generateSubjectCodeAttendanceReportPdf($attendance,$condition,$range1,$range2);
    //             }
                
    //         }
    //         $this->session->set_flashdata('warning', 'No reports found!.');
    //         redirect('attendance_report');
    //     }
    //     $this->session->set_flashdata('danger', 'Invalid input.');
    //     redirect('attendance_report');
    // }


    /*************************** Start Action controllers for generating enlistment report ***************************/

    /**
     * admin_generate_voc_program_enlistment_report function.
     * 
     * @access public
     * @return csv|pdf enlistment report by vocational program
     */
    public function admin_generate_voc_program_enlistment_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // get students with vocational program
        $condition  = array('vocational_program'=>$this->input->post('vocational_program'),'batch_year'=> $this->input->post('batch_year_id'));
        $voc_program= $this->vocational_program_model->getVocationalPrograms('s',array('voc_program_id'=>$condition['vocational_program']));
        $students   = $this->admin_model->getStudentsBasicInfo($condition,'a');
        if(!empty($condition['vocational_program'])){
            
            if($this->input->post('export_csv')){
                $this->admin_report_model->generateVocProgramEnlistmentReportCsv($voc_program,$students);
                exit;
            }else if($this->input->post('export_pdf')){
                $this->admin_report_model->generateVocProgramEnlistmentReportPdf($voc_program,$students);
            }
            
            $this->session->set_flashdata('warning', 'No reports found!.');
            redirect('attendance_report');
        }
        $this->session->set_flashdata('danger', 'Invalid input.');
        redirect('attendance_report');
    }

    /**
     * admin_generate_subject_code_enlistment_report function.
     * 
     * @access public
     * @return csv|pdf enlistment report by subject code
     */
    public function admin_generate_subject_code_enlistment_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // get students with vocational program
        $condition= array('subject_code'=>$this->input->post('subject_code'),'batch_year'=> $this->input->post('batch_year_id'));
        $students   = $this->admin_model->getStudentsBasicInfo($condition,'a');
        
        if(!empty($condition['subject_code'])){
            if($this->input->post('export_csv')){
                $this->admin_report_model->generateSubjectCodeEnlistmnentReportCsv($students,$condition);
                exit;
            }else if($this->input->post('export_pdf')){
                $this->admin_report_model->generateSubjectCodeEnlistmnentReportPdf($students,$condition);
            }
            $this->session->set_flashdata('warning', 'No reports found!.');
            redirect('attendance_report');
        }
        $this->session->set_flashdata('danger', 'Invalid input.');
        redirect('attendance_report');
    }

    /*************************** End Action controllers for generating enlistment report ***************************/


    /*************************** Start Action controllers for generating attendance report ***************************/

    /**
     * generate_voc_program_attendance_report function.
     * commit 10/11/2018
     * 
     * @access public
     * @return csv|pdf attendance report by vocational program
     */
    public function generate_voc_program_attendance_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        // get inputs
        $condition= array('vocational_program'=>$this->input->post('vocational_program'),'batch_year'=> $this->input->post('batch_year_id'));
        $range1 = $this->input->post('date_range1');
        $range2 = $this->input->post('date_range2');
        // get necessary report data
        $voc_program= $this->vocational_program_model->getVocationalPrograms('s',array('voc_program_id'=>$condition['vocational_program']));
        $students   = $this->admin_model->getStudentsBasicInfo($condition,'a');
        $attendance = $this->admin_model->getStudentAttendanceByVocationalProgram($students,$range1,$range2,$condition['batch_year']);
        $att_record = $this->admin_model->getStudentDailyAttendanceRecord($students,$range1,$range2,$condition['batch_year']);
        $att_dates  = $this->crud->getDistinctValueOnAssociativeArray($attendance,'attendance_date');
        // generate report data in pdf or csv format from admin_report_model
        if((!empty($condition['vocational_program']) && !empty($range1) && !empty($range2)) && ($range1 <= $range2)){
            if(!empty($attendance)){
                if($this->input->post('export_csv')){
                    $this->admin_report_model->generateStudentAttendanceByVocationalProgramCsv($attendance,$att_record,$att_dates,$voc_program,$range1,$range2);
                    exit;
                }else if($this->input->post('export_pdf')){
                    $this->admin_report_model->generateVocProgramAttendanceReportPdf($attendance,$voc_program,$range1,$range2);
                }
            }
            $this->session->set_flashdata('warning', 'No reports found!.');
            redirect('attendance_report');
        }
        $this->session->set_flashdata('danger', 'Invalid input.');
        redirect('attendance_report');
        
    }

    /**
     * generate_subject_code_attendance_report function.
     * commit 10/11/2018
     * 
     * @access public
     * @return csv|pdf attendance report by student
     */
    public function generate_subject_code_attendance_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        // get inputs
        $con    = array('subject_code'=>$this->input->post('subject_code'),'batch_year'=> $this->input->post('batch_year_id'));
        $range1 = $this->input->post('date_range1');
        $range2 = $this->input->post('date_range2');
        // get necessary report data
        $students   = $this->admin_model->getStudentsBasicInfo($con,'a');
        $attendance = $this->admin_model->getStudentAttendanceBySubjectCode($range1,$range2,$con['subject_code'],$con['batch_year']);
        $att_record = $this->admin_model->getStudentSubjectCodeAttendanceRecord($students,$range1,$range2,$con['subject_code'],$con['batch_year']);
        $att_dates  = $this->crud->getDistinctValueOnAssociativeArray($attendance,'attendance_date');
        // generate report data in pdf or csv format from admin_report_model
        if((!empty($con['subject_code']) && !empty($range1) && !empty($range2)) && ($range1 <= $range2)){
            if(!empty($attendance) && !empty($att_record)){
                if($this->input->post('export_csv')){
                    $this->admin_report_model->generateStudentAttendanceBySubjectCodeCsv($attendance,$att_record,$att_dates,$con,$range1,$range2);
                    exit;
                }else if($this->input->post('export_pdf')){
                    $this->admin_report_model->generateSubjectCodeAttendanceReportPdf($attendance,$con,$range1,$range2);
                }
            }
            $this->session->set_flashdata('warning', 'No reports found!.');
        }else{
            $this->session->set_flashdata('danger', 'Invalid input.');
        }
        redirect('attendance_report');
    }

    /*************************** End Action controllers for generating attendance report ***************************/




    /*************************** Start Action controllers for generating remarks report ***************************/

    /**
     * generate_subject_code_remarks_report function.
     * commit 10/12/2018
     * 
     * @access public
     * @return csv|pdf attendance report by student
     */
    public function generate_subject_code_remarks_report(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty'));
        // get inputs
        $con    = array('subject_code'=>$this->input->post('subject_code'),'batch_year'=> $this->input->post('batch_year_id'));
        $range1 = $this->input->post('date_range1');
        $range2 = $this->input->post('date_range2');
        // get necessary report data
        $students   = $this->admin_model->getStudentsBasicInfo($con,'a');
        $attendance = $this->admin_model->getStudentAttendanceBySubjectCode($range1,$range2,$con['subject_code'],$con['batch_year']);
        $att_record = $this->admin_model->getStudentSubjectCodeAttendanceRecord($students,$range1,$range2,$con['subject_code'],$con['batch_year']);
        $att_dates  = $this->crud->getDistinctValueOnAssociativeArray($attendance,'attendance_date');
        // generate report data in pdf or csv format from admin_report_model
        if((!empty($con['subject_code']) && !empty($range1) && !empty($range2)) && ($range1 <= $range2)){
            if(!empty($attendance) && !empty($att_record)){
                if($this->input->post('export_csv')){
                    $this->admin_report_model->generateStudentRemarksReportBySubjectCodeCsv($attendance,$att_record,$att_dates,$con,$range1,$range2);
                    exit;
                }else if($this->input->post('export_pdf')){
                    $this->admin_report_model->generateSubjectCodeAttendanceReportPdf($attendance,$con,$range1,$range2);
                }
            }
            $this->session->set_flashdata('warning', 'No reports found!.');
        }else{
            $this->session->set_flashdata('danger', 'Invalid input.');
        }
        redirect('attendance_report');
    }

    /*************************** End Action controllers for generating remarks report ***************************/

}