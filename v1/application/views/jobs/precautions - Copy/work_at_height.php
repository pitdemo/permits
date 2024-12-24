 <div class="row">
        <div class="col-md-6 col-xl-6">
            <div class="mb-3">
                <label class="form-label text-red">Work At Height:</label> 

                <?php
        $precautions_data=(isset($precautions['workatheights'])) ? explode(',',$precautions['workatheights']) : array();
        ?>

                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>" value="1">
                    <span class="form-check-label">
                    Only medically fit personnel engaged in work and list is available.
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>" value="2">
                    <span class="form-check-label">
                    Job Hazards is explained to all concern thru tool box talk meeting.
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>" value="3">
                    <span class="form-check-label">
                    Ladder(s) inspected prior to use
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>" value="4">
                    <span class="form-check-label">
                    Ladder properly supported and leveled
                    </span>
                </label>
                <label class="form-check form-check-inline" style="padding-left:60px;">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>" value="5">
                    <span class="form-check-label">
                    Secured at Top
                    </span>
                </label>
                <label class="form-check form-check-inline">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>" value="6">
                    <span class="form-check-label">
                    Secured at Bottom
                    </span>
                </label>     
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>" value="7">
                    <span class="form-check-label">
                    Distance between the ladder support and the ladder base is at least ¼ the total length of the ladder
                    </span>
                </label>   
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>" value="8">
                    <span class="form-check-label">
                    Ladder been provided with skid resistant feet
                    </span>
                </label>      
                <label class="form-check form-check-inline">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>" value="9">
                    <span class="form-check-label">
                    Scaffolds/platforms inspected for good repair and proper construction (secured flooring and guardrails)
                    </span>
                </label>    
                <label class="form-check form-check-inline">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>" value="10">
                    <span class="form-check-label">
                    Floor openings covered Guarded
                    </span>
                </label>          
                <label class="form-check">
                    <label class="form-label">Additional Info(If any)</label>
                    <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                    value="" name="precautions_workatheights_additional_info"><?php echo (isset($precautions['precautions_workatheights_additional_info'])) ? strtoupper($precautions["precautions_workatheights_additional_info"]) : ''; ?></textarea>
                </label>                        
            </div>                                            
        </div>

        <div class="col-md-6 col-xl-6">
            <label class="form-label text-red">&nbsp;</label>  
            <div class="mb-3">
                <label class="form-check form-check-inline">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>" value="11">
                    <span class="form-check-label">
                    Work area roped off and warning signs in place
                    </span>
                </label>
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>" value="12">
                    <span class="form-check-label">
                    Proper Housekeeping is done
                    </span>
                </label>  

                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?>" value="13">
                    <span class="form-check-label">
                    Personnel assigned to warn of floor opening or other hazardous exposure.
                    </span>
                </label>   
                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?>" value="14">
                    <span class="form-check-label">
                    Tools and other equipment stored in safe manner
                    </span>
                </label>   

                <label class="form-check">
                    <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?>" value="15">
                    <span class="form-check-label">
                    Area cleared below prior to starting work
                    </span>
                </label>   
                <div class="form-control-plaintext"><b>PPEs Provided</b></div>  
                        <label class="form-check form-check-inline">
                            <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(16,$precautions_data)) ? "checked='checked'" : '' ?>" value="16">
                            <span class="form-check-label">Safety Harness and Lanyard anchored to independent rigid object</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(17,$precautions_data)) ? "checked='checked'" : '' ?>" value="17">
                            <span class="form-check-label">Lifeline Rope</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(18,$precautions_data)) ? "checked='checked'" : '' ?>" value="18">
                            <span class="form-check-label">Fall Arrestor with rope anchorage</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(19,$precautions_data)) ? "checked='checked'" : '' ?>" value="19">
                            <span class="form-check-label">Full Body harness is used by all workmen engaged at height work.</span>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input workatheights" type="checkbox" name="precautions[3]"  <?php echo (in_array(20,$precautions_data)) ? "checked='checked'" : '' ?>" value="20">
                            <span class="form-check-label">Safety net is provided but not less than 5 M from the work area.</span>
                        </label>                       
            </div>
        </div>  
</div>        