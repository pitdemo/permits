<?php
error_reporting(0);

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

function checkbox($array_args)
{		
	extract($array_args);
	
	$style=(isset($style)) ? 'style="'.$style.'"' : '';	
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />&nbsp;';
}

$checkbox = checkbox(array('status'=>'yes','style'=>'vertical-align:middle;float: right;text-align: right;'));

$table='';

$location=(isset($records['location'])) ? strtoupper($records['location']) : '';

$location_time_start=(isset($records['location_time_start'])) ?  $records['location_time_start'].$hrs : '';	

$location_time_to=(isset($records['location_time_to'])) ?  $records['location_time_to'].$hrs  : '';	

 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();

 if(isset($records))
 $m_depth=json_decode($records['m_depth']);
 else
 $m_depth=array();


 if(isset($records))
 $dept_issuing_id=json_decode($records['dept_issuing_id']);
 else
 $dept_issuing_id=array();

 if(isset($records))
 $dept_issuing_date=json_decode($records['dept_issuing_date']);
 else
 $dept_issuing_date=array();

 if(isset($records))
 $dept_approval_status=json_decode($records['dept_approval_status']);
 else
 $dept_approval_status=array();

 $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';

 $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

 $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

 if(isset($records))
 $dept_remarks=json_decode($records['dept_remarks']);
 else
 $dept_remarks=array();

 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
   
	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Dalmia Cement (B) Ltd - Ariyalur</h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #ME1657'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr></table>';

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:11px !important; border: 2px solid red;	margin:0 auto;border-collapse:collapse;"  align="center">';

	//Mandatory measures to be taken for all type of works
    $table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top"><table align="left" width="100%"  ><tr><td align="left" colspan="5"><b>Mandatory measures to be taken for all type of works:</b></td></tr>';

	$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Required usages of PPEs (Safety Helmet, Safety Shoes)</td>';
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Enclose the list of persons carried out the job.</td>';
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Five Minutes Safety Talk conducted (record to be maintained)</td>';
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Equipment/work area inspected.</td></tr>';
	$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Equipment electrically isolated. If YES, line clearance Permit No:</td>';
	$table.='<td align="left"  style="'.$valign.'">'.$checkbox.'Portable Fire Fighting system readiness.</td><td align="left"  style="'.$valign.'">'.$checkbox.'Tools & Tackles Checked</td>';
	
	$table.='<td align="left">'.$checkbox.'The place of work is made accessible and proper aggress.</td></tr>';
	$table.='<tr><td align="left">'.$checkbox.'Barricading and cordoning of the area.</td>';
	$table.='<td align="left" colspan="2">'.$checkbox.'Loose dresses are to be avoided or tight properly while working near conveyors or rotating equipment’s.</td>';
	$table.='<td align="left">'.$checkbox.'Sufficient safe lighting facility provided.</td><td align="left" colspan="3">'.$checkbox.'Deputed Skilled Supervisor</td></tr></table></td></tr>';


	//Hot Work (Welding, Grinding, Cutting):
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Hot Work (Welding, Grinding, Cutting):</td></tr>';

	$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Flammables / Combustibles/ Explosive material removed / protected. (> 35ft.)</td>';
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Fire Watch Established</td><td align="left">'.$checkbox.'Welding & Cutting equipment positioned properly</td>';
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Leads up and do not pose a tripping hazard</td><td align="left" style="'.$valign.'">'.$checkbox.'Area hazards reviewed</td></tr>';
	
	
	$table.='<tr><td align="left">'.$checkbox.'Electrical connections through ELCB/RCCB of 30 mA sensitivity</td>';
	$table.='<td align="left">'.$checkbox.'Electrical equipment’s are free from damage and earthed properly</td>';
	$table.='<td align="left" colspan="2">'.$checkbox.'Performer/s are competent and equipped with appropriate PPEs i.e. including face shield/welding goggles/ apron, safety shoes etc.</td>';
	$table.='<td align="left">'.$checkbox.'No tampering / manipulation attempted in safety device of the equipment’s</td></tr>';

	$table.='<tr><td align="left" >'.$checkbox.'Only industrial type electrical appliances are in use</td>';
	$table.='<td align="left">'.$checkbox.'Cables / fuses are of adequate size & capacity fit with the requirement</td>';
	$table.='<td align="left" colspan="2">'.$checkbox.'No cable joint within 1 Mtr. from the holder / grinding machine and completely insulated from with M/C body</td>';
	$table.='<td align="left">'.$checkbox.'Gas cylinders used: Oxygen / Industrial LPG / Dissolved Acetylene</td></tr>';


	$table.='<tr><td align="left" colspan="2">'.$checkbox.'Gas cutting torch of reputed make, ISI marked, installed with Back Fire and Flash back arrestors are in use at both ends</td>';
	$table.='<td align="left">'.$checkbox.'Hoses are free from damage and connected with hose clamp</td><td align="left">'.$checkbox.'Regulator pressure gauges in working condition, visible and not damaged</td></tr>';
	$table.='<td align="left">'.$checkbox.'Welding cable and earthing cable are crimped with proper size lugs.</td></tr><tr><td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';
	$table.='<td align="left">'.$checkbox.'Area wet down</td><td align="left">'.$checkbox.'Spark shields installed</td><td>'.$checkbox.'Fire blanket</td></tr>'; 
	$table.='<tr><td align="left" colspan="5"><i>'.$checkbox.'Fire Fighting arrangements provided:</i></td></tr>';
	
	$table.='<tr><td align="left" style="padding-left:10px">'.$checkbox.'CO2</td><td align="left">'.$checkbox.'Dry Chemical Powder</td><td align="left">'.$checkbox.'ABC</td><td align="left">'.$checkbox.'Fire Tender</td><td align="left">'.$checkbox.'Fire hose connected to hydrant </td></tr>';

	$table.='<tr><td align="left" style="padding-left:10px">'.$checkbox.'Fire hose connected to hydrant</td><td align="left" colspan="4">'.$checkbox.'Other</td></tr>';

	$table.='<tr><td align="left" colspan="5">'.$checkbox.'Welding Helmet&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Hand gloves&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Apron&nbsp;&nbsp;&nbsp;'.$checkbox.'Hand Sleeves&nbsp;&nbsp;&nbsp;'.$checkbox.'Leg Guard&nbsp;&nbsp;&nbsp;'.$checkbox.'Welding Goggles for Helper&nbsp;&nbsp;&nbsp;'.$checkbox.'Nose Mask&nbsp;&nbsp;&nbsp;'.$checkbox.'Other</td></tr>';
	$table.='</table></td></tr>'; 


	//Material lowering & lifting:
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Material lowering & lifting:</b></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Safety devices of the lifting appliances are inspected before use</td>';
	$table.='<td align="left">'.$checkbox.'Operator qualified and medically fit including eye sight examined by authority</td>';
	$table.='<td align="left">'.$checkbox.'Lifting appliances are certified by competent authority and labeled properly</td>';
	$table.='<td align="left">'.$checkbox.'Hoist chain or hoist rope free of kinks or twists and not wrapped around the load.</td>';
	$table.='<td align="left">'.$checkbox.'Lifting Hook has a Safety Hook Latch that will prevent the rope from slipping out.</td></tr>';


	$table.='<tr><td align="left">'.$checkbox.'Lifting gears operator been instructed not to leave the load suspended</td>';

	$table.='<td align="left">'.$checkbox.'Electrical power line clearance (12ft) checked</td><td align="left">'.$checkbox.'Signal man identified</td>';
	$table.='<td align="left">'.$checkbox.'Outriggers supported, Crane leveled</td><td align="left">'.$checkbox.'SLI/ Load chart available in the crane</td></tr>';

		
	$table.='<tr><td align="left">'.$checkbox.'Barrier Installed</td><td align="left">'.$checkbox.'Riggers are competent</td>';
	$table.='<td align="left" colspan="2">'.$checkbox.'Slings are inspected for free from cut marks, pressing, denting, bird caging, twist, kinks or core protrusion prior to use.</td>';
	$table.='<td align="left">'.$checkbox.'Slings mechanically spliced (Hand spliced slings may not be allowed)</td></tr>';

	
	$table.='<tr><td align="left">'.$checkbox.'D / Bow shackles are free from any crack, dent, distortion or weld mark, wear / tear</td>';
	$table.='<td align="left">'.$checkbox.'Special lift as per erection / lift plan</td>';
	$table.='<td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';
	$table.='<td align="left">'.$checkbox.'Guide rope is provided while shifting / lifting/lowering the load.</td>';
	$table.='<td align="left">'.$checkbox.'Daily inspection checklist followed and maintained for crane</td></tr>';
	$table.='<tr><td align="left">'.$checkbox.'SWL displayed</td><td align="left"  colspan="4">'.$checkbox.'Wind velocity < 36 KMPH, No rain</td></tr>';
	$table.='</table></td></tr>'; 

	//Electrical Work:
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Electrical Work:</b></td></tr>';
	$table.='<tr><td align="center" colspan="5"><u>LIVE ELECTRICAL WORK PERFORMED BY LICENCED ELECRTRICIAN ONLY</u></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Obtained LOTOTO</td><td align="left">'.$checkbox.'Power supply locked and tagged</td><td align="left">'.$checkbox.'Circuit checked for zero voltage</td><td align="left">'.$checkbox.'Portable cords and electric tools inspected</td><td align="left">'.$checkbox.'Safety back-up man appointed</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td><td align="left">'.$checkbox.'Physical isolation is ensured If yes, State the method</td><td align="left">'.$checkbox.'In case of lock applied, ensure the safe custody of the key</td><td align="left" colspan="2">'.$checkbox.'If physical isolation is not possible state, the alternative method of precaution</td></tr>';
	
	$table.='<tr><td align="center" colspan="5"><u>Equipment Provided</u></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Approved rubber and leather gloves</td><td align="left">'.$checkbox.'Insulating mat</td><td align="left">'.$checkbox.'Fuse puller</td><td align="left" colspan="2">'.$checkbox.'Disconnect pole or safety rope</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Non-conductive hard hat</td><td align="left" colsnan="4">'.$checkbox.'ELCB/RCCB is installed of 30 mA</td>></tr>';
	$table.='</table></td></tr>';



	//Scaffolding Erection & Dismantling
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Scaffolding Erection & Dismantling:</b></td></tr>';

	$table.='<tr><td align="left" colspan="2">'.$checkbox.'Presence of competent person assigned to ensure safe erection, maintenance, or modification of scaffolds. Name</td><td align="left">'.$checkbox.'That person prior to use by personnel other than scaffolders inspects scaffold</td><td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td><td align="left">'.$checkbox.'All pipes, clamps, H-frames, couplers, boards checked before assembly</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Scaffolds provided with proper access and egress</td><td align="left">'.$checkbox.'Standard guardrail been used</td><td align="left">'.$checkbox.'Platforms, walkways on scaffolds are wide of minimum of 900 mm wherever possible</td><td align="left">'.$checkbox.'Precautions taken to ensure scaffolds are not overloaded</td><td align="left">'.$checkbox.'Overhead protection provided where there is exposure</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'No opening / Gap in the platform / walkway.</td><td align="left" colspan="4">'.$checkbox.'All component of the scaffold more than 12’ away from any exposed power lines</td></tr>';
	
	$table.='<tr><td align="center" colspan="5"><u>PPEs Provided</u></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Safety Harness and Lanyard anchored to independent rigid object</td><td align="left">'.$checkbox.'Lifeline Rope</td><td align="left">'.$checkbox.'Fall Arrestor with rope anchorage</td><td align="left">'.$checkbox.'Full Body harness is used by all workmen engaged at height work</td><td align="left" >'.$checkbox.'Safety net is provided but not less than 5 M from the work area</td></tr>';	
	$table.='</table></td></tr>';


	//Confined Space Entry:
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Confined Space Entry:</b></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Equipment properly drained / Depressurized</td><td align="left">'.$checkbox.'Disconnected Inlet, Outlet lines and isolate equipment</td><td align="left">'.$checkbox.'Vent / Manholes are kept open to maintain proper ventilation</td><td align="left" colspan="2">'.$checkbox.'Only trained personnel were engaged & register was maintained for entry & exit of person with time</td></tr>';	

	$table.='<tr><td align="left">'.$checkbox.'Standby Personnel/Entry supervisor,. is available</td><td align="left">'.$checkbox.'Oxygen level is measured and find………………( 19.5% - 23.5% is available</td><td align="left">'.$checkbox.'Flammable gases and vapours reading: ≤ 5% LEL</td><td align="left" colspan="2">'.$checkbox.'Toxic gases and vapours reading: ≤ PEL values</td></tr>';	

	$table.='<tr><td align="left">'.$checkbox.'Inside temperature closed to room temperature and ambient air comfortable for working</td><td align="left">'.$checkbox.'Recommended communication system</td><td align="left">'.$checkbox.'Safe Illumination provided (24-volt hand lamps)</td><td align="left" colspan="2">'.$checkbox.'Additional Measures</td></tr>';	
	$table.='</table></td></tr>';

	//U T Pump:
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>U T Pump:</b></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Trained persons are deployed</td><td align="left">'.$checkbox.'Adequate water level in tank</td><td align="left">'.$checkbox.'Whiplash is provided to hose pipe</td><td align="left">'.$checkbox.'All hoses joints thread tightened properly</td><td align="left">'.$checkbox.'Pump is earthed</td></tr>';	

	$table.='<tr><td align="left">'.$checkbox.'Pressure gauge is showing reading and marking provided – Yellow/Green/Red</td><td align="left">'.$checkbox.'Jet gun connected properly and dead man switch functioning</td><td align="left">'.$checkbox.'Hoses are properly protected and barricaded</td><td align="left" colspan="2">'.$checkbox.'PPEs are adequate for working</td></tr>';	
	$table.='</table></td></tr>';


	//Work At Height:
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Work At Height:</b></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Only medically fit personnel engaged in work and list is available</td><td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting.</td><td align="left">'.$checkbox.'Ladder(s) inspected prior to use</td><td align="left" colspan="2">'.$checkbox.'Distance between the ladder support and the ladder base is at least ¼ the total length of the ladder</td></tr>';	

	$table.='<tr><td align="left" colspan="5">'.$checkbox.'Ladder properly supported and leveled</td></tr>';	
	$table.='<tr><td align="left" style="padding-left:15px;">'.$checkbox.'Secured at Top</td><td align="left" colspan="4">'.$checkbox.'Secured at Bottom</td></tr>';	

	$table.='<tr><td align="left">'.$checkbox.'Ladder been provided with skid resistant feet</td><td align="left">'.$checkbox.'Scaffolds/platforms inspected for good repair and proper construction (secured flooring and guardrails)</td><td align="left">'.$checkbox.'Floor openings covered Guarded</td><td align="left">'.$checkbox.'Work area roped off and warning signs in place</td><td align="left">'.$checkbox.'Proper Housekeeping is done</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Personnel assigned to warn of floor opening or other hazardous exposure.</td><td align="left">'.$checkbox.'Tools and other equipment stored in safe manner</td><td align="left" colspan="3">'.$checkbox.'Area cleared below prior to starting work</td></tr>';

	$table.='<tr><td align="center" colspan="5"><u>PPEs Provided</u></td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Safety Harness and Lanyard anchored to independent rigid object</td><td align="left">'.$checkbox.'Lifeline Rope</td><td align="left" colspan="3">'.$checkbox.'Fall Arrestor with rope anchorage</td></tr>';

	$table.='<tr><td align="left">'.$checkbox.'Full Body harness is used by all workmen engaged at height work.</td><td align="left" colspan="4">'.$checkbox.'Safety net is provided but not less than 5 M from the work area</td></tr>';
	$table.='</table></td></tr>';


	//Job specific Tool box Talk
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Job specific Tool box Talk:</b></td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:50px;"><b>Persons Engaged for the job: </b>(if more than 6 persons were engaged for work, then separate sheet to be attached)</td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:150px;"><table align="center" border="1" style="width:750px;border-collapse: collapse;"><tr><td style="width:10%;text-align:center;"><b>S.No</b></td><td align="center"><b>Name</b></td><td align="center"><b>Designation</b></td><td align="center"><b>Sign</b></td></tr>';

	for($i=1;$i<=10;$i++)
	{

		$table.='<tr><td  align="center" height="20">'.$i.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

	}
	
	
	
	
	
	$table.='</table></td></tr>';


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

echo '<a href="'.base_url().'uploads/permits/'.$records['id'].$file_name.'" target="_blank">Print</a>';

//echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$records['id'].$file_name));
exit;

?>

