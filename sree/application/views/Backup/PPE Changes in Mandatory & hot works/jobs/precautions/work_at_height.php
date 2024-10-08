 <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="mb-3">
                <label class="form-label text-red">Work At Height:</label> 

        <?php
        $precautions_data=(isset($precautions['workatheights'])) ? json_decode($precautions['workatheights'],true) : array();

        
        $a=1;

        $labels=array(1=>'Only medically fit personnel engaged in work and list is available.',2=>'Job Hazards is explained to all concern thru tool box talk meeting.',3=>'Ladder(s) inspected prior to use',4=>'Ladder properly supported and leveled',5=>'Secured at Top',6=>'Secured at Bottom',6=>'Distance between the ladder support and the ladder base is at least ¼ the total length of the ladder',7=>'Ladder been provided with skid resistant feet',8=>'Scaffolds/platforms inspected for good repair and proper construction (secured flooring and guardrails)',9=>'Floor openings covered Guarded',10=>'Work area roped off and warning signs in place',11=>'Proper Housekeeping is done');
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
         $labels=array(12=>'Personnel assigned to warn of floor opening or other hazardous exposure.',13=>'Tools and other equipment stored in safe manner',14=>'Area cleared below prior to starting work',15=>'Safety Harness and Lanyard anchored to independent rigid object',16=>'Lifeline Rope',17=>'Fall Arrestor with rope anchorage',18=>'Full Body harness is used by all workmen engaged at height work.',19=>'Safety net is provided but not less than 5 M from the work area.');
         ?>
        <div class="col-md-6 col-xl-6">
        
            <div class="mb-3">
            <label class="form-label text-red">PPEs Provided</label> 
                <table class="table mb-0" border="1">
                        <tbody>
                                <tr>
                                    <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                    <th width="9%">PPE's</th>
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