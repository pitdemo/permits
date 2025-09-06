<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Isolocks extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array('public_model','security_model','zones_model','jobs_model'));	

		$this->load->helper(array('custom'));
			
		$this->security_model->chk_is_admin();    
		    
		$this->data=array('controller'=>$this->router->fetch_class().'/');

		$this->data['method']=$this->router->fetch_method();

	} 

    public function index()
	{
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        if($subscription_date_start !==FALSE && $this->uri->segment($subscription_date_start+1))
        {
            $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		}
		else
		$subscription_date_start = date('Y-m-d',strtotime("-30 days"));
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
        if($subscription_date_end !==FALSE && $this->uri->segment($subscription_date_end+1))
        {
            $subscription_date_end = $this->uri->segment($subscription_date_end+1);
		}
		else
		$subscription_date_end = date('Y-m-d');

		$zones = array_search('zones',$segment_array);
		
        if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $selected_zones = explode(',',$this->uri->segment($zones+1));
		}
		else
			$selected_zones=array();
        
        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();         

        $req=array('select'=>'id,name','table'=>ZONES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Companys List
        $qry=$this->public_model->get_data($req);
		
        $this->data['zones']=$qry->result_array();            

		$req=array('select'=>'id,name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name','dir'=>'asc');
        //Getting Active Departments List
        $this->data['departments']=$this->public_model->get_data($req)->result_array();

		
		

        $this->data['selected_zones']=$selected_zones;
		
		$this->data['subscription_date_start']=date('d/m/Y',strtotime($subscription_date_start));
		
		$this->data['subscription_date_end']=date('d/m/Y',strtotime($subscription_date_end));
		
		$this->load->view('isolocks/index',$this->data);
	}

    public function ajax_search_department_wise()
	{
		#echo '<pre>'; print_r($this->input->get()); exit;

		#$redirect_url=$this->get_segment_array(array('controller'=>$this->data['controller'],'method'=>$this->data['method'])); exit;

		$redirect_url='';
		
		$segment_array=$this->uri->segment_array();
		
        $subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);
		
		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));
		
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		$where_condition='DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'"';

		$zones = array_search('zones',$segment_array);

 		if($zones !==FALSE && $this->uri->segment($zones+1))
        {
            $zones = $this->uri->segment($zones+1);

            if($zones!='null')
            {
            	$where_condition.=' AND j.zone_id IN('.$zones.')';

            	$redirect_url.='/zone_id/'.$zones;
            }		
		}		

		$contractor_id = array_search('contractor_id',$segment_array);
		
 		if($contractor_id !==FALSE && $this->uri->segment($contractor_id+1))
        {
            $contractor_id = $this->uri->segment($contractor_id+1);

            if($contractor_id!='null')
            {
            	$where_condition.=' AND j.contractor_id IN('.$contractor_id.')';

            	$redirect_url.='/contractor_id/'.$contractor_id;
            }		
		}		

		
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];		

		$req=array('select'=>'id,name as department_name','table'=>DEPARTMENTS,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'department_name','dir'=>$order_by);
        //Getting Active Departments List
        $qry=$this->public_model->get_data($req);

        $fet_departments=$qry->result_array();

        $req=array('select'=>'id,name','table'=>PERMITSTYPES,'where_condition'=>array('status'=>STATUS_ACTIVE),'column'=>'name,id','dir'=>'asc');
        $qry=$this->public_model->get_data($req);
        $permit_types=$qry->result_array();


        $fields='d.name as department_name,j.department_id,count(pti.permits_id) as permit_count,pti.permits_id';
		
		$records=$this->jobs_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by,'permit_types_count'=>true,'group_by'=>'j.department_id,pti.permits_id'))->result_array();

        #echo $this->db->last_query(); exit;

		$json=array();
		
		$j=$t=0;	

        if(count($records)>0)
        {
            foreach($fet_departments as $departments)
            {
                $department_name = $departments['department_name'];

                $json[$j]['department_name']=$department_name;

                $department_id = $departments['id'];

                $total=0;

                foreach($permit_types as $permit_type)
                {
                    $permit_type_id=$permit_type['id'];

                    $filtered = array_values(array_filter($records, function ($filt) use($department_id,$permit_type_id) { return $filt['department_id'] == $department_id &&  $filt['permits_id']==$permit_type_id; }));

                    $total_count=count($filtered) > 0 ? $filtered[0]['permit_count'] : 0;
                    
                    $json[$j][$permit_type_id]=$total_count > 0 ? $total_count : '<span style="color:red;">'.$total_count.'</span>' ;
                    
                    $total=$total+$total_count;

                }

                $json[$j]['total_permits']=$total;
                
                $j++;

            }
        }

		$json=json_encode($json);
										
		echo $json;
		
		exit;
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
