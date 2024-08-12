<div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Electrical Work:</label>               
      
      <div class="form-control-plaintext"><b>LIVE ELECTRICAL WORK PERFORMED BY LICENCED ELECRTRICIAN ONLY</b></div>  
      <?php
        $precautions_data=(isset($precautions['electrical'])) ? explode(',',$precautions['electrical']) : array();
        ?>
      <label class="form-check  form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?> value="1">
            <span class="form-check-label">
            Obtained LOTOTO
            </span>
      </label>
      <label class="form-check  form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?> value="2">
            <span class="form-check-label">
            Power supply locked and tagged
            </span>
      </label>
      <label class="form-check  form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?> value="3">
            <span class="form-check-label">
            Circuit checked for zero voltage
            </span>
      </label>
      <label class="form-check  form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?> value="4">
            <span class="form-check-label">
            Portable cords and electric tools inspected
            </span>
      </label>
      <label class="form-check  form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?> value="5">
            <span class="form-check-label">
            Safety back-up man appointed
            </span>
      </label>
      <label class="form-check form-check-inline>
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?> value="6">
            <span class="form-check-label">
            Job Hazards is explained to all concern thru tool box talk meeting.
            </span>
      </label>
      <label class="form-check form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?> value="7">
            <span class="form-check-label">
            Physical isolation is ensured If yes, State the method
            </span>
      </label>
      <label class="form-check form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?> value="8">
            <span class="form-check-label">
            In case of lock applied, ensure the safe custody of the key
            </span>
      </label>
      <label class="form-check form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?> value="9">
            <span class="form-check-label">
            If physical isolation is not possible state, the alternative method of precaution
            </span>
      </label>   
      <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                value="" name="precautions_electrical_additional_info"><?php echo (isset($precautions['precautions_electrical_additional_info'])) ? strtoupper($precautions["precautions_electrical_additional_info"]) : ''; ?></textarea>
      </label>
      </div>                                            
      </div>
      <div class="col-md-6 col-xl-6">

      <label class="form-label text-red">&nbsp;</label>     
      <div class="form-control-plaintext"><b>Equipment Provided</b></div>  

      <div class="mb-3">
      
      <label class="form-check form-check-inline">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?> value="10">
            <span class="form-check-label">
            Approved rubber and leather gloves
            </span>
      </label>                                

      <label class="form-check">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?> value="11">
            <span class="form-check-label">
            Insulating mat
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?> value="12">
            <span class="form-check-label">
            Fuse puller
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?> value="13">
            <span class="form-check-label">
            Disconnect pole or safety rope
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?> value="14">
            <span class="form-check-label">
            Non-conductive hard hat
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input electrical" type="checkbox"  name="precautions[2]"  <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?> value="15">
            <span class="form-check-label">
            ELCB/RCCB is installed of 30 mA
            </span>
      </label>
      </div>                                            
      </div>
</div>