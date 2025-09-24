<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Isolocks extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model','jobs_model'));	

		$this->load->helper(array('custom'));
			
		$this->security_model->chk_login();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');

		$this->data['method']=$this->router->fetch_method();

	} 

	public function index()
	{
		redirect('tag_wise');
	}

    public function tag_wise()
	{
		$segment_array=$this->uri->segment_array();

		$eq = array_search('eq',$segment_array);
		
        if($eq !==FALSE && $this->uri->segment($eq+1))
        {
            $selected_eq = explode(',',$this->uri->segment($eq+1));
		}
		else
			$selected_eq=array();

		$status = array_search('status',$segment_array);
		
        if($status !==FALSE && $this->uri->segment($status+1))
        {
            $selected_status = $this->uri->segment($status+1);
		}
		
		if($selected_status=='')
			$selected_status=STATUS_ACTIVE;

        $req=array('select'=>'id,equipment_number,equipment_name','table'=>EIP_CHECKLISTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'equipment_number','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();      

        $this->data['selected_eq']=$selected_eq;

		$this->data['status']=$selected_status;
		
		$this->load->view('isolocks/tag_wise',$this->data);
	}

    public function ajax_search_tag_wise()
	{
		#echo '<pre>'; print_r($this->input->get()); exit;

		#$redirect_url=$this->get_segment_array(array('controller'=>$this->data['controller'],'method'=>$this->data['method'])); exit;

		$where_condition='1=1';

		$redirect_url='';
		
		$segment_array=$this->uri->segment_array();

		$eq = array_search('eq',$segment_array);

 		if($eq !==FALSE && $this->uri->segment($eq+1))
        {
            $eq = $this->uri->segment($eq+1);

            if($eq!='null')
            {
            	$where_condition.=' AND ec.id IN('.$eq.')';

            	$redirect_url.='/eq/'.$eq;
            }		
		}	

		$status = array_search('status',$segment_array);

 		if($status !==FALSE && $this->uri->segment($status+1))
        {
            $status = $this->uri->segment($status+1);

            if($status!='')
            {
            	$where_condition.=' AND li.status IN("'.$status.'")';

            	$redirect_url.='/status/'.$status;
            }		
		}	
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];		
        
		$totalFiltered=$this->public_model->join_fetch_data_three_tables(array('select'=>'ec.id as equipment_id','table1'=>LOTOISOLATIONS.' li','table2'=>LOTOISOLATIONSLOG.' lil','table3'=>EIP_CHECKLISTS.' ec','join_type'=>'inner','join_on_tbl2'=>'li.id=lil.jobs_lotos_id','join_on_tbl3'=>'li.eip_checklists_id=ec.id','where'=>$where_condition,'num_rows'=>true,'group_by'=>'li.id'));

		$records=$this->public_model->join_fetch_data_three_tables(array('select'=>'ec.id as equipment_id,ec.equipment_name,ec.equipment_number,count(lil.id) as no_of_permits,SUM(if(lil.status ="'.STATUS_ACTIVE.'", 1, 0)) AS active_counts,li.isolated_tagno3,li.status,li.created,li.id as loto_id','table1'=>LOTOISOLATIONS.' li','table2'=>LOTOISOLATIONSLOG.' lil','table3'=>EIP_CHECKLISTS.' ec','join_type'=>'inner','join_on_tbl2'=>'li.id=lil.jobs_lotos_id','join_on_tbl3'=>'li.eip_checklists_id=ec.id','where'=>$where_condition,'num_rows'=>false,'group_by'=>'li.id','order_by'=>$sort_by,'order'=>$order_by,'length'=>$limit,'start'=>$start))->result_array();

        #echo $this->db->last_query(); exit;

		$json=array();
		
		$j=$t=0;	

        if(count($records)>0)
        {
            foreach($records as $record)
            {
                $json[$j]['equipment_name']=$record['equipment_name'];
				$json[$j]['equipment_number']=$record['equipment_number'];
				$active_counts=$record['active_counts'];

				$cl='green';

				if(ucfirst($record['status'])==STATUS_CLOSED)
					$cl='red';
				$disabled='disabled';
				$class='';

				if($active_counts==0 && $record['status']==STATUS_ACTIVE){
					$disabled='';
					$cl='orange';
					$class='bulk_box checkbox';
				}

				$chk_box = "<center><input type='checkbox' name='permit_no[]' class='".$class."' ".$disabled." value='".$record['loto_id']."'><center>";
				$json[$j]['chk_box']=$chk_box;

				$json[$j]['no_of_permits']='<a href="javascript:void(0);"  data-bs-toggle="modal" data-bs-target="#modal-scrollable" data-loto-id="'.$record['loto_id'].'" data-eq="'.$record['equipment_number'].'" data-job-id="1" data-id="1" class="re_energized_log" >
                    '.$record['no_of_permits'].'
                  </a>';
				$json[$j]['isolated_tagno3']=$record['isolated_tagno3'];
				$json[$j]['status']='<span style="color:'.$cl.';">'.ucfirst($record['status']).'</span>';
				$json[$j]['created']=date('d-m-Y H:i A',strtotime($record['created']));
                $j++;

            }
        }

		$total_records=$totalFiltered;

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function ajax_update_users()
	{
        $response='';
		#echo '<pre>'; print_r($_POST); exit;
        $status = $this->input->post('status');
        
		$this->db->where('id IN ('.implode(',',$this->input->post('id')).')');
        $this->db->set('status',$status);
        $this->db->update(LOTOISOLATIONS);		
		#echo $this->db->last_query(); 
        echo 'bulk'; exit;
    }
	
	function get_segment_array($array_args)
	{
	   extract($array_args);

	   $current_url=uri_string(); 

	   $base_url = $controller;

	   $return=str_replace($base_url,'',$current_url);

	   $base_url = $method;   

	   $return=str_replace($base_url,'',$return);

	   return $return;
	}

	
	
}
?>
