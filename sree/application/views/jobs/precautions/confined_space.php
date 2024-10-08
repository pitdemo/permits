<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="mb-3">
        <label class="form-label text-red">OBJECTIVE:  FOR PERMITTING ENTRY TO WORK IN VESSELS & CONFINED SPACES:</label>   
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">Confined Space Entry:</label> 
        <?php
        $precautions_data=(isset($precautions['confined_space'])) ? json_decode($precautions['confined_space'],true) : array(6);
        $oxygen_readings=(isset($precautions['oxygen_readings'])) ? $precautions['oxygen_readings'] : '';
        $gases_readings=(isset($precautions['gases_readings'])) ? $precautions['gases_readings'] : '';
        $carbon_readings=(isset($precautions['carbon_readings'])) ? $precautions['carbon_readings'] : '';
        $labels=array(1=>'Connecting pipe lines blinded / Disconnected for isolation and tagged',2=>'Vent / Manholes are kept open to maintain proper ventilation',3=>'Vessel properly depressurised and drained.',4=>'Vessel gas freed and cooled.',5=>'No Overhead Coating seen inside the Vessel.',6=>'Provision for venting made (exhaust fan at manhole).',7=>'Only trained personnel were engaged & register was maintained for entry & exit of person with time. ',8=>'Standby Personnel/Entry supervisor,. is available');
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
                              $disabled='';
                              if($key==6){
                                $y_checked="checked='checked'";
                                $disabled='disabled';
                             }

                        ?>
                        <tr>
                              <td colspan="2"> 
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                                $disabled='disabled';
                                value="y" name="confined_space[<?php echo $key; ?>]" <?php echo $disabled; ?>  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input confined_space" type="radio" 
                              value="n" name="confined_space[<?php echo $key; ?>]" <?php echo $disabled; ?> <?php echo $n_checked; ?>>
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
   
     $labels=array(9=>'Oxygen level is measured and find <input type="text" class="form-control" name="oxygen_readings" id="oxygen_readings" value="'.$oxygen_readings.'">( 19.5% - 23.5% is available)',10=>'Flammable gases and vapours reading ≤ 5% LEL',11=>'Air hose draft provided',11=>'Hand lamp 24 volt provided',12=>'Fire control: water hose, extinguisher, fire staff arranged.',13=>'Spl. instruction if any, complied as under.............................................',14=>'Approach to inside work place: rope ladder, cage etc. provided',15=>'Emergency exit provided',16=>'Protective appliances: safety belt, helmet, gloves, breathing mask etc. provided.');
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