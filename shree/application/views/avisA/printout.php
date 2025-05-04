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
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Dalmia Cement (B) Ltd - Ariyalur</h1><br />AVI (Avoid verbal instruction)</center>
		<span style="float:right"><b style="font-size:14px !important;">Zone Name : '.strtoupper($zone_name).' - AVI No :#'.$avi_info['id'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr></table>';


$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';


    $table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;">';
	
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="7"><b>To: Issuer,</b><br />  
I have physically ensured that all manpower is removed and request to temporarily energize the equipment. I have also collected all the linked permits and attached here (offline). No work is being taken by any agency.
</td>
	</tr>';

		$equipment_tag_nos=(isset($avi_info['jobs_loto_ids'])) ? json_decode($avi_info['jobs_loto_ids']) : array();

		$isolated_user_ids=(isset($avi_info['isolated_user_ids'])) ? json_decode($avi_info['isolated_user_ids'],true) : array();

		$closure_isolator_ids=(isset($avi_info['closure_isolator_ids'])) ? json_decode($avi_info['closure_isolator_ids'],true) : array();

		$isolated_name_approval_datetimes = (isset($avi_info['isolated_name_approval_datetime'])) ? json_decode($avi_info['isolated_name_approval_datetime'],true) : array();

		$isolated_name_closure_datetimes = (isset($avi_info['isolated_name_closure_datetime'])) ? json_decode($avi_info['isolated_name_closure_datetime'],true) : array();

		$table.='<tr>
		<td align="left"   style="'.$td_border.'"><b>Eq. Tag No</b></td>
		<td style="'.$td_border.'"><b>Eq. Desc</b></td>
    	<td align="left"  style="'.$td_border.'"><b>LOCK No</b></td>
		<td align="left"  style="'.$td_border.'" colspan="2"><b>Isolator Name & Signature</b></td>
		<td align="left"  style="'.$td_border.'" colspan="2"><b>Closure Name & Signature</b></td>
    	</tr>';

		#echo '<pre>'; print_r($equipment_tag_nos);exit;
		$r=1;
		foreach($equipment_tag_nos as $i => $jobs_loto_id)
		{	
				$isolated_ia_name='';

				$tag_key=$jobs_loto_id;

				$filtered = array_values(array_filter($job_isolations, function ($filt) use($jobs_loto_id) { return $filt['jobs_loto_id'] == $jobs_loto_id; }))[0];

				$isolation_type_user_id=(isset($isolated_user_ids[$i])) ? $isolated_user_ids[$i] : '';

				$isolation_type_user_name = strtoupper(get_authorities($isolation_type_user_id,$allusers));

				$isolated_name_approval_datetime=(isset($isolated_name_approval_datetimes[$i])) ? $isolated_name_approval_datetimes[$i] : '';

				$closure_isolator_id=(isset($closure_isolator_ids[$i])) ? $closure_isolator_ids[$i] : '';

				$closure_isolator_user_name = strtoupper(get_authorities($closure_isolator_id,$allusers));

				$isolated_name_closure_datetime=(isset($isolated_name_closure_datetimes[$i])) ? $isolated_name_closure_datetimes[$i] : '';

				$table.='<tr>
				<td align="left" style="'.$td_border.'">'.$filtered['equipment_name'].'</td>
				<td align="left" style="'.$td_border.'">'.$filtered['equipment_number'].'</td>
				<td style="'.$td_border.'">'.$filtered['isolated_tagno3'].'</td>
				<td align="left"  style="'.$td_border.'" colspan="2">'.$isolation_type_user_name.' '.$isolated_name_approval_datetime.'</td>
				<td align="left"  style="'.$td_border.'" colspan="2">'.$closure_isolator_user_name.' '.$isolated_name_closure_datetime.'</td>
				</tr>';
			$r++;
			
		}

		
	$table.='<tr>
	<td align="center" style="'.$td_border.'" colspan="7"><b>Closure of AVI</b></td></tr>';

	#echo '<pre>'; print_r($avi_info);

$acceptance_performing_id = $avi_info['acceptance_performing_id'];

$acceptance_performing_name= get_authorities($acceptance_performing_id,$allusers);

$date=(isset($avi_info['acceptance_performing_date']) && $avi_info['acceptance_performing_date']!='') ? $avi_info["acceptance_performing_date"].$hrs :  ''; 

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

$closure_issuing_id=(isset($avi_info['acceptance_issuing_id']) && $avi_info['acceptance_issuing_id']>0) ? $avi_info['acceptance_issuing_id'] : '';

$closure_issuing_name='';

if(!!$closure_issuing_id)
$closure_issuing_name = get_authorities($closure_issuing_id,$allusers);

$date=(isset($avi_info['acceptance_issuing_date']) && $avi_info['acceptance_issuing_date']!='') ? $avi_info['acceptance_issuing_date'].$hrs : '';

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

$closure_issuing_id=(isset($avi_info['closure_issuing_id']) && $avi_info['closure_issuing_id']>0) ? $avi_info['closure_issuing_id'] : '';

$closure_issuing_name='';

if(!!$closure_issuing_id)
$closure_issuing_name = get_authorities($closure_issuing_id,$allusers);

$date=(isset($avi_info['closure_issuing_date']) && $avi_info['closure_issuing_date']!='') ? $avi_info['closure_issuing_date'].$hrs : '';

$table.='<tr>
<td align="left" style="'.$td_border.'" colspan="3"><b>To:Permit Closure Issuer,</b><br />  
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
<td align="left" style="'.$td_border.'" colspan="3"><b>To: Permit Closure Raiser,</b><br />  
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

