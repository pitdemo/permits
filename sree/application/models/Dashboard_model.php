<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : dashboard_model.php
 * Project        : PMS
 * Creation Date  : 06-14-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manage dashboard page datas
*********************************************************************************************/	
class Dashboard_model extends CI_Model
{
	public	function __construct()
	{
		parent::__construct();
		
        $notes='';
	}
    
	
	public function update_data($array_data)
	{
			extract($array_data);	

			$this->db->where('companies_id',$companies_id);	
			
			$set='';
			
			for($f=0;$f<count($field_name);$f++)
			{
				$set.=''.$field_name[$f].'='.$field_name[$f].''.$sign.$field_value[$f].',';
			}
			
			$set=rtrim($set,',');
			
			$this->db->query("UPDATE ".$this->db->dbprefix.DASHBOARD." SET ".$set." WHERE companies_id ='".$companies_id."'");

			if ($this->db->affected_rows() == 0)
			{
				$ins=array();
				
				for($f=0;$f<count($field_name);$f++)
				{
					$ins=array_merge($ins,array($field_name[$f]=>$field_value[$f]));
				}
			
				$insert=array_merge($ins,array('companies_id'=>$companies_id));
			
				$this->db->insert(DASHBOARD,$insert);
			}
			
			return;
		
	}

	public function update_counts($array_data)
	{
			$this->load->model(array('public_model'));
			
			extract($array_data);	
			
			$where_conditions="companies_id = '".$companies_id."'";
			
			$dashboard=$this->public_model->get_data(array('select'=>$select,'table'=>DASHBOARD,'where_condition'=>$where_conditions));
			
			if($dashboard->num_rows()==0)
			{
				$insert=array('companies_id'=>$companies_id);
			
				$this->db->insert(DASHBOARD,$insert);
				
				$dashboard_field='';
			}
			else
			{
				$dashboard_count=$dashboard->row_array();

				$dashboard_field=$dashboard_count[$select];
			}
			
				if($dashboard_field!='')
				{
					$field_count=unserialize($dashboard_field);			
				}
				else
				$field_count=array();
			
			//Update Values
			if(isset($add))
			{
				if(array_key_exists($add,$field_count))
				$field_count[$add]=$field_count[$add]+$add_value;	
				else
				$field_count[$add]=$add_value;
			}
			
			if(isset($sub))
			{
				$split_sub_fields=explode(',',$sub);
				
				#print_r($split_sub_fields);
				
				if(array_key_exists($split_sub_fields[0],$field_count))
				$field_count[$split_sub_fields[0]]=$field_count[$split_sub_fields[0]]-$sub_value;	
				else
				$field_count[$split_sub_fields[0]]=0;
				
				if(isset($split_sub_fields[1]))
				{
					if(array_key_exists($split_sub_fields[1],$field_count))
					$field_count[$split_sub_fields[1]]=$field_count[$split_sub_fields[1]]+$sub_value;	
					else
					$field_count[$split_sub_fields[1]]=$sub_value;
				
					if($field_count[$split_sub_fields[1]]<0)
					$field_count[$split_sub_fields[1]]=0;
				}
				
				if($field_count[$split_sub_fields[0]]<0)
				$field_count[$split_sub_fields[0]]=0;
				
			}
			
			#echo '<pre>'; print_r($field_count); exit;
			
			$this->db->where('companies_id',$companies_id);	
			
			$this->db->update(DASHBOARD,array($select=>serialize($field_count)));
			
			#echo $this->db->last_query(); exit;
			
			/*if ($this->db->affected_rows() == 0)
			{
				$ins=array();
				
				$ins=array_merge($ins,array($select=>serialize($field_count)));
			
				$insert=array_merge($ins,array('companies_id'=>$companies_id));
			
				$this->db->insert(DASHBOARD,$insert);
			}*/
			
			return;
		
	}
	
	function humanTiming ($time)
	{
	
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
	
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	
	}
}

