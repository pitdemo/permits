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

#echo '<pre>'; print_r($records); print_r($precautions); exit;


 $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';	
	  
 $contractor_name='';	  
 
   $contractors=$contractors->result_array();
 
   foreach($contractors as $list)
   {
	   if($select_contractor_id==$list['id']) { $contractor_name=strtoupper($list['name']); break; } 
   }

 $acceptance_issuing_approval=(isset($records['acceptance_issuing_approval'])) ? $records['acceptance_issuing_approval'] : '';

 $acceptance_performing_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

 $acceptance_issuing_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

 if(isset($records))
 $dept_remarks=json_decode($records['dept_remarks']);
 else
 $dept_remarks=array();

 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $td_border="border: 1px solid #000000;padding-left:5px;";

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
<body>';



   $subcontractor = (isset($records['contractor_id'])) ? strtoupper($records["sub_contractor"]) : '';

    $table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; margin:0 auto;border-collapse:collapse;"><tr>
		<td align="left" width="15%" style="'.$td_border.'"><b>Department :</b><br/>'.$department['name'].'</td>
		<td align="left"  width="15%"   style="'.$td_border.'"><b>Section : </b><br/>'.strtoupper($zone_name).'</td>
		<td align="left"  width="15%"  style="'.$td_border.'"><b>Start Date : </b><br/>'.$location_time_start.'</td>
		<td style="'.$td_border.'"  width="15%" ><b>End Date : </b><br/>'.$location_time_to.'</td>
    	<td align="left"  style="'.$td_border.'"  width="15%" ><b>Contractor: </b><br/>'.$contractor_name.'</td>
    	<td align="left"  style="'.$td_border.'"  width="15%" ><b>Sub Contractor:</b><br/> '.$subcontractor.'</td></tr>';

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

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>Work Description :</b> '.$job_name.'</td>
		<td align="left"   style="'.$td_border.'" colspan="3"><b>Location : </b>'.$location.'</td>
	</tr>';

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="6"><b>Checkpoints for Permit Initiator</b></td>
	</tr>';

	$checkpoints=unserialize(CHECKPOINTS);

	$td_length = count($checkpoints);

	$cl=0;

	$checkpoints_data = (isset($records['checkpoints'])) ? explode(',',$records["checkpoints"]) : array();

	$table.='<tr>';
		foreach($checkpoints as $key => $label):
			$cl++;
			$cl_span='';

			if($cl==$td_length)
			{
				$cl_span=(6-$key)+1;
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
	
	$table.='<tr>
		<td align="left" style="'.$td_border.'">'.$checkbox.'Mechancal </td>';

		$table.='<td align="left"   style="'.$td_border.'">'.$checkbox.'Electrical </td>';

		$table.='<td align="left" style="'.$td_border.'">'.$checkbox.'Instrumentation </td>';

		$table.='<td style="'.$td_border.'">'.$checkbox.'Process</td>';

    	$table.='<td align="left"  style="'.$td_border.'" colspan="2">'.$checkbox.'Civil</td>
    	</tr>';
	}
	

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

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3"><b>B) Issuer:</b> I have checked that all conditions are met to carry out the job safety.</td>
		<td align="left" style="'.$td_border.'" colspan="3"><b>Name of the Issuer:</b> '.$acceptance_issuing_name.' '.$acceptance_issuing_date.'</td>
	</tr>';

	//Loto
	if(in_array(8,$permit_types))
	{

		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="3"><b>C) To be filled by Permit Initiator and checked by issuer</b> </td>
			<td align="left" style="'.$td_border.'" colspan="3"><b>D) To be filled by authorized isolator who is carrying out isolations</b></td>
		</tr>';

		$table.='<tr>
		<td align="left" style="'.$td_border.'">Eq. Details</td>
		<td align="left"   style="'.$td_border.'">Eq. Tag No</td>
		<td align="left" style="'.$td_border.'">Isolation Type</td>
		<td style="'.$td_border.'">LOCK/TAG No(Isolator)</td>
    	<td align="left"  style="'.$td_border.'">LOCK No(Initiator)</td>
		<td align="left"  style="'.$td_border.'">Name & Sign of Isolator</td>
    	</tr>';
	
		for($i=1;$i<=5;$i++)
		{

			$table.='<tr>
			<td align="left" style="'.$td_border.'">&nbsp;</td>
			<td align="left"   style="'.$td_border.'"></td>
			<td align="left" style="'.$td_border.'"></td>
			<td style="'.$td_border.'"></td>
			<td align="left"  style="'.$td_border.'"></td>
			<td align="left"  style="'.$td_border.'"></td>
			</tr>';
			
		}

		$table.='<tr>
			<td align="left" style="'.$td_border.'" colspan="6"><b>E) To be filled & ensure by issuer</b></td>
		</tr>';

		$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.'Are all equipments identified and stopped?</td><td  align="left"  style="'.$td_border.'vertical-align:top;" colspan="3" rowspan="4">
		I have ensure that all isolation mentioned in clause no C&D are completed clearance is given to start the job <br />
		<b>Name of the Issuer :   <br /><br />
		Date & Time:</b>
		</td></tr>
		<tr><td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.'Are precending & following eqiupment also stopped? </td></tr>
		<tr><td style="'.$td_border.'" colspan="3">'.$checkbox.'Is try out done as per LOTO matrix from CCR?</td></tr>
    	<tr><td align="left"  style="'.$td_border.'" colspan="3">'.$checkbox.'Are all equipments emptied out/material removed?</td>
		
    	</tr>';
	
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.'<b>F) Try out done by initiator</b><br /><br />Name & sign of Initiator: <br /><br />Date&Time : </td>
		<td align="left" style="'.$td_border.'" colspan="3">'.$checkbox.'<b>G) I am briefed & understood all potential hazard involved in that activity</b><br /><br />Name & sign of Co-permittee : <br /><br />Date&Time : </td>
	</tr>';
	}

	//Loto
	if(in_array(38,$permit_types))
	{


			$table.='<tr>
				<td align="left" style="'.$td_border.'" colspan="6"><b>H)Renewal of Permit to Work</b></td>
			</tr>';

			$table.='<tr>
				<td align="left" style="'.$td_border.'">Date & Time</td>
				<td align="left"   style="'.$td_border.'">Initiator</td>
				<td align="left" style="'.$td_border.'">Issuer</td>
				<td style="'.$td_border.'">Co-permitte</td>
				<td align="left"  style="'.$td_border.'" colspan="2">Reference Code</td>
				</tr>';
			
			for($i=1;$i<=5;$i++)
			{

				$table.='<tr>
				<td align="left" style="'.$td_border.'">&nbsp;</td>
				<td align="left"   style="'.$td_border.'"></td>
				<td align="left" style="'.$td_border.'"></td>
				<td align="left"  style="'.$td_border.'"></td>
				<td align="left"  style="'.$td_border.'" colspan="2"></td>
				</tr>';
				
			}
	}
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="6"><b>I)Closure of permit to work(1st copy of Permit must be routed during permit closure)</b></td>
	</tr>';

	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">1) The job is completed, all men & material removed from site. Safe to remove isolations as stated clause. A&C</td>
		<td align="left" style="'.$td_border.'" colspan="3">Permit Initiator Name & Sign</td>
	</tr>';
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">2) Please remove isolations as stated clause. A&C </td>
		<td align="left" style="'.$td_border.'" colspan="3">Issuer Name & Sign</td>
	</tr>';
	
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">3) I have removed all isolation as listed clause.</td>
		<td align="left" style="'.$td_border.'" colspan="3">Isolator Name & Sign</td>
	</tr>';
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">4) All isolations as per clause. A&C are restored. Equipment ready to start.</td>
		<td align="left" style="'.$td_border.'" colspan="3">Issuer Name & Sign</td>
	</tr>';
	$table.='<tr>
		<td align="left" style="'.$td_border.'" colspan="3">5) 1st of permit received for record purpose.</td>
		<td align="left" style="'.$td_border.'" colspan="3">Permit Initiator Name & Sign</td>
	</tr>';

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


	$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:11px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">';
	//Mandatory measures to be taken for all type of works
    	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top"><table align="center" width="100%"  ><tr><td align="center" colspan="5"><b>PRECAUTIONS TAKEN AND EQUIPMENT PROVIDED TO PROTECT PERSONNEL FROM ACCIDENT OR INJURY.</b></td></tr>';
	$table.='</table></td></tr></table>';

	$precautions_data=(isset($precautions['precautions_mandatory'])) ? json_decode($precautions['precautions_mandatory'],true) : array();

	$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:11px !important; border: 1px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">';
	//Mandatory measures to be taken for all type of works
    $table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top"><table align="left" width="100%"  ><tr><td align="left" colspan="5"><b>Mandatory measures to be taken for all type of works:</b></td></tr>';

	$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Required usages of PPEs (Safety Helmet, Safety Shoes)</td>';

	$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Enclose the list of persons carried out the job.</td>';

	$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Five Minutes Safety Talk conducted (record to be maintained)</td>';

	$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Equipment/work area inspected.</td></tr>';

	$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Equipment electrically isolated. If YES, line clearance Permit No:</td>';
	$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left"  style="'.$valign.'">'.$checkbox.'Portable Fire Fighting system readiness.</td>';
	$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left"  style="'.$valign.'">'.$checkbox.'Tools & Tackles Checked</td>';
	
	$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left">'.$checkbox.'The place of work is made accessible and proper aggress.</td></tr>';

	$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<tr><td align="left">'.$checkbox.'Barricading and cordoning of the area.</td>';

	$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" colspan="2">'.$checkbox.'Loose dresses are to be avoided or tight properly while working near conveyors or rotating equipment’s.</td>';
	$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left">'.$checkbox.'Sufficient safe lighting facility provided.</td>';
	
	$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
	$table.='<td align="left" colspan="3">'.$checkbox.'Deputed Skilled Supervisor</td></tr>';
	
	$additional_info =  (isset($precautions['precautions_mandatory_additional_info'])) ? strtoupper($precautions["precautions_mandatory_additional_info"]) : '';

	$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';
	$table.='</table></td></tr>';

	//Hot Work (Welding, Grinding, Cutting):
	if(in_array(4,$permit_types))
	{
		$precautions_data=(isset($precautions['hotworks'])) ? explode(',',$precautions['hotworks']) : array();
		
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Hot Work (Welding, Grinding, Cutting):</td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Flammables / Combustibles/ Explosive material removed / protected. (> 35ft.)</td>';

		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Fire Watch Established</td><td align="left">'.$checkbox.'Welding & Cutting equipment positioned properly</td>';

		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Leads up and do not pose a tripping hazard</td><td align="left" style="'.$valign.'">'.$checkbox.'Area hazards reviewed</td></tr>';
		
		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Electrical connections through ELCB/RCCB of 30 mA sensitivity</td>';

		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Electrical equipment’s are free from damage and earthed properly</td>';

		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2" style="'.$valign.'">'.$checkbox.'Performer/s are competent and equipped with appropriate PPEs i.e. including face shield/welding goggles/ apron, safety shoes etc.</td>';

		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'No tampering / manipulation attempted in safety device of the equipment’s</td></tr>';

		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left"  style="'.$valign.'">'.$checkbox.'Only industrial type electrical appliances are in use</td>';

		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Cables / fuses are of adequate size & capacity fit with the requirement</td>';

		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2" style="'.$valign.'">'.$checkbox.'No cable joint within 1 Mtr. from the holder / grinding machine and completely insulated from with M/C body</td>';

		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Gas cylinders used: Oxygen / Industrial LPG / Dissolved Acetylene</td></tr>';


		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" colspan="2" style="'.$valign.'">'.$checkbox.'Gas cutting torch of reputed make, ISI marked, installed with Back Fire and Flash back arrestors are in use at both ends</td>';

		$checkbox = (in_array(13,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Hoses are free from damage and connected with hose clamp</td><td align="left">'.$checkbox.'Regulator pressure gauges in working condition, visible and not damaged</td></tr>';

		$checkbox = (in_array(14,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Welding cable and earthing cable are crimped with proper size lugs.</td></tr><tr><td align="left"  style="'.$valign.'" colspan="2">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';

		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Area wet down</td>';
		
		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Spark shields installed</td><td  style="'.$valign.'">'.$checkbox.'Fire blanket</td></tr>'; 


		$table.='<tr><td align="left" colspan="5"><i>Fire Fighting arrangements provided:</i></td></tr>';
		
		$checkbox = (in_array(16,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="padding-left:10px;'.$valign.'">'.$checkbox.'CO2</td>';
		
		$checkbox = (in_array(17,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left"  style="'.$valign.'">'.$checkbox.'Dry Chemical Powder</td>';
		$checkbox = (in_array(18,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'ABC</td>';
		$checkbox = (in_array(19,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Fire Tender</td>';
		$checkbox = (in_array(20,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Fire hose connected to hydrant </td></tr>';

		$checkbox = (in_array(21,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="padding-left:10px;'.$valign.'">'.$checkbox.'Fire hose connected to hydrant</td></tr>';

		$checkbox = (in_array(22,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" colspan="5" style="'.$valign.'">'.$checkbox.'Welding Helmet';
		
		$checkbox = (in_array(23,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Hand gloves';
		$checkbox = (in_array(24,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leather Apron';
		$checkbox = (in_array(25,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Hand Sleeves';
		$checkbox = (in_array(26,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Leg Guard';
		$checkbox = (in_array(27,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Welding Goggles for Helper';
		$checkbox = (in_array(28,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='&nbsp;&nbsp;&nbsp;'.$checkbox.'Nose Mask';
		$table.='</td></tr>';

		$additional_info =  (isset($precautions['precautions_hotworks_additional_info'])) ? strtoupper($precautions["precautions_hotworks_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>'; 
	}


	//Material lowering & lifting:
	if(in_array(10,$permit_types))
	{
		$precautions_data=(isset($precautions['materials'])) ? explode(',',$precautions['materials']) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Material lowering & lifting:</b></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Safety devices of the lifting appliances are inspected before use</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Operator qualified and medically fit including eye sight examined by authority</td>';

		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Lifting appliances are certified by competent authority and labeled properly</td>';

		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Hoist chain or hoist rope free of kinks or twists and not wrapped around the load.</td>';

		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Lifting Hook has a Safety Hook Latch that will prevent the rope from slipping out.</td></tr>';

		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Lifting gears operator been instructed not to leave the load suspended</td>';

		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Electrical power line clearance (12ft) checked</td><td align="left">'.$checkbox.'Signal man identified</td>';

		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Outriggers supported, Crane leveled</td>';
		
		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'SLI/ Load chart available in the crane</td></tr>';

		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Barrier Installed</td>';
		
		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Riggers are competent</td>';

		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'Slings are inspected for free from cut marks, pressing, denting, bird caging, twist, kinks or core protrusion prior to use.</td>';

		$checkbox = (in_array(13,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Slings mechanically spliced (Hand spliced slings may not be allowed)</td></tr>';

		
		$checkbox = (in_array(14,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'D / Bow shackles are free from any crack, dent, distortion or weld mark, wear / tear</td>';
		$table.='<td align="left">'.$checkbox.'Special lift as per erection / lift plan</td>';

		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';

		$checkbox = (in_array(16,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Guide rope is provided while shifting / lifting/lowering the load.</td>';

		$checkbox = (in_array(17,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Daily inspection checklist followed and maintained for crane</td></tr>';

		$checkbox = (in_array(18,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'SWL displayed</td>';
		
		$checkbox = (in_array(19,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left"  colspan="4">'.$checkbox.'Wind velocity < 36 KMPH, No rain</td></tr>';

		$additional_info =  (isset($precautions['precautions_material_additional_info'])) ? strtoupper($precautions["precautions_material_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>'; 
	}

	//Electrical Work:
	if(in_array(2,$permit_types))
	{
		$precautions_data=(isset($precautions['electrical'])) ? explode(',',$precautions['electrical']) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Electrical Work:</b></td></tr>';
		$table.='<tr><td align="center" colspan="5"><u>LIVE ELECTRICAL WORK PERFORMED BY LICENCED ELECRTRICIAN ONLY</u></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Obtained LOTOTO</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Power supply locked and tagged</td>';
		
		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Circuit checked for zero voltage</td>';
		
		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Portable cords and electric tools inspected</td>';
		
		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Safety back-up man appointed</td></tr>';

		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left"  style="'.$valign.'">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';
		
		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Physical isolation is ensured If yes, State the method</td>';
		
		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'In case of lock applied, ensure the safe custody of the key</td>';
		
		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2"  style="'.$valign.'">'.$checkbox.'If physical isolation is not possible state, the alternative method of precaution</td></tr>';
		
		$table.='<tr><td align="center" colspan="5"><u>Equipment Provided</u></td></tr>';

		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Approved rubber and leather gloves</td>';
		
		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Insulating mat</td>';
		
		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Fuse puller</td>';

		$checkbox = (in_array(13,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'Disconnect pole or safety rope</td></tr>';

		$checkbox = (in_array(14,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Non-conductive hard hat</td>';
		
		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colsnan="4">'.$checkbox.'ELCB/RCCB is installed of 30 mA</td>></tr>';

		$additional_info =  (isset($precautions['precautions_electrical_additional_info'])) ? strtoupper($precautions["precautions_electrical_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';

	}

	//Scaffolding Erection & Dismantling
	if(in_array(5,$permit_types) || in_array(11,$permit_types))
	{
		$precautions_data=(isset($precautions['scaffoldings'])) ? explode(',',$precautions['scaffoldings']) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Scaffolding Erection & Dismantling:</b></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" colspan="2" style="'.$valign.'">'.$checkbox.'Presence of competent person assigned to ensure safe erection, maintenance, or modification of scaffolds. Name</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'That person prior to use by personnel other than scaffolders inspects scaffold</td>';
		
		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting</td>';
		
		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'All pipes, clamps, H-frames, couplers, boards checked before assembly</td></tr>';

		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Scaffolds provided with proper access and egress</td>';
		
		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Standard guardrail been used</td>';
		
		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Platforms, walkways on scaffolds are wide of minimum of 900 mm wherever possible</td>';
		
		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Precautions taken to ensure scaffolds are not overloaded</td>';
		
		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Overhead protection provided where there is exposure</td></tr>';

		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'No opening / Gap in the platform / walkway.</td>';
		
		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="4" style="'.$valign.'">'.$checkbox.'All component of the scaffold more than 12’ away from any exposed power lines</td></tr>';
		
		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="center" colspan="5"><u>PPEs Provided</u></td></tr>';

		$checkbox = (in_array(13,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="'.$valign.'">'.$checkbox.'Safety Harness and Lanyard anchored to independent rigid object</td>';
		
		$checkbox = (in_array(14,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Lifeline Rope</td>';

		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Fall Arrestor with rope anchorage</td>';

		$checkbox = (in_array(16,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Full Body harness is used by all workmen engaged at height work</td>';

		$checkbox = (in_array(17,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" style="'.$valign.'">'.$checkbox.'Safety net is provided but not less than 5 M from the work area</td></tr>';	

		$additional_info =  (isset($precautions['precautions_scaffolding_additional_info'])) ? strtoupper($precautions["precautions_scaffolding_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';

	}

	//Confined Space Entry:
	if(in_array(7,$permit_types))
	{
		$precautions_data=(isset($precautions['confined_space'])) ? explode(',',$precautions['confined_space']) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Confined Space Entry:</b></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Equipment properly drained / Depressurized</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Disconnected Inlet, Outlet lines and isolate equipment</td>';
		
		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Vent / Manholes are kept open to maintain proper ventilation</td>';
		
		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'Only trained personnel were engaged & register was maintained for entry & exit of person with time</td></tr>';	

		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Standby Personnel/Entry supervisor,. is available</td>';
		
		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Oxygen level is measured and find………………( 19.5% - 23.5% is available</td>';
		
		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Flammable gases and vapours reading: ≤ 5% LEL</td>';

		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));		
		$table.='<td align="left" colspan="2">'.$checkbox.'Toxic gases and vapours reading: ≤ PEL values</td></tr>';	

		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Inside temperature closed to room temperature and ambient air comfortable for working</td>';
		
		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Recommended communication system</td>';
		
		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Safe Illumination provided (24-volt hand lamps)</td>';
		
		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'Additional Measures</td></tr>';	

		$additional_info =  (isset($precautions['precautions_confined_additional_info'])) ? strtoupper($precautions["precautions_confined_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}

	//U T Pump:
	if(in_array(6,$permit_types))
	{
		$precautions_data=(isset($precautions['utp'])) ? explode(',',$precautions['utp']) : array();
		
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>U T Pump:</b></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Trained persons are deployed</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Adequate water level in tank</td>';
		
		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Whiplash is provided to hose pipe</td>';
		
		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'All hoses joints thread tightened properly</td>';
		
		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Pump is earthed</td></tr>';	

		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Pressure gauge is showing reading and marking provided – Yellow/Green/Red</td>';
		
		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Jet gun connected properly and dead man switch functioning</td>';
		
		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Hoses are properly protected and barricaded</td>';

		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'PPEs are adequate for working</td></tr>';	

		$additional_info =  (isset($precautions['precautions_utp_additional_info'])) ? strtoupper($precautions["precautions_utp_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}


	//Work At Height:
	if(in_array(3,$permit_types))
	{
		$precautions_data=(isset($precautions['utp'])) ? explode(',',$precautions['utp']) : array();
		$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Work At Height:</b></td></tr>';

		$checkbox = (in_array(1,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Only medically fit personnel engaged in work and list is available</td>';
		
		$checkbox = (in_array(2,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Job Hazards is explained to all concern thru tool box talk meeting.</td>';

		$checkbox = (in_array(3,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Ladder(s) inspected prior to use</td>';

		$checkbox = (in_array(4,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="2">'.$checkbox.'Distance between the ladder support and the ladder base is at least ¼ the total length of the ladder</td></tr>';	

		$checkbox = (in_array(5,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" colspan="5">'.$checkbox.'Ladder properly supported and leveled</td></tr>';	

		$checkbox = (in_array(6,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left" style="padding-left:15px;">'.$checkbox.'Secured at Top</td>';
		
		$checkbox = (in_array(7,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="4">'.$checkbox.'Secured at Bottom</td></tr>';	

		$checkbox = (in_array(8,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Ladder been provided with skid resistant feet</td>';

		$checkbox = (in_array(9,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Scaffolds/platforms inspected for good repair and proper construction (secured flooring and guardrails)</td>';

		$checkbox = (in_array(10,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Floor openings covered Guarded</td>';
		
		$checkbox = (in_array(11,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Work area roped off and warning signs in place</td>';

		$checkbox = (in_array(12,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Proper Housekeeping is done</td></tr>';

		$checkbox = (in_array(13,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Personnel assigned to warn of floor opening or other hazardous exposure.</td>';
		
		$checkbox = (in_array(14,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Tools and other equipment stored in safe manner</td>';

		$checkbox = (in_array(15,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="3">'.$checkbox.'Area cleared below prior to starting work</td></tr>';

		$table.='<tr><td align="center" colspan="5"><u>PPEs Provided</u></td></tr>';

		$checkbox = (in_array(16,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Safety Harness and Lanyard anchored to independent rigid object</td>';

		$checkbox = (in_array(17,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left">'.$checkbox.'Lifeline Rope</td>';

		$checkbox = (in_array(18,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="3">'.$checkbox.'Fall Arrestor with rope anchorage</td></tr>';

		$checkbox = (in_array(19,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<tr><td align="left">'.$checkbox.'Full Body harness is used by all workmen engaged at height work.</td>';

		$checkbox = (in_array(20,$precautions_data)) ? checkbox(array('status'=>'yes','style'=>'float: right;vertical-align: top;')) : checkbox(array('status'=>'no','style'=>'float: right;vertical-align: top;'));
		$table.='<td align="left" colspan="4">'.$checkbox.'Safety net is provided but not less than 5 M from the work area</td></tr>';

		$additional_info =  (isset($precautions['precautions_workatheights_additional_info'])) ? strtoupper($precautions["precautions_workatheights_additional_info"]) : '';

		$table.='<tr><td align="left" colspan="5"><i>Additional Info(If any):</i> '.$additional_info.'</td></tr>';

		$table.='</table></td></tr>';
	}


	//Job specific Tool box Talk
	$table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;;border-right:1px solid #ccc;" valign="top"><table align="left" width="100%" ><tr><td align="left" colspan="5"><b>Job specific Tool box Talk:</b></td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:50px;"><b>Persons Engaged for the job: </b>(if more than 6 persons were engaged for work, then separate sheet to be attached)</td></tr>';

	$table.='<tr><td align="center" colspan="5" style="padding-left:150px;"><table align="center" border="1" style="width:750px;border-collapse: collapse;"><tr><td style="width:10%;text-align:center;"><b>S.No</b></td><td align="center"><b>Contractor Name</b></td><td align="center"><b>Sub Contractor</b></td><td align="center"><b>No. of workers</b></td><td align="center"><b>Sign</b></td></tr>';

	for($i=1;$i<=10;$i++)
	{

		$table.='<tr><td  align="center" height="20">'.$i.'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';

	}
	
	
	
	
	
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

