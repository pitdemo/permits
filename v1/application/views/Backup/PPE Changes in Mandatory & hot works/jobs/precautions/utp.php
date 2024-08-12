<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">U T Pump:</label> 
            <?php
        $precautions_data=(isset($precautions['utp'])) ? json_decode($precautions['utp'],true) : array();
        $labels=array(1=>'Trained persons are deployed',2=>'Adequate water level in tank',3=>'Whiplash is provided to hose pipe',4=>'All hoses joints thread tightened properly',5=>'Pressure gauge is showing reading and marking provided – Yellow/Green/Red');

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
                              <input class="form-check-input utp" type="radio" 
                              value="y" name="utp[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input utp" type="radio" 
                              value="n" name="utp[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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

        </div>                                            
    </div> 
    <div class="col-md-6 col-xl-6">
        <div class="mb-3">
            <label class="form-label text-red">U T Pump:</label> 
            <?php
        $labels=array(8=>'Hoses are properly protected and barricaded',9=>'PPEs are adequate for working');
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
                              <input class="form-check-input utp" type="radio" 
                              value="y" name="utp[<?php echo $key; ?>]"  <?php echo $y_checked; ?>>
                              </label>
                              <label class="form-check form-check-inline">
                              <input class="form-check-input utp" type="radio" 
                              value="n" name="utp[<?php echo $key; ?>]"  <?php echo $n_checked; ?>>
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
                name="precautions_utp_additional_info"><?php echo (isset($precautions['precautions_utp_additional_info'])) ? strtoupper($precautions["precautions_utp_additional_info"]) : ''; ?></textarea>
            </label>
        </div>                                            
    </div> 
</div> 