<?php
 $job_approval_status=unserialize(JOBAPPROVALS);

$hrs=' HRS';

 if(!empty($records))
 {
     $page_name='Edit Permit';
	 
	 $record_id=$records['id'];
	 
	 $show_button=$records['show_button'];
	 
	 $acceptance_performing_id=$records['acceptance_performing_id'];
	 
	 $acceptance_issuing_id=$records['acceptance_issuing_id'];
	 
	 $status=$records['status'];
	 
	 $cancellation_performing_id=$records['cancellation_performing_id'];
	 
	 $cancellation_issuing_id=$records['cancellation_issuing_id'];
	 
	 if($show_button=='hide')
	 $readonly=true;
	 

 }
 else
 $record_id=''; 
 
 $checked='checked="checked"';

function get_user_name($authorities,$user_id)
 	{		
 		$user_name='';

 		if($authorities!='')
		  {
			  foreach($authorities as $fet)
			  {
				  $id=$fet['id'];
				  
				  if($user_id==$id) { $user_name=strtoupper($fet['first_name']); break; }
			  }
		  }	
		return $user_name;  
 	} 	

function checkbox($array_args)
{		
	extract($array_args);
	
	$style=(isset($style)) ? 'style="'.$style.'"' : '';	
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />';
}


$cse_location_no=(isset($records['cse_location_no'])) ? '<b>'.strtoupper($records['cse_location_no']).'</b>' : '';

$table='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:7.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
    <colgroup>
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
    </colgroup>

	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr>
	
	<tr>
      <td style="border:1px solid #ccc; width: 20% !important;vertical-align: top;" colspan="3"><b>CSE Location Number :</b>'.$cse_location_no.'  </td>
	  <td colspan="3"  style="border:1px solid #ccc;width: 20% !important; vertical-align: top;">&nbsp;</td>
	  <td style="border:1px solid #ccc;width: 20% !important;vertical-align: top;"colspan="4" >&nbsp;</td>
	</tr>';

	$location=(isset($records['location'])) ? '<b>'.strtoupper($records['location']).'</b>' : '';	
	$table.='<tr>
		<td style="border:1px solid #ccc;" colspan="2"><b>Location : </b>'.$location.'</td>	
		<td style="border:1px solid #ccc;" colspan="4" ><strong>Hazards / concern identified:</strong></td>
		<td style="border:1px solid #ccc;text-align:center;"><strong>YES / NO</strong></td>
		<td style="border:1px solid #ccc !important;"colspan="5"><strong>Precautions to be Taken :</strong></td>
		<td style="border:1px solid #ccc;text-align:center;"><strong>YES / NA</strong></td> </tr>
	</tr>';

  	$job_name=(isset($records['job_name'])) ? '<b>'.strtoupper($records['job_name']).'</b>' : '';	

  $location_time_start=(isset($records['location_time_start'])) ? $records['location_time_start'].$hrs : '';	

  $location_time_to=(isset($records['location_time_to'])) ? $records['location_time_to'].$hrs : '';		
	
 if(isset($records))
 $hazards=json_decode($records['hazards']);
 else
 $hazards=array();
 
 if(isset($records))
 $hazards_options=json_decode($records['hazards_options']);
 else
 $hazards_options=array();
 
 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();

 if(isset($records))
 $precautions_text=json_decode($records['precautions_text']);
 else
 $precautions_text=array();

 
 if(isset($records))
 $precautions_options=json_decode($records['precautions_options']);
 else
 $precautions_options=array();

 $pre=(isset($precautions->a)) ? strtoupper($precautions->a) : '';

 $haz=(isset($hazards->a)) ? strtoupper($hazards->a) : '';

