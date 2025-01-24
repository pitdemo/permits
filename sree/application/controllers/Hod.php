<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hod extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model'));	
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}
	public function index() // list the item lists
	{
                $plant_types=unserialize(PLANT_TYPES);

                $c_id = array_search('plant_type',$this->uri->segment_array());
                $id='';
                $where_plant_type=' plant_type ="'.CEMENT_PLANT.'"';

                $this->data['selected_plant_type']=$plant_types[CEMENT_PLANT];
                
                if($c_id !==FALSE && $this->uri->segment($c_id+1))
                {
                        $id = $this->uri->segment($c_id+1);  
                        
                        
                        $id=array_key_exists($id, $plant_types) ? $id : CEMENT_PLANT;
                          
                        $this->data['selected_plant_type']=$plant_types[$id];
                        
                        $where_plant_type=' plant_type ="'.$id.'"';
                }  

                $this->data['msg']='';
                
                if($this->input->post('user_id')!='')
                {
                        $user_ids=implode(',',$this->input->post('user_id'));

                        $this->db->update(USERS,array('is_hod'=>NO));

                        $this->db->where('id IN('.$user_ids.')');

                        $this->db->update(USERS,array('is_hod'=>YES));

                        $this->data['msg']='HOD\'s updated successfully';

                }

		$where=$where_plant_type." AND user_role NOT IN ('SA') AND status='".STATUS_ACTIVE."'";
                //Getting Active Companys List
                $qry=$this->public_model->get_data(array('select'=>'id,first_name,user_role,department_id,is_hod','where_condition'=>$where,'table'=>USERS,'column'=>'first_name','dir'=>'asc'));

                $this->data['users']=$qry->result_array();

                $req=array(
                'select'=>'id,name',
                'table'=>DEPARTMENTS,
                'where'=>$where_plant_type.' AND status="'.STATUS_ACTIVE.'"',
                'column'=>'name','dir'=>'asc'
                );
                $qry=$this->public_model->fetch_data($req);

                
        
                $this->data['departments']=$qry->result_array();     

		$this->load->view('hod/index',$this->data);
	}
	
	
	
	
	
}
?>
