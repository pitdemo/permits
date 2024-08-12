<?php
#error_reporting(0);

$hrs=' HRS';


 $checked='checked="checked"';
 
 $select_zone_id=(isset($jobs_info['zone_id'])) ? $jobs_info['zone_id'] : '';
 
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

function checkbox($array_args)
{		
	extract($array_args);
	
	$style=(isset($style)) ? 'style="'.$style.'"' : '';	
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />&nbsp;';
}

$checkbox = checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;'));

$table='';

$location=(isset($jobs_info['location'])) ? strtoupper($jobs_info['location']) : '';

$location_time_start=(isset($jobs_info['location_time_start'])) ?  $jobs_info['location_time_start'].$hrs : '';	

$location_time_to=(isset($jobs_info['location_time_to'])) ?  $jobs_info['location_time_to'].$hrs  : '';	

 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $td_border="border: 1px solid #000000;padding-left:5px;";

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
   
	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/Daco_4764006.png" width="120" height="61">
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Your Company Name (B) Ltd - Location</h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : '.$jobs_info['permit_no'].' - AVI No :#'.$jobs_info['id'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/Daco_4764006.png" width="120" height="61"></td>
    </tr></table>';


$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';


$select_contractor_id=(isset($jobs_info['contractor_id'])) ? explode(',',$jobs_info['contractor_id']) : array();	
	  
$contractor_name='';	  

  $contractors=$contractors->result_array();

  foreach($contractors as $list)
  {
	  if(in_array($list['id'],$select_contractor_id)) { $contractor_name.=strtoupper($list['name']).','; } 
  }

  $contractor_name=rtrim($contractor_name,',');

  $location=(isset($jobs_info['location'])) ? strtoupper($jobs_info['location']) : '';

$location_time_start=(isset($jobs_info['location_time_start'])) ?  $jobs_info['location_time_start'].$hrs : '';	

$location_time_to=(isset($jobs_info['location_time_to'])) ?  $jobs_info['location_time_to'].$hrs  : '';	

$job_name = (isset($jobs_info['job_name'])) ? strtoupper($jobs_info["job_name"]) : '';

$location = (isset($jobs_info['location'])) ? strtoupper($jobs_info["location"]) : '';


    $table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr>
  		<td align="left" width="15%" style="'.$td_border.'"><b>Permit No :</b><br/>'.$jobs_info['permit_no'].'</td>
		<td align="left" width="15%" style="'.$td_border.'"><b>Department :</b><br/>'.$department['name'].'</td>
		<td align="left"  width="15%"   style="'.$td_border.'"><b>Section : </b><br/>'.strtoupper($zone_name).'</td>
		<td style="'.$td_border.'"  width="15%" colspan="2"><b>Work Description :</b> '.$job_name.'</td>
		<td style="'.$td_border.'"  width="15%"  colspan="2"><b>Location : </b>'.$location.'</td>
    	</tr>';
	
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="7"><b>To: Issuer,</b><br />  
I have physically ensured that all manpower is removed and request to temporarily energize the equipment. I have also collected all the linked permits and attached here (offline). No work is being taken by any agency.
</td>
	</tr>';

	$equipment_descriptions=(isset($job_isolations['equipment_descriptions'])) ? json_decode($job_isolations['equipment_descriptions']) : array();

		$equipment_tags=(isset($job_isolations['equipment_tag_nos'])) ? json_decode($job_isolations['equipment_tag_nos'],true) : array();

		$equipment_tag_nos=(isset($avi_info['eq_tag'])) ? json_decode($avi_info['eq_tag']) : array();

		$isolate_types=(isset($job_isolations['isolate_types'])) ? json_decode($job_isolations['isolate_types'],true) : array();

		$isolated_tagno1=(isset($job_isolations['isolated_tagno1'])) ? json_decode($job_isolations['isolated_tagno1'],true) : array();

		$isolated_tagno2=(isset($job_isolations['isolated_tagno2'])) ? json_decode($job_isolations['isolated_tagno2'],true) : array();

		$isolated_tagno3=(isset($job_isolations['isolated_tagno3'])) ? json_decode($job_isolations['isolated_tagno3'],true) : array();

		$isolated_user_ids=(isset($avi_info['isolated_user_ids'])) ? json_decode($avi_info['isolated_user_ids'],true) : array();

		$closure_isolator_ids=(isset($avi_info['closure_isolator_ids'])) ? json_decode($avi_info['closure_isolator_ids'],true) : array();

		$isolated_name_approval_datetimes = (isset($avi_info['isolated_name_approval_datetime'])) ? json_decode($avi_info['isolated_name_approval_datetime'],true) : array();

		$isolated_name_closure_datetimes = (isset($avi_info['isolated_name_closure_datetime'])) ? json_decode($avi_info['isolated_name_closure_datetime'],true) : array();

		#$isolated_ia_names=(isset($job_isolations['isolated_ia_name'])) ? json_decode($job_isolations['isolated_ia_name']) : array();

		$table.='<tr>
		<td align="left"   style="'.$td_border.'"><b>Eq. Tag No</b></td>
		<td style="'.$td_border.'"><b>PA LOCK & TAG No</b></td>
    	<td align="left"  style="'.$td_border.'"><b>LOCK No</b></td>
		<td align="left"  style="'.$td_border.'" colspan="2"><b>Isolator Name & Signature</b></td>
		<td align="left"  style="'.$td_border.'" colspan="2"><b>Closure Name & Signature</b></td>
    	</tr>';

		foreach($equipment_tag_nos as $i => $value)
		{	
			$isolated_ia_name='';

			if($value!='')
			{
				$tag_key = $value;

				$equipment_tag=(isset($equipment_tags[$tag_key])) ? $equipment_tags[$tag_key] : '';

				

				$isolated_tag1=(isset($isolated_tagno1[$tag_key])) ? $isolated_tagno1[$tag_key] : '';

				$isolated_tag2=(isset($isolated_tagno2[$tag_key])) ? $isolated_tagno2[$tag_key] : '';

				$isolated_tag3=(isset($isolated_tagno3[$tag_key])) ? $isolated_tagno3[$tag_key] : '';

				
				$isolation_type_user_id=(isset($isolated_user_ids[$tag_key])) ? $isolated_user_ids[$tag_key] : '';

				$isolation_type_user_name = strtoupper(get_authorities($isolation_type_user_id,$allusers));

				$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes[$tag_key])) ? $isolated_name_approval_datetimes[$tag_key] : '';

				$closure_isolator_id=(isset($closure_isolator_ids[$tag_key])) ? $closure_isolator_ids[$tag_key] : '';

				$closure_isolator_user_name = strtoupper(get_authorities($closure_isolator_id,$allusers));

				$isolated_name_closure_datetime=(isset($isolated_name_closure_datetimes[$tag_key])) ? $isolated_name_closure_datetimes[$tag_key] : '';

				

				$table.='<tr>
				<td align="left" style="'.$td_border.'">'.$equipment_tag.'</td>
				<td align="left" style="'.$td_border.'">'.$isolated_tag1.' & '.$isolated_tag2.'</td>
				<td style="'.$td_border.'">'.$isolated_tag3.'</td>
				<td align="left"  style="'.$td_border.'" colspan="2">'.$isolation_type_user_name.' '.$isolated_name_approval_datetime.'</td>
				<td align="left"  style="'.$td_border.'" colspan="2">'.$closure_isolator_user_name.' '.$isolated_name_closure_datetime.'</td>
				</tr>';
			}
			
		}

		
	$table.='<tr>
	<td align="center" style="'.$td_border.'" colspan="7"><b>Closure of AVI</b></td></tr>';


