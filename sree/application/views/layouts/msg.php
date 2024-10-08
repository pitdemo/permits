<br>
<?php if($this->session->flashdata("message")){ ?>
  <div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php echo $this->session->flashdata('message');?></strong> 
</div>
<?php } ?>
<?php if(!!$this->session->flashdata("success")){ ?>

<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<?php
		$replace_with=array("MODULE");
		if(isset($controller))
		{
				$message = str_replace($replace_with,ucfirst(rtrim($controller,'/')),$this->session->flashdata("success")); 
		}
		else
		{
			$message = $this->session->flashdata("success");
		}
	?>
     <strong><?php echo str_replace("_"," ",$message);?></strong> 
</div>

<?php } ?>

<?php if(!!$this->session->flashdata("failure")){ ?>
  <div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<?php
		$replace_with=array("MODULE");
		if(isset($controller))
		{
				$message = str_replace($replace_with,ucfirst(rtrim($controller,'/')),$this->session->flashdata("failure")); 
		}
		else
		{
			$message = $this->session->flashdata("failure");
		}
	?>
    <strong><?php echo str_replace("_"," ",$message);?></strong> 
  </div>
<?php } 

$_SESSION['failure']='';
$_SESSION['success']='';
$_SESSION['message']='';

unset($_SESSION['failure']);
unset($_SESSION['success']);
unset($_SESSION['message']);

if(isset($controller))
{
?>
<a data-target="#confirm_modal" id="confirm" data-toggle="modal">&nbsp;</a>
<span id="gritter_success" data-title="Success!" data-msg='<?php echo str_replace('_',' ',str_replace("MODULE",ucfirst(substr($controller,0,-2)),DB_UPDATE)); ?>'></span>
<span id="gritter_required" data-title="Error!" data-msg='<?php echo REQUIRED; ?>'></span>

<div  class="modal fade modal-danger" id="confirm_modal" >
  <div class="modal-dialog">
  
  <form method="post" enctype="application/x-www-form-urlencoded">
  	<input  type="hidden" name="status_base_url" id="status_base_url" value="<?php echo base_url().$controller.'ajax_change_status/'; ?>">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:white;font-size:14px;" >Confirm</h4>
              </div>
              <div class="modal-body" id="update_confirm">
                	Are you sure?
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger confirm_status">Yes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<a data-target="#change_status_confirm_modal" id="change_status_confirm" data-toggle="modal">&nbsp;</a>
<div  class="modal fade modal-danger" id="change_status_confirm_modal" >
  <div class="modal-dialog">
  <form method="post" enctype="application/x-www-form-urlencoded">
  	<input  type="hidden" name="status_base_url" id="status_base_url" value="<?php echo base_url().$controller.'ajax_change_status/'; ?>">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:white;font-size:14px;" >Confirm</h4>
              </div>
              <div class="modal-body" id="change_status_update_confirm">
                	Are you sure?
              </div>
     		  <div class="modal-footer">
        <button type="button" class="btn btn-defaultm" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary change_status_confirm">Yes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>

<a data-target="#change_reports_status_confirm_modal" id="change_reports_status_confirm" data-toggle="modal">&nbsp;</a>
<div  class="modal fade modal-danger" id="change_reports_status_confirm_modal" >
  <div class="modal-dialog">
  <form method="post" enctype="application/x-www-form-urlencoded">
    <input  type="hidden" name="reports_status_base_url" id="reports_status_base_url" value="<?php echo base_url().$controller.'ajax_change_status/'; ?>">
    <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" style="color:white;font-sizechange_reports_status_update_confirm:14px;" >Confirm</h4>
              </div>
              <div class="modal-body" id="change_reports_status_update_confirm" style="word-wrap: break-word;">
                  Are you sure?
              </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-defaultm change_reports_status_confirm_no" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger change_reports_status_confirm" >Yes</button>
      </div>
    </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
<?php } ?>

<div class="alert alert-success" id="api_response" style="display:none;">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
     <strong id="api_response_msg"></strong> 
</div>