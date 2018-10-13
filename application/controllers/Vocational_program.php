<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Vocational_program extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('vocational_program_model');
        $this->load->model('user_model');
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
     * vocational_programs function.
     * 
     * @access public
     * @return render vocational programs table
     */
    public function vocational_programs(){
        $this->crud->credibilityAuth(array('Administrator'));
        $data['subheader'] = array('title'=>'Vocational Programs','icon'=>'icon-list');
        // Necessary page data
        $data['voc_program'] = $this->vocational_program_model->getVocationalPrograms('a','');
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
        $this->load->view('oam-users/oam-admin/admin-vocational-program',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/edit-voc-program-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * vocational_program_create function.
     * 
     * @access public
     * @return render vocational programs creation
     */
    public function vocational_program_create(){
        $this->crud->credibilityAuth(array('Administrator'));
        $data['subheader'] = array('title'=>'New Vocatonal Programs','icon'=>'icon-list');
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
        $this->load->view('oam-users/oam-admin/vocational-program-registration');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * vocational_program_save_registration function.
     * 
     * @access public
     * @return process vocational programs save request
     */
    public function vocational_program_save_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = array(
            'voc_program'         => $this->input->post('voc_program_name'),
            'voc_program_acronym' => $this->input->post('voc_program_acronym')
        );
        $new_data = $this->crud->insertBatchvalidateAndRemoveDuplicateData($data,'','voc_program_acronym','','tbl6');
        $insert   = $this->crud->setDataBatch($new_data,array('created_by'=>$this->session->userdata('user_id')),'tbl6');
        if($insert){
            $this->user_model->recordLogs('Create new Vocatonal Program(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'New Vocatonal Program(s) has been created!.');
            redirect('vocational_program_create');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
            redirect('vocational_program_create');
        }
    }

    /**
     * vocational_program_activate_deactivate function.
     * 
     * @access public
     * @return process vocational programs activation or deactivation request
     */
    public function vocational_program_activate_deactivate(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate users
            $data = array('voc_program_id'=>$this->input->post('voc_program_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('user_id')),'voc_program_id','tbl6');
            $this->user_model->recordLogs('Deactivate Vocatonal Program(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Vocatonal Program(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Activate users
            $data = array('voc_program_id'=>$this->input->post('voc_program_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('user_id')),'voc_program_id','tbl6');
            $this->user_model->recordLogs('Activate Vocatonal Program(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Vocatonal Program(s) has been activated');
        }
        redirect('vocational_programs');
    }

    /**
     * get_vocational_program function.
     * 
     * @access public
     * @return process get vocational program request by id
     */
    public function get_vocational_program($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->vocational_program_model->getVocationalPrograms('s',array('voc_program_id'=>$id));
        echo json_encode($data);
    }

    /**
     * vocational_program_update function.
     * 
     * @access public
     * @return process vocational program update request
     */
    public function vocational_program_update(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert  = 'alert alert-success';
        $msg    = 'Vocatonal Program has been updated!';
        $voc_id = $this->input->post('voc_program_id');
        $data   = array(
            'voc_program' => trim($this->input->post('voc_program')),
            'voc_program_acronym' => trim($this->input->post('voc_program_acronym')),
            'updated_by' => $this->session->userdata('user_id')
        );
        $cond = array('voc_program_id'=>$voc_id);
        if(!empty($data['voc_program']) && !empty($data['voc_program_acronym'])){
            if(empty($this->crud->getData('','s',array('voc_program_acronym'=>$data['voc_program_acronym'],'voc_program_id !='=>$voc_id),'tbl6'))){
                $this->crud->updateData($data,$cond,'tbl6');
                $this->user_model->recordLogs('Update Vocatonal Program',$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-danger';
                $msg   = 'Vocatonal Program has not been updated due to invalid Vocatonal Program Acronym.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Vocatonal Program has not been updated due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

}