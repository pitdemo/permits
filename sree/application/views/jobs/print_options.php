<?php
      if(!!$record_id && $is_loto==YES && $this->show_filter_form=='') { ?> 
    <div class="row row-cards">
            <div class="col-md-12" style="text-align:right;padding-bottom:5px;">
              <div class="col-sm-12">
                        <a href="javascript:void(0);" class="badge bg-pink text-pink-fg w-70 print_out electrical_shutdown" data-id="<?php echo $record_id; ?>" data-url="prints/electrical">
                          Print Shutdown
                        </a>
                       
              </div>
            </div>
    </div>
<?php } ?>