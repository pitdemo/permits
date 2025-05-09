<?php
      if(!!$record_id) { ?> 
    <div class="row row-cards">
            <div class="col-md-12" style="text-align:right;padding-bottom:5px;">
              <div class="col-sm-12">
                        <a href="javascript:void(0);" class="badge bg-green text-green-fg w-70 open_download_model" data-id="<?php echo $record_id; ?>" data-bs-toggle="modal" data-bs-target="#modal-download">
                          Download PDF
                        </a>
              </div>
              <div class="modal modal-blur fade" id="modal-download" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="log_title">Download PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" id="log_text" align="left">

                        <div class="row row-cards">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label">PDF for</label>
                             
                              <label class="form-check form-check-inline">
                                  <input class="form-check-input pdf_for" type="radio" 
                                  value="P" name="pdf_for" checked data-url="prints/avi">AVI
                              </label>
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="mb-3">
                              <label class="form-label">PDF Type</label>
                             
                              <label class="form-check form-check-inline">
                                  <input class="form-check-input pdf_type" type="radio" 
                                  value="P" name="pdf_type" checked>Portrait
                              </label>

                              <label class="form-check form-check-inline">
                                  <input class="form-check-input pdf_type" type="radio" 
                                  value="L" name="pdf_type">Landscape
                              </label>
                             
                            </div>
                          </div>
                        </div>
                          
                        <div class="row row-cards">
                            <div class="col-md-12" id="pdf_response">
                           
                            </div>
                        </div>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn me-auto generate_pdf">Generate</button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
    </div>
<?php } ?>