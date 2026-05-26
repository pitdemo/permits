<?php
#echo 'AA '.UPLODPATH; exit;

$hrs=' HRS';
	$job_status_error_msg=(isset($job_status_error_msg))? $job_status_error_msg : '';
	
	$temp_show='';$department_user_validation=0;
	
	$eip_completed_departments=unserialize(EIP_COMPLETED_DEPARTMENTS);

	$eip_id=(isset($records['id'])) ? $records['id'] : '';
		
			  $approval_status=(isset($records['approval_status'])) ? $records['approval_status'] : '';		
			  
			  $issuing_authority_id2_approval=$issuing_authority_id3_approval=$performing_authority_id2_approval='';	 
			  
			  $select_department=(isset($records['department_id'])) ? $records['department_id'] : '';	
			  
		if($isolations->num_rows()>0)
		$isolations=$isolations->result_array();
		else
		$isolations='';
		
$table='';
$table.='<table style="font-family:Arial, Helvetica, sans-serif;width:100%;font-size:10px !important; border: 2px solid #000000;	margin:0 auto;border-collapse:collapse;"  align="center">

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
</colgroup>';

$date_start=(isset($records['date_start'])) ? date('d-m-Y',strtotime($records['date_start'])) : date('d-m-Y');

$date_end = (isset($records['date_end'])) ? date('d-m-Y',strtotime($records['date_end'])) : '';

$time_start = (isset($records['time_start'])) ? $records['time_start'] : date('H:i');

$time_end = (isset($records['time_end'])) ? $records['time_end'] : '';

$table.='<tr style="border:1px solid #ccc;">
    <td style="border:1px solid #ccc;" colspan="3" id="t2"   align="center"><img src="'.base_url().'/assets/img/print_logo.jpg" ></td>
    <td style="border:1px solid #ccc;" colspan="4" id="t2"><center><h2>Dalmia Cement (B) Ltd - '.BRANCH_NAME.' <br/> Energy Isolation Permit </h2></center></td>
    <td style="vertical-align: bottom"><b>S.No : '.$sl_no.'</b></td>
    <td style="border:0px solid #ccc;"  colspan="2" id="t2"   align="center"><img src="'.base_url().'/assets/img/print_symbol.jpg" ></td>
</tr>';

$table.='<tr rowspan="2">
    <td style="border:1px solid #ccc; vertical-align: top" colspan="6" rowspan="2" > <strong> (A) To be filled by the Performing Authority :</strong></td>
    <td style="border:1px solid #ccc;" width="" colspan="2">Date : <b>'.$date_start.'</b></td>
    <td style="border:1px solid #ccc;" width="" colspan="2" >Valid Upto : <b>'.$date_end.'</b></td>
</tr>';

$table.='<tr>   <td style="border:1px solid #ccc;" width="" colspan="2">Time : <b>'.$time_start.$hrs.' </b></td>
                <td style="border:1px solid #ccc;" width="" colspan="2">Time : <b>'.$time_end.$hrs.'</b></td>
                </tr>';
$dept_name='';				
if($departments->num_rows()>0)
{
	$departments=$departments->result_array();
	
	foreach($departments as $list)
	{
		if($select_department==$list['id']) {
		$dept_name=strtoupper($list['name']); break; }
	}
}
$zone_name='';
$select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';			  
if($zones->num_rows()>0)
{
	$zones=$zones->result_array();
	
	foreach($zones as $list)
	{
		if($select_zone_id==$list['id'])
		{ $zone_name=strtoupper($list['name']); break; }
	}
}



$section=(isset($records['section'])) ? strtoupper($records['section']) : '';

$area = (isset($records['area'])) ? strtoupper($records['area']) : '';

$work_permit_nos = (isset($records['work_permit_nos'])) ? $records['work_permit_nos'] : '';

$work_permit_job_name = (isset($records['work_permit_job_name'])) ? $records['work_permit_job_name'] : '';

$table.='<tr align="center" rowspan="2">
    <td style="border:1px solid #ccc;height: 40px;vertical-align: top;" colspan="2" align="center">Dept <br /> 
	<b>'.$dept_name.'</b></td>
	<td style="border:1px solid #ccc;vertical-align: top;" colspan="2" align="center">Section <br /><b>'.$section.'</b></td>
    <td style="border:1px solid #ccc;vertical-align: top;" colspan="2" align="center">Area <br /><b>'.$area.'</b></td>
    <td style="border:1px solid #ccc;vertical-align: top;" colspan="4">Ref Work Permit NOs <br /><b>'.$work_permit_nos.'</b></td>
</tr>';

$table.='<tr>
    <td style="border:1px solid #ccc;" colspan=10 id="t2">Description of Work : <b>'.strtoupper($work_permit_job_name).'</b></td>
</tr>';
$table.='<tr align="center">
    <td style="border:1px solid #ccc;" colspan="1"><strong>S.NO</strong></td>
    <td style="border:1px solid #ccc;" colspan="3"><strong>Description Of Equipment</strong></td>
    <td style="border:1px solid #ccc;" colspan="3"><strong>Equipment Tag No</strong></td>
    <td style="border:1px solid #ccc;" colspan="3"><strong>Isolation Type</strong></td>
</tr>';

