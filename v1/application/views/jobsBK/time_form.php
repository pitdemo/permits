<?php 
$page_name='Create Job';
 if(!empty($records)){
     $page_name='Edit Job';
 }
$this->load->view('layouts/header',array('page_name'=>$page_name)); ?>

<style>

table.form_work tr td { padding:0px 5px 0 5px; }
.radio_button { padding:0 2px 0px 2px; }
label.error { display:none; }
.float_right { float:right; padding-right:5px; }
label.error { display:none !important; }

input[type=checkbox].box_big {
    transform: scale(3);
    -ms-transform: scale(2);
    -webkit-transform: scale(2);
    padding: 10px;
}
.authority { width:170px; }
</style>
<!-- start: Content -->
<div class="main create-con min-height">
			<div class="row">		
				<div class="col-lg-12">                
                <h1><?php echo isset($records['id'])?'Edit':'Create';?> Job (<a style="text-decoration:underline;" href="<?php echo base_url(); ?>jobs/form/id/<?php echo $records['id']; ?>" target="_blank">#<?php echo $records['id']; ?></a>)</h1>
                
                
                
                        
                      
                <form id="job_form" name="job_form" enctype="multipart/form-data" >	
                	<input type="hidden" id="id" name="id" value="<?php echo (isset($records['id'])) ? $records['id'] : ''; ?>" />
 					<div class="panel panel-default">
						<div class="acc-header">
                  
                  
						<table align="center" width="100%" border="1" class="form_work"  >
                          <tr height=36 style='height:27.0pt'>
                            <td height=36 class=xl102 colspan="2" valign="top" style='height:27.0pt;
  width:936pt'><b>Select Department </b>
                              <?php 	
									$zone_name='';
									$select_department=(isset($records['department_id'])) ? $records['department_id'] : '';			  
									if($departments->num_rows()>0)
				  				    {
										 $departments=$departments->result_array();

                                        foreach($departments as $list)
										{
											
											if($select_department==$list['id'])
											echo '<br />'.$list['name'];
											
                                 		}
								 
								 } ?>
                              <br /></td>
                            <td class=xl70 colspan="2" valign="top" style='width:48pt'><b>Zone</b>
                             <?php 	
									$zone_name='';
									$select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';			  
									if($zones->num_rows()>0)
				  				    {
										 $zones=$zones->result_array();

                                        foreach($zones as $list)
										{
											 if($select_zone_id==$list['id'])
											  echo '<br />'.$list['name'];
                                		}
								 
								 } ?></td>
                              <td class=xl70 colspan="4" valign="top" style='width:48pt'><b>Permit No</b>
                              <br />#<?php echo (isset($records['id'])) ? $records['id'] : $permit_no; ?>
                              </td>
                          </tr>
                          <?php
  if(isset($records))
  $work_types=explode(',',rtrim($records['work_types'],','));
  else
  $work_types=array();
 ?>
                          <tr height=31 style='mso-height-source:userset;height:23.25pt'>
                            <td height=94 class=xl97 width=831 style='height:23.25pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl162 style='width:189pt'><center>
                              <b>HEIGHT WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 width=77  align="center" valign="middle"><input type="checkbox" name="works[]" value="height_work"  <?php if(in_array('height_work',$work_types)) { ?> checked="checked" <?php } ?>   class="box_big" /></td>
                            <td colspan=3 class=xl162 style='width:184pt'><center>
                              <b>HOT WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 width=108 align="center" valign="middle"><input type="checkbox" name="works[]" value="hot_work" class="box_big" <?php if(in_array('hot_work',$work_types)) { ?> checked="checked" <?php } ?> /></td>
                            <td colspan=3 class=xl104 style='width:173pt'><center>
                              <b>GENERAL WORK</b>
                            </center></td>
                            <td rowspan=2 height=94 colspan="4" align="center" valign="middle"><input type="checkbox" name="works[]" value="general_work" class="box_big" <?php if(in_array('general_work',$work_types)) { ?> checked="checked" <?php } ?>/></td>
                          </tr>
                          <tr height=63 style='mso-height-source:userset;height:47.25pt'>
                            <td height=94 class=xl71 width=831 style='height:47.25pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl188 style='width:189pt'>Work at a Height of
                              1.5 Mts. &amp; above</td>
                            <td colspan=3 class=xl188 style='width:184pt'>Work related to
                              Welding / Cutting /Grinding /Open flame</td>
                            <td colspan=3 class=xl190 >Works other than
                              Height, Hot, Confined Space,Electrical &amp; Excavation</td>
                          </tr>
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td rowspan=4 height=117 class=xl123 width=831 align="center" style='height:87.75pt;width:111pt;' valign="top"><center>
                              <b>Location</b>
                            </center>
                              <br />
                              <br />
                              <?php echo (isset($records['location'])) ? $records['location'] : '- - -'; ?></td>
                            <td  class=xl106 style='border-left:none;width:130pt;' valign="middle"><center>
                              <b>Date</b>
                            </center></td>
                            <td colspan=2 class=xl106 style='border-left:none;width:130pt;padding:2px;' valign="top"><?php echo (isset($records['location_date'])) ? $records['location_date'] : date('d-m-Y'); ?></td>
                            <td colspan=4 class=xl108 style='border-right:.5pt solid black;
  width:245pt'><span style='mso-spacerun:yes'> </span><b>Hazards / concerns
                              Identified:</b></td>
                            <td class=xl86 width=108 style='border-top:none;border-left:none;width:55pt'><center>
                              <b>YES/NO</b>
                            </center></td>
                            <td colspan=6 class=xl108 style='border-left:none;width:247pt'><b>Precautions to be Taken:</b></td>
                            <td class=xl89 style='width:89pt'><center>
                              <b>YES/NO</b>
                            </center></td>
                          </tr>
                          <?php
 if(isset($records))
 $hazards=json_decode($records['hazards']);
 else
 $hazards=array();
 
 if(isset($records))
 $precautions=json_decode($records['precautions']);
 else
 $precautions=array();
 
 #echo '<pre>'; print_r($records);
 ?>
                          <tr height=26 style='mso-height-source:userset;height:19.5pt'>
                            <td rowspan="3" class=xl106 width=426 style='width:59pt' valign="middle"><center>
                              <b>Time</b>
                            </center></td>
                            <td rowspan=3 height=117 class=xl111 width=83 style='border-bottom:.5pt solid black;
  height:70.5pt;border-top:none;width:65pt' valign="middle"><center>
                              <b>FROM</b><br />
                              <br />
                              <?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : '- - -'; ?>
                            </center></td>
                            <td rowspan=3 class=xl113 valign="middle" width=100 style='border-bottom:.5pt solid black;
  border-top:none;width:65pt' valign="top"><center>
                              <b>TO</b><br />
                              <br />
                              <?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : '- - -'; ?>
                            </center></td>
                            <td colspan=4 class=xl198 style='border-right:.5pt solid black;
  width:245pt'>a) No permanent Platform/Handrails/stairs</td>
                            <td class=xl87 width=108 style='border-top:none;border-left:none;width:55pt'><input name="hazards[a]" data-attr="a" type="radio" <?php if(isset($hazards->a) && $hazards->a=='Yes') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="Yes" />
                              Y&nbsp;
                              <input type="radio" name="hazards[a]" class="radio_button hazards" value="No" data-attr="a" <?php if(isset($hazards->a) && $hazards->a=='No') { ?> checked="checked" <?php } ?> />
                              N&nbsp;</td>
                            <td colspan=6 class=xl198 style='border-right:.5pt solid black;
  border-left:none;width:247pt'>a) Standard &amp; certified Scaffold provided</td>
                            <td class=xl74 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="a" name="precautions[a]"  <?php if(isset($precautions->a) && $precautions->a=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="a" type="radio" <?php if(isset($precautions->a) && $precautions->a=='No') { ?> checked="checked" <?php } ?> name="precautions[a]" class="radio_button precautions" value="No" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=23 style='mso-height-source:userset;height:17.25pt'>
                            <td colspan=4 height=117 class=xl115 style='height:17.25pt;
  width:245pt'>b) Un Safe Access to work area.</td>
                            <td class=xl87 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="b" name="hazards[b]" value="Yes" <?php if(isset($hazards->b) && $hazards->b=='Yes') { ?> checked="checked" <?php } ?> type="radio" class="radio_button hazards" />
                              Y&nbsp;
                              <input data-attr="b" type="radio" <?php if(isset($hazards->b) && $hazards->b=='No') { ?> checked="checked" <?php } ?> name="hazards[b]" class="radio_button hazards"  value="No"/>
                              N&nbsp;</td>
                            <td colspan=6 class=xl115 style='border-left:none;width:247pt'>b)
                              Suitable access provided.</td>
                            <td class=xl74 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="b" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="b" type="radio" name="precautions[b]" <?php if(isset($precautions->b) && $precautions->b=='No') { ?> checked="checked" <?php } ?> value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=45 style='mso-height-source:userset;height:33.75pt'>
                            <td colspan=4 height=117 class=xl115 style='height:33.75pt;
  width:245pt'>c) Falling of material.</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="c"  name="hazards[c]" <?php if(isset($hazards->c) && $hazards->c=='Yes') { ?> checked="checked" <?php } ?> value="Yes" type="radio" class="radio_button hazards" />
                              Y&nbsp;
                              <input data-attr="c" type="radio" <?php if(isset($hazards->c) && $hazards->c=='No') { ?> checked="checked" <?php } ?> value="No" name="hazards[c]" class="radio_button hazards" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>c)
                              Loose materials removed &amp; barricade tape/ signs provided</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="c" type="radio" <?php if(isset($precautions->c) && $precautions->c=='Yes') { ?> checked="checked" <?php } ?> name="precautions[c]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="c" <?php if(isset($precautions->c) && $precautions->c=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[c]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=50 style='mso-height-source:userset;height:37.5pt'>
                            <td colspan=4 height=50 class=xl117 style='height:47.5pt;
  width:300pt'><b>Equipment name:</b>&nbsp;
                              <?php echo (isset($records['equipment_name'])) ? $records['equipment_name'] : '- - -'; ?></td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>d) Over Head Electrical Lines /Electric shock to personnel</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input type="radio"  name="hazards[d]" class="radio_button hazards" data-attr="d" value="Yes" <?php if(isset($hazards->d) && $hazards->d=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input type="radio" <?php if(isset($hazards->d) && $hazards->d=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards"  name="hazards[d]" data-attr="d" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:247pt'>d) isolation of power supply</td>
                            <td class=xl75 style='border-top:none;border-left:none;width:89pt;'><center>
                              <input data-attr="d" type="radio" <?php if(isset($precautions->d) && $precautions->d=='Yes') { ?> checked="checked" <?php } ?> name="precautions[d]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="d" <?php if(isset($precautions->d) && $precautions->d=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[d]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=70 style='mso-height-source:userset;height:52.5pt'>
                            <td colspan=4 height=70 class=xl120 style='height:52.5pt;
  width:300pt'><b>Nature of Job:</b>&nbsp;
                              <?php echo (isset($records['job_name'])) ? $records['job_name'] : '- - -'; ?></td>
                            <td colspan=4 class=xl115 style='width:245pt'>e) Failure of
                              scaffolding / Ladders/Crane / other lifting equipment</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="e" type="radio" class="radio_button hazards" value="Yes" <?php if(isset($hazards->e) && $hazards->e=='Yes') { ?> checked="checked" <?php } ?>  name="hazards[e]" />
                              Y&nbsp;
                              <input data-attr="e" type="radio"  name="hazards[e]" <?php if(isset($hazards->e) && $hazards->e=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>e)
                              Certification of Scaffolds/cranes / lifting eqpt. &amp; tackles ensured &amp;
                              visual inspection done</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="e" type="radio" <?php if(isset($precautions->e) && $precautions->e=='Yes') { ?> checked="checked" <?php } ?> name="precautions[e]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="e" <?php if(isset($precautions->e) && $precautions->e=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[e]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=73 style='mso-height-source:userset;height:54.75pt'>
                            <td colspan=2  height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><b>Name of the Contractor/:</b>&nbsp;
                                <?php 	
									$zone_name='';
									$select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';			  
									if($contractors->num_rows()>0)
				  				    {
										 $contractors=$contractors->result_array();

                                        foreach($contractors as $list){
											
											  if($select_contractor_id==$list['id']) echo '<br /><br />'.$list['name'];?>
                                <?php }} ?>
                              </td>
                            <td colspan=2 valign="top"  class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130pt'><b>No of Persons involved</b>&nbsp;
                              <br /><br /><?php echo (isset($records['contractors_involved'])) ? $records['contractors_involved'] : '- - -'; ?></td>
                            <td colspan=4 class=xl115 style='width:245pt'>f) Fall of person
                              from -height</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="f" type="radio" class="radio_button hazards"  name="hazards[f]" value="Yes" <?php if(isset($hazards->f) && $hazards->f=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="f"  name="hazards[f]" type="radio" <?php if(isset($hazards->f) && $hazards->f=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>f)
                              Use of Full Body Harness/Anchor points /<span style='mso-spacerun:yes'>  </span>fall arrestors /Safety Nets /life lines/ Vertigo Test Certificate
                              ensured as required.</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="f" type="radio" <?php if(isset($precautions->f) && $precautions->f=='Yes') { ?> checked="checked" <?php } ?> name="precautions[f]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="f" <?php if(isset($precautions->f) && $precautions->f=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[f]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <?php
  $yes_active='';
  $no_active=$na_active='';
  if(isset($records))
  {
	  $is_isoloation_permit=(isset($records['is_isoloation_permit'])) ? $records['is_isoloation_permit'] : '';
	  
	  if($is_isoloation_permit=='No') 
	  $no_active='checked';
	  else if($is_isoloation_permit=='N/A')
	  $na_active='checked';
	  else
	  $yes_active='checked';
  }
  else
  $yes_active='checked';
 ?>
                          <tr height=61 style='mso-height-source:userset;height:45.75pt'>
                            <td colspan=4 height=61 class=xl136 style='border-right:1.0pt solid black;
  height:45.75pt;width:300pt'><b>Is Energy Isolation permit obtained:</b>
                              <input type="radio" name="is_isoloation_permit" class="radio_button on_off" data-relate='isoloation' <?php echo $yes_active; ?> value="Yes"/>
                              Yes&nbsp;
                              <input name="is_isoloation_permit" <?php echo $no_active; ?> type="radio" value="No" class="radio_button on_off" data-relate='isoloation'/>
                              No&nbsp;
                              <input name="is_isoloation_permit" value="N/A" <?php echo $na_active; ?> type="radio" class="radio_button on_off" data-relate='isoloation' />
                              N/A</td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>g)Liquid or gas under pressure</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="g" type="radio" class="radio_button hazards"  name="hazards[g]" value="Yes" <?php if(isset($hazards->g) && $hazards->g=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="g"  name="hazards[g]" type="radio" <?php if(isset($hazards->g) && $hazards->g=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'><span
  style='mso-spacerun:yes'> </span>g)After energy isolation, equipment/pipe
                              line fully drained &amp; depressurised/ cleaning of area done.</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="g" type="radio" <?php if(isset($precautions->g) && $precautions->g=='Yes') { ?> checked="checked" <?php } ?> name="precautions[g]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="g" <?php if(isset($precautions->g) && $precautions->g=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[g]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=40 style='mso-height-source:userset;height:50.0pt'>
                            <td colspan=4 height=40 class=xl128 style='border-right:1.0pt solid black;
  height:30.0pt;width:300pt'><b>If yes Energy Isolation Permit NO:</b> &nbsp;<br /><br />
                              <?php echo (isset($records['isoloation_permit_no'])) ? $records['isoloation_permit_no'] : '- - -'; ?></td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>h) Danger due to naked flames /Ignition of
                              Flammables</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="h" type="radio" class="radio_button hazards"  name="hazards[h]" value="Yes" <?php if(isset($hazards->h) && $hazards->h=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="h"  name="hazards[h]" type="radio" <?php if(isset($hazards->h) && $hazards->h=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>h)
                              Space free o<font class="font12">f Flammables<span
  style='mso-spacerun:yes'> </span></font></td>
                            <td class=xl75 style='border-top:none;border-left:none;width:89pt'><center>
                              <input data-attr="h" type="radio" <?php if(isset($precautions->h) && $precautions->h=='Yes') { ?> checked="checked" <?php } ?> name="precautions[h]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="h" <?php if(isset($precautions->h) && $precautions->h=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[h]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=42 style='mso-height-source:userset;height:31.5pt'>
                            <td colspan=2 rowspan=2 height=84 class=xl139 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><b>Is scaffolding TAG certification obtained</b>
                              <?php
  $yes_active='';
  $no_active=$na_active='';
  if(isset($records))
  {
	  $is_scaffolding_certification=(isset($records['is_scaffolding_certification'])) ? $records['is_scaffolding_certification'] : '';
	  
	  if($is_scaffolding_certification=='No') 
	  $no_active='checked';
	  else if($is_scaffolding_certification=='N/A')
	  $na_active='checked';
	  else
	  $yes_active='checked';
  }
  else
  $yes_active='checked';
  
  ?>
                              <br />
                              <input type="radio" class="radio_button on_off" data-relate='scaffolding' name="is_scaffolding_certification"  <?php echo $yes_active; ?> value="Yes"/>
                              Yes&nbsp;
                              <input type="radio" <?php echo $no_active; ?> class="radio_button on_off" data-relate='scaffolding' name="is_scaffolding_certification" value="No"/>
                              No&nbsp;
                              <input type="radio" class="radio_button on_off" data-relate='scaffolding' <?php echo $na_active; ?> value="N/A" name="is_scaffolding_certification"/>
                              N/A </td>
                            <td colspan=2 valign="top" rowspan=2 class=xl139 style='border-right:1.0pt solid black; border-bottom:1.0pt solid black;width:130pt'><b>If Yes Scaffold</b><br />
                              Tag No:-<br /><br />
                              <?php if($yes_active!='') { echo (isset($records['scaffolding_certification_no'])) ? $records['scaffolding_certification_no'] : '- - -';  } else { '- - -'; } ?>
                              <br />
                              Issued by :<br /><br />
                              <?php if($yes_active!='') { echo (isset($records['scaffolding_certification_issed_by'])) ? $records['scaffolding_certification_issed_by'] : '- - -';  } else {  '- - -'; } ?> 
                              <br /></td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  border-left:none;width:245pt'>i) Defective Welding/Gas cutting sets<span
  style='mso-spacerun:yes'> </span></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="i" type="radio" class="radio_button hazards"  name="hazards[i]" value="Yes" <?php if(isset($hazards->i) && $hazards->i=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input  name="hazards[i]" data-attr="i" type="radio" <?php if(isset($hazards->i) && $hazards->i=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>i) <font
  class="font14">Welding, gas cutting sets checked </font><font class="font12">and
                              Rectified</font></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input type="radio" data-attr="i" <?php if(isset($precautions->i) && $precautions->i=='Yes') { ?> checked="checked" <?php } ?> name="precautions[i]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="i" <?php if(isset($precautions->i) && $precautions->i=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[i]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=42 style='mso-height-source:userset;height:31.5pt'>
                            <td colspan=4 height=84 class=xl119 style='border-right:.5pt solid black;
  height:31.5pt;border-left:none;width:245pt'>j)<span
  style='mso-spacerun:yes'>  </span>Fire during work activity</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="j" type="radio" class="radio_button hazards"  name="hazards[j]" value="Yes" <?php if(isset($hazards->j) && $hazards->j=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="j"  name="hazards[j]" type="radio" <?php if(isset($hazards->j) && $hazards->j=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>j)Adequate
                              protection / Fire extinguisher and Fire blanket available.</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="j" type="radio" <?php if(isset($precautions->j) && $precautions->j=='Yes') { ?> checked="checked" <?php } ?> name="precautions[j]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="j" <?php if(isset($precautions->j) && $precautions->j=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[j]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=44 style='mso-height-source:userset;height:33.0pt'>
                            <td colspan=4 rowspan=2 height=77 class=xl151 style='height:57.75pt;
  width:300pt'>SOP / Work instructions clearly explained to the all the members
                              in the working Group</td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>k) Moving Machinery/<font class="font12">Electric shock/</font><font
  class="font20">Other Energy</font></td>
                            <td class=xl70><input data-attr="k" type="radio" class="radio_button hazards" value="Yes" <?php if(isset($hazards->k) && $hazards->k=='Yes') { ?> checked="checked" <?php } ?>  name="hazards[k]" />
                              Y&nbsp;
                              <input type="radio" data-attr="k"  name="hazards[k]" <?php if(isset($hazards->k) && $hazards->k=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='width:247pt'>k) Hazardous Energy
                              Isolation ensured</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="k" type="radio" <?php if(isset($precautions->k) && $precautions->k=='Yes') { ?> checked="checked" <?php } ?> name="precautions[k]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="k" <?php if(isset($precautions->k) && $precautions->k=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[k]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=33 style='mso-height-source:userset;height:24.75pt'>
                            <td colspan=4 height=77 class=xl194 style='border-right:.5pt solid black;
  height:24.75pt;width:245pt'>l) Poor ventilation</td>
                            <td class=xl95 width=108 style='border-left:none;width:55pt'><input data-attr="l" type="radio"  name="hazards[l]" class="radio_button hazards" value="Yes" <?php if(isset($hazards->l) && $hazards->l=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="l"  name="hazards[l]" type="radio" <?php if(isset($hazards->l) && $hazards->l=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl195 style='width:247pt'>l) Proper ventilation
                              facilities provided</td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="l" type="radio" <?php if(isset($precautions->l) && $precautions->l=='Yes') { ?> checked="checked" <?php } ?> name="precautions[l]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="l" <?php if(isset($precautions->l) && $precautions->l=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[l]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                            <td height=34 class=xl71 width=831 style='height:25.5pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl70 style='mso-ignore:colspan'></td>
                            <td colspan=4 class=xl119 style='border-right:.5pt solid black;
  width:245pt'>m) Poor Illumination<span style='mso-spacerun:yes'> </span></td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="m"  name="hazards[m]" type="radio" class="radio_button hazards" value="Yes" <?php if(isset($hazards->m) && $hazards->m=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="m" name="hazards[m]" type="radio" <?php if(isset($hazards->m) && $hazards->m=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl119 style='border-left:none;width:247pt'>m)Adequate<span
  style='mso-spacerun:yes'>  </span>Illumination<span
  style='mso-spacerun:yes'> </span></td>
                            <td class=xl75 style='border-top:none;width:89pt'><center>
                              <input data-attr="m" type="radio" <?php if(isset($precautions->m) && $precautions->m=='Yes') { ?> checked="checked" <?php } ?> name="precautions[m]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="m" <?php if(isset($precautions->m) && $precautions->m=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[m]" value="No" class="radio_button precautions" />
                              N&nbsp;
                            </center></td>
                          </tr>
                          <tr height=52 style='mso-height-source:userset;height:39.0pt'>
                            <td height=52 class=xl71 width=831 style='height:39.0pt;width:111pt'>&nbsp;</td>
                            <td colspan=3 class=xl70 style='mso-ignore:colspan'></td>
                            <td colspan=4 class=xl115 style='width:245pt'>n) Emergency
                              preparedness of employees</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'><input data-attr="n" type="radio"  name="hazards[n]" class="radio_button hazards" value="Yes" <?php if(isset($hazards->n) && $hazards->n=='Yes') { ?> checked="checked" <?php } ?> />
                              Y&nbsp;
                              <input data-attr="n" type="radio"  name="hazards[n]" <?php if(isset($hazards->n) && $hazards->n=='No') { ?> checked="checked" <?php } ?> class="radio_button hazards" value="No" />
                              N&nbsp;</td>
                            <td colspan=6 class=xl115 style='border-left:none;width:247pt'>n)Adequate Awareness of emergency procedures/ Ensure
                              for clear emergency exits.</td>
                            <td class=xl95 width=108 style='border-top:none;border-left:none;width:55pt'>&nbsp;
                              <input data-attr="n" type="radio" <?php if(isset($precautions->n) && $precautions->n=='Yes') { ?> checked="checked" <?php } ?> name="precautions[n]" value="Yes" class="radio_button precautions"/>
                              Y&nbsp;
                              <input data-attr="n" <?php if(isset($precautions->n) && $precautions->n=='No') { ?> checked="checked" <?php } ?> type="radio" name="precautions[n]" value="No" class="radio_button precautions" />
                              N&nbsp;</td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=4 height=21 class=xl131 style='height:15.75pt;
  width:300pt'>&nbsp;</td>
                            <td colspan=4 class=xl166 style='border-right:.5pt solid black;
  width:245pt'>o)Others</td>
                            <td class=xl96 width=108 style='border-top:none;border-left:none;width:55pt'><?php echo (isset($records['hazards_other'])) ? $records['hazards_other'] : '- - -'; ?></td>
                            <td colspan=6 class=xl166 style='border-left:none;width:247pt'>o)Others</td>
                            <td class=xl90 style='border-top:none;width:89pt'><center>
                               <?php echo (isset($records['precautions_other'])) ? $records['precautions_other'] : '- - -'; ?>
                            </center></td>
                          </tr>
                          <tr height=22 style='mso-height-source:userset;height:16.5pt'>
                            <td colspan=3 height=22 class=xl125 style='border-right:1.0pt solid black;
  height:16.5pt;width:235pt'><center>
                              <b>Required PPE</b>
                            </center></td>
                            <td colspan=5 rowspan=7 style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><p><b>Authorisation & Acceptance: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>I have had the contents of this permit explained to me and I shall work in accordance with the control measures identified </p>
                              <p>&nbsp;</p>
                              <p><span style="float:left;"><b>Name:</b> <br />
                                  <?php
  $select=(isset($records['acceptance_performing_id'])) ? $records['acceptance_performing_id'] : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) echo '<br />'.$first_name;
		  }
	  }
  }
   ?>
                               
                                </span> <span style="float:right;"><b>Sign/Date:</b> <br /><br />
                                  <?php echo (isset($records['acceptance_performing_date'])) ? $records['acceptance_performing_date'] : '- - -'; ?>
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have ensured that each of the identified control measures is suitable and sufficient. The content of this permit has been explained to the
                                holder and work may proceed.</p>
                              <p>&nbsp;</p>
                              <p><span style="float:left;"><b>Name:</b> <br />
                                  <?php
  $select=(isset($records['acceptance_issuing_id'])) ? $records['acceptance_issuing_id'] : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) echo '<br />'.$first_name;
		  }
	  }
  }
   ?>
                                </span> <span style="float:right;"><b>Sign/Date:</b><br /><br />
                                  <?php echo (isset($records['acceptance_issuing_date'])) ? $records['acceptance_issuing_date'] : '- - -'; ?>
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br /></td>
                            <td colspan=8 rowspan=7 valign="top" style='border-right:1.0pt solid black;border-bottom:1.0pt solid black;'><p><b>Work Completion / Cancellation: </b></p>
                              <p><b>Performing Authority: </b></p>
                              <p>Work completed, all persons are withdrawn and material removed from the area.</p>
                              <p>&nbsp;</p>
                              <p><span style="float:left;"><b>Name:</b><br /><br />
                                  <?php
  $select=(isset($records['cancellation_performing_id'])) ? $records['cancellation_performing_id'] : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) echo $first_name;
		  }
	  }
  }
   ?>
                                </span> <span style="float:right;"><b>Sign/Date:</b> <br /><br />
                                 <?php echo (isset($records['cancellation_performing_date'])) ? $records['cancellation_performing_date'] : '- - -'; ?>
                                </span></p>
                              <br />
                              <br />
                              <br />
                              <br />
                              <p><b>Issuing Authority: </b></p>
                              <p>I have inspected the work area and declare the work for which the permit was issued has been properly.</p>
                              <p>&nbsp;</p>
                              <br />
                              <p><span style="float:left;"><b>Name:</b> <br /><br />
                                  <?php
  $select=(isset($records['cancellation_issuing_id'])) ? $records['cancellation_issuing_id'] : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) echo $first_name;
		  }
	  }
  }
   ?>
                                </span> <span style="float:right;"><b>Sign/Date:</b> <br /><br />
                                  <?php echo (isset($records['cancellation_issuing_date'])) ? $records['cancellation_issuing_date'] : '- - -'; ?>
                                </span></p>
                              <br />
                              <br /></td>
                          </tr>
                          <tr height=35 style='mso-height-source:userset;height:26.25pt'>
                            <td height=35 width=831 style='height:26.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <?php
  if(isset($records))
  $required_ppe=explode(',',rtrim($records['required_ppe'],','));
  else
  $required_ppe=array();
  
 
  #print_r($required_ppe);
  ?>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=35 class=xl76 width=148 style='height:26.25pt;border-top:none;
    width:111pt'><span style='mso-spacerun:yes'> </span>Safety shoes<span
    style='mso-spacerun:yes'>&nbsp;<span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" class="required_ppe" <?php if(in_array('Safety Shoes',$required_ppe)) { ?> checked="checked" <?php } ?> value="Safety Shoes" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=35 style='  height:26.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=35 class=xl148 width=165 style='
    height:26.25pt;border-left:none;width:124pt'>Eye protection <span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Eye Protection',$required_ppe)) { ?> checked="checked" <?php } ?>  class="required_ppe" value="Eye Protection" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=38 style='mso-height-source:userset;height:28.5pt'>
                            <td height=38 width=831 style='height:28.5pt;width:111pt' align=left
  valign=top><table cellpadding=0 cellspacing=0>
                              <tr>
                                <td height=38 class=xl76 width=148 style='height:28.5pt;border-top:none;
    width:111pt'>Safety Helmet<span
    style='mso-spacerun:yes'><span class="float_right">
                                  <input type="checkbox" name="required_ppe[]" <?php if(in_array('Safety Helmet',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Safety Helmet" />
                                </span></span></td>
                              </tr>
                            </table></td>
                            <td colspan=2 height=38 style='border-right:1.0pt solid black;
  height:28.5pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=38 class=xl148 width=165 style='height:28.5pt;border-left:none;width:124pt'>Ear protection <span class="float_right">
                                    <input <?php if(in_array('Ear Protection',$required_ppe)) { ?> checked="checked" <?php } ?> type="checkbox" name="required_ppe[]"  class="required_ppe" value="Ear Protection" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=41 style='mso-height-source:userset;height:30.75pt'>
                            <td height=41 width=831 style='height:30.75pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=41 class=xl76 width=148 style='height:30.75pt;border-top:none;
    width:111pt'>Full body Harness<span style='mso-spacerun:yes'><span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Full body Harness',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Full body Harness" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=41 style='border-right:1.0pt solid black;
  height:30.75pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=41 class=xl121 width=165 style='
    height:30.75pt;border-left:none;width:124pt'>Welding shield <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Welding sheid',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Welding sheid" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=36 style='mso-height-source:userset;height:27.0pt'>
                            <td height=36 width=831 style='height:27.0pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=36 class=xl76 width=148 style='height:27.0pt;border-top:none;
    width:111pt'>Safety Net<span style='mso-spacerun:yes'><span class="float_right">
                                    <input value="Safety net" name="required_ppe[]" <?php if(in_array('Safety net',$required_ppe,true)) { ?> checked="checked" <?php } ?>    class="required_ppe" type="checkbox" />
                                  </span></span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=36 style='border-right:1.0pt solid black;
  height:27.0pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=36 class=xl121 width=165 style='
    height:27.0pt;border-left:none;width:124pt'>Coverall Suit <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Coverall Suit',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Coverall Suit" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 width=831 style='height:35.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:111pt'>Nose Mask <span class="float_right">
                                    <input type="checkbox" name="required_ppe[]" <?php if(in_array('Nose Mask',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Nose Mask" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=47 style='border-right:1.0pt solid black;
  height:35.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=47 class=xl150 width=165 style='
    height:35.25pt;border-left:none;width:124pt'>Hand Glouse <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Hand Glouse',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Hand Glouse" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=47 style='mso-height-source:userset;height:35.25pt'>
                            <td height=47 width=831 style='height:35.25pt;width:111pt' align=left
  valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td height=47 class=xl77 width=148 style='height:35.25pt;border-top:none;
    width:111pt'>Others <span class="float_right">
                                    <input name="required_ppe[]" <?php if(in_array('Others',$required_ppe)) { ?> checked="checked" <?php } ?>    class="required_ppe" value="Others" type="checkbox" />
                                  </span></td>
                                </tr>
                              </table>
                            </span></td>
                            <td colspan=2 height=47 style='border-right:1.0pt solid black;
  height:35.25pt;width:124pt' align=left valign=top><span
  style='mso-ignore:vglayout2'>
                              <table cellpadding=0 cellspacing=0>
                                <tr>
                                  <td colspan=2 height=47 class=xl150 width=165 style='
    height:35.25pt;border-left:none;width:124pt'></td>
                                </tr>
                              </table>
                            </span></td>
                          </tr>
                          <tr height=21 style='height:15.75pt'>
                            <td height=21 class=xl83 width=831 style='height:15.75pt;width:111pt'><b>Revalidation:</b><span
  style='mso-spacerun:yes'>                   </span></td>
                            <td colspan=15 class=xl155 style='border-right:1.0pt solid black;
  border-left:none;width:825pt'><span style='mso-spacerun:yes'>  </span><b>I have
                              visited the work area and understand and well comply with the requirements of
                              this permit</b></td>
                          </tr>
                          
<tr height=41 style='height:15.75pt'>
  <td height=41 class=xl83 width=148 style='height:55.75pt;width:111pt'><b>Job Status: </b><span
  style='mso-spacerun:yes'>                   </span></td>
  <td colspan=17 class=xl155 width=1100 style='border-right:1.0pt solid black;
  border-left:none;width:825pt'>
  <?php
  $job_status=unserialize(JOB_STATUS);
  
  $status=(isset($records['status'])) ? $records['status'] : 'open';
  	
	foreach($job_status as $key =>$label)
	{
		if($status==$key)
		$chk='checked="checked"';
		else
		$chk='';
		
  		echo '<input type="radio" class="status" name="status" '.$chk.' value="'.$key.'">&nbsp;'.$label.'&nbsp;';
	}
?>	


  
  </td>
 </tr>                          
                          <?php	
     if(isset($records))
     $schedule_date=json_decode($records['schedule_date']);
     else
     $schedule_date=array();
	 
	 $current_date=strtotime(date('d-m-Y'));
    
    ?>
                          <tr height=21 style='height:15.75pt'>
                            <td rowspan=4 height=83 class=xl157 width=831 style='border-bottom:.5pt solid black;
      height:62.25pt;width:111pt'><b>SCHEDULE</b></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:124pt'>Date : <span id="current_date" style="display:none;"><?php echo date('Y-m-d'); ?></span>
      <?php 
			
			$arr=array('a','b','c','d','e','f');
			
			for($a=0;$a<count($arr);$a++)
			{
				${'disabled_'.$arr[$a]}='';	
				
				$schedule=(isset($schedule_date->$arr[$a])) ? $schedule_date->$arr[$a] : '';
				
				 if($schedule!='')
				 {		
					if($current_date>=strtotime($schedule))
					${'disabled_'.$arr[$a]}='disabled';
				 }
			}
			 
	   ?>
                              <input  type="text" <?php echo $disabled_a; ?> value="<?php echo (isset($schedule_date->a)) ? $schedule_date->a : ''; ?>" name="schedule_date[a]"  class="form-control datepicker schedule_date_a" style="width: 107px;" /></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:126pt'>Date :
                              <input type="text" <?php echo $disabled_b; ?> value="<?php echo (isset($schedule_date->b)) ? $schedule_date->b : '';?>" name="schedule_date[b]"  class="form-control datepicker schedule_date_b" style="width: 107px;" /></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:117pt'>Date :
                              <input type="text" <?php echo $disabled_c; ?> value="<?php echo (isset($schedule_date->c)) ? $schedule_date->c : ''; ?>" name="schedule_date[c]"  class="form-control datepicker schedule_date_c" style="width: 107px;" /></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:122pt'>Date :
                              <input type="text" <?php echo $disabled_d; ?> value="<?php echo (isset($schedule_date->d)) ? $schedule_date->d : ''; ?>" name="schedule_date[d]"  class="form-control datepicker schedule_date_d" style="width: 107px;" /></td>
                            <td colspan=2 class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:173pt'>Date :
                              <input type="text" <?php echo $disabled_e; ?> value="<?php echo (isset($schedule_date->e)) ? $schedule_date->e : ''; ?>" name="schedule_date[e]"  class="form-control datepicker schedule_date_e" style="width: 107px;" /></td>
                            <td colspan=5  class=xl143 style='border-right:1.0pt solid black;
      border-left:none;width:163pt'>Date :
                              <input type="text" <?php echo $disabled_f; ?> value="<?php echo (isset($schedule_date->f)) ? $schedule_date->f : ''; ?>" name="schedule_date[f]"  class="form-control datepicker schedule_date_f" style="width: 107px;" /></td>
                          </tr>
                          
                          <tr height=21 style='height:15.75pt'>
                            <td colspan=2 height=83 class=xl146 style='border-right:1.0pt solid black;
      height:15.75pt;border-left:none;width:124pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:126pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:117pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl146 style='border-right:1.0pt solid black;
      border-left:none;width:122pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=2 class=xl93 style='border-right:1.0pt solid black;
      border-left:none;width:173pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                            <td colspan=5  class=xl93 style='border-right:1.0pt solid black;
      border-left:none;width:163pt'><b>
                              <center>
                                Time
                              </center>
                            </b></td>
                          </tr>
                          
                          <tr height=21 style='height:15.75pt'>
                            <td height=83 class=xl93 width=426 style='height:15.75pt;border-top:none;
      border-left:none;width:59pt'>From</td>
                            <td class=xl94 width=83 style='border-top:none;border-left:none;width:65pt'>To</td>
                            <td class=xl93 width=100 style='border-top:none;border-left:none;width:65pt'>From</td>
                            <td class=xl94 width=77 style='border-top:none;border-left:none;width:61pt'>To</td>
                            <td class=xl93 width=77 style='border-top:none;border-left:none;width:61pt'>From</td>
                            <td class=xl94 width=71 style='border-top:none;border-left:none;width:56pt'>To</td>
                            <td class=xl93 width=85 style='border-top:none;border-left:none;width:67pt'>From</td>
                            <td class=xl94 width=108 style='border-top:none;border-left:none;width:55pt'>To</td>
                            <td class=xl93 width=107 style='border-top:none;border-left:none;width:83pt'>From</td>
                            <td class=xl94 width=116 style='border-top:none;border-left:none;width:90pt'>To</td>
                            <td class=xl93 width=225 style='border-top:none;border-left:none;width:74pt'>From</td>
                            <td colspan=5  class=xl161 style='border-right:1.0pt solid black;
      border-left:none;width:89pt'>To</td>
                          </tr>
                          
                          <?php
     if(isset($records))
     $schedule_from_time=json_decode($records['schedule_from_time']);
     else
     $schedule_from_time=array();
 
     if(isset($records))
     $schedule_to_time=json_decode($records['schedule_to_time']);
     else
     $schedule_to_time=array();
    
    ?>
                          <tr height=20 style='height:15.0pt'>
                            <td height=83 class=xl78 width=426 style='height:15.0pt;border-top:none;
  border-left:none;width:59pt'><?php echo generate_time(array('name'=>'schedule_from_time[a]','selected_value'=>(isset($schedule_from_time->a)) ? $schedule_from_time->a : '','disabled'=>$disabled_a)); ?></td>
                            <td class=xl79 width=83 style='border-top:none;border-left:none;width:65pt'><?php echo generate_time(array('name'=>'schedule_to_time[a]','selected_value'=>(isset($schedule_to_time->a)) ? $schedule_to_time->a : '','disabled'=>$disabled_a)); ?></td>
                            <td class=xl78 width=100 style='border-top:none;border-left:none;width:65pt'><?php echo generate_time(array('name'=>'schedule_from_time[b]','selected_value'=>(isset($schedule_from_time->b)) ? $schedule_from_time->b : '','disabled'=>$disabled_b)); ?></td>
                            <td class=xl79 width=77 style='border-top:none;border-left:none;width:61pt'><?php echo generate_time(array('name'=>'schedule_to_time[b]','selected_value'=>(isset($schedule_to_time->b)) ? $schedule_to_time->b : '','disabled'=>$disabled_b)); ?></td>
                            <td class=xl78 width=77 style='border-top:none;border-left:none;width:61pt'><?php echo generate_time(array('name'=>'schedule_from_time[c]','selected_value'=>(isset($schedule_from_time->c)) ? $schedule_from_time->c : '','disabled'=>$disabled_c)); ?></td>
                            <td class=xl79 width=71 style='border-top:none;border-left:none;width:56pt'><?php echo generate_time(array('name'=>'schedule_to_time[c]','selected_value'=>(isset($schedule_to_time->c)) ? $schedule_to_time->c : '','disabled'=>$disabled_c)); ?></td>
                            <td class=xl80 width=85 style='border-top:none;border-left:none;width:67pt'><?php echo generate_time(array('name'=>'schedule_from_time[d]','selected_value'=>(isset($schedule_from_time->d)) ? $schedule_from_time->d : '','disabled'=>$disabled_d)); ?></td>
                            <td class=xl81 width=108 style='border-top:none;border-left:none;width:55pt'><?php echo generate_time(array('name'=>'schedule_to_time[d]','selected_value'=>(isset($schedule_to_time->d)) ? $schedule_to_time->d : '','disabled'=>$disabled_d)); ?></td>
                            <td class=xl82 width=107 style='border-top:none;border-left:none;width:83pt'><?php echo generate_time(array('name'=>'schedule_from_time[e]','selected_value'=>(isset($schedule_from_time->e)) ? $schedule_from_time->e : '','disabled'=>$disabled_e)); ?></td>
                            <td class=xl81 width=116 style='border-top:none;border-left:none;width:90pt'><?php echo generate_time(array('name'=>'schedule_to_time[e]','selected_value'=>(isset($schedule_to_time->e)) ? $schedule_to_time->e : '','disabled'=>$disabled_e)); ?></td>
                            <td class=xl82 width=225 style='border-top:none;border-left:none;width:74pt'><?php echo generate_time(array('name'=>'schedule_from_time[f]','selected_value'=>(isset($schedule_from_time->f)) ? $schedule_from_time->f : '','disabled'=>$disabled_f)); ?></td>
                            <td colspan=5  class=xl168 style='border-right:1.0pt solid black;
  border-left:none;width:89pt'><?php echo generate_time(array('name'=>'schedule_to_time[f]','selected_value'=>(isset($schedule_to_time->f)) ? $schedule_to_time->f : '','disabled'=>$disabled_f)); ?></td>
                          </tr>
                          <?php
     if(isset($records))
     $no_of_persons=json_decode($records['no_of_persons']);
     else
     $no_of_persons=array();
    
    ?>
                          <tr height=40 style='height:30.0pt'>
                            <td height=40 class=xl84 width=831 style='height:30.0pt;border-top:none;
  width:111pt'>No of Persons involved</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><input type="text" <?php echo $disabled_a; ?> value="<?php echo (isset($no_of_persons->a)) ? $no_of_persons->a : ''; ?>" name="no_of_persons[a]"  class="form-control no_of_persons_a" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><input type="text" <?php echo $disabled_b; ?> value="<?php echo (isset($no_of_persons->b)) ? $no_of_persons->b : ''; ?>" name="no_of_persons[b]"  class="form-control no_of_persons_b" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><input type="text" <?php echo $disabled_c; ?> value="<?php echo (isset($no_of_persons->c)) ? $no_of_persons->c : ''; ?>" name="no_of_persons[c]"  class="form-control no_of_persons_c" style="width: 107px;" /></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><input type="text" <?php echo $disabled_d; ?> value="<?php echo (isset($no_of_persons->d)) ? $no_of_persons->d : ''; ?>" name="no_of_persons[d]"  class="form-control no_of_persons_d" style="width: 107px;" /></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><input type="text" <?php echo $disabled_e; ?> value="<?php echo (isset($no_of_persons->e)) ? $no_of_persons->e : ''; ?>" name="no_of_persons[e]"  class="form-control no_of_persons_e" style="width: 107px;" /></td>
                            <td width="213" colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><input type="text" <?php echo $disabled_f; ?> value="<?php echo (isset($no_of_persons->f)) ? $no_of_persons->f : ''; ?>" name="no_of_persons[f]"  class="form-control no_of_persons_f" style="width: 107px;" /></td>
                          </tr>
                          <?php
     if(isset($records))
     $performing_authority=json_decode($records['performing_authority']);
     else
     $performing_authority=array();
    
    ?>
                          <tr height=34 style='mso-height-source:userset;height:25.5pt'>
                            <td height=34 class=xl84 width=831 style='height:25.5pt;border-top:none;
  width:111pt'>Performing Authority</td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:124pt'><select <?php echo $disabled_a; ?> id="performing_authority[a]" name="performing_authority[a]"  class="form-control authority performing performing_authority_a" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->a)) ? $performing_authority->a : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:126pt'><select <?php echo $disabled_b; ?> id="performing_authority[b]" name="performing_authority[b]"  class="form-control authority performing performing_authority_b" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->b)) ? $performing_authority->b : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:117pt'><select <?php echo $disabled_c; ?> id="performing_authority[c]" name="performing_authority[c]"  class="form-control authority performing performing_authority_c" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->c)) ? $performing_authority->c : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl179 style='border-right:1.0pt solid black;
  border-left:none;width:122pt'><select <?php echo $disabled_d; ?> id="performing_authority[d]" name="performing_authority[d]"  class="form-control authority performing performing_authority_d" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->d)) ? $performing_authority->d : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:173pt'><select <?php echo $disabled_e; ?> id="performing_authority[e]" name="performing_authority[e]"  class="form-control authority performing performing_authority_e" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->e)) ? $performing_authority->e : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=5 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;width:163pt'><select <?php echo $disabled_f; ?> id="performing_authority[f]" name="performing_authority[f]"  class="form-control authority performing performing_authority_f" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($performing_authority->f)) ? $performing_authority->f : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='PA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                          </tr>
                          <?php
     if(isset($records))
     $issuing_authority=json_decode($records['issuing_authority']);
     else
     $issuing_authority=array();
    
    ?>
                          <tr height=30 style='mso-height-source:userset;height:22.5pt'>
                            <td height=30 class=xl85 width=831 style='height:22.5pt;border-top:none;
  width:111pt'>Issuing Authority</td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_a; ?> id="issuing_authority[a]" name="issuing_authority[a]"  class="form-control authority issuing issuing_authority_a" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->a)) ? $issuing_authority->a : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_b; ?> id="issuing_authority[b]" name="issuing_authority[b]"  class="form-control authority issuing issuing_authority_b" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->b)) ? $issuing_authority->a : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_c; ?> id="issuing_authority[c]" name="issuing_authority[c]"  class="form-control authority issuing issuing_authority_c" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->c)) ? $issuing_authority->c : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl179  style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_d; ?> id="issuing_authority[d]" name="issuing_authority[d]"  class="form-control authority issuing issuing_authority_d" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->d)) ? $issuing_authority->d : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=2 class=xl177 style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_e; ?> id="issuing_authority[e]" name="issuing_authority[e]"  class="form-control authority issuing issuing_authority_e" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->e)) ? $issuing_authority->e : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                            <td colspan=5 class=xl177  style='border-right:1.0pt solid black;
  border-left:none;'><select <?php echo $disabled_f; ?> id="issuing_authority[f]" name="issuing_authority[f]"  class="form-control authority issuing issuing_authority_f" style="width: 120px;">
                              <option value="" selected="selected">- - Select - -</option>
                              <?php
  $select=(isset($issuing_authority->f)) ? $issuing_authority->f : '';
  if($authorities!='')
  {
	  foreach($authorities as $fet)
	  {
		  $role=$fet['user_role'];
		  
		  $id=$fet['id'];
		  
		  $first_name=$fet['first_name'];
		  
		  $chk='';
		  
		  if($role=='IA')
		  {
		  		if($select==$id) $chk='selected';
  ?>
                              <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                              <?php
		  }
	  }
  }
   ?>
                            </select></td>
                          </tr>
                          
                           <tr height=31 style='height:23.25pt'>
                            <td colspan=16 height=31 class=xl182 style='border-right:1.0pt solid black;
  height:23.25pt;width:936pt'>
                        <b>  Emergency Contact number : Cell : 9865152222/ 3108 / PA system 9 Ref No: WI-33(P1-14:AM 7) Rev No: 01 Dt. 30.06.2016
