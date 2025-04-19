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
				$where_condition.=" (j.permit_no LIKE '%".$search_txt."%' OR j.job_name LIKE '%".$search_txt."%'  OR sr.title LIKE '%".$search_txt."%') AND ";
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
		
		
		$where_condition.=' DATE(sr.created) BETWEEN "'.$subscription_date_start.'" AND "'.$subscription_date_end.'" AND ';

		$where_condition=rtrim($where_condition,' AND ');

		return array('where_condition'=>$where_condition,'filters'=>$filters);
	}

	public function form()
	{

		if($this->session->userdata('is_safety')!='yes') {

			$this->session->set_flashdata('failure','You don\'t have rights to access the page.');  
			redirect('remarks/index/?mode='.$this->session->userdata('mode'));
		}
		$segment_array=$this->uri->segment_array();

		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

		if($param_url=='')
			$param_url=$segment_array[1];
		
		$this->data['param_url']=$param_url;

		$update = array_search('id',$this->uri->segment_array());

		$records=array();

		if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);

			$where_condition='sr.id="'.$id.'"';

			$fields='j.permit_no,sr.approval_status,sr.created,sr.modified,sr.title,sr.images,u.first_name,sr.id,sr.job_id,sr.user_id,aci.first_name as custodian_name,aii.first_name as issuer_name,sr.comments,sr.remarks_id';

			$records=$this->remarks_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'sr.id','dir'=>'asc'))->row_array();
        }

		$this->data['records']=$records;

		$this->load->view($this->data['controller'].'form',$this->data);
	}

	public function form_action()
	{

		#echo '<pre>'; print_r($_FILES); 
        #print_r($this->input->post());   
       # exit; 

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

		$permit_info=$this->public_model->get_data(array('table'=>JOBS,'select'=>'permit_no,id,approval_status,acceptance_custodian_id,acceptance_issuing_id','where_condition'=>'id = "'.$job_id.'"','column'=>'id','dir'=>'asc'))->row_array();

		$permit_no=$permit_info['permit_no'];

		$acceptance_custodian_id=$permit_info['acceptance_custodian_id'];

		$acceptance_issuing_id=$permit_info['acceptance_issuing_id'];

		$approval_status=$permit_info['approval_status'];

		if($id=='')
		{
			$_POST['permit_no_sec']=$this->get_max_permit_id(array('job_id'=>$job_id));
			$_POST['remarks_id']=$permit_no.'-'.$_POST['permit_no_sec'];

		}

		$remarks_id=$this->input->post('remarks_id');

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
		if(!$id)
		{	 
			$fields.='user_id,approval_status,created';

			$fields_values.='"'.$user_id.'","'.$approval_status.'","'.date('Y-m-d H:i').'"';		

			$ins="INSERT INTO ".$this->db->dbprefix.SAFETY_REMARKS." (".$fields.") VALUES (".$fields_values.")";
		
			$this->db->query($ins);

			$id=$this->db->insert_id();		
			
			$msg_type=SA_RESP_PERSONS_NEW;

			$this->session->set_flashdata('success','Remarks has been created successfully and sent notification to Job custodian and Issuer.');    
			
		}
		else
		{

			$update=rtrim($update,',');

			$up="UPDATE ".$this->db->dbprefix.SAFETY_REMARKS." SET ".$update." WHERE id='".$id."'";
			
			$this->db->query($up);

			$msg_type=SA_RESP_PERSONS_UPDATE;

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

			#echo $up; exit;
			
			$this->db->query($up);
        }	

		$u_ids=$acceptance_custodian_id.','.$acceptance_issuing_id;
		
		$push_notification_array=array();

		switch($msg_type)
		{
			case SA_RESP_PERSONS_NEW:
				$receivers=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>'ID IN ('.$u_ids.')','table'=>USERS))->result_array();	
				
				foreach($receivers as $receiver):
					$msg_type=sprintf($msg_type,$receiver['first_name'],$this->session->userdata('first_name'),$permit_no,$remarks_id);
					$push_notification_array[]=array('uid'=>$receiver['id'],'pid'=>$id,'title'=>'New Remarks Notification','body'=>$msg_type);
				endforeach;
				
				break;
			case SA_RESP_PERSONS_UPDATE:
				 
				$receivers=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>'ID IN ('.$u_ids.')','table'=>USERS))->result_array();	

				foreach($receivers as $receiver):
					$msg_type=sprintf($msg_type,$receiver['first_name'],$this->session->userdata('first_name'),$permit_no);
					$push_notification_array[]=array('uid'=>$receiver['id'],'pid'=>$id,'title'=>'Remarks Notification','body'=>$msg_type);
				endforeach;

				break;
		}

		if(count($push_notification_array)>0)
		{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => PUSH_NOTIFICATION_URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($push_notification_array), // Properly encode JSON
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json' // Inform the server that the payload is JSON
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
		}

		$ret=array('status'=>true);

		echo json_encode($ret);
		
		exit;
	}

	public function get_max_permit_id($array_args)
	{
		extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(permit_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.SAFETY_REMARKS." WHERE job_id='".$job_id."'");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';

			return strtoupper($fet['permit_no']);
	}


	public function reply()
	{		
		$segment_array=$this->uri->segment_array();

		$param_url=$this->public_model->get_params_url(array('start'=>5,'segment_array'=>$segment_array));	

		if($param_url=='')
			$param_url=$segment_array[1];
		
		$this->data['param_url']=$param_url;

		$user_id=$this->session->userdata('user_id');

		$update = array_search('id',$this->uri->segment_array());

		$records=array(); $conversations=array();

		$show_form=0;

		if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);

			$where_condition='sr.id="'.$id.'"';

			$fields='j.permit_no,sr.approval_status,sr.created,sr.modified,sr.title,sr.images,u.first_name,sr.id,sr.job_id,sr.user_id as remarks_owner_user_id,aci.first_name as custodian_name,aii.first_name as issuer_name,sr.comments,sr.remarks_id,j.acceptance_custodian_id,j.acceptance_issuing_id';

			$records=$this->remarks_model->fetch_data(array('join'=>true,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'start'=>0,'length'=>1,'column'=>'sr.id','dir'=>'asc'))->row_array();

			if(in_array($user_id,array($records['acceptance_custodian_id'],$records['acceptance_issuing_id'])) || $this->session->userdata('is_safety')=='yes'){
				$show_form=1;
			}

			$conversations=$this->public_model->join_fetch_data(array('select'=>'d.id,d.comments,d.images,d.created,d.last_updated_by,u.first_name,d.is_safety','table1'=>SAFETY_REMARKS_DISCUSSIONS.' d','table2'=>USERS.' u','join_type'=>'inner','join_on'=>'u.id=d.user_id','where'=>'d.jobs_safety_remarks_id="'.$id.'"','num_rows'=>false,'custom_order'=>'d.id desc'))->result_array();
        }

		$this->data['show_form']=$show_form;

		$this->data['records']=$records;

		$this->data['conversations']=$conversations;

		$this->load->view($this->data['controller'].'reply',$this->data);
	}


	public function reply_form_action()
	{

		#echo '<pre>'; print_r($_FILES); 
        #print_r($this->input->post());   
       # exit; 

		$user_id=$this->session->userdata('user_id');
		
		$skip_fields=array('id','submit_type','image_data','step1','remarks_owner_user_id','remarks_id'); 
		
		$arr=array();
		
		$fields='';
		
		$fields_values='';
		
		$update=''; 
		
		$msg='';

		$remarks_id=$this->input->post('remarks_id');

		$id=($this->input->post('id')) ? $this->input->post('id') : '';		

		$remarks_owner_user_id=$this->input->post('remarks_owner_user_id');

		$job_id=$this->input->post('job_id');

		$user_name=$this->session->userdata('first_name');

		$user_id=$this->session->userdata('user_id');

		$is_safety=$this->session->userdata('is_safety');

		$_POST['is_safety']=$is_safety;

		$_POST['user_id']=$user_id;

		$_POST['last_updated_by']=$user_name;

		$_POST['created']=date('Y-m-d H:i');

		$_POST['jobs_safety_remarks_id']=$id;

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


		$permit_info=$this->public_model->get_data(array('table'=>JOBS,'select'=>'permit_no,id,approval_status,acceptance_custodian_id,acceptance_issuing_id','where_condition'=>'id = "'.$job_id.'"','column'=>'id','dir'=>'asc'))->row_array();

		$permit_no=$permit_info['permit_no'];

		$acceptance_custodian_id=$permit_info['acceptance_custodian_id'];

		$acceptance_issuing_id=$permit_info['acceptance_issuing_id'];

		$approval_status=$permit_info['approval_status'];

		$fields=rtrim($fields,',');
		$fields_values=rtrim($fields_values,',');
			
		$ins="INSERT INTO ".$this->db->dbprefix.SAFETY_REMARKS_DISCUSSIONS." (".$fields.") VALUES (".$fields_values.")";
	
		$this->db->query($ins);

		$id=$this->db->insert_id();		
		
		$msg_type=REMARK_DISCUSSION;

		$this->session->set_flashdata('success','Comment has been published successfully.');  

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

            $up="UPDATE ".$this->db->dbprefix.SAFETY_REMARKS_DISCUSSIONS." SET ".$update." WHERE id='".$id."'";

			$this->db->query($up);
        }	

		if($is_safety=='yes')
			$u_ids=$acceptance_custodian_id.','.$acceptance_issuing_id;
		else 
			$u_ids=$remarks_owner_user_id;
		
		$push_notification_array=array();

		switch($msg_type)
		{
			case REMARK_DISCUSSION:
				$receivers=$this->public_model->get_data(array('select'=>'first_name,id','where_condition'=>'ID IN ('.$u_ids.')','table'=>USERS))->result_array();	
				
				foreach($receivers as $receiver):
					$msg_type=sprintf($msg_type,$receiver['first_name'],$this->session->userdata('first_name'),$remarks_id);
					$push_notification_array[]=array('uid'=>$receiver['id'],'pid'=>$id,'title'=>'Remarks Notification From '.$remarks_id,'body'=>$msg_type);
				endforeach;
				
				break;
		}

		if(count($push_notification_array)>0)
		{
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => PUSH_NOTIFICATION_URL,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($push_notification_array), // Properly encode JSON
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json' // Inform the server that the payload is JSON
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
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
		
		$mode=$this->session->userdata('mode');
		
		$where_condition='';
		
		#echo $where_condition; exit;
		
		$generate_conditions=$this->generate_where_condition();
		
		$where_condition.=$generate_conditions['where_condition'];

		 $fields='j.job_name,j.location,j.permit_no,sr.approval_status,sr.created,sr.modified,sr.title,sr.images,u.first_name,sr.id,sr.job_id,sr.user_id,aci.first_name as custodian_name,aii.first_name as issuer_name,sr.remarks_id';
		
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
				
				$remarks_id=$record['remarks_id'];
					
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
				
				$images=base_url().'uploads/permits/'.$job_id.'/'.$record['images'];

				$images='<a href="javascript:void(0);" class="open_model" data-url="'.$images.'" data-bs-toggle="modal" data-bs-target="#modal-download">
						<img src="'.$images.'" width="40" height="40" />
                        </a>';

				$approval_status = "<span class='".$color."'>".$job_approval_status[$approval_status]."</span>";	
				
				$modified=$record['modified'];

				$raised_by=$record['user_id'];

				$action='<a href="'.base_url().'remarks/reply/id/'.$id.'/?mode='.$mode.'">Reply</a>';

				if($raised_by==$user_id)
				$action.='&nbsp;|&nbsp;<a href="'.base_url().'remarks/form/id/'.$id.'/?mode='.$mode.'" style="color:green;">Edit</a>&nbsp;|&nbsp;<a href="'.base_url().'remarks/delete/id/'.$id.'/?mode='.$mode.'" style="color:red;" onclick="javascript:return confirm(\'Are you sure to delete this remarks?\');">Delete</a>';

				$responsible_persons=$record['custodian_name'].'<br />'.$record['issuer_name'];

				$cl='';
				$redirect=base_url().'jobs/form/id/'.$job_id;			
				$permit_no='<a href="'.$redirect.'">'.$permit_no.'</a>';
				$json[$j]['remarks_id']=$remarks_id;
				$json[$j]['permit_no']=$permit_no;
				$json[$j]['title']=$title;
				$json[$j]['created_by']=$record['first_name'];
				$json[$j]['id']='<a href="'.$redirect.'" style="color:'.$cl.'">#'.$title.'</a>';
				$json[$j]['approval_status']=$approval_status;#.' - '.$search;
				$json[$j]['created']=date(DATE_FORMAT.' H:i A',strtotime($created));
				$json[$j]['images']=$images;
				$json[$j]['action']=$action;
				$json[$j]['responsible_persons']=$responsible_persons;
				
				$j++;
			}
		}

		$total_records=$totalFiltered;
		

		$json=json_encode($json);
							
		$return='{"total":'.intval( $total_records ).',"recordsFiltered":'.intval( $total_records ).',"rows":'.$json.'}';
		
		echo $return;
		
		exit;
	}

	public function delete()
	{
		$update = array_search('id',$this->uri->segment_array());

		$mode=$this->session->userdata('mode');

		if($update !==FALSE && $this->uri->segment($update+1))
        {
            $id = $this->uri->segment($update+1);

			$this->db->where('id',$id);

			$this->db->delete(SAFETY_REMARKS);

			$this->session->set_flashdata('success','Remarks has been deleted successfully'); 
		}

		redirect('remarks/index/?mode='.$mode);
			
		exit;
	}

}
