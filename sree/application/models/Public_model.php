<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : public_model.php
 * Project        : PMS
 * Creation Date  : 06-02-2016
 * Author         : Anantha Kumar RJ
 * Description    : Write a common module to use anywhere in the project
*********************************************************************************************/	
class Public_model extends CI_Model
{
	

	public	function __construct()
	{
		parent::__construct();
        $notes=''; 
	}

	public function send_email($req)
	{
            extract($req);   
            $config = array();
            $config['useragent'] = "CodeIgniter";
           // $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
            $config['protocol'] = "sendmail";
            $config['smtp_host'] = "ssl://mail.ttaswebsite.com";
            $config['smtp_user'] = 'support@ttaswebsite.com';
            $config['smtp_pass'] = 'Cnd!W=$rNwD';        
            $config['smtp_port']= "465";
            $config['mailtype'] = 'html';
            $config['charset']  = 'utf-8';
            $config['newline']  = "\r\n";
            $config['validate']     = TRUE;
            $config['wordwrap'] = TRUE;
            $config['send_multipart'] = FALSE;
            $config['mailtype'] = 'html'; 
            $config['smtp_crypto'] = 'ssl';
            $this->load->library('email');
            $this->email->initialize($config);
		    $this->email->set_newline("\r\n");  
			$this->email->subject($subject);
			$this->email->message($mail_content);
			$this->email->from('email@ttaswebsite.com');
		//	echo 'TTTT '.$to;
			$this->email->to($to);
			$this->email->send();
			return;
			//echo 'Debugger '.$this->email->print_debugger();
			
		//	exit;

	}

	public function extends_from_date($field_name,$selected_inputs,$index,$date_diff)
	{
		
		$return='';

		$sel_flag=0;

		for($d=0;$d<$date_diff;$d++){
			
			$date = date('d-m-Y', strtotime('+'.$d.' days'));

			$sel='';

			if($date==$selected_inputs)  { $sel='selected="selected"'; $sel_flag=1; } 

			$return.='<option value="'.$date.'" '.$sel.'>'.$date.'</option>';
		}
		
		if($sel_flag==0 && $selected_inputs!=''){
			$return='<option value="'.$selected_inputs.'" selected>'.$selected_inputs.'</option>'.$return;
		}

		$return='<select class="form-control '.$field_name.$index.' extends'.$index.'"  name="'.$field_name.'['.$index.']" id="'.$field_name.'['.$index.']"><option value="" selected>Select</option>'.$return;

		$return.='</select>';

		return $return;

	}


	public function extends_contractors($field_name,$inputs,$selected_inputs,$index)
	{
		$selected_inputs=explode(',',$selected_inputs);

		$return='<select class="form-control select2 extends'.$index.'"  name="'.$field_name.'['.$index.']" id="'.$field_name.$index.'" multiple style="max-width:250px;">';

		foreach($inputs as $list){
			$sel=in_array($list['id'],$selected_inputs) ? 'selected="selected"' : '';
			$return.='<option value="'.$list['id'].'" '.$sel.'>'.$list['name'].'</option>';
		}
		
		$return.='</select>';

		return $return;

	}

	public function extends_authorities($field_name,$selected_inputs,$index,$user_id,$inputs,$pa_id)
	{
		$return='<select class="form-control extends_date '.$field_name.$index.'  extends'.$index.'"  name="'.$field_name.'['.$index.']" id="'.$field_name.$index.'" data-id="'.$index.'" data-date="'.date('d-m-Y H:i').'"><option value="" selected>Select</option>';

		foreach($inputs as $list){

			$chk='';

			$id=$list['id'];

			$flag=0;

			if($field_name=='ext_performing_authorities')
			{ 
				if($selected_inputs=='')
				{ 
				   if($user_id==$list['id'])
				   $flag=1;
				}
				
			} else
			{
				if($selected_inputs=='')
				{
					if($id!=$user_id)
					$flag=1;
				}
				else if($selected_inputs>0)
				{
					$flag=1;
					
					if($id==$pa_id)
						$flag=0;
				}
			} 

			if($id==$selected_inputs) {
				$chk='selected'; $flag=1;
			}
			 

			if($flag==1)
			$return.='<option value="'.$list['id'].'" '.$chk.'>'.$list['first_name'].'</option>';
		}
		
		$return.='</select>';

		return $return;

	}
    