$loop_count=$records['is_checklist'];

         if($records)
		 {
         	$equipment_descriptions=json_decode($records['equipment_descriptions']);
			
			$loop_count=count(array_filter(json_decode($records['equipment_descriptions'],true)));	
		 }
         else
         $equipment_descriptions=array();

         if($records)
         $equipment_tag_nos=json_decode($records['equipment_tag_nos']);
         else
         $equipment_tag_nos=array();

     	if($records)
     	$equipment_radio=json_decode($records['equipment_radio']);
     	else
     	$equipment_radio=array();

         if($records)
         $isolate_types=json_decode($records['isolate_types']);
         else
         $isolate_types=array();

     	$checklist_count=count($zones_fetch);

     	$desc_checklist=array();

     	if($checklist_count>0)
     	{
     		$desc_checklist=array_column($zones_fetch, 'id');
     	}

  $k=1;
   $additional_rows=EIP_CHECKLIST_ADDITIONAL_ROWS_START;


 for($i=1;$i<=$loop_count;$i++)
 {
 	$dont_include_row=0; $add_flag=0;

	 $desc=(isset($equipment_descriptions->$i)) ? $equipment_descriptions->$i : '';

	 if($desc=='')
	 {
	 	if(isset($equipment_descriptions->$additional_rows)) { $desc=$equipment_descriptions->$additional_rows; $add_flag=1; } 
	 }

	 if($checklist_count>0 && $desc!='')
	 {
	 	$key = array_search($desc, $desc_checklist);

	 	#echo '<br /> Desc '.$desc.' = '.$i.' = Key '.$key;

	 	if($add_flag==0)
	 	$eq_radio=(isset($equipment_radio->$i)) ? $equipment_radio->$i : 'No';
	 	else
	 	$eq_radio='Yes';	

	 	if(is_numeric($key))
	 	{
	 		$desc=$zones_fetch[$key]['equipment_name'];
	 	}	

	 	if($eq_radio!='Yes')
	 	$dont_include_row=1;	
	 }

	 $tag_nos = (isset($equipment_tag_nos->$i)) ? $equipment_tag_nos->$i : '';

	 if($tag_nos=='')
	 {
	 	if(isset($equipment_tag_nos->$additional_rows)) { $tag_nos=$equipment_tag_nos->$additional_rows;  } 

	 }


	 $isolate_type=(isset($isolate_types->$i)) ? $isolate_types->$i : '';

	 if($isolate_type=='')
	 {
	 	if(isset($isolate_types->$additional_rows)) { $isolate_type=$isolate_types->$additional_rows; $additional_rows++; } 

	 }

	 $name = '';
	  if(count($isolations)>0)
	  {
		  foreach($isolations as $fet)
		  {
			  $record_type=$fet['record_type'];
			  
			  $id=$fet['id'];
			  
			  if($record_type=='isolation_type')
			  {
					if($isolate_type==$id) { $name = $fet['name']; break; }
			  }
		  }
	  }

	  if($dont_include_row==0)
	  {	
	     $table.='<tr align="center">
	        <td style="border:1px solid #ccc;" colspan="1" align="center">'.$k.'</td>
	        <td style="border:1px solid #ccc;" colspan="3"><b>'.strtoupper($desc).'</b></td>
	        <td style="border:1px solid #ccc;" colspan="3"><b>'.strtoupper($tag_nos).'</b></td>
	        <td style="border:1px solid #ccc;" colspan="3"><b>'.strtoupper($name).'</b></td>
	    </tr>';

	    $k++;
	  } 
	  

  }

$remarks_performing_id=(isset($records['remarks_performing_id'])) ? $records['remarks_performing_id'] : '';

$first_name='';

      if($authorities!='')
      {
             foreach($authorities as $fet)
             {
				  $role=$fet['user_role'];
				  
				  $id=$fet['id'];
              
					if($remarks_performing_id==$id)
					{ $first_name=$fet['first_name']; break; } 
                                   
			  }
      }

$signature = (isset($records['remarks_performing_date'])) ? $records['remarks_performing_date'].$hrs : '';
	  
$table.='<tr>
    <td style="border:1px solid #ccc;" colspan="5" rowspan="2" id="t2">Name of the Performing Authority : <b>'.strtoupper($first_name).'</b></td>
    <td style="border:1px solid #ccc;" width="" colspan="5" style="border-bottom:1px solid #FFF">Digitally Signed : </td>
</tr>';

$table.='<tr>
    <td style="border:1px solid #ccc;" width="" colspan="5" id="t2">Date & Time : <b>'.$signature.'</b></td>
</tr>';


$table.='<tr>
    <td style="border:1px solid #ccc;" width="" colspan="10" id="t2"><strong>(B) Remarks by the Issuing Authority : </strong></td>
</tr>';

$list_equip = (isset($records['remarks_issuing_authority_1'])) ? $records['remarks_issuing_authority_1'] : '';

$list_equip2 = (isset($records['remarks_issuing_authority_2'])) ? $records['remarks_issuing_authority_2'] : '';

$remarks_issuing_id=(isset($records['remarks_issuing_id'])) ? $records['remarks_issuing_id'] : '';

$first_name = '';
	  if($issuing_authorities!='')
	  {
		  foreach($issuing_authorities as $fet)
		  {
			  $id=$fet['id'];
			  
			  
			  if($remarks_issuing_id==$id) { $first_name=$fet['first_name']; break; }
		  }
	  }

$remarks_issuing_date=(isset($records['remarks_issuing_date'])) ? $records['remarks_issuing_date'].$hrs : '';

$table.='<tr>
    <td style="border:1px solid #ccc;" colspan="7">1. List of Equipment where isolation resolution is ok <b>'.strtoupper($list_equip).'</b></td>
    <td style="border:1px solid #ccc;" width="" colspan="3">Name of the IA : <b>'.strtoupper($first_name).'</b></td>
</tr>';
$table.='<tr>
    <td style="border:1px solid #ccc;" colspan="7">2. Following Additional isolations / safety measures are required <b>'.strtoupper($list_equip2).'</b></td>
    <td style="border:1px solid #ccc;" width="" colspan="3">Digitally Signed :  </td>
</tr>';

