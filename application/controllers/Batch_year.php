<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Batch_year extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('user_model');
        $this->load->model('batch_year_model');
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
     * current_batch_year function.
     * 
     * @access public
     * @return render current opened batch year
     */
    public function current_batch_year(){
    	$this->crud->credibilityAuth(array('Administrator'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Batch Year','icon'=>'fa fa-graduation-cap');
        // Necessary page data
        $data['batch_year']= $this->batch_year_model->getBatchCurrentYear();
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
        $this->load->view('oam-users/oam-admin/admin-batch-year');
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/new-batch-year-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * set_batch_year function.
     * 
     * @access public
     * @return set new batch year
     */
    public function set_batch_year(){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert = 'alert alert-success';
        $msg   = 'Batch Year has been successfully created!';
    	$data = array(
    		'batch_name' => $this->input->post('batch_name'),
    		'created_by' => $this->session->userdata('user_id')
    	);
    	if(empty($this->crud->getData('batch_name','s',array('batch_name'=>$data['batch_name']),'tbl8'))){
    		$set_batch_year = $this->crud->setData($data,'','tbl8');
	    	if($set_batch_year===FALSE){
	    		$alert = 'alert alert-danger';
	        	$msg   = 'Error occured!';
	    	}else{
	    		$this->user_model->recordLogs('Create new Batch Year',$this->session->userdata('user_id'));
	    	}
    	}else{
    		$alert = 'alert alert-warning';
        	$msg   = 'Batch Year is already existing!';
    	}
    	echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * update_batch_year_status function.
     * 
     * @access public
     * @return update batch year status
     */
    public function update_batch_year_status(){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
    	$batch_name = $this->input->post('batch_name');
    	$status 	= $this->input->post('batchyear_on_of');
    	if($status=='FALSE'){
    		$this->crud->updateData(array('is_active'=>$status),array('batch_name'=>$batch_name),'tbl8');
    		$this->user_model->recordLogs('Disabled Batch Year',$this->session->userdata('user_id'));
    		$this->session->set_flashdata('warning','Batch Year has been Disabled.');
    	}else{
    		$this->crud->updateData(array('is_active'=>'TRUE'),array('batch_name'=>$batch_name),'tbl8');
    		$this->user_model->recordLogs('Enabled Batch Year',$this->session->userdata('user_id'));
    		$this->session->set_flashdata('success','Batch Year has been Enabled.');
    	}
    	redirect('batch_year');
    }

}