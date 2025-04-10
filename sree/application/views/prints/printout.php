<?php
error_reporting(0);

$hrs=' HRS';

$table='';

 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $td_border="border: 1px solid #000000;padding-left:5px;display: inline-block;";

 $td_top_border="border-top: 1px solid #000000;padding-left:5px;display: inline-block;";

 function get_authorities($authority_id,$authorities,$merge_ec_code='')
{
	$acceptance_issuing_name=array();

	foreach($authorities as $fet)
	{
	
	
	$id=$fet['id'];
	
	$first_name=strtoupper($fet['first_name']);     

	$ec=strtoupper($fet['employee_id']);     

	$department_name=strtoupper($fet['department_name']);

	if($authority_id==$id)
		{ $acceptance_issuing_name=array('name'=>$first_name,'ec'=>$ec,'department_name'=>$department_name); break; }

	}
	return $acceptance_issuing_name;
}

$permit_types=unserialize(PLANT_TYPES);

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important;	margin:0 auto;border-collapse:collapse;"  align="center">
   <tr><td>&nbsp;</td></tr>
	<tr  >
        <td style="width:15% !important;font-size:14px;" align="center" colspan="3">
			<b>SHREE CEMENT LTD., NAWALGARH</b> <br />
            (A unit of Shree Cement Ltd.)<br />
            Village Gothara, The Nawalgarh, Distt.- Jhunjhunu (Raj.) Pin 333304
		</td> 
    </tr><tr><td colspan="3">&nbsp;</td></tr><tr><td align="left" style="font-size:14px;">Work Permit For <b>'.$permit_types[$records['permit_for']].'</b></td><td colspan="2" align="right" style="font-size:14px;">Permit No <b>'.$records['permit_no'].'</b></td></tr><tr><td colspan="3">&nbsp;</td></tr></table>';
 

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';

$table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; border-collapse:collapse;padding-top:555px;'.$td_border.'"><tr><td colspan="5" align="justify"><b>SCOPE:</b>  For permitting job at a height of more than 10 feet., Material Handling , working in confined space , excavation, welding Cutting and use of open flame at all locations of the plant area. </td></tr>';

$permit_types=json_decode($records['permit_type_ids'],true);
$permit_type_names='';
foreach($permits as $p_type):

	if(in_array($p_type['id'],$permit_types))
	$permit_type_names.='<b>'.strtoupper($p_type['name']).'</b>,';

endforeach;

$permit_type_names=rtrim($permit_type_names,',');

$user_info=get_authorities($records['acceptance_performing_id'],$allusers,1);

$name = '<b>'.$user_info['name'].'</b>';
$ec = '<b>'.$user_info['ec'].'</b>';
$dept = '<b>'.$user_info['department_name'].'</b>';

$select_contractor_id=(isset($records['contractor_id'])) ? explode(',',$records['contractor_id']) : array();	
	  
$contractor_name='';	  

foreach($contractors as $list)
{
	if(in_array($list['id'],$select_contractor_id)) { $contractor_name.=strtoupper($list['name']).','; } 
}

$contractor_name=rtrim($contractor_name,',');

$copermittee=(isset($records['copermittee_id']) && $records['copermittee_id']!='') ?  'M/s.'.$records['copermittee_id'] : 'NA';	

$location_time_start=(isset($records['location_time_start'])) ?  $records['location_time_start'] : '';	

$location_time_to=(isset($records['location_time_to'])) ?  $records['location_time_to']  : '';	

$job_name=$records['job_name'];

$created=$records['created'];

$table.='<tr><td colspan="5" style="border-top: 1px solid #000000;line-height:55px;">'.$permit_type_names.' Permit released to (Name of Initiator) Mr.'.$name.' EC '.$ec.' of '.$dept.'. For Contractors <b>'.$contractor_name.'</b> Co Permitee (if any) <b>'.$copermittee.'</b>. On date <b>'.date('d.m.Y',strtotime($location_time_start)).'</b>. From <b>'.date('h:i A',strtotime($location_time_start)).'</b> to (expiry time) <b>'.date('d.m.Y H:i A',strtotime($location_time_to)).'</b>
For <b>'.strtoupper($job_name).'</b>. As per details digitally entered by Initiator Mr.'.$name.' EC '.$ec.' of '.$dept.'.
On Date: <b>'.date('d.m.Y',strtotime($created)).'</b>.Time: <b>'.date('H:i A',strtotime($created)).'</b>.</td></tr>';

