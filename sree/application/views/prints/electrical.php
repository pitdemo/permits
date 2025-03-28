<?php
error_reporting(0);
$hrs=' HRS';

$table='';

$location_time_start=(isset($records['location_time_start'])) ?  $records['location_time_start'].$hrs : '';	

$location_time_to=(isset($records['location_time_to'])) ?  $records['location_time_to'].$hrs  : '';	

 $padding_top='padding-top:7px;';

 $valign='vertical-align:top;';

 $td_border="border: 1px solid #000000;padding-left:5px;display: inline-block;";

 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important;	margin:0 auto;border-collapse:collapse;"  align="center">
   <tr><td>&nbsp;</td></tr>
	<tr  >
        <td style="width:15% !important;font-size:14px;" colspan="1"   align="center">
			<b>SHREE CEMENT LTD., NAWALGARH</b> <br />
            (A unit of Shree Cement Ltd.)<br />
            Village Gothara, The Nawalgarh, Distt.- Jhunjhunu (Raj.) Pin 333304
		</td> 
    </tr><tr><td>&nbsp;</td></tr></table>';
   

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';

$isolated_name_approval_datetimes=json_decode($records['isolated_name_approval_datetime'],true);
$equipment_descriptions_names=json_decode($records['equipment_tag_nos'],true);
$equipment_tag_nos=json_decode($records['equipment_descriptions_name'],true);
$acceptance_performing_id=$records['acceptance_performing_id'];

$isolated_tagno1=json_decode($records['isolated_tagno1'],true);
$isolated_tagno3=json_decode($records['isolated_tagno3'],true);
$approved_isolated_user_ids=json_decode($records['approved_isolated_user_ids'],true);

$count=count(array_filter($isolated_name_approval_datetimes));





$c=0;

    foreach($isolated_name_approval_datetimes as $key => $info):

        if($info!='')
        {

            $table.='<table align="center"  style="font-family:Arial, Helvetica, sans-serif;width:70%;font-size:12px !important; margin:0 auto;border-collapse:collapse;margin-top:25px;">';

            $exp=explode(' ',$info);

            $equipment_descriptions_name=$equipment_descriptions_names[$key];

            $equipment_tag_no=$equipment_tag_nos[$key];

            $tagno1=$isolated_tagno1[$key];

            $tagno3=$isolated_tagno3[$key];

            $approved_isolated_user_id=$approved_isolated_user_ids[$key];

            $cust_filter = array_search($approved_isolated_user_id, array_column($users_info, 'id'));
            
            $isolator_name='';

            if($cust_filter>0)
                $isolator_name=$users_info[$cust_filter]['first_name'];

            $cust_filter = array_search($acceptance_performing_id, array_column($users_info, 'id'));

            $initiator_name=$users_info[$cust_filter]['first_name'];

            $department_name=$users_info[$cust_filter]['department_name'];

           $table.='<tr><td colspan="3">&nbsp;</td></tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Date :</b>'.date('d.m.Y',strtotime($exp[0])).'</td>
            <td align="left"  width="15%"  style="'.$td_border.'"><b>Time : </b>'.date('h.i A',strtotime($exp[1])).'</td>
            <td align="left"  width="15%"  style="'.$td_border.'"><b>Permit No : </b>'.$records['permit_no'].'</td>
            </tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Equipment Under Shutdown </b></td>
            <td align="left"  width="15%"   style="'.$td_border.'">'.strtoupper($equipment_descriptions_name).'</td>
            <td align="left"  width="15%"  style="'.$td_border.'">'.$equipment_tag_no.'</td>
            </tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Lock (Key No.) </b></td>
            <td align="left"  width="15%"   style="'.$td_border.'">'.$tagno1.'</td>
            <td align="left"  width="15%"  style="'.$td_border.'">'.$tagno3.'</td>
            </tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Lock Key Handover to User</b></td>
            <td align="left"  width="15%"   style="'.$td_border.'"></td>
            <td align="left"  width="15%"  style="'.$td_border.'"></td>
            </tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Initiator Name </b></td>
            <td align="left"  width="15%"   style="'.$td_border.'">'.strtoupper($initiator_name).'</td>
            <td align="left"  width="15%"  style="'.$td_border.'">'.$department_name.'</td>
            </tr>';

            $table.='<tr>
            <td align="left" width="15%" style="'.$td_border.'"><b>Isolator Name </b></td>
            <td align="left"  width="15%"   style="'.$td_border.'">'.strtoupper($isolator_name).$c.' '.$count.'</td>
            <td align="left"  width="15%"  style="'.$td_border.'"></td>
            </tr>';

            $table.='</table>';

            $c++;

            if($c!=$count)
            $table.='<pagebreak />';

        }

    endforeach;
    
    

   # echo $table; exit;

     #$table.='<table align="center" width="100%"><tr><td colspan="2" align="center" style="border: 1px solid #000;"><b>Emergency contact Number 3108 / 9942989056</b></td></tr></table>';


try
{
		include_once APPPATH.'/third_party/mpdf60/mpdf.php';

		$footer="";

	
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

