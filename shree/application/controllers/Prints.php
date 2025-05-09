<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prints extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model','scaffoldings_model'));	
			
		//$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

	public function printout()
	{
		$id=$this->input->post('id');

		$pdf_type=$this->input->post('pdf_type');

		$this->data['pdf_type']=$pdf_type;
		#$id=75;

		$plant_type=$this->session->userdata('plant_type');

		$plant_where_condition=" AND plant_type IN('".$plant_type."','".BOTH_PLANT."')";

		$this->data['copermittees'] = $this->public_model->get_data(array('table'=>COPERMITTEES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'))->result_array(); 

		$this->data['contractors'] = $this->public_model->get_data(array('table'=>CONTRACTORS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'))->result_array(); 

		$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'));

		$this->data['permits'] = $this->public_model->get_data(array('table'=>PERMITSTYPES,'select'=>'name,id,department_id,is_excavation','where_condition'=>'status = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'))->result_array();

		$this->data['permit_type_checklists'] = $this->public_model->get_data(array('table'=>PERMITS_CHECKLISTS,'select'=>'name,id,permit_type_id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'name','dir'=>'asc'))->result_array();

		


		
		$this->data['clearance_departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND clearance = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'))->result_array();

		$this->data['isoaltion_info_departments'] = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND isolation_info = "'.STATUS_ACTIVE.'"'.$plant_where_condition,'column'=>'name','dir'=>'asc'))->result_array();

		$req=array(
			'select'=>'u.first_name,d.name as department_name,u.id,u.employee_id',
			'where'=>'u.status = "'.STATUS_ACTIVE.'" AND u.user_role NOT IN ("SA")',
			'table1'=>USERS.' u',
			'table2'=>DEPARTMENTS.' d',
			'join_on'=>'u.department_id=d.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$this->data['allusers'] = $this->public_model->join_fetch_data($req)->result_array();    
		
		$req=array(
			'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
			'table'    =>JOBS,
			'where'=>array('id'=>$id)
		);
		$qry=$this->public_model->fetch_data($req);

		if($qry)
		{
			$records=$qry->row_array();
			
			$this->data['records']=$records;
			
			$department_id = $records['department_id'];

			$department = $this->public_model->get_data(array('table'=>DEPARTMENTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id = "'.$department_id.'"','column'=>'name','dir'=>'asc'))->row_array();

			$this->data['department']['name'] = $department['name'];		
			

			$this->data['precautions']=$this->public_model->get_data(array('table'=>JOBSPRECAUTIONS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'job_id','dir'=>'asc'))->row_array();

			$this->data['jobs_extends'] = $this->public_model->get_data(array('table'=>JOB_EXTENDS,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();

			$this->data['job_isolations'] = $this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'*','where_condition'=>'job_id = "'.$id.'"','column'=>'id','dir'=>'asc'))->row_array();
			
		} 

		
		$this->load->view($this->data['controller'].'printout',$this->data);
	}


    public function electrical()
	{

		#$job_id=74;
		$job_id=$this->input->post('id');

		$pdf_type=$this->input->post('pdf_type');

		$this->data['pdf_type']=$pdf_type;

		$where='i.job_id="'.$job_id.'"';

		$req=array(
			'select'=>'i.*,j.permit_no,j.acceptance_performing_id',
			'where'=>$where,
			'table1'=>JOBS.' j',
			'table2'=>JOBSISOLATION.' i',
			'join_on'=>'i.job_id=j.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$job_info = $this->public_model->join_fetch_data($req)->row_array();    

		$this->data['records']=$job_info;

		$where='user_role!="SA"';

		$req=array(
			'select'=>'u.first_name,d.name as department_name,u.id',
			'where'=>$where,
			'table1'=>USERS.' u',
			'table2'=>DEPARTMENTS.' d',
			'join_on'=>'u.department_id=d.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$users_info = $this->public_model->join_fetch_data($req)->result_array();    

		$this->data['users_info']=$users_info;

		#echo '<pre>'; print_r($users_info); exit;
		
        $this->load->view($this->data['controller'].'electrical',$this->data);
	}
	
	public function scaffoldings()
	{ 
		$readonly='';

		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		if($user_id=='')
		{
			$user_id=$this->session->userdata(ADMIN.'user_id');

			$user_name=$this->session->userdata(ADMIN.'first_name');
		}
		
		$authorities=$job_isolations_where=$job_status_error_msg='';

		
        $id = $this->input->post('id');

		if($id!='')
        {

			$where_condition='s.id="'.$id.'"';

			$fields='j.location,j.permit_no,aci.first_name,aii.first_name as issuer_name,s.*';

			$records=$this->scaffoldings_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'s.id','dir'=>'asc'))->row_array();

			if(isset($records))
			{
				
				$where='u.user_role!="SA" AND u.id IN('.$records['acceptance_performing_id'].','.$records['acceptance_issuing_id'].')';

				$req=array(
					'select'=>'u.first_name,d.name as department_name,u.id',
					'where'=>$where,
					'table1'=>USERS.' u',
					'table2'=>DEPARTMENTS.' d',
					'join_on'=>'u.department_id=d.id ',
					'join_type'=>'inner',
					'num_rows'=>false
				);
				$all_users = $this->public_model->join_fetch_data($req)->result_array(); 

				$checklists=$this->public_model->get_data(array('table'=>SCAFFOLDINGS_CHECKLISTS,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'"','column'=>'id','dir'=>'asc'))->result_array();
			}

			//$this->data['notes'] = $this->public_model->get_data(array('table'=>SCAFFOLDINGS_NOTES,'select'=>'*','where_condition'=>'scaffolding_id = "'.$id.'"','column'=>'id','dir'=>'desc','limit'=>5))->result_array();
        }

		$this->data['checklists']=$checklists;
		
		$this->data['allusers']=$all_users; 

		$this->data['records']=$records;
		
		$this->load->view($this->data['controller'].'scaffoldings',$this->data);
	}
	
	public function avi()
	{ 
		error_reporting(0);

		$readonly='';

		$pdf_type=$this->input->post('pdf_type');

		$this->data['pdf_type']=$pdf_type;

		$department_id=$this->session->userdata('department_id');
		
		$user_name=$this->session->userdata('first_name');
		
		$user_id=$this->session->userdata('user_id');

		if($user_id=='')
		{
			$user_id=$this->session->userdata(ADMIN.'user_id');

			$user_name=$this->session->userdata(ADMIN.'first_name');
		}
		
		$authorities=$job_isolations_where=$job_status_error_msg='';

		$this->data['allusers'] = $this->public_model->get_data(array('table'=>USERS,'select'=>'first_name,id,user_role','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND user_role NOT IN ("SA")','column'=>'first_name','dir'=>'asc'))->result_array();
		
        $id = $this->input->post('id');

        if($id!='')
        {
            $req=array(
              'select'  =>'*',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>AVIS,
              'where'=>array('id'=>$id)
            );
            $qry=$this->public_model->fetch_data($req);
			
			#echo $this->db->last_query(); exit;
            if($qry)
			{
                $records=$qry->row_array();

				$this->data['avi_info']=$records;	

				$zone_id=$records['zone_id'];

				$this->data['zones'] = $this->public_model->get_data(array('table'=>ZONES,'select'=>'name,id','where_condition'=>'status = "'.STATUS_ACTIVE.'" AND id="'.$zone_id.'"'));

				$jobs_loto_ids=json_decode($records['jobs_loto_ids'],true);

				$jobs_loto_ids=implode(',',$jobs_loto_ids);

				$job_pre_isolations=$this->public_model->join_fetch_data(array('select'=>'ec.id,ec.equipment_name,ec.equipment_number,li.isolated_tagno3,li.id as jobs_loto_id','table1'=>LOTOISOLATIONS.' li','table2'=>EIP_CHECKLISTS.' ec','join_type'=>'inner','join_on'=>'li.eip_checklists_id=ec.id','where'=>'li.id IN('.$jobs_loto_ids.')','num_rows'=>false))->result_array();

				$this->data['job_isolations']=$job_pre_isolations;
            }   
        }
		
	 
		
		$this->load->view($this->data['controller'].'avi',$this->data);
	}
	

	
}
?>
