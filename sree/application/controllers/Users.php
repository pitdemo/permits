<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends CI_Controller {

    function __construct()
    { 
        parent::__construct();      

        $this->load->model(array('public_model','security_model'));

        $this->data=array('controller'=>$this->router->fetch_class().'/');
    } 
    
    //Login Page
    public function index()
    {
        if($this->session->userdata('is_logged_in'))
        {
            if($this->session->userdata('user_role')=='SA')
            {
                redirect(base_url('departments'));
            }
            else if($this->session->userdata('user_role')!='SA')
            {
                redirect(base_url('jobs'));
            }
        }
        #echo 'SS '.$this->lang->line('language_key');;
        $this->form_validation->set_rules('email_address','Email ID','required|trim');
        $this->form_validation->set_rules('pass_word','Last Name','trim');
        if($this->form_validation->run())
        {
            $email = $this->input->post('email_address');

            $password = base64_encode($this->input->post('pass_word'));     

            
            $position=strpos($email,"@");

            if($position=='')
                $email=$email.'@shreecement.com';

            $req=array(
                'select'=>'user_role',
                'where'=>array('email_address'=>$email, 'status !='=>STATUS_DELETED),
                'table'=>USERS
            );
            //Verify the account is SA or Other Account
            $qry=$this->public_model->fetch_data($req);
            
            #echo $this->db->last_query(); exit;
            
            if($qry!==false)
            {
                $fet=$qry->row_array();
            
                if( (!empty($qry) && $qry->num_rows()>0 && $fet['user_role'] !='SA'))
                {
                    //Non SA Account Details
                    $req=array(
                        'select'=>'i.id,i.department_id,i.first_name,i.last_name,i.email_address,i.pass_word,i.user_role,i.status,j.status as comp_status,j.name as department_name,is_default_password_changed,permission,i.is_isolator,i.employee_id,j.short_code,i.is_hod,i.is_section_head',
                        'where'=>array('i.email_address'=>$email, 'i.status !='=>'deleted'),
                        'table1'=>USERS.' i',
                        'table2'=>DEPARTMENTS.' j',
                        'join_on'=>'i.department_id=j.id ',
                        'join_type'=>'inner',
                        'num_rows'=>false
                    );
                    $user_details = $this->public_model->join_fetch_data($req);                
                }
                else{
                      $req=array(
                        'select'=>'id,first_name,last_name,pass_word,email_address,user_role,department_id,status,is_default_password_changed,permission,is_isolator,employee_id,is_hod,is_section_head',
                        'where'=>array('email_address'=>$email),
                        'table'=>USERS
                    );            
                    $user_details=$this->public_model->fetch_data($req);                
                }  
                //Check the account detail in DB
                if(!empty($user_details) && $user_details->num_rows()>0)
                {
    
                    $user_details =  $user_details->row_array();
                    
                    #echo '<br /> P '.$password. ' = '.$user_details['pass_word']; exit;
                    //Password Validation
                    if($password != $user_details['pass_word']){
                        $this->session->set_flashdata('failure',LOGIN_ERROR);
                        redirect('users');    
                    }
                        
                        //Check it is an active user account and Company Account
                        if( @constant($user_details['user_role']) !=SA &&  $user_details['comp_status'] != STATUS_ACTIVE || $user_details['status'] != STATUS_ACTIVE ){
                                $this->session->set_flashdata('failure',ACC_DISABLED);
                                redirect('users');    
                        }
                    
                        //Writing values into Session
                        /*swathi - start*/
                        if(@constant($user_details['user_role']) == SA)
                        {
                            $login_data = array(
                               ADMIN.'employee_id'=>$user_details['employee_id'],
                               ADMIN.'user_id'=>$user_details['id'],
                               ADMIN.'first_name'=>$user_details['first_name'],
                               ADMIN.'user_role'  => ($user_details['user_role']=='') ? 'PA' : $user_details['user_role'],
                               ADMIN.'email_address' => $user_details['email_address'],
                               ADMIN.'department_id' => (isset($user_details['department_id'])) ? $user_details['department_id'] : '',
                               ADMIN.'department_name'=>(isset($user_details['department_name'])) ? $user_details['department_name'] : '',
                               ADMIN.'is_default_password_changed' => 'yes',
                               ADMIN.'is_logged_in' => TRUE,
                               ADMIN.'is_isolator'=>(isset($user_details['is_isolator'])) ? $user_details['is_isolator'] : '',
                               ADMIN.'is_hod'=>(isset($user_details['is_hod'])) ? $user_details['is_hod'] : '',
                               ADMIN.'is_section_head'=>(isset($user_details['is_section_head'])) ? $user_details['is_section_head'] : '',
                            );
                        }
                        else
                        {
                            $login_data = array(
                               'employee_id'=>$user_details['employee_id'],
                               'user_id'=>$user_details['id'],
                               'first_name'=>$user_details['first_name'],
                               'user_role'  => ($user_details['user_role']=='') ? 'PA' : $user_details['user_role'],
                               'email_address' => $user_details['email_address'],
                                'department_id' => (isset($user_details['department_id'])) ? $user_details['department_id'] : '',
                                'department_name'=>(isset($user_details['department_name'])) ? $user_details['department_name'] : '',
                                'department_short_code'=>(isset($user_details['short_code'])) ? $user_details['short_code'] : '',
                                'is_default_password_changed' => 'yes',
                               'is_logged_in' => TRUE,
                               'permission'=>$user_details['permission'],
                               'is_isolator'=>(isset($user_details['is_isolator'])) ? $user_details['is_isolator'] : '',
                               'is_hod'=>(isset($user_details['is_hod'])) ? $user_details['is_hod'] : '',
                               'is_section_head'=>(isset($user_details['is_section_head'])) ? $user_details['is_section_head'] : ''
                            ); 
                        }             
                        /*swathi - end*/
                        
                        $this->session->set_userdata($login_data);
                        $redirect = '';
                        
                        $key = array_search('redirect',$this->uri->segment_array());
                        if($key)
                        {
                            $redirect = base64_decode($this->uri->segment($key+1));
                        }
                        
                        // echo '<pre>'; print_r($_SESSION);

                       //  print_r($this->session->userdata); echo 'ddd '.$redirect; exit;
                        #if(constant($user_details['user_role'])==SA) echo 'Yes'; else echo 'No'; exit;
                    //Add last login details to DB
                        $this->public_model->last_login();
                        $notes=array('type'=>"login");
                        if(@constant($user_details['user_role'])==SA)
                        {
                            redirect('departments/users');
                        }
                        else if($user_details['is_default_password_changed'] == 'no') //swathi
                        {
                            redirect(base_url().'users/change_password/');
                        }
                        else if($redirect=='')
                        {
                            redirect('jobs/');
                        }
                        else
                        redirect($redirect); 
                    }
            }
            //If No data returns throw Invalid Credentials
            $this->session->set_flashdata('failure',LOGIN_ERROR);
            redirect('users');               
        }
        $this->load->view($this->data['controller'].'index');
    }
    
    //Forgot Password Page
    public function forgot_password(){
        $this->load->view($this->data['controller'].'forgot_password',$this->data);        
    }
    
    //Resetting the password
    public function change_forgot_password(){
        $email = array_search('email',$this->uri->segment_array());
        $email_address='';
        if($email !==FALSE && $this->uri->segment($email+1))
        {
            //Check the Email Exisits in the DB
            $email_address = base64_decode($this->uri->segment($email+1));                
             $num_rows=$this->public_model->ajax_check_data_exists(array('table_name'=>USERS,'where'=>'email_address = "'.$email_address.'" and status = "'.STATUS_ACTIVE.'"'));
            if($num_rows>0){                                
                $this->form_validation->set_rules('new_password','New Password','required|trim');
                $this->form_validation->set_rules('conf_password','Confirm Password','required|trim|matches[new_password]');
                $this->form_validation->set_error_delimiters('<label class="error">', '</label>');
                if($this->form_validation->run()){
                    $data=array(
                        'pass_word'=>base64_encode($this->input->post('new_password')),
                        'modified'=>date('Y-m-d H:i:s'),
                        'is_default_password_changed' => 'yes'
                    );
                    $whr=array('email_address'=>$email_address);
                    $this->db->update(USERS,$data,$whr);
                    $this->session->set_userdata('is_default_password_changed','yes');   
                    $req=array('select'=>'id,first_name,last_name,pass_word,email_address,user_role,department_id,status,is_default_password_changed',
                                        'where'=>array('email_address'=>$email_address, 'status !='=>'deleted'),
                                       'table'=>USERS
                    );
                    $user_details = $this->public_model->fetch_data($req);
                    //Check data exisits in DB
                    if($user_details && $user_details->num_rows()>0){
                        $user_details =  $user_details->row_array();
                        if($user_details['status'] !=STATUS_ACTIVE){
                            //Disabled Account
                            $this->session->set_flashdata('failure',ACC_DISABLED);
                            redirect('users');    
                        }
                        //If valid user setting session values and login to their account
                        $login_data = array(
                           'user_id'=>$user_details['id'],
                           'first_name'=>$user_details['first_name'],
                           'user_role'  => ($user_details['user_role']=='') ? 'PA' : $user_details['user_role'],
                           'email_address' => $user_details['email_address'],
                            'department_id' => (isset($user_details['department_id'])) ? $user_details['department_id'] : '',
                            'department_name'=>(isset($user_details['department_name'])) ? $user_details['department_name'] : '',
                            'is_default_password_changed' =>'yes',
                           'is_logged_in' => TRUE,
                           'is_isolator'=>(isset($user_details['is_isolator'])) ? $user_details['is_isolator'] : '',
                        );              
                        
                        $this->session->set_userdata($login_data);

                        $this->session->set_flashdata('success',DB_UPDATE);
                        $this->public_model->last_login();
                       
                        redirect(base_url());
                    }
                }
                //IF not data exisits in DB
                $this->load->view($this->data['controller'].'change_forgot_password',$this->data);        
            }else{
                //Email ID Does not exists in DB
                $this->session->set_flashdata('failure',LOGIN_ERROR);
                redirect('users');
            }            
        }
        //Email ID Not found in The URL
        else{
                redirect('users');            
        }
    }
    
    //Forgot Password Page
    public function forgot(){
        $this->load->view($this->data['controller'].'forgot',$this->data);        
    }

      //Mail sending for Forgot Password
    public function forgot_mail(){
        //Getting User infor from the DB
        $req=array(
            'select'=>'first_name,status',
            'table'=>USERS,
            'where_condition'=>array('email_address'=>$this->input->post('email_address'),'status !='=>STATUS_DELETED )
        );        
        $qry=$this->public_model->get_data($req);   
        
        if($qry && $qry->num_rows()>0){
            //If exisits checking Status
            $data=$qry->row_array();
            if($data['status']==STATUS_ACTIVE){
                $new_password=substr(round(microtime(true) * 1000),-4);
                $user_info=$qry->row_array();
                $req=array(
                    'to'=>$this->input->post('email_address'),
                    'subject'=>'Password Reset',
                    'first_name'=>$user_info['first_name'],
                    'new_password'=>$new_password
                );
                $req['mail_content']=$this->load->view("email_templates/forgot_password", $req, TRUE);

                $data['pass_word']=base64_encode($new_password);
                $data['is_default_password_changed']='yes';

                $whr=array('email_address'=>$this->input->post('email_address'));

                $this->db->update(USERS,$data,$whr);  
                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: info@pitinfotech.com' . "\r\n";                
               
               mail($req['to'],$req['subject'],$req['mail_content'],$headers);
              
               // $send_mail=$this->public_model->send_email($req);
               $this->session->set_flashdata('success','New password has been sent to your email address');    
               
               echo $msg='true'; exit;            
              
                
               // echo $msg='Mail not sent.'; exit;
            }
            else{
                $this->session->set_flashdata('failure','Your account is disabled...! Please contact our admin.');  
                echo $msg="Your Account is Disabled...! Please Contact Admin."; exit;
            }
        }
        $this->session->set_flashdata('failure','Email ID does not exists...!');  
        echo $msg='Email ID does not exists...!'; exit;
    }
    
  
    //Check the given mail address exists or not in DB
    public function ajax_check_email_exists($id='')
    {
        $this->security_model->chk_is_admin();
        $email_address=trim($this->input->post('email_address'));
       if(trim($id) !=''){
          $id=base64_decode($id);
            $num_rows=$this->public_model->ajax_check_data_exists(array('table_name'=>USERS,'where'=>'email_address = "'.$email_address.'" and id != "'.$id.'"and status = "'.STATUS_ACTIVE.'"'));
        }
        else{
          $num_rows=$this->public_model->ajax_check_data_exists(array('table_name'=>USERS,'where'=>'email_address = "'.$email_address.'" and status = "'.STATUS_ACTIVE.'"'));
        }
        
        if($num_rows>0)
        echo "false";
        else
        echo "true";                
    }

    //Check the given employee id exists or not in DB
    public function ajax_check_employee_id_exists($id='')
    {
        $this->security_model->chk_is_admin();
        $employee_id=trim($this->input->post('employee_id'));
       if(trim($id) !=''){
          $id=base64_decode($id);
            $num_rows=$this->public_model->ajax_check_data_exists(array('table_name'=>USERS,'where'=>'employee_id = "'.$employee_id.'" and id != "'.$id.'"and status = "'.STATUS_ACTIVE.'"'));
        }
        else{
          $num_rows=$this->public_model->ajax_check_data_exists(array('table_name'=>USERS,'where'=>'employee_id = "'.$employee_id.'" and status = "'.STATUS_ACTIVE.'"'));
        }
        
        if($num_rows>0)
        echo "false";
        else
        echo "true";                
    }
    
    //Change logged user's password
    public function change_password(){
        
        //Check the account is logged in or not
        $this->security_model->chk_login();
        
        $this->form_validation->set_rules('old_password','Current Password','required|trim');
        $this->form_validation->set_rules('new_password','New Password','required|trim');
        $this->form_validation->set_rules('conf_password','Confirm Password','required|trim|matches[new_password]');
        $this->form_validation->set_error_delimiters('<label class="error">', '</div>');
        if($this->form_validation->run()){
            $old_password = base64_encode($this->input->post('old_password'));
            $user_info = $this->public_model->fetch_data(array('select'=>'pass_word','where'=>array('id'=>$this->session->userdata('user_id')) ,'table'=>USERS))->row_array();
            $password = $user_info['pass_word'];
            if($password==$old_password){
                $data=array(
                    'pass_word'=>base64_encode($this->input->post('new_password')),
                    'modified'=>date('Y-m-d H:i:s'),
                    'is_default_password_changed'=>'yes' //swathi
                );
                $whr=array('id'=>$this->session->userdata('user_id'));
                $this->db->update(USERS,$data,$whr);   
                $this->session->set_userdata('is_default_password_changed','yes');
                $this->session->set_flashdata('success',CHNG_PASSWD);
                redirect('users/change_password');
            }
            //If Wrong current Password
            $this->session->set_flashdata('failure',WRNG_PASSWD);
            redirect('users/change_password');
        }
        $this->load->view($this->data['controller'].'change_password',$this->data);
    }

    //Change logged user's password
    public function changepassword(){
        
        //Check the account is logged in or not
        $this->security_model->chk_login();
        
        $this->form_validation->set_rules('old_password','Current Password','required|trim');
        $this->form_validation->set_rules('new_password','New Password','required|trim');
        $this->form_validation->set_rules('conf_password','Confirm Password','required|trim|matches[new_password]');
        $this->form_validation->set_error_delimiters('<label class="error">', '</div>');
        if($this->form_validation->run()){
            $old_password = base64_encode($this->input->post('old_password'));
            $user_info = $this->public_model->fetch_data(array('select'=>'pass_word','where'=>array('id'=>$this->session->userdata('user_id')) ,'table'=>USERS))->row_array();
            $password = $user_info['pass_word'];
            if($password==$old_password){
                $data=array(
                    'pass_word'=>base64_encode($this->input->post('new_password')),
                    'modified'=>date('Y-m-d H:i:s'),
                    'is_default_password_changed'=>'yes' //swathi
                );
                $whr=array('id'=>$this->session->userdata('user_id'));
                $this->db->update(USERS,$data,$whr);   
                $this->session->set_userdata('is_default_password_changed','yes');
                $this->session->set_flashdata('success',CHNG_PASSWD);
                redirect('users/changepassword');
            }
            //If Wrong current Password
            $this->session->set_flashdata('failure',WRNG_PASSWD);
            redirect('users/changepassword');
        }
        $this->load->view($this->data['controller'].'changepassword',$this->data);
    }
    
    
    //Logout
    public function logout()
    {
        if($this->session->userdata('user_id'))
        {
            $this->session->sess_destroy();

            session_unset();

            #echo '<pre>'; print_r($this->session->userdata); exit;
            redirect('users');
        }
        else
        {
            redirect();
        }        
    }   
}
 /* End of file application/controllers/Users.php */
 /* End of file application/controllers/Users.php */