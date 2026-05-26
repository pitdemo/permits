<?php


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
	
	return '<img src="'.base_url().'assets/img/checkbox_'.$status.'.png" '.$style.' height="10" width="10" />';
}


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

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<table style="font-family:Arial, Helvetica, sans-serif;width:100%;width:100%;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
   
	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/print_logo.jpg" >
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Dalmia Cement (B) Ltd - '.BRANCH_NAME.'</h1><br /><h1>Excavation Permit</h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/print_symbol.jpg" ></td>
    </tr></table><table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:12px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">';


    $table.='<tr><td style="border-left:1px solid #ccc;padding-top:10px;" valign="top" width="50%"><table align="center" width="100%" ><tr><td align="left">
    	<b>Department :</b>'.$department['name'].'</td><td align="left"><b>Zone : </b>'.strtoupper($zone_name).'</td></tr>
    	<tr><td colspan="2" align="left"  style="'.$padding_top.'"><b>Location : </b>'.$location.'</td></tr>
    	<tr><td align="left" style="'.$padding_top.'"><b>Date From : </b>'.$location_time_start.'</td><td><b>Date To : </b>'.$location_time_to.'</td></tr>
    	<tr><td colspan="2" align="left"  style="'.$padding_top.'"><b>This Permits Cover</b></td></tr>
    	<tr><td colspan="2" align="left"  style="'.$padding_top.'">1) Any excavation on the ground <br />2) Road Concreate Breaking</td></tr>';

    $desc=(isset($records['job_name'])) ? strtoupper($records['job_name']) : '';

    $earth_work_depth=(isset($records['earth_work_depth'])) ? strtoupper($records['earth_work_depth']) : '';
    

    $table.='<tr><td  align="left"  style="'.$padding_top.'"><b>Description of Work</b> <br />'.$desc.' <br /><br /><b>Permit Issued to</b></td><td  align="left"  style="'.$padding_top.'" valign="top"><b>Earth work depth</b> <br />'.$earth_work_depth.'</td></tr>';


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

	  $table.='<tr><td align="left" style="'.$padding_top.'"><b>Name of Contractor : </b>'.$contractor_name.'</td><td><b>No of Persons : </b>'.$contractors_involved.'</td></tr><tr><td colspan="2">&nbsp;</td></tr>';    

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'border-top:1px solid #cccccc;"><b>Electrical & Instrumental Department:</b></td></tr>';

  $yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->b)) ? $precautions->b : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

  $depth=(isset($m_depth->b) && $m_depth->b!='') ? '<b>'.$m_depth->b.'</b>' : '&nbsp;';	

  $remarks=(isset($dept_remarks->b)) ? strtoupper($dept_remarks->b) : '- - -';

  $cable_deductor = isset($records['cable_deductor']) ? $records['cable_deductor'] : '- - -';
  $cable_deductor_yes_active=$cable_deductor_no_active='';
  if($cable_deductor=='Yes') 
  $cable_deductor_yes_active=$checked;
  else if($cable_deductor=='No') 
  $cable_deductor_no_active=$checked;	


	  $table.='<tr><td align="left" style="'.$padding_top.'">1) Underground Electrical cables are passing through the area</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

	 // $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">2) Underground Electrical Cables at <u>'.$depth.'</u> m depth <br /><br /><b>Remarks (If any):</b><br />'.$remarks.'</td></tr>';

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">2) Underground Electrical Cables at <u>'.$depth.'</u> m depth <br />3) Excavated work space area inspected with live cable deductor: <input type="radio" '.$cable_deductor_yes_active.'>Yes&nbsp;<input type="radio" '.$cable_deductor_no_active.'>No <br /><br /><b>Remarks (If any):</b><br />'.$remarks.'</td></tr>';


  $dept_issue_id=(isset($dept_issuing_id->b)) ? $dept_issuing_id->b : '';
  $dept_date=(isset($dept_issuing_date->b)) ? $dept_issuing_date->b : '';
  $name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
	  }
  }

	  $table.='<tr><td align="left" style="'.$padding_top.'"><b>Name </b><br />'.$name.'</td><td align="left"><b>Digitally Signed/Date&Time</b><br />'.$dept_date.'</td></tr>';



$table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'border-top:1px solid #cccccc;"><b>IT Department:</b></td></tr>';

  $yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->c)) ? $precautions->c : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No')  
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

  $depth=(isset($m_depth->c) && $m_depth->c!='') ? '<b>'.$m_depth->c.'</b>' : '&nbsp;';	

  $remarks=(isset($dept_remarks->c)) ? strtoupper($dept_remarks->c) : '- - -';

	  $table.='<tr><td align="left" style="'.$padding_top.'">1) Underground IT cables are passing through the area</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">2) Underground IT Cables at <u>'.$depth.'</u> m depth<br /><br /><b>Remarks (If any):</b><br />'.$remarks.'</td></tr>';


  $dept_issue_id=(isset($dept_issuing_id->c)) ? $dept_issuing_id->c : '';
  $dept_date=(isset($dept_issuing_date->c)) ? $dept_issuing_date->c : '';
  $name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
	  }
  }

	  $table.='<tr><td align="left" style="'.$padding_top.'"><b>Name </b><br />'.$name.'<br /><br /><br /></td><td align="left"><b>Digitally Signed/Date&Time </b><br />'.$dept_date.'<br /><br /><br /></td></tr>';



    $table.='</table></td><td width="50%" style="border-left:1px solid #ccc;border-right:1px solid #ccc;" valign="top"><table align="center" width="100%">';


    $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'"><b>Mechanical Department:</b></td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->d)) ? $precautions->d : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

  $depth=(isset($m_depth->d) && $m_depth->d!='') ? '<b>'.$m_depth->d.'</b>' : '&nbsp;';	

  $remarks=(isset($dept_remarks->d)) ? strtoupper($dept_remarks->d) : '- - -';


	  $table.='<tr><td align="left" style="'.$padding_top.'">1) Underground Pipe Lines</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">2) Underground Pipe Line at <u>'.$depth.'</u> m depth<br /><br /><b>Remarks (If any):</b><br />'.$remarks.'</td></tr>';


  $dept_issue_id=(isset($dept_issuing_id->d)) ? $dept_issuing_id->d : '';
  $dept_date=(isset($dept_issuing_date->d)) ? $dept_issuing_date->d : '';
  $name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
	  }
  }

