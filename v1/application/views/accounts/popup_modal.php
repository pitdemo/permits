<div  class="modal fade" id="myModal">
  <div class="modal-dialog">
  
  <form method="post" id="import" enctype="application/x-www-form-urlencoded">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" onclick="javascript:pop_up_close();" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Import Data</h4>
              </div>
              <div class="modal-body">
              	
                	<div class="row" id="show_response_msg" style="display:none;">
                         <div class="col-lg-12 col-md-2 col-sm-4 col-xs-6">	
                    		<div class="alert alert-danger show_msg">
								<button data-dismiss="alert" class="close" type="button">&times;</button>
								<span id="response_msg"></span>
							</div>
                          </div>  
                    </div>
              
              <input type="hidden" name="import_file_value" id="import_file_value" value="0" />
                        <div class="row">
                                  <div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                      <div class="form-group">
                                      <label class="control-label">Upload*</label>
                                          <input type="file" name="import_csv_file" id="import_csv_file" accept="application/msexcel" />
                                          <span class="error">Upload CSV file only</span>
                                      </div>
                                  </div>
                                            
                                 <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label"></label>
                                                 (Or)
                                                 </div>
                                            </div>
                                        
                                 <div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label">Upload*</label>
                                                    <input type="file" name="import_zip_file" id="import_zip_file" accept="application/x-zip-compressed" />
                                                    <span class="error">Upload Zip file only</span>
                                                </div>
                                            </div>       
                                            
                        </div>	
                        
                        <div class="row">
	                        <div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label"></label>
                                                 <span><br /><a style="text-decoration:underline;" class="editable editable-click" target="_blank" href="<?php echo base_url(); ?>uploads/csv/accounts.csv">Download</a> Sample CSV file </span>
                                                 </div>
                                            </div>
							<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label"></label>
                                               
                                                 </div>
                                            </div>      
							<div class="col-lg-5 col-md-2 col-sm-4 col-xs-6">
                                                <div class="form-group">
                                                <label class="control-label"></label>
                                                 <span><br /><a style="text-decoration:underline;" class="editable editable-click" target="_blank" href="<?php echo base_url(); ?>uploads/uploads.zip">Download</a> Sample ZIP file </span>
                                                 </div>
                                            </div>                                                                                  
                        </div>                    
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm import_button" onclick="javascript:pop_up_close();">Close</button>
        <button type="reset" class="btn btn-danger import_reset">Reset</button>
        <button type="button" class="btn btn-primary import import_button">Upload</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<script type="text/javascript">
function pop_up_close()
{
	if($("#import_file_value").val()==0)
	{
		$('#import')[0].reset();
		$('#show_response_msg').hide();
		$('#myModal').modal('toggle');
		$('input[type=file]').removeAttr('disabled');
	}
	else
	{
		alert("The file processing is going on. Please wait! ");
		return false;
	}
	
}
</script>