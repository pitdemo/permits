  <div class="row">
      <div class="col-md-6 col-xl-6">
      <div class="mb-3">
      <label class="form-label text-red">Excavation (irrespective of depth):</label> 
      <?php
        $precautions_data=(isset($precautions['excavations'])) ? explode(',',$precautions['excavations']) : array();
        ?>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(1,$precautions_data)) ? "checked='checked'" : '' ?>" value="1">
            <span class="form-check-label">
            Contractor has a competent person assigned to inspect & control condition of excavation on site
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(2,$precautions_data)) ? "checked='checked'" : '' ?>" value="2">
            <span class="form-check-label">
            Underground utilities identified
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(3,$precautions_data)) ? "checked='checked'" : '' ?>" value="3">
            <span class="form-check-label">
            Power equipment grounded
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(4,$precautions_data)) ? "checked='checked'" : '' ?>" value="4">
            <span class="form-check-label">
            Electrical or mechanical overhead clearances checked
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(5,$precautions_data)) ? "checked='checked'" : '' ?>" value="5">
            <span class="form-check-label">
            Hard / Soft Barricades, area warning placed
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(6,$precautions_data)) ? "checked='checked'" : '' ?>" value="6">
            <span class="form-check-label">
            Means of egress (ladder or steps) placed
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(7,$precautions_data)) ? "checked='checked'" : '' ?>" value="7">
            <span class="form-check-label">
            Side walls shored or laid back  
            </span>
      </label>
      
      <label class="form-check">
                <label class="form-label">Additional Info(If any)</label>
                <textarea rows="3" class="form-control" placeholder="Here can be your additional info"
                value="" name="precautions_excavations_additional_info"><?php echo (isset($precautions['precautions_excavations_additional_info'])) ? strtoupper($precautions["precautions_excavations_additional_info"]) : ''; ?></textarea>
      </label>
      </div>                                            
      </div>
      <div class="col-md-6 col-xl-6">

      <label class="form-label text-red">&nbsp;</label>   
      <div class="mb-3">
      
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(8,$precautions_data)) ? "checked='checked'" : '' ?>" value="8">
            <span class="form-check-label">
            Area adequately lighted
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(9,$precautions_data)) ? "checked='checked'" : '' ?>" value="9">
            <span class="form-check-label">
            Material or soil removed from excavation edge
            </span>
      </label>   
      
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(10,$precautions_data)) ? "checked='checked'" : '' ?>" value="10">
            <span class="form-check-label">
            Excavator is fit for the job
            </span>
      </label>                                

      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(11,$precautions_data)) ? "checked='checked'" : '' ?>" value="11">
            <span class="form-check-label">
            Banksman provided to guide the operator
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(12,$precautions_data)) ? "checked='checked'" : '' ?>" value="12">
            <span class="form-check-label">
            Method of dewatering is established and ensured the stoppage of water return
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(13,$precautions_data)) ? "checked='checked'" : '' ?>" value="13">
            <span class="form-check-label">
            Excavated pit edges free from heavy over-burden, stack of materials
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(14,$precautions_data)) ? "checked='checked'" : '' ?>" value="14">
            <span class="form-check-label">
            People are prevented from working inside pits if heavy vehicle movement in the vicinity due to which soil collapse may take place
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(15,$precautions_data)) ? "checked='checked'" : '' ?>" value="15">
            <span class="form-check-label">
            Job Hazards is explained to all concern thru tool box talk meeting.
            </span>
      </label>
      <label class="form-check">
            <input class="form-check-input excavations" type="checkbox" name="precautions[9]"  <?php echo (in_array(16,$precautions_data)) ? "checked='checked'" : '' ?>" value="16">
            <span class="form-check-label">
            Additional measures
            </span>
      </label>
      </div>                                            
      </div>
</div>  