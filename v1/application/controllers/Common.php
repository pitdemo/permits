<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Common extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model'));
		//$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

/**********************************************************************************************
 * Description    : Grab all counts data from Dashboard table based on by logged company user
**********************************************************************************************/	

	public function index()
	{

		$this->load->view($this->data['controller'].'index');
	}

	public function ajax_dropdown_get_values()
	{
        
        $action_type= $this->input->get('action_type');
        $search_key = $this->input->get('q');
        $filter_value = $this->input->get('filter_value');
        $departments = $this->input->get('departments');

        $where_condition="1=1";

        switch($action_type)
        {
            case 'performing_id':
                            $skip_users = $this->input->get('skip_users');
                            $where_condition=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

                            if($skip_users!='')
                            {
                                $where_condition.=' AND id IN('.$skip_users.')';
                            }

                            if($search_key!=''){
                                $where_condition.=" AND first_name like '%".$search_key."%'";
                            }

				            //Getting Active Companys List
	                        $data=$this->public_model->get_data(array('select'=>'id,first_name as internal,user_role','where_condition'=>$where_condition,'table'=>USERS,'column'=>'first_name','dir'=>'asc'))->result_array();

                            break;
            case 'loto_closure_isolators':
                                    if($departments!='')
                                            $where_condition='isl.isolation_id IN('.$departments.')';

                                    if($search_key!=''){
                                        $where_condition.=" AND u.first_name like '%".$search_key."%'";
                                    }
                                    $data = $this->jobs_isolations_model->get_isolation_users_closure(array('where'=>$where_condition))->result_array();

                                    #echo $this->db->last_query();
                                    break;
            case 'issuing_id':
            case 'loto_closure_issuing':
                            $skip_users = $this->input->get('skip_users');

                            if(!in_array($filter_value,array(EIP_CIVIL,EIP_TECHNICAL)))
                            $dept="'".$filter_value."'";
                            else
                            $dept="'".EIP_CIVIL."','".EIP_TECHNICAL."'";	

                            $dept.=",'".EIP_PRODUCTION."','".EIP_PACKING_OPERATION."'";
                            
                            $where_condition=" department_id IN(".$dept.") AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";

                            if($skip_users!='')
                            {
                                $where_condition.=' AND id NOT IN('.$skip_users.')';
                            }

                            if($search_key!=''){
                                $where_condition.=" AND first_name like '%".$search_key."%'";
                            }

				            //Getting Active Companys List
	                        $data=$this->public_model->get_data(array('select'=>'id,first_name as internal,user_role','where_condition'=>$where_condition,'table'=>USERS,'column'=>'first_name','dir'=>'asc'))->result_array();

                            break;
            case 'clearance_department':
                            $where_condition='status = "'.STATUS_ACTIVE.'" AND department_id="'.$filter_value.'" AND user_role NOT IN ("SA") ';

                            if($search_key!=''){
                                $where_condition.=" AND first_name like '%".$search_key."%'";
                            }

                            $data = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name as internal,id','"','column'=>'first_name','dir'=>'asc','where_condition'=>$where_condition))->result_array();
                            break;
            case 'zones':  

                         $where_condition = "status ='".STATUS_ACTIVE."'";

                        if($search_key!=''){
                                $where_condition.=" AND name like '%".$search_key."%'";
                        }

                        $data = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name as internal,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc','where_condition'=>$where_condition))->result_array();
                    break;
            case 'contractors':  
                        $where_condition = "status ='".STATUS_ACTIVE."'";
                        
                        if($search_key!=''){
                                $where_condition.=" AND name like '%".$search_key."%'";
                        }

                        $data=$this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name as internal,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc','where_condition'=>$where_condition))->result_array();
                    break;
           case 'avis_jobs':
                        $where_condition = "j.status='".STATUS_OPENED."' AND j.is_loto='Yes'";

                            if($search_key!=''){
                                $where_condition.=" AND (j.job_name like '%".$search_key."%' OR j.location like '%".$search_key."%' OR j.permit_no like '%".$search_key."%') ";
                            } 

                        $data=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>"j.permit_no as internal,j.id",'start'=>0,'length'=>10,'column'=>'j.permit_no','dir'=>'asc'))->result_array();

                        #echo $this->db->last_query(); 
                        break;
        }
		

        echo json_encode($data);
		
	}

	
}
