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


$table='';
//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8px; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">';
$location=(isset($records['location'])) ? '<b>'.strtoupper($records['location']).'</b>' : '';

  $location_time_start=(isset($records['location_time_start'])) ? '<b>'.$records['location_time_start'].$hrs.'</b>' : '';	

  $location_time_to=(isset($records['location_time_to'])) ? '<b>'.$records['location_time_to'].$hrs.'</b>' : '';	


$table.='<tr>
    <td style="border:1px solid #ccc;text-align:center;border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;" width="" colspan="11" id="t2"><h1>UT Pump Operation Permit</h1><h1>Permit No : #'.$records['permit_no'].'</h1> </td></tr>';
$table.='<tr><td style="border:1px solid #ccc;width:300px;border-left:1px solid #000;vertical-align:middle;" colspan="4"  rowspan="2"><table style="width:100%; border-collapse:collapse;font-family:Arial, Helvetica, sans-serif;font-size:9px;">	
			
				<tr>
					<td style="vertical-align:middle;text-align:left;">Location</td>
					
					<td style="vertical-align:middle;text-align:left;">From</td>
					
					<td style="vertical-align:middle;text-align:left;">To</td>
					
				</tr>

				<tr>
					
					<td style="text-align:left;vertical-align:middle;" >'.$location.'</td>
					
					<td style="text-align:left;vertical-align:middle;" >'.$location_time_start.'</td>
					
					<td style="text-align:left;vertical-align:middle;" >'.$location_time_to.'</td>
				</tr>


			</table></td><td style="border:1px solid #ccc;width:250px;">Hazard Identified : </td>
			<td style="border:1px solid #ccc;width:55px !important;text-align:center;" colspan="2">YES/NO</td><td style="border:1px solid #ccc;width:250px;" colspan="2">Checklist :</td>
			<td style="border:1px solid #ccc;width:55px;text-align:center;border-right:1px solid #000;" colspan="2">YES/NO</td></tr>';

//<td style="border:1px solid #ccc;border-right:1px solid #000;widht:5px">Remarks</td>

			 $nature_of_job=(isset($records['job_name'])) ? '<br /><b>'.strtoupper($records['job_name']).'</b>' : '';

 if(isset($records))
 $hazards=json_decode($records['hazards']);
 else
 $hazards=array();
 
 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();

 if(isset($records))
 $precautions_text=json_decode($records['precautions_text']);
 else
 $precautions_text=array();			 

  $haz=(isset($hazards->a)) ? strtoupper($hazards->a) : '';

  $pre=(isset($precautions->a)) ? strtoupper($precautions->a) : '';

  $pre_text= (isset($precautions_text->a)) ? '<br /><b>'.strtoupper($precautions_text->a).'</b>' : '';


$table.='<tr><td style="border:1px solid #ccc;" style="border:1px solid #ccc;">1) Safe Access of work area </td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"  colspan="2">1) Pump connected to proper water supply source'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;" align="center" colspan="2">'.$pre.'</td></tr>';

  $haz=(isset($hazards->b)) ? strtoupper($hazards->b) : '';

  $pre=(isset($precautions->b)) ? strtoupper($precautions->b) : '';

  $pre_text= (isset($precautions_text->b)) ? '<br /><b>'.strtoupper($precautions_text->b).'</b>' : '';


$table.='<tr><td rowspan="2" colspan="4" style="border:1px solid #cccccc;border-left:1px solid #000;">1) Nature of Job'.$nature_of_job.'</td><td style="border:1px solid #cccccc;">2) Spilage of Hot material</td><td style="border:1px solid #ccc;" colspan="2" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"  colspan="2">2) All hose joints connected properly'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';

  $haz=(isset($hazards->c)) ? strtoupper($hazards->c) : '';

  $pre=(isset($precautions->c)) ? strtoupper($precautions->c) : '';

  $pre_text= (isset($precautions_text->c)) ? '<br /><b>'.strtoupper($precautions_text->c).'</b>' : '';

