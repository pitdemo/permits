<?php
      if(!!$record_id && $this->show_filter_form=='') { ?> 
    <div class="row row-cards">
            <div class="col-md-12" style="text-align:right;padding-bottom:5px;">
              <div class="col-sm-12">
                        <?php
                        if($is_loto==YES){ ?>
                        <a href="javascript:void(0);" class="badge bg-pink text-pink-fg w-70 print_out electrical_shutdown" data-id="<?php echo $record_id; ?>" data-url="prints/electrical">
                          Print Shutdown
                        </a>
                        <?php } ?>

                        <a href="javascript:void(0);" class="badge bg-green text-green-fg w-70 print_out" data-id="<?php echo $record_id; ?>" data-url="prints/printout">
                          Print WP
                        </a>
                       
              </div>
            </div>
    </div>
<?php } ?>