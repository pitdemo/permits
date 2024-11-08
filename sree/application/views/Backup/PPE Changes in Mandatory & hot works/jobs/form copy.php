<?php 

    $this->load->view('layouts/preload');

    $this->load->view('layouts/admin_header');
?>
<div class="page-wrapper">
       
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
          <div class="row row-cards">

          <div class="col-lg-12">
              <div class="row row-cards">
                <div class="col-12">
                  <form class="card">
                    <div class="card-body">
                      <h3 class="card-title" style="color:green">Permit No: <?php echo $permit_no; ?></h3>
                      <div class="row row-cards">
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Department</label>
                            <div class="form-control-plaintext"><?php echo $department['name']; ?></div>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Select Zone</label>
                            <select class="form-control" name="zone_id" id="zone_id">
                                <option value="">- - Select Zone - - </option>
                                <?php   
                                    $zone_name='';
                                    $select_zone_id=(isset($records['zone_id'])) ? $records['zone_id'] : '';        
                                    if($zones->num_rows()>0)
                                    {
                                       $zones=$zones->result_array();

                                       foreach($zones as $list){
                                    
                                ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_zone_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php }} ?>
                              </select>
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Start Date & Time</label>
                            <input type="text" class="form-control" name="location_time_start" id="location_time_start"  value="<?php echo (isset($records['location_time_start'])) ? $records['location_time_start'] : date('d-m-Y H:i'); ?>" readonly="readonly">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">End Date & Time</label>
                            <input type="text" class="form-control" name="location_time_to" id="location_time_to"  value="<?php echo (isset($records['location_time_to'])) ? $records['location_time_to'] : date('d-m-Y H:i',strtotime("+12 hours")); ?>" readonly="readonly">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Select Contractor</label>
                            <select class="form-control contractors" data-show="other_contractors" name="contractor_id" id="contractor_id">
                                <option value="">- - Select Contractor - - </option>
                            <?php   
                                  $zone_name='';
                                  $select_contractor_id=(isset($records['contractor_id'])) ? $records['contractor_id'] : '';

                                        foreach($contractors as $list){
                      
                                ?>
                                <option value="<?php echo $list['id'];?>" <?php if($select_contractor_id==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                <?php } ?>

                             </select>    
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Sub Contractor</label>
                            <input type="text" class="form-control" placeholder="Sub Contractor Name"  value="">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Initiator Name & Signature</label>
                            <input type="text" class="form-control" placeholder="" value="">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label error">A) To be filled by Permit Initiator</label>                            
                          </div>
                        </div>
                        <div class="col-md-12">
                                <div class="mb-3">                                   
                                    <div>
                                        <?php
                                            foreach($permits as $list){
                                        ?>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" name="permit_type[]" type="checkbox" value="<?php echo $list['id']; ?>">
                                        <span class="form-check-label"><?php echo $list['name']; ?></span>
                                    </label>
                                    <?php } ?>

                                    </div>
                                </div>
                        </div>
                        <div class="col-md-12">
                          <div class="mb-3 mb-0">
                            <label class="form-label">Work Description</label>
                            <textarea rows="3" class="form-control" placeholder="Here can be your description"
									          value=""></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row g-5">
                            <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">Checkpoints for Permit Initiator</label>
                                            </div>
                                            <?php
                                            $checkpoints=unserialize(CHECKPOINTS);
                                            ?>
                                            <div class="mb-3">
                                                <?php
                                                foreach($checkpoints as $key => $label):
                                                ?>
                                                <label class="form-check">
                                                    <input class="form-check-input" name="checkpoints[]" type="checkbox" value="<?php echo $key; ?>">
                                                    <span class="form-check-label"><?php echo $label; ?></span>
                                                </label>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>                            
                            
                            </div>

                            <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">Clearance required from other Department</label>
                                            </div>
                                            <div class="mb-3">
                                                <?php
                                                foreach($clearance_departments as $list):
                                                ?>
                                                <label class="form-check">
                                                    <input class="form-check-input" name="checkpoints[]" type="checkbox" value="<?php echo $list['id']; ?>">
                                                    <span class="form-check-label"><?php echo $list['name']; ?></span>
                                                </label>
                                                <?php endforeach; ?>
                                            </div>
                                            
                                        </div>
                                        
                                    </div> 
                            </div>
                       </div>                      

                       <hr />

                       <div class="row g-5">
                            <div class="col-xl-7">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">B) Issuer: I have checked that all conditions are met to carry out the job safety.</label>

                                            <div class="form-control-plaintext">I have checked that all equipments have been identified by initiator as mentioned below. Please get isolated the equipment</div>
                                            </div>                                           
                                        </div>
                                    </div>                            
                            
                            </div>
                             <?php
                             $acceptance_issuing_id=$record_id=$acceptance_performing_id=''; 
                             ?>
                            <div class="col-xl-5">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-9">
                                            <div class="mb-3">
                                            <label class="form-label">Name of the Issuer</label>
                                            </div>
                                            <div class="mb-3">
                                            <select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                            <option value="">- - Select - -</option>
                                            <?php  
                                            
                                                if($authorities!='')
                                                {
                                                    foreach($authorities as $fet)
                                                    {
                                                    $role=$fet['user_role'];
                                                    
                                                    $id=$fet['id'];
                                                    
                                                    $first_name=$fet['first_name'];
                                                    
                                                    $chk='';
                                                    
                                                        if($record_id=='')
                                                        {
                                                            if($id!=$user_id)
                                                            $flag=1;
                                                            else
                                                            $flag=0;
                                                        }
                                                        else
                                                        $flag=1;
                                                        
                                                    if($flag==1 && $acceptance_performing_id!=$id)
                                                    {
                                                        if($acceptance_issuing_id==$id) $chk='selected';
                                                ?>
                                                                                <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                                                                <?php
                                                    }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </div>
                                            <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <input value="<?php //echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                            </div>
                                            
                                        </div>
                                        
                                    </div> 
                            </div>
                       </div> 
                       <hr />
                        
                       <div class="row g-5">
                            <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">C) To be filled by Permit initiator and checked by issuer</label>
                                            </div>                                            
                                        </div>
                                    </div>                            
                            
                            </div>

                            <div class="col-xl-6">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">D) To be filled by authorized isolator who is carrying out isolations</label>
                                            </div>
                                        </div>
                                    </div> 
                            </div>
                       </div>

                       <div class="row g-5">
                            <div class="col-xl-12">
                            <div class="table-responsive">
                        <table class="table mb-0" border="1">
                          <thead>
                            <tr>
                              <th style="text-align:center">Eq.Details</th>
                              <th style="text-align:center">Equip Tag No</th>
                              <th style="text-align:center">Type of Isolation</th>
                              <th style="text-align:center" class="text-orange">Lock & Tag No</th>
                              <th style="text-align:center" class="text-orange">Lock No</th>
                              <th style="text-align:center" class="text-orange">Name of the Isolator</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            for($i=1;$i<=3;$i++)
                            {

                            ?>
                            <tr>
                              <td>
                              <input type="text" class="form-control">
                              </td>
                              <td>
                                <input type="text" class="form-control"></td>
                              <td>
                              <input type="text" class="form-control">
                              </td>
                              <td>
                                <input type="text" class="form-control" >
                              </td>
                              <td>
                                <input type="text" class="form-control" >
                              </td>
                              <td>
                                <input type="text" class="form-control" >
                              </td>
                            </tr>
                            <?php
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>     
                      <hr />

                      <div class="row g-5">
                            <div class="col-xl-7">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">E) To be filled & ensured by issuer.</label>

                                            <div class="form-control-plaintext">1. <input type="checkbox" /> Are all required equipments identified and stopped? </div>
                                            <div class="form-control-plaintext">2. <input type="checkbox" /> Are precedings & followings equipment also stopped? </div>
                                            <div class="form-control-plaintext">3. <input type="checkbox" /> Is try out done as per LOTO matrix from CCR? </div>
                                            <div class="form-control-plaintext">4. <input type="checkbox" /> Are all equipments emptied out/material removed? 
                                            </div>                                            
                                            </div>                                           
                                        </div>
                                    </div>                            
                            
                            </div>
                             <?php
                             $acceptance_issuing_id=$record_id=$acceptance_performing_id=''; 
                             ?>
                            <div class="col-xl-5">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-9">
                                            <div class="mb-3">

                                            <div class="form-control-plaintext">
                                            I have ensure that all isolation mentioned in clause no <b>C&D</b> are completed, clearance is given to start the job.
                                            </div>
                                            <label class="form-label">Name of the Issuer</label>
                                            </div>
                                            <div class="mb-3">
                                            <select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                            <option value="">- - Select - -</option>
                                            <?php  
                                            
                                                if($authorities!='')
                                                {
                                                    foreach($authorities as $fet)
                                                    {
                                                    $role=$fet['user_role'];
                                                    
                                                    $id=$fet['id'];
                                                    
                                                    $first_name=$fet['first_name'];
                                                    
                                                    $chk='';
                                                    
                                                        if($record_id=='')
                                                        {
                                                            if($id!=$user_id)
                                                            $flag=1;
                                                            else
                                                            $flag=0;
                                                        }
                                                        else
                                                        $flag=1;
                                                        
                                                    if($flag==1 && $acceptance_performing_id!=$id)
                                                    {
                                                        if($acceptance_issuing_id==$id) $chk='selected';
                                                ?>
                                                                                <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                                                                <?php
                                                    }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </div>
                                            <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <input value="<?php //echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                            </div>
                                            
                                        </div>
                                        
                                    </div> 
                            </div>
                       </div> 


                       <hr />


                      <div class="row g-5">
                            <div class="col-xl-7">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-12">
                                            <div class="mb-3">
                                            <label class="form-label">F) Try Out done by initiator. <input type="checkbox" /></label>
                                            </div>
                                            <div class="mb-3 ">
                                            <div class="form-control-plaintext">Name & Sign of the initiator</div>
                                            <div class="mb-3 col-md-6"><select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                            <option value="">- - Select - -</option>
                                            <?php  
                                            
                                                if($authorities!='')
                                                {
                                                    foreach($authorities as $fet)
                                                    {
                                                    $role=$fet['user_role'];
                                                    
                                                    $id=$fet['id'];
                                                    
                                                    $first_name=$fet['first_name'];
                                                    
                                                    $chk='';
                                                    
                                                        if($record_id=='')
                                                        {
                                                            if($id!=$user_id)
                                                            $flag=1;
                                                            else
                                                            $flag=0;
                                                        }
                                                        else
                                                        $flag=1;
                                                        
                                                    if($flag==1 && $acceptance_performing_id!=$id)
                                                    {
                                                        if($acceptance_issuing_id==$id) $chk='selected';
                                                ?>
                                                                                <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                                                                <?php
                                                    }
                                                    }
                                                }
                                                ?>
                                            </select></div>

                                            <div class="mb-3 col-md-6">
                                            <label class="form-label">Date & Time</label>
                                            <input value="<?php //echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                            </div>
                                              
                                            </div>                                           
                                        </div>
                                    </div>                            
                            
                            </div>
                             <?php
                             $acceptance_issuing_id=$record_id=$acceptance_performing_id=''; 
                             ?>
                            <div class="col-xl-5">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-9">
                                            <div class="mb-3">

                                            <div class="form-control-plaintext">
                                            <b>G) I am briefed & understood all potential hazard involved in that activity</b>
                                            </div>
                                            <label class="form-label">Name & Sign of co-permittee</label>
                                            </div>
                                            <div class="mb-3">
                                            <select id="acceptance_issuing_id" <?php if($acceptance_issuing_id=='') { ?>  disabled="disabled" <?php } ?> name="acceptance_issuing_id" class="form-control issuing authority">
                                            <option value="">- - Select - -</option>
                                            <?php  
                                            
                                                if($authorities!='')
                                                {
                                                    foreach($authorities as $fet)
                                                    {
                                                    $role=$fet['user_role'];
                                                    
                                                    $id=$fet['id'];
                                                    
                                                    $first_name=$fet['first_name'];
                                                    
                                                    $chk='';
                                                    
                                                        if($record_id=='')
                                                        {
                                                            if($id!=$user_id)
                                                            $flag=1;
                                                            else
                                                            $flag=0;
                                                        }
                                                        else
                                                        $flag=1;
                                                        
                                                    if($flag==1 && $acceptance_performing_id!=$id)
                                                    {
                                                        if($acceptance_issuing_id==$id) $chk='selected';
                                                ?>
                                                                                <option value="<?php echo $id; ?>" <?php echo $chk; ?>><?php echo $first_name; ?></option>
                                                                                <?php
                                                    }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            </div>
                                            <div class="mb-3">
                                            <label class="form-label">Date & Time</label>
                                            <input value="<?php //echo $acceptance_issuing_date; ?>" type="text" id="acceptance_issuing_date"  name="acceptance_issuing_date" class="form-control" readonly="readonly" />
                                            </div>
                                            
                                        </div>
                                        
                                    </div> 
                            </div>
                       </div> 
                       <hr />

                       <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label error">H) Renewal of Permit to Work</label>                            
                          </div>
                        </div>

                        <div class="row g-5">
                            <div class="col-xl-12">
                            <div class="table-responsive">
                                <table class="table mb-0" border="1">
                                  <thead>
                                    <tr>
                                      <th style="text-align:center">Date & Time</th>
                                      <th style="text-align:center">Initiator</th>
                                      <th style="text-align:center">Issuer</th>
                                      <th style="text-align:center">Co-permittee</th>
                                      <th style="text-align:center" class="text-orange">Date & Time</th>
                                      <th style="text-align:center" class="text-orange">Initiator</th>
                                      <th style="text-align:center" class="text-orange">Issuer</th>
                                      <th style="text-align:center" class="text-orange">Co-permittee</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    for($i=1;$i<=3;$i++)
                                    {

                                    ?>
                                    <tr>
                                      <td>
                                      <input type="text" class="form-control">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control"></td>
                                      <td>
                                      <input type="text" class="form-control">
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" >
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" >
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" >
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" >
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" >
                                      </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                  </tbody>
                                </table>
                            </div>     
                            </div>
                       </div>
                       
                       <div>&nbsp;</div>

                       <div class="col-sm-6 col-md-12">
                          <div class="mb-3">
                            <label class="form-label error">I) Closure of permit to work (1st copy of Permit must be routed during permit closure)</label>                            
                          </div>
                        </div>

                        <?php
                        $arr = array('The job is completed, all men & material removed from site. Safe to remove isolations as stated clause-A&C.','Please remove isolations as stated clause-A&C.','I have removed all isolation as listed clause-A&C.','All isolations as per clause-A&C are restored. Equipment ready to start.','1st copy of permit resolved for record purpose.');

                        $arr_sub = array('Permit Initiator Name & Sign','Issuer Name & Sign','Isolator Name & Sign','Issuer Name & Sign','Permit Initiator Name & Sign');



                        foreach($arr as $key => $label):
                        ?>
                      
                        <div class="row row-cards">
                            <div class="col-md-6">
                              <div class="mb-3">
                                <label class="form-label"><?php echo ($key+1).' '.$label; ?></label>
                                
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="mb-3">
                                <label class="form-label"><?php echo $arr_sub[$key]; ?></label>
                                <div class="form-control-plaintext"><select class="form-control"></select></div>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-control-plaintext"><input type="text" class="form-control" placeholder="DD/MM/YYYY HH/MM" /></div>
                              </div>
                            </div>
                        </div>
                        <?php
                        endforeach;
                        ?>
                        
                            

                        
                                                


                        </div>
                    
                        <div class="card-footer text-end">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </form>
                </div>                
              </div>
            </div>

       

         </div>
          </div>
        </div>        
      </div>

      </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>

  