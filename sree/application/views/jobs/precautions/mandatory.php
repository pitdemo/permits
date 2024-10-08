<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="mb-3">
        <label class="form-label text-red">OBJECTIVE:  FOR PERMITTING GENERAL REPAIR/ MAINTENANCE WORK ON STRUCTURES/ EQUIPMENT:</label>   
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
                                  
        <?php
        $precautions_data=(isset($precautions['precautions_mandatory'])) ? json_decode($precautions['precautions_mandatory'],true) : array();
        
        $labels = array('Area free from slippery/ combustibles materials','Equipment depressurized, drained, flushed/ purged','Venting and adequate lighting arranged','Hand tools/ portable power tools have been checked (including earthing) & found in order.','Safe approach to work area/ temporary working platform of sound health provided.');
        $a=1;
        ?>

        <table class="table mb-0" border="1">
            <tbody>
                        <tr>
                                <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                <th width="5%">Precautions</th>
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
                                        <input class="form-check-input precautions_mandatory" type="radio" 
                                         value="y" name="precautions_mandatory[<?php echo $a; ?>]" <?php echo $y_checked; ?>>
                                        </label>
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input precautions_mandatory" type="radio" 
                                         value="n" name="precautions_mandatory[<?php echo $a; ?>]" <?php echo $n_checked; ?>>
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
    $labels=array('Safety appliances like gas mask, breathing apparatus, helmet, goggles, face shield, gloves, apron etc. provided and their use ensured.','Job Hazards is explained to all concern thru tool box talk meeting','Electrical connections through ELCB/RCCB of 30 mA sensitivity');
    ?>
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
        
        <table class="table mb-0" border="1">
            <tbody>
                        <tr>
                                <th width="4%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                <th width="7%">Precautions</th>
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
                                        <input class="form-check-input precautions_mandatory" type="radio" 
                                         value="y" name="precautions_mandatory[<?php echo $a; ?>]" <?php echo $y_checked; ?>>
                                        </label>
                                        <label class="form-check form-check-inline">
                                        <input class="form-check-input precautions_mandatory" type="radio" 
                                         value="n" name="precautions_mandatory[<?php echo $a; ?>]" <?php echo $n_checked; ?>>
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
                value="" name="precautions_mandatory_additional_info"><?php echo (isset($precautions['precautions_mandatory_additional_info'])) ? strtoupper($precautions["precautions_mandatory_additional_info"]) : ''; ?></textarea>
        </label>
        </div>                                            
    </div>
    <span style="display:none;" id="precautions_mandatory_total"><?php echo ($a-1); ?></span> 
</div>  