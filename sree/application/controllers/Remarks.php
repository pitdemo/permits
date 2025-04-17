<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Dashboard.php
 * Project        : Formwork
 * Creation Date  : 12-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Dashbaord Datas 
*********************************************************************************************/	

class Remarks extends CI_Controller
 {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('security_model','jobs_model','public_model','jobs_isolations_model','remarks_model'));
		//$this->security_model->chk_is_user();        
		$this->data=array('controller'=>$this->router->fetch_class().'/');
	}

    /**********************************************************************************************
     * Description    : Grab all counts data from Dashboard table based on by logged company user
    **********************************************************************************************/	


	public function index()
	{
		$segment_array=$this->uri->segment_array();
		
		$this->data['params_url']=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	
		
		$filters=$this->generate_where_condition();

		$this->data['filters']=$filters['filters'];

		$this->load->view($this->data['controller'].'index',$this->data);
	}

	public function generate_where_condition()
	{
		
		$user_id=$this->session->userdata('user_id');
		
		$where_condition='';

		$filters=array();

		$segment_array=$this->uri->segment_array();

        $department_ids = array_search('department_ids',$this->uri->segment_array());

        if($department_ids !==FALSE && $this->uri->segment($department_ids+1))
        {
            $department_ids = $this->uri->segment($department_ids+1);
			
			if($department_ids!='') {
				$where_condition.=" j.department_id IN(".$department_ids.") AND ";

				$filters['department_ids']=$department_ids;
			}
		}	

		$zone_ids = array_search('zone_ids',$this->uri->segment_array());

        if($zone_ids !==FALSE && $this->uri->segment($zone_ids+1))
        {
            $zone_ids = $this->uri->segment($zone_ids+1);
			
			if($zone_ids!='') {
				$where_condition.=" j.zone_id IN(".$zone_ids.") AND ";

				$filters['zone_ids']=$zone_ids;
			}
		}

		$permit_types = array_search('permit_types',$this->uri->segment_array());

        if($permit_types !==FALSE && $this->uri->segment($permit_types+1))
        {
            $permit_types = $this->uri->segment($permit_types+1);
			
			if($permit_types!='') {

				$permit_type_where_condition=' (';
				//Extends
				for($i=0;$i<=11;$i++)
				{
					$permit_type_where_condition.=' j.permit_type LIKE \'%"'.$i.'":"'.$permit_types.'"%\' OR ';
				}

				$permit_type_where_condition = rtrim($permit_type_where_condition,' OR ');
				$permit_type_where_condition=$permit_type_where_condition.') ';


				$where_condition.=$permit_type_where_condition.' AND ';

				$filters['permit_types']=$permit_types;
			}
		}

		$status = array_search('status',$this->uri->segment_array());

        if($status !==FALSE && $this->uri->segment($status+1))
        {
            $status = $this->uri->segment($status+1);
			
			if($status!='') {
				$where_condition.=" j.approval_status IN(".$status.") AND ";
				$filters['status']=$status;
			}
		}

		$search_txt = array_search('search_txt',$this->uri->segment_array());

        if($search_txt !==FALSE && $this->uri->segment($search_txt+1))
        {
            $search_txt = trim($this->uri->segment($search_txt+1));
			
			if($search_txt!=''){
				$where_condition.=" (j.permit_no LIKE '%".$search_txt."%' OR j.job_name LIKE '%".$search_txt."%') AND ";
				$filters['search_txt']=$search_txt;
			}
		}	

		$subscription_date_start = array_search('subscription_date_start',$segment_array);

        $subscription_date_start = $this->uri->segment($subscription_date_start+1);
		
		$subscription_date_end = array_search('subscription_date_end',$segment_array);
		
		$subscription_date_end = $this->uri->segment($subscription_date_end+1);

		$subscription_date_start=date('Y-m-d',strtotime($subscription_date_start));

		if($subscription_date_start=='' || $subscription_date_start=='1970-01-01'){
			$subscription_date_start=date('Y-m-d',strtotime("-30 days"));
		}
		$subscription_date_end = date('Y-m-d',strtotime($subscription_date_end));

		if($subscription_date_end=='' || $subscription_date_end=='1970-01-01'){
			$subscription_date_end=date('Y-m-d');
		}

		$filters['subscription_date_start']=$subscription_date_start;
		$filters['subscription_date_end']=$subscription_date_end;
		
		
		$where_condition.=' DATE(j.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$where_condition=rtrim($where_condition,' AND ');

		return array('where_condition'=>$where_condition,'filters'=>$filters);
	}

	public function form()
	{
		$segment_array=$this->uri->segment_array();

		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

		if($param_url=='')
			$param_url=$segment_array[1];
		
		$this->data['param_url']=$param_url;

		$this->load->view($this->data['controller'].'form',$this->data);
	}

	public function form_action()
	{

		//echo '<pre>'; print_r($_FILES); 
        //print_r($this->input->post());   
       // exit; 

		$user_id=$this->session->userdata('user_id');
		
		$skip_fields=array('id','submit_type','image_data','step1','screenshots_hidden');

		$print_out='';
		
		$arr=array();
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';
		

		$_POST['last_modified_id']=rand(time(),5);

		$id=($this->input->post('id')) ? $this->input->post('id') : '';		

		$job_id=$this->input->post('job_id');

		$user_name=$this->session->userdata('first_name');

		$_POST['last_updated_by']=$user_name;

		$_POST['modified']=date('Y-m-d H:i');

		$inputs=$this->input->post();

		#echo '<br /> MSg '.$msg;

		#echo '<pre>'; print_r($_POST); exit;
		//Jobs Inputs
		foreach($inputs as $field_name => $field_value)
		{
			if(!in_array($field_name,$skip_fields))
			{
				$fields.=$field_name.',';				
				
				$field_value="'".rtrim(@addslashes($field_value),',')."'";

				$fields_values.=$field_value.',';
				
				$update.=$field_name.'='.$field_value.',';
			}
		}


		$permit_info=$this->public_model->get_data(array('table'=>JOBS,'select'=>'permit_no,id,approval_status','where_condition'=>'id = "'.$job_id.'"','column'=>'id','dir'=>'asc'))->row_array();

		$permit_no=$permit_info['permit_no'];

		$approval_status=$permit_info['approval_status'];

		if(!$id)
		{	
			$fields.=',user_id,approval_status,created';

			$fields_values.=',"'.$user_id.'","'.$approval_status.'","'.date('Y-m-d H:i').'"';		

			$ins="INSERT INTO ".$this->db->dbprefix.SAFETY_REMARKS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);

			$id=$this->db->insert_id();			

			$this->session->set_flashdata('success','Remarks has been created successfully and sent notification to Job custodian and Issuer.');    
			
		}
		else
		{
			$up="UPDATE ".$this->db->dbprefix.SAFETY_REMARKS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);

			$this->session->set_flashdata('success','Remarks has been updated successfully');  
		}

        $files=$_FILES;

		$uploaddir = './uploads/permits/'.$job_id.'/';

		if(!file_exists($uploaddir))
		{
			mkdir($uploaddir,0777,true);
		}
		
        $flag=0;

        $update='';

        foreach($files as $name => $file)
		{
           // print_r($file);

			if($file['error']==0)
			{				
				$generate_file_name = $file['name'];

				$ext_path=explode('.',$generate_file_name);
				
				$tmp_path = $file['tmp_name'];

				$newfilename = str_replace(' ','_',$generate_file_name);
				
				$uploadfile = $uploaddir.$newfilename;

				move_uploaded_file($tmp_path, $uploadfile);
                
                $update.="images = '".$newfilename."',";

                $flag=1;
			}
		}

        if($flag==1){

            $update=rtrim($update,',');

            $up="UPDATE ".$this->db->dbprefix.SAFETY_REMARKS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);
        }	

		
		$ret=array('status'=>true);

		echo json_encode($ret);
		
		exit;
	}

	
	public function ajax_fetch_show_all_data()
	{
		 
		$job_approval_status=unserialize(JOBAPPROVALS);
		 
		$job_approval_status_color=unserialize(JOBAPPROVALS_COLOR);
		 
		$segment_array=$this->uri->segment_array();
		
		$param_url=$this->public_model->get_params_url(array('start'=>3,'segment_array'=>$segment_array));	

		$requestData= $_REQUEST;

		$search=$where_condition='';
		
		$department_id=$this->session->userdata('department_id');
		
		$zone_id=$this->session->userdata('zone_id');
		
		$user_role=$this->session->userdata('user_role');
		
		$user_id=$this->session->userdata('user_id');		
		
		$where_condition='';
		
		#echo $where_condition; exit;
		
		  //Getting in URL params
		  $search_value=(isset($_REQUEST['search'])) ? trim($_REQUEST['search']) : '';
		  
		  if($search_value!='')
		  {
			  $where_condition.=" (j.location like '%".$search_value."%' OR j.job_name like '%".$search_value."%' OR j.permit_no LIKE '%".$search_value."%') AND ";
		  }
		  
		 # $where_condition .= "j.approval_status NOT IN (4,6,10)";

		 // echo $where_condition; exit;

		 $fields='j.job_name,j.location,j.permit_no,sr.approval_status,sr.created,sr.modified,sr.title,sr.images,u.first_name,sr.id,sr.job_id';
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$limit=$_REQUEST['limit'];
		
		$start=$_REQUEST['offset'];
		
		$sort_by =$_REQUEST['sort'];
		
		$order_by = $_REQUEST['order'];
		
		$totalFiltered=$this->remarks_model->fetch_data(array('where'=>$where_condition,'num_rows'=>true,'fields'=>$fields,'join'=>true));
		
		$records=$this->remarks_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>$start,'length'=>$limit,'column'=>$sort_by,'dir'=>$order_by))->result_array();
		
		//echo '<br /> Query : '.$this->db->last_query();  
		$json=array();
		
		$job_status=unserialize(JOB_STATUS);

		$j=0;
		
		if($totalFiltered>0)
		{	
			foreach($records as $record)
			{
				
				$id=$record['id'];
				
				$permit_no=$record['permit_no'];

				$job_id=$record['job_id'];
				
				$redirect=base_url().'jobs/form/id/'.$job_id;				
				$job_name=($record['job_name']) ? $record['job_name'] : ' - - -';				
				


				$title=$record['title'];
				$redirect=base_url().'remarks/form/id/'.$id;
				$title='<a href="'.$redirect.'">'.$title.'</a>';
			
				$created=$record['created'];
				
				
				$approval_status=$record['approval_status'];
				
				if(array_key_exists($job_approval_status[$approval_status],$job_approval_status_color))
				$color=$job_approval_status_color[$job_approval_status[$approval_status]];
				else
				$color='';

				$permit_no=$record['permit_no'];
				
				$images=base_url().'uploads/'.$permit_no.'/'.$record['images'];

				$images='<a href="javascript:void(0);" class="open_model" data-url="'.$images.'" data-bs-toggle="modal" data-bs-target="#modal-download">
						<img src="'.$images.'" width="40" height="40" />
                        </a>';

				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";	
				
				$modified=$record['modified'];

				$cl='';
				$permit_no='<a href="'.$redirect.'">'.$permit_no.'</a>';
				$json[$j]['permit_no']=$permit_no;
				$json[$j]['title']=$title;
				$json[$j]['created_by']=$record['first_name'];
				$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$title.'</a>';
				$json[$j]['approval_status']=$approval_status;#.' - '.$search;
				$json[$j]['created']=date(DATE_FORMAT.' H:i A',strtotime($created));
				$json[$j]['images']=$images;
				#$json[$j]['status']=ucfirst($status);
				
				$j++;
			}
		}

		$total_records=$totalFiltered;
		

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

}
