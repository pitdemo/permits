<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prints extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model'));	
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

    public function electrical()
	{

		#$job_id=74;
		$job_id=$this->input->post('id');

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
