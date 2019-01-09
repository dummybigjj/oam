<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Company extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('company_model');
        $this->load->model('user_model');
    }

    /**
     * template_reference function.
     * 
     * @access public
     * @return render system template reference
     */
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
     * company function.
     * 
     * @access public
     * @return render company table view
     */
    public function company(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Program Head'));
        $data['subheader'] = array('title'=>'Company','icon'=>'icon-home');
        // Necessary page data
        $data['company']   = $this->company_model->get_company('a','');
        // Page headers and navigation
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
        $this->load->view('oam-users/oam-admin/admin-company',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/edit-company-modal');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * new_company function.
     * 
     * @access public
     * @return render new_company registration form
     */
    public function new_company(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data['subheader'] = array('title'=>'New Company','icon'=>'icon-home');
        // Necessary page data
        // Page headers and navigation
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
        $this->load->view('oam-users/oam-admin/new-company',$data);
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * company_save_registration function.
     * 
     * @access public
     * @return process save company registration request.
     */
    public function company_save_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = array('company_name'=> $this->input->post('company_name'));
        $insert_batch = $this->crud->insertBatch($data,'',array('created_by'=>$this->session->userdata('email')),'tbl13');
        if($insert_batch){
            $this->user_model->recordLogs('Create new Company(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'New Company(s) has been created!.');
            redirect('new_company');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
            redirect('new_company');
        }
    }

    /**
     * company_activate_deactivate function.
     * 
     * @access public
     * @return process company activation or deactivation request
     */
    public function company_activate_deactivate(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate Company
            $data = array('company_id'=>$this->input->post('company_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('email')),'company_id','tbl13');
            $this->user_model->recordLogs('Deactivate Company',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Company(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Activate Company
            $data = array('company_id'=>$this->input->post('company_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('email')),'company_id','tbl13');
            $this->user_model->recordLogs('Activate Company',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Company(s) has been activated');
        }else if($this->input->post('delete')){
            // Delete Company
            $this->company_model->delete_company($this->input->post('company_id'));
            $this->user_model->recordLogs('Delete Company',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Company(s) has been deleted');
        }
        redirect('company');
    }

    /**
     * get_company function.
     * 
     * @access public
     * @return process get company request by id
     */
    public function get_company($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->company_model->get_company('s',array('company_id'=>$id));
        echo json_encode($data);
    }

    /**
     * company_update function.
     * 
     * @access public
     * @return process company update request
     */
    public function company_update(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert = 'alert alert-success';
        $msg   = 'Company has been updated!';
        $data  = array(
            'company_name'=> trim($this->input->post('company_name')),
            'updated_by'  => $this->session->userdata('email')
        );
        $company_id = $this->input->post('company_id');
        if(!empty($data['company_name'])){
            if(empty($this->crud->getData('','s',array('company_name'=>$data['company_name'],'company_id !='=>$company_id),'tbl13'))){
                $this->crud->updateData($data,array('company_id'=>$company_id),'tbl13');
                $this->user_model->recordLogs('Update Company',$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-danger';
                $msg   = 'Company has not been updated due to invalid company name.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'Error occured due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

}