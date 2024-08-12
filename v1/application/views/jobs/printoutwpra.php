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

 $table_border=$row_border='border:1px solid #000000;border-collapse: collapse;table-layout: fixed;';

 $checkbox='<img src="'.base_url().'/assets/img/checkbox_no1.png" height="10" width="10" />';

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


 $header='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:8.5px !important; border: 0px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
   
	<tr style="border:1px solid #ccc;" >
        <td style="border:1px solid #ccc;width:15% !important;" colspan="1" id="t2" rowspan="2"  align="center">
			<img src="'.base_url().'assets/img/Daco_4764006.png" width="120" height="61">
		</td>
        <td style="border:1px solid #ccc;" colspan="10" id="t2"><center><h1>Your Company Name (B) Ltd - Location</h1></center>
		<span style="float:right"><b style="font-size:14px !important;">Permit No : #'.$records['permit_no'].'</b></span>
		</td>
        <td style="border:0px solid #ccc;"  colspan="2" rowspan="2" id="t2" align="center"><img src="'.base_url().'assets/img/Daco_4764006.png" width="120" height="61"></td>
    </tr></table>';

//$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">
$table.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>';

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
							<td colspan="2" style="'.$fontSize.'">General Work Permit: <br />'.$records['permit_no'].'</td><td style="'.$fontSize.'">Start Date: <br />'.$location_time_start.'</span></td>
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
		<td colspan="3" align="right" style="'.$fontSize.'"><b>SL. No. '.$records['permit_no'].'</td>
		</tr>

		<tr style="'.$row_height.'">
				<td style="'.$table_border.$fontSize.'" colspan="2">Dept: <br />'.$department['name'].'</td>
				<td style="'.$table_border.$fontSize.'">Area/Location: <br />'.strtoupper($zone_name).'</td>
		</tr>

		<tr style="'.$row_height.'">
			<td style="'.$table_border.$fontSize.'" colspan="2">Start Date: <br />'.$location_time_start.$hrs.'</td>
			<td style="'.$table_border.$fontSize.'">End Date: <br />'.$location_time_to.$hrs.'</td>
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

$fontSize="font-size:10vw !important;";
$row_height='height:16px;'.$fontSize;
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
</table>';
   
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