$table.='<tr><td colspan="5">&nbsp;</td></tr>';
//Checklists
$checklists=json_decode($precautions['checklists'],true);

foreach($permits as $p_type):

	if(in_array($p_type['id'],$permit_types))
	{

		$permit_type_id=$p_type['id'];

		$table.='<tr><td colspan="5"><b>'.$p_type['name'].'</b></td></tr>';

		$table.='<tr><td colspan="2" style="'.$td_border.'width:15%;" align="center"><b>Precautionary checks to be complied by Initiator</b></td><td align="center" style="'.$td_border.'"><b>Yes</b></td><td align="center" style="'.$td_border.'"><b>No</b></td><td align="center" style="'.$td_border.'"><b>NA</b></td></tr>';
			
		$filters = array_filter($permit_type_checklists, function ($filt) use($permit_type_id) { return $filt['permit_type_id'] == $permit_type_id; });

		if(count($filters)>0)
		{	
			foreach($filters as $filter):

				$checklist_id=$filter['id'];

				$status=isset($checklists[$checklist_id]) ? $checklists[$checklist_id] : 'na';

				${'y'}='';${'n'}=''; ${'na'}='';

				${$status}='<img src="'.base_url().'assets/img/'.$status.'.png"  style="vertical-align: top;" height="10" width="10" />';

				$table.='<tr><td colspan="2" style="'.$td_border.'">'.$filter['name'].'</td><td style="'.$td_border.'" align="center">'.$y.'</td><td style="'.$td_border.'" align="center">'.$n.'</td><td style="'.$td_border.'" align="center">'.$na.'</td></tr>';

			endforeach;

			$table.='<tr><td colspan="5">&nbsp;</td></tr>';
		}

		
	}

endforeach;

$table.='<tr><td colspan="5" style="border-top: 1px solid #000000;line-height:25px;">With reference to above work, I confirm as under All precautions/ safety measures filled digitally by me for the above job for personal protection and safe job execution have been taken as indicated above. <br />As per details digitally entered by Initiator Mr.'.$name.' EC '.$ec.' of '.$dept.'.
On Date: <b>'.date('d.m.Y',strtotime($created)).'</b>.Time: <b>'.date('H:i A',strtotime($created)).'</b>.</td></tr>';


//Isolations
$is_loto=(isset($records['is_loto'])) ? $records['is_loto'] : ''; 

