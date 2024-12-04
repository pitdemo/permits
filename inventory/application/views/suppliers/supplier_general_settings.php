
<?php $this->load->view('layouts/header');?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
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
      	 <li>
            <a href="<?php echo base_url();?>suppliers">Suppliers</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
		 <li>
		 	<?php echo ucfirst($supplier_details['supplier_name']); ?>
			<span class="divider"><i class="icon-angle-right"></i></span>
		 </li>
        <li class="active">Supplier General Settings</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 

        
      <!--/.page-header-->
     
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
        <?php $this->load->view('layouts/sub_menu_supplier');?>

        <form name="customer_form" id="customer_form" method="post">
        <div class="row-fluid">
        <br>
      
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                    <th class="center" width="10%">Supplier ID</th>
                      <th class="center" width="25%">Name</th>
                        <th class="center" width="15%">Email Id</th>
                         <th class="center" width="15%">Phone No.</th>
                      <th class="center" width="15%">Address</th>
                    </tr>
                  </thead>
                  <tbody>
				              </tbody>
            </table>
          </div>
             
          
          <div class="clearfix"></div>
          <br/>
        
        </div>
         </form>  
        
                       
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>

	<!--page specific plugin scripts--> 

<script src="<?php echo base_url();?>js/jquery-1.11.0.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
			$(function() {
				//get supplier general details using datatable ajax
					$('#table_report').dataTable( {
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>suppliers/ajax_get_supplier_settings/<?php echo $supplier_id; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }
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