$table.='<tr><td style="border:1px solid #cccccc;">3) Presence of Inflammables</td>
	<td style="border:1px solid #ccc;" colspan="2" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"  colspan="2">3) All hose joints thread tightened properly'.$pre_text.'</td>
	<td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';

  $haz=(isset($hazards->d)) ? strtoupper($hazards->d) : '';

  $pre=(isset($precautions->d)) ? strtoupper($precautions->d) : '';

  $pre_text= (isset($precautions_text->d)) ? '<br /><b>'.strtoupper($precautions_text->d).'</b>' : '';


	  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';	
	  
	  $contractor_name='';	
	  
	  if($contractors->num_rows()>0)
	  {
		 $contractors=$contractors->result_array();
	  
		foreach($contractors as $list)
		{
			if($select_contractor_id==$list['id']) { $contractor_name='<b>'.strtoupper($list['name']).'</b>'; break; } 
		}
	  }
	  
	  if($select_contractor_id=='others')
	  $contractor_name=(isset($records['other_contractors'])) ? '<b>'.strtoupper($records['other_contractors']).'</b>' : '';
	  
	  $contractors_involved=(isset($records['contractors_involved'])) ? '<b>'.$records['contractors_involved'].'</b>' : '';


	 $watch_other_person_names = (isset($records['watch_other_person_names'])) ? json_decode($records['watch_other_person_names']) : 
 array(0=>'');

	 $watch_other_person_names = array_filter($watch_other_person_names);

	 $watch_other_person_names = strtoupper(implode(',<br /><br />',$watch_other_person_names));

	

$table.='<tr><td rowspan="11" colspan="4" style="border:1px solid #ccc;vertical-align: top;border-left:1px solid #000;">Name of Contractor : '.$contractor_name.'<br><br><br>No of Person Involved : '.$contractors_involved.'<br><br><br> Name of the Person <br />'.$watch_other_person_names.'</td><td style="border:1px solid #cccccc;">4) Excessive Temperature</td>
<td style="border:1px solid #ccc;" colspan="2" align="center">'.$pre.'</td><td style="border:1px solid #ccc;"  colspan="2">4) Any hole present on the hose line / hose damaged'.$pre_text.'</td><td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';

  $haz=(isset($hazards->e)) ? strtoupper($hazards->e) : '';

  $pre=(isset($precautions->e)) ? strtoupper($precautions->e) : '';

  $pre_text= (isset($precautions_text->e)) ? '<br /><b>'.strtoupper($precautions_text->e).'</b>' : '';

$table.='<tr><td style="border:1px solid #cccccc;">5) Baricaded the work area</td>
	<td style="border:1px solid #ccc;" colspan="2" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"  colspan="2">5) Hoses are properly protected & Barriacded that area'.$pre_text.'</td><td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';

  $haz=(isset($hazards->f)) ? strtoupper($hazards->f) : '';

  $pre=(isset($precautions->f)) ? strtoupper($precautions->f) : '';

  $pre_text= (isset($precautions_text->f)) ? '<br /><b>'.strtoupper($precautions_text->f).'</b>' : '';	

$table.='<tr><td style="border:1px solid #cccccc;">6) Falling objects</td>
<td style="border:1px solid #ccc;" align="center" colspan="2">'.$haz.'</td><td style="border:1px solid #ccc;"  colspan="2">6) Any water leakages in water hose line'.$pre_text.'</td><td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';

  $pre=(isset($precautions->g)) ? strtoupper($precautions->g) : '';

  $pre_text=(isset($precautions_text->g)) ? '<br /><b>'.strtoupper($precautions_text->g).'</b>' : '';	

  

  
$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">7) Pump earthing cable in good condition'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';


  $pre=(isset($precautions->h)) ? strtoupper($precautions->h) : '';

  $pre_text=(isset($precautions_text->h)) ? '<br /><b>'.strtoupper($precautions_text->h).'</b>' : '';

$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">8) Jet gun connected properly'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';

  $pre=(isset($precautions->i)) ? strtoupper($precautions->i) : '';

  $pre_text=(isset($precautions_text->i)) ? '<br /><b>'.strtoupper($precautions_text->i).'</b>' : '';

$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">9) Walkways are baricaded from the High Pressure hose'.$pre_text.'</td><td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">'.$pre.'</td></tr>';


  $pre=(isset($precautions->j)) ? strtoupper($precautions->j) : '';

  $pre_text=(isset($precautions_text->j)) ? '<br /><b>'.strtoupper($precautions_text->j).'</b>' : '';