    public function get_max_eip_no()
	{
		$qry=$this->db->query("SELECT max(eip_no_sec)+1 as sl_no FROM ".$this->db->dbprefix.JOBSISOLATION." WHERE department_id='".$this->session->userdata('department_id')."'");

		$fet=$qry->row_array();	
		
		if(!$fet['sl_no'])
		$fet['sl_no']=1;

		return strtoupper(substr($this->session->userdata('department_name'),0,2)).$fet['sl_no'];

	}
	
	public function dashboard_count()
	{
		
		$user_id=$this->session->userdata('user_id');
		
		$this->load->model(array('jobs_model','jobs_isolations_model'));
		
		$department_id=$this->session->userdata('department_id');
		
		$where_condition=" j.department_id = '".$department_id."'";
		
		$fields = array(0 =>'count(j.id) as status_counts,j.approval_status');
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$totalFiltered=$this->jobs_model->fetch_data(array('column'=>'j.id','dir'=>'asc','length'=>30,'start'=>0,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'join'=>true,'group_by'=>'j.approval_status'));
		
		#echo $this->db->last_query(); exit;
		$status=$status_counts=array();
		
		if($totalFiltered->num_rows()>0)
		{
			$fet=$totalFiltered->result_array();	
			
			$status=array_column($fet,'approval_status');
			
			$status_counts=array_column($fet,'status_counts');
			
			#echo '<pre>';print_r($status); print_r($status_counts); exit;
		}
		
		#echo $this->db->last_query(); exit;
		
		#$where_condition=" j.department_id = '".$department_id."'";
		
			$qry='('; //{"a":"15","b":"","c":"","d":"","e":"","f":""}
				for($i=1;$i<=20;$i++)
				{
					$qry.=' (j.isolated_name like \'%"'.$i.'":"'.$user_id.'"%\') OR ';
				}
				$qry=rtrim($qry,'OR ');
				
				$qry.=')';
		
		
		$where_condition=' (j.remarks_issuing_id = "'.$user_id.'" OR j.issuing_authority_id2 = "'.$user_id.'" OR 
			j.issuing_authority_id3 = "'.$user_id.'" OR j.remarks_performing_id = "'.$user_id.'") OR '.$qry;
		
		$fields = array(0 =>'count(j.id) as status_counts,j.approval_status');
		
		$where_condition=rtrim($where_condition,'AND ');
		
		$totalFiltered=$this->jobs_isolations_model->fetch_data(array('column'=>'j.id','dir'=>'asc','length'=>30,'start'=>0,'where'=>$where_condition,'num_rows'=>false,'fields'=>$fields,'join'=>true,'group_by'=>'j.approval_status'));
		
		#echo $this->db->last_query(); exit;
		$eip_status=$eip_status_counts=array();
		
		if($totalFiltered->num_rows()>0)
		{
			$fet=$totalFiltered->result_array();	
			
			$eip_status=array_column($fet,'approval_status');
			
			$eip_status_counts=array_column($fet,'status_counts');
			
			#echo '<pre>';print_r($eip_status); print_r($eip_status_counts); exit;
		}
		
