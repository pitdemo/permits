<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Materials.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Materials extends CI_Controller
 {

	function __construct()
	{
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		parent::__construct(); 
		
		#echo '<pre>Material Session'; print_r($_SESSION);
	    
	    #echo '<br />Material Cookies'; print_r($_COOKIE); exit;
	    
        $this->load->model(array('security_model','jobs_model','public_model'));
		$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');

        $this->data['title']='Materials';
	}

    public function tester()
    {


        $this->load->view($this->data['controller'].'test',$this->data);
    }

/**********************************************************************************************
 * Description    : Grab all counts data from Dashboard table based on by logged company user
**********************************************************************************************/	

public function index() // list the item lists
{
    $c_id = array_search('search_txt',$this->uri->segment_array());

    $id=$where_condition='';

    $department_id=$this->session->userdata('department_id');
    
    $where='department_id="'.$department_id.'"';


    if($c_id !==FALSE && $this->uri->segment($c_id+1))
    {
        $id = $this->uri->segment($c_id+1);  
          
        $this->data['search_txt']=$id;
        
        if($id!='')
            $where_condition =' (file_name LIKE "%'.$id.'%" OR description LIKE "%'.$id.'%") AND ';
    }        
    
    $record_type = array_search('record_type',$this->uri->segment_array());

    if($record_type !==FALSE && $this->uri->segment($record_type+1))
    {
        $record_type = $this->uri->segment($record_type+1);  

        if($record_type!='')
            $where_condition.=' record_type="'.$record_type.'"';
    }  
    else
    {
        $where_condition.=' record_type="'.SOPS.'"';

        $record_type=SOPS;
    }	

    $where_condition=rtrim($where_condition,'AND ');

   # $this->data['departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id,plant_type','column'=>'name','dir'=>'asc','where_condition'=>$where))->result_array();

    $check_lists=$this->public_model->get_data(array('table'=>SOPS,'select'=>'sl_no,id,description,status,file_name','column'=>'modified','dir'=>'desc','where_condition'=>$where_condition));

    $this->data['checklists']=$check_lists;

    $this->data['record_type']=$record_type;
    
    $this->load->view($this->data['controller'].'lists',$this->data);
}

public function preview()
{

    $where_condition = '';

    $record_type = array_search('id',$this->uri->segment_array());

    if($record_type !==FALSE && $this->uri->segment($record_type+1))
    {
        $record_type = $this->uri->segment($record_type+1);  

        if($record_type!='')
        {
            $where_condition.=' record_type="'.$record_type.'"';

            $where_condition=rtrim($where_condition,'AND ');
        }
    }  

    if($where_condition==''){

        $this->session->set_flashdata('failure','Invalid access.');  

        redirect('users/logout');
    }

    $check_lists=$this->public_model->get_data(array('table'=>SOPS,'select'=>'sl_no,id,description,status,file_name','column'=>'modified','dir'=>'desc','where_condition'=>$where_condition));

    $this->data['checklists']=$check_lists;

    $this->load->view($this->data['controller'].'preview2',$this->data);
}



	
	
}
