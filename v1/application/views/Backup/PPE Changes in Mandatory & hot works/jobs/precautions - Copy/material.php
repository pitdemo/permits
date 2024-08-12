  <div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Material lowering & lifting:</label>                                     
      <?php
        $precautions_data=(isset($precautions['materials'])) ? explode(',',$precautions['materials']) : array();
        ?>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"  name="precautions[10]" value="1"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Safety devices of the lifting appliances are inspected before use
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="2" <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Operator qualified and medically fit including eye sight examined by authority
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="3" <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Lifting appliances are certified by competent authority and labeled properly.
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="4" <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Hoist chain or hoist rope free of kinks or twists and not wrapped around the load.
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="5" <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Lifting Hook has a Safety Hook Latch that will prevent the rope from slipping out.
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="6" <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Lifting gears operator been instructed not to leave the load suspended
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="7" <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Electrical equipment’s are free from damage and earthed properly
            </span>
      </label>



      <label class="form-check form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="8" <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Electrical power line clearance (12ft) checked
            </span>
      </label>
      <label class="form-check form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="9" <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Signal man identified
            </span>
      </label>   

      <label class="form-check form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="10" <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">Outriggers supported, Crane leveled</span>
      </label>
      <label class="form-check form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="11" <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">SLI/ Load chart available in the crane</span>
      </label>                               
      <label class="form-check form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="12" <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">Barrier Installed</span>
      </label>  
      <label class="form-check  form-check-inline">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="13" <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Riggers are competent
            </span>
      </label>

      <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                 name="precautions_material_additional_info"><?php echo (isset($precautions['precautions_material_additional_info'])) ? strtoupper($precautions["precautions_material_additional_info"]) : ''; ?></textarea>
      </label>

      </div>                                            
      </div>
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">&nbsp;</label>     
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="14" <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Slings are inspected for free from cut marks, pressing, denting, bird caging, twist, kinks or core protrusion prior to use.
            </span>
      </label>                                

      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="15" <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Slings mechanically spliced (Hand spliced slings may not be allowed)
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="16" <?php echo (in_array(16,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            D / Bow shackles are free from any crack, dent, distortion or weld mark, wear / tear
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="17" <?php echo (in_array(17,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Special lift as per erection / lift plan
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="18" <?php echo (in_array(18,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Job Hazards is explained to all concern thru tool box talk meeting
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="19" <?php echo (in_array(19,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Guide rope is provided while shifting / lifting/lowering the load.
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="20" <?php echo (in_array(20,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Daily inspection checklist followed and maintained for crane
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="21" <?php echo (in_array(21,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            SWL displayed
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input materials"" type="checkbox"   name="precautions[10]" value="22" <?php echo (in_array(22,$precautions_data)) ? "checked='checked'" : '' ?>>
            <span class="form-check-label">
            Wind velocity < 36 KMPH, No rain
            </span>
      </label>
      </div>                                            
      </div>
  </div>  