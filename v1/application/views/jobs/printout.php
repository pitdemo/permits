<?php
#error_reporting(0);

$hrs=' HRS';

 if(!empty($records))
 {	 
	 $record_id=$records['id'];
	 
	 $acceptance_performing_id=$records['acceptance_performing_id'];
	 
	 $acceptance_issuing_id=$records['acceptance_issuing_id'];

 }
 else
 $record_id=''; 
 
 $checked='checked="checked"';
 
 $select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';
 
 $zone_name='';
 
	$zones=$zones->result_array();

    foreach($zones as $list)
	{  
		if($select_zone_id==$list['id']) 
		{
			$zone_name=$list['name'];
			
			break;	
		}
	
	}

function get_authorities($authority_id,$authorities)
{
	$acceptance_issuing_name='';

	foreach($authorities as $fet)
	{
	$role=$fet['user_role'];
	
	$id=$fet['id'];
	
	$first_name=strtoupper($fet['first_name']);     

	if($authority_id==$id)
		{ $acceptance_issuing_name=$first_name; break; }

	}
	return $acceptance_issuing_name;
}

function checkbox($array_args)
{		
	extract($array_args);
	
	$style=(isset($style)) ? 'style="'.$style.'"' : '';	
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />&nbsp;';
}

function generate_isolations($isolations,$isolate_type='')
{
	$name = '';
	foreach($isolations as $fet)
	{
		$record_type=$fet['record_type'];
										
		$id=$fet['id'];
		
		$name=$fet['name'];
		
		$chk='';
		
		if($record_type=='isolation_type')
		{
			if($isolate_type==$id) 
			break;
		}	
	}

	return $name;
}

function generate_department($departments,$department_id='')
{
	$name = '';
	foreach($departments as $fet)
	{						
		$id=$fet['id'];
		
		$name=$fet['name'];
		
		$chk='';
		 
		if($department_id==$id) 
		break;
		 
	}

	return $name;
}

$checkbox = checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;'));

$table='';

$location=(isset($records['location'])) ? strtoupper($records['location']) : '';

$location_time_start=(isset($records['location_time_start'])) ?  $records['location_time_start'].$hrs : '';	

$location_time_to=(isset($records['location_time_to'])) ?  $records['location_time_to'].$hrs  : '';	

