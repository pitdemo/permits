<?php
      if(!!$record_id) { ?> 
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

                        <a href="javascript:void(0);" class="badge bg-green text-green-fg w-70" data-id="<?php echo $record_id; ?>" data-bs-toggle="modal" data-bs-target="#modal-download">
                          Download
                        </a>
              </div>

              <div class="modal modal-blur fade" id="modal-download" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="log_title">Scrollable modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="log_text" align="left">
                      <a href="<?php echo base_url(); ?>uploads/permits/16/permit1742958931.pdf">Click Here</a> to download the PDF
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
    </div>
<?php } ?>