<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('public_model'));

		
		/*$resp=$this->public_model->send_sms(array('sender'=>158,'receiver'=>'157,158','msg_type'=>IATOPA_ACCEPT_EXTEND_APPROVAL,'permit_type'=>'General Work Permit','permit_no'=>'001'));

		print_r($resp); exit;*/
	}



	public function backup()
	{

		$tables=unserialize(PERMITS);

		$where="WHERE DATEDIFF(DATE(NOW()),DATE(created))>45";

		$msg='';



		$ins=array('permit_no'=>12,'error_msg'=>'Backup ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'9043371538','text_msg'=>'Started backup '.implode(',',$tables));

		$this->db->insert(ERROR_LOGS,$ins);

		foreach($tables as $name => $label):

			$qry=$this->db->query("INSERT INTO dml_".$name."_bk SELECT * FROM dml_".$name." ".$where." ORDER BY ID ASC");

			$qry=$this->db->query("DELETE FROM dml_".$name." ".$where);

			$aff=$this->db->affected_rows();

			$msg=$label.' - '.$aff;

			$ins=array('permit_no'=>12,'error_msg'=>'Backup ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'233222','text_msg'=>'Backup is done '.$msg);

			$this->db->insert(ERROR_LOGS,$ins);

		endforeach;
			
			$ins=array('permit_no'=>12,'error_msg'=>'Backup ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'9043371538','text_msg'=>'Completed backup');

		$this->db->insert(ERROR_LOGS,$ins);
			

		exit;	
	}


	public function check_expired_jobs()
	{
		$this->load->model(array('cron_job_model'));

		$where='';# AND id ="'.$this->session->userdata('user_id').'"';

		

		#$ret=$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>''));

		$where='user_role NOT IN("SA") AND status ="'.STATUS_ACTIVE.'"';	//Cancel or Complete
		
        $req=array(
          'select'  =>'id,first_name,mobile_number',#,DATEDIFF(NOW(),modified) AS DiffDate
          'table'   =>USERS,
          'where_condition'=>($where)
        );
			
        $users=$this->public_model->get_data($req)->result_array();

        define('CRON_NOTES','cron_notes');

        foreach($users as $user)
        {
        	$emp=array();

        	$user_id=$user['id'];

        	$mobile_number=$user['mobile_number'];

        	$first_name=$user['first_name'];
        	
        	$permit_nos='';

        	$where_job_status='approval_status NOT IN(11,12) AND remarks_performing_id="'.$user_id.'"';

        	$get_jobs_info=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'eip_no,TIMESTAMPDIFF(DAY,date_start, "'.date('Y-m-d H:i').'") as time_diff,id','where_condition'=>$where_job_status,'having'=>'time_diff>=14'));

			$num_records=$get_jobs_info->num_rows();
			#echo 'Query '.$this->db->last_query(); exit;
			#echo '<pre>'; 
			if($num_records>0)	
			{	
				$records=$get_jobs_info->result_array();

				foreach($records as  $keys => $record)
				{
					$time_diff=($record['time_diff']-15).' days ago';

					$permit_nos.=$record['eip_no'].'('.$time_diff.'),';
				}

				$permit_nos=ltrim($permit_nos,',');

				$permit_nos=rtrim($permit_nos,',');

				if($permit_nos!='')
				{

					

					$url='http://bhashsms.com/api/sendmsg.php';

					$text='Dear Sir, Following EIP Permits '.$permit_nos.' will expire tomorrow. Please take necessary action - DCBL';

					$headers[] = 'application/x-www-form-urlencoded';

					$ch = curl_init();


					$ins=array('notes'=>$text,'created'=>date('Y-m-d H:i:s'),'mobile_number'=>$mobile_number,'user_id'=>$user_id);

					$this->db->insert(CRON_NOTES,$ins);

					

					#$receiver_info['mobile_number']='8220918567';

					$context = stream_context_create(
					    array(
					        "http" => array(
					            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
					        )
					    )
					);

					#$receiver_info['mobile_number']=9043371538;	

					$text=str_replace('#','',$text);
					
					$url=$url.'?user=DCMWPS&pass=DCMWPS&sender=DALWPS&phone='.$mobile_number.'&text='.urlencode($text).'&priority=ndnd&stype=normal'; 		

					#echo '<br />'.$url; #exit;
					
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);    
			     	curl_setopt($ch, CURLOPT_HTTPGET, 1); // setting as a post		
			     	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			     	curl_exec($ch);
					
					if (curl_error($ch))
					{
					    $error_msg = curl_error($ch);
					  
					    $ins=array('permit_no'=>12,'error_msg'=>$error_msg,'created'=>date('Y-m-d H:i:s'),'mobile_number'=>$receiver_info['mobile_number'],'text_msg'=>$error_msg);

						$this->db->insert(ERROR_LOGS,$ins);
					}
					

					$curlerrno = curl_errno($ch);

					curl_close($ch);

					sleep(3);
				}	
			}	

        }	


		/*$ins=array('permit_no'=>12,'error_msg'=>'AFter ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'233222','text_msg'=>'sdfdsfsdf');

		$this->db->insert(ERROR_LOGS,$ins);*/

		echo 'Done';
	}

	public function terstcheck_expired_jobs()
	{
		$this->load->model(array('cron_job_model'));

		$where='';# AND id ="'.$this->session->userdata('user_id').'"';

		$ins=array('permit_no'=>1,'error_msg'=>'Before ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'233222','text_msg'=>'sdfdsfsdf');

		$this->db->insert(ERROR_LOGS,$ins);


		echo 'Working ';

		#$ret=$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>''));


		$ins=array('permit_no'=>12,'error_msg'=>'AFter ','created'=>date('Y-m-d H:i:s'),'mobile_number'=>'233222','text_msg'=>'sdfdsfsdf');

		$this->db->insert(ERROR_LOGS,$ins);

		echo 'Done';
	}

	public function check_expired_jobs_old()
	{
		$this->load->model(array('cron_job_model'));

		$where='';# AND id ="'.$this->session->userdata('user_id').'"';

		$ret=$this->cron_job_model->check_expired_permits(array('where'=>$where,'type'=>''));
	}

	public function send_extended_permit_sms()
	{

		$where='user_role NOT IN("SA") AND status ="'.STATUS_ACTIVE.'"';	//Cancel or Complete
		
            $req=array(
              'select'  =>'id,first_name,mobile_number',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'   =>USERS,
              'where_condition'=>($where)
            );
			
        $users=$this->public_model->get_data($req)->result_array();

      
		$permits=unserialize(PERMITS);

		$where_job_status='';

		$job_status=STATUS_OPENED;

		foreach($permits as $table_name => $label)
		{
			switch($table_name)
			{
				case EXCAVATIONPERMITS:
										if($job_status==strtolower(STATUS_OPENED))
											$where_job_status=' approval_status NOT IN('.implode(',',unserialize(EXCAVATION_CLOSED_STATUS)).')';
										else if($job_status==strtolower(STATUS_CLOSED))
											$where_job_status=' approval_status IN('.implode(',',unserialize(EXCAVATION_CLOSED_STATUS)).')';

										$fields='acceptance_issuing_id,acceptance_performing_id,dept_issuing_id';
										break;
				case CONFINEDPERMITS:
										if($job_status==strtolower(STATUS_OPENED))
											$where_job_status=' approval_status NOT IN('.implode(',',unserialize(CONFINED_CLOSE_PERMITS)).')';
										else if($job_status==strtolower(STATUS_CLOSED))
											$where_job_status=' approval_status IN('.implode(',',unserialize(CONFINED_CLOSE_PERMITS)).')';

										$fields='extended_issuing_from_authority,extended_issuing_to_authority,extended_performing_from_authority,extended_performing_to_authority,extended_safety_from_sign_id,extended_safety_to_sign_id,acceptance_performing_id,acceptance_issuing_id,cancellation_issuing_id,acceptance_safety_sign_id,cancellation_performing_id';

										break;	
				default:
										if($job_status==strtolower(STATUS_OPENED))
											$where_job_status=' approval_status NOT IN('.implode(',',unserialize(CLOSED_JOBS)).')';
										else if($job_status==strtolower(STATUS_CLOSED))
											$where_job_status=' approval_status IN('.implode(',',unserialize(CLOSED_JOBS)).')';

										if($table_name==JOBS)
											$fields='issuing_authority,performing_authority,acceptance_issuing_id,cancellation_issuing_id,acceptance_performing_id,cancellation_performing_id';	
										else if($table_name==ELECTRICALPERMITS)
											$fields='acceptance_performing_id,cancellation_issuing_id,acceptance_issuing_id,cancellation_performing_id,issuing_authority,performing_authority';
										else if($table_name==UTPUMPSPERMITS)
											$fields='acceptance_issuing_id,cancellation_issuing_id,cancellation_performing_id,acceptance_performing_id';
										break;												
			}

			$get_jobs_info=$this->public_model->get_data(array('table'=>$table_name,'select'=>$fields.',TIMESTAMPDIFF(HOUR,modified, "'.date('Y-m-d H:i').'") as time_diff,permit_no,id','where_condition'=>$where_job_status,'having'=>'time_diff>13'));

			${$table_name.'num_records'}=$get_jobs_info->num_rows();
			#echo 'Query '.$this->db->last_query(); exit;
			#echo '<pre>'; 
			if($get_jobs_info->num_rows()>0)			
				${$table_name.'_records'}=$get_jobs_info->result_array();

				#$key = array_search(215, array_column($records, 'acceptance_performing_id'));
					/*$acceptance_performing_id = array_keys(array_column($records, 'acceptance_performing_id'), 215);

					if(count($acceptance_performing_id)>0)
						$sms_users=$acceptance_performing_id;*/

			

			#${'jobsnum_records'}=0;
        }

        $arr = range('a', 'f');

        foreach($users as $user)
        {
        	$user_id=$user['id'];

        	$mobile_number=$user['mobile_number'];

        	$first_name=$user['first_name'];

        	#echo '<br /> User '.$user_id.' <br />';

        	#$permits=array(JOBS=>'Combined');

        	$permit_nos='';


        	foreach($permits as $table_name => $label)
        	{
        		$array_keys=$json_fields=array();
        		#echo '<br /> Total '.${$table_name.'num_records'};
        		if(${$table_name.'num_records'}>0)
        		{
        			$records = ${$table_name.'_records'};	

        			switch($table_name)
        			{
        				case EXCAVATIONPERMITS:	
									$fields=array('acceptance_issuing_id','acceptance_performing_id');
									$json_fields=array('dept_issuing_id');
									break;
						case CONFINEDPERMITS:
									$fields=array('acceptance_performing_id','acceptance_issuing_id','cancellation_issuing_id','acceptance_safety_sign_id','cancellation_performing_id');
									$json_fields=array('extended_issuing_from_authority','extended_issuing_to_authority','extended_performing_from_authority','extended_performing_to_authority','extended_safety_from_sign_id','extended_safety_to_sign_id');
									break;			
						case JOBS:
									$fields=array('acceptance_issuing_id','cancellation_issuing_id','acceptance_performing_id','cancellation_performing_id');
									$json_fields=array('issuing_authority','performing_authority');
									break;
						case UTPUMPSPERMITS:
									$fields=array('acceptance_issuing_id','cancellation_issuing_id','cancellation_performing_id','acceptance_performing_id');		
									break;	
						case ELECTRICALPERMITS:
									$fields=array('acceptance_issuing_id','cancellation_issuing_id','acceptance_performing_id','cancellation_performing_id');
									$json_fields=array('issuing_authority','performing_authority');
									break; 			
        			}
        			
        			$fields=array('acceptance_performing_id');
        			//Getting NON JSON Fields 
        			foreach($fields as $field)
        			{
        				$keys_exists = array_keys(array_column($records, $field), $user_id);
        				
						if(count($keys_exists)>0)
							$array_keys=array_merge($array_keys,$keys_exists);
					}		

					/*if(count($array_keys)>0)
					{
						echo '<br /> Keys matched ';print_r($array_keys); #exit;
						
					}*/

					if(count($json_fields)>0)
					{
						foreach($json_fields as $field)
						{
							foreach($records as $key => $record)
							{	
								if($record[$field]!='')
								{
									$json=json_decode($record[$field],true);

									#echo '<br /> Rtable '.$table_name;

									$json=array_filter($json, 'strlen');

									if(count($json)>0)
									{	
										$json=array_values($json);
										#print_r($record);print_r($json); #exit;
										
										$check_json_exists=array_search($user_id, $json);

										#echo '<br /> Check Json '.$check_json_exists;
										if(is_numeric($check_json_exists))
										$array_keys=array_merge($array_keys,array($key));	
										#print_r($array_keys); exit;
									}
								}	

							}

						}	
					}

					if(count($array_keys)>0)
					{
						$array_keys=array_unique($array_keys);

						sort($array_keys);

						foreach($array_keys as  $keys)
						{
							if($records[$keys]['time_diff']>PERMIT_CLOSE_AFTER)					
							{ #$records[$keys]['time_diff'] = PERMIT_CLOSE_AFTER;
							
							$time_diff=($records[$keys]['time_diff']-PERMIT_CLOSE_AFTER).' hrs';

							$permit_nos.=$records[$keys]['permit_no'].'('.$time_diff.' - '.$records[$keys]['time_diff'].')<br />';
							}
						}

        			}	
        		}	
        		
        		#echo '<br /> End ';	
        		
        	}

        	if($permit_nos!='')
        	{
        		$permit_nos=rtrim($permit_nos,',');


        		/*$arr=array('mobile_no'=>$mobile_number,'msg'=>$permit_nos,'created'=>date('Y-m-d H:i:s'));

        		$this->db->insert(SMS_SENT_INFO,$arr);

        		$this->public_model->send_sms(array('additional_text'=>$permit_nos,'msg_type'=>EXPIRED_JOB_SMS_TEXT,'mobile_number'=>$mobile_number));

        		#echo '<br />Txt '.$permit_nos.' - '.$mobile_number;*/

        		
        		echo '<br /> Permits '.$permit_nos.' = '.$user_id.'  = '.$first_name;; 
        	}
        }
		

        $permit_nos='';


		echo 'sms done';

        exit;
	}	

	public function index()
	{

		echo 'Yes';

		exit;
	}
	public function auto_close_nonextended_permits()
	{
		#SELECT DATEDIFF('2014-11-30','2014-11-29') AS DiffDate	
		
		#echo 'FF '.$_SERVER['DOCUMENT_ROOT'];

		$where='user_role IN("SA") AND status ="'.STATUS_ACTIVE.'"';	//Cancel or Complete
		
            $req=array(
              'select'  =>'id,first_name',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>USERS,
              'where_condition'=>($where)
            );
			
            $qry=$this->public_model->get_data($req)->row_array();
			
			$admin_id=$qry['id'];
			
			$admin_name=$qry['first_name'];

		
		$where='approval_status NOT IN(4,6) AND status !="'.STATUS_CLOSED.'"';	//Cancel or Complete
		
            $req=array(
              'select'  =>'*,TIMESTAMPDIFF(HOUR, modified, "'.date('Y-m-d H:i').'") as time_diff',#,DATEDIFF(NOW(),modified) AS DiffDate
              'table'    =>JOBS,
              'where_condition'=>($where),
			  'having'=>'time_diff>='.PERMIT_CLOSE_AFTER
            );
			
            $qry=$this->public_model->get_data($req);
			
			#echo $this->db->last_query(); exit;
			
			$nums=$qry->num_rows();
			
			if($nums>0)
			{
				$fets=$qry->result_array();	
				
				foreach($fets as $fet)
				{
					$permit_no=$fet['permit_no'];
					
					$job_id=$fet['id'];
					
					$approval_status=$fet['approval_status'];
					
					$status=strtolower($fet['status']);	
					
					$modified=date('d-m-Y H:i',strtotime($fet['modified']));
					
					$msg='<b>Auto closed</b> by system on '.date('d-m-Y H:i').'hrs. Last updated this permit on '.$modified;	
						
					$up="UPDATE ".JOBS." SET status='".STATUS_CLOSED."',modified='".date('Y-m-d H:i:s')."',approval_status=9 WHERE id='".$job_id."'";
					
					echo '<br /> Up : '.$up;
					
					$this->db->query($up);
					
					$array=array('user_id'=>$admin_id,'job_id'=>$job_id,'notes'=>$msg,'created'=>date('Y-m-d H:i'));
					
					$this->db->insert(JOBSHISTORY,$array);
				}
			}
			#echo $this->db->last_query(); 
		
	
	}
	
}