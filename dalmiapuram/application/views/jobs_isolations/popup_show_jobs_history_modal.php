<div  class="modal fade" id="show_matched_records_modal">
  <div class="modal-dialog" style="width:90%">
  
  <form method="post" id="import" enctype="application/x-www-form-urlencoded">
  	
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Accessed Info's</h4>
              </div>
              <div class="modal-body">
              	
                	<div class="row" id="show_response_msg" style="display:none;">
                         <div class="col-lg-12 col-md-2 col-sm-4 col-xs-6">	
                    		<div class="alert alert-danger show_msg">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<span id="response_msg"></span>
							</div>
                          </div>  
                    </div>
              
              
              	<div id="matched_fund_account_information" class="wall">
                </div>        
              
              <div class="row">&nbsp;</div>
              
             
              <div class="redeme-table">
                        <div class="overflow" id="no-more-tables">
							  <div id="matched_result">
                              </div>
                        </div>            
						</div>
                        	
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm match_close" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>