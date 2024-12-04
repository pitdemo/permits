
<?php $this->load->view('layouts/header');?>


<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
<style type="text/css">
td.center1
{
		text-align:right;
}
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
      	 <li>
            <a href="<?php echo base_url();?>customers">Customer</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
		 <li>
		 	<?php echo ucfirst($customer_details['customer_name']); ?>
			<span class="divider"><i class="icon-angle-right"></i></span>
		 </li>
        <li class="active">Customer Payments</li>
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
                        <th class="center" width="15%">Payment Date</th>
                         <th class="center" width="10%">Amount</th>
                        <th class="center" width="30%">Attachment</th>
                    </tr>
                  </thead>
                  
                   <tfoot>
            <tr>
             
                  <th style="text-align:right"><span style="padding-top:10px"> Sub Total:</span><br><br> <span> Total:</span> </th>
                  <th></th>
                   <th></th>
                   
            </tr>
          
        </tfoot>
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
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<script type="text/javascript">
			$(function() {
				//get customer transaction history using datatable ajax
					$('#table_report').dataTable( {
						
						 "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
		    var iTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][1].replace(/[^0-9\.]+/g,""));
			   iTotalamount += number*1;
            }
			
			
        
            var iPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][1].replace(/[^0-9\.]+/g,""));
			iPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var PageTotal =accounting.formatMoney(iPageamount);
			var PageTotal = accounting.formatMoney(iPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			//var OverallTotal =accounting.formatMoney(iTotalamount);
			var OverallTotal = accounting.formatMoney(iTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});

 var TotalQty = 0;
			
         
			
            var nCells = nRow.getElementsByTagName('th');
           // nCells[1].innerHTML = '<b style="text-align:right">Rs.</b>' + PageTotal +   '<br> Rs.'+ OverallTotal ;
	
       nCells[1].innerHTML= "<div style=text-align:left;>" + ' Rs.'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+PageTotal +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + 'Rs. '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+OverallTotal +"<br>" ;
	    
		},

						
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>customers/ajax_get_customer_payment_details/<?php echo $customer_id; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center1" }, { "sClass": "center" }
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