$table.='<tr>
    <td style="border:1px solid #ccc;" colspan="7"></td>
    <td style="border:1px solid #ccc;" colspan="3">Date & Time : <b>'.$remarks_issuing_date.'</b></td>
</tr>';

$table.='<tr>
    <td style="border:1px solid #ccc;" width="" colspan="10" id="t2"><strong>(C) To be filled by the authorized person (Performing Authority or Isolator) who is carry out isolations : </strong></td>
</tr>';

$table.='<tr>
    <th style="border:1px solid #ccc; width:5%" width="5%"><strong>S.NO</strong></th>
    <th style="border:1px solid #ccc;"><strong>Equipment Tag No</strong></th>
    <th style="border:1px solid #ccc;"><strong>Isolation Type</strong></th>
	<th style="border:1px solid #ccc;"><strong>Description Of Isolation</strong></th>
    <th style="border:1px solid #ccc;" colspan="2">PA Lock</th>
    <th style="border:1px solid #ccc;" colspan="2">ISO Lock</th>
    <th style="border:1px solid #ccc;">Name of Auth Isolator</th>
    <th style="border:1px solid #ccc;">Digitally Signed</th>
</tr>';

$loop_count=20;

         if(isset($records))
         { $isolated_equipment_descriptions=json_decode($records['isolated_equipment_descriptions']); 
		 	
		   if($records['isolated_equipment_descriptions']!='')
		   $loop_count=count(array_filter(json_decode($records['isolated_equipment_descriptions'],true))); 	
		 }
         else
         $isolated_equipment_descriptions=array();

         if(isset($records))
         $isolated_equipment_tag_nos=json_decode($records['isolated_equipment_tag_nos']);
         else
         $isolated_equipment_tag_nos=array();


         if(isset($records))
         $isolated_isolate_types=json_decode($records['isolated_isolate_types']);
         else
         $isolated_isolate_types=array();

         if(isset($records))
         $isolated_tagno1=json_decode($records['isolated_tagno1']);
         else
         $isolated_isolate_types=array();

         if(isset($records))
         $isolated_tagno2=json_decode($records['isolated_tagno2']);
         else
         $isolated_isolate_types=array();

         if(isset($records))
         $isolated_tagno3=json_decode($records['isolated_tagno3']);
         else
         $isolated_isolate_types=array();

         if(isset($records))
         $isolated_tagno4=json_decode($records['isolated_tagno4']);
         else
         $isolated_isolate_types=array();


     	 if(isset($records))
         $isolated_ia_names=json_decode($records['isolated_ia_name']);
         else
         $isolated_ia_names=array();

		
         if(isset($records))
         $isolated_names=json_decode($records['isolated_name']);
         else
         $isolated_names=array();

         if(isset($records))
         $isolated_name_approval=json_decode($records['isolated_name_approval']);
         else
         $isolated_name_approval=array();
 
         if(isset($records))
         $isolated_name_approval_datetime=json_decode($records['isolated_name_approval_datetime']);
         else
         $isolated_name_approval_datetime=array();
		 
		# echo '<pre>'; print_r($isolated_name); exit;

	for($i=1;$i<=$loop_count;$i++)
	{
            $isolated_equipment_description=(isset($isolated_equipment_descriptions->$i)) ? $isolated_equipment_descriptions->$i : '';
			
			$isolated_name_id=(isset($isolated_names->$i)) ? $isolated_names->$i : '';
			
			$isolated_name_approval=(isset($isolated_name_approval->$i)) ? $isolated_name_approval->$i : '';
		
			$isolated_equipment_tag_no=(isset($isolated_equipment_tag_nos->$i)) ? $isolated_equipment_tag_nos->$i : '';
			
			$isolated_isolate_type=(isset($isolated_isolate_types->$i)) ? $isolated_isolate_types->$i : '';
			
			$isolated_name_approval_dttime=(isset($isolated_name_approval_datetime->$i)) ? $isolated_name_approval_datetime->$i.$hrs : '';

			$isolated_ia_name=(isset($isolated_ia_names->$i)) ? '<br /><br /><div><b style="float:left;padding-left:10px;">Name of the IA </b></div>'.strtoupper($isolated_ia_names->$i) : '';
			
			$iso_type_name='';
		  if(count($isolations)>0)
		  {
			  foreach($isolations as $fet)
			  {
				  $record_type=$fet['record_type'];
				  
				  $id=$fet['id'];
				  
				  if($isolated_isolate_type==$id) { $iso_type_name=$fet['name']; break; }
			  }
		  }

			$iso_type_desc='';
		  if(count($isolations)>0)
		  {
			  foreach($isolations as $fet)
			  {
				  $record_type=$fet['record_type'];
				  
				  $id=$fet['id'];
				  
				  if($isolated_equipment_description==$id) { $iso_type_desc=$fet['name']; break; }
			  }
		  }
		
		$iso_tag1=(isset($isolated_tagno1->$i)) ? $isolated_tagno1->$i : '';
		
		$iso_tag2=(isset($isolated_tagno2->$i)) ? $isolated_tagno2->$i : '';
		
		$iso_tag3=(isset($isolated_tagno3->$i)) ? $isolated_tagno3->$i : '';
		
		$iso_tag4=(isset($isolated_tagno4->$i)) ? $isolated_tagno4->$i : '';	
		
		$isolated_name='';
			
		if(!empty($isolated_isolate_type))
		{
				$get_iso=$this->jobs_isolations_model->get_isolation_users(array('isolation_type_id'=>$isolated_isolate_type));
				
				#echo '<br /> Query : '.$this->db->last_query();
				if($get_iso->num_rows()>0)
				{
					 $fet_iso=$get_iso->result_array();
		
					foreach($fet_iso as $list)
					{
						if($list['id']==$isolated_name_id)
						{ $isolated_name = $list['first_name']; break; }
					}
				}
		}
		
		#echo '<br /> Name : '.$isolated_name.' = '.$isolated_isolate_type.' - '.$isolated_name_id;
		$table.='<tr>
	<td style="border:1px solid #ccc;" align="center">'.$i.'</td>
	<td style="border:1px solid #ccc;">'.strtoupper($isolated_equipment_tag_no).'</td>
	<td style="border:1px solid #ccc;">'.strtoupper($iso_type_name).'</td>
	<td style="border:1px solid #ccc;">'.strtoupper($iso_type_desc).'</td>
	<td style="border:1px solid #ccc;" align="center">'.strtoupper($iso_tag1).'</td>
	<td style="border:1px solid #ccc;" align="center">'.strtoupper($iso_tag2).'</td>
	<td style="border:1px solid #ccc;" align="center" colspan="2">'.strtoupper($iso_tag3).'</td>
	<!-- <td style="border:1px solid #ccc;" align="center">'.strtoupper($iso_tag4).'</td> -->
	<td style="border:1px solid #ccc;">'.strtoupper($isolated_name).'</td>
	<td style="border:1px solid #ccc;">'.strtoupper($isolated_name_approval_dttime).' '.$isolated_ia_name.'</td>
	  </tr>';
	}
	
      $yes_active='';
      $no_active=$na_active='';
      if(isset($records))
      {
          $is_equipment_stopped=(isset($records['is_equipment_stopped'])) ? $records['is_equipment_stopped'] : '';
          
          if($is_equipment_stopped=='No') 
          $no_active='checked="checked"';
          else if($is_equipment_stopped=='N/A')
          $na_active='checked="checked"';
          else
          $yes_active='checked="checked"';
      }
      else
      $na_active='checked="checked"';

  	  
			$table.='<tr>
		    <td style="border:1px solid #ccc;" width="" colspan="10" id="t2"><strong>(D) To be filled and ensured by the Issuing Authority </strong></td>
		</tr>';
		$table.='<tr><td style="border:1px solid #ccc;" colspan="1">1</td><td style="border:1px solid #ccc;" colspan="6">Is equipment stopped & Isolated</td><td style="border:1px solid #ccc;" colspan="3" align="center"><input type="radio" disabled name="is_equipment_stopped" class="radio_button on_off" '.$yes_active.' />YES&nbsp;<input type="radio" disabled name="is_equipment_stopped" class="radio_button on_off" '.$no_active.' />NO&nbsp;<input type="radio" disabled name="is_equipment_stopped" class="radio_button on_off" '.$na_active.' />N/A</td></tr>';

		      $yes_active='';
		      $no_active=$na_active='';
		      if(isset($records))
		      {
		          $is_equipment_stopped=(isset($records['is_stopped_isoloated'])) ? $records['is_stopped_isoloated'] : '';
		          
		          if($is_equipment_stopped=='No') 
		          $no_active='checked="checked"';
		          else if($is_equipment_stopped=='N/A')
		          $na_active='checked="checked"';
		          else
		          $yes_active='checked="checked"';
		      }
		      else
		      $na_active='checked="checked"';


			$table.='<tr><td style="border:1px solid #ccc;" colspan="1">2</td><td style="border:1px solid #ccc;" colspan="6">Are preceding & Succeeding Equipments also stopped & Isolated</td><td style="border:1px solid #ccc;" colspan="3" align="center"><input type="radio" disabled name="is_stopped_isoloated" class="radio_button on_off" '.$yes_active.' />YES&nbsp;<input type="radio" disabled name="is_stopped_isoloated" class="radio_button on_off" '.$no_active.' />NO&nbsp;<input type="radio" disabled name="is_stopped_isoloated" class="radio_button on_off" '.$na_active.' />N/A</td></tr>';

		      $yes_active='';
		      $no_active=$na_active='';
		      if(isset($records))
		      {
		          $is_isoloation_drained_fully=(isset($records['is_isoloation_drained_fully'])) ? $records['is_isoloation_drained_fully'] : '';
		          
		          if($is_isoloation_drained_fully=='No') 
		          $no_active='checked="checked"';
		          else if($is_isoloation_drained_fully=='N/A')
		          $na_active='checked="checked"';
		          else
		          $yes_active='checked="checked"';
		      }
		      else
		      $na_active='checked="checked"';
			  
			  $is_isoloation_drained_fully_options=(isset($records['is_isoloation_drained_fully_options'])) ? explode(',',$records['is_isoloation_drained_fully_options']) : array();
			
				$including=(in_array('including compressed air',$is_isoloation_drained_fully_options)) ? 'checked="checked"' : '';
				
				$supply = (in_array('supply to air blaster',$is_isoloation_drained_fully_options)) ? 'checked="checked"' : '';
				
				$material= (in_array('input material',$is_isoloation_drained_fully_options)) ? 'checked="checked"' : '';
				
				$gas_entry = (in_array('gas entry/exist',$is_isoloation_drained_fully_options)) ? 'checked="checked"' : '';
				
				$water = (in_array('water/oil',$is_isoloation_drained_fully_options)) ? 'checked="checked"' : '';

				$table.='<tr><td style="border:1px solid #ccc;" colspan="1">3</td><td style="border:1px solid #ccc;" colspan="6">
		        Has the vessel/equipment/pipe line been positively isolated from all sources? <br /><input class="is_isoloation_drained_fully_options" type="checkbox" name="is_isoloation_drained_fully_options[]" disabled value="including compressed air" '.$including.' />Including compressed air <input class="is_isoloation_drained_fully_options" type="checkbox" name="is_isoloation_drained_fully_options[]" disabled value="including compressed air" '.$supply.' /> supply to air blaster <input class="is_isoloation_drained_fully_options" type="checkbox" name="is_isoloation_drained_fully_options[]" disabled value="including compressed air" '.$material.' /> input material <input class="is_isoloation_drained_fully_options" type="checkbox" name="is_isoloation_drained_fully_options[]" disabled value="including compressed air" '.$gas_entry.' />gas entry/exist stream  <input class="is_isoloation_drained_fully_options" type="checkbox" name="is_isoloation_drained_fully_options[]" disabled value="including compressed air" '.$water.' />water/oil  and radiation source, if applicable
		    </td><td style="border:1px solid #ccc;" colspan="3" align="center"><input type="radio" disabled name="is_isoloation_drained_fully" class="radio_button on_off" '.$yes_active.' />YES&nbsp;<input type="radio" disabled name="is_isoloation_drained_fully" class="radio_button on_off" '.$no_active.' />NO&nbsp;<input type="radio" disabled name="is_isoloation_drained_fully" class="radio_button on_off" '.$na_active.' />N/A</td></tr>';
			
			      $yes_active='';
		      $no_active=$na_active='';
		      if(isset($records))
		      {
		          $is_isoloation_permit=(isset($records['is_isoloation_permit'])) ? $records['is_isoloation_permit'] : '';
		          
		          if($is_isoloation_permit=='No') 
		          $no_active='checked="checked"';
		          else if($is_isoloation_permit=='N/A')
		          $na_active='checked="checked"';
		          else
		          $yes_active='checked="checked"';
		      }
		      else
		      $na_active='checked="checked"';


		$table.='<tr><td style="border:1px solid #ccc;" colspan="1">4</td><td style="border:1px solid #ccc;" colspan="6">Have equipment/pipeliness de-pressurized (vent Open) process material(s) emptied out and drained fully?<td style="border:1px solid #ccc;" colspan="3" align="center"><input type="radio" disabled name="is_isoloation_permit" class="radio_button on_off" '.$yes_active.' />YES&nbsp;<input type="radio" disabled name="is_isoloation_permit" class="radio_button on_off" '.$no_active.' />NO&nbsp;<input type="radio" disabled name="is_isoloation_permit" class="radio_button on_off" '.$na_active.' />N/A</td></tr>';

		 $issuing_authority_id2=(isset($records['issuing_authority_id2'])) ? $records['issuing_authority_id2'] : '';
		 
		 $first_name = '';
		       if($issuing_authorities!='')
		      {
		          foreach($issuing_authorities as $fet)
		          {
		              $id=$fet['id'];

				  	  if($issuing_authority_id2==$id) { $first_name=$fet['first_name']; break; }
		          }
		      }

			$issuing_authority_id2_date=(isset($records['issuing_authority_id2_date']) && $records['issuing_authority_id2_date']!='') ? $records['issuing_authority_id2_date'].$hrs : '';

			$table.='<tr><td style="border:1px solid #ccc;" colspan="7">Comment by the Issuer: I have ensured that all isolations mentioned in clause  A, B,C & D are completed. Clear to start the job.</td>
			    <td style="border:1px solid #ccc;" colspan="3">Name of the IA : <b>'.$first_name.'</b><br>
			        Digitally Signed :<br>
			        Date & Time: <b>'.$issuing_authority_id2_date.'</b><br></td></tr>';

			$performing_authority_id2=(isset($records['performing_authority_id2'])) ? $records['performing_authority_id2'] : $remarks_performing_id;

			$first_name='';
			      if($authorities!='')
			      {
			          foreach($authorities as $fet)
			          {
			              $id=$fet['id'];
			              
			              if($performing_authority_id2==$id) { $first_name=$fet['first_name']; break; }
			          }
			      }

			$performing_authority_id2_date=(isset($records['performing_authority_id2_date']) && $records['performing_authority_id2_date']!='') ? $records['performing_authority_id2_date'].$hrs : '';

			$table.='<tr><td style="border:1px solid #ccc;" colspan="7">(E) Performing Authority<br>I understand clause A,B,C&D, I shall maintain conditions as required</td>
			    <td style="border:1px solid #ccc;" colspan="3">Name of the Performing Authority : <b>'.$first_name.'</b><br>

			        Digitally Signed :<br>
			        Date & Time: <b>'.$performing_authority_id2_date.'</b><br></td></tr>';

			$table.='<tr><td style="border:1px solid #ccc;" colspan="10">(F)Temporary Energization & ReIsolation.     Only Same Lock & Tag only to be reused.</td></tr>';

			$table.='<tr rowspan="2"><th rowspan="2" style="border:1px solid #ccc;width:5% !important;">SL.No</th><th style="border:1px solid #ccc;" rowspan="2" colspan="2">Equipment Tag No.</th><th style="border:1px solid #ccc;" rowspan="2" >Logo lock & Tag No.</th><th style="border:1px solid #ccc;" colspan="3" >Energization</th><th style="border:1px solid #ccc;" colspan="3">Re‐Isolation</th> </tr>';
			$table.='<tr><th style="border:1px solid #ccc;">Sign of Performing Authority</th>
			    <th style="border:1px solid #ccc;">Sign of Issuing Authority with date and time</th>
			    <th style="border:1px solid #ccc;">Sign of Isolator with date and time</th>
			    <th style="border:1px solid #ccc;">Sign of Performing Authority</th>
			    <th style="border:1px solid #ccc;">Sign of Issuing Authority with date and time</th>
			    <th style="border:1px solid #ccc;">Sign of Isolator with date and time</th>
			</tr>';

                 if(isset($records))
                 $temporary_lock_nos=json_decode($records['temporary_lock_nos']);
                 else
                 $temporary_lock_nos=array();
        
                 if(isset($records))
                 $temporary_tag_nos=json_decode($records['temporary_tag_nos']);
                 else
                 $temporary_tag_nos=array();
 
                  if(isset($records))
                 $temporary_pas=json_decode($records['temporary_pa']);
                 else
                 $temporary_pas=array();

                 if(isset($records))
                 $temporary_ias=json_decode($records['temporary_ia']);
                 else
                 $temporary_ias=array();

                 if(isset($records))
                 $temporary_isos=json_decode($records['temporary_iso']);
                 else
                 $temporary_isos=array();

                 if(isset($records))
                 $temporary_pa_signdates=json_decode($records['temporary_pa_signdates']);
                 else
                 $temporary_pa_signdates=array();

                 if(isset($records))
                 $temporary_ia_signdates=json_decode($records['temporary_ia_signdates']);
                 else
                 $temporary_ia_signdates=array();

                 if(isset($records))
                 $temporary_iso_signdates=json_decode($records['temporary_iso_signdates']);
                 else
                 $temporary_iso_signdates=array();
				 
                 if(isset($records))
                 $temporary_re_pas=json_decode($records['temporary_re_pa']);
                 else
                 $temporary_re_pas=array();

                 if(isset($records))
                 $temporary_re_ias=json_decode($records['temporary_re_ia']);
                 else
                 $temporary_re_ias=array();

                 if(isset($records))
                 $temporary_re_isos=json_decode($records['temporary_re_iso']);
                 else
                 $temporary_re_isos=array();
				 
                 if(isset($records))
                 $temporary_re_pa_signdates=json_decode($records['temporary_re_pa_signdates']);
                 else
                 $temporary_re_pa_signdates=array();

                 if(isset($records))
                 $temporary_re_ia_signdates=json_decode($records['temporary_re_ia_signdates']);
                 else
                 $temporary_re_ia_signdates=array();

                 if(isset($records))
                 $temporary_re_iso_signdates=json_decode($records['temporary_re_iso_signdates']);
                 else
                 $temporary_re_iso_signdates=array();


        	     
				for($i=1;$i<=3;$i++)
				{
					$temporary_tag_no=(isset($temporary_tag_nos->$i)) ? $temporary_tag_nos->$i : '';
					
					$temporary_pa_signdate=(isset($temporary_pa_signdates->$i) && $temporary_pa_signdates->$i!='') ? $temporary_pa_signdates->$i.$hrs : '';
					
					$temporary_ia_signdate=(isset($temporary_ia_signdates->$i) && $temporary_ia_signdates->$i!='') ? $temporary_ia_signdates->$i.$hrs : '';
					
					$temporary_iso_signdate=(isset($temporary_iso_signdates->$i) && $temporary_iso_signdates->$i!='') ? $temporary_iso_signdates->$i.$hrs : '';
					
					$temporary_pa=(isset($temporary_pas->$i)) ? $temporary_pas->$i : '';
					
					$temporary_ia=(isset($temporary_ias->$i)) ? $temporary_ias->$i : '';
					
					$temporary_iso=(isset($temporary_isos->$i)) ? $temporary_isos->$i : '';
					
					$temporary_re_pa_signdate=(isset($temporary_re_pa_signdates->$i) && $temporary_re_pa_signdates->$i!='') ? $temporary_re_pa_signdates->$i.$hrs : '';
					
					$temporary_re_ia_signdate=(isset($temporary_re_ia_signdates->$i)  && $temporary_re_ia_signdates->$i!='') ? $temporary_re_ia_signdates->$i.$hrs : '';
					
					$temporary_re_iso_signdate=(isset($temporary_re_iso_signdates->$i)  && $temporary_re_iso_signdates->$i!='') ? $temporary_re_iso_signdates->$i.$hrs : '';
					
					$temporary_re_pa=(isset($temporary_re_pas->$i)) ? $temporary_re_pas->$i : '';
					
					$temporary_re_ia=(isset($temporary_re_ias->$i)) ? $temporary_re_ias->$i : '';
					
					$temporary_re_iso=(isset($temporary_re_isos->$i)) ? $temporary_re_isos->$i : '';
					
					$temporary_lock = (isset($temporary_lock_nos->$i)) ? $temporary_lock_nos->$i : '';
					
					$show_tmp_tag_nos = '';
					
					for($tc=1;$tc<=20;$tc++)
					{
						$tmp_tag_nos=strtoupper((isset($equipment_descriptions->$tc)) ? $equipment_descriptions->$tc : '');
						
						$isolated_no1=(isset($isolated_tagno1->$tc)) ? $isolated_tagno1->$tc : '';
						
						$isolated_no2=(isset($isolated_tagno2->$tc)) ? $isolated_tagno2->$tc : '';
						
						$isolated_no3=(isset($isolated_tagno3->$tc)) ? $isolated_tagno3->$tc : '';
					
						$isolated_no4=(isset($isolated_tagno4->$tc)) ? $isolated_tagno4->$tc : '';
						
						$loto=strtoupper($isolated_no1.' - '.$isolated_no2.' <br /><br />'.$isolated_no3.' - '.$isolated_no4);
						
						$isolated_name_id=(isset($isolated_name->$tc)) ? $isolated_name->$tc : '';
					
						if($temporary_tag_no==$tmp_tag_nos) { $show_tmp_tag_nos = $tmp_tag_nos; break; }
					}
					
					$first_name='';
				      if($authorities!='')
				      {
				          foreach($authorities as $fet)
				          {
				              $id=$fet['id'];
				              
							 if($temporary_pa==$id)  { $first_name=$fet['first_name']; break;}
				          }
				      }
					$temporary_ia_name='';
					
					 if($issuing_authorities!='')
					  {
						  foreach($issuing_authorities as $fet)
						  {
							  $id=$fet['id'];
							  
							  if($temporary_ia==$id) { $temporary_ia_name=$fet['first_name']; break; }
						  }
					  }
					
					$temporary_iso_name='';
					
					  if(!empty($temporary_iso))
					  {
							$get_iso=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>'id = '.$temporary_iso,'table'=>USERS))->row_array();;
							$temporary_iso_name= $get_iso['first_name'];
					  }
					  
					  $temporary_re_pa_name='';
					
				      if($authorities!='')
				      {
				          foreach($authorities as $fet)
				          {
				              $id=$fet['id'];
							  if($temporary_re_pa==$id)  { $temporary_re_pa_name=$fet['first_name']; break; }
				          }
				      }
					
					 $temporary_re_ia_name='';
					 if($issuing_authorities!='')
					  {
						  foreach($issuing_authorities as $fet)
						  {
							  $id=$fet['id'];
							  
							  if($temporary_re_ia==$id) { $temporary_re_ia_name=$fet['first_name']; break; }
						  }
					  }
					  
					  $temporary_re_iso_name='';
					  if(!empty($temporary_re_iso))
					  {
							$get_iso=$this->public_model->get_data(array('select'=>'id,first_name','where_condition'=>'id = '.$temporary_re_iso,'table'=>USERS))->row_array();;
							$temporary_re_iso_name= $get_iso['first_name'];
					  }
					
				    $table.='<tr><td style="border:1px solid #ccc;" align="center">'.$i.'</td><td style="border:1px solid #ccc;" colspan="2">'.strtoupper($show_tmp_tag_nos).'</td><td style="border:1px solid #ccc;">'.strtoupper($temporary_lock).'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($first_name).'</b> <br /> '.$temporary_pa_signdate.'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($temporary_ia_name).'</b><br />'.$temporary_ia_signdate.'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($temporary_iso_name).'</b><br />'.$temporary_iso_signdate.'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($temporary_re_pa_name).'</b><br />'.$temporary_re_pa_signdate.'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($temporary_re_ia_name).'</b><br />'.$temporary_re_ia_signdate.'</td><td style="border:1px solid #ccc;"><b>'.strtoupper($temporary_re_iso_name).'</b><br />'.$temporary_re_iso_signdate.'</td></tr>';
				 }

		$final_status_date = (isset($records['final_status_date'])) ? $records['final_status_date'] : '';	
		
		if($final_status_date!='')	
		{		 
				$table.='<tr><td style="border:1px solid #ccc;" colspan="10">(G)Work Completion:</td></tr>';

				$performing_authority_id3=(isset($records['performing_authority_id3'])) ? $records['performing_authority_id3'] : '';

				$pa_name = '';
				      if($authorities!='')
				      {
				          foreach($authorities as $fet)
				          {
				              $id=$fet['id'];
				              
							  if($performing_authority_id3==$id) { $pa_name=$fet['first_name']; break; }
				          }
				      }

				$performing_authority_id3_date = (isset($records['performing_authority_id3_date']) && $records['performing_authority_id3_date']!='') ? $records['performing_authority_id3_date'].$hrs : ''; 

				$table.='<tr><td style="border:1px solid #ccc;vertical-align: top;" colspan="4">
				        <strong>The work has been completed and area cleared.</strong><br><br>
				        Name of the Performing Authority :<br><b>'.strtoupper($pa_name).'</b><br><br>

				        Digitally Signed :<br><br>
				        Date & Time: <b>'.$performing_authority_id3_date.'</b><br>
				    </td>';
					
				 $issuing_authority_id3=(isset($records['issuing_authority_id3'])) ? $records['issuing_authority_id3'] : '';
				 
				 $ia_name = '';
				      if($issuing_authorities!='')
				      {
				          foreach($issuing_authorities as $fet)
				          {
				              $id=$fet['id'];
				              
						  	  if($issuing_authority_id3==$id) { $ia_name=$fet['first_name']; break; }
				          }
				      }
					  
					  $issuing_authority_id3_date=(isset($records['issuing_authority_id3_date']) && $records['issuing_authority_id3_date']!='') ? $records['issuing_authority_id3_date'].$hrs : '';
				 	
				$table.='<td style="border:1px solid #ccc;vertical-align: top;" colspan="3">
				        Area Inspected and all Energy sources canbe restored<br>
				        Name of the Issuing Authority :<br><b>'.strtoupper($ia_name).'</b><br><br>

				        Digitally Signed :<br><br>
				        Date & Time: <b>'.$issuing_authority_id3_date.'</b><br>
				    </td>';

			   if(isset($records))
			   $department_completion_users=json_decode($records['department_completion_users'],true);
			   else
			   $department_completion_users=array();
			   
			   if(isset($records))
			   $department_completion_users_approval_dates=json_decode($records['department_completion_users_approval_dates'],true);
			   else
			   $department_completion_users_approval_dates=array();

				$department_electrical_completion_user=(isset($department_completion_users[EIP_ELECTRICAL])) ? $department_completion_users[EIP_ELECTRICAL] : '';
							
				$department_electrical_completion_users_approval_date=(isset($department_completion_users_approval_dates[EIP_ELECTRICAL]) && $department_completion_users_approval_dates[EIP_ELECTRICAL]!='') ? $department_completion_users_approval_dates[EIP_ELECTRICAL].$hrs : '';
				
				$electrical_name='';
				
			      if($department_isolators)
			      {
			          foreach($department_isolators as $department_isolator)
			          {
			              $id=$department_isolator['id'];
			              
						  if($department_electrical_completion_user==$id) { $electrical_name='<b>'.strtoupper($department_isolator['first_name']).'</b><br />'; break; }
			          }
			      }
				
				$department_inst_completion_user=(isset($department_completion_users[EIP_INSTRUMENTAL])) ? $department_completion_users[EIP_INSTRUMENTAL] : '';
							
				$department_inst_completion_users_approval_date=(isset($department_completion_users_approval_dates[EIP_INSTRUMENTAL]) && $department_completion_users_approval_dates[EIP_INSTRUMENTAL]!='') ? $department_completion_users_approval_dates[EIP_INSTRUMENTAL].$hrs : '';
				
				$inst_name='';
	
		      if($department_isolators)
		      {
		          foreach($department_isolators as $department_isolator)
		          {
		              $id=$department_isolator['id'];
		              
					  if($department_inst_completion_user==$id) { $inst_name='<b>'.strtoupper($department_isolator['first_name']).'</b><br />'; break; }
		          }
		      }


			$department_mech_completion_user=(isset($department_completion_users[EIP_MECHANICAL])) ? $department_completion_users[EIP_MECHANICAL] : '';
						
			$department_mech_completion_users_approval_date=(isset($department_completion_users_approval_dates[EIP_MECHANICAL])  && $department_completion_users_approval_dates[EIP_MECHANICAL]!='') ? $department_completion_users_approval_dates[EIP_MECHANICAL].$hrs : '';
			
			$mech_name='';
			
		      if($department_isolators)
		      {
		          foreach($department_isolators as $department_isolator)
		          {
		              $id=$department_isolator['id'];
		              
					  if($department_mech_completion_user==$id) { $mech_name='<b>'.strtoupper($department_isolator['first_name']).'</b><br />'; break; }
		          }
		      }


			$department_uti_completion_user=(isset($department_completion_users[EIP_UTILITIES])) ? $department_completion_users[EIP_UTILITIES] : '';
						 
			$department_uti_completion_users_approval_date=(isset($department_completion_users_approval_dates[EIP_UTILITIES])   && $department_completion_users_approval_dates[EIP_UTILITIES]!='') ? $department_completion_users_approval_dates[EIP_UTILITIES].$hrs : '';
	
			$uti_name='';
			
		      if($department_isolators)
		      {
		          foreach($department_isolators as $department_isolator)
		          {
		              $id=$department_isolator['id'];
		              
					  if($department_uti_completion_user==$id) { $uti_name='<b>'.strtoupper($department_isolator['first_name']).'</b><br />'; break; }
		          }
		      }


			$department_process_completion_user=(isset($department_completion_users[EIP_PROCESS])) ? $department_completion_users[EIP_PROCESS] : '';
						
			$department_process_completion_users_approval_date=(isset($department_completion_users_approval_dates[EIP_PROCESS]) && $department_completion_users_approval_dates[EIP_PROCESS]!='') ? $department_completion_users_approval_dates[EIP_PROCESS].$hrs : '';
			
			$process_name='';
			
		      if($department_isolators)
		      {
		          foreach($department_isolators as $department_isolator)
		          {
		              $id=$department_isolator['id'];
		              
					  if($department_process_completion_user==$id) { $process_name='<b>'.strtoupper($department_isolator['first_name']).'</b><br />'; break; }
		          }
		      }
			

			$table.='<td style="border:1px solid #ccc;" colspan="3">
			        <table style="width:100%;border:0px !important; border-collapse:collapse;" border="0">
			            <tr><td style="border:1px solid #ccc;" colspan="2">Connected Energy Sources restored</td></tr>
			            <tr><th>Department</th><th>Digitally Signed</th></tr>
			            <tr><td style="border:1px solid #ccc;">1. Electrical</td><td style="border:1px solid #ccc;">'.$electrical_name.$department_electrical_completion_users_approval_date.'</td></tr>
			            <tr><td style="border:1px solid #ccc;">2. Instrumentation</td><td style="border:1px solid #ccc;">'.$inst_name.$department_inst_completion_users_approval_date.'</td></tr>

			            <tr><td style="border:1px solid #ccc;">3. Mechanical</td><td style="border:1px solid #ccc;">'.$mech_name.$department_mech_completion_users_approval_date.'</td></tr>
			            <tr><td style="border:1px solid #ccc;">4. Utilities</td><td style="border:1px solid #ccc;">'.$uti_name.$department_uti_completion_users_approval_date.'</td></tr>
			            <tr><td style="border:1px solid #ccc;">5. Process</td><td style="border:1px solid #ccc;">'.$process_name.$department_process_completion_users_approval_date.'</td></tr>
			        </table>
			    </td>
			</tr>';
	}
$table.='<tr><td style="border:1px solid #ccc;" colspan="10">'.EMERGENCY_CONTACT_NUMBER.'</td></tr>';
$table.='</table>';


#echo $table; exit;
#include("mpdf60/mpdf.php");

include_once APPPATH.'/third_party/mpdf60/mpdf.php';

$header="";

$footer="";

$mpdf=new mPDF('c','A4','','',10,10,10,10,10,10);
//                             L,R,T,
$mpdf->SetDisplayMode('fullpage');


$mpdf->SetHTMLHeader($header);
$mpdf->SetFooter($footer.'{PAGENO}');
//$mpdf->setFooter('{PAGENO}');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a li
// LOAD a stylesheet
#$stylesheet = file_get_contents(include_once APPPATH.'/third_party/mpdf60/style.css');
#$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
$mpdf->WriteHTML($table,2);

$path = UPLODPATH.'uploads/eip/'.$records['id'];

if (!file_exists($path)) 
mkdir($path);

$file_name='/EIP'.time().'.pdf';

$file=$path.$file_name;

$mpdf->Output($file,'F');

echo json_encode(array('file_path'=>base_url().'uploads/eip/'.$records['id'].$file_name));
?>