$table.='<tr><td align="left" style="'.$padding_top.'"><b>Name </b><br />'.$name.'</td><td align="left"><b>Digitally Signed/Date&Time </b><br />'.$dept_date.'</td></tr>';


$table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'border-top:1px solid #cccccc;"><b>Safety Department:</b></td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->e)) ? $precautions->e : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

  $depth=(isset($m_depth->e) && $m_depth->e!='') ? '<b>'.$m_depth->e.'</b>' : '&nbsp;';	

  $remarks=(isset($dept_remarks->e)) ? strtoupper($dept_remarks->e) : '- - -';


	  $table.='<tr><td align="left" style="'.$padding_top.'">1) Underground Fire Hydrant Line is passing through the area</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">2) Underground Fire Hydrant line at <u>'.$depth.'</u> m depth</td></tr>';

	  $manual_done=(isset($records['manual_done'])) ? '<b>'.$records['manual_done'].'</b>' : '';

	  $powered=(isset($records['powered'])) ? '<b>'.$records['powered'].'</b>' : '';

	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">Excavation to be done by Manual : '.$manual_done.' Powerd : '.$powered.'</td></tr>';


$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->f)) ? $precautions->f : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

$table.='<tr><td align="left" style="'.$padding_top.'">1) Work area Barricaded</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->g)) ? $precautions->g : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

$table.='<tr><td align="left" style="'.$padding_top.'">2) Arrangements made for road diversion</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->h)) ? $precautions->h : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

$table.='<tr><td align="left" style="'.$padding_top.'">3) Arrangements made for climbing up and down</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->i)) ? $precautions->i : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

$table.='<tr><td align="left" style="'.$padding_top.'">4)Arrangements made for Removing Excess excavated soil</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';

$yes_active='';
  $no_active='';
  if(isset($records))
  {
	  $pre=(isset($precautions->j)) ? $precautions->j : '';

	  if($pre=='Yes') 
	  $yes_active=$checked;
	  else if($pre=='No') 
	  $no_active=$checked;	
  }
  else
  $no_active=$checked;

$table.='<tr><td align="left" style="'.$padding_top.'">5)Arrangements made for shoring /shuttering</td><td align="right"><input type="radio" '.$yes_active.'>Yes&nbsp;<input type="radio" '.$no_active.'>No</td></tr>';	  


$table.='<tr><td align="left" style="'.$padding_top.'" valign="top" colspan="2"><b>Remarks (If any):</b><br />'.$remarks.'</td></tr>';

  $dept_issue_id=(isset($dept_issuing_id->e)) ? $dept_issuing_id->e : '';
  $dept_date=(isset($dept_issuing_date->e)) ? $dept_issuing_date->e : '';
  $name='';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
	  }
  }

	  $table.='<tr><td align="left" style="'.$padding_top.'"><b>Name </b><br />'.$name.'</td><td align="left"><b>Digitally Signed/Date&Time </b><br />'.$dept_date.'</td></tr>';


	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'border-top:1px solid #cccccc;">&nbsp;</td></tr>';

  $dept_issue_id=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';

 

  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $id=$fet['id'];
		  
		 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
	  }
  }	  



	  $table.='<tr><td colspan="2" align="left"  style="'.$padding_top.'">

	  <table align="center" width="100%">
	  	<tr><td><b>Performing Authority</b></td><td align="left" ><b>Issuing Authority</b></td></tr>

	  	<tr><td align="left" style="'.$padding_top.'"><b>Name </b><br />'.$name.'</td>';

	  $dept_issue_id=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';

	  if($authorities!='')
	  {
		  foreach($authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			 if($dept_issue_id==$id) { $name=strtoupper($fet['first_name']); break; }
		  }
	  }

  	$table.='<td align="left" valign="top"><b>Name </b><br />'.$name.'</td></tr>';

  	$dept_date=(isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : '';

  	$acceptance_name_of_ia=(isset($records['acceptance_name_of_ia'])) ? strtoupper($records['acceptance_name_of_ia']) : '';

  	$table.='<tr><td align="left" style="'.$padding_top.'" valign="top"><b>Digitally Signed/Date&Time </b><br />'.$dept_date.'<p><b>Name of IA</b>: <br />'.$acceptance_name_of_ia.'</p><br /></td>';

  	$dept_date=(isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '';

  	$remarks=(isset($records['acceptance_issuing_remarks'])) ? strtoupper($records['acceptance_issuing_remarks']) : '';
  	$table.='<td align="left" valign="top" style="'.$padding_top.'"><b>Digitally Signed/Date&Time </b><br />'.$dept_date.' <br /><b>Remarks (If any)<br />'.$remarks.'<br /><br /></td>';

  	$table.='</tr></table>';

	

	  $table.='</td></tr>';

    $table.='</table></td></tr></table>';

    #echo $table; exit;

     #$table.='<table align="center" width="100%"><tr><td colspan="2" align="center" style="border: 1px solid #000;"><b>Emergency contact Number 3108 / 9942989056</b></td></tr></table>';


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