$eip_yes_selection='';
	  
	  $jobs_isoloations_ids=array();
	  
	  if($isoloation_permit_no!='')
	  {
		  if($isoloation_permit_no->num_rows()>0)
		  {
			  $fets_permits=$isoloation_permit_no->result_array();
				  
			  $jobs_isoloations_ids=array_column($fets_permits,'jobs_isoloations_id');
			  
			  if($eips->num_rows()>0)
			  {
					$fet_eips=$eips->result_array();
					
					foreach($fet_eips as $fet_eip)
					{
						$eip_id=$fet_eip['id'];
						
						if(array_search($eip_id,$jobs_isoloations_ids)!==FALSE)
						$eip_disabled='disabled=disabled';			
					}
			  }
		  }
	  }
	  if($eips->num_rows()>0)
	  {
		  $fet_eips=$eips->result_array();
		  
		  foreach($fet_eips as $fet_eip)
		  {
			  $eip_id=$fet_eip['id'];
			  
			  $eip_section=$fet_eip['section'];
			  
			  $eip_status=$fet_eip['status'];

			  $eip_no=$fet_eip['eip_no'];
			  
			  if(array_search($eip_id,$jobs_isoloations_ids)!==FALSE)
				$eip_yes_selection.=strtoupper($eip_section.'(#'.$eip_no.'),');
		  }
		  
		  $eip_yes_selection=rtrim($eip_yes_selection,',');
	  }
	  
	  if(trim($eip_yes_selection)=='')
	  $eip_yes_selection='NA';

	  $no_active=$na_active=$yes_active=$yes_existing_active='';

	  if(isset($records))
	  {
		  $is_isoloation_permit=(isset($records['is_isoloation_permit'])) ? $records['is_isoloation_permit'] : '';
		  
		    if($is_isoloation_permit=='Existing') 
		    $no_active=$checked;
		    else if($is_isoloation_permit=='N/A')
		    $na_active=$checked;
		    else if($is_isoloation_permit=='Yes')
		    $yes_active=$checked;
		    else		    
		    $yes_existing_active=$checked;
		    
	  }
	  else
	  $na_active=$checked;			//Anand removed border-right:1
	$table.='<tr><td style="border:1px solid #ccc;vertical-align:top"rowspan="6" colspan="2"><table style="width:100%;height:100%; border-collapse:collapse"><tr><td style="border-bottom:1px solid #ccc;border-right:0px solid #ccc; vertical-align:top;text-align:left;height:30px;" colspan="2"><b>Description of Job</b> <br /> '.$job_name.'</td>
					</tr>			
				<tr>
					<td style="border-bottom:1px solid #ccc;border-right:1px solid #ccc; vertical-align:middle;text-align:left;">From</td>
					<td style="text-align:left;border-bottom:1px solid #ccc;border-right:0px solid #ccc; vertical-align:middle;"> '.$location_time_start.'</td>
				</tr><tr>
					<td style="border-right:1px solid #ccc; vertical-align:middle;border-bottom:1px solid #ccc;">To</td>
					<td style="border:0px solid #ccc; vertical-align:middle;border-bottom:1px solid #ccc;"> '.$location_time_to.'</td>
				</tr>
				<tr>					
					<td style="border:0px solid #ccc; vertical-align:middle;" colspan="2">

					<p><b>Is EIP obtained</b><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$yes_existing_active.'>Yes&Existing&nbsp;<input type="radio" '.$no_active.'>Existing&nbsp;<input type="radio" '.$na_active.'>N/A</p><br />
		<p><b>If yes Energy isolation Permit No : </b> '.$eip_yes_selection.'</p>


					</td>
				</tr>
				</table>		
		</td>	
		<td style="border:1px solid #ccc;vertical-align:middle;" colspan="4"> a) Un Safe Access to work area.</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">a) Safe access and Egress provided</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

 $pre=(isset($precautions->b)) ? strtoupper($precautions->b) : '';

 $haz=(isset($hazards->b)) ? strtoupper($hazards->b) : '';

	$table.='<tr>
	<td style="border:1px solid #ccc;"colspan="4">b) Oxygen deficient atmosphere.</td>
		 <td style="border:1px solid #ccc;vertical-align:middle;" align="center">'.$haz.'</td>
		 <td style="border:1px solid #ccc;"colspan="5">b) Gas monitoring test carried out</td>
		 <td style="border:1px solid #cccccc;"  align="center">'.$pre.'</td>
	
	</tr>';

 $pre=(isset($precautions->c)) ? strtoupper($precautions->c) : '';

 $haz=(isset($hazards->c)) ? strtoupper($hazards->c) : '';	
	
	$table.='<tr>
		<td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">
				c) Ignition of Flammables
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				c) Space free of Flammables / Combustible Materials</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

 $pre=(isset($precautions->d)) ? strtoupper($precautions->d) : '';

 $haz=(isset($hazards->d)) ? strtoupper($hazards->d) : '';		
	
	$table.='<!--<tr><td style="border:1px solid #ccc;"colspan="5">      </td><td style="border:1px solid #cccccc;" align="center"></td></tr>-->
	<tr>
	<td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">
				d) Corrosives or Irritatives

		</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				d) Use of appropriate PPE
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';
	
 $pre=(isset($precautions->e)) ? strtoupper($precautions->e) : '';

 $haz=(isset($hazards->e)) ? strtoupper($hazards->e) : '';	

	$table.='<tr>
	<td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">		e) Excessive Temperature </td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				e) Eqpt.Cooled / Forced Ventilation facilities provided
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';
	
 $pre=(isset($precautions->f)) ? strtoupper($precautions->f) : '';

 $haz=(isset($hazards->f)) ? strtoupper($hazards->f) : '';	

	$table.='<tr>
	<td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">
				f) Gas / Vapour or Fumes produced by Operation
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				f) Forced ventilation facilities provided
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

	$equipment_name = (isset($records['equipment_name'])) ? strtoupper($records['equipment_name']) : '';

 $pre=(isset($precautions->g)) ? strtoupper($precautions->g) : '';

 $haz=(isset($hazards->g)) ? strtoupper($hazards->g) : '';		

 $access_card=(isset($records['access_card'])) ? $records['access_card'] : '';

   $yes_active='';
   $no_active='';

	  if($access_card=='Yes')
	  $yes_active=$checked;
	  else
	  $no_active=$checked;

	$table.='<tr>
		 <td style="border:1px solid #ccc;"colspan="2"><strong>Equipment name:</strong> '.$equipment_name.'</td>
		 <td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">g) Electrocution</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center" >'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5"> g) 24 Volts supply provided to Lights & Equipments
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>	
	</tr>';

 $pre=(isset($precautions->h)) ? strtoupper($precautions->h) : '';

 $haz=(isset($hazards->h)) ? strtoupper($hazards->h) : '';	

 $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';   	

 $other_contractors=(isset($records['other_contractors'])) ? $records['other_contractors'] : ''; 
 
 if($select_contractor_id!='others') 
 {
	 if($contractors->num_rows()>0)
	 {
	    $contractors=$contractors->result_array();

	    foreach($contractors as $list)
	    {
	    	if($select_contractor_id==$list['id'])
	    	{
	    		$other_contractors=$list['name'];
	    		break;
	    	}	
		}
	 }	 
}	 
	 $table.='<tr>
		<td style="border:1px solid #ccc;vertical-align:middle;"colspan="2"><strong>Access Card Available : <input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No <br> 
			
		</strong> <br />
		<b>Name of the Contractor/DCBL : </b>'.strtoupper($other_contractors).'</td>
		<td style="border:1px solid #ccc;vertical-align:middle;"colspan="4">
				h) Moving Machinery</td>
		<td style="border: 1px solid #cccccc;vertical-align:middle;" align="center" >'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				h) Hazardous Energy Isolation ensured
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'
		</td>		
	</tr>';
	
 $pre=(isset($precautions->i)) ? strtoupper($precautions->i) : '';

 $haz=(isset($hazards->i)) ? strtoupper($hazards->i) : '';	

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Attach List if more persons involved</strong> </td>
		
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="4">
				i) Falling Objects

		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" >'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				i) Loose material removed / barrier provided / safety net tied / dummy provided
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

 $pre=(isset($precautions->j)) ? strtoupper($precautions->j) : '';

 $haz=(isset($hazards->j)) ? strtoupper($hazards->j) : '';	

 $watch_person_name=(isset($records['watch_person_name'])) ? strtoupper($records['watch_person_name']) : '';

 $watch_other_person_names = (isset($records['watch_other_person_names'])) ? json_decode($records['watch_other_person_names']) : 
 array(0=>'');

 $wopn='';

  if(count($watch_other_person_names)>0)
  {
 		$watch_other_person_names = array_filter($watch_other_person_names);

 		$wopn=(isset($watch_other_person_names[0])) ? strtoupper($watch_other_person_names[0]) : '';
   }		

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Watch Person Name : </strong>'.$watch_person_name.' </td>						
						
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="4">j) Poor ventilation
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" >'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				j) Proper ventilation facilities provided
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';	
	
 $pre=(isset($precautions->k)) ? strtoupper($precautions->k) : '';

 $haz=(isset($hazards->k)) ? strtoupper($hazards->k) : '';	

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Name of the Person</strong> </td>				
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="4">
				k) Poor Illumination</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				k) Adequate Illumincation Provided
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
		
	</tr>';	

 $pre=(isset($precautions->l)) ? strtoupper($precautions->l) : '';

 $haz=(isset($hazards->l)) ? strtoupper($hazards->l) : '';		
	
	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>1) </strong>'.$wopn.'</td>				
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="4">
				l) Probability of Fire</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				l)Fire extinguishers availability ensured.
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>		
	</tr>';	
	
 $pre=(isset($precautions->m)) ? strtoupper($precautions->m) : '';

 $haz=(isset($hazards->m)) ? strtoupper($hazards->m) : '';	

 $wopn=(isset($watch_other_person_names[1])) ? strtoupper($watch_other_person_names[1]) : '';

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>2) </strong>'.$wopn.'</td>				
		
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="4">
				m) Emergency Management / Rescue
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="5">      
				m)Trained watch person outside space means of Communication Kept Ready (phone /Rope)
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>		
	</tr>';	
	
