<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Management class created by CodexWorld
 */
class User extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('crud');
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
     * user_login function.
     * 
     * @access public
     * @return render user login form
     */
    public function user_login(){
        // Is user already logged in
        if($this->session->userdata('isUserLoggedIn')){
            redirect('user/user_role');
        }
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('oam-users/oam-login/header-bar');
        $this->load->view('templates/content-inner');
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-login/login_includes');
        $this->load->view('oam-users/oam-login/login');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * user_change_password function.
     * 
     * @access public
     * @return render user change password form
     */
    public function user_change_password(){
        $this->crud->credibilityAuthChangePassword();
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('templates/content-inner');
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-login/change_password');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * users function.
     * 
     * @access public
     * @return render list of users
     */
    public function users(){
        $this->crud->credibilityAuth(array('Administrator'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Users','icon'=>'icon-user');
        // Necessary page data
        $data['users'] = $this->user_model->getUsers('a','');
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
        $this->load->view('oam-users/oam-admin/admin-users',$data);
        // Page modals
        $this->load->view('oam-users/oam-admin/admin-modals/view-user-modal');
        $this->load->view('oam-users/oam-admin/admin-modals/edit-user-modal');
        $this->load->view('templates/modals/success');
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * user_profile function.
     * 
     * @access public
     * @return render user profile
     */
    public function user_profile(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty','Program Head'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Profile','icon'=>'icon-user');
        // Necessary page data
        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');

        // Manage menu for different kind of user
        if($this->session->userdata('designation')=='Administrator' || $this->session->userdata('designation')=='Registrar'):
        $this->load->view('oam-users/oam-admin/admin-menu/menu');
        else:
        $this->load->view('oam-users/oam-faculty/faculty-menu/menu');
        endif;

        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flash data messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/user-profile');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * user_register function.
     * 
     * @access public
     * @return render user registration
     */
    public function user_register(){
        $this->crud->credibilityAuth(array('Administrator'));
        // Subheader bar title and icon
        $data['subheader'] = array('title'=>'Register Users','icon'=>'icon-padnote');
        // Necessary page data

        // Page headers
        $this->load->view('templates/header');
        $this->load->view('templates/header-bar');
        $this->load->view('oam-users/oam-admin/admin-menu/menu');
        $this->load->view('templates/content-inner');
        $this->load->view('templates/subheader-bar',$data);
        // Flashdata messages
        $this->load->view('templates/flashdata/flashdata-success');
        $this->load->view('templates/flashdata/flashdata-warning');
        $this->load->view('templates/flashdata/flashdata-danger');
        // Page contents
        $this->load->view('oam-users/oam-admin/user-registration');
        // Page modals
        // Page footer
        $this->load->view('templates/footer');
    }

    /**
     * user_save_registration function.     
     * 
     * @access public
     * @return save users
     */
    public function user_save_registration(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $password   = $this->user_model->hashUsersPassword($this->input->post('password'));
        $reset_date = $this->user_model->generatePasswordResetDate();
        $data = array(
            'u_full_name'    => $this->input->post('fname'),
            'u_email_address'=> $this->input->post('email'),
            'u_password'     => $password,
            'designation'    => $this->input->post('designation')
        );
        $new_data = $this->crud->insertBatchvalidateAndRemoveDuplicateData($data,'','u_email_address','','tbl1');
        $insert   = $this->crud->setDataBatch($new_data,array('password_reset_date'=>$reset_date,'created_by'=>$this->session->userdata('email')),'tbl1');
        if($insert){
            $this->user_model->recordLogs('Register users',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success', 'Users has been registered!.');
        }else{
            $this->session->set_flashdata('danger', 'Error occured!.');
        }
        redirect('user_registration');
    }

    /**
     * user_resolve_login function.     
     * 
     * @access public
     * @return process user login request
     */
    public function user_resolve_login(){
        $email    = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));
        $resolve  = $this->user_model->resolveUserLoginCredentials($email,$password);
        if($resolve===TRUE){
            $this->user_model->recordLogs('Login user',$this->session->userdata('user_id'));
            redirect('user/user_role');
        }else{
            $this->session->set_flashdata('danger',$resolve);
            redirect('login');
        }
    }

    /**
     * user_role function.     
     * 
     * @access public
     * @return process role and redirects
     */
    public function user_role(){
        if($this->session->userdata('isUserLoggedIn')===TRUE){
            if($this->session->userdata('password_reset_date')<=date('Y-m-d H:i:s')){
                redirect('change_password');
            }else{
                if($this->session->userdata('designation')=='Registrar'){
                    redirect('admin_dashboard');
                }else if($this->session->userdata('designation')=='Administrator'){
                    redirect('admin_dashboard');
                }else if($this->session->userdata('designation')=='Faculty'){
                    redirect('faculty_dashboard');
                }else if($this->session->userdata('designation')=='Program Head'){
                    redirect('admin_dashboard');
                }
            }
        }
        redirect('login');
    }

    /**
     * user_cp function.     
     * 
     * @access public
     * @return process change password request
     */
    public function user_cp(){
        $this->crud->credibilityAuthChangePassword();
        $password1 = trim($this->input->post('password1'));
        $password2 = trim($this->input->post('password2'));
        if($password1==$password2){
            $change_pass = $this->user_model->changeUserPassword($password1);
            if($change_pass==TRUE){
                $this->user_model->recordLogs('Change password',$this->session->userdata('user_id'));
                $this->session->set_flashdata('success','Password has been successfully changed!.');
                redirect('logout');
            }
            $this->session->set_flashdata('danger','Error occur!.');
            redirect('change_password');
        }
        $this->session->set_flashdata('warning','Password does not match!.');
        redirect('change_password');
    }

    /**
     * user_update_profile function.     
     * 
     * @access public
     * @return process update profile request
     */
    public function user_update_profile(){
        $this->crud->credibilityAuth(array('Administrator','Registrar','Faculty','Program Head'));
        $user_id  = $this->session->userdata('user_id');
        $name     = trim($this->input->post('name'));
        $email    = trim($this->input->post('email'));
        $password = $this->user_model->hashPassword(trim($this->input->post('password1')));
        if(!empty($name) && !empty($email)){
            if($this->user_model->isEmailValid($email,$this->session->userdata('user_id'))===TRUE && !empty(trim($this->input->post('password1')))){
                $this->crud->updateData(array('u_full_name'=>$name,'u_email_address'=>$email,'u_password'=>$password,'updated_by'=>$this->session->userdata('email')),array('user_id'=>$user_id),'tbl1');
                $this->user_model->recordLogs('Update user profile',$this->session->userdata('user_id'));
                $this->session->set_flashdata('success','Profile has been successfully updated!. You have to re-login to see changes made.');
            }else if($this->user_model->isEmailValid($email,$this->session->userdata('user_id'))===FALSE){
                $this->session->set_flashdata('warning','Profile has not been updated due to an email that is not valid.');
            }else{
                $this->crud->updateData(array('u_full_name'=>$name,'u_email_address'=>$email,'updated_by'=>$this->session->userdata('email')),array('user_id'=>$user_id),'tbl1');
                $this->user_model->recordLogs('Update user profile',$this->session->userdata('user_id'));
                $this->session->set_flashdata('success','Profile has been successfully updated!. You have to re-login to see changes made.');
            }
        }else{
            $this->session->set_flashdata('warning','Profile has not been updated due to empty required fields.');
        }
        redirect('user_profile');
    }

    /**
     * users function.
     * 
     * @access public
     * @param int $id
     * @return process get user request by id
     */
    public function get_user($id = NULL){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $data = $this->user_model->getUsers('s',array('user_id'=>$id));
        echo json_encode($data);
    }

    /**
     * user_update function.
     * 
     * @access public
     * @return process update user request
     */
    public function user_update(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        $alert   = 'alert alert-success';
        $msg     = 'User has been updated!';
        $user_id = $this->input->post('user_id');
        $data = array(
            'u_full_name'     => trim($this->input->post('name')),
            'u_email_address' => trim($this->input->post('email')),
            'designation'     => trim($this->input->post('designation')),
            'updated_by'      => $this->session->userdata('email')
        );
        $cond = array('user_id' => $user_id);
        if(!empty($data['u_email_address']) && !empty($data['u_full_name']) && !empty($data['designation'])){
            if($this->user_model->isEmailValid($data['u_email_address'],$user_id)==TRUE){
                $this->crud->updateData($data,$cond,'tbl1');
                $this->user_model->recordLogs('Update user information',$this->session->userdata('user_id'));
            }else{
                $alert = 'alert alert-danger';
                $msg   = 'User has not been updated due to invalid email address.';
            }
        }else{
            $alert = 'alert alert-warning';
            $msg   = 'User has not been updated due to empty required fields.';
        }
        
        echo json_encode(array("status"=>TRUE,"msg"=>$msg,"class_add"=>$alert));
    }

    /**
     * user_activate_deactivate function.
     * 
     * @access public
     * @return process activation or deactivation user request
     */
    public function user_activate_deactivate(){
        $this->crud->credibilityAuth(array('Administrator','Registrar'));
        if($this->input->post('deactivate')){
            // Deactivate users
            $data = array('user_id'=>$this->input->post('user_id'));
            $this->crud->updateDataBatch($data,array('status'=>'0','updated_by'=>$this->session->userdata('email')),'user_id','tbl1');
            $this->user_model->recordLogs('Deactivate users',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','User(s) has been deactivated');
        }else if($this->input->post('activate')){
            // Deactivate users
            $data = array('user_id'=>$this->input->post('user_id'));
            $this->crud->updateDataBatch($data,array('status'=>'1','updated_by'=>$this->session->userdata('email')),'user_id','tbl1');
            $this->user_model->recordLogs('Activate users',$this->session->userdata('user_id'));
            $this->session->set_flashdata('success','User(s) has been activated');
        }
        redirect('admin_users');
    }

    /**
     * user_logout function.     
     * 
     * @access public
     * @return logout user
     */
    public function user_logout(){
        $userdata = array('isUserLoggedIn','user_id','email','password_reset_date','designation','recent_login','device_name','device_ip_address');
        $this->user_model->recordLogs('Logout user',$this->session->userdata('user_id'));
        $this->session->unset_userdata($userdata);
        redirect('login');
    }

    /**
     * user_err function.
     * 
     * @access public
     * @return render unauthorized page for faculty
     */
    public function user_err(){
        if(!empty($this->user_model->dYearMonth()) && $this->user_model->dYearMonth()!=date('Y-m')){
            redirect('login');
        }
        show_error('Internal Server Error!', 400);
    }

}