		return json_encode(array('eip_status_counts'=>$eip_status_counts,'eip_status'=>$eip_status,'status'=>$status,'status_counts'=>$status_counts));
		
	}
	
	
	public function ajax_check_data_exists($array_args)
	{ 
		extract($array_args);	
		
		$display_query=(isset($display_query)) ? $display_query : '';
		
		  $this->db->where($where);
		  
		  $nums = $this->db->get($table_name);
		  
		  if($display_query==true)
		  echo $this->db->last_query();
		  
		  $nums = $nums->num_rows();
		  
		  return $nums;
	}
    
      // Notes function
    public function notes($req){
        $name=$this->session->userdata('first_name');
        extract($req);
        switch ($type) {
            case 'login':
               $notes.=' '.$name.' '.LOGIN_SUCCESS;
             break;
            case 'chg_passwd':
                $notes .=''.$name.' '.CHNG_PASSWD;
                break;
            case 'profile':
                $notes .=' '.$name.' '.PROFILE_UPDATE;
                break;
            case 'new_user':
                $notes .=' '.$name.' '.NEW_USER;
                break;
            case 'user_info_update':
                $notes .=' '.$name.' '.UPD_USER;
                break;
            case 'del_user':
                $notes .=' '.$name.' '.DB_DELETE;
                break;
            case 'status_change':
                $notes .=' '.$name.' '.STATUS_CHANGE;
                break;
            case 'new_company':
                $notes .=' '.$name.' '.NEW_COMPANY;
                break;
            case 'del_company':
                $notes .=' '.$name.' '.DEL_COMPANY;
                break;                
            case 'logout':
                $notes .=' '.$name. ' '.LOGOUT;
                break;
            case 'db_upd':
                $notes .=' '.$name. ' '.DB_UPDATE;
                break;
            case 'db_add':
                $notes .=' '.$name. ' '.DB_ADD;
                break;
            case 'db_dele':
                $notes .=' '.$name. ' '.DB_DELETE;
                break;
            case 'fgt_password':
                $notes .=' '.$email. ' '.FGT_PASSWORD;
                    break;
            default:
                break;
        }
        $data=array(
                'user_id'=>$this->session->userdata('user_id'),
                'notes'=>$notes,
                'created'=>date('Y-m-d H:i:s')
            );
        $this->db->insert(NOTES,$data);
    }
	
	public function get_data($array_args)
	{
            extract($array_args);
			
            $this->db->select($select);
			
            $this->db->where($where_condition);
			
            $this->db->from($table);   
			
			if(isset($group_by))
			 $this->db->group_by($group_by);  
			 
			 if(isset($column) && isset($dir))
			 $this->db->order_by($column."   ".$dir);
			 
			 if(isset($limit))
			 $this->db->limit($limit,0);          
			
			 if(isset($having))
			 $this->db->having($having);          
			
			$qry=$this->db->get();  
			
            return $qry;
	}

    public function fetch_data($req){
            extract($req);
            $this->db->select($select);
            $this->db->where($where);
            // isset($order) ? $this->db->order_by($order,'modified') :'';
            if(isset($limit) && isset($offset) && $limit > 0 ){
                $qry=$this->db->get($table,$limit,$offset);    
            }
            else if(isset($limit) && $limit ){
              $qry=$this->db->get($table,$limit);       
            }
            else{
                $qry=$this->db->get($table);    
            }
			
            if($qry->num_rows()>0){
                return $qry;
            }
            return false;
    }
    
        // Save last login
    public function last_login(){
        $id=$this->session->userdata('user_id');
        $data=array('last_login'=>date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        $this->db->update(USERS,$data);
    }
    
     // Fetch Data from two tables
    public function join_fetch_data($req)
    {
        extract($req);   
        
        $this->db->select($select);     
        
        $this->db->from($table1);
        
        $this->db->join($table2,$join_on,$join_type);
        
        $where=(isset($where)) ? $where : '';
        
        if(!empty($where))
        $this->db->where($where);
        
        if(isset($order_by) && $order_by!='' ){
            $this->db->order_by($order_by,$order);            
        }

        if(isset($custom_order))
        $this->db->order_by($custom_order);            	

        if($num_rows==false )
        {
            if(isset($length) && isset($start)){
                $this->db->limit($length,$start);                
            }
        }
		
		 if(isset($group_by))
		 $this->db->group_by($group_by);  

		 if(isset($having) && $having!=''){
			$this->db->having($having);
		}
		
        
        $get_query = $this->db->get();
        
        #echo $this->db->last_query();
        if($num_rows==true){
            return $get_query->num_rows();
        }

        
        return $get_query;          
        
    }   

      // Fetch Data from DB for ajax calls
    public function fetch_data_ajx($req)
    {
        extract($req);   
        
        $this->db->select($fields);     
        
        $this->db->from($table);
        if(isset($table2) && $table2!=''){            
            $this->db->join($table2,$join_on,$join_type);
        }        
        $where=(isset($where)) ? $where : '';
        
        if(!empty($where))

        $this->db->where($where);
        if(isset($group_by) ){
          $this->db->group_by($group_by);  
        }
        
        if(isset($order_by) && $order_by!=''){
          $this->db->order_by($order_by,$order);
        }
        
        #$this->db->order_by('category.category_id','desc');
        if($num_rows==false && isset($column))
        {
            $this->db->order_by($column."   ".$dir);
            
            $this->db->limit($length,$start);
        }
        
        $get_query = $this->db->get();
        
        #echo $this->db->last_query();
        if($num_rows==true){
            return $get_query->num_rows();
        }

        
        return $get_query;          
        
    }  
	
	// Fetch Data from three tables
    public function join_fetch_data_three_tables($req)
    {
        extract($req);   
        
        $this->db->select($select);     
        
        $this->db->from($table1);
        
        $this->db->join($table2,$join_on_tbl2,$join_type);
		
		$this->db->join($table3,$join_on_tbl3,$join_type);
        
        $where=(isset($where)) ? $where : '';
		
		$where_in=(isset($where_in)) ? $where_in : '';
        
        if(!empty($where))

        $this->db->where($where);
		
		if(!empty($where_in))

        $this->db->where_in('subscription.id',$where_in);
        
        if(isset($order_by) && $order_by!='' ){
            $this->db->order_by($order_by,$order);            
        }
        
        if($num_rows==false )
        {
            if(isset($length) && isset($start)){
                $this->db->limit($length,$start);                
            }
        }
        
        $get_query = $this->db->get();
        
        #echo $this->db->last_query();
        if($num_rows==true){
            return $get_query->num_rows();
        }

        return $get_query;          
        
    }
	
	//
	function csv_export($cols=NULL,$result_array=NULL,$prefix=NULL,$filename=NULL)
	{
		$col_name = array();
		foreach( $cols as $col )
		{
			$title = $col;
			
			if( $prefix != "" )
			{
				$title = str_replace($prefix.'.','',$title);
			}
			
			$title = ucfirst(str_replace('_',' ',$title));
			$col_name[] = $title;
			
		}
		
		//print_r($result_array);exit;
		
		$file = fopen("php://memory", 'w');
		header("Pragma: no-cache");                           // HTTP/1.0
		header("Content-type: application/force-download");
		header("Content-type: application/octet-stream");
		header("Content-Type: application/download");
    	header('Content-Type: application/csv');
    	// tell the browser we want to save it instead of displaying it
    	header('Content-Disposition: attachement; filename="'.$filename.'"');
		fputcsv($file,$col_name);
		
		$subscription = array();
		
		foreach($result_array as $result)
		{
			$res = array();
			for($i=0;$i<count($result);$i++)
			{ 
				$title = $cols[$i];
				if( $prefix != "" )
				{
					$title = str_replace($prefix.'.','',$title);
				}
				$val = $result[$title];
				if( $title == "amount")
				{
					if($val>0)
						$res[$title] = '$'.$val;
					else
						$res[$title] = '---';
				}
				else if( $title == "subscription_date" || $title == "proceeds_due_by_date" )
				{
					if(strtotime($val)>0)
						$res[$title] = date('m/d/Y',strtotime($val));
					else
						$res[$title] = '---';
				}
				else
				{
					$res[$title] = str_replace("_"," ",$result[$title]);
				}
			}
			
			fputcsv($file,$res);
		}
		fseek($file, 0);
	 	fpassthru($file); // make php send the generated csv lines to the browser
		//exit;
		
	}


	public function send_sms($array_args)
	{
			return;

			$text='';
			
			extract($array_args);

			$permit_no='#'.$permit_no;

			$additional_text=(isset($additional_text)) ? $additional_text : '';

			//Getting Sender Info
			$sender_info=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'id ="'.$sender.'"','table'=>USERS))->row_array();

			$exxp=explode(',',$receiver);

			#echo 'FF '.count($exxp).' = '.$receiver; exit;

			//Getting Receiver Info
			if(count($exxp)==1)
			$receiver_info=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'id ="'.$receiver.'"','table'=>USERS))->row_array();
			else
			{
				$receiver=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'ID IN ('.$receiver.')','table'=>USERS))->result_array();	

				$receiver_info['first_name'] = 'All';

				$mobile_number='';

				foreach($receiver as $res)
				{
					$mobile_number.=$res['mobile_number'].',';
				}
				$receiver_info['mobile_number']=rtrim($mobile_number,',');
			}	

			#print_r($receiver_info); exit;

			#$receiver_info['first_name']='Steward';

			switch ($msg_type)
			{
				case PATOIA_WAITING_APPROVAL:							
							$text=sprintf(PATOIA_WAITING_APPROVAL,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_APPROVAL:							
							$text=sprintf(IATOPA_APPROVAL,$permit_no,$sender_info['first_name']);
					break;						
				case PATOIA_WAITING_CANCEL_REQUEST:							
							$text=sprintf(PATOIA_WAITING_CANCEL_REQUEST,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_CANCEL_APPROVAL:							
							$text=sprintf(IATOPA_CANCEL_APPROVAL,$permit_no,$sender_info['first_name']);
					break;	
				case PATOIA_WAITING_COMPLETION_REQUEST:							
							$text=sprintf(PATOIA_WAITING_COMPLETION_REQUEST,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_COMPLETION_APPROVAL:							
							$text=sprintf(IATOPA_COMPLETION_APPROVAL,$permit_no,$sender_info['first_name']);
					break;	
				case PATOIA_WAITING_EXTEND_APPROVAL:							
							$text=sprintf(PATOIA_WAITING_EXTEND_APPROVAL,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_ACCEPT_EXTEND_APPROVAL:			
							$text=sprintf(IATOPA_ACCEPT_EXTEND_APPROVAL,$receiver_info['first_name'],$permit_no,$sender_info['first_name']);
					break;
				case PATOIA_SELF_CANCELLED:				
							$text=sprintf(PATOIA_SELF_CANCELLED,$permit_no,$sender_info['first_name']);		
					break;	
				case DEPT_TO_PA:			//Not working	
							$text=sprintf(DEPT_TO_PA,$permit_no,$sender_info['first_name']);	
					break;
				case EIP_PA_TO_ISO:				
							$text=sprintf(EIP_PA_TO_ISO,$permit_no,$sender_info['first_name']);	
							break;
				case EIP_ISO_TO_PA:				
							$text=sprintf(EIP_ISO_TO_PA,$permit_no,$sender_info['first_name']);	
							break;
				/*case EIP_ISO_TO_PA_COMPLETED:				
							$text=sprintf(EIP_ISO_TO_PA_COMPLETED,$permit_no);										
				break;
				case EIP_DEPT_TO_PA:				
							$text=sprintf(EIP_DEPT_TO_PA,$receiver_info['first_name'],$permit_no);										
				break;		*/				
			}

			if($additional_text!='')
				$text.=$additional_text;

			$text.=' - DCBL';

			#echo $text; exit;
			#echo $additional_text.'= '.$text.' = '.EIP_DEPT_TO_PA; exit;
			$url='http://bhashsms.com/api/sendmsg.php';

			$headers[] = 'application/x-www-form-urlencoded';

			$ch = curl_init();

			#$receiver_info['mobile_number']='8012522550';

			$context = stream_context_create(
			    array(
			        "http" => array(
			            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
			        )
			    )
			);

			#$receiver_info['mobile_number']=9043371538;	

			$text=str_replace('#','',$text);
			
			$url=$url.'?user=DCMWPS&pass=DCMWPS&sender=DALWPS&phone='.$receiver_info['mobile_number'].'&text='.urlencode($text).'&priority=ndnd&stype=normal'; 		

			

			#$r=file_get_contents($url, false, $context);
				


			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
	     	curl_setopt($ch, CURLOPT_HTTPGET, 1); // setting as a post		
	     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	     	curl_exec($ch);
			
			if (curl_error($ch))
			{
			    $error_msg = curl_error($ch);
			  
			    $ins=array('permit_no'=>$permit_no,'error_msg'=>$error_msg,'created'=>date('Y-m-d H:i:s'),'mobile_number'=>$receiver_info['mobile_number'],'text_msg'=>urlencode($text));

			    $this->db->insert(ERROR_LOGS,$ins);
			}
			

			$curlerrno = curl_errno($ch);

			curl_close($ch);

			return true;		
	}

	public function OLssend_sms($array_args)
	{
			return;
			
			extract($array_args);

			$permit_no='#'.$permit_no;

			$additional_text=(isset($additional_text)) ? $additional_text : '';

			//Getting Sender Info
			$sender_info=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'id ="'.$sender.'"','table'=>USERS))->row_array();

			$exxp=explode(',',$receiver);

			#echo 'FF '.count($exxp).' = '.$receiver; exit;

			//Getting Receiver Info
			if(count($exxp)==1)
			$receiver_info=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'id ="'.$receiver.'"','table'=>USERS))->row_array();
			else
			{
				$receiver=$this->public_model->get_data(array('select'=>'first_name,mobile_number','where_condition'=>'ID IN ('.$receiver.')','table'=>USERS))->result_array();	

				$receiver_info['first_name'] = 'All';

				$mobile_number='';

				foreach($receiver as $res)
				{
					$mobile_number.=$res['mobile_number'].',';
				}
				$receiver_info['mobile_number']=rtrim($mobile_number,',');
			}	

			#print_r($receiver_info); exit;

			#$receiver_info['first_name']='Steward';

			switch ($msg_type)
			{
				case PATOIA_WAITING_APPROVAL:							
							$text=sprintf(PATOIA_WAITING_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_APPROVAL:							
							$text=sprintf(IATOPA_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;						
				case PATOIA_WAITING_CANCEL_REQUEST:							
							$text=sprintf(PATOIA_WAITING_CANCEL_REQUEST,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_CANCEL_APPROVAL:							
							$text=sprintf(IATOPA_CANCEL_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case PATOIA_WAITING_COMPLETION_REQUEST:							
							$text=sprintf(PATOIA_WAITING_COMPLETION_REQUEST,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_COMPLETION_APPROVAL:							
							$text=sprintf(IATOPA_COMPLETION_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case PATOIA_WAITING_EXTEND_APPROVAL:							
							$text=sprintf(PATOIA_WAITING_EXTEND_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;	
				case IATOPA_ACCEPT_EXTEND_APPROVAL:			
							$text=sprintf(IATOPA_ACCEPT_EXTEND_APPROVAL,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);
					break;
				case PATOIA_SELF_CANCELLED:				
							$text=sprintf(PATOIA_SELF_CANCELLED,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);							
					break;	
				case DEPT_TO_PA:				
							$text=sprintf(DEPT_TO_PA,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);							
					break;
				case EIP_PA_TO_ISO:				
							$text=sprintf(EIP_PA_TO_ISO,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);	
				case EIP_ISO_TO_PA:				
							$text=sprintf(EIP_ISO_TO_PA,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);										
				break;
				case EIP_ISO_TO_PA_COMPLETED:				
							$text=sprintf(EIP_ISO_TO_PA_COMPLETED,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);										
				break;
				case EIP_DEPT_TO_PA:				
							$text=sprintf(EIP_DEPT_TO_PA,$receiver_info['first_name'],$permit_type,$permit_no,$sender_info['first_name']);										
				break;						
			}

			if($additional_text!='')
				$text.=$additional_text;


			#echo $msg_type.' - '.$text.' = '.IATOPA_ACCEPT_EXTEND_APPROVAL; exit;
			$url='http://bhashsms.com/api/sendmsg.php';

			$url='http://sms.pitdemo.in/api/sendmsg.php';

			$headers[] = 'application/x-www-form-urlencoded';

			$ch = curl_init();

			#$receiver_info['mobile_number']='8220918567';

			$context = stream_context_create(
			    array(
			        "http" => array(
			            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
			        )
			    )
			);

			
			//$receiver_info['mobile_number']=9043371538;	

			$text=str_replace('#','',$text);
			
			$url=$url.'?user=DCMWPS&pass=DCMWPS&sender=DALWPS&phone='.$receiver_info['mobile_number'].'&text='.urlencode($text).'&priority=ndnd&stype=normal'; 		

			#echo $url; exit;

			#$r=file_get_contents($url, false, $context);
				


			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
	     	curl_setopt($ch, CURLOPT_HTTPGET, 1); // setting as a post		
	     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	     	curl_exec($ch);
			
			if (curl_error($ch))
			{
			    $error_msg = curl_error($ch);
			  
			    $ins=array('permit_no'=>$permit_no,'error_msg'=>$error_msg,'created'=>date('Y-m-d H:i:s'),'mobile_number'=>$receiver_info['mobile_number'],'text_msg'=>urlencode($text));

			    $this->db->insert(ERROR_LOGS,$ins);
			}
			

			$curlerrno = curl_errno($ch);

			curl_close($ch);

			return true;		
	}
	
	public function datetime_diff($array_args)
	{
		extract($array_args);		
		
		$start_date=date('Y-m-d',strtotime($start_date));
		
		$end_date=date('Y-m-d',strtotime($end_date));
		
		$s_time=strtotime($start_date);
		
		$e_time=strtotime($end_date);
		
		if($e_time>$s_time)
		{ $diff=abs($e_time-$s_time); }# echo '<br />Yes '.$start_date.' - '.$end_date;
		else
		$diff=abs($s_time-$e_time);
		
		$qry_diff=$this->db->query('SELECT DATEDIFF("'.$start_date.'","'.$end_date.'") AS DiffDate')->row_array();
		
		$days=$qry_diff['DiffDate'];	
		
		return array('days'=>$days);			
		
	}
	
    public function get_params_url($array_args)
    {
        extract($array_args);

        $param_url='';

        for($i=$start;$i<=count($segment_array);$i++)
        {
            $param_url.=$segment_array[$i].'/';
        }

        return $param_url;
    }
	
	public function get_extended_missed_dates($date_array)
	{
		$missed_dates_array = array();

		$date_array=explode(',',implode(',',$date_array));

		$date_array=array_filter($date_array);

		$date_array=explode(',',implode(',',$date_array));

		#print_r($date_array);

		for ($i = 1, $n = count($date_array); $i < $n; $i++) 
		{
		    $date_from = $date_array[$i]; #date('d-m-Y',strtotime($date_array[$i]));
			$date_to = $date_array[$i-1]; #date('d-m-Y',strtotime($date_array[$i-1]));

			$daysLeft = abs(strtotime($date_to) - strtotime($date_from));
			$day_difference = $daysLeft/(60 * 60 * 24);

			#echo 'days '.$day_difference.' = '.$date_from.' = '.$date_to.' <br/>';
			if($day_difference > 1)
			{
				$date_end = strtotime($date_from);
				$date_start = strtotime($date_to);

				for ($j=$date_start; $j<=$date_end; $j+=86400) 
				{  
					$missed_date = date("d-m-Y", $j);

					if(!in_array(strtotime($missed_date), array($date_start,$date_end)))
					{
						$missed_dates_array[] = $missed_date;	
					}
				}  
			}
		}

		if(count($missed_dates_array)>0)
			return implode('<br />',$missed_dates_array);
		else
			return '- - -';
	}
}
