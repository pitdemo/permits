<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
        <label class="form-label text-red">Mandatory measures to be taken for all type of works:</label>                                     
        <?php
        $precautions_data=(isset($precautions['precautions_mandatory'])) ? explode(',',$precautions['precautions_mandatory']) : array();
        ?>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]" value="1" <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Required usages of PPEs (Safety Helmet, Safety Shoes
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]" value="2" <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Enclose the list of persons carried out the job.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="3" <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Five Minutes Safety Talk conducted (record to be maintained).
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="4" <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Equipment/work area inspected.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="5" <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Portable Fire Fighting system readiness.
                </span>
        </label>        
        <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                value="" name="precautions_mandatory_additional_info"><?php echo (isset($precautions['precautions_mandatory_additional_info'])) ? strtoupper($precautions["precautions_mandatory_additional_info"]) : ''; ?></textarea>
        </label>

        
        </div>                                            
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
        <label class="form-label text-red">&nbsp;</label>         
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="6" <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Tools & Tackles Checked.
                </span>
        </label>                            

        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="7" <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                The place of work is made accessible and proper aggress.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="8" <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Barricading and cordoning of the area.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="9" <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Loose dresses are to be avoided or tight properly while working near conveyors or rotating equipment’s.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="10" <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Sufficient safe lighting facility provided.
                </span>
        </label>
        <label class="form-check">
                <input class="form-check-input precautions_mandatory" type="checkbox" name="precautions[m]"  value="11" <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">
                Deputed Skilled Supervisor
                </span>
        </label>

        
        </div>                                            
    </div>
</div>  