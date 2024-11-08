<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">Confined Space Entry:</label> 
        <?php
        $precautions_data=(isset($precautions['confined_space'])) ? json_decode($precautions['confined_space'],true) : array();
        $labels=array(1=>'Equipment properly drained / Depressurized',2=>'Disconnected Inlet, Outlet lines and isolate equipment',3=>'Vent / Manholes are kept open to maintain proper ventilation',4=>'Only trained personnel were engaged & register was maintained for entry & exit of person with time.',5=>'Standby Personnel/Entry supervisor,. is available');
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
                              <input class="form-check-input confined_space" type="radio" 
                              value="y" name="confined_space[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                              value="n" name="confined_space[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                value="" name="precautions_confined_additional_info"><?php echo (isset($precautions['precautions_confined_additional_info'])) ? strtoupper($precautions["precautions_confined_additional_info"]) : ''; ?></textarea>
            </label>                                      
        </div>                                            
    </div>
    <?php
     $labels=array(6=>'Oxygen level is measured and find………………( 19.5% - 23.5% is available)',7=>'Flammable gases and vapours reading: ≤ 5% LEL',8=>'Toxic gases and vapours reading: ≤ PEL values',9=>'Inside temperature closed to room temperature and ambient air comfortable for working.',10=>'Recommended communication system',11=>'Safe Illumination provided (24-volt hand lamps)',12=>'Additional Measures.');
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
                              <input class="form-check-input confined_space" type="radio" 
                              value="y" name="confined_space[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                              value="n" name="confined_space[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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