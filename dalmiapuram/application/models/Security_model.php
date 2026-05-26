<?php
//Session validation with Admin for PIM
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Security_model extends CI_Model
{   

    public function get_current_date_time()
    {

        $qry=$this->db->query('SELECT NOW() as sys_date')->row_array();

        return date('d-m-Y H:i',strtotime($qry['sys_date']));

    }

    public function chk_login()
    {
        if($this->session->userdata('is_logged_in'))
        {
            return true;
        }
        else
        {
            //redirect(base_url('login'));
            echo '<script type="text/javascript">window.top.location.href="'.base_url().'users/index/redirect/'.base64_encode(current_url()).'";</script>';
            return false;
        }

    }

    public function chk_is_admin()
    {
        //if($this->session->userdata('is_logged_in') && $this->session->userdata('user_role') ==SA || $this->session->userdata('user_role') ==CIO)
        #print_r($this->session->userdata); exit;
        // swathi add ADMIN in if condition
        if($this->session->userdata(ADMIN.'is_logged_in') && constant($this->session->userdata(ADMIN.'user_role')) == SA)
        {
            return true;
        }
        else
        {
            redirect(base_url());
            return false;
        }
    }

    public function chk_is_user()
    {
        //if($this->session->userdata('is_logged_in') && $this->session->userdata('user_role') ==SA || $this->session->userdata('user_role') ==CIO)
        $user_roles=unserialize(USER_ROLES);
        
        #print_r($this->session->userdata); exit;
        if($this->session->userdata('is_logged_in')==1 && array_key_exists($this->session->userdata('user_role'),$user_roles))
        {
            return true;
        }
        else
        {
            //redirect(base_url());
            echo '<script type="text/javascript">window.top.location.href="'.base_url().'users/index/redirect/'.base64_encode(current_url()).'";</script>';
            return false;
        }
    }
}
/* End of file security_model.php */
/* Location: ./application/models/security_model.php */