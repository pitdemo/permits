<?php


#echo '<pre>'; print_r($records); #exit;


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

function checkbox($array_args)
{		
	extract($array_args);
	
	$style=(isset($style)) ? 'style="'.$style.'"' : '';	
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />';
}


$table='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body><table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
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

	$table.='<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr>
	
	<tr>
      <td style="border:1px solid #ccc; width: 20% !important;vertical-align: top;" colspan="3">&nbsp;</td>
	  <td colspan="3"  style="border:1px solid #ccc;width: 20% !important; vertical-align: top;">&nbsp;</td>
	  <td style="border:1px solid #ccc;width: 20% !important;vertical-align: top;"colspan="3" >&nbsp;</td>
	</tr>
	
	<tr>
		<td style="border:1px solid #ccc;" colspan="2"></td>			
		<td style="border:1px solid #ccc;" colspan="2" align="center">Date & Time</td>
		<td style="border:1px solid #ccc;" colspan="3" ><strong>Hazards / concersn identified:</strong></td>
		<td style="border:1px solid #ccc;"><center><strong>YES / NO</strong></center></td>
		<td style="border:1px solid #ccc !important;"colspan="4"><strong>Precautions to be Taken :</strong></td>
		<td style="border:1px solid #ccc;"><center><strong>YES / NA</strong></center></td> </tr>
		
		
	</tr>';
	$location=(isset($records['location'])) ? '<b>'.strtoupper($records['location']).'</b>' : '';


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

  $haz_options=array(); $pre_options=array();
  if(isset($hazards_options->a))
  {
	  $haz_options=explode('|',rtrim($hazards_options->a,'|'));	
  }
	
  $electrical_checked  = (in_array('Electrical shock to the personal',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
  
  $electrocution_checked = (in_array('Electrocution',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

  $haz=(isset($hazards->a)) ? strtoupper($hazards->a) : '';
  
  $haz_yes=$haz_no='';
  
  if($haz=='Yes')
  $haz_yes=$checked;
  else if($haz=='No')
  $haz_no=$checked; 
  
  $pre_text= (isset($precautions_text->a)) ? '<br /><b>'.strtoupper($precautions_text->a).'</b>' : '';
  
  $pre=(isset($precautions->a)) ? strtoupper($precautions->a) : '';
  
  $location_time_start=(isset($records['location_time_start'])) ? $records['location_time_start'].$hrs : '';	

  $location_time_to=(isset($records['location_time_to'])) ? $records['location_time_to'].$hrs : '';	

	$table.='<tr>
		<td style="border:1px solid #ccc;vertical-align:top"rowspan="6" colspan="2">Location<br /><br/>'.$location.'</td>
		
		<td style="border:1px solid #ccc;vertical-align:top;padding:0px;"colspan="2" rowspan="6" align="center">
			<table style="width:100%;height:100%; border-collapse:collapse">	
			
				<tr>
					<td style="border-bottom:1px solid #ccc;border-right:1px solid #ccc; vertical-align:middle;text-align:left;">From</td>
					<td style="text-align:left;border-bottom:1px solid #ccc;border-right:1px solid #ccc; vertical-align:middle;">'.$location_time_start.'</td>
				</tr>
				
				<tr>
					<td style="border:1px solid #ccc; vertical-align:top;">To</td>
					<td style="border:1px solid #ccc; vertical-align:top;">'.$location_time_to.'</td>
				</tr>
				
			</table>
		
		</td>
				
		<td style="border:1px solid #ccc;vertical-align:top;" rowspan="6" colspan="3">
			a) '.$electrical_checked.' Electrical shock to the personal 
			'.$electrocution_checked.' Electrocution </td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" rowspan="6">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
			a) (i)Work area isolated by opening MCCB/ACB/SFU/VCB/AB Switch /MCB is isolated / Fuse removed locked and tagged'.$pre_text.'</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';
	
	 $pre=(isset($precautions->aii)) ? strtoupper($precautions->aii) : '';

	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      ii) Ruber mat provided</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

	$pre=(isset($precautions->aiii)) ? strtoupper($precautions->aiii) : '';
	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      iii) Proper elect connection, Dryness of, floor ensured</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

	$pre=(isset($precautions->aiv)) ? strtoupper($precautions->aiv) : '';

	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      iv) Discharge using suitable discharge rods/Earthing trolleys</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

	$pre=(isset($precautions->av)) ? strtoupper($precautions->av) : '';
	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      v) Ensure proper clearness from OH line if any</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

	$pre=(isset($precautions->avi)) ? strtoupper($precautions->avi) : '';

	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      vi) Electrical hard Gloves / Tools inspected</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	

	$equipment_name = (isset($records['equipment_name'])) ? strtoupper($records['equipment_name']) : '';

	$haz=(isset($hazards->b)) ? strtoupper($hazards->b) : '';

	$pre=(isset($precautions->b)) ? strtoupper($precautions->b) : '';

	  if(isset($hazards_options->b))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->b,'|'));	
	  }	

	  $pre_text= (isset($precautions_text->b)) ? '<br /><b>'.strtoupper($precautions_text->b).'</b>' : '';

 	  $equipment_checked = (in_array('Equipment Accidental Back Charge',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

 	  $interconnection_checked = (in_array('Interconnection available',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

	 $table.='<tr>
		 <td style="border:1px solid #ccc;"colspan="4"><strong>Equipment name: </strong>'.$equipment_name.' </td>
		 <td style="border:1px solid #ccc;"colspan="3">b) '.$equipment_checked.' Equipment Accidental Back Charge '.$interconnection_checked.' Interconnection available</td>
		 <td style="border:1px solid #ccc;" align="center">'.$haz.'</td>
		 <td style="border:1px solid #ccc;"colspan="4">b) All possible back feeding supplies are disconnected '.$pre_text.'</td>
		 <td style="border:1px solid #cccccc;"  align="center">'.$pre.'</td>
	 </tr>';

	 $nature_of_job=(isset($records['job_name'])) ? strtoupper($records['job_name']) : '';

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
	  $na_active=$checked;

	  if(isset($precautions_options->c))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->c,'|'));	
	  }
	  if(isset($hazards_options->c))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->c,'|'));	
	  }	

	  $presence_checked  = (in_array('Presense of residual energy in equipment',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	  $capacitor_checked  = (in_array('Capacitor',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	  $cables_checked  = (in_array('Cables',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
  	 
  	 $line_checked  = (in_array('Line',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
  	 $equipment_checked  = (in_array('Equipment',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
  	 $areabarricated_checked  = (in_array('Areabarricated',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

  	
	$haz=(isset($hazards->c)) ? strtoupper($hazards->c) : '';

	$pre=(isset($precautions->c)) ? strtoupper($precautions->c) : '';

	 $table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4" rowspan="3" valign="top"><strong>Nature of Job : </strong>'.$nature_of_job.' <br /><br />
		<p><b>Is EIP obtained</b><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$yes_existing_active.'>Yes&Existing&nbsp;<input type="radio" '.$no_active.'>Existing&nbsp;<input type="radio" '.$na_active.'>N/A</p><br />
		<p><b>If yes Energy isolation Permit No : </b> '.$eip_yes_selection.'</p>
		</td>				
		<td style="border:1px solid #ccc;vertical-align:top;" rowspan="3" colspan="3">
c) '.$presence_checked.' Presense of residual energy in equipment '.$capacitor_checked.' capacitor '.$cables_checked.' Cables &amp; Presense of Unauthorised entry into work area
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" rowspan="3">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
				c) (i) Line '.$line_checked.' Equipment is disconnected, if required '.$equipment_checked.' Earthed and earth  continuity checked '.$areabarricated_checked.' Areabarricated</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';
	
	 if(isset($precautions_options->cii))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->cii,'|'));	
	  }	

	  $danger_checked  = (in_array('Danger',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

	  $safety_checked  = (in_array('Safety',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	 
	 $pre=(isset($precautions->cii)) ? strtoupper($precautions->cii) : '';
	  	
	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      ii) '.$danger_checked.' Danger Board '.$safety_checked.' Safety tag displayed.</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

			  if(isset($precautions_options->ciii))
              {
                $pre_options=explode('|',rtrim($precautions_options->ciii,'|')); 
              }

              $wait_checked  = (in_array('wait',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

              $earthing_checked  = (in_array('Earthing',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

              $pre=(isset($precautions->ciii)) ? strtoupper($precautions->ciii) : '';

	$table.='
	<tr><td style="border:1px solid #ccc;"colspan="4">      iii) '.$wait_checked.' Wait for 1Minute after switching off the Power supply and Ensure Capacitors were discharged by using proper discharge rod '.$earthing_checked.' Earthing trolleys </td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	
	  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';	
	  
	  $contractor_name='';	
	  
	  if($contractors->num_rows()>0)
	  {
		 $contractors=$contractors->result_array();
	  
		foreach($contractors as $list)
		{
			if($select_contractor_id==$list['id']) { $contractor_name=strtoupper($list['name']); break; } 
		}
	  }
	  
	  if($select_contractor_id=='others')
	  $contractor_name=(isset($records['other_contractors'])) ? strtoupper($records['other_contractors']) : '';
	  
	  $contractors_involved=(isset($records['contractors_involved'])) ? $records['contractors_involved'] : '';

			  if(isset($hazards_options->d))
              {
                $haz_options=explode('|',rtrim($hazards_options->d,'|')); 
              }

              $electrical_checked  = (in_array('Electrical',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
              
              $breaker_checked  = (in_array('breaker',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
              
              $mcc_checked  = (in_array('mcc',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	
			  $haz=(isset($hazards->d)) ? $hazards->d : '';	

			  $pre=(isset($precautions->d)) ? strtoupper($precautions->d) : '';	

			 
		$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="2" rowspan="2"><strong>Name of the Contractor : </strong>'.$contractor_name.' </td>
		<td style="border:1px solid #ccc;"colspan="2" rowspan="2"><strong>No of Persons involved : </strong>'.$contractors_involved.' </td>
		
				
		<td style="border:1px solid #ccc;vertical-align:top;" rowspan="2" colspan="3">
		d) '.$electrical_checked.' Electrical Fire while racking out '.$breaker_checked.' in of breaker '.$mcc_checked.' MCC Feeder Module
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" rowspan="2">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
				d) i) Using suitable fire suit & SOP</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

	 $pre=(isset($precautions->dii)) ? strtoupper($precautions->dii) : '';	
	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      ii) Ensure nearby Eyewash towers are working properly </td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';


	$height_works_involved=(isset($records['height_works_involved'])) ? strtoupper($records['height_works_involved']) : '';

	$haz=(isset($hazards->e)) ? $hazards->e : '';	

			  if(isset($precautions_options->e))
              {
                $pre_options=explode('|',rtrim($precautions_options->e,'|')); 
              }

              $availability_checked  = (in_array('Availability',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	

              $tender_checked  = (in_array('Tender',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

	 $pre=(isset($precautions->e)) ? strtoupper($precautions->e) : '';	

	 $table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4" rowspan="2"><strong>If Electrical works involved are at height, work at height permit no :</strong> '.$height_works_involved.'</td>
				
		<td style="border:1px solid #ccc;vertical-align:top;" rowspan="2" colspan="3">
		e)Fire during work activity
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" rowspan="2">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
				e) i) '.$availability_checked.' Availability of fire extinguisher '.$tender_checked.' Tender Ensuired</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

	$pre=(isset($precautions->eii)) ? strtoupper($precautions->eii) : '';	

	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">      ii) Ensure nearby water line to suppress the fire</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	
	$confined_space_involved = (isset($records['confined_space_involved'])) ? $records['confined_space_involved'] : '';

	$haz=(isset($hazards->f)) ? $hazards->f : '';	

	$pre=(isset($precautions->f)) ? strtoupper($precautions->f) : '';	

	 $table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4" rowspan="2"><strong>If Electrical works involved are at Confined space, confgined space no : </strong> '.$confined_space_involved.'</td>
				
		<td style="border:1px solid #ccc;vertical-align:top;"  colspan="3">
		f) Poor illumination in night 
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
				f) Adequate illumination provided</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';
	$haz=(isset($hazards->g)) ? $hazards->g : '';	

	$pre=(isset($precautions->g)) ? strtoupper($precautions->g) : '';	

	$table.='<tr>
	<td style="border:1px solid #ccc;vertical-align:top;" colspan="3">
		g) Poor Ventilation
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center">'.$haz.'</td>
	<td style="border:1px solid #ccc;"colspan="4">g) Proper ventilation facilities provided</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

	$haz=(isset($hazards->h)) ? $hazards->h: '';	

	$pre=(isset($precautions->h)) ? strtoupper($precautions->h) : '';	

$other_inputs=(isset($records['other_inputs'])) ? explode(',',rtrim($records['other_inputs'],',')) : array();
	   
	   $other_checked1=(in_array('SOP',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   $other_checked2=(in_array('Work instructions clearly explained to the all the members',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   $other_checked3=(in_array('Peptalk',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   if(in_array('Peptalk',$other_inputs))
	   $other_peptalk=(isset($records['other_inputs_text']) && $records['other_inputs_text']!='') ? '(<b>'.strtoupper($records['other_inputs_text']).'</b>)<br />' : '';	
	   else
	   $other_peptalk='<br />';	

	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4" rowspan="2">'.$other_checked1.' SOP <br /><br />
	 '.$other_checked2.' Work instructions clearly explained to the all the members in the working Group<br /><br />
	 '.$other_checked3.' Peptalk '.$other_peptalk.'</td>
				
		<td style="border:1px solid #ccc;vertical-align:top;" rowspan="2" colspan="3">
		h) NDT Equipment are used (Megger/Multimeter, etc.)
		</td>
		<td style="border: 1px solid #cccccc;vertical-align:top;" align="center" rowspan="2">'.$haz.'</td>
		<td style="border:1px solid #ccc;"colspan="4">      
				h) i) Having valid calibration certificate</td>    
		<td style="border:1px solid #cccccc;" align="center">'.$pre.'</td>
	</tr>';

	$pre=(isset($precautions->hii)) ? strtoupper($precautions->hii) : '';	

	$table.='<tr><td style="border:1px solid #ccc;"colspan="4">ii) By using standard / quality probes</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

$hazards_other = (isset($records['hazards_other'])) ? '<b>'.strtoupper($records['hazards_other']).'</b>' : '';

$precautions_other = (isset($records['precautions_other'])) ? '<b>'.strtoupper($records['precautions_other']).'</b>' : '';


	$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4" rowspan="2" align="center"><strong>Required PPE</strong></td>
				
		<td style="border:1px solid #ccc;vertical-align:top;"  colspan="4">
		i) Others '.$hazards_other.'
		</td>
		
		<td style="border:1px solid #ccc;"colspan="5">      
				i) Others '.$precautions_other.'</td>    
		
	</tr>
	
	<tr>
	</tr>';

	$st=(isset($records['status'])) ? $records['status'] : '';
	
	$work_msg='Completion/Cancellation';
	
	if($st=='Completion' || $st == 'Cancellation')
	$work_msg=$st;

	/*$table.='<tr>
		<td style="border:1px solid #ccc;"colspan="4"  align="center"><strong>Required PPE</strong></td><td style="border:1px solid #ccc;"colspan="4" align="left"><span style="text-align:center;"><strong>Authorisation & Acceptance</strong></span><br><b>Performing Authority:</b<br></td><strong>Work '.$work_msg.' <br />Performing Authority:</strong></td><td style="border:1px solid #ccc;"colspan="4"></td></tr>';*/
	
	$table.='<tr rowspan="5"><td style="border:1px solid #ccc;"colspan="4" align="left"><span style="text-align:center;"><strong>Authorisation & Acceptance</strong></span><br><b>Performing Authority:</b></td><td style="border:1px solid #ccc;"colspan="5"><strong>Work '.$work_msg.' <br />Performing Authority:</strong></td></tr>';

			

  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();
  
    $helmet_checked=(in_array('Helmet',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));				

     $ladder_checked=(in_array('Insulted ladder',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));	

      $electrical_checked=(in_array('Electrical',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

      $fullbody_checked=(in_array('Fullbody',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

      $fuse_checked=(in_array('Fuse Puller',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

      $clamp_checked=(in_array('Clamp',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));


       $safety_shoes_checked=(in_array('Safety Shoes',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

		 $fire_checked=(in_array('Fire',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
       $goggles_checked=(in_array('Goggles',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

		 $earthing_trolleys_checked=(in_array('Earthing trolleys',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

		 $other_checked=(in_array('Others',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));

			
	$table.='<tr>
		<td style="border:1px solid #ccc; vertical-align: middle;" colspan="2">'.$helmet_checked.' <strong> Helmet</strong></td>
		<td style="border:1px solid #ccc;vertical-align: middle;"colspan="2">'.$ladder_checked.' <strong> Insulted ladder</strong> </td>
		<td style="border:1px solid #ccc;"colspan="4">I have had the contents fo this permit explained to me and I shall work in aordance with the ontrol measures identified.</td>
		<td style="border:1px solid #ccc;"colspan="5">Work completed, all persons are withdrawn and material removed from the area.</td>
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

	$acceptance_performing_date=(isset($records['acceptance_performing_date']) && $records['acceptance_performing_date']!='') ? '<br />'.date('d-m-Y H:i',strtotime($records['acceptance_performing_date'])).$hrs : '';
	
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
 	
	$cancellation_performing_date=(isset($records['cancellation_performing_date']) && $records['cancellation_performing_date']!='') ? '<br />'.date('d-m-Y H:i',strtotime($records['cancellation_performing_date'])).$hrs : '';
	
			
	$table.='<tr>
		<td style="border: 1px solid #cccccc;" colspan="2">'.$electrical_checked.' <strong> Electrical gloves 440/17KV</strong></td>
		<td style="border:1px solid #ccc;"colspan="2">'.$fullbody_checked.' <strong>Fullbody Harness</strong></td>
		<td style="border:1px solid #ccc;"colspan="2">Name : <strong>'.$acceptance_performing_name.'</strong> </td>
		<td style="border:1px solid #ccc;" colspan="2">
	Digitally Sign/Date&Time: <b><br />'.$acceptance_performing_date.'</b></td> 
		<td style="border:1px solid #ccc;"colspan="3">Name : <strong>'.$cancellation_performing_name.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2">Digitally Sign/Date&Time: <b>'.$cancellation_performing_date.'</b></td>
	</tr>
	
	<tr>
		<td style="border:1px solid #ccc;font-size: 8px;" colspan="2">'.$fuse_checked.' <strong> Fuse Puller </strong> </td>
		<td style="border:1px solid #ccc;"colspan="2">'.$clamp_checked.'<strong> Clamp/Multi Meter/Meggar</strong></td>
		<td style="border:1px solid #ccc;"colspan="4"><strong>Issuing Authority: </strong></td>
		<td style="border:1px solid #ccc;"colspan="5"> <strong>Issuing Authority:</strong></td>
	</tr>
	
	
	<tr>
		<td style="border: 1px solid #cccccc;" colspan="2">'.$safety_shoes_checked.' <strong> Insulated Safety Shoes</strong> </td>
		<td style="border:1px solid #ccc;"colspan="2">'.$fire_checked.' <strong> Fire Proof sult</strong></td>
		<td style="border:1px solid #ccc;"colspan="4">I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the holder and work may proceed. </td>
		<td style="border:1px solid #ccc;"colspan="5">I have inspected the work area and declare the work for whih the permit was issued has been properly performed</td>
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
$acceptance_issuing_date=(isset($records['acceptance_issuing_date']) && $records['acceptance_issuing_date']!='') ? '<br />'.date('d-m-Y H:i',strtotime($records['acceptance_issuing_date'])).$hrs : ''; 	
	
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
  
	$cancellation_issuing_date=(isset($records['cancellation_issuing_date']) && $records['cancellation_issuing_date']!='') ? '<br />'.
	date('d-m-Y H:i',strtotime($records['cancellation_issuing_date'])).$hrs : '';

	 $required_ppe_other=(isset($records['required_ppe_other'])) ? $records['required_ppe_other'] : '';

	$acceptance_name_of_ia=(isset($records['acceptance_name_of_ia'])) ? strtoupper($records['acceptance_name_of_ia']) : '';

	$cancellation_name_of_ia=(isset($records['cancellation_name_of_ia'])) ? strtoupper($records['cancellation_name_of_ia']) : '';
  	
	$table.='<tr>
		<td style="border: 1px solid #cccccc;" colspan="2">'.$goggles_checked.' <strong> Goggles </strong></td>
		<td style="border:1px solid #ccc;"colspan="2">'.$earthing_trolleys_checked.' <strong> Earthing trolleys </strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Name : </strong>'.$acceptance_issuing_name.'<br /><br /><p><b>Name of IA</b>: <br />'.$acceptance_name_of_ia.'</p></td>
		<td style="border:1px solid #ccc;" colspan="2">Digitally Sign/Date&Time: <strong><br />'.$acceptance_issuing_date.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="3">Name : <strong> '.$cancellation_issuing_name.'</strong><br /><br /><p><b>Name of IA</b>: <br />'.$cancellation_name_of_ia.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2">Digitally Sign/Date&Time: <strong>'.$cancellation_issuing_date.'</strong></td> 
	</tr>
	
	
	<tr>
		<td style="border: 1px solid #cccccc;" colspan="2">'.$other_checked.'<strong> Others </strong></td>
		<td style="border:1px solid #ccc;"colspan="2">'.$required_ppe_other.'</td>
		<td style="border:1px solid #ccc;"colspan="4"><td style="border:1px solid #ccc;"colspan="5"></td>
	</tr>';
	
	$self_cancellation_description=(isset($records['self_cancellation_description'])) ? strtoupper($records['self_cancellation_description']) : '';

	if(!empty($self_cancellation_description))
	$table.='<tr>
		<td style="border: 1px solid #cccccc;"><strong>Reason for cancellation:</strong></td>
		<td style="border:1px solid #ccc;"colspan="12">'.$self_cancellation_description.'</td>
	</tr>';
		
	$table.='<tr>
		<td style="border: 1px solid #cccccc;"><strong>Revalidation:</strong></td>
		<td style="border:1px solid #ccc;"colspan="12">I have visited the work area and understand and well omply with the requirements of this permit</td>
	</tr>';


     if(isset($records))
     $schedule_date=json_decode($records['schedule_date']);
     else
     $schedule_date=array();
	 
	 $s_date_a=(isset($schedule_date->a)) ? $schedule_date->a :'';
	  $s_date_b=(isset($schedule_date->b)) ? $schedule_date->b :'';
	   $s_date_c=(isset($schedule_date->c)) ? $schedule_date->c :'';
	   $s_date_d=(isset($schedule_date->d)) ? $schedule_date->d :'';
	    $s_date_e=(isset($schedule_date->e)) ? $schedule_date->e :'';
		 $s_date_f=(isset($schedule_date->f)) ? $schedule_date->f :''; 

	
	$table.='<tr>
		<td style="border:1px solid #ccc;"rowspan="4"><strong>SCHEDULE</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_a.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_b.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_c.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_d.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_e.'</strong></td>
		<td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_f.'</strong></td>
	</tr>
		
		
	<tr>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;"colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
	</tr>
	
	<tr>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>From</strong></td>
		<td style="border:1px solid #ccc;"align="center"><strong>To</strong></td>
	</tr>';
     if(isset($records))
     $schedule_from_time=json_decode($records['schedule_from_time']);
     else
     $schedule_from_time=array();
 
     if(isset($records))
     $schedule_to_time=json_decode($records['schedule_to_time']);
     else
     $schedule_to_time=array();

	 $f_time_a=(isset($schedule_from_time->a) && $schedule_from_time->a!='') ? $schedule_from_time->a.$hrs :'';
	 $f_time_b=(isset($schedule_from_time->b) && $schedule_from_time->b!='') ? $schedule_from_time->b.$hrs :'';
	 $f_time_c=(isset($schedule_from_time->c)  && $schedule_from_time->c!='') ? $schedule_from_time->c.$hrs :'';
	 $f_time_d=(isset($schedule_from_time->d)  && $schedule_from_time->d!='') ? $schedule_from_time->d.$hrs :'';
	 $f_time_e=(isset($schedule_from_time->e)  && $schedule_from_time->e!='') ? $schedule_from_time->e.$hrs:'';
	 $f_time_f=(isset($schedule_from_time->f)  && $schedule_from_time->f!='') ? $schedule_from_time->f.$hrs :'';
	 
	 $t_time_a=(isset($schedule_to_time->a)  && $schedule_to_time->a!='') ? $schedule_to_time->a.$hrs :'';
	 $t_time_b=(isset($schedule_to_time->b)  && $schedule_to_time->b!='') ? $schedule_to_time->b.$hrs :'';
	 $t_time_c=(isset($schedule_to_time->c)  && $schedule_to_time->c!='') ? $schedule_to_time->c.$hrs :'';  
	 $t_time_d=(isset($schedule_to_time->d)   && $schedule_to_time->d!='') ? $schedule_to_time->d.$hrs :'';  
	 $t_time_e=(isset($schedule_to_time->e)   && $schedule_to_time->e!='') ? $schedule_to_time->e.$hrs :'';  
	 $t_time_f=(isset($schedule_to_time->f)   && $schedule_to_time->f!='') ? $schedule_to_time->f.$hrs :''; 
	 	
	$table.='<tr>
		<td style="border:1px solid #ccc;height: 16px;" align="center"><b>'.$f_time_a.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_a.'</b></td><td style="border:1px solid #cccccc;"  align="center"><b>'.$f_time_b.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_b.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_c.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_c.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_d.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_d.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_e.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_e.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_f.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_f.'</b></td>
	</tr>';

	$contractor_name_a=$contractor_name_b=$contractor_name_c=$contractor_name_d=$contractor_name_e=$contractor_name_f='';

        if(isset($records))
	    {
	      $extended_contractors_id=json_decode($records['extended_contractors_id']);

	      $extended_others_contractors_id=json_decode($records['extended_others_contractors_id']);

	      $contractor_name='';	

	      $range=range('a','f');

	      	foreach($range as $ra)
	      	{
	      		$select_contractor_id=(isset($extended_contractors_id->$ra) && $extended_contractors_id->$ra!='') ? $extended_contractors_id->$ra : '';

	      		if($select_contractor_id!='others')
	      		{
					foreach($contractors as $list)
					{
						if($select_contractor_id==$list['id']) { ${"contractor_name_".$ra}=strtoupper($list['name']); break; } 
					}
				}
				else
				${"contractor_name_".$ra}=(isset($extended_others_contractors_id->$ra) && $extended_others_contractors_id->$ra!='') ? strtoupper($extended_others_contractors_id->$ra) : '';	
			}	
		
	   }   
	   else  
	   		$extended_contractors_id=$extended_others_contractors_id=array();

	  $table.='<tr>
		<td style="border:1px solid #ccc;font-size: 9px;height: 20px;"  ><strong>Name of the Contractor</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_b.'</b> </td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_e.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_f.'</b></td>
	</tr>'; 	


     if(isset($records))
     $no_of_persons=json_decode($records['no_of_persons']);
     else
     $no_of_persons=array();
	 
	 $no_a=(isset($no_of_persons->a)) ? $no_of_persons->a :'';
	  $no_b=(isset($no_of_persons->b)) ? $no_of_persons->b :'';
	   $no_c=(isset($no_of_persons->c)) ? $no_of_persons->c :'';
	    $no_d=(isset($no_of_persons->d)) ? $no_of_persons->d :'';
		 $no_e=(isset($no_of_persons->e)) ? $no_of_persons->e :'';
		  $no_f=(isset($no_of_persons->f)) ? $no_of_persons->f :'';


		  	
	$table.='<tr>
		<td style="border:1px solid #ccc;font-size: 9px;height: 20px;"  ><strong>No. of Persons Involved</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_b.'</b> </td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_e.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_f.'</b></td>
	</tr>';

     if(isset($records))
     $performing_authority=json_decode($records['performing_authority']);
     else
     $performing_authority=array();
	 
     if(isset($records))
     $issuing_authority=json_decode($records['issuing_authority']);
     else
     $issuing_authority=array();
	 
	
	$performing_authority_a=(isset($performing_authority->a)) ? $performing_authority->a : '';
	
	$performing_authority_name_a='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_a==$id) { $performing_authority_name_a=strtoupper($fet['first_name']); break; }
		  }
	  }


	$performing_authority_b=(isset($performing_authority->b)) ? $performing_authority->b : '';
	
	$performing_authority_name_b='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_b==$id) { $performing_authority_name_b=strtoupper($fet['first_name']); break; }
		  }
	  }


	$performing_authority_c=(isset($performing_authority->c)) ? $performing_authority->c : '';
	
	$performing_authority_name_c='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_c==$id) { $performing_authority_name_c=strtoupper($fet['first_name']); break; }
		  }
	  }


	$performing_authority_d=(isset($performing_authority->d)) ? $performing_authority->d : '';
	
	$performing_authority_name_d='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_d==$id) { $performing_authority_name_d=strtoupper($fet['first_name']); break; }
		  }
	  }


	$performing_authority_e=(isset($performing_authority->a)) ? $performing_authority->e : '';
	
	$performing_authority_name_e='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_e==$id) { $performing_authority_name_e=strtoupper($fet['first_name']); break; }
		  }
	  }

	$performing_authority_f=(isset($performing_authority->f)) ? $performing_authority->f : '';
	
	$performing_authority_name_f='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($performing_authority_f==$id) { $performing_authority_name_f=strtoupper($fet['first_name']); break; }
		  }
	  }
			
	
	$table.='<tr>
		<td style="border:1px solid #ccc;font-size: 9px;height: 20px"><strong>Performing Authority</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_b.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_e.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_f.'</b></td>
	</tr>';
	
	$issuing_authority_a=(isset($issuing_authority->a)) ? $issuing_authority->a : '';
	
	$issuing_authority_name_a='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_a==$id) { $issuing_authority_name_a=strtoupper($fet['first_name']); break; }
		  }
	  }

	$issuing_authority_b=(isset($issuing_authority->b)) ? $issuing_authority->b : '';
	
	$issuing_authority_name_b='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_b==$id) { $issuing_authority_name_b=strtoupper($fet['first_name']); break; }
		  }
	  }

	$issuing_authority_c=(isset($issuing_authority->c)) ? $issuing_authority->c : '';
	
	$issuing_authority_name_c='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_c==$id) { $issuing_authority_name_c=strtoupper($fet['first_name']); break; }
		  }
	  }

	$issuing_authority_d=(isset($issuing_authority->d)) ? $issuing_authority->d : '';
	
	$issuing_authority_name_d='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_d==$id) { $issuing_authority_name_d=strtoupper($fet['first_name']); break; }
		  }
	  }

	$issuing_authority_e=(isset($issuing_authority->e)) ? $issuing_authority->e : '';
	
	$issuing_authority_name_e='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_e==$id) { $issuing_authority_name_e=strtoupper($fet['first_name']); break; }
		  }
	  }


	$issuing_authority_f=(isset($issuing_authority->f)) ? $issuing_authority->f : '';
	
	$issuing_authority_name_f='';
	
	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  if($issuing_authority_f==$id) { $issuing_authority_name_f=strtoupper($fet['first_name']); break; }
		  }
	  }

	 if(isset($records))
     $extend_issuing_authority_name_of_ia=json_decode($records['extend_issuing_authority_name_of_ia']);
     else
     $extend_issuing_authority_name_of_ia=array();

     $ext_ia_a=(isset($extend_issuing_authority_name_of_ia->a)) ? strtoupper($extend_issuing_authority_name_of_ia->a) :'';	 
	 $ext_ia_b=(isset($extend_issuing_authority_name_of_ia->b)) ? strtoupper($extend_issuing_authority_name_of_ia->b) :'';	 
	 $ext_ia_c=(isset($extend_issuing_authority_name_of_ia->c)) ? strtoupper($extend_issuing_authority_name_of_ia->c) :'';	 
	 $ext_ia_d=(isset($extend_issuing_authority_name_of_ia->d)) ? strtoupper($extend_issuing_authority_name_of_ia->d) :'';	 
	 $ext_ia_e=(isset($extend_issuing_authority_name_of_ia->e)) ? strtoupper($extend_issuing_authority_name_of_ia->e) :'';	 
	 $ext_ia_f=(isset($extend_issuing_authority_name_of_ia->f)) ? strtoupper($extend_issuing_authority_name_of_ia->f) :'';	 


	$table.='<tr>
		<td style="border:1px solid #ccc;font-size: 9px;height: 20px;"> <strong>Issuing Authority</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_a.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_a.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_b.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_b.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_c.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_c.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_d.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_d.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_e.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_e.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_f.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_f.'</p></td>
	</tr>';

     if(isset($records))
     $reference_code=json_decode($records['reference_code']);
     else
     $reference_code=array();
	 
	 $ref_a=(isset($reference_code->a)) ? strtoupper($reference_code->a) :'';	 
	 $ref_b=(isset($reference_code->b)) ? strtoupper($reference_code->b) :'';	 
	 $ref_c=(isset($reference_code->c)) ? strtoupper($reference_code->c) :'';	 
	 $ref_d=(isset($reference_code->d)) ? strtoupper($reference_code->d) :'';	 
	 $ref_e=(isset($reference_code->e)) ? strtoupper($reference_code->e) :'';	 
	 $ref_f=(isset($reference_code->f)) ? strtoupper($reference_code->f) :'';		

	$table.='<tr>
		<td style="border:1px solid #ccc;font-size: 9px;height: 20px;"> <strong>Reference Code</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_b.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_e.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_f.'</b></td>
	</tr>
	
	<tr>
	<td colspan="13" style="border:1px solid #ccc;font-size: 10px !important;"><strong>'.EMERGENCY_CONTACT_NUMBER.'</strong></td> </tr>
</table></body></html>';

 


try
{
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
echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$records['id'].$file_name));
exit;

?>

