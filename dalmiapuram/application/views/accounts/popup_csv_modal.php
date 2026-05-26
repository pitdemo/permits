<div  class="modal fade" id="myModal" >
  <div class="modal-dialog">
  
  <form method="post" id="import" enctype="application/x-www-form-urlencoded">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import Matched Data</h4>
              </div>
              <div class="modal-body">
              	
                	<div class="row" id="show_response_msg" style="display:none;">
                         <div class="col-lg-12 col-md-2 col-sm-4 col-xs-6">	
                    		<div class="alert alert-danger show_msg">
								<button data-dismiss="alert" class="close" type="button">x</button>
								<span id="response_csv_msg"></span>
							</div>
                          </div>  
                    </div>
              
              
                        <div class="row">
                                            <div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label">Upload*</label>
                                                    <input type="file" name="import_file" id="import_file" accept="application/msexcel" />
                                                    <span class="error">Upload csv file only</span><br />
													
                                                </div>
                                            </div>
                                            
                                          <div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label"></label>
                                                 <span><br /> Sample csv file <a target="_blank" href="<?php echo base_url(); ?>sampleAccounts.csv">Download</a></span>
                                                 </div>
                                            </div>
                                            
                                            <!--<div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label">&nbsp;</label>
                                                 <label class="control-label">Pickup from API</label>
                                                 </div>
                                            </div>-->
                        </div>	
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm import_button" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary import import_button">Upload</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>