<div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Electrical Work:</label>               
      
      <div class="form-control-plaintext"><b>LIVE ELECTRICAL WORK PERFORMED BY LICENCED ELECRTRICIAN ONLY</b></div>  
      <?php
        $precautions_data=(isset($precautions['electrical'])) ? json_decode($precautions['electrical'],true) : array();

        $labels=array(1=>'Obtained LOTOTO',2=>'Power supply locked and tagged',3=>'Circuit checked for zero voltage',4=>'Portable cords and electric tools inspected',5=>'Safety back-up man appointed',6=>'Job Hazards is explained to all concern thru tool box talk meeting.',7=>'Physical isolation is ensured If yes, State the method',8=>'In case of lock applied, ensure the safe custody of the key',9=>'If physical isolation is not possible state, the alternative method of precaution');

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
                              <input class="form-check-input electrical" type="radio" 
                              value="y" name="electrical[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input electrical" type="radio" 
                              value="n" name="electrical[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
      <div class="col-md-6 col-xl-6">

      <label class="form-label text-red">&nbsp;</label>     
      <div class="form-control-plaintext"><b>Equipment Provided</b></div>  
      <?php
      $labels=array(10=>'Approved rubber and leather gloves',11=>'Insulating mat',12=>'Fuse puller',13=>'Disconnect pole or safety rope',14=>' Non-conductive hard hat',15=>'ELCB/RCCB is installed of 30 mA');
      ?>
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
                                    <input class="form-check-input electrical" type="radio" 
                                    value="y" name="electrical[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                    </label>
                                    <label class="form-check form-check-inline">
                                    <input class="form-check-input electrical" type="radio" 
                                    value="n" name="electrical[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                  value="" name="precautions_electrical_additional_info"><?php echo (isset($precautions['precautions_electrical_additional_info'])) ? strtoupper($precautions["precautions_electrical_additional_info"]) : ''; ?></textarea>
            </label>
      </div>                                            
      </div>
</div>