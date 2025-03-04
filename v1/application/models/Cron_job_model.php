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
		$permit_nos='';
		$where=(isset($where)) ? $where : '';
		$permits=unserialize(PERMITS);
		$where_job_status='';
		$job_status=STATUS_OPENED;
		$table_name=JOBS;
		$fields='acceptance_issuing_id,cancellation_issuing_id,acceptance_performing_id,cancellation_performing_id';	
		$where_job_status=' status NOT IN("'.STATUS_CLOSED.'","'.STATUS_CANCELLATION.'") AND (acceptance_issuing_id="'.$user_id.'" OR cancellation_issuing_id="'.$user_id.'" OR acceptance_performing_id="'.$user_id.'" OR cancellation_performing_id="'.$user_id.'")';

		$conditions=$where_job_status;

		$get_jobs_info=$this->public_model->get_data(array('table'=>$table_name,'select'=>$fields.',TIMESTAMPDIFF(HOUR,modified, "'.date('Y-m-d H:i').'") as time_diff,permit_no,id','where_condition'=>$conditions,'having'=>'time_diff>'.PERMIT_CLOSE_AFTER));

		#echo $this->db->last_query(); exit;

		$nums = $get_jobs_info->num_rows();

		if($nums>0)
		{
			$records = $get_jobs_info->result_array();

			foreach($records as $record):

				if($record['time_diff']>PERMIT_CLOSE_AFTER)					
				{ 
					$time_diff=($record['time_diff']-PERMIT_CLOSE_AFTER).' hrs ago';

					$permit_nos.=$record['permit_no'].'('.$time_diff.'),';
				}

			endforeach;
		}

		
		
		$permit_nos=rtrim($permit_nos,',');
		
        if($type=='single' && $permit_nos!='')
        {
        	$this->session->set_flashdata('failure','Please close/complete to the EXPIRED jobs permits '.$permit_nos);

        	redirect('jobs/');

        }
       # return array('status'=>YES,'permit_nos'=>$permit_nos);
	}
	
}