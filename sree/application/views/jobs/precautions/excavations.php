  <div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Excavation (irrespective of depth):</label> 
      <?php
        $precautions_data=(isset($precautions['excavations'])) ? json_decode($precautions['excavations'],true) : array();
        $labels=array(1=>'Contractor has a competent person assigned to inspect & control condition of excavation on site',2=>'Underground utilities identified',3=>'Power equipment grounded',4=>'Electrical or mechanical overhead clearances checked',5=>'Hard / Soft Barricades, area warning placed',6=>'Means of egress (ladder or steps) placed',7=>'Side walls shored or laid back');

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
                                          <input class="form-check-input excavations" type="radio" 
                                          value="y" name="excavations[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                          </label>
                                          <label class="form-check form-check-inline">
                                          <input class="form-check-input excavations" type="radio" 
                                          value="n" name="excavations[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                        <textarea rows="5" class="form-control" placeholder="Here can be your additional info"
                        value="" name="precautions_excavations_additional_info"><?php echo (isset($precautions['precautions_excavations_additional_info'])) ? strtoupper($precautions["precautions_excavations_additional_info"]) : ''; ?></textarea>
                  </label>
      </div>                                            
      </div>

      <?php
       $labels=array(8=>'Area adequately lighted',9=>'Material or soil removed from excavation edge',10=>'Excavator is fit for the job',11=>'Banksman provided to guide the operator',12=>'Method of dewatering is established and ensured the stoppage of water return',13=>'Excavated pit edges free from heavy over-burden, stack of materials',14=>'People are prevented from working inside pits if heavy vehicle movement in the vicinity due to which soil collapse may take place',15=>'Job Hazards is explained to all concern thru tool box talk meeting.',16=>'Additional measures');
       ?>
      <div class="col-md-6 col-xl-6">

      <label class="form-label text-red">&nbsp;</label>   
      <div class="mb-3">
      
    
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
                                          <input class="form-check-input excavations" type="radio" 
                                          value="y" name="excavations[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                          </label>
                                          <label class="form-check form-check-inline">
                                          <input class="form-check-input excavations" type="radio" 
                                          value="n" name="excavations[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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