$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">10) Personal protective equipment available & Inspected'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';

  $pre=(isset($precautions->k)) ? strtoupper($precautions->k) : '';

  $pre_text=(isset($precautions_text->k)) ? '<br /><b>'.strtoupper($precautions_text->k).'</b>' : '';

$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">11) Sufficient water available in tank'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';

  $pre=(isset($precautions->l)) ? strtoupper($precautions->l) : '';

  $pre_text=(isset($precautions_text->l)) ? '<br /><b>'.strtoupper($precautions_text->l).'</b>' : '';

$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">12) Communication between watch Person and pump operator is ensured'.$pre_text.'</td>
<td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';

  $pre=(isset($precautions->m)) ? strtoupper($precautions->m) : '';

  $pre_text=(isset($precautions_text->m)) ? '<br /><b>'.strtoupper($precautions_text->m).'</b>' : '';

$table.='<tr><td colspan="3"><td style="border:1px solid #ccc;"  colspan="2">13) UT pump operator is aware of the SOP for UT pump operation'.$pre_text.'</td><td style="border:1px solid #ccc;border-right:1px solid #000;"  colspan="2" align="center">'.$pre.'</td></tr>';

$hazards_other = (isset($records['hazards_other'])) ? '<br /><b>'.strtoupper($records['hazards_other']).'</b>' : '';

$precautions_other = (isset($records['precautions_other'])) ? '<br /><b>'.strtoupper($records['precautions_other']).'</b>' : '';

$table.='<tr><td style="border:1px solid #cccccc;" colspan="3" align="left">7) Others'.$hazards_other.'</td>

<td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="4" align="left">Others'.$precautions_other.'</td></tr>';

$table.='<tr><td colspan="4" style="border:1px solid #ccc;border-left:1px solid #000;vertical-align:middle;"><h2>Required PPE</h2></td><td colspan="3" style="border:1px solid #ccc ;"><h2>Authorisation & Acceptance : </h2></td> <td colspan="4" style="border:1px solid #ccc;border-right:1px solid #000;vertical-align: middle;"><h2>Work Completion / Cancellation : </h2> </td></tr>';


  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();

