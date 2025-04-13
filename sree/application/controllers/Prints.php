<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prints extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model'));	
			
		$this->security_model->chk_is_admin();    
		    
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
	
	
}
?>
