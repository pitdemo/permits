<?php

$pdf_types=array('P'=>'Portrait','L'=>'Landscape');


      if(!!$record_id) { ?> 
    <div class="row row-cards">
            <div class="col-md-12" style="text-align:right;padding-bottom:5px;">
              <div class="col-sm-12">
                        <a href="javascript:void(0);" class="badge bg-green text-green-fg w-70 generate_pdf" data-id="<?php echo $record_id; ?>" data-bs-toggle="modal" data-bs-target="#modal-download">
                          Download Certificate
                        </a>
              </div>
            </div>
    </div>
<?php } ?>