$hazards_other = (isset($records['hazards_other'])) ? '<br /><b>'.strtoupper($records['hazards_other']).'</b>' : '';

$precautions_other = (isset($records['precautions_other'])) ? '<br /><b>'.strtoupper($records['precautions_other']).'</b>' : '';

$wopn=(isset($watch_other_person_names[2])) ? strtoupper($watch_other_person_names[2]) : '';

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>3) </strong>'.$wopn.'</td>
		<td style="border:1px solid #ccc;vertical-align:top;"colspan="5">n)Others '.$hazards_other.'
		</td>
		
		<td style="border:1px solid #ccc;"colspan="6">n)Others '.$precautions_other.'</td></tr>';	
	
	$wopn=(isset($watch_other_person_names[3])) ? strtoupper($watch_other_person_names[3]) : '';

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>4) </strong>'.$wopn.'</td>
		<td style="border:0px solid #ccc;vertical-align:top;"colspan="10">
				<strong>Required PPE</strong>
		</td>
		<td style="border-right:1px solid #cccccc;"></td>
	</tr>';

	$required_ppe=explode(',',rtrim($records['required_ppe'],','));

	$helmet_checked=(in_array('Helmet',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$safety_shoes_checked=(in_array('Safety Shoes',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$eye_protection_checked=(in_array('Eye Protection',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$ear_protection_checked=(in_array('Ear Protection',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$hand_gloves_checked=(in_array('Hand Gloves',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));


	$wopn=(isset($watch_other_person_names[4])) ? strtoupper($watch_other_person_names[4]) : '';

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>5) </strong>'.$wopn.'</td>
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Helmet  </strong>'.$helmet_checked.'  </td>				
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Safety Shoe  </strong>'.$safety_shoes_checked.'</td>				
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Eye Protection  </strong>'.$eye_protection_checked.'</td>				
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Ear Protection  </strong>'.$ear_protection_checked.'</td>				
		<td colspan="3" style="border-right:1px solid #cccccc;"><strong> Hand Gloves  </strong>'.$hand_gloves_checked.'</td>				
		
	</tr>';	
	
	$wopn=(isset($watch_other_person_names[5])) ? strtoupper($watch_other_person_names[5]) : '';

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>6) </strong>'.$wopn.'</td>			
		<td colspan="2" style="border:0px solid #cccccc;"></td>				
		<td colspan="2" style="border:0px solid #cccccc;"></td>				
		<td colspan="2" style="border:0px solid #cccccc;"></td>				
		<td colspan="2" style="border:0px solid #cccccc;"></td>						
		<td colspan="2"></td>
		<td style="border-right:1px solid #cccccc;"></td>
	</tr>';	

	$full_body_checked=(in_array('Full Body Harness',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$nose_mask_checked=(in_array('Nose mask',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$others_checked=(in_array('Others',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));

	$required_ppe_other=(isset($records['required_ppe_other'])) ? strtoupper($records['required_ppe_other']) : '';

	$wopn=(isset($watch_other_person_names[6])) ? strtoupper($watch_other_person_names[6]) : '';

	$fall_protection_kit_checked=(in_array('Fall Protection Kit',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: left;text-align: left;padding-left:5px;')) : checkbox(array('status'=>'no','style'=>'padding-left:5px;vertical-align:middle;float: left;text-align: left;'));
	
	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>7) </strong>'.$wopn.'</td>			
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Full Body Harness  </strong>'.$full_body_checked.'  </td>				
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Nose mask  </strong>'.$nose_mask_checked.'  </td>	
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Fall Protection Kit  </strong>'.$fall_protection_kit_checked.'  </td>			
		<td colspan="2" style="border:0px solid #cccccc;"><strong> Others  </strong>'.$others_checked.'  </td>				
		<td colspan="2" style="border:0px solid #cccccc;">'.$required_ppe_other.'</td>	
		<td style="border-right:1px solid #cccccc;"></td>
	</tr>';		

	$wopn=(isset($watch_other_person_names[7])) ? strtoupper($watch_other_person_names[7]) : '';

	if($wopn!='')
	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>8) </strong>'.$wopn.'</td>				
		<td colspan="10"></td>
		<td style="border-right:1px solid #cccccc;"></td>
	</tr>';

	$wopn=(isset($watch_other_person_names[8])) ? strtoupper($watch_other_person_names[8]) : '';

	if($wopn!='')
	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>9) </strong>'.$wopn.' </td>				
		<td colspan="10"></td>
		<td style="border-right:1px solid #cccccc;"></td>
	</tr>';	
	
	$wopn=(isset($watch_other_person_names[9])) ? strtoupper($watch_other_person_names[9]) : '';	

	if($wopn!='')
	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2"><strong>10) </strong>'.$wopn.' </td>				
		<td colspan="10"></td>
		<td style="border-right:1px solid #cccccc;"></td>
	</tr><!--end -->';

	$table.='<tr><td colspan="13" style="border: 1px solid #cccccc;"><table align="center" width="100%" style="border-collapse:collapse;">';

	$st=(isset($records['status'])) ? $records['status'] : '';
	
	$work_msg='Completion/Cancellation';
	
	if($st=='Completion' || $st == 'Cancellation')
	$work_msg=$st;

	$table.='<tr rowspan="6">
		<td ><strong>Test </strong> </td>			
		<td  align="center" style="border-left:1px solid #ccc;"><strong>Acceptable Conditions</strong></td>
		<td  align="center" style="border-left:1px solid #ccc;" width="109px"><strong>Present Reading</strong></td>		
		<td  colspan="6" style="border-left:1px solid #ccc;"><span style="text-align:center;"><strong>Authorisation & Acceptance</strong></span>
				<br>Performing Authority:<br>	
		</td>
		<td style="border-left:1px solid #ccc;"colspan="6"><strong>Work '.$work_msg.'</strong> <br />Performing Authority:</td>
	</tr>';

	$oxygen_reading=(isset($records['oxygen_reading'])) ? strtoupper($records['oxygen_reading']) : '';

	$gases_reading=(isset($records['gases_reading'])) ? strtoupper($records['gases_reading']) : '';

	$carbon_reading=(isset($records['carbon_reading'])) ? strtoupper($records['carbon_reading']) : '';

	$table.='<tr>
	<td style="border:1px solid #ccc;"><strong>Oxygen </strong> </td>
		<td style="border:1px solid #ccc;" align="center" ><strong>19.5  to  23.5  %</strong></td>		
		<td style="border:1px solid #ccc;" align="center"><strong>'.$oxygen_reading.'</strong></td>		
		<td style="border:1px solid #ccc;"colspan="6">I have read permit explained shall work in accordance with the control measures identified</td>
		<td style="border:1px solid #ccc;border-right:0px solid #ccc;"colspan="6">Work completed, all persons are withdrawn and material removed from the area.</td>
	</tr>';

	$acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

  $acceptance_performing_name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($acceptance_performing_id==$id) { $acceptance_performing_name=strtoupper($fet['first_name']); break; }
	  }
  }

  $acceptance_performing_date=(isset($records['acceptance_performing_date']) && $records['acceptance_performing_date']!='') ? date('d-m-Y H:i',strtotime($records['acceptance_performing_date'])).$hrs : '';	

  $cancellation_performing_id=(isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';

  $cancellation_performing_name='';
 
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		  if($cancellation_performing_id==$id) { $cancellation_performing_name=strtoupper($fet['first_name']); break; }
	  }
  }
 	
	$cancellation_performing_date=(isset($records['cancellation_performing_date']) && $records['cancellation_performing_date']!='') ? date('d-m-Y H:i',strtotime($records['cancellation_performing_date'])).$hrs : '';
	$table.='<tr>	
	<td ><strong> Combustible gases</strong> </td>
	<td style="border-left:1px solid #ccc;" align="center"><strong>0%</strong></td>
	<td style="border-left:1px solid #ccc;" align="center"><strong>'.$gases_reading.'</strong></td>	
		<td style="border:1px solid #ccc;"colspan="4">Name : <strong>'.$acceptance_performing_name.'</strong> </td>
		<td style="border:1px solid #ccc;"colspan="2">
	Digital Sign/Date&Time: <b>'.$acceptance_performing_date.'</b></td>
		<td style="border:1px solid #ccc;"colspan="3">Name : <strong>'.$cancellation_performing_name.'</strong></td>
		<td style="border:1px solid #ccc;border-right:0px solid #ccc;"colspan="3">Digital Sign/Date&Time: <b>'.$cancellation_performing_date.'</b></td>
	</tr>	
	<tr>
		<td style="border-top:1px solid #ccc;"colspan="1"><strong> Carbon Monoxide</strong> </td>
		<td style="border:1px solid #ccc;" align="center"><strong>0-25  ppm</strong></td>
		<td style="border:1px solid #ccc;" align="center"><strong>'.$carbon_reading.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="6"><strong>Issuing Authority: </strong></td>
		<td style="border:1px solid #ccc;border-right:0px solid #ccc;"colspan="6"> <strong>Issuing Authority:</strong></td>
	</tr>
	
	
	<tr>
	<td style="border:1px solid #ccc;"colspan="1"><strong> </strong> </td>
	<td ></td><td style="border:1px solid #ccc;"></td>
	
		<td style="border:1px solid #ccc;border-right:0px solid #ccc;"colspan="6">
I have ensured that each of the identified control measures are suitable. The content of the permit has been explained to the holder and work may proceed. </td>
		<td style="border:1px solid #ccc;border-right:0px solid #ccc;"colspan="6">I have inspected the work area and declare the work for which the permit was issued has been properly performed</td>
	</tr>';

$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

$acceptance_issuing_name='';

  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		  if($acceptance_issuing_id==$id) { $acceptance_issuing_name=strtoupper($fet['first_name']); break; }
	  }
  }
$acceptance_issuing_date=(isset($records['acceptance_issuing_date']) && $records['acceptance_issuing_date']!='') ? date('d-m-Y H:i',strtotime($records['acceptance_issuing_date'])).$hrs : ''; 
	
	$cancellation_issuing_id=(isset($records['cancellation_issuing_id'])) ? $records['cancellation_issuing_id'] : '';
	
	$cancellation_issuing_name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		  if($cancellation_issuing_id==$id) { $cancellation_issuing_name=strtoupper($fet['first_name']); break; }
	  }
  }

  $acceptance_name_of_ia=(isset($records['acceptance_name_of_ia'])) ? strtoupper($records['acceptance_name_of_ia']) : '';

  $cancellation_name_of_ia=(isset($records['cancellation_name_of_ia'])) ? strtoupper($records['cancellation_name_of_ia']) : '';
  
	$cancellation_issuing_date=(isset($records['cancellation_issuing_date']) && $records['cancellation_issuing_date']!='') ? 
	date('d-m-Y H:i',strtotime($records['cancellation_issuing_date'])).$hrs : '';	
	$table.='<tr>
		<td colspan="1"><strong> </strong> </td>
		<td style="border-top:1px solid #ccc;border-left:1px solid #ccc;"></td>
		<td style="border-top:1px solid #ccc;border-left:1px solid #ccc;"></td>
		<td colspan="4" style="border-left:1px solid #ccc;">Name : <strong>'.$acceptance_issuing_name.'</strong><br /><br /><p><b>Name of IA</b>: <br />'.$acceptance_name_of_ia.'</p></td>
		<td colspan="2" style="border-left:1px solid #ccc;">Sign/Date&Time: <strong>'.$acceptance_issuing_date.'</strong></td>
		<td style="border-left:1px solid #ccc;border-right:0px solid #ccc;"colspan="3">Name : <strong>'.$cancellation_issuing_name.'</strong><br /><br /><p><b>Name of IA</b>: <br />'.$cancellation_name_of_ia.'</p></td>
		<td style="border-left:1px solid #ccc;border-right:0px solid #ccc;" colspan="3">Digital Sign/Date&Time: <strong>'.$cancellation_issuing_date.'</strong></td> 
	</tr>';

	$acceptance_safety_sign_id=(isset($records['acceptance_safety_sign_id'])) ? $records['acceptance_safety_sign_id'] : '';
	
	$accceptance_safety_name='';
  if($safety_authorities!='')
  {
	  foreach($safety_authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		  if($acceptance_safety_sign_id==$id) { $accceptance_safety_name=strtoupper($fet['first_name']); break; }
	  }
  }
  
	$acceptance_safety_date=(isset($records['acceptance_safety_date']) && $records['acceptance_safety_date']!='') ? 
	date('d-m-Y H:i',strtotime($records['acceptance_safety_date'])).$hrs : '';	

	$table.='<tr>
		<td colspan="1" style="border-top:1px solid #ccc;"><strong> </strong> </td>
		<td style="border-top:1px solid #ccc;border-left:1px solid #ccc;"></td>
		<td style="border-top:1px solid #ccc;border-left:1px solid #ccc;"></td>
		<td colspan="4" style="border-left:1px solid #ccc;border-top:1px solid #ccc;">Safety Sign : <strong>'.$accceptance_safety_name.'</strong></td>
		<td colspan="2" style="border-left:1px solid #ccc;border-top:1px solid #ccc;">Sign/Date&Time: <strong>'.$acceptance_safety_date.'</strong></td>
		<td style="border-left:1px solid #ccc;border-top:1px solid #ccc;"colspan="3"></td>
		<td style="border-left:1px solid #ccc;border-top:1px solid #ccc;" colspan="3"></td> 
	</tr>

	</table></td></tr>';


	$table.='<tr>
		<td style="border: 1px solid #cccccc;"><strong>Revalidation:</strong></td>
		<td style="border:1px solid #ccc;"colspan="12">I have visited the work area and checked the oxygen leave, found it well within the requirement of this permit and the readings are as follows:</td></tr>';
	
	$schedule_date=json_decode($records['schedule_date']);

	$extended_ranges=range('a','f');

	$td='';

	 foreach($extended_ranges as $extended_range)
	 {
	 	$sch_date=(isset($schedule_date->$extended_range)) ? '<b>'.$schedule_date->$extended_range.'</b>' : '';

	 	if($extended_range=='a')
	 	$td='<td style="border-right: 1px solid #cccccc;"  width="5%">Date:'.$sch_date.'</td>';
	 	else
	 	$td.='<td colspan="2" style="border-right: 1px solid #cccccc;">Date: '.$sch_date.'</td>';	
	 }

	$table.='<tr><td colspan="15" style="padding:0px;">
	<table style="border-collapse:collapse;padding:0px;width:50%;" align="center">
	<tr>		
		<td colspan="3" style="border-left:1px solid #cccccc;border-right:1px solid #cccccc;" width="5%">Time Interval</td>'.$td.'		
		</tr>';

	

     if(isset($records))
     $schedule_from_time=json_decode($records['schedule_from_time']);
     else
     $schedule_from_time=array();
 
     if(isset($records))
     $schedule_to_time=json_decode($records['schedule_to_time']);
     else
     $schedule_to_time=array();

     if(isset($records))
     $watch_person_from_time=json_decode($records['watch_person_from_time']);
     else
     $watch_person_from_time=array();
 
     if(isset($records))
     $watch_person_to_time=json_decode($records['watch_person_to_time']);
     else
     $watch_person_to_time=array();     	

 	$time_td=$wpn_td='';	

	foreach($extended_ranges as $extended_range)	
	{
		$from_time_period=(isset($schedule_from_time->$extended_range) && $schedule_from_time->$extended_range!='') ? $schedule_from_time->$extended_range.$hrs : '&nbsp;';

		$to_time_period=(isset($schedule_to_time->$extended_range) && $schedule_to_time->$extended_range!='') ? $schedule_to_time->$extended_range.$hrs : '&nbsp;';

		$from_watch_person=(isset($watch_person_from_time->$extended_range)) ? strtoupper($watch_person_from_time->$extended_range) : '';

		$to_watch_person=(isset($watch_person_to_time->$extended_range)) ? strtoupper($watch_person_to_time->$extended_range) : '';

		if($extended_range=='a')
		{
			$time_td='<td style="border-right: 1px solid #cccccc;border-top: 1px solid #cccccc;" width="5%">'.$to_time_period.'</td>';

			$wpn_td='<td style="border: 1px solid #cccccc;" >'.$to_watch_person.'</td>';
		}
		else
		{
			$time_td.='<td style="border: 1px solid #cccccc;" width="5%">'.$from_time_period.'</td><td width="5%" style="border: 1px solid #cccccc;">'.$to_time_period.'</td>';

			$wpn_td.='<td style="border: 1px solid #cccccc;">'.$from_watch_person.'</td><td style="border: 1px solid #cccccc;">'.$to_watch_person.'</td>';
		}	

	}

$table.='<tr><td style="border: 1px solid #cccccc;"colspan="3" ></td>'.$time_td.'
</tr>

<tr>
<td style="border: 1px solid #cccccc;" colspan="3">Watch Person Name : </td>'.$wpn_td.'
</tr>


<tr>
	<td style="border: 1px solid #cccccc;width:10px !important;" colspan="3">Sl.No</td>	
	<td style="border: 1px solid #cccccc;" colspan="11">Name of the personnel involved in the confined space work :</td>
</tr>';

     if(isset($records))
     $watch_other_person_from_names=json_decode($records['watch_other_person_from_names'],true);
     else
     $watch_other_person_from_names=array();
 
     if(isset($records))
     $watch_other_person_to_names=json_decode($records['watch_other_person_to_names'],true);
     else
     $watch_other_person_to_names=array();

 	 #echo '<pre>'; print_r($watch_other_person_to_names);

 	$approval_status = $records['approval_status'];

 /*	if($approval_status==4)
 	$row_count=1;
 	else
 	$row_count=15;	
*/

 	$schedule_date=json_decode($records['schedule_date']);
	
	$extended_ranges=range('a','f');

	$rr=0;

	 foreach($extended_ranges as $extended_range)
	 {
	 	$sch_date=(isset($schedule_date->$extended_range)) ? '<b>'.$schedule_date->$extended_range.'</b>' : '';

	 

	 	if($sch_date=='<b></b>')
	 		$rr++;
	 }

	 if($rr==6)
	 	$row_count=1;
 	 else
 		$row_count=15;

	
	for($i=1;$i<=$row_count;$i++)
	{ 
		$wopn='';

		foreach($extended_ranges as $extended_range)	
		{
			$to_other_name=(isset($watch_other_person_to_names[$extended_range][$i])) ? strtoupper($watch_other_person_to_names[$extended_range][$i]) : '';
			$from_other_name=(isset($watch_other_person_from_names[$extended_range][$i])) ? strtoupper($watch_other_person_from_names[$extended_range][$i]) : '';

			if($extended_range=='a')		
				$wopn='<td style="border: 1px solid #cccccc;">'.$to_other_name.'</td>';			
			else
				$wopn.='<td style="border: 1px solid #cccccc;">'.$from_other_name.'</td><td style="border: 1px solid #cccccc;">'.$to_other_name.'</td>';	

		}	

		$table.='<tr><td style="border: 1px solid #cccccc;width:10px !important;" colspan="3">'.$i.'</td>'.$wopn.'</tr>';
	} 

	

     if(isset($records))
     {
        $extended_to_oxygen_reading=json_decode($records['extended_to_oxygen_reading']);

        $extended_from_oxygen_reading=json_decode($records['extended_from_oxygen_reading']);

        $extended_from_gases_reading=json_decode($records['extended_from_gases_reading']);

        $extended_to_gases_reading=json_decode($records['extended_to_gases_reading']);

        $extended_from_carbon_reading=json_decode($records['extended_from_carbon_reading']);

        $extended_to_carbon_reading=json_decode($records['extended_to_carbon_reading']);

        $extended_performing_to_authority=json_decode($records['extended_performing_to_authority']);

        $extended_performing_from_authority=json_decode($records['extended_performing_from_authority']);

        $extended_safety_to_sign_id=json_decode($records['extended_safety_to_sign_id']);

        $extended_safety_from_sign_id=json_decode($records['extended_safety_from_sign_id']);   
        
        $extended_issuing_to_authority=json_decode($records['extended_issuing_to_authority']);

        $extended_issuing_from_authority=json_decode($records['extended_issuing_from_authority']); 

        $extended_reference_code_from=json_decode($records['extended_reference_code_from']);

        $extended_reference_code_to=json_decode($records['extended_reference_code_to']);

     	$extend_issuing_authority_name_of_to_ia=json_decode($records['extend_issuing_authority_name_of_to_ia']);

     	$extend_issuing_authority_name_of_from_ia=json_decode($records['extend_issuing_authority_name_of_from_ia']);
   
    
     }   
     else
     $extended_to_oxygen_reading=$extended_from_oxygen_reading=$extended_from_gases_reading=$extended_to_gases_reading=$extended_from_carbon_reading=$extended_to_carbon_reading=$extended_performing_to_authority=$extended_performing_from_authority=$extended_safety_to_sign_id=$extended_safety_from_sign_id=$extended_issuing_to_authority=$extended_issuing_from_authority=$extended_reference_code_from=$extended_reference_code_to=$extend_issuing_authority_name_of_from_ia=$extend_issuing_authority_name_of_to_ia=array();

 	$oxy_td=$combustible_td=$carbon_td=$pa_td=$sa_td=$ia_td=$ref_td='';

 	

	foreach($extended_ranges as $extended_range)	
	{
		$from_carbon=(isset($extended_from_carbon_reading->$extended_range)) ? strtoupper($extended_from_carbon_reading->$extended_range) : '';
		$to_carbon=(isset($extended_to_carbon_reading->$extended_range)) ? strtoupper($extended_to_carbon_reading->$extended_range) : '';

		$from_oxygen=(isset($extended_from_oxygen_reading->$extended_range)) ? strtoupper($extended_from_oxygen_reading->$extended_range) : '';
		$to_oxygen=(isset($extended_to_oxygen_reading->$extended_range)) ? strtoupper($extended_to_oxygen_reading->$extended_range) : '';

		$from_gases=(isset($extended_from_gases_reading->$extended_range)) ? strtoupper($extended_from_gases_reading->$extended_range) : '';

		$to_gases=(isset($extended_to_gases_reading->$extended_range)) ? strtoupper($extended_to_gases_reading->$extended_range) : '';


		$from_ref=(isset($extended_reference_code_from->$extended_range)) ? strtoupper($extended_reference_code_from->$extended_range) : '';

		$to_ref=(isset($extended_reference_code_to->$extended_range)) ? strtoupper($extended_reference_code_to->$extended_range) : '';


		$from_pa_id=(isset($extended_performing_from_authority->$extended_range)) ? strtoupper($extended_performing_from_authority->$extended_range) : '';

		$to_pa_id=(isset($extended_performing_to_authority->$extended_range)) ? strtoupper($extended_performing_to_authority->$extended_range) : '';

		$from_pa_name=get_user_name($authorities,$from_pa_id);

		$to_pa_name=get_user_name($authorities,$to_pa_id);


		$from_sa_id=(isset($extended_safety_from_sign_id->$extended_range)) ? strtoupper($extended_safety_from_sign_id->$extended_range) : '';
		$to_sa_id=(isset($extended_safety_to_sign_id->$extended_range)) ? strtoupper($extended_safety_to_sign_id->$extended_range) : '';

		$from_sa_name=get_user_name($safety_authorities,$from_sa_id);

		$to_sa_name=get_user_name($safety_authorities,$to_sa_id);


		$from_ia_id=(isset($extended_issuing_from_authority->$extended_range)) ? strtoupper($extended_issuing_from_authority->$extended_range) : '';

		$to_ia_id=(isset($extended_issuing_to_authority->$extended_range)) ? strtoupper($extended_issuing_to_authority->$extended_range) : '';

		$from_ia_name=get_user_name($authorities,$from_ia_id);

		$to_ia_name=get_user_name($authorities,$to_ia_id);

		$ext_ia_from=(isset($extend_issuing_authority_name_of_from_ia->$extended_range)) ? strtoupper($extend_issuing_authority_name_of_from_ia->$extended_range) :'';	

		$ext_ia_to=(isset($extend_issuing_authority_name_of_to_ia->$extended_range)) ? strtoupper($extend_issuing_authority_name_of_to_ia->$extended_range) :'';	 
	 


		if($extended_range=='a')
		{
			$oxy_td='<td style="border: 1px solid #cccccc;">'.$to_oxygen.'</td>';

			$combustible_td='<td style="border: 1px solid #cccccc;">'.$to_gases.'</td>';

			$carbon_td='<td style="border: 1px solid #cccccc;">'.$to_carbon.'</td>';

			$pa_td='<td style="border: 1px solid #cccccc;">'.$to_pa_name.'</td>';

			$sa_td='<td style="border: 1px solid #cccccc;">'.$to_sa_name.'</td>';

			$ia_td='<td style="border: 1px solid #cccccc;">'.$to_ia_name.'<br /><p><b>Name of IA:</b><br />'.$ext_ia_to.'</p></td>';

			$ref_td='<td style="border: 1px solid #cccccc;">'.$to_ref.'</td>';
		}	
		else
		{
			$oxy_td.='<td style="border: 1px solid #cccccc;">'.$from_oxygen.'</td><td style="border: 1px solid #cccccc;">'.$to_oxygen.'</td>';

			$combustible_td.='<td style="border: 1px solid #cccccc;">'.$from_gases.'</td><td style="border: 1px solid #cccccc;">'.$to_gases.'</td>';

			$carbon_td.='<td style="border: 1px solid #cccccc;">'.$from_carbon.'</td><td style="border: 1px solid #cccccc;">'.$to_carbon.'</td>';

			$pa_td.='<td style="border: 1px solid #cccccc;">'.$from_pa_name.'</td><td style="border: 1px solid #cccccc;">'.$to_pa_name.'</td>';

			$sa_td.='<td style="border: 1px solid #cccccc;">'.$from_sa_name.'</td><td style="border: 1px solid #cccccc;">'.$to_sa_name.'</td>';

			$ia_td.='<td style="border: 1px solid #cccccc;">'.$from_ia_name.'<br /><p><b>Name of IA:</b><br />'.$ext_ia_from.'</p></td><td style="border: 1px solid #cccccc;">'.$to_ia_name.'<br /><p><b>Name of IA:</b><br />'.$ext_ia_to.'</p></td>';	

			$ref_td.='<td style="border: 1px solid #cccccc;">'.$from_ref.'</td><td style="border: 1px solid #cccccc;">'.$to_ref.'</td>';
		}

	}	

$table.='<tr><td style="border: 1px solid #cccccc;" colspan="3">%of Oxygen</td>'.$oxy_td.'
</tr>

<tr><td style="border: 1px solid #cccccc;" colspan="3">Combustible gases %</td>'.$combustible_td.'
</tr>

<tr><td style="border: 1px solid #cccccc;" colspan="3">Carbon Monoxide %</td>'.$carbon_td.'
</tr>

<tr><td style="border: 1px solid #cccccc;" colspan="3">PA</td>'.$pa_td.'
</tr>

<tr><td style="border: 1px solid #cccccc;" colspan="3">IA</td>'.$ia_td.'
</tr>

<tr><td style="border: 1px solid #cccccc;" colspan="3">SA</td>'.$sa_td.'
</tr>
<tr><td style="border: 1px solid #cccccc;" colspan="3">Ref Code</td>'.$ref_td.'
</tr>
</table></td></tr>

	
	<tr>
	<td colspan="15" style="border:1px solid #ccc;font-size: 10px !important;"><strong>'.EMERGENCY_CONTACT_NUMBER.'</strong></td> </tr>
</table><pagebreak />';


	$fontSize="font-size:10vw !important;";
	
	$table_border=$row_border='border:1px solid #000000;border-collapse: collapse;table-layout: fixed;';

	$row_height='height:20px;'.$fontSize;

	/* Page 5 */

	$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;margin-top:450px;"  align="center">
    <colgroup>
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
        <col width="5%"><col width="5%">
    </colgroup>';
   $table.=' <tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" height="34"></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg"  height="34"></td>
    </tr>';
	$table.='</table>';

$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;margin:0 auto;border-collapse:collapse;table-layout: fixed ;"  align="center">
<tr style="'.$row_height.'">
	<td colspan="7" align="center" style="'.$row_height.'"><h2>ANNEXURE-E</h2>
	 <br />
	<p style="'.$row_height.'">Additional sheet for GAS TEST RECORD</p>
	<br />
	<p style="'.$row_height.'">	Oxygen meter, LEL Meter, Toxic Gas Detector should have the sticker indicating the Date of last Calibration & due date of calibration by CES.	Reading are measured at interval not more than two hours aprt.</p>
	<br />
	</td>
</tr>';

$row_height='height:37px;'.$fontSize;

$table.='<tr style="'.$row_height.$table_border.'">
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Date</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Time (Hrs.)</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Oxygen %</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>LEL</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Toxicity, PPM</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Name</b></td>
	<td style="'.$row_height.$table_border.'text-align:center;"><b>Signature</b></td>
</tr>';



	for($p=1;$p<=10;$p++)
	{

		$table.='<tr style="'.$row_height.$table_border.'">'.str_repeat("<td  style='".$row_height.$table_border."'>&nbsp;</td>",7).'</tr>';

	}
$table.='</table>';


$table.='</body></html>';

#echo $table; exit;

include_once APPPATH.'/third_party/mpdf60/mpdf.php';

$header="";

$footer="";

$mpdf=new mPDF('c','A4-L','','',10,10,10,10,10,10);
//                             L,R,T,
$mpdf->SetDisplayMode('fullpage');


$mpdf->SetHTMLHeader($header);
$mpdf->SetFooter($footer.'{PAGENO}');
//$mpdf->setFooter('{PAGENO}');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a li
// LOAD a stylesheet
#$stylesheet = file_get_contents(include_once APPPATH.'/third_party/mpdf60/style.css');
#$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($table,2);

$path = UPLODPATH.'uploads/permits/'.$records['id'];

if (!file_exists($path)) 
mkdir($path);

$file_name='/permit'.time().'.pdf';

$file=$path.$file_name;

$mpdf->Output($file,'F');

echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$records['id'].$file_name));
exit;

?>

