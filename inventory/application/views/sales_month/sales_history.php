<?php $this->load->view('layouts/header');?>
<style type="text/css">

</style>
<body>
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li class="active">Sales History</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="items_form" id="items_form" method="post">
        <div class="row-fluid">
        <br>
        <!-- purchase history table -->
   
          <div class="table-header"><?php echo ucfirst($details['sales_person_name']);?> - 

          <?php echo ucfirst($details['item_name']); ?>  -  <?php echo ucfirst($details['customer_name']); ?>   History <span style="float:right">Total Qty - <?php echo $details['qty']; ?> &nbsp;&nbsp;</span></div>
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                          <!-- <th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th> -->
                           <th class="center" width="20%">Customer Name</th>
                           <th class="center" width="20%">Date</th>
                           <th class="center" width="20%">Quantity</th>

                        </tr>
                    </thead>
                    <tbody>
  				          </tbody>

                </table>
            
           
          </div>
          </br>
          <div class="clearfix"></div>

          <br/>
          </div>
         </form>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div>
      <br/>
      <br/>
            <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--  -->
  <!--/#main-content--> 
</div>
<!--/.fluid-container#main-container--> 

<!--<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> -->

<!--basic scripts--> 

<?php $this->load->view('layouts/footer_script');?>

<!--page specific plugin scripts--> 
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
			$(function() {
				// get item history using datatable ajax
					
          $('#table_report').dataTable( {
                        "aaSorting": [],
                        "pageLength": 50,
					
					"ajax": {

								 "url" : '<?php echo base_url();?>sales_month/ajax_sales_history/sales_person_id/<?php echo $get['chk_sales_id']; ?>/item_id/<?php echo $get['chk_item_id']; ?>/sales_date/<?php echo $get['chk_sales_date']; ?>/start/<?php echo $get['chk_start_date']; ?>/end/<?php echo $get['chk_end_date']; ?>/customer_id/<?php echo $get['chk_customer_id'];?>',
								 "dataSrc": function(json) {
                    return json.data;
								 },
							},
					"aoColumns": [
					 { "sClass": "center" }, { "sClass": "center" } , { "sClass": "center" }
					],
							
				});
			//end
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}

			
</script>
</body>
</html>