$acceptance_performing_id = $jobs_info['acceptance_performing_id'];

$acceptance_performing_name= get_authorities($acceptance_performing_id,$allusers);

$date=(isset($avi_info['closure_performing_date']) && $avi_info['closure_performing_date']!='') ? strtoupper($avi_info["closure_performing_date"]).$hrs :  ''; 

$table.='<tr>
<td align="left" style="'.$td_border.'" colspan="3"><b>To: Permit Raiser,</b><br />  
Please isolate the equipment as stated clause-A
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Initiator Name</b><br />  
'.$acceptance_performing_name.'
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Signature Date & Time</b><br /> '.$date.'
</td>
</tr>';


$closure_issuing_id=(isset($avi_info['closure_issuing_id']) && $avi_info['closure_issuing_id']>0) ? $avi_info['closure_issuing_id'] : '';

$closure_issuing_name='';

if(!!$closure_issuing_id)
$closure_issuing_name = get_authorities($closure_issuing_id,$allusers);

$date=(isset($records['closure_issuing_date'])) ? $records['closure_issuing_date'].$hrs : '';

$table.='<tr>
<td align="left" style="'.$td_border.'" colspan="3"><b>To:Permit Issuer,</b><br />  
Please isolate the equipment as stated clause-A
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Issuer Name</b><br />  
'.$closure_issuing_name.'
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Signature Date & Time</b><br /> '.$date.'
</td>
</tr>';

$acceptance_performing_id = (isset($avi_info['closure_performing_again_id']) && $avi_info['closure_performing_again_id']>0) ? $avi_info['closure_performing_again_id']: '';

$acceptance_performing_name='';

if($acceptance_performing_id!='')
$acceptance_performing_name= get_authorities($acceptance_performing_id,$allusers);

$date=(isset($avi_info['closure_performing_again_date']) && $avi_info['closure_performing_again_date']!='') ? strtoupper($avi_info["closure_performing_again_date"]).$hrs :  '';

$table.='<tr>
<td align="left" style="'.$td_border.'" colspan="3"><b>To: Permit Raiser,</b><br />  
Please isolate the equipment as stated clause-A
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Initiator Name</b><br />  
'.$acceptance_performing_name.'
</td>
<td align="left" style="'.$td_border.'" colspan="2"><b>Signature Date & Time</b><br /> '.$date.'
</td>
</tr>';


	

	$table.='</table></td></tr>';


    $table.='</table>';

   #echo $table; exit;

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

		$path = UPLODPATH.'uploads/permits/'.$avi_info['id'];

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

echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$avi_info['id'].$file_name));
exit;

?>