if($is_loto==YES){

	$job_isolations=isset($job_isolations) ? $job_isolations : array();

	$eq_given_locals=isset($job_isolations['eq_given_local']) ? json_decode($job_isolations['eq_given_local'],true) : array();

	$equipment_tag_nos=isset($job_isolations['equipment_descriptions_name']) ? json_decode($job_isolations['equipment_descriptions_name'],true) : array();

	$equipment_descriptions_names=isset($job_isolations['equipment_tag_nos']) ? json_decode($job_isolations['equipment_tag_nos'],true) : array();

	$isolated_tagno1=isset($job_isolations['isolated_tagno1']) ? json_decode($job_isolations['isolated_tagno1'],true) : array();

	$isolated_tagno3=isset($job_isolations['isolated_tagno3']) ? json_decode($job_isolations['isolated_tagno3'],true) : array();

	$approved_isolated_user_ids=isset($job_isolations['approved_isolated_user_ids']) ? json_decode($job_isolations['approved_isolated_user_ids'],true) : array();

	$isolated_name_approval_datetimes=isset($job_isolations['isolated_name_approval_datetime']) ? json_decode($job_isolations['isolated_name_approval_datetime'],true) : array();

	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>Isolation by E&I/ Process/Mechanical</b></td></tr>';

	$sub_table=''; $return_sub_table='';

	$eq_given_locals=array_filter($eq_given_locals);

	foreach($eq_given_locals as $key_id => $local):  

		$description_name=$equipment_descriptions_names[$key_id];

		$eq_tag_no=$equipment_tag_nos[$key_id];

		$tag_no3=$isolated_tagno3[$key_id];

		$tag_no1=$isolated_tagno1[$key_id];

		$approved_isolated_user_id=$approved_isolated_user_ids[$key_id];

		$isolated_name_approval_datetime=$isolated_name_approval_datetimes[$key_id];

		$name=$ec=$dept=$date=$time='……………';

		if($approved_isolated_user_id!='')
		{
			$user_info=get_authorities($approved_isolated_user_id,$allusers,1);

			$name = $user_info['name'];
			$ec = $user_info['ec'];
			$dept = $user_info['department_name'];

			if($isolated_name_approval_datetime!='')
			{
				$date=date('d.m.Y',strtotime($isolated_name_approval_datetime));	
				$time=date('H:i A',strtotime($isolated_name_approval_datetime));
			}	
		}

		

		$table.='<tr><td colspan="5">LOTO done for equipment (Name) <b>'.$description_name.'</b>.Equipment Tag No <b>'.$eq_tag_no.'</b> done and Isolation Tag bearing Sr. no. <b>'.$tag_no3.'</b> displayed at MCC. As per details digitally entered by Isolator  Mr.<b>'.$name.'</b> .EC <b>'.$ec.'</b> of (Deptt) <b>'.$dept.'</b>. On Date: <b>'.$date.'</b>.Time: <b>'.$time.'</b>.</td></tr>'; 
		
		$sub_table.='<tr><td colspan="5">Key no <b>'.$tag_no1.'</b> of the lock used for isolation of  equipment (Name)<b>'.$description_name.'</b>.Equipment Tag No <b>'.$eq_tag_no.'</b> with me also try out for this equipment done. As per details digitally entered by Initiator  Mr.<b>'.$name.'</b> .EC <b>'.$ec.'</b> of (Deptt) <b>'.$dept.'</b>. On Date: <b>'.$date.'</b>.Time: <b>'.$time.'</b>.</td></tr>'; 

		$return_sub_table.='<tr><td colspan="5">Request to Remove lock for reenergize the equipment bearing Isolation Tag No. <b>'.$tag_no3.'</b> equipment (Name) <b>'.$description_name.'</b> Equipment Tag No <b>'.$eq_tag_no.'</b> key is returned by me to isolator.</td></tr>';


	endforeach;

	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>Declaration by initiator</b></td></tr>';

	$table.=$sub_table;

	$user_info=get_authorities($records['acceptance_performing_id'],$allusers,1);

	$name = '<b>'.$user_info['name'].'</b>';
	$ec = '<b>'.$user_info['ec'].'</b>';
	$dept = '<b>'.$user_info['department_name'].'</b>';

	$table.='<tr><td colspan="5" style="padding-top:15px;">As per details digitally entered by Initiator Mr.'.$name.' EC '.$ec.' of '.$dept.'.On Date: <b>'.date('d.m.Y',strtotime($created)).'</b>.Time: <b>'.date('H:i A',strtotime($created)).'</b>.</td></tr>';

	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>Declaration by Issuer</b></td></tr>';

	$ccr_lists=unserialize(CCR_CHECKLISTS);

	$issuer_checklists=(isset($records['issuer_checklists'])) ? json_decode($records['issuer_checklists'],true) : array(); 

	$table.='<tr><td style="'.$td_border.'width:25%;" align="center"><b>Checklists</b></td><td align="center" style="'.$td_border.'width:5%;"><b>Yes</b></td><td align="center" style="'.$td_border.'width:5%;"><b>No</b></td><td align="center" style="'.$td_border.'width:5%;"><b>NA</b></td><td align="center" style="'.$td_border.'width:15%;"><b>Any Other Inst or advice</b></td></tr>';

	$c=1; $ccr_lists_count=count($ccr_lists);

	$issuer_cecklists_notes=$records['issuer_cecklists_notes'];

	foreach($ccr_lists as $key => $val):

		$data = (isset($issuer_checklists[$key])) ? $issuer_checklists[$key] : 'na';

		${'y'}='';${'n'}=''; ${'na'}='';

		${$data}='<img src="'.base_url().'assets/img/'.$data.'.png"  style="vertical-align: top;" height="10" width="10" />';

		$table.='<tr><td style="'.$td_border.'">'.$val.' '.$c.' '.$ccr_lists_count.'</td><td align="center"  style="'.$td_border.'">'.$y.'</td><td align="center"  style="'.$td_border.'">'.$n.'</td><td align="center"  style="'.$td_border.'">'.$na.'</td>';

		if($c==1){
				$table.='<td rowspan="'.$ccr_lists_count.'" style="'.$td_border.'" valign="top">'.$issuer_cecklists_notes.'</td>';
		}

		$c++;

		$table.='</tr>';

	endforeach;

	$user_info=get_authorities($records['acceptance_issuing_id'],$allusers,1);

	$name = '<b>'.$user_info['name'].'</b>';
	$ec = '<b>'.$user_info['ec'].'</b>';
	$dept = '<b>'.$user_info['department_name'].'</b>';

	$table.='<tr><td colspan="5" style="padding-top:15px;">As per details digitally entered by Issuer Mr.'.$name.' EC '.$ec.' of '.$dept.'.On Date: <b>'.date('d.m.Y',strtotime($created)).'</b>.Time: <b>'.date('H:i A',strtotime($created)).'</b>.</td></tr>';

	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>BY SAFETY Rep.: WE DON’T HAVE THIS INPUT IN APP</b></td></tr>';

	$table.='<tr><td colspan="5" style="padding-top:15px;">……….. Nos. Safety belts, to be used, found suitable and considered safe to proceed with work.</td></tr>';
}



