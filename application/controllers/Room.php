<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class Room extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
        $this->load->model('user_model');
        $this->load->model('room_model');
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
     * rooms function.
     * 
     * @access public
     * @return render rooms table
     */
    public function rooms(){
    	$this->crud->credibilityAuth(array('Administrator'));
    	$data['subheader'] = array('title'=>'Rooms','icon'=>'fa fa-university');
    	// Necessary page data
        $data['room'] = $this->room_model->getRooms('a','');
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
        $this->load->view('oam-users/oam-admin/admin-room',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/edit-room-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * room_create function.
     * 
     * @access public
     * @return render room registration
     */
    public function room_create(){
    	$this->crud->credibilityAuth(array('Administrator'));
    	$data['subheader'] = array('title'=>'New Rooms','icon'=>'fa fa-university');
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
        $this->load->view('oam-users/oam-admin/room-registration');
        // Page modals
        // your modal view here
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * room_save_registration function.
     * 
     * @access public
     * @return process save new room request
     */
    public function room_save_registration(){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
    	$data = array('room_name' => $this->input->post('room_name'));
    	$new_ = $this->crud->insertBatchvalidateAndRemoveDuplicateData($data,'','room_name','','tbl5');
    	$insert = $this->crud->setDataBatch($new_,array('created_by'=>$this->session->userdata('user_id')),'tbl5');
        if($insert){
            $this->user_model->recordLogs('Create new room(s)',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'New room(s) has been created!.');
            redirect('room_create');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
            redirect('room_create');
        }
    }

    /**
     * room_activate_deactivate function.
     * 
     * @access public
     * @return process room activation or deactivation request
     */
    public function room_activate_deactivate(){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate room
            $data = array('room_id'=>$this->input->post('room_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('user_id')),'room_id','tbl5');
            $this->user_model->recordLogs('Deactivate rooms',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Room(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Deactivate room
            $data = array('room_id'=>$this->input->post('room_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('user_id')),'room_id','tbl5');
            $this->user_model->recordLogs('Activate rooms',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Room(s) has been activated');
        }else if($this->input->post('delete')){
            // Delete room
            $this->room_model->deleteRoomPermanently($this->input->post('room_id'));
            $this->user_model->recordLogs('Delete rooms',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','Room(s) has been deleted');
        }
        redirect('rooms');
    }

    /**
     * get_room function.
     * 
     * @access public
     * @return process get room request by id
     */
    public function get_room($id = NULL){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->room_model->getRooms('s',array('room_id'=>$id));
        echo json_encode($data);
    }

    /**
     * room_update function.
     * 
     * @access public
     * @return process room update request
     */
    public function room_update(){
    	$this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'Room has been updated!';
        $room    = trim($this->input->post('room_name'));
        $room_id = $this->input->post('room_id');
        if(!empty($room)){
        	if(empty($this->crud->getData('','s',array('room_name'=>$room,'room_id !='=>$room_id),'tbl5'))){
	        	$data = array('room_name'=>$room,'updated_by'=>$this->session->userdata('user_id'));
	        	$cond = array('room_id'=>$room_id);
	        	$this->crud->updateData($data,$cond,'tbl5');
	        	$this->user_model->recordLogs('Update room name',$this->session->userdata('user_id'));
	        }else{
	        	$alert = 'alert alert-danger';
	            $msg   = 'Room has not been updated due to invalid room name.';
	        }
        }else{
        	$alert = 'alert alert-warning';
            $msg   = 'Room has not been updated due to empty required fields.';
        }
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

}