<div class="row">
    <div class="col-md-4 col-xl-4">
        <div class="mb-3">
        <label class="form-label text-red">Mandatory measures to be taken for all type of works:</label>                                     
        <?php
        $precautions_data=(isset($precautions['precautions_mandatory'])) ? json_decode($precautions['precautions_mandatory'],true) : array();
        
        $labels = array('Required usages of PPEs (Safety Helmet, Safety Shoes','Enclose the list of persons carried out the job.','Five Minutes Safety Talk conducted (record to be maintained).','Equipment/work area inspected.','Equipment electrically isolated. If YES, line clearance Permit No:','Portable Fire Fighting system readiness.');
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
        <label class="form-check" style="padding-left:0px;">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                value="" name="precautions_mandatory_additional_info"><?php echo (isset($precautions['precautions_mandatory_additional_info'])) ? strtoupper($precautions["precautions_mandatory_additional_info"]) : ''; ?></textarea>
        </label>
        </div>                                            
    </div>
    <?php
    $labels=array('Tools & Tackles Checked.','The place of work is made accessible and proper aggress.','Barricading and cordoning of the area.','Loose dresses are to be avoided or tight properly while working near conveyors or rotating equipment’s.','Sufficient safe lighting facility provided.','Deputed Skilled Supervisor');
    ?>
    <div class="col-md-4 col-xl-4">
        <div class="mb-3">
        <label class="form-label text-red">&nbsp;</label>         
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
        </div>                                            
    </div>


    <?php
        $labels=array('Safety shoes & Helmet,Eye protection','Leather Hand gloves','ABLeather ApronC','Hand Gloves','Leg Guard','Welding Goggles for Helper','Nose Mask');
        ?>
    <div class="col-md-4 col-xl-4">
        <div class="mb-3">
            <label class="form-label text-red">&nbsp;</label>  
            <table class="table mb-0" border="1">
                <tbody>
                            <tr>
                                    <th width="4%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                    <th width="7%">PPEs Provided</th>
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
                                $disabled='';
                                if($key==0){
                                    $y_checked="checked='checked'";
                                    $disabled='disabled';
                                }
                            ?>
                            <tr>
                                            <td colspan="2"> 
                                            <label class="form-check form-check-inline">
                                            <input class="form-check-input precautions_mandatory" type="radio" 
                                            value="y" name="precautions_mandatory[<?php echo $a; ?>]"  <?php echo $y_checked; ?> <?php echo $disabled; ?>>
                                            </label>
                                            <label class="form-check form-check-inline">
                                            <input class="form-check-input precautions_mandatory" type="radio" 
                                            value="n" name="precautions_mandatory[<?php echo $a; ?>]"  <?php echo $n_checked; ?>  <?php echo $disabled; ?>>
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
    <span style="display:none;" id="precautions_mandatory_total"><?php echo ($a-1); ?></span> 
</div>  