$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>Permit Approval:</b></td></tr>';

$table.='<tr><td colspan="5">In view of above, permit to <b>'.$permit_type_names.'</b> work for above job is approved.</td></tr>';

$user_info=get_authorities($records['acceptance_custodian_id'],$allusers,1);
$acceptance_custodian_date=date('d.m.Y H:i A',strtotime($records['acceptance_custodian_date']));

$name = $user_info['name'];
$ec = $user_info['ec'];


$table.='<tr><td colspan="5" align="right"><b>'.$name.'('.$ec.') '.$acceptance_custodian_date.'</b> <br />(Deptt Head/Area Incharge)</td></tr>';


$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>ISSUER:</b></td></tr>';

$table.='<tr><td colspan="5">In view of above, permit to <b>'.$permit_type_names.'</b> for above jobs is issued.</td></tr>';

$user_info=get_authorities($records['acceptance_issuing_id'],$allusers,1);
$acceptance_issuing_date=date('d.m.Y H:i A',strtotime($records['acceptance_issuing_date']));

$name = $user_info['name'];
$ec = $user_info['ec'];


$table.='<tr><td colspan="5" align="right"><b>'.$name.'('.$ec.') '.$acceptance_issuing_date.'</b> <br />(Deptt Head/Area Incharge)</td></tr>';


