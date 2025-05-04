<?php
error_reporting(0);
header('Content-type: application/json');
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

$font_style='font-family:Arial, Helvetica, sans-serif;';

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important;	margin:0 auto;border-collapse:collapse;"  align="center">
   <tr><td>&nbsp;</td></tr>
	<tr  >
        <td style="width:15% !important;font-size:14px;" align="center" colspan="3">
			<b>SHREE CEMENT LTD., NAWALGARH</b> <br />
            (A unit of Shree Cement Ltd.)<br />
            Village Gothara, The Nawalgarh, Distt.- Jhunjhunu (Raj.) Pin 333304
		</td> 
    </tr><tr><td colspan="3">&nbsp;</td></tr><tr><td align="left" style="font-size:14px;">Scaffolding for <b>'.$records['permit_no'].'</b></td><td colspan="2" align="right" style="font-size:14px;">Scaffolding ID <b>'.$records['scaffolding_id'].'</b></td></tr><tr><td colspan="3">&nbsp;</td></tr></table>';
 

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';

$table.='<p align="center" style="'.$font_style.'"><b><u>REQUEST FOR SCAFFOLDING (Part 1)</u></b></p>';

$table.='<p align="left" style="'.$font_style.'"><b>To Civil Deptt</b></p>';

$table.='<p style="'.$font_style.'">I hereby request that the scaffolding for purpose of <b>'.strtoupper($records['purpose_of']).'</b> be erected at <b>'.strtoupper($records['location']).'.</b>(Location) for the duty (select from load table as given below) and height <b>'.$records['meter'].' Meter.</p>';


$load_duties=(isset($records['load_duty'])) && $records['load_duty']!=''  ? json_decode($records['load_duty'],true) : array();

$titles=array(1=>'Maximum  Safe load in Kg',2=>'Maximum bay length / width in Meter');

$title_values[1]=array(1=>array(0=>75,1=>150),2=>array(2=>225,3=>300),3=>array(4=>450,5=>600));
$title_values[2]=array(1=>array(0=>2.7,1=>2.2),2=>array(2=>1.8,3=>1.4),3=>array(4=>1.0,5=>0.8));

$title_types=array(1=>'Light duty',2=>'General purpose (Medium duty)',3=>'Heavy duty or special duty');

$table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; border-collapse:collapse;padding-top:555px;'.$td_border.'"><tr>
<th colspan="2" style="height:25px;text-align:center;'.$td_border.'">Load Duty</th>';

foreach($title_types as $t_key => $tinfo):
$table.='<th colspan="2" style="text-align:center;'.$td_border.'">'.$tinfo.'</th>';
endforeach;

$table.='</tr>';

$title_type=$title_type_value='';

$rr=1;
foreach($titles as $t_key => $title):

    $td_values=$title_values[$t_key];

    $val=(isset($load_duties[$t_key])) ? $load_duties[$t_key] : '';

    $table.=' <tr><td style="'.$td_border.'" colspan="2">'.$title.'</td>';

    foreach($td_values as $td_key => $values):

        foreach($values as $v_key => $value):

            $sel=($val==$v_key && $val!='') ? '<img src="'.base_url().'assets/img/y.png"  style="vertical-align: top;" height="10" width="10" />' : '';

            if($rr==1 && $val==$v_key && $val!=''){
                $title_type=$title_types[$td_key];
                $title_type_value=$value;
            }

            $table.='<td style="text-align:center;height:25px;'.$td_border.'">'.$sel.' '.$value.'</td>';
        endforeach;
    
    endforeach;

    $rr++;

    $table.='</tr>';

endforeach;

$table.='</table>';

$user_info=get_authorities($records['acceptance_performing_id'],$allusers,1);

$name = '<b>'.$user_info['name'].'</b>';
$ec = '<b>'.$user_info['ec'].'</b>';
$dept = '<b>'.$user_info['department_name'].'</b>';