</b>
 
                          </td></tr>
                          
                        </table>

                        
                        <div>&nbsp;</div>
                          
                           
                         
						<?php
							$redirect=base_url().'jobs/day_in_process';
						
							if($records['status']!=STATUS_CLOSED)
							{
						?>
                           <button class="btn btn-sm btn-primary show_button"  value="hide" type="submit"><i class="fa fa-dot-circle-o"></i> Update time</button>
                          <?php
							}
							?>
                           <a  class="btn btn-sm btn-danger" href="<?php echo $redirect; ?>"><i class="fa fa-ban"> Back </i></a>                         
						</div>
					</div>
</form>                    
				</div><!--/col-->
			
			</div><!--/row-->
				
		</div>
<!-- end: Content -->
<?php

function generate_time($array_args)
{
	extract($array_args);
	
	$selected_value=(isset($selected_value)) ? $selected_value : '';
	
	$width=(isset($width)) ? $width : '67px';
?>	
	<select name="<?php echo $name; ?>" <?php echo (isset($disabled)) ? $disabled : ''; ?> id="<?php echo $name; ?>"  class="form-control" style="width:<?php echo $width; ?>;">
    	<option value="" selected="selected">Select</option>
	<?php for($i = 0; $i < 24; $i++)
		{
	
		$t=$i % 12 ? $i % 12 : 12;
		
		$t.= ':00';
		
		$a=$i >= 12 ? 'pm' : 'am';
		
		$t=$t.' '.$a;
		
		if($t==$selected_value)
		$sel="selected=selected";
		else
		$sel='';
	 ?>
 	 <option value="<?php echo $t; ?>" <?php echo $sel; ?>><?php echo $t; ?></option>
	<?php } ?>
	</select>
<?php	
}


 $this->load->view('layouts/footer_script'); ?>
