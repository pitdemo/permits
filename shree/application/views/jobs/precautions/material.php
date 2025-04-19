<div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Material lowering & lifting:</label>                                     
      <?php
        $precautions_data=(isset($precautions['materials'])) ? json_decode($precautions['materials'],true) : array();

        $labels=array(1=>'Safety devices of the lifting appliances are inspected before use',2=>'Operator qualified and medically fit including eye sight examined by authority',3=>'Lifting appliances are certified by competent authority and labeled properly.',4=>'Hoist chain or hoist rope free of kinks or twists and not wrapped around the load.',5=>'Lifting Hook has a Safety Hook Latch that will prevent the rope from slipping out.',6=>'Lifting gears operator been instructed not to leave the load suspended',7=>'Electrical equipment’s are free from damage and earthed properly','8'=>'Electrical power line clearance (12ft) checked',9=>'Signal man identified','10'=>'Outriggers supported, Crane leveled','11'=>'SLI/ Load chart available in the crane');
            $a=1;
        ?>

            <table class="table mb-0" border="1">
                <tbody>
                        <tr>
                              <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                              <th width="9%">Precautions</th>
                        </tr>
                        <?php
                        foreach($labels as $key => $label):
                              $y_checked=$n_checked='';

                              if(isset($precautions_data) && count($precautions_data)>0)
                              {
                              $data = (isset($precautions_data[$key])) ? $precautions_data[$key] : '';

                              $y_checked = $data=='y' ? "checked='checked'" : '';
                              $n_checked = $data=='n' ? "checked='checked'" : '';
                              }

                        ?>
                        <tr>
                              <td colspan="2"> 
                              <label class="form-check form-check-inline">
                              <input class="form-check-input materials" type="radio" 
                              value="y" name="materials[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input materials" type="radio" 
                              value="n" name="materials[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
                              </label>
                              </td>
                              <td> 
                              <?php echo $label; ?>
                              </td>
                        </tr>
                            <?php
                            $a++;
                            endforeach;
                            ?>
                </tbody>
            </table>
     
      

      <label class="form-check" style="padding-left:0px;">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                 name="precautions_material_additional_info"><?php echo (isset($precautions['precautions_material_additional_info'])) ? strtoupper($precautions["precautions_material_additional_info"]) : ''; ?></textarea>
      </label>

      </div>                                            
      </div>
      <?php
      $labels = array('12'=>'Barrier Installed','13'=>'Riggers are competent',14=>'Slings are inspected for free from cut marks, pressing, denting, bird caging, twist, kinks or core protrusion prior to use.',15=>'Slings mechanically spliced (Hand spliced slings may not be allowed)',16=>'D / Bow shackles are free from any crack, dent, distortion or weld mark, wear / tear',17=>'Special lift as per erection / lift plan',18=>'Job Hazards is explained to all concern thru tool box talk meeting',19=>'Guide rope is provided while shifting / lifting/lowering the load.',20=>'Daily inspection checklist followed and maintained for crane',21=>'SWL displayed',22=>'Wind velocity < 36 KMPH, No rain');



      
      ?>
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">&nbsp;</label>  
      
      <table class="table mb-0" border="1">
                <tbody>
                        <tr>
                              <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                              <th width="9%">Precautions</th>
                        </tr>
                        <?php
                        foreach($labels as $key => $label):
                              $y_checked=$n_checked='';

                              if(isset($precautions_data) && count($precautions_data)>0)
                              {
                              $data = (isset($precautions_data[$key])) ? $precautions_data[$key] : '';

                              $y_checked = $data=='y' ? "checked='checked'" : '';
                              $n_checked = $data=='n' ? "checked='checked'" : '';
                              }

                        ?>
                        <tr>
                              <td colspan="2"> 
                              <label class="form-check form-check-inline">
                              <input class="form-check-input materials" type="radio" 
                              value="y" name="materials[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input materials" type="radio" 
                              value="n" name="materials[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
                              </label>
                              </td>
                              <td> 
                              <?php echo $label; ?>
                              </td>
                        </tr>
                            <?php
                            $a++;
                            endforeach;
                            ?>
                </tbody>
            </table>
      
      </div>                                            
      </div>
  </div>  