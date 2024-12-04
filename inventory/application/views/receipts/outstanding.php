<?php
 // $get_records=$customer_details->result_array();
 // echo "<pre>"; print_r($customer_details); exit;
?>
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
          <div class="container" > 
          <h1 style="margin-left:420px;">Transaction Details</h1>
            <!--PAGE CONTENT BEGINS HERE-->
        <form name="transaction_form" id="transaction_form" method="post">
        <div class="row-fluid"> 
          <div  style="margin-top:20px"> <span style="padding-left:0%;font-weight:700;padding-top:20px">Outstanding :<?php echo "Rs. ".number_format($customer_details['outstanding'],2) ?> </span></div>
          <div class="table-outer"  style="margin-top:10px">
            	 <table id="table_report" class="table table-striped table-bordered table-hover" >
                  <thead>
                    <tr>
                        <th class="center" width="15%">Item Name</th>
                        <th class="center" width="10%">Date</th>
                        <th class="center" width="10%">Qty</th>
                        <th class="center" width="10%">Cerdit</th>
                        <th class="center" width="10%">Debit</th>
                        <th class="center" width="10%">Remarks</th>
                        <th class="center" width="10%">Record Type</th>
                    </tr>
                  </thead>
                 <tfoot>
            <tr>
                  <th></th>
                   <th style="text-align:right"><span style="padding-top:10px"> Sub Total:</span><br><br> <span> Total:</span> </th>
                  <th></th>
                 <th></th>
                  <th></th>
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
                   
           <div> <span style="padding-left:0%;font-weight:700;padding-top:0px">Outstanding : <?php echo "Rs. ".number_format($customer_details['outstanding'],2) ?> </span></div>

        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>


<script type="text/javascript">
			$(function() {
				$('#table_report').dataTable( {
						
						
						 "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
		    var iTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][3].replace(/\,/g,''));
			   iTotalamount += number*1;
            }
			
			
        
            var iPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][3].replace(/\,/g,''));
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


// debit amount

		    var iDebitTotalamount = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
            //alert(aaData[i][4].replace(/,/g, '.'));
			  var number= Number(aaData[i][4].replace(/\,/g,''));
			   iDebitTotalamount += number*1;
            }
			
			
        
            var iDebitPageamount = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][4].replace(/\,/g,''));
			iDebitPageamount += number*1;
			  // iPageamount = iPageamount + aaData[ aiDisplay[i] ][4];
            }
			//var PageTotal =accounting.formatMoney(iPageamount);
			var DebitPageTotal = accounting.formatMoney(iDebitPageamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});
			
			//var OverallTotal =accounting.formatMoney(iTotalamount);
			var DebitOverallTotal = accounting.formatMoney(iDebitTotalamount, {   
    symbol   : " ",
    thousand : ",",
    decimal  : ".",
});

 var TotalQtyIn = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
           
			  var number= Number(aaData[i][2].replace(/\,/g,''));
			   TotalQtyIn += number*1;
            }
			
			var iTotalQtyIn = accounting.formatNumber(TotalQtyIn);
        
            var PageQtyIn = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][2].replace(/\,/g,''));
			PageQtyIn += number*1;
			 
            }
			var iPageQtyIn = accounting.formatNumber(PageQtyIn);
			
			
			
			 var TotalQtyOut = 0;
			
            for ( var i=0 ; i<aaData.length ; i++ )
            {
           
			  var number= Number(aaData[i][3].replace(/\,/g,''));
			   TotalQtyOut += number*1;
            }
			
			var iTotalQtyOut = accounting.formatNumber(TotalQtyOut);
        
            var PageQtyOut = 0;
		
            for ( var i=iStart; i<iEnd ; i++ )
            {
			var number= Number(aaData[ aiDisplay[i] ][3].replace(/\,/g,''));
			PageQtyOut += number*1;
			 
            }
			var iPageQtyOut = accounting.formatNumber(PageQtyOut);
			
            var nCells = nRow.getElementsByTagName('th');
          
		   nCells[2].innerHTML= "<div style=text-align:left;>" + ''+ "</div>" + "<div style=text-align:right;margin-top:0px;>"+iPageQtyIn +"<br>" +  " <div style=text-align:left;margin-top:40px;>" + ''+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+iTotalQtyIn +"<br>" ;
		 
       nCells[3].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+PageTotal +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br> '+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+OverallTotal +"<br>" ;
	    nCells[4].innerHTML= "<div style=text-align:left;>" + ' <br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+DebitPageTotal +"<br>" +  " <div style=text-align:left;margin-top:20px;>" + '<br>'+ "</div>" + "<div style=text-align:right;margin-top:-20px;>"+DebitOverallTotal +"<br>" ;
	    
		},
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>receipts/ajax_get_customer_outstanding_history/<?php echo $customer_id; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" },  { "sClass": "center1" }, { "sClass": "center1" },{ "sClass": "center1" },{ "sClass": "center1" }, { "sClass": "center" }
					],
							
				});
});
	
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
            
</script>
</body>
</html>
