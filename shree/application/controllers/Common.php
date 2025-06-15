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

        /*$current_time = '10:00 am';//date('H:i A');
		$sunrise = "9:00 am";
		$sunset = "6:00 pm";
		$date1 = DateTime::createFromFormat('h:i a', $current_time);
		$date2 = DateTime::createFromFormat('h:i a', $sunrise);
		$date3 = DateTime::createFromFormat('h:i a', $sunset);
		if ($date1 > $date2 && $date1 < $date3)
		{
		echo 'here';
		} else { 
			echo 'Failed';
		}

		echo date('H:i A'); exit;
        */
	}

	public function ajax_dropdown_get_values()
	{
        
        $action_type= $this->input->get('action_type');
        $search_key = $this->input->get('q');
        $filter_value = $this->input->get('filter_value');
        $departments = $this->input->get('departments');
        $filter_departments=$this->input->get('filter_departments');
        $is_loto=$this->input->get('is_loto');

        if($is_loto=='') {
            $is_loto=NO;
        }

        $where_condition="1=1";

        $plant_type=$this->session->userdata('plant_type');

        switch($action_type)
        {
            case 'custodian_id':
                            $skip_users = $this->input->get('skip_users');
                            $department_id=$this->input->get('filter_value');
                            $filter_role=$this->input->get('filter_role');     


                            $where_condition=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."' AND plant_type='".$plant_type."'";

                            //Plant type is Cement & isolation is YES
                            if($plant_type==CEMENT_PLANT && $is_loto==YES){

                                $current_time = date('h:i A');
                                $sunrise = "9:00 am";
                                $sunset = "6:00 pm";
                                $date1 = DateTime::createFromFormat('h:i a', $current_time);
                                $date2 = DateTime::createFromFormat('h:i a', $sunrise);
                                $date3 = DateTime::createFromFormat('h:i a', $sunset);

                                //Day or Night 
                                if ($date1 > $date2 && $date1 < $date3)
                                $shift_type=DAY; 
                                else 
                                $shift_type=NIGHT;

                                $where_condition.=' AND shift_type="'.$shift_type.'"  AND department_id=19 '; //Process
                            } else 
                                $where_condition.="AND department_id='".$department_id."'";

                            /*if($filter_role==YES)  Recently hide this cond on 13th June 25
                                $where_condition.=" AND is_hod='".YES."'";
                             else 
                                $where_condition.=" AND is_section_head='".YES."'";
                            */
                            $where_condition.=" AND (is_hod='".YES."' OR is_section_head='".YES."')";


                            if($skip_users!='')
                            {
                                //$where_condition.=' AND id IN('.$skip_users.')';
                            }

                            if($search_key!=''){
                                $where_condition.=" AND first_name like '%".$search_key."%'";
                            }

                            //Getting Active Companys List
                            $data=$this->public_model->get_data(array('select'=>'id,first_name as internal,user_role','where_condition'=>$where_condition,'table'=>USERS,'column'=>'first_name','dir'=>'asc'))->result_array();

                            #echo $this->db->last_query(); exit;
                           
                            break;
            case 'performing_id':
                            $skip_users = $this->input->get('skip_users');
                            $where_condition=" user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."' AND plant_type='".$plant_type."'";

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

                                if($skip_users!='')
                                {
                                    $where_condition.=' AND i.id NOT IN('.$skip_users.')';
                                }

                                if($search_key!=''){
                                    $where_condition.=" AND i.first_name like '%".$search_key."%'";
                                }

                                $where_condition.=" AND i.plant_type='".$plant_type."'";
        
                                $req=array(
                                    'select'=>'i.id,i.first_name as text,j.name as group_name',
                                    'where'=>$where_condition,
                                    'table1'=>USERS.' i',
                                    'table2'=>ISSUERS.' j',
                                    'join_on'=>'i.issuer_id=j.id ',
                                    'join_type'=>'inner',
                                    'num_rows'=>false,
                                    'order_by'=>'i.first_name',
                                    'order'=>'asc'
                                );
                                $user_details = $this->public_model->join_fetch_data($req)->result_array();    
                                
                               // echo $this->db->last_query(); exit;
                        
                                $group_by_column=array_column($user_details,'group_name');
                        
                                $group_by_column=array_unique($group_by_column);

                                $final_results=array();
        
                                foreach($group_by_column as $key => $group_text):
        
                                    $results=array();
                        
                                    $results['text']=$group_text;
                        
                                    $users = array_filter($user_details, function($val) use($group_text) {
                                        return ($val['group_name']==$group_text);
                                        });
                        
                                    $results['children']=array_values($users);
                        
                                    array_push($final_results,$results);
                        
                                endforeach;
                                
                                $data=$final_results;

                                break;
            case 'clearance_department':
                            $skip_users = $this->input->get('skip_users');
                            $where_condition='status = "'.STATUS_ACTIVE.'" AND department_id="'.$filter_value.'" AND user_role NOT IN ("SA") ';

                            $where_condition.=" AND plant_type='".$plant_type."'";

                            if($skip_users!='') {
                                    $where_condition.='AND id NOT IN('.$skip_users.')';
                            }

                            if($search_key!=''){
                                $where_condition.=" AND first_name like '%".$search_key."%'";
                            }

                            $data = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name as internal,id','"','column'=>'first_name','dir'=>'asc','where_condition'=>$where_condition))->result_array();
                            
                            break;
            case 'zones':  

                         $where_condition = "status ='".STATUS_ACTIVE."'";
                         $where_condition.=" AND plant_type IN('".$plant_type."','".BOTH_PLANT."')";

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

                        $where_condition.=" AND plant_type IN('".$plant_type."','".BOTH_PLANT."')";

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
            case 'permits':

                        $where_condition = "j.final_status_date!=''";

                        if($search_key!=''){
                            $where_condition.=" AND (j.job_name like '%".$search_key."%' OR j.location like '%".$search_key."%' OR j.permit_no like '%".$search_key."%') ";
                        } 

                        $data=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>"j.permit_no as internal,j.id,j.location",'start'=>0,'length'=>10,'column'=>'j.permit_no','dir'=>'asc'))->result_array();
                        
                        break;
            case 'civil':                                   
                            $skip_users = $this->input->get('skip_users');

                            if($skip_users!='')
                            {
                                $where_condition.=' AND i.id NOT IN('.$skip_users.')';
                            }

                            if($search_key!=''){
                                $where_condition.=" AND i.first_name like '%".$search_key."%'";
                            }

                            $where_condition.=" AND i.plant_type='".$plant_type."' AND d.is_safety='scaff'";
    
                            $req=array(
                                'select'=>'i.id,i.first_name as internal',
                                'where'=>$where_condition,
                                'table1'=>USERS.' i',
                                'table2'=>DEPARTMENTS.' d',
                                'join_on'=>'i.department_id=d.id ',
                                'join_type'=>'inner',
                                'num_rows'=>false,
                                'order_by'=>'i.first_name',
                                'order'=>'asc'
                            );

                            $data = $this->public_model->join_fetch_data($req)->result_array();    

                            break;

        }
		

        echo json_encode($data);
		
	}

	
}
