 <div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">Hot Work (Welding, Grinding, Cutting):</label>  
            <?php
        $precautions_data=(isset($precautions['hotworks'])) ? explode(',',$precautions['hotworks']) : array();
        ?>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="1" <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Flammables / Combustibles/ Explosive material removed / protected. (> 35ft.)
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="2" <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Fire Watch Established
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="3" <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Welding & Cutting equipment positioned properly
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="4" <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Leads up and do not pose a tripping hazard
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="5" <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Area hazards reviewed
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="6" <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Electrical connections through ELCB/RCCB of 30 mA sensitivity
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="7" <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Electrical equipment’s are free from damage and earthed properly
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="8" <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Performer's are competent and equipped with appropriate PPEs i.e. including face shield / welding goggles / apron, safety shoes etc.
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="9" <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    No tampering / manipulation attempted in safety device of the equipment’s
                    </span>
            </label>   
            <div class="form-control-plaintext"><b>Fire Precautions Taken</b></div>  
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="10" <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Area wet down</span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="11" <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Spark shields installed</span>
            </label>                               
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="12" <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Fire blanket</span>
            </label>  
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="13" <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Fire Fighting arrangements provided:
                    </span>
            </label>
            <label class="form-check form-check-inline" style="margin-left:25px">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="14" <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">CO2</span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="15" <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Dry Chemical Powder</span>
            </label>                               
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="16" <?php echo (in_array(16,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">ABC</span>
            </label>  
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="17" <?php echo (in_array(17,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Fire Tender</span>
            </label>
            <label class="form-check form-check-inline" style="margin-left:25px;">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="18" <?php echo (in_array(18,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Fire hose connected to hydrant</span>
            </label>  

            <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                 name="precautions_hotworks_additional_info"><?php echo (isset($precautions['precautions_hotworks_additional_info'])) ? strtoupper($precautions["precautions_hotworks_additional_info"]) : ''; ?></textarea>
            </label>
            
        </div>                                            
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">&nbsp;</label>     
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="20" <?php echo (in_array(20,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Only industrial type electrical appliances are in use
                    </span>
            </label>   
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="21" <?php echo (in_array(21,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Cables / fuses are of adequate size & capacity fit with the requirement
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="22" <?php echo (in_array(22,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    No cable joint within 1 Mtr. from the holder / grinding machine and completely insulated from with M/C body
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="23" <?php echo (in_array(23,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Gas cylinders used: Oxygen / Industrial LPG / Dissolved Acetylene
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="24" <?php echo (in_array(24,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Gas cutting torch of reputed make, ISI marked, installed with Back Fire and Flashback arrestors are in use at both ends
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="25" <?php echo (in_array(25,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Hoses are free from damage and connected with hose clamp.
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="26" <?php echo (in_array(26,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Regulator pressure gauges in working condition, visible and not damaged.
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="27" <?php echo (in_array(27,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Welding cable and earthing cable are crimped with proper size lugs.
                    </span>
            </label>
            <label class="form-check">
                    <input class="form-check-input hotworks" type="checkbox" name="precautions[4]"value="28" <?php echo (in_array(28,$precautions_data)) ? "checked='checked'" : '' ?>>
                    <span class="form-check-label">
                    Job Hazards is explained to all concern thru tool box talk meeting
                    </span>
            </label>
            
            <div class="form-control-plaintext"><b>PPEs Provided</b></div>  
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="29" <?php echo (in_array(29,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Welding Helmet</span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="30" <?php echo (in_array(30,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Leather Hand gloves</span>
            </label>                               
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="31" <?php echo (in_array(31,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">ABLeather ApronC</span>
            </label>  
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="32" <?php echo (in_array(32,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Hand Sleeves</span>
            </label>
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="33" <?php echo (in_array(33,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Leg Guard</span>
            </label>                               
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="34" <?php echo (in_array(34,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Welding Goggles for Helper</span>
            </label>  
            <label class="form-check form-check-inline">
                <input class="form-check-input hotworks" type="checkbox" name="precautions[4]" value="35" <?php echo (in_array(35,$precautions_data)) ? "checked='checked'" : '' ?>>
                <span class="form-check-label">Nose Mask</span>
            </label>     
        </div>                                            
    </div>
</div>                           