<?php $this->load->view('layouts/header',array('page_name'=>'Account Notes')); ?>
<style>
    .label:hover{
        cursor: pointer; cursor: hand;
    }
</style>

<!-- start: Content -->
<div class="main acccount-con min-height">
			<div class="row mr-none">		
				<div class="col-lg-12">
                  <h1>Accounts Note Details</h1>
                 <div class="clearfix"></div>
                 
                 <div class="panel panel-default transaction">
						<div class="panel-body">							
						<div id="myTabContent" class="tab-content">
	                                <div class="tab-pane active" id="all"> 
									<?php if(!empty($account_notes)) 
										  {   
									?>
									<div class="col-lg-4 col-md-2 col-sm-4 col-xs-12">
									<div class="form-group">
										   <label>Account Name</label> : <label><?php echo $account_notes[0]['name']; ?></label>
								  	</div>
									</div>
									<div class="col-lg-4 col-md-2 col-sm-4 col-xs-12">
									<div class="form-group">
										   <label>Fund Account Number</label> : <label><?php echo $account_notes[0]['fund_account_number']; ?></label>
									</div>
									</div>
									<div class="col-lg-4 col-md-2 col-sm-4 col-xs-12">
									<div class="form-group">
										   <label>PI Account Number</label> : <label><?php echo ($account_notes[0]['pi_account_number'])?$account_notes[0]['pi_account_number']:'-----'; ?></label>
									</div>
									</div>
									<?php } ?>               
											<div class="panel-body redeme-table">
											<div id="no-more-tables" class="overflow">
												 <table class="table  custom-table table-striped redeme-table" id="associate_account_tbl">
							  <thead>
								  <tr>
								  	  <th width="340">Notes</th>
									  <th width="300">Updated Date</th>
									  <th width="200">Updated Time</th>
								  </tr>
							  </thead>
							  <tbody>
							  <?php if(!empty($account_notes)) { foreach($account_notes as $account_notes) { ?>
							  	<tr>
									<td><label><?php echo isset($account_notes['notes']) ? $account_notes['notes'] :'';?></label></td>
									<td><label><?php echo isset($account_notes['created']) ? date('m/d/Y',strtotime($account_notes['created'])) :'';?></label></td>
									<td><label><?php echo isset($account_notes['created']) ? date('H:i A',strtotime($account_notes['created'])) :'';?></label></td>			
								</tr>
								<?php } } else { ?>
								<tr align="center"><td colspan="3">No datas found</td></tr>
								<?php } ?>
							  </tbody>
							  </table>
											</div>            
											</div>                
                                        </div>
							</div>
						</div>
					</div>
				</div><!--/col-->
			</div><!--/row-->
		</div>
<!-- end: Content -->
<?php $this->load->view('layouts/footer_script'); ?>
 <?php $this->load->view('layouts/footer'); ?>

