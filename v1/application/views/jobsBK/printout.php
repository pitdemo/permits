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

$table='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body><table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
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

/*<table width="100%" align="left">
		<tr><td style="width: 24% !important;text-align:left;">
		<b>Department: </b> '.$department['name'].'</td><td style="width: 24% !important;text-align:left;"><b>Zone: </b> '.$zone_name.'</td><td style="width: 27% !important;text-align:left;"><b>Permit No: </b> #'.$records['permit_no'].'</td></tr></table>*/
  $table.=' <tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
    </tr>';
	
	$table.='</table><table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">';
	
  if(isset($records))
  $work_types=explode(',',rtrim($records['work_types'],','));
  else
  $work_types=array();
	

	$height_work_checked=(in_array('height_work',$work_types)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	
	$hot_work_checked=(in_array('hot_work',$work_types)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	
	$general_work_checked=(in_array('general_work',$work_types)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	
	//<img src="'.base_url().'assets/img/Circle-Check.png" />

	$line=(isset($records['line'])) ? $records['line'] : '';

	$line1_checked=$line2_checked=$line3_checked=$line4_checked='';

	switch($line)
	{
		case 1:
				$line1_checked='checked=checked';
				break;
		case 2:
				$line2_checked='checked=checked';
				break;
		case 3:
				$line3_checked='checked=checked';
				break;
		case 4:
				$line4_checked='checked=checked';
				break;						
	}
	
    $table.='<tr><td style="border:1px solid #ccc; width: 20% !important;vertical-align: top;" colspan="3"> <strong>HEIGHT WORK </strong>'.$height_work_checked.' <br>Work at a Height of 1.5 Mts & above</td><td style="border:1px solid #ccc;"colspan="3" style="width: 20% !important; vertical-align: top;"><strong>HOT WORK</strong>&nbsp;&nbsp;'.$hot_work_checked.'<br>Work related to <br>Welding / Cutting / Grinding / Open flame</td><td style="border:1px solid #ccc;width: 20% !important;vertical-align: top;"colspan="3" ><strong>GENERAL WORK</strong>&nbsp;&nbsp;'.$general_work_checked.'<br>Works other than Height, Hot, Confined<br>Space, Electrical & Excavation</td><td style="border:1px solid #ccc;width: 20% !important;vertical-align: top;"colspan="4" ><b>Line</b><br /><br />
    	<input name="line" type="radio" '.$line1_checked.' class="radio_button" value="1" />
                              Line 1&nbsp;
                              <input type="radio" name="line" class="radio_button" value="2"  '.$line2_checked.' />
                              Line 2&nbsp;
                              <input type="radio" name="line" class="radio_button" value="3"  '.$line3_checked.' />
                              Colony&nbsp;
                              &nbsp;
                              <input type="radio" name="line" class="radio_button" value="4"  '.$line4_checked.' />
                              Mines&nbsp;
    	</td></tr>';
	
	$location=(isset($records['location'])) ? '<b>'.strtoupper($records['location']).'</b>' : '';
	
    $table.='<tr ><td style="border:1px solid #ccc;"rowspan="4" colspan="2" valign="top"><b>Zone</b><br />'.$zone_name.'<br /><br /><b>Location</b><br />'.$location.'</td><td style="border: 1px solid #cccccc;" colspan="3" align="center">Date & Time</td><td style="border:1px solid #ccc;"colspan="3"><strong>Hazards / concern identified:</strong></td><td><strong>YES / NO</strong></td><td style="border:1px solid #ccc !important;"colspan="3"><strong>Precautions to be Taken :</strong></td><td><strong>YES / NA</strong></td> </tr>';
	
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
	
  $platform_checked  = (in_array('Platform',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
  
  $Handrails_checked = (in_array('Handrails',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
  
  $Stairs_checked = (in_array('Stairs',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
  
  $haz=(isset($hazards->a)) ? strtoupper($hazards->a) : '';
  
  $haz_yes=$haz_no='';
  
  if($haz=='Yes')
  $haz_yes=$checked;
  else if($haz=='No')
  $haz_no=$checked; 
  
  $pre_text= (isset($precautions_text->a)) ? '<br /><b>'.strtoupper($precautions_text->a).'</b>' : '';
  
  $pre=(isset($precautions->a)) ? strtoupper($precautions->a) : '';
  
  $location_date=(isset($records['location_date'])) ? $records['location_date'] : '';

  
    $table.='<tr><td style="border:1px solid #ccc;" align="center" colspan="2">FROM Time </td><td style="border:1px solid #ccc;"align="center">TO Time</td><td style="border:1px solid #ccc;"colspan="3">a)'.$platform_checked.' No permanent Platform '.$Handrails_checked.' Handrails '.$Stairs_checked.' stairs</td><td style="border: 1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">
	a) Standard & certified Scaffold provided '.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	
  $haz=(isset($hazards->b)) ? strtoupper($hazards->b) : '';
  
  $pre=(isset($precautions->b)) ? strtoupper($precautions->b) : '';
  
  $pre_text= (isset($precautions_text->b)) ? '<br /><b>'.strtoupper($precautions_text->b).'</b>' : '';
	
	$location_time_start=(isset($records['location_time_start'])) ? $records['location_time_start'].$hrs : '';
	
	$location_time_to=(isset($records['location_time_to'])) ? $records['location_time_to'].$hrs : '';
	
	
	
    $table.='<tr rowspan="2"><td  align="left"><b>'.$location_date.'</b></td><td style="border-right:1px solid #ccc;"  align="center"><b>'.$location_time_start.'</b></td><td align="center"><b>'.$location_time_to.'</b></td><td style="border:1px solid #ccc;"colspan="3">b) Un Safe Access to work area.</td><td style="border: 1px solid #cccccc;"  align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">b) Suitable access provided. '.$pre_text.'</td><td style="border:1px solid #cccccc;"  align="center">'.$pre.'</td></tr>';
	
	
  $haz=(isset($hazards->c)) ? strtoupper($hazards->c) : '';
  
 
  $pre=(isset($precautions->c)) ? strtoupper($precautions->c) : '';
  
  
	  if(isset($precautions_options->c))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->c,'|'));	
	  }

	  $pre_checked_1=(in_array('Loose materials removed & barricade tape',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	  
	  $pre_checked_2=(in_array('Signs provided',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));	
	  
	  $pre_text= (isset($precautions_text->c)) ? '<br /><b>'.strtoupper($precautions_text->c).'</b>' : '';
	
    $table.='<tr><td style="border-right:1px solid #ccc;" colspan="2"></td><td></td><td style="border:1px solid #ccc;"colspan="3">c) Falling of material</td><td style="border: 1px solid #cccccc;"  align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">c) '.$pre_checked_1.' Loose materials removed & barricade tape  '.$pre_checked_2.' signs provided'.$pre_text.'</td><td style="border:1px solid #cccccc;"  align="center">'.$pre.'</td></td></tr>';
	
  $haz=(isset($hazards->d)) ? strtoupper($hazards->d) : '';
  
  $pre=(isset($precautions->d)) ? strtoupper($precautions->d) : '';
  
  $pre_text= (isset($precautions_text->d)) ? '<br /><b>'.strtoupper($precautions_text->d).'</b>' : '';
  
	  if(isset($hazards_options->d))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->d,'|'));	
	  }
		
	  $checked_1  = (in_array('Electrical Lines',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_2 = (in_array('Electric shock to personnel',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	
	
		$equipment_name = (isset($records['equipment_name'])) ? strtoupper($records['equipment_name']) : '';
		
    $table.='<tr><td style="border:1px solid #ccc;"colspan="5"><strong>Equipment name: '.$equipment_name.'</strong> </td><td style="border:1px solid #ccc;"colspan="3">d) '.$checked_1.' Over Head Electrical Lines  '.$checked_2.' Electric shock to personnel</td><td align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">d) isolation of power supply'.$pre_text.'</td><td style="border:1px solid #cccccc;"  align="center">'.$pre.'</td></tr>';
	
  $haz=(isset($hazards->e)) ? strtoupper($hazards->e) : '';
  
  $pre=(isset($precautions->e)) ? strtoupper($precautions->e) : '';
  
  $pre_text= (isset($precautions_text->e)) ? '<br /><b>'.strtoupper($precautions_text->e).'</b>' : '';
  
	  if(isset($hazards_options->e))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->e,'|'));	
	  }
	  
	  $checked_1=(in_array('Scaffolding',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_2=(in_array('Ladders',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_3=(in_array('Crane',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_4=(in_array('Other lifting equipment',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

	  $checked_5=(in_array('Certified ladder',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  if(isset($precautions_options->e))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->e,'|'));	
	  }

	  $pre_checked_1=(in_array('Certification of Scaffolds',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_2=(in_array('Cranes',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_3=(in_array('lifting eqpt. & tackles ensured & visual inspection done',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

	  $pre_checked_4=(in_array('Certified ladder',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));

	  
	  $job_name=(isset($records['job_name'])) ? strtoupper($records['job_name']) : '';
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="5"><strong>Nature of Job: '.$job_name.'</strong></td><td style="border:1px solid #ccc;"colspan="3"> e)  '.$checked_1.' Failure of scaffolding '.$checked_2.' Ladders  '.$checked_3.' Crane  '.$checked_4.' other lifting equipment '.$checked_5.' Certified ladder</td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">e)  '.$pre_checked_1.' Certification of Scaffolds  '.$pre_checked_2.' cranes  '.$pre_checked_3.' lifting eqpt. & tackles ensured & visual inspection done.'.$pre_text.'&nbsp;'.$pre_checked_4.' Certified ladder</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';
	
  $haz=(isset($hazards->f)) ? strtoupper($hazards->f) : '';  
  
  $pre=(isset($precautions->f)) ? strtoupper($precautions->f) : '';
  
  $pre_text= (isset($precautions_text->f)) ? '<br /><b>'.strtoupper($precautions_text->f).'</b>' : '';
  
	  if(isset($precautions_options->f))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->f,'|'));	
	  }

	  $pre_checked_1=(in_array('Use of Full Body Harness',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_2=(in_array('Anchor points',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_3=(in_array('Fall arrestors',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_4=(in_array('Safety Nets',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_5=(in_array('Life lines',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	  $pre_checked_6=(in_array('Vertigo Test Certificate',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';	
	  
	  $contractor_name='';	  
	  
		$contractors=$contractors->result_array();
	  
		foreach($contractors as $list)
		{
			if($select_contractor_id==$list['id']) { $contractor_name=strtoupper($list['name']); break; } 
		}
	 
	  
	  if($select_contractor_id=='others')
	  $contractor_name=(isset($records['other_contractors'])) ? strtoupper($records['other_contractors']) : '';
	  
	  $contractors_involved=(isset($records['contractors_involved'])) ? $records['contractors_involved'] : '';
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="5">Name of the contractor : <b>'.$contractor_name.'</b><br /><br> No.of persons involved : <b>'.$contractors_involved.'</b></td><td style="border:1px solid #ccc;"colspan="3">f) Fall of person from -height</td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">f)  '.$pre_checked_1.' Use of Full Body Harness &nbsp; '.$pre_checked_2.' Anchor points &nbsp; '.$pre_checked_3.' fall arrestors <br />'.$pre_checked_4.' Safety Nets '.$pre_checked_5.' life lines  '.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';

  $haz=(isset($hazards->g)) ? strtoupper($hazards->g) : '';  
  
  $pre=(isset($precautions->g)) ? strtoupper($precautions->g) : '';
  
  $pre_text= (isset($precautions_text->g)) ? '<br /><b>'.strtoupper($precautions_text->g).'</b>' : '';
  
  
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

    $table.='<tr><td style="border:1px solid #ccc;"colspan="5">Is EIP obtained <input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$yes_existing_active.'>Yes&Existing&nbsp;<input type="radio" '.$no_active.'>Existing&nbsp;<input type="radio" '.$na_active.'>N/A </td><td style="border:1px solid #ccc;"colspan="3">g) Liquid or gas under pressure</td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">g) After energy isolation, equipment/pipe line fully drained & depressurised/cleaning of area done.'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';
	
  $haz=(isset($hazards->h)) ? strtoupper($hazards->h) : '';
  
  $pre=(isset($precautions->h)) ? strtoupper($precautions->h) : '';
  
  $pre_text= (isset($precautions_text->h)) ? '<br /><b>'.strtoupper($precautions_text->h).'</b>' : '';
  
	  if(isset($hazards_options->h))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->h,'|'));	
	  }
	  
	  $checked_1=(in_array('Danger due to naked flames',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_2=(in_array('Ignition of Flammables',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
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
				
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="5">If yes Energy isolation Permit No: <b>'.$eip_yes_selection.'</b></td><td style="border:1px solid #ccc;"colspan="3">h) '.$checked_1.' Danger due to naked flames '.$checked_2.' Ignition of Flammables</td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">h) Space free of Flammables'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';

  $haz=(isset($hazards->i)) ? strtoupper($hazards->i) : '';
  
  $pre=(isset($precautions->i)) ? strtoupper($precautions->i) : '';
  
  $pre_text= (isset($precautions_text->i)) ? '<br /><b>'.strtoupper($precautions_text->i).'</b>' : '';
  
  $yes_active='';
  $no_active=$na_active='';
  if(isset($records))
  {
	  $is_scaffolding_certification=(isset($records['is_scaffolding_certification'])) ? $records['is_scaffolding_certification'] : '';
	  
	  if($is_scaffolding_certification=='No') 
	  $no_active=$checked;
	  else
	  $yes_active=$checked;
  }
  else
  $no_active=$checked;
	
    $table.='<tr rowspan="2"><td style="border:1px solid #ccc;"colspan="5" ><strong>Is Scaffolding TAG CERTIFICATION OBTAINED</strong> <input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td><td style="border:1px solid #ccc;"colspan="3">i) Defective Welding/Gas cutting sets </td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">i) Welding, gas cutting sets checked and Rectified'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	
  $haz=(isset($hazards->j)) ? strtoupper($hazards->j) : '';
  
  $pre=(isset($precautions->j)) ? strtoupper($precautions->j) : '';
  
  $pre_text= (isset($precautions_text->j)) ? '<br /><b>'.strtoupper($precautions_text->j).'</b>' : '';
  
	  if(isset($precautions_options->j))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->j,'|'));	
	  }

	  $pre_checked_1=(in_array('Adequate protection',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_2=(in_array('Fire extinguisher and Fire blanket available',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
  
$scaffolding_certification_no=(isset($records['scaffolding_certification_no']) && $records['scaffolding_certification_no']!='') ? strtoupper($records['scaffolding_certification_no']) : 'NA';
	
	$scaffolding_certification_issed_by=(isset($records['scaffolding_certification_issed_by']) && $records['scaffolding_certification_issed_by']!='') ? strtoupper($records['scaffolding_certification_issed_by']) : 'NA';

	if(trim($scaffolding_certification_no)=='')
	$scaffolding_certification_no='NA';
	
	if(trim($scaffolding_certification_issed_by)=='')
	$scaffolding_certification_issed_by='NA';
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="2"><strong>If Yes Scaffold Tag No. '.$scaffolding_certification_no.'</strong></td> <td style="border:1px solid #ccc;"colspan="3"><strong>Issued by: '.$scaffolding_certification_issed_by.'</strong></td><td style="border:1px solid #ccc;"colspan="3">j) Fire during work activity</td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">j) '.$pre_checked_1.'Adequate protection '.$pre_checked_2.' Fire extinguisher and Fire blanket available.'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';
	
  $haz=(isset($hazards->k)) ? strtoupper($hazards->k) : '';
  
  $pre=(isset($precautions->k)) ? strtoupper($precautions->k) : '';
  
  $pre_text= (isset($precautions_text->k)) ? '<br /><b>'.strtoupper($precautions_text->k).'</b>' : '';
  
	  if(isset($hazards_options->k))
	  {
		  $haz_options=explode('|',rtrim($hazards_options->k,'|'));	
	  }
	  
	 # echo '<pre>'; print_r($haz_options);
	  
	  $checked_1=(in_array('Machinery',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_2=(in_array('Electric shock',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $checked_3=(in_array('Other Energy',$haz_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	   $other_inputs=(isset($records['other_inputs'])) ? explode(',',rtrim($records['other_inputs'],',')) : array();
	   
	   $other_checked1=(in_array('SOP',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   $other_checked2=(in_array('Work instructions clearly explained to the all the members',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   $other_checked3=(in_array('Peptalk',$other_inputs)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	   
	   if(in_array('Peptalk',$other_inputs))
	   $other_peptalk=(isset($records['other_inputs_text'])) ? '(<b>'.strtoupper($records['other_inputs_text']).'</b>)<br />' : '';	
	   else
	   $other_peptalk='<br />';	
	   
	   if(!in_array('SOP',$other_inputs)) 
	   {
	   		$sop=(isset($records['sop']) && $records['sop']!='') ? '<b>SOP</b> : '.$records['sop'] : $other_checked1.' SOP';
	   }
	   else
	   		$sop=$other_checked1.' SOP';

	   	if(!in_array('Work instructions clearly explained to the all the members',$other_inputs)) 
	   {
	   		$wi=(isset($records['work_instruction']) && $records['work_instruction']!='') ? '<b>Work Instruction </b> : '.$records['work_instruction'] : $other_checked2.' Work instructions clearly explained to the all the members in the working Group';
	   }
	   else
	   		$wi=$other_checked2.' Work instructions clearly explained to the all the members in the working Group';


    $table.='<tr rowspan="5"><td style="border:1px solid #ccc;font-size:10px !important;vertical-align: top;" colspan="5" rowspan="5">
	 '.$sop.'<br />
	 '.$wi.'<br />
	 '.$other_checked3.' Peptalk '.$other_peptalk.'
	</td><td style="border:1px solid #ccc;"colspan="3">k) '.$checked_1.' Moving Machinery '.$checked_2.' Electric shock '.$checked_3.' Other Energy </td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">k) Hazardous Energy Isolation ensured '.$pre_text.'
	</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';

  $haz=(isset($hazards->l)) ? strtoupper($hazards->l) : '';
  
  $pre=(isset($precautions->l)) ? strtoupper($precautions->l) : '';
  
  $pre_text= (isset($precautions_text->l)) ? '<br /><b>'.strtoupper($precautions_text->l).'</b>' : '';

    $table.='<tr><td style="border:1px solid #ccc;"colspan="3">i) Poor ventilation </td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">i) Proper ventilation facilities provided'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td> </tr>';

  $haz=(isset($hazards->m)) ? strtoupper($hazards->m) : '';
  
  $pre=(isset($precautions->m)) ? strtoupper($precautions->m) : '';
  
  $pre_text= (isset($precautions_text->m)) ? '<br /><b>'.strtoupper($precautions_text->m).'</b>' : '';
  
    $table.='<tr><td style="border:1px solid #ccc;"colspan="3">m) Poor Illumination </td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">m) Adequate Illumination provided'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';
	
  $haz=(isset($hazards->n)) ? strtoupper($hazards->n) : '';
  
  $pre=(isset($precautions->n)) ? strtoupper($precautions->n) : '';
  
  $pre_text= (isset($precautions_text->n)) ? '<br /><b>'.strtoupper($precautions_text->n).'</b>' : '';
  
	  if(isset($precautions_options->n))
	  {
		  $pre_options=explode('|',rtrim($precautions_options->n,'|'));	
	  }

	  $pre_checked_1=(in_array('Adequate Awareness of emergency procedures',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
	  
	  $pre_checked_2=(in_array('Ensure for clear emergency exits',$pre_options)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;'));
  
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="3">n)Emergency preparedness of employees </td><td style="border:1px solid #cccccc;" align="center">'.$haz.'</td><td style="border:1px solid #ccc;"colspan="3">n)  '.$pre_checked_1.' Adequate Awareness of emergency procedures  '.$pre_checked_2.' Ensure for clear emergency exists.'.$pre_text.'</td><td style="border:1px solid #cccccc;" align="center">'.$pre.'</td></tr>';

$hazards_other = (isset($records['hazards_other'])) ? '<b>'.strtoupper($records['hazards_other']).'</b>' : '';

$precautions_other = (isset($records['precautions_other'])) ? '<b>'.strtoupper($records['precautions_other']).'</b>' : '';

    $table.='<tr><td style="border:1px solid #ccc;"colspan="4">o)Others '.$hazards_other.'</td><td style="border:1px solid #ccc;"colspan="4">o)Others '.$precautions_other.'</td></tr>';
	
  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();
  
  $safety_checked=(in_array('Safety Shoes',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $eye_checked=(in_array('Eye Protection',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $safety_helmet_checked=(in_array('Safety Helmet',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $ear_checked=(in_array('Ear Protection',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $fullbody_checked=(in_array('Full body Harness',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $welding_checked=(in_array('Welding sheid',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $safety_net_checked=(in_array('Safety net',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $coverall_checked=(in_array('Coverall Suit',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $nose_checked=(in_array('Nose Mask',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
   
  $hand_checked=(in_array('Hand Gloves',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $other_checked=(in_array('Others',$required_ppe)) ? checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;')) : checkbox(array('status'=>'no','style'=>'vertical-align:middle;float: right;text-align: right;'));
  
  $required_ppe_other=(isset($records['required_ppe_other'])) ? $records['required_ppe_other'] : '';
  
 $st=(isset($records['status'])) ? $records['status'] : '';
	
	$work_msg='Completion/Cancellation';
	
	if($st=='Completion' || $st == 'Cancellation')
	$work_msg=$st;





    $table.='<tr rowspan="6"><td style="border:1px solid #ccc;"colspan="3" align="center"><strong>Required PPE</strong></td><td style="border:1px solid #ccc;" colspan="5" ><span style="text-align:center;"><strong>Authorisation & Acceptance</span> <b><i>Performing Authority:</i></b><br>
            </strong></td><td style="border:1px solid #ccc;"colspan="5"><strong>Work '.$work_msg.' <i>Performing Authority:</i></strong></td></tr>';
    $table.='<tr><td style="border:1px solid #ccc; vertical-align: middle;" >'.$safety_checked.'<strong> Safety shoes</strong></td><td style="border:1px solid #ccc;vertical-align: middle;"colspan="2">'.$eye_checked.' <strong> Eye Protection</strong> </td><td style="border:1px solid #ccc;"colspan="5">I have read the contents of this permit explained to me and I shall work in acordance with the control measures identified.</td><td style="border:1px solid #ccc;"colspan="5">Work completed, all persons are withdrawn and material removed from the area.</td></tr>';

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
	

	$acceptance_name_of_ia=(isset($records['acceptance_name_of_ia'])) ? strtoupper($records['acceptance_name_of_ia']) : '';

	$cancellation_name_of_ia=(isset($records['cancellation_name_of_ia'])) ? strtoupper($records['cancellation_name_of_ia']) : '';


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
	
    $table.='<tr><td style="border: 1px solid #cccccc;">'.$safety_helmet_checked.' <strong> Safety Helmet</strong></td><td style="border:1px solid #ccc;"colspan="2">'.$ear_checked.'<strong> Ear protection</strong></td><td style="border:1px solid #ccc;"colspan="2">Name : <strong>'.$acceptance_performing_name.'</strong> <br /><p><b>Name of IA</b>: <br />'.$acceptance_name_of_ia.'</p></td><td style="border:1px solid #ccc;"colspan="3">
	Digitally Signed/Date&Time: <b>'.$acceptance_performing_date.'</b> </td> <td style="border:1px solid #ccc;"colspan="2">Name : <strong>'.$cancellation_performing_name.'</strong> <br /><p><b>Name of IA</b>: <br />'.$cancellation_name_of_ia.'</p></td><td style="border:1px solid #ccc;"colspan="3">Digitally Signed/Date&Time: <b>'.$cancellation_performing_date.'</b></td> </tr>';

	
    $table.='<tr><td style="border:1px solid #ccc;"style="font-size: 8px;">'.$fullbody_checked.'<strong> Full body Harness</strong> </td><td style="border:1px solid #ccc;"colspan="2">'.$welding_checked.'<strong> Welding Shield</strong></td><td style="border:1px solid #ccc;"colspan="5"><strong>Issuing Authority: </strong></td><td style="border:1px solid #ccc;"colspan="5"> <strong>Issuing Authority:</strong></td> </tr>';
	
    $table.='<tr><td style="border: 1px solid #cccccc;">'.$safety_net_checked.'<strong> Safety Net</strong> </td><td style="border:1px solid #ccc;"colspan="2">'.$coverall_checked.'<strong> Coverall Suit</strong></td><td style="border:1px solid #ccc;"colspan="5">I have ensured that each of the identified control measures are  suitable and sufficient. The content of this permit has been explained to the holder and work may proceed. </td><td style="border:1px solid #ccc;"colspan="5">I have inspected the work area and declare the work for which the permit was issued has been properly performed</td></tr>';
	
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
  
	
	
    $table.='<tr><td style="border: 1px solid #cccccc;">'.$nose_checked.'<strong> Nose Mask </strong></td><td style="border:1px solid #ccc;"colspan="2">'.$hand_checked.'<strong> Hand Gloves </strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Name : '.$acceptance_issuing_name.'</strong></td><td style="border:1px solid #ccc;"colspan="3">Digitally Signed/Date&Time: <strong>'.$acceptance_issuing_date.'</strong></td><td style="border:1px solid #ccc;"colspan="2">Name : <strong>'.$cancellation_issuing_name.'</strong></td><td style="border:1px solid #ccc;"colspan="3">Digitally Signed/Date&Time: <strong>'.$cancellation_issuing_date.'</strong></td> </tr>';

    $table.='<tr><td style="border: 1px solid #cccccc;">'.$other_checked.'<strong> Others </strong></td><td style="border:1px solid #ccc;"colspan="2"><b>'.strtoupper($required_ppe_other).'</b></td><td style="border:1px solid #ccc;"colspan="5"><b>Name & Signature of co-permittee:</b><td style="border:1px solid #ccc;"colspan="5"></td> </tr>';

    $self_cancellation_description=(isset($records['self_cancellation_description'])) ? $records['self_cancellation_description'] : '';

    if(!empty($self_cancellation_description))
    $table.='<tr><td style="border: 1px solid #cccccc;"><strong>Reason for cancellation:</strong></td><td style="border:1px solid #ccc;"colspan="12">'.$self_cancellation_description.'</td> </tr>';
	
    $table.='<tr><td style="border: 1px solid #cccccc;"><strong>Revalidation:</strong></td><td style="border:1px solid #ccc;"colspan="12">I have visited the work area and understand and will comply with the requirements of this permit</td> </tr>';
	
     if(isset($records))
     $schedule_date=json_decode($records['schedule_date']);
     else
     $schedule_date=array();

     $ex_st_date='';

     if(isset($schedule_date))
     {
     	$st=json_decode($records['schedule_date'],true);
     	$st=array_filter($st);
     	if(count($st)>0)
     	{
     		$ex_st_date=end($st);
     	}
     }
     

	 
	 $s_date_a=(isset($schedule_date->a)) ? $schedule_date->a :'';
	  $s_date_b=(isset($schedule_date->b)) ? $schedule_date->b :'';
	   $s_date_c=(isset($schedule_date->c)) ? $schedule_date->c :'';
	   $s_date_d=(isset($schedule_date->d)) ? $schedule_date->d :'';
	    $s_date_e=(isset($schedule_date->e)) ? $schedule_date->e :'';
		 $s_date_f=(isset($schedule_date->f)) ? $schedule_date->f :''; 
	
	//4
    $table.='<tr><td style="border:1px solid #ccc;"rowspan="3"><strong>SCHEDULE</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_a.'</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_b.'</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_c.'</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_d.'</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date: '.$s_date_e.'</strong></td><td style="border:1px solid #ccc;"colspan="2"><strong>Date:'.$s_date_f.'</strong></td></tr>';
	
   // $table.='<tr><td style="border:1px solid #ccc;" colspan="2" align="center">Time</td><td style="border:1px solid #ccc;" colspan="2" align="center">Time</td><td style="border:1px solid #ccc;"colspan="2" align="center">Time</td><td style="border:1px solid #ccc;" colspan="2" align="center">Time</td><td style="border:1px solid #ccc;" colspan="2" align="center">Time</td><td style="border:1px solid #ccc;" colspan="2" align="center">Time</td> </tr>';
	
	
    $table.='<tr><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td><td style="border:1px solid #ccc;"align="center"><strong>From</strong></td><td style="border:1px solid #ccc;"align="center"><strong>To</strong></td></tr>';
	
	
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

		 
    $table.='<tr><td style="border:1px solid #ccc;height: 16px;" align="center"><b>'.$f_time_a.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_a.'</b></td><td style="border:1px solid #cccccc;"  align="center"><b>'.$f_time_b.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_b.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_c.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_c.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_d.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_d.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_e.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_e.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$f_time_f.'</b></td><td style="border:1px solid #cccccc;" align="center"><b>'.$t_time_f.'</b></td></tr>';

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
	   	

	$table.='<tr><td style="border:1px solid #ccc;"style="font-size: 9px;height: 20px;"  ><strong>Name of the contractor</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_a.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_b.'</b> </td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_c.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_d.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_e.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$contractor_name_f.'</b></td></tr>';	  
	
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

	
    $table.='<tr><td style="border:1px solid #ccc;"style="font-size: 9px;height: 20px;"  ><strong>No. of Persons Involved</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_a.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_b.'</b> </td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_c.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_d.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_e.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$no_f.'</b></td></tr>';
	
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
		
	
    $table.='<tr><td style="border:1px solid #ccc;font-size: 9px;height: 20px"><strong>Performing Authority</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_a.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_b.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_c.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_d.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_e.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$performing_authority_name_f.'</b></td></tr>';
	
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

	
    $table.='<tr><td style="border:1px solid #ccc;font-size: 9px;height: 20px;"> <strong>Issuing Authority</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_a.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_a.'</p></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_b.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_b.'</p></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_c.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_c.'</p></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_d.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_d.'</p></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_e.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_e.'</p></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$issuing_authority_name_f.'</b><br /><p><b>Name of IA:</b><br />'.$ext_ia_f.'</p></td></tr>';

    if(isset($records))
     $extended_scaffolding_certification_no=json_decode($records['extended_scaffolding_certification_no']);
     else
     $extended_scaffolding_certification_no=array();

     
     $extended_scaffolding_certification_no=array();
	 
	 $ref_a=(isset($extended_scaffolding_certification_no->a)) ? strtoupper($extended_scaffolding_certification_no->a) :'';	 
	 $ref_b=(isset($extended_scaffolding_certification_no->b)) ? strtoupper($extended_scaffolding_certification_no->b) :'';	 
	 $ref_c=(isset($extended_scaffolding_certification_no->c)) ? strtoupper($extended_scaffolding_certification_no->c) :'';	 
	 $ref_d=(isset($extended_scaffolding_certification_no->d)) ? strtoupper($extended_scaffolding_certification_no->d) :'';	 
	 $ref_e=(isset($extended_scaffolding_certification_no->e)) ? strtoupper($extended_scaffolding_certification_no->e) :'';	 
	 $ref_f=(isset($extended_scaffolding_certification_no->f)) ? strtoupper($extended_scaffolding_certification_no->f) :'';	 	 	 	 	 	 
	
    $table.='<tr><td style="border:1px solid #ccc;font-size: 9px;height: 20px;"> <strong>Co-permittee Sign</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_a.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_b.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_c.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_d.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_e.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_f.'</b></td></tr>';
	
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
	
    $table.='<tr><td style="border:1px solid #ccc;font-size: 9px;height: 20px;"> <strong>Reference Code</strong></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_a.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_b.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_c.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_d.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_e.'</b></td><td style="border:1px solid #ccc;"colspan="2" align="center"><b>'.$ref_f.'</b></td></tr>';
	
    $table.='<tr><td style="border:1px solid #ccc;"colspan="13" style="font-size: 10px !important;"><strong>'.EMERGENCY_CONTACT_NUMBER.'</strong></td> </tr>
</table>';	



$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
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

/*<table width="100%" align="left">
		<tr><td style="width: 24% !important;text-align:left;">
		<b>Department: </b> '.$department['name'].'</td><td style="width: 24% !important;text-align:left;"><b>Zone: </b> '.$zone_name.'</td><td style="width: 27% !important;text-align:left;"><b>Permit No: </b> #'.$records['permit_no'].'</td></tr></table>*/
   $table.=' <tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
    </tr>';
	
	$table.='</table>';


		 $hot_works=array('a'=>'Workmen briefed on Fire fighting methods?','b'=>'No bulk storage facility of flammable or combustible material like gas, liquid coal, fine coal, oil etc within 10 m vicinity of hot work area?','c'=>'Obstruction placed to stop spark propagation?','d'=>'Compressed gas Cylinders are kept in upright position and latched?','e'=>'Checked condition of all tools & accessories for job, (ex regulator, hoses, cables, cutting torch, Weld M/c & earthing, flashback arrester, etc)?','f'=>'Flashback arrester fitted to regulator of Oxy – acetylene hoses at both ends','g'=>'Welding cable and earthing cable are crimped with proper size lugs','h'=>'Workmen are competent and equipped with appropriate PPE’s (i.e) including face shield / Welding goggles / Apron / Welders shoe / Leatherhand gloves','i'=>'Only industrial type electrical appliances are in use','j'=>'Hoses are free from damage and connected with hose clamp','k'=>'No cable joint within 1 Mtr from the holder / Grinding machine and completely insulated from Machine body','l'=>'Gas testing for presence of any flammable gases or vapor in the vicinity of work place done?','m'=>'Type of Fire Extinguisher - Water/Foam/C02/ABC/DCP');

	 if(isset($records))
	 $hot_work_checklists=json_decode($records['hot_work_checklists']);
	 else
	 $hot_work_checklists=array();


	$table.='<table align="center" width="100%" style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:10.5px !important;	margin:0 auto;border-collapse:collapse;" ><tr><td width="50%"><table align="center" width="100%"><tr><td colspan="2" align="center" style="padding-top:15px;border-left:none;"><b>HOT Work Check List</b></td></tr><tr><td colspan="2" style="border-left:none;border-bottom:.5pt solid black;">&nbsp;</td></tr>';
	  foreach($hot_works as $key => $works)
	  {
	  		$hot_work_checklist=(isset($hot_work_checklists->$key)) ? $hot_work_checklists->$key : '';

	  		$yes_active=$na_active='';

	  		if($hot_work_checklist=='Yes')
	  		$yes_active=$checked;
	  		else if($hot_work_checklist=='NA')
	  		$na_active=$checked;


	  	$table.='<tr><td style="border-right:.5pt solid black;border-left:.5pt solid black;height:25px;padding-left:5px;" width="700px">'.$key.') '.$works.'</td><td style="border-right:.5pt solid black;border-left:none;" width="100px"><center><input  type="radio" '.$yes_active.'/>Y&nbsp;<input  type="radio" '.$na_active.'/>NA</center></td></tr>';

	}

	$firewatcher=(isset($records['firewatcher'])) ? strtoupper($records['firewatcher']) :'';	 

	$table.='<tr><td style="border-right:.5pt solid black;border-left:.5pt solid black;height:25px;padding-left:5px;" width="700px">n) Name of the fire watcher : '.$firewatcher.'</td><td style="border-right:.5pt solid black;border-left:none;" width="100px"></td></tr>';

	$table.='<tr><td style="border-right:.5pt solid black;border-left:.5pt solid black;height:25px;padding-left:5px;border-bottom:.5pt solid black;" width="700px">&nbsp;</td><td style="border-right:.5pt solid black;border-left:none;border-bottom:.5pt solid black;" width="100px">&nbsp;</td></tr>';
                                              
    $table.='</table></td>';        
     
	$height_works=array('a'=>'Engaged worker is having authorized height work access card (Vertigo Test Certificate
                              ensured as required)','b'=>'Are all persons are instructed on hazards & precautions related to the work at height?','c'=>'All elevated working platforms, portable & fixed ladders, scaffolding condition, etc are checked?','d'=>'Crawling ladders provided for jobs on fragile roofs?','e'=>'Certified Full body double lanyard safety harness is used by all workmen engaged at height work','f'=>'Adequate arrangements (rigid support) for anchorage of safety harness provided?','g'=>'Certified Ladder has been provided and the distance between the ladder support and the base is 1:4','h'=>'Are barricades/safety cordon provided at the elevation to avoid fall of material?','i'=>'Is the work area clear of overhead electrical lines and other protruding material?','j'=>'Is the Lifeline (vertical or horizontal) arranged?','k'=>'Whether competent person certified the scaffolding and tag provided','l'=>'Proper guardrail and access to the scaffolding is provided');

	 $c=count($hot_works)-count($height_works);

	 if(isset($records))
	 $height_work_checklists=json_decode($records['height_work_checklists']);
	 else
	 $height_work_checklists=array();

                                 
     $table.='<td width="50%" valign="top"><table align="center" width="100%"><tr><td colspan="2" align="center" style="padding-top:15px;border-left:none;"><b>Working At Height</b></td></tr><tr><td colspan="2" style="border-left:none;border-bottom:.5pt solid black;">&nbsp;</td></tr>';
                                           
	foreach($height_works as $key => $works)
	{

		$height_work_checklist=(isset($height_work_checklists->$key)) ? $height_work_checklists->$key : '';

  		$yes_active=$na_active='';

  		if($height_work_checklist=='Yes')
  		$yes_active=$checked;
  		else if($height_work_checklist=='NA')
  		$na_active=$checked;		

        $table.='<tr><td style="border-right:.5pt solid black;border-left:none;height:25px;" width="700px">'.$key.') '.$works.'</td><td style="border-right:.5pt solid black;" width="100px">
                                                <center><input type="radio" '.$yes_active.'/>Y&nbsp;<input  type="radio" '.$na_active.'/>NA&nbsp;</center></td></tr>';
                                              
    }

    $table.='<tr><td style="border-right:.5pt solid black;border-left:none;height:25px;" width="700px"></td><td style="border-right:.5pt solid black;" width="100px"></td></tr>';
    for($i=0;$i<$c;$i++)
    {
    	  $table.='<tr><td style="border-right:.5pt solid black;border-left:none;height:25px;" width="700px">&nbsp;</td><td style="border-right:.5pt solid black;" width="100px"></td></tr>';
    }


    $table.='<tr><td style="border-right:.5pt solid black;border-left:none;height:25px;border-bottom:.5pt solid black;" width="700px">&nbsp;</td><td style="border-left:none;border-bottom:.5pt solid black;border-right:.5pt solid black;" width="100px">&nbsp;</td></tr>
    </table></td></tr>';


    $table.='<tr><td colspan="2">&nbsp;</td></tr>';

     $completions=array('a'=>'Men, material, & tools have been cleared','b'=>'Safety nets/Lifelines removed','c'=>'Caution boards/barricade removed','d'=>'Checked the working & adjacent areas and found no smoke & fire','e'=>'Guards have been placed back in position','f'=>'Openings/Handrails fixed back','h'=>'Scaffholding/Ladder has been removed','i'=>'Area has been cleaned (Oil spillage, Oil Soaked cotton waste, Scraps, etc) and inspected');


	 if(isset($records))
	 $completion_checklists=json_decode($records['completion_checklist']);
	 else
	 $completion_checklists=array();

	$table.='<tr><td colspan="2"><table align="left" width="50%" style="border:.5pt solid black;"><tr><td colspan="2" align="center" style="padding-top:15px;border-left:none;"><b>Completion Check List</b></td></tr> <tr><td colspan="2" style="border-left:none;border-bottom:.5pt solid black;">&nbsp;</td></tr>';

      foreach($completions as $key => $works)
      {

	      	$completion_list=(isset($completion_checklists->$key)) ? $completion_checklists->$key : '';

	  		$yes_active=$na_active='';

	  		if($completion_list=='Yes')
	  		$yes_active=$checked;
	  		else if($completion_list=='NA')
	  		$na_active=$checked;	
        
       		$table.='<tr><td style="border-right:.5pt solid black;height:25px;padding-left:5px;" width="700px">'.$key.') '.$works.'</td><td style="border-left:none;" width="100px"><center><input  type="radio" '.$yes_active.'/>Y&nbsp;<input  type="radio" '.$na_active.'/>NA</center></td></tr>';
	}

	#$table.='<tr><td  style="border-bottom:.5pt solid black;">&nbsp;</td></tr>';

    $table.='</table></td></tr>';
    $table.='</table> <pagebreak />';

    $ex_date=($ex_st_date!='' ? $ex_st_date : $location_time_start);

	$table_border=$row_border='border:1px solid #000000;border-collapse: collapse;table-layout: fixed;';
$checkbox='<img src="'.base_url().'/assets/img/checkbox_no.png" height="10" width="10" />';

$fontSize="font-size:13vw !important;";
$row_height='height:60px;'.$fontSize;

$table1_chkbox=array('Elect','Mechanical','Pneumatic','Hydraulic','Themal','Gravitational','Water','Steam','Chemical','Gas','Radiation','Kinetic','Potential Energies','Spring/belt tension','Jammed equipment','Counter weight','High Pressure','Coating');

$td_checkbox1=''; $c=1;
for($i=0;$i<count($table1_chkbox);$i++)
{
    $td_checkbox1.='<td height="30" style="'.$fontSize.'"><span style="vertical-align: top;">'.$checkbox.'</span>&nbsp;'.$table1_chkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox1.='</tr>';

        if(($i+1)!=count($table1_chkbox))
        $td_checkbox1.='<tr style="'.$row_height.'">';

        $c=1;
    }
}   

$workman_table='';

for($i=1;$i<=17;$i++)
{
    $workman_table.='<tr style="'.$row_height.'"><td style="'.$table_border.'">&nbsp;</td><td style="'.$table_border.'">&nbsp;</td><td style="'.$table_border.'">&nbsp;</td></tr>';
}

//Column 2
$checklists=array('Whether work completed as per work order and instructions',
'Work is still going on','Permit and LOTO have been returned','Workplace housekeeping done after work',
'Whether men, machine, Material have been withdrawn','Whether barricade, boards, tags have been removed',
'Whether there was any near miss/Incident/accident <br />(If yes, whether reported in My setu, give FIR no.................................');


$tr_checklists='';
for($i=0;$i<count($checklists);$i++)
{
    $tr_checklists.='<tr style="'.$row_height.'"><td height="40" style="'.$fontSize.'">&nbsp;'.$checklists[$i].'</td><td>'.$checkbox.'</td><td>'.$checkbox.'</td></tr>';
}   

$auditlists=array('Does this work and risk assessment was as described to you','Does all workmen signed before entry (For CSE)',
'All hazards checked & control measures taken','Have all workmen participated in Toolbox talk','All work environment issues addressed during work','Whether all ergonomical issues addressed');

$tr_auditlists='';
for($i=0;$i<count($auditlists);$i++)
{
    $tr_auditlists.='<tr style="'.$row_height.'"><td height="30"  style="'.$fontSize.'">&nbsp;'.$auditlists[$i].'</td><td>'.$checkbox.'</td><td>'.$checkbox.'</td></tr>';
}

$description_lists=array('Is there any need of work permit','Is there any need of energy source positive isolation',
'Are the workmen deployed trained and experienced','Whether workmen understood the job/safety requirement properly',
'Is the hazard/risk discussed before starting the work','Whether housekeeping is good at work place',
'Whether tools, tackles are in good condition to use','Whether there is any need for special PPEs like respirator',
'Whether there is adequate ventilation and lighting','Whether HIRA/SWP developed and briefed to workmen',
'Are all required PPEs available to use','Whether there is need for any lifting machine/equipment',
'Whether ergonomical points are considered in work','Whether work involve height work. If yes then follow checklist-A',
'Whether work involve hot work. If yes then follow checklist-B','Whether work involve confined space work. If yes then follow checklist-C','Whether work involve excavation. If yes then follow checklist-D','Whether work involve lifting work. If yes then follow checklist-E','Whether this work will affect others job. If yes then give details','Whether chemicals are going to be used in work (check MSDS)','Whether this work is to be done in odd hours','Whether it is a breakdown work','Whether it is a shutdown work','Whether safety arrangements are adequate');

$tr_description_lists='';
for($i=0;$i<count($description_lists);$i++)
{
    $tr_description_lists.='<tr style="'.$row_height.'"><td height="27"  style="'.$fontSize.'">&nbsp;'.$description_lists[$i].'</td><td>'.$checkbox.'</td><td>'.$checkbox.'</td></tr>';
}   

/* Page 3 */

$table_no="font-size:14px;font-weight:bold;";

$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;margin-top:450px;padding-bottom:5px;"  align="center">
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
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
    </tr>';
	$table.='</table>';

$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:9.5px !important;	margin:0 auto;border-collapse:collapse;height:120px !important;clear:both;"  align="center">

<tr >
<td  valign="top"  width="50%">
	<table align="left" style="'.$table_border.'" width="98%" height="350">
		<tr style="'.$row_height.'">
				<td style="'.$table_border.$fontSize.'" align="center"><span style="'.$table_no.'">3</span> Permit Obtained</td>
				<td style="'.$table_border.$fontSize.'" align="center">Permit Surrended</td>
				<td style="'.$table_border.$fontSize.'" align="center">Signature</td>
		</tr>

		<tr style="'.$row_height.'">

			<td style="'.$table_border.$fontSize.'" align="center">General Work Permit</td>
			<td style="'.$table_border.$fontSize.'" align="center">General Work Permit</td>
			<td style="'.$table_border.'">&nbsp;</td>

		</tr>

		<tr style="'.$row_height.'">
			<td style="'.$table_border.$fontSize.'" align="center"><span style="vertical-align: top;">Yes</span> '.$checkbox.'&nbsp; <span style="vertical-align: top;">No</span> '.$checkbox.'</td>
			<td style="'.$table_border.$fontSize.'" align="center"><span style="vertical-align: top;">Yes</span> '.$checkbox.'&nbsp; <span style="vertical-align: top;">No</span> '.$checkbox.'</td>
			<td style="'.$table_border.'">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
			<td colspan="3" style="'.$table_border.'">
					<table align="center" style="table-layout:fixed;" >
						<tr style="'.$row_height.'">
							<td colspan="2" style="'.$fontSize.'">General Work Permit:</td><td style="'.$fontSize.'">Start Date: </span></td>
						</tr>  
						<tr style="'.$row_height.'">
							<td colspan="3">&nbsp;</td>
						</tr> 

						<tr style="'.$row_height.'">
							<td colspan="3" style="'.$fontSize.'">Reason for taking Permit:  '.str_repeat("_",70).'</td>
						</tr> 
						<tr style="'.$row_height.'">
							<td colspan="3" style="'.$fontSize.'">Energy sources to be isolated: </td>
						</tr>   
						<tr style="'.$row_height.'">'.$td_checkbox1.'</tr> 

						<tr style="'.$row_height.'">
						<td colspan="3" style="'.$fontSize.'">All applicable energy sources positively isolated & Tryout done <br /><br /><span style="vertical-align: top;">Yes</span> '.$checkbox.'&nbsp; <span style="vertical-align: top;">No</span> '.$checkbox.'<br /><br /></td>
						</tr>

						<tr style="'.$row_height.'">
							<td colspan="3" style="'.$fontSize.'">&nbsp;</td>
						</tr>
						
						<tr style="'.$row_height.'">
						<td colspan="3" style="'.$fontSize.'">Other anticipated hazard/risk, control measures detail <br /> <br />________________________________________________________________________<br /><br /><br />________________________________________________________________________</td>
						</tr>

						<tr style="'.$row_height.'">
						<td colspan="2" style="'.$fontSize.'">Whether all necessary measures against hazard/risk are taken <br /><br /><span style="text-align:center;"><span style="vertical-align: top;">Yes</span> '.$checkbox.'&nbsp; <span style="vertical-align: top;">No</span> '.$checkbox.'</span></td>
						<td align="right" valign="top"><span style="'.$table_no.'">4</span></td>
						</tr>

						<tr style="'.$row_height.'">
							<td colspan="3"  style="'.$fontSize.'">If your anser is No then please dont start work</td>
						</tr>    
						<tr style="'.$row_height.'">
							<td colspan="3"  style="'.$fontSize.'">&nbsp;</td>
						</tr>                               
							</td>
						</tr> 
					</table>
			</td>
		</tr>

		<tr style="'.$row_height.'">
		<td style="'.$table_border.$fontSize.'" align="center"><b>Name of Workman</b></td>
		<td style="'.$table_border.$fontSize.'" align="center"><b>Briefing before work</b></td>
		<td style="'.$table_border.$fontSize.'" align="center"><b>Signature</b></td>
		</tr>
		'.$workman_table.'    
		<tr style="'.$row_height.'">
		<td style="'.$table_border.$fontSize.'border-right:0px !important;" colspan="2">&nbsp;&nbsp;<b>Field Engineer</b> <br /><br /><br /><br /></td>
		<td style="'.$table_border.$fontSize.'border-left:0px !important;"  align="right"><b>Co-permittee</b>&nbsp;&nbsp; <br /><br /><br /><br /></td>
		</tr>
	</table>
</td>

<td valign="top" width="50%">

<table align="right" style="'.$table_border.'table-layout:fixed;width:500px;">

		<tr style="'.$row_height.'">
			<td colspan="3" align="center" style="'.$fontSize.'"><span style="'.$table_no.'">5</span> Comments after work completion:</td>
		</tr>  

		<tr style="'.$row_height.'">
			<td colspan="3">'.str_repeat("_",95).'</td>
		</tr> 

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
			<td colspan="3">'.str_repeat("_",95).'</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
			<td colspan="3">'.str_repeat("_",95).'</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
			<td colspan="3">'.str_repeat("_",95).'</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>
		

		<tr style="'.$row_height.'">
		<td style="'.$fontSize.'"><b><u>Work Completion Checklists:</u></b></td>
		<td></td>
		<td></td>
		</tr>

		<tr style="'.$row_height.'">
		<td>&nbsp;</td>
		<td style="'.$fontSize.'"><b>Yes</b></td>
		<td style="'.$fontSize.'"><b>No</b></td>
		</tr>'.$tr_checklists.'


		<tr style="'.$row_height.'" rowspan="3">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" style="'.$fontSize.'"><b>Field Engineer</b> '.str_repeat("&nbsp;",85).'<b style="float:right;">Co-permittee</b> <br /><br /></td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'" rowspan="3">
		<td colspan="3">&nbsp;</td>
		</tr>
		


		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'"><span style="'.$table_no.'">6</span> <b style="vertical-align:top;"><u>Sample audit by SH/DH/FH</u></b></td>
		</tr>

		<tr style="'.$row_height.'">
		<td>&nbsp;</td>
		<td style="'.$fontSize.'"><b>Yes</b></td>
		<td style="'.$fontSize.'"><b>No</b></td>
		</tr>'.$tr_auditlists.'


		<tr style="'.$row_height.'">
		<td colspan="3" style="'.$fontSize.'"><b>How would you rate the work risk assessment:</b></td>
		</tr>
		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'">
		<span style="vertical-align: top;">Good</span> '.$checkbox.'&nbsp; <span style="vertical-align: top;">Need Improvement</span> '.$checkbox.'
		<span style="vertical-align: top;">Not adequate</span> '.$checkbox.'
		</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>
		

		<tr style="'.$row_height.'">
		<td colspan="3" style="'.$fontSize.'">Comments if any:</td>
		</tr>


		

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

	
		

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'"><b>Signature of Dept Head</b></td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3">&nbsp;</td>
		</tr>
</table>

</td>

<td  valign="top" width="50%">

	<table align="left" style="'.$table_border.'table-layout:fixed;width:500px;border-bottom:0px !important;" >

		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'"><span style="'.$table_no.'">1</span> <b style="vertical-align:middle;"><u>Work Place Risk Assessment(WPRA)</u></b></td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="right">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="right" style="'.$fontSize.'"><b>SL. No. .................................................</td>
		</tr>

		<tr style="'.$row_height.'">
				<td style="'.$table_border.$fontSize.'" colspan="2">Dept:</td>
				<td style="'.$table_border.$fontSize.'">Area/Location:</td>
		</tr>

		<tr style="'.$row_height.'">
			<td style="'.$table_border.$fontSize.'" colspan="2">Start Date:</td>
			<td style="'.$table_border.$fontSize.'">End Date:</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="right">&nbsp;</td>
		</tr>
	</table>

	<table align="left" style="'.$table_border.'table-layout:fixed;width:500px;" >
		
	<tr style="'.$row_height.'">
		<td colspan="3" align="right">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'"><b>Work Description</b></td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="right">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td style="'.$fontSize.'"><b>Please ask the following questions before starting </b></td>
		<td style="'.$fontSize.'"><b>Yes</b></td>
		<td style="'.$fontSize.'"><b>No</b></td>
		</tr>'.$tr_description_lists.'
	</table>

	<table align="left" style="table-layout:fixed;width:500px;border:1px solid black;border-right:1px solid black;border-left:1px solid black;" >
		<tr style="'.$row_height.'">
			<td  valign="top" style="'.$fontSize.'"><b>Name & Signature <br /> Field Engineer</b></td>
			<td>&nbsp;</td>
			<td  valign="top" align="right" style="'.$fontSize.'"><b>Name & Signature <br />Co-permitttee</b></td>
		</tr>
		<tr style="'.$row_height.'">
			<td  valign="top">&nbsp;</td>
			<td>&nbsp;</td>
			<td  valign="top">&nbsp;</td>
		</tr>

		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'">&nbsp;</td>
		</tr>
		<tr style="'.$row_height.'">
		<td colspan="3" align="center" style="'.$fontSize.'">&nbsp;</td>
		</tr>
	</table>  
</td>
</tr>
</table><pagebreak />';

/* Page 4 Start */

$fontSize="font-size:10vw !important;";
$row_height='height:20px;'.$fontSize;
$checkbox_height="16";

$hazard_checkbox=array('Dust','Inadequate Ventilation','Congested/restricted place','Noise','Slip/Trip','Grinding hazard','Hot/Cold Surfaces','New workmen','Loco movement','Hot/Liquid Gas','Overhead electric line','Multi level work','Fall hazards','Oil leaks','Gas/time','Inadequate lighting','Opening','Loose material','Rotating/moving part','Lifting hazard','Gas cylinder','Corroded surface','Flying chips','Fuel store','Unauthorized activity','Radioactive source','Bacterial germs','Chemical contact','Welding hazards','Cutting hazards','Energy sources','Electrical tools/equipment','Arc flash','Sharp edges','Fire','Hot material','Pit/sump','Coating','Transport vehicle','Insect/bites/reptiles','Fire/sparks','Struture stability');


$td_checkbox1=''; $c=1;
for($i=0;$i<count($hazard_checkbox);$i++)
{
    $td_checkbox1.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$hazard_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
       
        $td_checkbox1.='</tr>';

        if(($i+1)!=count($hazard_checkbox))
        $td_checkbox1.='<tr style="'.$row_height.'">';

        $c=1;
    }
}   


$control_checkbox=array('Dusk mask/bag filter','Exhaust fan','Good housekeeping','Ear plug/muff','Housekeeping/anti skid','Disc expiry/guard/face sheidld','Hand gloves/Clothing','Supervision/training','Safe distance/red flag','LOTO/Caution sign/PPE','Safe distance','Shielding/safety net','Platform/access/harness','Dio tray/kit','Respirator/mask/ventilation','Lighting','Cover/barricade','Housekeeping','Guard/cover','Tested tools/barricade','Valve cap/trolley','Barricade/caution','Goggles/barricade','Fire cylinder','No entry/caution sign','Authorized person/barricade','Chemical gloves/mask','Eye shower/MSDS','Weding shield/blanket','Goggles/flash back arrestor','LOTO/Isolation','ELCB/Plug top/earthing','Arc flash suit','Hand gloves/soft pad','Fire cylinder','Hot suit/safe distance','Barricade/caution sign','Area shielding','Vehicle check points','Gumboot/cleanliness','Non sparking tools','Overloading control');


$td_checkbox2=''; $c=1;
for($i=0;$i<count($control_checkbox);$i++)
{
    $td_checkbox2.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$control_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox1.='</tr>';

        if(($i+1)!=count($control_checkbox))
        $td_checkbox2.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  


$ergonomical_checkbox=array('Awkward body posture','Manual lifting/shifting','Improper access/passages','Poor work station design','Monotonous/repetitive','Fatigue/exertion','Bending back','Body movements','Overload');

$td_checkbox3=''; $c=1;
for($i=0;$i<count($ergonomical_checkbox);$i++)
{
    $td_checkbox3.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$ergonomical_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox3.='</tr>';

        if(($i+1)!=count($ergonomical_checkbox))
        $td_checkbox3.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  

$environment_checkbox=array('High temperature','River','Hot conditions','Rainy','Pond','Sludge','Winter','Thundering/Storm');

$td_checkbox4=''; $c=1;
for($i=0;$i<count($environment_checkbox);$i++)
{
    $td_checkbox4.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$environment_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox4.='</tr>';

        if(($i+1)!=count($environment_checkbox))
        $td_checkbox4.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  

$ergonomical_control_checkbox=
array('Right body posture','Use of mechanical tools','Housekeepign','Right work station design','Rest pause','Adequate rest','Use of mechanical aid','Use of hand tools','Group handling');

$td_checkbox5=''; $c=1;
for($i=0;$i<count($ergonomical_control_checkbox);$i++)
{
    $td_checkbox5.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$ergonomical_control_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox4.='</tr>';

        if(($i+1)!=count($ergonomical_control_checkbox))
        $td_checkbox5.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  


$environment_control_checkbox=
array('Work shet','Barricade','Hot suit','Safe shelter','Gum boot','Floating Tube','Jacket','Lightening Arrestor','Life Jacket');

$td_checkbox6=''; $c=1;
for($i=0;$i<count($environment_control_checkbox);$i++)
{
    $td_checkbox6.='<td height="'.$checkbox_height.'" style="'.$fontSize.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$environment_control_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checkbox4.='</tr>';

        if(($i+1)!=count($environment_control_checkbox))
        $td_checkbox6.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  

$checklist_checkbox=array('Scaffold/platform/stool','Full body harness','Ladder/stairways','Fall arrestor','Lifeline/anchor point','Man lift','Safety net','Loose material','Tool lanyard','Height phobia test','Barricade','Crawing ladder');


$td_checklist1=''; $c=1;
for($i=0;$i<count($checklist_checkbox);$i++)
{
    $td_checklist1.='<td style="'.$fontSize.'" height="'.$checkbox_height.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$checklist_checkbox[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checklist1.='</tr>';

        if(($i+1)!=count($checklist_checkbox))
        $td_checklist1.='<tr style="'.$row_height.'">';

        $c=1;
    }
}  

$checklist_checkbox2=array('ELCB/Welding machine','Flash back arrestor','Insulated cable joints','Cylinder trolley/key','Welding blanket','Double stage regulator','Apron/sleeve/leg guard','Hose pipe/clamps','Welding shield with helmet','Cutting googles','Fire cylinder/sand bucket','Leather gloves');

$td_checklist2=''; $c=1;
for($i=0;$i<count($checklist_checkbox2);$i++)
{
    $td_checklist2.='<td style="'.$fontSize.'" height="'.$checkbox_height.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$checklist_checkbox2[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checklist2.='</tr>';

        if(($i+1)!=count($checklist_checkbox2))
        $td_checklist2.='<tr style="'.$row_height.'">';

        $c=1;
    }
} 

$checklist_checkbox3=array('Gas test','Hole attendant','Ventilation','Temperature inside space','Energy source isolation','24V hand lamps','Access ways/passage','Emergency kit','Rescue plan','Communication system','Health checkup','Supervision/training');

$td_checklist3=''; $c=1;
for($i=0;$i<count($checklist_checkbox3);$i++)
{
    $td_checklist3.='<td style="'.$fontSize.'" height="'.$checkbox_height.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$checklist_checkbox3[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checklist3.='</tr>';

        if(($i+1)!=count($checklist_checkbox3))
        $td_checklist3.='<tr style="'.$row_height.'">';

        $c=1;
    }
} 

$checklist_checkbox4=array('Excavation certificate','Insulated hand tools','Underground utilities','Entry/exit register','Shoring/Sloping','Utilities protection','Access/ramp','Dust','Barricade/caution sign','Vehicle movement','Seepage water','Falling from sides');

$td_checklist4=''; $c=1;
for($i=0;$i<count($checklist_checkbox4);$i++)
{
    $td_checklist4.='<td  style="'.$fontSize.'" height="'.$checkbox_height.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$checklist_checkbox4[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checklist4.='</tr>';

        if(($i+1)!=count($checklist_checkbox4))
        $td_checklist4.='<tr style="'.$row_height.'">';

        $c=1;
    }
} 

$checklist_checkbox5=array('Tester tools/gears','Barricade','Crane/hydra fitness','Hook latch','Overloading','Tag line with load','Limit switches','Signal man','Run over guard','Trained and experienced workmen','Guards/Cover','Lifting Plan');

$td_checklist5=''; $c=1;
for($i=0;$i<count($checklist_checkbox5);$i++)
{
    $td_checklist5.='<td style="'.$fontSize.'" height="'.$checkbox_height.'"><span style="vertical-align: top;">&nbsp;'.$checkbox.'</span>&nbsp;'.$checklist_checkbox5[$i].'</td>';

    $c++;

    if($c>3)
    {
        $td_checklist5.='</tr>';

        if(($i+1)!=count($checklist_checkbox5))
        $td_checklist5.='<tr style="'.$row_height.'">';

        $c=1;
    }
} 
/* Page 4 */
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
<tr style="'.$row_height.$table_border.'">
	<td colspan="10" align="center" style="'.$row_height.'"><span style="'.$table_no.'">2</span>&nbsp;<b>Potential Workplace Hazard (tick is applicable)</b></td>
</tr>
<tr>
	<td  valign="top" colspan="5" width="400px">
		<table  width="600px"   align="left" style="'.$table_border.'">
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Physical/Chemical/Biological hazards detail</b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checkbox1.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Ergonomical hazards details</b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checkbox3.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Work environment conditions</b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checkbox4.'</tr> 

			

			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b><i>Work at height checklist - A</i></b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checklist1.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b><i>Confined Space checklist - C</i></b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checklist3.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b><i>Lifting work checklist - E</i></b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checklist5.'</tr> 
		</table>
	</td>

	<td valign="top" colspan="5" width="500px">
		<table align="left" width="1000px"  style="'.$table_border.'">
		<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Physical/Chemical/Biological hazards control measures</b></td></tr> 
		<tr style="'.$row_height.'">'.$td_checkbox2.'</tr> 	

		<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Ergoonomical hazards control measures</b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checkbox5.'</tr> 

			

			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b>Work environment conditions control measures</b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checkbox6.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b><i>Hot work checklist - B</i></b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checklist2.'</tr> 
			<tr style="'.$row_height.'"><td colspan="3"  align="center"  style="'.$table_border.$row_height.'"><b><i>Excavation checklist - D</i></b></td></tr> 
			<tr style="'.$row_height.'">'.$td_checklist4.'</tr> 
		</table>
	</td>
</tr>
</table><pagebreak />';

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
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
    </tr>';
	$table.='</table>';

	$table.='<table align="left" width="100%" style="font-family: Arial, Helvetica, sans-serif; width: 100%; width: 100%; font-size: 10.5px !important; margin: 0 auto; border-collapse: collapse;"><tr><td>&nbsp;</td></tr><tr><td align="center">
	<img src="'.base_url().'/assets/img/tamilchecklist1.jpg" style="width:950px;height:580px;transform: scale(1.1);" ></td></tr></table><pagebreak />';

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
        <td style="border:1px solid #ccc;" colspan="2" id="t2" rowspan="2"  align="left"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
        <td style="border:1px solid #ccc;" colspan="9" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' </h1></center><span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
    </tr>';
	$table.='</table>';

	$table.='<table align="left" width="100%" style="font-family: Arial, Helvetica, sans-serif; width: 100%; width: 100%; font-size: 10.5px !important; margin: 0 auto; border-collapse: collapse;"><tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr><tr><td align="center">
	<img src="'.base_url().'/assets/img/tamilchecklist2.jpg" style="width:950px;height:580px;transform: scale(1.1);" ></td></tr></table>';







	$table.='</body></html>';
#echo $table; exit;

include_once APPPATH.'/third_party/mpdf60/mpdf.php';

$header="";

$footer="";

$mpdf=new mPDF('c','A4-L','','',10,10,10,10,10,10);
//                             L,R,T,
$mpdf->SetDisplayMode('fullpage');


//$mpdf->SetHTMLHeader($header);
//$mpdf->SetFooter($footer.'{PAGENO}');
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

