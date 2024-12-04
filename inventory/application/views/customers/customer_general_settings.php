
<?php $this->load->view('layouts/header');?>
<style type="text/css">
input[type="text"] { width:150px; }
select{width:150px;}
.sub_nav1_outer{ width:100%; float:left;  margin-top:42px; }
.sub_nav1{ width:100%; max-width:750px; float:left ; }
.sub_nav1 ul{ margin:0px 0px 0px 60px; padding:0px; float:left; width:100%; }
.sub_nav1 li{ margin:0px; padding:0px; float:left; list-style-type:none; margin-left:1px; }
.sub_nav1 li a{ color:#fff; font-size:18px; display:block; text-decoration:none; padding:11px 44px; /* Firefox v4.0+ , Safari v5.1+ , Chrome v10.0+, IE v10+ and by Opera v10.5+ */
text-shadow:1px 1px 4px rgba(0,0,0,0.2); transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;-webkit-transition: all .2s ease-in-out; padding:11px 44px 11px 43px\0/; *padding:11px 43px 11px 43px;
-ms-filter:"progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true)";zoom:1;
filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true);}
.sub_nav1 li a:hover { background-color:#fff; color:#0b6cbc;border-radius: 18px;}
.sub_nav1 li a.active1{ background-color:#fff; color:#0b6cbc;border-radius: 18px;}
</style>

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
            <a href="<?php echo base_url();?>customers">Customer</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
		 <li>
		 	<?php echo ucfirst($customer_details['customer_name']); ?>
			<span class="divider"><i class="icon-angle-right"></i></span>
		 </li>
        <li class="active">Customer General Settings</li>
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
        <?php $this->load->view('layouts/sub_menu');?>

        <form name="customer_form" id="customer_form" method="post">
        <div class="row-fluid">
        <br>
      
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                    <th class="center" width="10%">Customer ID</th>
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
				//get item purchase history using datatable ajax
					$('#table_report').dataTable( {
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>customers/ajax_get_customer_settings/<?php echo $customer_id; ?>',
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
