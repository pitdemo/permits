<?php
//Session validation with Admin for PIM
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Security_model extends CI_Model
{   

    public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}

    public function get_current_date_time()
    {

        $qry=$this->db->query('SELECT NOW() as sys_date')->row_array();

        return date('d-m-Y H:i',strtotime($qry['sys_date']));

    }

    public function chk_login()
    {

        
        if($this->session->userdata('is_logged_in'))
        {

            if(isset($_SESSION['mode']) && $_SESSION['mode']=='mobile')
                $this->check_cookie_user();

            return true;
        }      
        else
        {
             if(isset($_COOKIE) && $_COOKIE['email']!='') {
                $this->check_cookie_user();
                return true;
            } else {
                //redirect(base_url());
                echo '<script type="text/javascript">window.top.location.href="'.base_url().'users/index/redirect/'.base64_encode(current_url()).'";</script>';
                 return false;
            }
        }
    }

    public function chk_is_admin()
    {
        //if($this->session->userdata('is_logged_in') && $this->session->userdata('user_role') ==SA || $this->session->userdata('user_role') ==CIO)
        #print_r($this->session->userdata); exit;
        // swathi add ADMIN in if condition
        if($this->session->userdata(ADMIN.'is_logged_in') && constant($this->session->userdata(ADMIN.'user_role')) == SA)
        {

            if(isset($_SESSION['mode']) && $_SESSION['mode']=='mobile')
                $this->check_cookie_user();

            return true;
        }
        else
        {
            redirect(base_url());
            return false;
        }
    }

    public function check_cookie_user()
    {

        $email=$_COOKIE['email'];

        $where='(i.employee_id="'.$email.'" OR i.email_address="'.$email.'") AND i.status!="deleted" AND i.user_role!="SA"';

        $req=array(
                'select'=>'i.id,i.department_id,i.first_name,i.last_name,i.email_address,i.pass_word,i.user_role,i.status,j.status as comp_status,j.name as department_name,is_default_password_changed,permission,i.is_isolator,i.employee_id,j.short_code,i.is_hod,i.is_section_head,i.is_mobile_app,i.plant_type,i.modules_access',
                'where'=>$where,
                'table1'=>USERS.' i',
                'table2'=>DEPARTMENTS.' j',
                'join_on'=>'i.department_id=j.id ',
                'join_type'=>'inner',
                'num_rows'=>false
            );

       
           
        $user_details_qry = $this->public_model->join_fetch_data($req);     
        $user_details = $user_details_qry->row_array();
       
        $_SESSION['mode']='mobile';

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
                               'is_section_head'=>(isset($user_details['is_section_head'])) ? $user_details['is_section_head'] : '',
                               'is_mobile_app'=>(isset($user_details['is_mobile_app'])) ? $user_details['is_mobile_app'] : '',
                               'plant_type'=>(isset($user_details['plant_type'])) ? $user_details['plant_type'] : '',
                               'modules_access'=>(isset($user_details['modules_access'])) ? $user_details['modules_access'] : '',
                               'is_safety'=>(isset($user_details['is_safety'])) ? $user_details['is_safety'] : ''
                            );  

        #echo '<pre>'; print_r($login_data); exit;

        $this->session->set_userdata($login_data);

        return;

    }
    public function chk_is_user()
    {

        #echo '<pre>Cookies '; print_r($_COOKIE); 
        #echo '<pre>Sessiopn '; print_r($_SESSION); exit;
        //if($this->session->userdata('is_logged_in') && $this->session->userdata('user_role') ==SA || $this->session->userdata('user_role') ==CIO)
        $user_roles=unserialize(USER_ROLES);
        
        #print_r($this->session->userdata); exit;
        if($this->session->userdata('is_logged_in')==1 && array_key_exists($this->session->userdata('user_role'),$user_roles))
        {
            if(isset($_SESSION['mode']) && $_SESSION['mode']=='mobile')
                $this->check_cookie_user();

            return true;
        }
        else
        {
             if(isset($_COOKIE) && $_COOKIE['email']!='') {
                $this->check_cookie_user();
                return true;
            } else {
                //redirect(base_url());
                echo '<script type="text/javascript">window.top.location.href="'.base_url().'users/index/redirect/'.base64_encode(current_url()).'";</script>';
                 return false;
            }
        }
    }
}
/* End of file security_model.php */
/* Location: ./application/models/security_model.php */