<?php $this->load->view('layouts/footer'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">
		$(".datepicker").datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			clearBtn:true
		});
		
</script>		
<script>
	$(document).ready(function() {
		$('.datepicker').prop('readonly', true);
		
	$('.show_button').click(function() {
		$('#show_button').val($(this).val());
	});	
	
	$('input[type=checkbox],input[type=radio]').attr('disabled','disabled');
	
	$('.status').removeAttr('disabled',true);
	
	$('.on_off').change(function() {
		
		var date_relate=$(this).attr('data-relate');
		
		var val=$(this).val();
		
		if(val=='Yes')
		$('.'+date_relate).removeAttr('disabled');
		else
		$('.'+date_relate).attr('disabled',true);
	});	
		
		<?php $flag='true'; ?>
    $("#job_form").validate({ 
			rules: {
				department_id:{required:<?php echo $flag; ?>},
                location:{required:<?php echo $flag; ?>},
				location_date: { required:<?php echo $flag; ?> },
				location_time_start: { required:<?php echo $flag; ?> },
				location_time_to: { required:<?php echo $flag; ?> },
				equipment_name: { required:<?php echo $flag; ?> },
				job_name: { required:<?php echo $flag; ?> },
				contractor_name: { required:<?php echo $flag; ?> }
            },
			messages:
			{
				department_id : {required:'Required' },
				location:{required:'Required' },
				location_date:{required:'Required' },
				location_time_start:{required:'Required' },
				location_time_to:{required:'Required' },
				equipment_name:{required:'Required' },
				job_name:{required:'Required' },
				contractor_name:{required:'Required' }
			},
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        }/*,
		showErrors: function(errorMap, errorList) {
				if (submitted) {
					var summary = "You have the following errors: <br/>";
					$.each(errorList, function() { summary += " * " + this.message + "<br/>"; });
					$("#form_errors").html(summary);
					submitted = false;
				}
				//--> if you dont want to see the errors in line remove this below line?
				this.defaultShowErrors();
			},          
		invalidHandler: function(form, validator) {
			submitted = true;
		}*/,       		
        submitHandler:function(){
             $("#job_form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                //form.submit();
			var data = new FormData();					
			var $inputs = $('form#job_form :input[type=text],form#job_form :input[type=hidden],select');
			 $inputs.each(function() {
					if(this.type=='radio')
					{
						if(this.name)
						{
							var checked_val = $("input[name="+this.name+"]:checked").val();
						
							data.append(this.name,checked_val);
						}
					}
					else
					{
						data.append(this.name,$(this).val());
					}
					
			});		
			
			data.append('status',$('input[name=status]:checked').val());
			
			$.ajax({
							url: base_url+'jobs/form_action',
							type: 'POST',
							"beforeSend": function(){ },
							data: data,
							cache: false,
							dataType: 'json',
							processData: false, // Don't process the files
							contentType: false, // Set content type to false as jQuery will tell the server its a query string request
							success: function(data, textStatus, jqXHR)
							{
								if(data){
									window.location.href=base_url+'jobs/day_in_process/';
								}							
							},
							error: function(data, textStatus,errorThrown)
							{
									$('#error').show();
									
									$('#error_msg').html(data.failure);
							}
						});	
						
						return false;		
			
        }
    });
    });
	
	
	
	
