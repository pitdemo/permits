<div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="mb-3">
            <label class="form-label text-red">Scaffolding Erection & Dismantling:</label> 
            <?php
        $precautions_data=(isset($precautions['scaffoldings'])) ? json_decode($precautions['scaffoldings'],true) : array();

        $labels=array(1=>'Presence of competent person assigned to ensure safe erection, maintenance, or modification of scaffolds. Name',2=>'That person prior to use by personnel other than scaffolders inspects scaffold.',3=>'Job Hazards is explained to all concern thru tool box talk meeting',4=>'All pipes, clamps, H-frames, couplers, boards checked before assembly',5=>'Scaffolds provided with proper access and egress',6=>'Standard guardrail been used',7=>'Platforms, walkways on scaffolds are wide of minimum of 900 mm wherever possible',8=>'Precautions taken to ensure scaffolds are not overloaded',9=>'Overhead protection provided where there is exposure');

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
                                <input class="form-check-input scaffoldings" type="radio" 
                                value="y" name="scaffoldings[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                </label>
                                <label class="form-check form-check-inline">
                                <input class="form-check-input scaffoldings" type="radio" 
                                value="n" name="scaffoldings[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                name="precautions_scaffolding_additional_info"><?php echo (isset($precautions['precautions_scaffolding_additional_info'])) ? strtoupper($precautions["precautions_scaffolding_additional_info"]) : ''; ?></textarea>
            </label>
            
        </div>                                            
        </div>
        <?php
        $labels=array(10=>'No opening / Gap in the platform / walkway',11=>'All component of the scaffold more than 12’ away from any exposed power lines',12=>'Excavator is fit for the job',13=>'Safety Harness and Lanyard anchored to independent rigid object',14=>'Lifeline Rope ',15=>'Fall Arrestor with rope anchorage',16=>'Full Body harness is used by all workmen engaged at height work.',17=>'Safety net is provided but not less than 5 M from the work area.');

        ?>
        <div class="col-md-6 col-xl-6">
            
            
            <label class="form-label text-red">PPEs Provided</label> 
            <div class="mb-3">     
                            
            <table class="table mb-0" border="1">
                <tbody>
                        <tr>
                                <th width="2%" colspan="2">Yes <span style="padding-left:25px;">No</span></th>
                                <th width="9%">PPEs</th>
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
                                <input class="form-check-input scaffoldings" type="radio" 
                                value="y" name="scaffoldings[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                                </label>
                                <label class="form-check form-check-inline">
                                <input class="form-check-input scaffoldings" type="radio" 
                                value="n" name="scaffoldings[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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

                         <tr>
                            <td colspan="3">
                                        <label class="form-label">Scaffolding Tag No</label>
                                        <input type="text" class="form-control" name="scaffolding_tag_no" id="scaffolding_tag_no"  value="<?php echo (isset($precautions['scaffolding_tag_no'])) ? $precautions['scaffolding_tag_no'] : ''; ?>">

                                        <label class="form-label">Scaffolding Inspector Name</label>
                                        <input type="text" class="form-control" name="scaffolding_inspector_name" id="scaffolding_inspector_name"  value="<?php echo (isset($precautions['scaffolding_inspector_name'])) ? $precautions['scaffolding_inspector_name'] : ''; ?>">
                             </td>
                        </tr>
                </tbody>
            </table>
                
            
                 
           </div>                                            
        </div>
</div>  