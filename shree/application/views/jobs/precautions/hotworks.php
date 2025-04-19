 <div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">Hot Work (Welding, Grinding, Cutting):</label>  
            <?php
        $precautions_data=(isset($precautions['hotworks'])) ? json_decode($precautions['hotworks'],true) : array();
        $labels=array('Flammables / Combustibles/ Explosive material removed / protected. (> 35ft.)','Fire Watch Established','Welding & Cutting equipment positioned properly','Leads up and do not pose a tripping hazard','Area hazards reviewed','Electrical connections through ELCB/RCCB of 30 mA sensitivity','Electrical equipment’s are free from damage and earthed properly','Performer\'s are competent and equipped with appropriate PPEs i.e. including face shield / welding goggles / apron, safety shoes etc.',' No tampering / manipulation attempted in safety device of the equipment’s');
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
                                $data = (isset($precautions_data[$a])) ? $precautions_data[$a] : '';

                                $y_checked = $data=='y' ? "checked='checked'" : '';
                                $n_checked = $data=='n' ? "checked='checked'" : '';
                            }

                        ?>
                        <tr>
                                        <td colspan="2"> 
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input hotworks" type="radio" 
                                         value="y" name="hotworks[<?php echo $a; ?>]"  <?php echo $y_checked; ?>>
                                        </label>
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input hotworks" type="radio" 
                                         value="n" name="hotworks[<?php echo $a; ?>]"  <?php echo $n_checked; ?>>
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

        <?php
        $labels=array('Area wet down','Spark shields installed','Fire blanket');

        ?>
           
            <div class="form-control-plaintext"><b>Fire Precautions Taken</b></div>  

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
                                $data = (isset($precautions_data[$a])) ? $precautions_data[$a] : '';

                                $y_checked = $data=='y' ? "checked='checked'" : '';
                                $n_checked = $data=='n' ? "checked='checked'" : '';
                            }

                        ?>
                        <tr>
                            <td colspan="2"> 
                            <label class="form-check form-check-inline">
                            <input class="form-check-input hotworks" type="radio" 
                                value="y" name="hotworks[<?php echo $a; ?>]"  <?php echo $y_checked; ?>>
                            </label>
                            <label class="form-check form-check-inline">
                            <input class="form-check-input hotworks" type="radio" 
                                value="n" name="hotworks[<?php echo $a; ?>]"  <?php echo $n_checked; ?>>
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
            <textarea rows="4" class="form-control" placeholder="Here can be your additional info"
                name="precautions_hotworks_additional_info"><?php echo (isset($precautions['precautions_hotworks_additional_info'])) ? strtoupper($precautions["precautions_hotworks_additional_info"]) : ''; ?></textarea>
        </label>
           

       
            
        </div>                                            
    </div>
    <?php
    $labels=array('Only industrial type electrical appliances are in use','Cables / fuses are of adequate size & capacity fit with the requirement','No cable joint within 1 Mtr. from the holder / grinding machine and completely insulated from with M/C body','Gas cylinders used: Oxygen / Industrial LPG / Dissolved Acetylene','Gas cutting torch of reputed make, ISI marked, installed with Back Fire and Flashback arrestors are in use at both ends','Hoses are free from damage and connected with hose clamp.','Regulator pressure gauges in working condition, visible and not damaged.','Welding cable and earthing cable are crimped with proper size lugs.','Job Hazards is explained to all concern thru tool box talk meeting');
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
                                $data = (isset($precautions_data[$a])) ? $precautions_data[$a] : '';

                                $y_checked = $data=='y' ? "checked='checked'" : '';
                                $n_checked = $data=='n' ? "checked='checked'" : '';
                            }

                        ?>
                        <tr>
                            <td colspan="2"> 
                            <label class="form-check form-check-inline">
                            <input class="form-check-input hotworks" type="radio" 
                                value="y" name="hotworks[<?php echo $a; ?>]"  <?php echo $y_checked; ?>>
                            </label>
                            <label class="form-check form-check-inline">
                            <input class="form-check-input hotworks" type="radio" 
                                value="n" name="hotworks[<?php echo $a; ?>]"  <?php echo $n_checked; ?>>
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

        

        <?php
        $labels=array('CO2','Dry Chemical Powder','ABC','Fire Tender','Fire hose connected to hydrant');
        ?>
        <div class="form-control-plaintext"><b>Fire Fighting arrangements provided:</b></div>  
        
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
                                $data = (isset($precautions_data[$a])) ? $precautions_data[$a] : '';

                                $y_checked = $data=='y' ? "checked='checked'" : '';
                                $n_checked = $data=='n' ? "checked='checked'" : '';
                            }

                        ?>
                        <tr>
                                        <td colspan="2"> 
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input hotworks" type="radio" 
                                         value="y" name="hotworks[<?php echo $a; ?>]"  <?php echo $y_checked; ?>>
                                        </label>
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input hotworks" type="radio" 
                                         value="n" name="hotworks[<?php echo $a; ?>]"  <?php echo $n_checked; ?>>
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