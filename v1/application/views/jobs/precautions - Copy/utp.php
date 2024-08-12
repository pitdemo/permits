<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="mb-3">
            <label class="form-label text-red">U T Pump:</label> 
            <?php
        $precautions_data=(isset($precautions['utp'])) ? explode(',',$precautions['utp']) : array();
        ?>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>" value="1">
                <span class="form-check-label">
                Trained persons are deployed
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>" value="2">
                <span class="form-check-label">
                Adequate water level in tank
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>" value="3">
                <span class="form-check-label">
                Whiplash is provided to hose pipe
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>" value="4">
                <span class="form-check-label">
                All hoses joints thread tightened properly
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>" value="5">
                <span class="form-check-label">
                Pressure gauge is showing reading and marking provided – Yellow/Green/Red
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>" value="6">
                <span class="form-check-label">
                Pump is earthed
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>" value="7">
                <span class="form-check-label">
                Jet gun connected properly and dead man switch functioning
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>" value="8">
                <span class="form-check-label">
                Hoses are properly protected and barricaded
                </span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input utp" type="checkbox" name="precautions[6]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>" value="9">
                <span class="form-check-label">
                PPEs are adequate for working
                </span>
            </label>  
            <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                name="precautions_utp_additional_info"><?php echo (isset($precautions['precautions_utp_additional_info'])) ? strtoupper($precautions["precautions_utp_additional_info"]) : ''; ?></textarea>
            </label>
        </div>                                            
    </div> 
</div> 