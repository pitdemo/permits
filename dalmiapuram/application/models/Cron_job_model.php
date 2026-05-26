<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Cron_job_model.php
 * Project        : Form Work
 * Creation Date  : 01-08-2018
 * Author         : Anantha Kumar RJ
*********************************************************************************************/	

class Cron_job_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('public_model'));
		
        $notes='';
	}
	
	public function check_expired_permits($array_args)
	{

		extract($array_args);

		$where=(isset($where)) ? $where : '';

		$where='user_role NOT IN("SA") AND status ="'.STATUS_ACTIVE.'" '.$where;	//Cancel or Complete
		
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

										$fields='acceptance_issuing_id,dept_issuing_id';
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
#$where_job_status.=' AND user_id=499';
			$get_jobs_info=$this->public_model->get_data(array('table'=>$table_name,'select'=>$fields.',TIMESTAMPDIFF(HOUR,modified, "'.date('Y-m-d H:i').'") as time_diff,permit_no,id','where_condition'=>$where_job_status,'having'=>'time_diff>'.PERMIT_CLOSE_AFTER));

			${$table_name.'num_records'}=$get_jobs_info->num_rows();
			#echo 'Query<br> '.$this->db->last_query(); #exit;
			#echo '<pre>'; 
			if($get_jobs_info->num_rows()>0)			
				${$table_name.'_records'}=$get_jobs_info->result_array();
        }

        $arr = range('a', 'f');

        foreach($users as $user)
        {
        	$emp=array();

        	$user_id=$user['id'];

        	$mobile_number=$user['mobile_number'];

        	$first_name=$user['first_name'];
        	
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
									$fields=array('acceptance_issuing_id');
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
							
								$time_diff=($records[$keys]['time_diff']-PERMIT_CLOSE_AFTER).' hrs ago';

								$permit_nos.=$records[$keys]['permit_no'].'('.$time_diff.'),';

								$emp=array_merge($emp,array("'".$records[$keys]['permit_no']."'"));
							}
						}

        			}	
        		}	
        	}

        	
        }


        $where_job_status='approval_status NOT IN(11,12) AND remarks_performing_id="'.$user_id.'"';

        $get_jobs_info=$this->public_model->get_data(array('table'=>JOBSISOLATION,'select'=>'eip_no,TIMESTAMPDIFF(DAY,date_start, "'.date('Y-m-d H:i').'") as time_diff,id','where_condition'=>$where_job_status,'having'=>'time_diff>15'));

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

				;

				
			}	


			if($permit_nos!='')
        	{
        		$permit_nos=rtrim($permit_nos,',');

        		$permit_nos=ltrim($permit_nos,',');
        	}

        if($type=='single' && $permit_nos!='')
        {
        	$this->session->set_flashdata('failure','Please close/complete to the EXPIRED jobs permits '.$permit_nos);

        	redirect('jobs/show_all');

        }
       # return array('status'=>YES,'permit_nos'=>$permit_nos);
	}
	
}