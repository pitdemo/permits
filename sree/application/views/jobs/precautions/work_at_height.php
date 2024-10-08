 <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="mb-3">
                <label class="form-label text-red">Work At Height:</label> 

        <?php
        $precautions_data=(isset($precautions['workatheights'])) ? json_decode($precautions['workatheights'],true) : array();

        
        $a=1;

        $labels=array(1=>'Is any overhead Electrical line passing through working area?',2=>'Safe work platform/ scaffolding of sound construction provided',3=>'Only medically fit personnel engaged in work. ',4=>'All employees trained for working at height.',5=>'Job Hazards is explained to all concern thru tool box talk meeting.',6=>'Ladder(s) inspected prior to use',6=>'Ladder properly supported and leveled',7=>'Scaffolds/platforms inspected for good repair and proper construction',8=>'Area below work place cleared off / cordon off with safety tape',9=>'Nos./ Roof safe walk ladder provided to work/ walk on fragile roof top and use shall be ensured.');
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
                                    <input class="form-check-input workatheights" type="radio" 
                                    value="y" name="workatheights[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                    </label>
                                    <label class="form-check form-check-inline">
                                    <input class="form-check-input workatheights" type="radio" 
                                    value="n" name="workatheights[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
        <?php
         $labels=array(10=>'All lifting tools / tackles and lifting machines to be used are checked and found in order',11=>'Hand tools/ portable power tools have been checked (including earthing) and found in order',12=>'Provision of safety net below the job in sound condition',13=>'Safety Harness and Lanyard anchored to independent rigid object ',14=>'No of personal protective appliances like full body harness tested of competent person  (ISI mark) having identification  Nos…………  provided to all the persons working at height and use shall be ensured.',15=>'Cell phone (Mobile) not to be carried by the workmen while work at height. ');
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
                                    <input class="form-check-input workatheights" type="radio" 
                                    value="y" name="workatheights[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                    </label>
                                    <label class="form-check form-check-inline">
                                    <input class="form-check-input workatheights" type="radio" 
                                    value="n" name="workatheights[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                        name="precautions_workatheights_additional_info"><?php echo (isset($precautions['precautions_workatheights_additional_info'])) ? strtoupper($precautions["precautions_workatheights_additional_info"]) : ''; ?></textarea>
                    </label>    

            </div>
        </div>  
</div>        