$safety_checked=(in_array('Helmet',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

$eye_checked=(in_array('Eye Protection',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

$shoe_checked=(in_array('Shoe',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

$hand_checked=(in_array('Hand Gloves',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

$kelver_checked=(in_array('Kelver Suit',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

$nose_checked=(in_array('Nose',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

$others_checked=(in_array('Others',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));  

 $required_ppe_other=(isset($records['required_ppe_other'])) ? $records['required_ppe_other'] : '';


$table.='<tr><td colspan="4" style="border-left:1px solid #000;"><table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:9px;">
<tr><td colspan="2" >Safety Helmet </td><td>'.$safety_checked.'</td><td></td><td colspan="2">Eye protection </td><td>'.$eye_checked.'</td><td></td></td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr><td colspan="2" >Shoe</td><td>'.$shoe_checked.'</td><td></td><td colspan="2">Hand Gloves (Special type) </td><td>'.$hand_checked.'</td><td></td></td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr><td colspan="2" >Kelver Suit</td><td>'.$kelver_checked.'</td><td></td><td colspan="2">Nose Mask</td><td>'.$nose_checked.'</td><td></td></td>
</tr>
<tr><td colspan="7">&nbsp;</td></tr>
<tr><td colspan="2" >Others</td><td>'.$others_checked.'</td><td></td><td colspan="2">'.$required_ppe_other.'</td><td></td><td></td></td>
</tr>
                           

                            </table></td>';


  $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

  $acceptance_performing_name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($acceptance_performing_id==$id) { $acceptance_performing_name='<b>'.strtoupper($fet['first_name']).'</b>'; break; }
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
		  
		  if($cancellation_performing_id==$id) { $cancellation_performing_name='<b>'.strtoupper($fet['first_name']).'</b>'; break; }
	  }
  }
 	
	$cancellation_performing_date=(isset($records['cancellation_performing_date']) && $records['cancellation_performing_date']!='') ? date('d-m-Y H:i',strtotime($records['cancellation_performing_date'])).$hrs : '';

$acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

$acceptance_issuing_name='';

  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		  if($acceptance_issuing_id==$id) { $acceptance_issuing_name='<b>'.strtoupper($fet['first_name']).'</b>'; break; }
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
		  
		  if($cancellation_issuing_id==$id) { $cancellation_issuing_name='<b>'.strtoupper($fet['first_name']).'</b>'; break; }
	  }
  }
  
	$cancellation_issuing_date=(isset($records['cancellation_issuing_date']) && $records['cancellation_issuing_date']!='') ? 
	date('d-m-Y H:i',strtotime($records['cancellation_issuing_date'])).$hrs : '';	


	$acceptance_name_of_ia=(isset($records['acceptance_name_of_ia'])) ? strtoupper($records['acceptance_name_of_ia']) : '';

	$cancellation_name_of_ia=(isset($records['cancellation_name_of_ia'])) ? strtoupper($records['cancellation_name_of_ia']) : '';


$table.='<td colspan="3" style="border-left:1px solid #ccc;"><b>Performing Authority :</b><br>
                I have had the contents of this permit explained to me and I shall work in accordance with the control measures identified.<br><br>

                <table align="left" widht="350px">
                <tr>
                <td>
                Name<br>'.$acceptance_performing_name.'</td><td align="right">

                Digital Signature Date & Time<br><b>'.$acceptance_performing_date.'</b></td></tr>


                <tr><td colspan="2"><br /><br />
                <br />
                <b>Issuing Authority :</b> <br>
                I have ensured that each of the identified control measures is suitable and sufficient. The content of this permis has 
                been explained to the holder and work may proceed.<br><br></td></tr>
                <tr>
                <td>Name<br>'.$acceptance_issuing_name.'<br /><br /><p><b>Name of IA</b>: <br />'.$acceptance_name_of_ia.'</p></td><td align="right">Digital Signature Date & Time<br><b>'.$acceptance_issuing_date.'</b></td></tr></table><br /><br />
                <br />
               </td>

               <td colspan="4" style="border-left:1px solid #ccc;border-right:1px solid #000;vertical-align:top;"><b>Performing Authority:</b><br>
               Work Completed, all persons are withdrawn and material removed the area.<br><br><br>
                 <table align="left" widht="350px">
                <tr>
                <td>
                Name<br>'.$cancellation_performing_name.'</td><td align="right">

                Digital Signature Date & Time<br><b>'.$cancellation_performing_date.'</b></td></tr>
                <tr><td colspan="2"><br /><br />
                <br />
                <br>
               <b>Issuing Autority:</b><br>
               I have inspected the work area and declare the work for which the permit was issued-has been properly performed.<br><br>
               </td></tr>
               <tr><td>
                 Name<br>'.$cancellation_issuing_name.'<br /><br /><p><b>Name of IA</b>: <br />'.$cancellation_name_of_ia.'</p></td><td align="right">

                Digital Signature Date & Time<br><b>'.$cancellation_issuing_date.'</b></td></tr></table><br /><br />
                <br /></td>  </tr>';

$self_cancellation_description=(isset($records['self_cancellation_description'])) ? strtoupper($records['self_cancellation_description']) : '';

	if(!empty($self_cancellation_description))
	$table.='<tr>
		<td style="border: 1px solid #cccccc;"><strong>Reason for cancellation:</strong></td>
		<td style="border:1px solid #ccc;"colspan="12">'.$self_cancellation_description.'</td>
	</tr>';
		
	$table.='<tr>
		<td style="border: 1px solid #cccccc;border-left:1px solid #000;" width="125px"><strong>Revalidation:</strong></td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;"colspan="10">I have visited the work area and understand and well omply with the requirements of this permit</td>
	</tr>';

	$table.='<tr><td colspan="11">';

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

	$table.='<table align="center" width="1130px" style="font-family:Arial, Helvetica, sans-serif;font-size:9px !important; margin:0 auto;border-collapse:collapse;" >';
	
	$table.='<tr>
		<td style="border:1px solid #ccc;border-top:none;border-left:1px solid #000;"rowspan="2" width="125px"><strong>SCHEDULE</strong></td>
		<td style="border:1px solid #ccc;border-top:none;"colspan="2"><strong>Date: '.$s_date_a.'</strong></td>
		<td style="border:1px solid #ccc;border-top:none;"colspan="2"><strong>Date: '.$s_date_b.'</strong></td>
		<td style="border:1px solid #ccc;border-top:none;"colspan="2"><strong>Date: '.$s_date_c.'</strong></td>
		<td style="border:1px solid #ccc;border-top:none;"colspan="2"><strong>Date: '.$s_date_d.'</strong></td>
		<td style="border:1px solid #ccc;border-top:none;"colspan="2"><strong>Date: '.$s_date_e.'</strong></td>
		<td style="border:1px solid #ccc;border-top:none;border-right:1px solid #000;"colspan="2"><strong>Date: '.$s_date_f.'</strong></td>
	</tr>
		
		
	<tr>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;"colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;" colspan="2" align="center">Time</td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;" colspan="2" align="center">Time</td>
	</tr>
	
	<tr>
		<td style="border:1px solid #ccc; border-left:1px solid #000;"rowspan="2">&nbsp;</td>
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
		<td style="border:1px solid #ccc;border-right:1px solid #000;"align="center"><strong>To</strong></td>
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
		<td style="border:1px solid #ccc;height: 16px;border-left:1px solid #000;" align="center"><b>'.$f_time_a.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_a.'</b></td><td style="border:1px solid #cccccc;"  align="center"><b>'.$f_time_b.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_b.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_c.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_c.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_d.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_d.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_e.'</b></td>
		<td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_e.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_f.'</b></td>
		<td style="border:1px solid #cccccc;border-right:1px solid #000;" align="center"><b>'.$t_time_f.'</b></td>
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
		<td style="border:1px solid #ccc;font-size: 9px;border-left:1px solid #000;"  ><strong>Name of the contractor</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_b.'</b> </td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_e.'</b></td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;"colspan="2" align="center"><b>'.$contractor_name_f.'</b></td>
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
		<td style="border:1px solid #ccc;font-size: 9px;border-left:1px solid #000;"  ><strong>No. of Persons Involved</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_b.'</b> </td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_e.'</b></td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;"colspan="2" align="center"><b>'.$no_f.'</b></td>
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
		<td style="border:1px solid #ccc;font-size: 9px;border-left:1px solid #000;"><strong>Performing Authority</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_a.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_b.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_c.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_d.'</b></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_e.'</b></td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;"colspan="2" align="center"><b>'.$performing_authority_name_f.'</b></td>
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
		<td style="border:1px solid #ccc;font-size: 9px;border-left:1px solid #000;"> <strong>Issuing Authority</strong></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_a.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_a.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_b.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_b.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_c.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_c.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_d.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_d.'</p></td>
		<td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_e.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_e.'</p></td>
		<td style="border:1px solid #ccc;border-right:1px solid #000;"colspan="2" align="center"><b>'.$issuing_authority_name_f.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_f.'</p></td>
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
		<td style="border:1px solid #ccc;border-bottom:none;font-size: 9px;border-left:1px solid #000;"> <strong>Reference Code</strong></td>
		<td style="border:1px solid #ccc;border-bottom:none;"colspan="2" align="center"><b>'.$ref_a.'</b></td>
		<td style="border:1px solid #ccc;border-bottom:none;"colspan="2" align="center"><b>'.$ref_b.'</b></td>
		<td style="border:1px solid #ccc;border-bottom:none;"colspan="2" align="center"><b>'.$ref_c.'</b></td>
		<td style="border:1px solid #ccc;border-bottom:none;"colspan="2" align="center"><b>'.$ref_d.'</b></td>
		<td style="border:1px solid #ccc;border-bottom:none;"colspan="2" align="center"><b>'.$ref_e.'</b></td>
		<td style="border:1px solid #ccc;border-bottom:none;border-right:1px solid #000;"colspan="2" align="center"><b>'.$ref_f.'</b></td>
	</tr>';
	
	$table.='</table>';

	$table.='</td></tr>';



$table.='<tr><td colspan="11" align="center" style="border: 1px solid #000;font-size:12px;font-weight:bold;">'.EMERGENCY_CONTACT_NUMBER.'</td></tr> ';
$table.='</table>';

#echo $table; exit;


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