$( window).load(function() {
	
	if($('.status:checked').val()!='extended')
	{
		//$('select[name^="schedule_from_time"]').attr('readonly',true);  
		$('select[name^="schedule_from_time"] option:not(:selected),select[name^="schedule_to_time"] option:not(:selected),select[name^="performing_authority"] option:not(:selected),select[name^="issuing_authority"] option:not(:selected)').prop('disabled', true);
		
		$('input[name^="no_of_persons"],input[name^="schedule_date"]').attr('disabled','disabled');  
	}
  	
	$('.status').click(function()
	{ 
		if($('.status:checked').val()!='extended')
		{
			$('select[name^="schedule_from_time"] option:not(:selected),select[name^="schedule_to_time"] option:not(:selected),select[name^="performing_authority"] option:not(:selected),select[name^="issuing_authority"] option:not(:selected)').prop('disabled', true);
			
			$('input[name^="no_of_persons"],input[name^="schedule_date"]').attr('disabled','disabled');  
		}
		else
		{
			var current_date=$('#current_date').html();
			
			$('input[name^="schedule_date"]').each(function()
			{
				var schedule_date=$(this).val();
				
				var selector_name = $(this).attr('name');
				
				var escaped_selector_name = selector_name.match(/\[(.*?)\]/);
				
				var selector_name=escaped_selector_name[1];
				
				if(schedule_date!='')
				{
					var spl=schedule_date.split('-');
					
					var sch_date=spl[2]+'-'+spl[1]+'-'+spl[0];
					
					var diff =  Math.floor(( Date.parse(sch_date) - Date.parse(current_date) ) / 86400000);	
				}	
				else
				diff=0;
				
				console.log('DD :'+diff);
				
				
				if(diff<0)
				{
					console.log('ESS : '+selector_name);
					
					//$('select[name^="schedule_from_time"] option:not(:selected),select[name^="schedule_to_time"] option:not(:selected),select[name^="performing_authority"] option:not(:selected),select[name^="issuing_authority"] option:not(:selected)').prop('disabled', true);
			
					//$('input[name^="no_of_persons"],input[name^="schedule_date"]').attr('disabled','disabled');  
					
					//$('input[name^="no_of_persons['+selector_name+']"]').prop('disabled',true);
					
					//$('.no_of_persons_'+selector_name).prop('disabled',true);
					
					//$('select.performing_authority_'+selector_name+' option:not(:selected)').prop('disabled',true);
					
					$('select[name="schedule_from_time['+selector_name+']"]  option:not(:selected),select[name="schedule_to_time['+selector_name+']"]  option:not(:selected),select[name="performing_authority['+selector_name+']"]  option:not(:selected),select[name="issuing_authority['+selector_name+']"]  option:not(:selected)').prop('disabled',true);
					
					$('input[name="no_of_persons['+selector_name+']"],input[name="schedule_date['+selector_name+']"]').prop('disabled',true);  
				}
				else
				{
					console.log('Greater : '+selector_name);
					$('input[name="no_of_persons['+selector_name+']"],input[name="schedule_date['+selector_name+']"]').prop('disabled',false);  
					
					
					$('select[name="schedule_from_time['+selector_name+']"]  option:not(:selected),select[name="schedule_to_time['+selector_name+']"]  option:not(:selected),select[name="performing_authority['+selector_name+']"]  option:not(:selected),select[name="issuing_authority['+selector_name+']"]  option:not(:selected)').prop('disabled',false);
					
					//$(':select([name=schedule_from_time['+selector_name+']],[name=schedule_to_time['+selector_name+']],[name=performing_authority['+selector_name+']],[name=issuing_authority['+selector_name+']])').removeAttr('disabled');
				}
			});
			
			
		}
	});
	

		
		
		
	
		
});	
</script>