if($is_loto==YES){

	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>RETURN:</b></td></tr>';

	$table.='<tr><td colspan="5">The above job is completed & all the men and materials have been removed from the work place. Guards removed for doing the job have been replaced & the work area cleaned. The permit <b>'.$records['permit_no'].'</b> returned LOTO  key is returned by me to isolator.</td></tr>';

	$loto_closure_ids=isset($records['loto_closure_ids']) && $records['loto_closure_ids']!='' ? json_decode($records['loto_closure_ids'],true) : array();
	$loto_closure_ids_dates=isset($records['loto_closure_ids_dates']) && $records['loto_closure_ids_dates']!='' ? json_decode($records['loto_closure_ids_dates'],true) : array();

	$name='...........';
	$ec='..........';
	$dept='...........';
	$loto_closure_pa_dates='On Date: ........... Time: .............';

	if(count($loto_closure_ids)>0){

		$loto_closure_pa=isset($loto_closure_ids[1]) && $loto_closure_ids[1]!='' ? $loto_closure_ids[1] : '';
		$loto_closure_pa_dates=isset($loto_closure_ids_dates[1]) && $loto_closure_ids_dates[1]!='' ? $loto_closure_ids_dates[1] : '';
		$user_info=get_authorities($loto_closure_pa,$allusers,1);
		$name = $user_info['name'];
		$ec = $user_info['ec'];
		$dept = $user_info['department_name'];

		if($loto_closure_pa_dates!=''){
			$loto_closure_pa_dates='On Date: '.date('d.m.Y',strtotime($loto_closure_pa_dates)).'. Time: '.date('h:i A',strtotime($loto_closure_pa_dates));
		}

	}

	$table.=$return_sub_table. '<tr><td colspan="5"><br />As per details digitally entered by Initiator  Mr.<b>'.$name.'</b>.EC <b>'.$ec.'</b> of (Deptt) <b>'.$dept.'</b>.'.$loto_closure_pa_dates.'</td></tr>';

	

	$name='...........';
	$ec='..........';
	$dept='...........';
	$loto_closure_pa_dates='........... on (date) .............';
	$loto_closure_pa_dates2='On Date: ........... Time: .............';

	if(count($loto_closure_ids)>0){

		$loto_closure_pa=isset($loto_closure_ids[2]) && $loto_closure_ids[2]!='' ? $loto_closure_ids[2] : '';
		$loto_closure_pa_dates=isset($loto_closure_ids_dates[2]) && $loto_closure_ids_dates[2]!='' ? $loto_closure_ids_dates[2] : '';

		$user_info=get_authorities($loto_closure_pa,$allusers,1);
		$name = $user_info['name'];
		$ec = $user_info['ec'];
		$dept = $user_info['department_name'];

		$flag=0;

		if($loto_closure_pa_dates!=''){

			$flag=1;
			$loto_closure_pa_dates=date('h:i A',strtotime($loto_closure_pa_dates)).' on (date) '.date('d.m.Y',strtotime($loto_closure_pa_dates));

			$loto_closure_pa_dates2='On Date: '.date('d.m.Y',strtotime($loto_closure_pa_dates)).'. Time: '.date('h:i A',strtotime($loto_closure_pa_dates));
		}

	}

	if($flag==1) { 
	$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>RE-ENERGIZING THE EQUIPMENT:</b></td></tr>';
	$table.='<tr><td colspan="5">Motor of the above equipment reconnected/ re-energized and tag removed.
at '.$loto_closure_pa_dates.'. <br />As per details digitally entered by Isolator  Mr. <b>'.$name.'</b>. EC <b>'.$ec.'</b> of (Deptt) <b>'.$dept.'</b>. '.$loto_closure_pa_dates2.'</td></tr>';
	}


}


$table.='<tr><td colspan="5" style="'.$td_top_border.'"><b>PERMIT CLOSURE:</b></td></tr>';

$cancellation_issuing_id=$records['cancellation_issuing_id'];
$cancellation_issuing_date=$records['cancellation_issuing_date'];

$name='...........';
$ec='..........';
$dept='...........';

$loto_closure_pa_dates='........... on (date) .............';
$loto_closure_pa_dates2='On Date: ........... Time: .............';

if($cancellation_issuing_id!='')
{
	$user_info=get_authorities($cancellation_issuing_id,$allusers,1);
	$name = $user_info['name'];
	$ec = $user_info['ec'];
	$dept = $user_info['department_name'];
}

if($cancellation_issuing_date!=''){
	$loto_closure_pa_dates=date('h:i A',strtotime($cancellation_issuing_date)).' on (date) '.date('d.m.Y',strtotime($cancellation_issuing_date));

	$loto_closure_pa_dates2='On Date: '.date('d.m.Y',strtotime($cancellation_issuing_date)).'. Time: '.date('h:i A',strtotime($cancellation_issuing_date));
}

$table.='<tr><td colspan="5">The permit closed at <b>'.$loto_closure_pa_dates.'</b> <br /> 
As per details digitally entered by Issuer  Mr. <b>'.$name.'</b>.EC <b>'.$ec.'</b> of (Deptt) <b>'.$dept.'</b>.'.$loto_closure_pa_dates2.'</td></tr>';


$table.='<tr><td colspan="5" style="'.$td_border.'" align="center">Issue and extension of this permit shall be the responsibility of Engr./ Supervisor who is directly supervising the execution of work  at site.</td></tr>';

$table.='</table>';

#echo $table;
try
{
		include_once APPPATH.'/third_party/mpdf60/mpdf.php';

		$footer="";

	
		$mpdf=new mPDF('c','A4-L','','',10,10,30,10,10,10);
		//                             L,R,T,
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->SetHTMLHeader($header);
		$mpdf->SetFooter($footer.'{PAGENO}');
		$mpdf->AddPage('P','','','','',15,15,35,30,10,10);
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

