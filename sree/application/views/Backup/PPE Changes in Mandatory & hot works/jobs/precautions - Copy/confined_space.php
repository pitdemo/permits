<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">Confined Space Entry:</label> 
            <?php
        $precautions_data=(isset($precautions['confined_space'])) ? explode(',',$precautions['confined_space']) : array();
        ?>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>" value="1">
                <span class="form-check-label">
                Equipment properly drained / Depressurized
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>" value="2">
                <span class="form-check-label">
                Disconnected Inlet, Outlet lines and isolate equipment
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>" value="3">
                <span class="form-check-label">
                Vent / Manholes are kept open to maintain proper ventilation
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>" value="4">
                <span class="form-check-label">
                Only trained personnel were engaged & register was maintained for entry & exit of person with time.
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>" value="5">
                <span class="form-check-label">
                Standby Personnel/Entry supervisor,. is available
                </span>
            </label>
            
            <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                value="" name="precautions_confined_additional_info"><?php echo (isset($precautions['precautions_confined_additional_info'])) ? strtoupper($precautions["precautions_confined_additional_info"]) : ''; ?></textarea>
            </label>                                      
        </div>                                            
    </div>
    <div class="col-md-6 col-xl-6">
        <label class="form-label text-red">&nbsp;</label>  
        <div class="mb-3">
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>" value="6">
                <span class="form-check-label">
                Oxygen level is measured and find………………( 19.5% - 23.5% is available)
                </span>
            </label>     
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>" value="7">
                <span class="form-check-label">
                Flammable gases and vapours reading: ≤ 5% LEL
                </span>
            </label>  
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>" value="8">
                <span class="form-check-label">
                Toxic gases and vapours reading: ≤ PEL values
                </span>
            </label>
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>" value="9">
                <span class="form-check-label">
                Inside temperature closed to room temperature and ambient air comfortable for working.
                </span>
            </label>  
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>" value="10">
                <span class="form-check-label">
                Recommended communication system
                </span>
            </label>   
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>" value="11">
                <span class="form-check-label">
                Safe Illumination provided (24-volt hand lamps)
                </span>
            </label>   
            
            <label class="form-check">
                <input class="form-check-input confined_space" type="checkbox" name="precautions[7]"  <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>" value="12">
                <span class="form-check-label">
                Additional Measures.
                </span>
            </label>   
        </div>                                            
    </div>
</div>  