#echo '<pre>'; print_r($records); print_r($precautions); exit;


 $select_contractor_id=(isset($records['contractor_id'])) ? explode(',',$records['contractor_id']) : array();	
	  
 $contractor_name='';	  
 
   $contractors=$contractors->result_array();
 
   foreach($contractors as $list)
   {
	   if(in_array($list['id'],$select_contractor_id)) { $contractor_name.=strtoupper($list['name']).','; } 
   }

   $contractor_name=rtrim($contractor_name,',');

 $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';

 $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

 $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';


 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $td_border="border: 1px solid #000000;padding-left:5px;";

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
   
	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Dalmia Cement (B) Ltd - Ariyalur</h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr></table>';

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';



   $subcontractor = (isset($records['contractor_id'])) ? strtoupper($records["sub_contractor"]) : '';

    $table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr>
		<td align="left" width="15%" style="'.$td_border.'"><b>Department :</b><br/>'.strtoupper($department['name']).'</td>
		<td align="left"  width="15%"   style="'.$td_border.'"><b>Section : </b><br/>'.strtoupper($zone_name).'</td>
		<td align="left"  width="15%"  style="'.$td_border.'"><b>Start Date : </b><br/>'.$location_time_start.'</td>
		<td style="'.$td_border.'"  width="15%" ><b>End Date : </b><br/>'.$location_time_to.'</td>
    	<td align="left"  style="'.$td_border.'"   colspan="2"><b>Contractor: </b><br/>'.$contractor_name.'</td>
    	</tr>';

	$acceptance_performing_name = (isset($records['acceptance_performing_name'])) ? strtoupper($records["acceptance_performing_name"]) : '';
	$acceptance_performing_date = (isset($records['acceptance_performing_date'])) ? strtoupper($records["acceptance_performing_date"]) : '';
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>A) To be filled by Permit Initiator :</b></td>
		<td align="left"   style="'.$td_border.'" colspan="3"><b>Initiator Name & Signature : </b>'.$acceptance_performing_name.' '.$acceptance_performing_date.$hrs.'</td>
		</tr>';
	
	$td_length = count($permits);

	$permit_types = (isset($records['permit_type'])) ? json_decode($records["permit_type"],true) : array();

	$table.='<tr>';
		$p=1; $cl=0;
		foreach($permits as $list):
			$cl++;
			$cl_span='';

			if($cl==$td_length)
			{
				$cl_span=(6-$p)+1;
			}

			$checkbox = (in_array($list['id'],$permit_types)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
			
			$table.='<td align="left" colspan="'.$cl_span.'" style="'.$td_border.'">'.$checkbox.$list['name'].'</td>';
			if($p==6){
				$table.='</tr><tr>';
				$p=0;
			}
			$p++;
		endforeach;
	
	$job_name = (isset($records['job_name'])) ? strtoupper($records["job_name"]) : '';

	$location = (isset($records['location'])) ? strtoupper($records["location"]) : '';

	$no_of_workers = (isset($records['no_of_workers'])) ? strtoupper($records["no_of_workers"]) : '';

	$wi=(isset($records['wi'])) ? $records["wi"] : '';

	$sop=(isset($records['sop'])) ? $records["sop"] : '';

	$other_inputs=(isset($records['other_inputs'])) ? json_decode($records['other_inputs'],true) : array();

	if($sop!='' || in_array('SOP',$other_inputs))
	$checkbox=checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;'));
	else 
	$checkbox=checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.' SOP </td>';


	if($wi!='' || in_array('WI',$other_inputs))
	$checkbox=checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;'));
	else 
	$checkbox=checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

	$wi_notes=(isset($records['wi_notes']) && $records['wi_notes']!='') ? ' - '.strtoupper($records['wi_notes']) : '';

	$table.='<td align="left"   style="'.$td_border.'" colspan="3">'.$checkbox.' Work instructions clearly explained to the all the members in the working Group '.$wi_notes.'</td>
	</tr>';

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>Work Description :</b> '.$job_name.'</td>
		<td align="left"   style="'.$td_border.'" colspan="3"><b>Location : </b>'.$location.'</td>
	</tr>';

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>Checkpoints for Permit Initiator</b></td>
		<td align="left"  style="'.$td_border.'" colspan="2"  width="15%" ><b>Sub Contractor:</b><br/> '.$subcontractor.'</td><td align="left" style="'.$td_border.'"><b>No of Workers: </b>'.$no_of_workers.'</td>
	</tr>';

	$checkpoints=unserialize(CHECKPOINTS);

	$td_length = count($checkpoints);

	//Colspan
	$td_cl_span=array(1=>1,2=>2,3=>2,4=>1);

	$cl=0;

	$checkpoints_data = (isset($records['checkpoints'])) ? json_decode($records["checkpoints"],true) : array();

	$table.='<tr>';
		foreach($checkpoints as $key => $label):
			$cl++;
			$cl_span=$td_cl_span[$key];

			if($cl==$td_length)
			{
				//$cl_span=(6-$key)+1;
			}

			$checkbox = (in_array($key,$checkpoints_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" colspan="'.$cl_span.'" style="'.$td_border.'">'.$checkbox.$label.'</td>';
		endforeach;
	$table.='</tr>';
	
	//Excavations
	if(in_array(9,$permit_types))
	{
		//Clearance
		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="6"><b>Clearance required from other Departments</b></td>
		</tr>';

		$clerance_department_user_id=(isset($records['clerance_department_user_id'])) ? json_decode($records['clerance_department_user_id'],true) : array();

		$clearance_department_dates=(isset($records['clearance_department_dates'])) ? json_decode($records['clearance_department_dates'],true) : array();

		
		$table.='<tr>';

		$td_cl_span=array(1=>1,2=>1,3=>2,4=>1,5=>1);

		$key=1;

		foreach($clearance_departments as $list):

			$cl_span=$td_cl_span[$key];

			$name=$date='';

			$department_user_id = isset($clerance_department_user_id[$list['id']]) && $clerance_department_user_id[$list['id']]!='' ? $clerance_department_user_id[$list['id']] : '';

			$clearance_department_date = isset($clearance_department_dates[$list['id']]) && $clearance_department_dates[$list['id']]!='' ? $clearance_department_dates[$list['id']].'HRS' : '';

			$checkbox=checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			if($department_user_id!='')
			{
				$checkbox=checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;'));

				$name = strtoupper(get_authorities($department_user_id,$allusers));

				$name='<br /><b>Name:</b>'.$name.' <br /><b>Sign:</b> '.$clearance_department_date;
			}

			$table.='<td align="left" style="'.$td_border.'" colspan="'.$cl_span.'">'.$checkbox.' '.$list['name'].' '.$name.'</td>';

			$key++;

		endforeach;

		$table.='</tr>';
	}
	

	$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

	$acceptance_issuing_name='';

	
	if($acceptance_issuing_id!='')
	{
		$acceptance_issuing_name = strtoupper(get_authorities($acceptance_issuing_id,$allusers));

	}
	$acceptance_issuing_date=(isset($records['acceptance_issuing_date']) && $records['acceptance_issuing_date']!='') ? ' <b>Sign:</b>'.date('d-m-Y H:i',strtotime($records['acceptance_issuing_date'])).$hrs : ''; 

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>B) Issuer:</b> I have checked that all conditions are met to carry out the job safety.</td>
		<td align="left" style="'.$td_border.'" colspan="3"><b>Name of the Issuer:</b> '.$acceptance_issuing_name.' '.$acceptance_issuing_date.'</td>
	</tr>';

	//Loto
	if(in_array(8,$permit_types))
	{
		$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions']) : array();

		$equipment_tag_nos=(isset($job_isolations['equipment_tag_nos'])) ? json_decode($job_isolations['equipment_tag_nos']) : array();

		$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types']) : array();

		$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1']) : array();

		$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2']) : array();

		$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_user_ids=(isset($job_isolations['isolated_user_ids'])) ? json_decode($job_isolations['isolated_user_ids']) : array();

		$isolated_name_approval_datetimes = (isset($job_isolations['isolated_name_approval_datetime'])) ? json_decode($job_isolations['isolated_name_approval_datetime']) : array();

		$isolated_ia_names=(isset($job_isolations['isolated_ia_name'])) ? json_decode($job_isolations['isolated_ia_name']) : array();



		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="3"><b>C) To be filled by Permit Initiator and checked by issuer</b> </td>
			<td align="left" style="'.$td_border.'" colspan="3"><b>D) To be filled by authorized isolator who is carrying out isolations</b></td>
		</tr>';

		

		$table.='<tr>
		<td align="left"   style="'.$td_border.'"><b>Eq. Tag No</b></td>
		<td align="left" style="'.$td_border.'"><b>Isolation Type</b></td>
		<td style="'.$td_border.'"><b>PA LOCK & TAG No</b></td>
    	<td align="left"  style="'.$td_border.'"><b>LOCK No</b></td>
		<td align="left"  style="'.$td_border.'"><b>Isolator Name  & Sign Date</b></td>
		<td align="left"  style="'.$td_border.'"><b>Sign Date</b></td>
    	</tr>';
	
		foreach($equipment_tag_nos as $i => $value)
		{
			if($value!='')
			{

				$type_isolation=(isset($isolate_types->$i)) ? $isolate_types->$i : '';

				$isolated_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';

				$isolated_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';

				$isolated_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';

				$isolation_type_user_id=(isset($isolated_user_ids->$i)) ? $isolated_user_ids->$i : '';

				$isolation_type_user_name = strtoupper(get_authorities($isolation_type_user_id,$allusers));

				$isolated_ia_name=(isset($isolated_ia_names->$i)) ? $isolated_ia_names->$i : '';

				$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes->$i)) ? $isolated_name_approval_datetimes->$i.$hrs : '';

				$type_of_isolation=strtoupper(generate_isolations($isolations,$type_isolation));

				if($isolated_ia_name!=''){
					$isolated_ia_name=generate_department($departments,$isolated_ia_name);
				}

				$table.='<tr>
				<td align="left" style="'.$td_border.'">'.strtoupper($value).'</td>
				<td align="left"   style="'.$td_border.'">'.$type_of_isolation.'</td>
				<td align="left" style="'.$td_border.'">'.$isolated_tag1.' & '.$isolated_tag2.'</td>
				<td style="'.$td_border.'">'.$isolated_tag3.'</td>
				<td align="left"  style="'.$td_border.'">'.$isolation_type_user_name.'</td>
				<td align="left"  style="'.$td_border.'">'.$isolated_name_approval_datetime.' </td>
				</tr>';
			}
			
		}

		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="6"><b>E) To be filled & ensure by issuer</b></td>
		</tr>';

		$ensured_items = array(1=>'Are all required equipments identified and stopped?',2=>'Are precedings & followings equipment also stopped?',3=>'Is try out done as per LOTO matrix from CCR?',4=>'Are all equipments emptied out/material removed?');

		$acceptance_loto_issuing_id=(isset($job_isolations['acceptance_loto_issuing_id']) && $job_isolations['acceptance_loto_issuing_id']!='') ? $job_isolations['acceptance_loto_issuing_id'] : '';

		$acceptance_loto_issuing_date=(isset($job_isolations['acceptance_loto_issuing_date'])) ? $job_isolations['acceptance_loto_issuing_date'].'HRS' : '';

		$issuer_ensured_items=(isset($job_isolations['issuer_ensured_items']) && $job_isolations['issuer_ensured_items']!='') ? json_decode($job_isolations['issuer_ensured_items'],true) : array();

		$acceptance_loto_issuing_name='';

		if(!!$acceptance_loto_issuing_id)
		$acceptance_loto_issuing_name = get_authorities($acceptance_loto_issuing_id,$allusers);

		foreach($ensured_items as $key => $label):

			$checked=(in_array($key.'y',$issuer_ensured_items)) ? 'checked' : '';

			$checkbox=checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			if($checked!='')
			$checkbox=checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;'));

			if($key==1)
			{
				$table.='<tr><td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.' '.$label.'</td><td  align="left"  style="'.$td_border.'vertical-align:top;" colspan="3" rowspan="4">
				I have ensure that all isolation mentioned in clause no C&D are completed clearance is given to start the job <br />
				<b>Name of the Issuer :  '.$acceptance_loto_issuing_name.'<br /><br />
				Date & Time: '.$acceptance_loto_issuing_date.'</b>
				</td></tr>';
			} else 
			{
			$table.='<tr><td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.' '.$label.' </td></tr>';
			}

		endforeach;

		 $pa_equip_identified=(isset($job_isolations['pa_equip_identified']) && $job_isolations['pa_equip_identified']!='') ?  json_decode($job_isolations['pa_equip_identified'],true) : array();

		 $acceptance_loto_pa_date=(isset($job_isolations['acceptance_loto_pa_date']) && $job_isolations['acceptance_loto_pa_date']!='') ? $job_isolations['acceptance_loto_pa_date'].'HRS' : '';

		 $acceptance_loto_pa_id=(isset($job_isolations['acceptance_loto_pa_id'])) ? $job_isolations['acceptance_loto_pa_id'] : '';

		 $acceptance_loto_pa_name='';

		 if($acceptance_loto_pa_id!='')
		 	$acceptance_loto_pa_name=get_authorities($acceptance_loto_pa_id,$allusers);

		 $checkbox=checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
         $checked=(in_array(1,$pa_equip_identified)) ? 'checked' : '';
		 
		 if($checked!='')
			$checkbox=checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;'));
	
		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="3"><b>F) To be filled & ensured by Initiator &nbsp;&nbsp;'.$checkbox.' Are all required equipments identified and stopped? <br />Name & sign of Initiator: '.$acceptance_loto_pa_name.' Date&Time : '.$acceptance_loto_pa_date.'</b></td>
			<td align="left" style="'.$td_border.'" colspan="3"><b>G) I am briefed & understood all potential hazard involved in that activity<br />Name & sign of Co-permittee :              Date&Time : </b></td>
		</tr>';
	}

	//Renewal
	if(isset($jobs_extends) && count($jobs_extends)>0)
	{
			$table.='<tr>
				<td align="left" style="'.$td_border.'" colspan="6"><b>H)Renewal of Permit to Work</b></td>
			</tr>';

			$table.='<tr>
				<td align="left" style="'.$td_border.'" colspan="6" width="100%"><table align="left" width="1144px" style="font-family:Arial, Helvetica, sans-serif;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;" >';

			$table.='<tr>
				<td align="left" style="'.$td_border.'" width="10%">From Date</td>
				<td align="left" style="'.$td_border.'" width="10%">To Date</td>
				<td align="left"   style="'.$td_border.'" width="10%">Initiator</td>
				<td align="left" style="'.$td_border.'" width="10%">Issuer</td>
				<td style="'.$td_border.'" width="10%">No.of Persons</td>
				<td style="'.$td_border.'" width="10%">Co-permitte</td>';
				
				//Confined
				if(in_array(7,$permit_types)) 
				$table.='<td style="'.$td_border.'" width="10%">%  of  Oxygen level 19.5  to  23.5  %</td>
				<td style="'.$td_border.'" width="10%">Combustible gases 0  %</td>
				<td style="'.$td_border.'" width="10%">Carbon Monoxide 0-25  ppm</td>';

				$table.='<td align="left"  style="'.$td_border.'" width="10%">Reference Code</td>
				</tr>';

				$schedule_from_dates=(isset($jobs_extends['schedule_from_dates']) && $jobs_extends['schedule_from_dates']!='') ? json_decode($jobs_extends['schedule_from_dates'],true) : array();

				$schedule_to_dates=(isset($jobs_extends['schedule_to_dates']) && $jobs_extends['schedule_to_dates']!='') ? json_decode($jobs_extends['schedule_to_dates'],true) : array();

				$ext_performing_authorities=(isset($jobs_extends['ext_performing_authorities']) && $jobs_extends['ext_performing_authorities']!='') ? json_decode($jobs_extends['ext_performing_authorities'],true) : array();

				$ext_issuing_authorities=(isset($jobs_extends['ext_issuing_authorities']) && $jobs_extends['ext_issuing_authorities']!='') ? json_decode($jobs_extends['ext_issuing_authorities'],true) : array();

				$ext_issuing_authorities_dates=(isset($jobs_extends['ext_issuing_authorities_dates']) && $jobs_extends['ext_issuing_authorities_dates']!='') ? json_decode($jobs_extends['ext_issuing_authorities_dates'],true) : array();

				$ext_performing_authorities_dates=(isset($jobs_extends['ext_performing_authorities_dates']) && $jobs_extends['ext_performing_authorities_dates']!='') ? json_decode($jobs_extends['ext_performing_authorities_dates'],true) : array();			

				$ext_contractors=(isset($jobs_extends['ext_contractors']) && $jobs_extends['ext_contractors']!='') ? json_decode($jobs_extends['ext_contractors'],true) : array();

				$ext_no_of_workers=(isset($jobs_extends['ext_no_of_workers']) && $jobs_extends['ext_no_of_workers']!='') ? json_decode($jobs_extends['ext_no_of_workers'],true) : array();

				$ext_oxygen_readings=(isset($jobs_extends['ext_oxygen_readings']) && $jobs_extends['ext_oxygen_readings']!='') ? json_decode($jobs_extends['ext_oxygen_readings'],true) : array();

				$ext_gases_readings=(isset($jobs_extends['ext_gases_readings']) && $jobs_extends['ext_gases_readings']!='') ? json_decode($jobs_extends['ext_gases_readings'],true) : array();

				$ext_carbon_readings=(isset($jobs_extends['ext_carbon_readings']) && $jobs_extends['ext_carbon_readings']!='') ? json_decode($jobs_extends['ext_carbon_readings'],true) : array();

				$ext_reference_codes=(isset($jobs_extends['ext_reference_codes']) && $jobs_extends['ext_reference_codes']!='') ? json_decode($jobs_extends['ext_reference_codes'],true) : array();
				#$contractors=$contractors->result_array();
				for($c=1;$c<=6;$c++)
				{
					$schedule_from_date=(isset($schedule_from_dates[$c]) && $schedule_from_dates[$c]!='') ? $schedule_from_dates[$c] : '';
					if($schedule_from_date!='') 
					{

						$schedule_to_date=(isset($schedule_to_dates[$c]) && $schedule_to_dates[$c]!='') ? $schedule_to_dates[$c] : '';
						$ext_performing_authoritie=(isset($ext_performing_authorities[$c]) && $ext_performing_authorities[$c]!='') ? strtoupper(get_authorities($ext_performing_authorities[$c],$allusers)) : '';
						$ext_performing_authorities_date=(isset($ext_performing_authorities_dates[$c]) && $ext_performing_authorities_dates[$c]!='') ? $ext_performing_authorities_dates[$c].$hrs : '';
						$ext_issuing_authoritie=(isset($ext_issuing_authorities[$c]) && $ext_issuing_authorities[$c]!='') ? strtoupper(get_authorities($ext_issuing_authorities[$c],$allusers)) : '';
						$ext_issuing_authorities_date=(isset($ext_issuing_authorities_dates[$c]) && $ext_issuing_authorities_dates[$c]!='') ? $ext_issuing_authorities_dates[$c].$hrs : '';

						$ext_oxygen_reading=(isset($ext_oxygen_readings[$c]) && $ext_oxygen_readings[$c]!='') ? $ext_oxygen_readings[$c] : '';
						$ext_gases_reading=(isset($ext_gases_readings[$c]) && $ext_gases_readings[$c]!='') ? $ext_gases_readings[$c] : '';
						$ext_carbon_reading=(isset($ext_carbon_readings[$c]) && $ext_carbon_readings[$c]!='') ? $ext_carbon_readings[$c] : '';
						$ext_reference_code=(isset($ext_reference_codes[$c]) && $ext_reference_codes[$c]!='') ? $ext_reference_codes[$c] : '';

						$ext_no_of_worker=(isset($ext_no_of_workers[$c]) && $ext_no_of_workers[$c]!='') ? $ext_no_of_workers[$c] : '';

						$table.='<tr>
						<td align="left" style="'.$td_border.'">'.$schedule_from_date.'</td>
						<td align="left" style="'.$td_border.'">'.$schedule_to_date.'</td>
						<td align="left" style="'.$td_border.'">'.$ext_performing_authoritie.' <br />'.$ext_performing_authorities_date.'</td>
						<td align="left" style="'.$td_border.'">'.$ext_issuing_authoritie.' <br />'.$ext_issuing_authorities_date.'</td>
						<td style="'.$td_border.'">'.$ext_no_of_worker.'</td>
						<td style="'.$td_border.'">&nbsp;</td>';

						if(in_array(7,$permit_types)) 
						$table.='<td style="'.$td_border.'">'.$ext_oxygen_reading.'</td>
						<td style="'.$td_border.'">'.$ext_gases_reading.'</td>
						<td style="'.$td_border.'">'.$ext_carbon_reading.'</td>';

						$table.='<td style="'.$td_border.'">'.$ext_reference_code.'</td>
						</tr>';
					}
					
				}

				$table.='</table></td></tr>';
	}
	

	/* $table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="2">1) The job is completed, all men & material removed from site. Safe to remove isolations as stated clause. A&C <br /><br />Permit Initiator Name & Sign
		</td>
		<td align="left"   style="'.$td_border.'">2) Please remove isolations as stated clause. A&C <br /><br />Issuer Name & Sign
</td>
		<td align="left" style="'.$td_border.'">3) I have removed all isolation as listed clause. <br /><br />Issuer Name & Sign</td>
		<td style="'.$td_border.'">4) All isolations as per clause. A&C are restored. Equipment ready to start. <br /><br />Issuer Name & Sign</td>
    	<td align="left"  style="'.$td_border.'" >5) 1st of permit received for record purpose <br /><br />Issuer Name & Sign</td>
    </tr>';*/
	$table.='</table>';	


	$table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;">';
	//Mandatory measures to be taken for all type of works
    	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top"><table align="center" width="100%"  ><tr><td align="center" colspan="5"><b>PRECAUTIONS TAKEN AND EQUIPMENT PROVIDED TO PROTECT PERSONNEL FROM ACCIDENT OR INJURY.</b></td></tr>';
	$table.='</table></td></tr></table>';

	$precautions_data=(isset($precautions['precautions_mandatory'])) ? json_decode($precautions['precautions_mandatory'],true) : array();

	$table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;">';
	//Mandatory measures to be taken for all type of works
    $table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" "colspan="5><b>Mandatory measures to be taken for all type of works:</b></td></tr>';

	$checkbox = (isset($precautions_data[1]) && $precautions_data[1]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Required usages of PPEs (Safety Helmet, Safety Shoes)</td>';

	$checkbox = (isset($precautions_data[2]) && $precautions_data[2]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Enclose the list of persons carried out the job.</td>';

	$checkbox = (isset($precautions_data[3]) && $precautions_data[3]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Five Minutes Safety Talk conducted (record to be maintained)</td>';

	$checkbox = (isset($precautions_data[4]) && $precautions_data[4]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Equipment/work area inspected.</td></tr>';

	$checkbox = (isset($precautions_data[5]) && $precautions_data[5]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Equipment electrically isolated. If YES, line clearance Permit No:</td>';

	$checkbox = (isset($precautions_data[6]) && $precautions_data[6]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left"  style="'.$valign.$td_border.'">'.$checkbox.'Portable Fire Fighting system readiness.</td>';

	$checkbox = (isset($precautions_data[7]) && $precautions_data[7]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left"  style="'.$valign.$td_border.'">'.$checkbox.'Tools & Tackles Checked</td>';
	
	$checkbox = (isset($precautions_data[8]) && $precautions_data[8]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$td_border.'">'.$checkbox.'The place of work is made accessible and proper aggress.</td></tr>';

	$checkbox = (isset($precautions_data[9]) && $precautions_data[9]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" style="'.$td_border.'">'.$checkbox.'Barricading and cordoning of the area.</td>';

	$checkbox = (isset($precautions_data[10]) && $precautions_data[10]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" colspan="2"  style="'.$td_border.'">'.$checkbox.'Loose dresses are to be avoided or tight properly while working near conveyors or rotating equipment’s.</td>';

	$checkbox = (isset($precautions_data[11]) && $precautions_data[11]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left"  style="'.$td_border.'">'.$checkbox.'Sufficient safe lighting facility provided.</td></tr>';
	
	$checkbox = (isset($precautions_data[12]) && $precautions_data[12]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" colspan="2"  style="'.$td_border.'">'.$checkbox.'Deputed Skilled Supervisor</td>';
	
	$additional_info =  (isset($precautions['precautions_mandatory_additional_info'])) ? strtoupper($precautions["precautions_mandatory_additional_info"]) : '';

	$table.='<td align="left" colspan="3" style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';


	$checkbox = (isset($precautions_data[13]) && $precautions_data[13]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" colspan="5" style="'.$valign.$td_border.'">'.$checkbox.'Safety shoes & Helmet,Eye protection';
		
	$checkbox = (isset($precautions_data[14]) && $precautions_data[14]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Hand gloves';
	$checkbox = (isset($precautions_data[15]) && $precautions_data[15]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Apron';
	$checkbox = (isset($precautions_data[16]) && $precautions_data[16]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Hand Sleeves';
	$checkbox = (isset($precautions_data[17]) && $precautions_data[17]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leg Guard';
	$checkbox = (isset($precautions_data[18]) && $precautions_data[18]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Welding Goggles for Helper';
	$checkbox =(isset($precautions_data[19]) && $precautions_data[19]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Nose Mask';
	$table.='</td></tr>';






	$table.='</table></td></tr>';

	//Hot Work (Welding, Grinding, Cutting):
	if(in_array(3,$permit_types))
	{
		$precautions_data=(isset($precautions['hotworks'])) ? json_decode($precautions['hotworks'],true) : array();

		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Hot Work (Welding, Grinding, Cutting):</td></tr>';

		$checkbox = (isset($precautions_data[1]) && $precautions_data[1]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Flammables / Combustibles/ Explosive material removed / protected. (> 35ft.)</td>';

		$checkbox = (isset($precautions_data[2]) && $precautions_data[2]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Fire Watch Established</td><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Welding & Cutting equipment positioned properly</td>';

		$checkbox = (isset($precautions_data[3]) && $precautions_data[3]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Leads up and do not pose a tripping hazard</td><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Area hazards reviewed</td></tr>';
		
		$checkbox = (isset($precautions_data[4]) && $precautions_data[4]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Electrical connections through ELCB/RCCB of 30 mA sensitivity</td>';

		$checkbox = (isset($precautions_data[5]) && $precautions_data[5]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Electrical equipment’s are free from damage and earthed properly</td>';

		$checkbox = (isset($precautions_data[6]) && $precautions_data[6]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2" style="'.$valign.$td_border.'">'.$checkbox.'Performer/s are competent and equipped with appropriate PPEs i.e. including face shield/welding goggles/ apron, safety shoes etc.</td>';

		$checkbox = (isset($precautions_data[7]) && $precautions_data[7]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'No tampering / manipulation attempted in safety device of the equipment’s</td></tr>';

		$checkbox = (isset($precautions_data[8]) && $precautions_data[8]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left"  style="'.$valign.$td_border.'">'.$checkbox.'Only industrial type electrical appliances are in use</td>';

		$checkbox = (isset($precautions_data[9]) && $precautions_data[9]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Cables / fuses are of adequate size & capacity fit with the requirement</td>';

		$checkbox = (isset($precautions_data[18]) && $precautions_data[18]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2" style="'.$valign.$td_border.'">'.$checkbox.'No cable joint within 1 Mtr. from the holder / grinding machine and completely insulated from with M/C body</td>';

		$checkbox = (isset($precautions_data[19]) && $precautions_data[19]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Gas cylinders used: Oxygen / Industrial LPG / Dissolved Acetylene</td></tr>';


		$checkbox = (isset($precautions_data[20]) && $precautions_data[20]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" colspan="2" style="'.$valign.$td_border.'">'.$checkbox.'Gas cutting torch of reputed make, ISI marked, installed with Back Fire and Flash back arrestors are in use at both ends</td>';

		$checkbox = (isset($precautions_data[21]) && $precautions_data[21]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Hoses are free from damage and connected with hose clamp</td><td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Regulator pressure gauges in working condition, visible and not damaged</td></tr>';

		$checkbox = (isset($precautions_data[22]) && $precautions_data[22]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Welding cable and earthing cable are crimped with proper size lugs.</td></tr><tr><td align="left"  style="'.$valign.$td_border.'" colspan="2">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';

		$checkbox = (isset($precautions_data[10]) && $precautions_data[10]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Area wet down</td>';
		
		$checkbox = (isset($precautions_data[11]) && $precautions_data[11]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Spark shields installed</td>';
		$checkbox = (isset($precautions_data[12]) && $precautions_data[12]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td  style="'.$valign.$td_border.'">'.$checkbox.'Fire blanket</td></tr>'; 


		$table.='<tr><td align="left" colspan="5" style="'.$valign.$td_border.'"><i>Fire Fighting arrangements provided:</i></td></tr>';
		
		$checkbox = (isset($precautions_data[13]) && $precautions_data[13]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="padding-left:10px;'.$valign.$td_border.'">'.$checkbox.'CO2</td>';
		
		$checkbox = (isset($precautions_data[14]) && $precautions_data[14]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left"  style="'.$valign.$td_border.'">'.$checkbox.'Dry Chemical Powder</td>';

		$checkbox = (isset($precautions_data[15]) && $precautions_data[15]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'ABC</td>';

		$checkbox = (isset($precautions_data[16]) && $precautions_data[16]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Fire Tender</td>';

		$checkbox = (isset($precautions_data[17]) && $precautions_data[17]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.'Fire hose connected to hydrant </td></tr>';		

		$additional_info =  (isset($precautions['precautions_hotworks_additional_info'])) ? strtoupper($precautions["precautions_hotworks_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5" style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>'; 
	}


	//Material lowering & lifting:
	if(in_array(10,$permit_types))
	{
		$precautions_data=(isset($precautions['materials'])) ? json_decode($precautions['materials'],true) : array();

		$labels=array(1=>'Safety devices of the lifting appliances are inspected before use',2=>'Operator qualified and medically fit including eye sight examined by authority',3=>'Lifting appliances are certified by competent authority and labeled properly.',4=>'Hoist chain or hoist rope free of kinks or twists and not wrapped around the load.',5=>'Lifting Hook has a Safety Hook Latch that will prevent the rope from slipping out.',6=>'Lifting gears operator been instructed not to leave the load suspended',7=>'Electrical equipment’s are free from damage and earthed properly','8'=>'Electrical power line clearance (12ft) checked',9=>'Signal man identified','10'=>'Outriggers supported, Crane leveled','11'=>'SLI/ Load chart available in the crane','12'=>'Barrier Installed','13'=>'Riggers are competent',14=>'Slings are inspected for free from cut marks, pressing, denting, bird caging, twist, kinks or core protrusion prior to use.',15=>'Slings mechanically spliced (Hand spliced slings may not be allowed)',16=>'D / Bow shackles are free from any crack, dent, distortion or weld mark, wear / tear',17=>'Special lift as per erection / lift plan',18=>'Job Hazards is explained to all concern thru tool box talk meeting',19=>'Guide rope is provided while shifting / lifting/lowering the load.',20=>'Daily inspection checklist followed and maintained for crane',21=>'SWL displayed',22=>'Wind velocity < 36 KMPH, No rain');
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Material lowering & lifting:</b></td></tr>';

		$table.='<tr>';

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr><tr>'; }

		endforeach;

		#$table.=rtrim($table,'</tr><tr>');

		$additional_info =  (isset($precautions['precautions_material_additional_info'])) ? strtoupper($precautions["precautions_material_additional_info"]) : '';

		$table.='<td align="left" colspan="3"  style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td>';

		$table.='</tr>';


		$table.='</table></td></tr>'; 
	}

	//Electrical Work:
	if(in_array(2,$permit_types))
	{
		$precautions_data=(isset($precautions['electrical'])) ? json_decode($precautions['electrical'],true) : array();

		$labels=array(1=>'Obtained LOTOTO',2=>'Power supply locked and tagged',3=>'Circuit checked for zero voltage',4=>'Portable cords and electric tools inspected',5=>'Safety back-up man appointed',6=>'Job Hazards is explained to all concern thru tool box talk meeting.',7=>'Physical isolation is ensured If yes, State the method',8=>'In case of lock applied, ensure the safe custody of the key',9=>'If physical isolation is not possible state, the alternative method of precaution',10=>'Approved rubber and leather gloves',11=>'Insulating mat',12=>'Fuse puller',13=>'Disconnect pole or safety rope',14=>' Non-conductive hard hat',15=>'ELCB/RCCB is installed of 30 mA');
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Electrical Work:</b></td></tr>';
		$table.='<tr><td align="center" colspan="5"><u>LIVE ELECTRICAL WORK PERFORMED BY LICENCED ELECRTRICIAN ONLY</u></td></tr>';

		

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			if($c==1) $table.='<tr>'; 

			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr>'; }

		endforeach;

		$additional_info =  (isset($precautions['precautions_electrical_additional_info'])) ? strtoupper($precautions["precautions_electrical_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';

	}

	//Scaffolding Erection & Dismantling
	if(in_array(5,$permit_types) || in_array(11,$permit_types))
	{
		$precautions_data=(isset($precautions['scaffoldings'])) ? json_decode($precautions['scaffoldings'],true) : array();

		$scaffolding_tag_no=(isset($precautions['scaffolding_tag_no'])) ? $precautions['scaffolding_tag_no'] : '';

		$scaffolding_inspector_name=(isset($precautions['scaffolding_inspector_name'])) ? $precautions['scaffolding_inspector_name'] : '';

		$additional_info =  (isset($precautions['precautions_scaffolding_additional_info'])) ? strtoupper($precautions["precautions_scaffolding_additional_info"]) : '';

		$labels=array(1=>'Presence of competent person assigned to ensure safe erection, maintenance, or modification of scaffolds. Name',2=>'That person prior to use by personnel other than scaffolders inspects scaffold.',3=>'Job Hazards is explained to all concern thru tool box talk meeting',4=>'All pipes, clamps, H-frames, couplers, boards checked before assembly',5=>'Scaffolds provided with proper access and egress',6=>'Standard guardrail been used',7=>'Platforms, walkways on scaffolds are wide of minimum of 900 mm wherever possible',8=>'Precautions taken to ensure scaffolds are not overloaded',9=>'Overhead protection provided where there is exposure',10=>'No opening / Gap in the platform / walkway',11=>'All component of the scaffold more than 12’ away from any exposed power lines',12=>'Excavator is fit for the job',13=>'Safety Harness and Lanyard anchored to independent rigid object',14=>'Lifeline Rope ',15=>'Fall Arrestor with rope anchorage',16=>'Full Body harness is used by all workmen engaged at height work.',17=>'Safety net is provided but not less than 5 M from the work area.');
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Scaffolding Erection & Dismantling:</b></td></tr>';

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			if($c==1) $table.='<tr>'; 

			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr>'; }

		endforeach;

		$table.='<td align="left" style="'.$valign.$td_border.'">Scaffolding Tag No: '.$scaffolding_tag_no.
		'</td><td align="left" style="'.$valign.$td_border.'">Scaffolding Inspector Name: '.$scaffolding_inspector_name.'</td>';
		$table.='<td align="left" style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';

	}

	//Confined Space Entry:
	if(in_array(7,$permit_types))
	{
		$precautions_data=(isset($precautions['confined_space'])) ? json_decode($precautions['confined_space'],true) : array();

		$oxygen_readings=(isset($precautions['oxygen_readings'])) ? $precautions['oxygen_readings'] : '';
        $gases_readings=(isset($precautions['gases_readings'])) ? $precautions['gases_readings'] : '';
        $carbon_readings=(isset($precautions['carbon_readings'])) ? $precautions['carbon_readings'] : '';

		$labels=array(1=>'Equipment properly drained / Depressurized',2=>'Disconnected Inlet, Outlet lines and isolate equipment',3=>'Vent / Manholes are kept open to maintain proper ventilation',4=>'Only trained personnel were engaged & register was maintained for entry & exit of person with time.',5=>'Standby Personnel/Entry supervisor,. is available',6=>'Oxygen level is measured and find <b>'.$oxygen_readings.'</b>( 19.5% - 23.5% is available) <br /><b>'.$gases_readings.'</b> (Combustible gases 0  %) <br /><b>'.$carbon_readings.'</b> (Carbon Monoxide 0-25  ppm)',7=>'Flammable gases and vapours reading: ≤ 5% LEL',8=>'Toxic gases and vapours reading: ≤ PEL values',9=>'Inside temperature closed to room temperature and ambient air comfortable for working.',10=>'Recommended communication system',11=>'Safe Illumination provided (24-volt hand lamps)',12=>'Additional Measures.');
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Confined Space Entry:</b></td></tr>';

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			if($c==1) $table.='<tr>'; 

			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr>'; }

		endforeach;

		$additional_info =  (isset($precautions['precautions_confined_additional_info'])) ? strtoupper($precautions["precautions_confined_additional_info"]) : '';

		$table.='<td align="left" colspan="3"  style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}

	//U T Pump:
	if(in_array(6,$permit_types))
	{
		$precautions_data=(isset($precautions['utp'])) ? json_decode($precautions['utp'],true) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>U T Pump:</b></td></tr>';

		$labels=array(1=>'Trained persons are deployed',2=>'Adequate water level in tank',3=>'Whiplash is provided to hose pipe',4=>'All hoses joints thread tightened properly',5=>'Pressure gauge is showing reading and marking provided – Yellow/Green/Red',8=>'Hoses are properly protected and barricaded',9=>'PPEs are adequate for working');

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			if($c==1) $table.='<tr>'; 

			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr>'; }

		endforeach;

		$additional_info =  (isset($precautions['precautions_utp_additional_info'])) ? strtoupper($precautions["precautions_utp_additional_info"]) : '';

		$table.='<td align="left" style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}


	//Work At Height:
	if(in_array(4,$permit_types))
	{
		$precautions_data=(isset($precautions['workatheights'])) ? json_decode($precautions['workatheights'],true) : array();


		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>Work At Height:</b></td></tr>';

		$labels=array(1=>'Only medically fit personnel engaged in work and list is available.',2=>'Job Hazards is explained to all concern thru tool box talk meeting.',3=>'Ladder(s) inspected prior to use',4=>'Ladder properly supported and leveled',5=>'Secured at Top',6=>'Secured at Bottom',6=>'Distance between the ladder support and the ladder base is at least ¼ the total length of the ladder',7=>'Ladder been provided with skid resistant feet',8=>'Scaffolds/platforms inspected for good repair and proper construction (secured flooring and guardrails)',9=>'Floor openings covered Guarded',10=>'Work area roped off and warning signs in place',11=>'Proper Housekeeping is done',12=>'Personnel assigned to warn of floor opening or other hazardous exposure.',13=>'Tools and other equipment stored in safe manner',14=>'Area cleared below prior to starting work',15=>'Safety Harness and Lanyard anchored to independent rigid object',16=>'Lifeline Rope',17=>'Fall Arrestor with rope anchorage',18=>'Full Body harness is used by all workmen engaged at height work.',19=>'Safety net is provided but not less than 5 M from the work area.');

		$c=0;
		foreach($labels as $key => $label):
			$c++;
			if($c==1) $table.='<tr>'; 

			$checkbox = (isset($precautions_data[$key]) && $precautions_data[$key]=='y') ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));

			$table.='<td align="left" style="'.$valign.$td_border.'">'.$checkbox.' '.$label.'</td>';

			if($c==5){ $c=0; $table.='</tr>'; }

		endforeach; 

		$additional_info =  (isset($precautions['precautions_workatheights_additional_info'])) ? strtoupper($precautions["precautions_workatheights_additional_info"]) : '';

		$table.='<td align="left" style="'.$valign.$td_border.'"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}


	//Job specific Tool box Talk
	/*$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Job specific Tool box Talk:</b></td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:50px;"><b>Persons Engaged for the job: </b>(if more than 6 persons were engaged for work, then separate sheet to be attached)</td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:150px;"><table align="center" border="1" style="width:750px;border-collapse: collapse;"><tr><td style="width:10%;text-align:center;"><b>S.No</b></td><td align="center"><b>Contractor Name</b></td><td align="center"><b>Sub Contractor</b></td><td align="center"><b>No. of workers</b></td><td align="center"><b>Sign</b></td></tr>';

	for($i=1;$i<=10;$i++)
	{
		$table.='<tr><td  align="center" height="20">'.$i.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	}
	
	$table.='</table></td></tr>';
	$table.='</table></td></tr>';*/

	//If loto is enabled
	if(in_array(8,$permit_types))
	{
		$arr = array(1=>'The job is completed, all men & material removed from site. <br />Safe to remove isolations as stated clause-A&C.',2=>'Please remove isolations as stated clause-A&C.',3=>'I have removed all isolation as listed clause-A&C and <br >all isolations as per clause-A&C are restored. Equipment ready to start.');

		$arr_sub = array(1=>'Permit Initiator Name & Sign',2=>'Issuer Name & Sign',3=>'Isolator Name & Sign',4=>'Issuer Name & Sign',5=>'Permit Initiator Name & Sign');

		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="left" colspan="5"><b>I)Closure of permit to work(1st copy of Permit must be routed during permit closure)</b></b></td></tr>';

		$loto_closure_ids=(isset($records['loto_closure_ids']) && $records['loto_closure_ids']!='') ?  json_decode($records['loto_closure_ids'],true) : array();
                                    
		$loto_closure_ids_dates=(isset($records['loto_closure_ids_dates']) && $records['loto_closure_ids_dates']!='') ?  json_decode($records['loto_closure_ids_dates'],true) : array();

		foreach($arr as $key => $label):

			$input_value=(isset($loto_closure_ids[$key]) && $loto_closure_ids[$key]!='')  ? $loto_closure_ids[$key] : '';

			if($input_value!=''){
			$input_value_text=get_authorities($input_value,$allusers);
			}

			

			

			$table.='<tr>
				<td align="left" style="'.$td_border.$valign.'" colspan="3">'.($key).' '.$label.'</td>
				<td align="left" style="'.$td_border.$valign.'" colspan="2"><b>'. $arr_sub[$key].'</b> <br /> '.$input_value_text.' <br /><b>Date:</b>'.$input_date_value.'</td>
			</tr>';
		endforeach;

		$table.='</table></td></tr>';
	}

	$approval_status=(isset($records['approval_status']) && $records['approval_status']!='') ? $records['approval_status'] : '';

	$status_txt = (in_array($approval_status,array(5,6))) ? 'Completion' : 'Cancellation';

	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr><td align="center" colspan="5"><b>Work Completion</b></b></td></tr><tr><Td colspan="5">&nbsp;</td></tr>';

	$cancellation_performing_id=(isset($records['cancellation_performing_id']) && $records['cancellation_performing_id']!='') ? $records['cancellation_performing_id'] : '';

	$cancellation_performing_date=(isset($records['cancellation_performing_date']) && $records['cancellation_performing_date']!='') ? $records['cancellation_performing_date'].'HRS' : '';
	
	$cancellation_issuing_id=(isset($records['cancellation_issuing_id']) && $records['cancellation_issuing_id']!='') ? $records['cancellation_issuing_id'] : '';

	$cancellation_issuing_date=(isset($records['cancellation_issuing_date']) && $records['cancellation_issuing_date']!='') ? $records['cancellation_issuing_date'].'HRS' : '';


	$cancellation_performing_name=$cancellation_issuing_name='';

	if($cancellation_performing_id!='')
	{
		$cancellation_performing_name=get_authorities($cancellation_performing_id,$allusers);
	}

	if($cancellation_issuing_id!='')
	{
		$cancellation_issuing_name=get_authorities($cancellation_issuing_id,$allusers);
	}

	$table.='<tr><td colspan="3" style="'.$td_border.$valign.'"><b>PA Work '.$status_txt.'</b><br />Work '.$status_txt.', all persons are withdrawn and material removed from the area <br /><br /><b>Performing Authority: </b>'.$cancellation_performing_name.' '.$cancellation_performing_date.'</td>';
	
	$table.='<td colspan="2" style="'.$td_border.$valign.'"><b>IA Work '.$status_txt.'</b><br />I have inspected the work area and declare the work for which the permit was issued has been properly. <br /><br /><b>Issuing Authority: </b>'.$cancellation_issuing_name.' '.$cancellation_issuing_date.'</td></tr>';

	$table.='</table></td></tr>';

	$table.='</table></td></tr>';

    $table.='</table>';

    //echo $table; exit;

     #$table.='<table align="center" width="100%"><tr><td colspan="2" align="center" style="border: 1px solid #000;"><b>Emergency contact Number 3108 / 9942989056</b></td></tr></table>';


try
{
		include_once APPPATH.'/third_party/mpdf60/mpdf.php';

		$footer="";

		/*$mpdf = new mPDF('',    // mode - default ''
		'',    // format - A4, for example, default ''
		0,     // font size - default 0
		'',    // default font family
		15,    // margin_left
		15,    // margin right
		16,     // margin top
		16,    // margin bottom
		9,     // margin header
		9,     // margin footer
		'L');  // L - landscape, P - portrait*/

		$mpdf=new mPDF('c','A4-L','','',10,10,30,10,10,10);
		//                             L,R,T,
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetHTMLHeader($header);
		$mpdf->SetFooter($footer.'{PAGENO}');
		#$mpdf->AddPage('P','','','','',15,15,30,30,10,10);
		//$mpdf->setFooter('{PAGENO}');
		$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a li
		// LOAD a stylesheet
		#$stylesheet = file_get_contents(include_once APPPATH.'/third_party/mpdf60/style.css');
		#$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

		$mpdf->debug = true;

		$mpdf->WriteHTML($table,2);

		$path = UPLODPATH.'uploads/permits/'.$records['id'];

		if (!file_exists($path)) 
		mkdir($path);

		$file_name='/permit'.time().'.pdf';

		$file=$path.$file_name;

		$mpdf->Output($file,'F');
}
catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
                                   //       name used for catch
    // Process the exception, log, print etc.
    echo 'ERror '.$e->getMessage();
}

//echo '<a href="'.base_url().'uploads/permits/'.$records['id'].$file_name.'" target="_blank">Print</a>';

echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$records['id'].$file_name));
exit;

?>

