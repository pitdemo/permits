 <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="mb-3">
            <label class="form-label text-red">Scaffolding Erection & Dismantling:</label> 
            <?php
        $precautions_data=(isset($precautions['scaffoldings'])) ? explode(',',$precautions['scaffoldings']) : array();
        ?>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>" value="1">
                <span class="form-check-label">
                Presence of competent person assigned to ensure safe erection, maintenance, or modification of scaffolds. Name
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>" value="2">
                <span class="form-check-label">
                That person prior to use by personnel other than scaffolders inspects scaffold.
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>" value="3">
                <span class="form-check-label">
                Job Hazards is explained to all concern thru tool box talk meeting
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>" value="4">
                <span class="form-check-label">
                All pipes, clamps, H-frames, couplers, boards checked before assembly
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>" value="5">
                <span class="form-check-label">
                Scaffolds provided with proper access and egress
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>" value="6">
                <span class="form-check-label">
                Standard guardrail been used
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>" value="7">
                <span class="form-check-label">
                Platforms, walkways on scaffolds are wide of minimum of 900 mm wherever possible
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>" value="8">
                <span class="form-check-label">
                Precautions taken to ensure scaffolds are not overloaded
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>" value="9">
                <span class="form-check-label">
                Overhead protection provided where there is exposure
                </span>
            </label>  
            <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                name="precautions_scaffolding_additional_info"><?php echo (isset($precautions['precautions_scaffolding_additional_info'])) ? strtoupper($precautions["precautions_scaffolding_additional_info"]) : ''; ?></textarea>
            </label>
            </div>                                            
        </div>
        <div class="col-md-6 col-xl-6">
            <label class="form-label text-red">&nbsp;</label>   
            <div class="form-control-plaintext"><b>PPEs Provided</b></div>  
            <div class="mb-3">     
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>" value="10">
                    <span class="form-check-label">
                    No opening / Gap in the platform / walkway
                    </span>
                </label>   
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>" value="11">
                    <span class="form-check-label">
                    All component of the scaffold more than 12’ away from any exposed power lines
                    </span>
                </label>   
                
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>" value="12">
                    <span class="form-check-label">
                    Excavator is fit for the job
                    </span>
                </label>                                

                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?>" value="13">
                    <span class="form-check-label">
                    Safety Harness and Lanyard anchored to independent rigid object
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?>" value="14">
                    <span class="form-check-label">
                    Lifeline Rope 
                    </span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?>" value="15">
                    <span class="form-check-label">
                    Fall Arrestor with rope anchorage
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(16,$precautions_data)) ? "checked='checked'" : '' ?>" value="16">
                    <span class="form-check-label">
                    Full Body harness is used by all workmen engaged at height work.
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input scaffoldings" type="checkbox" name="precautions[5]"  <?php echo (in_array(17,$precautions_data)) ? "checked='checked'" : '' ?>" value="17">
                    <span class="form-check-label">
                    Safety net is provided but not less than 5 M from the work area.
                    </span>
                </label>
           </div>                                            
        </div>
</div>  