$table.='<p style="'.$font_style.'">(Name & Signature of Maintenance Engineer)<br />'.$name.' EC '.$ec.' of '.$dept.' <br/>'.date('d.m.Y H:i:A',strtotime($records['acceptance_performing_date'])).$hrs.'</p>';


$table.='<p align="center">'.str_repeat('*',100).'</p>';


$table.='<p align="center" style="'.$font_style.'"><b><u>CERTIFICATES OF FITNESS FOR SCAFFOLDING (Part 2)</u></b></p>';

$table.='<p style="'.$font_style.'">I hereby certify that the scaffolding erected for work permit no <b>'.$records['permit_no'].'</b> is ready and fit for use  I further certify that it is intended for <b>'.$title_type.'</b> service and fit for a load of <b>'.$title_type_value.'</b> Kg and should not be overloaded.</p>';

$table.='<table align="center" width="100%"  style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; border-collapse:collapse;padding-top:555px;"><tr>
<th colspan="2" style="height:25px;text-align:left;"><b>Name and signature of
Maintenance Engineer</b><br /><br/>'.$name.' EC '.$ec.' of '.$dept.' <br/><b>'.date('d.m.Y H:i:A',strtotime($records['acceptance_performing_date'])).$hrs.'</b>
</th>';


$user_info=get_authorities($records['acceptance_issuing_id'],$allusers,1);

$name = '<b>'.$user_info['name'].'</b>';
$ec = '<b>'.$user_info['ec'].'</b>';
$dept = '<b>'.$user_info['department_name'].'</b>';

$table.='<th colspan="2" style="height:25px;text-align:right;"><b>Name and signature of
Civil Engr</b><br /><br/>'.$name.' EC '.$ec.' of '.$dept.' <br/>'.date('d.m.Y H:i:A',strtotime($records['acceptance_issuing_date'])).$hrs.'
</th>';

$table.='</tr></table><pagebreak />';


$table.='<p align="center" style="'.$font_style.'"><b><u>INSPECTION CHECK LIST (Part 3)</u></b></p>';

$table.='<table align="center" style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; border-collapse:collapse;padding-top:555px;">';

$table.='<tr><td colspan="2" style="'.$td_border.'width:150px;height:20px;" align="center"><b>Check Points</b></td><td align="center" style="'.$td_border.'width:150px;"><b>Yes</b></td><td align="center" style="'.$td_border.'width:150px;"><b>No</b></td><td align="center" style="'.$td_border.'width:150px;"><b>NA</b></td></tr>';

$jobs_checklists_values=(isset($records['check_points'])) ? json_decode($records['check_points'],true) : array();

foreach($checklists as $checklists):

	$key=$checklists['id'];
	$label=$checklists['name'];

	$data = (isset($jobs_checklists_values[$key])) ? $jobs_checklists_values[$key] : '';

	${'y'}='';${'n'}=''; ${'na'}='';

	if($data!='')
	${$data}='<img src="'.base_url().'assets/img/'.$data.'.png"  style="vertical-align: top;" height="10" width="10" />';

	$table.='<tr><td colspan="2" style="'.$td_border.'height:15px;">'.$label.'</td><td style="'.$td_border.'" align="center">'.$y.'</td><td style="'.$td_border.'" align="center">'.$n.'</td><td style="'.$td_border.'" align="center">'.$na.'</td></tr>';

endforeach;

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
		$mpdf->AddPage($pdf_type,'','','','',15,15,35,30,10,10);
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

		$file_name='/'.$records['permit_no'].'_'.time().'.pdf';

		$file=$path.$file_name;

		$mpdf->Output($file,'F');
}
catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
                                   //       name used for catch
    // Process the exception, log, print etc.
	echo json_encode(array('file_path'=>'','status'=>'0','msg'=>'Failed to generate PDF'));
    exit;
}

echo json_encode(array('file_path'=>base_url().'uploads/permits/'.$records['id'].$file_name,'status'=>'1','msg'=>'OK'));
exit;

?>

