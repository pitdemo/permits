<?php
      if(!!$record_id) { ?> 
    <div class="row row-cards">
            <div class="col-md-12" style="text-align:right;padding-bottom:5px;visibility:<?php echo $final_status_date=='' ? 'hidden': ''; ?>;">
              <div class="col-sm-12">
                        <a href="javascript:void(0);" class="badge bg-pink text-pink-fg w-70 print_out" data-id="<?php echo $record_id; ?>" data-url="jobs/printout">
                          Print PTW
                        </a>
                        <a href="#" class="badge bg-indigo text-indigo-fg print_out" data-id="<?php echo $record_id; ?>"  data-url="jobs/printoutwpra">
                          Print WPRA
                        </a>
              </div>
            </div>
    </div>
<?php } ?>