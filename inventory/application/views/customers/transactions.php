
<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
	
?>


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
        <li class="active">Customer Transactions</li>
        
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 

        <div class="page-header position-relative" style="border-bottom:none !important;">
             <?php $this->load->view('layouts/sub_menu');?>
          </div>
      <!--/.page-header-->
     
          
        <br>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
        <form name="transaction_form" id="transaction_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class();?>" />
        <br><br>
         <div class="row-fluid">
         Search by &nbsp;&nbsp; 
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="end date" >&nbsp;&nbsp;
             <select name="record_type[]" multiple="multiple" id="record_type" style="width:316px;margin-top:-10px">
                
            <?php
                $record_types = unserialize(RECORD_TYPES);
				
                foreach($record_types as $record_type)
                {
                   switch($record_type)
            {
                case 'Purchase':
                    $record_type1='P';
                    break;
                case 'Sales':
                    $record_type1='S';
                    break;
                case 'Manufacture':
                    $record_type1='M';
                    break;
                case 'Purchase Return':
                    $record_type1='PR';
                    break;
                case 'Sales Return':
                    $record_type1='SR';
                    break;
			   case 'Payment':
                    $record_type1='R';
                    break;
			   case 'Payment Return':
                    $record_type1='RR';
                    break;
				 case 'Credit':
                    $record_type1='LC';
                    break;
				 case 'Debit':
                    $record_type1='LD';
                    break;
				case 'Credit Return':
                    $record_type1='LCR';
                    break;
				case 'Debit Return':
                    $record_type1='LDR';
                    break;
           }
		   		$search_values = explode(",",$get['chk_recordtype']);
            ?>
                    <option value="<?php echo $record_type1; ?>" <?php echo in_array($record_type1,$search_values) ?'selected="selected"':"";?>><?php echo ucfirst($record_type); ?></option>
            <?php
                }          
            ?>
            </select>&nbsp;&nbsp; 
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
            
            </div>
        <div class="row-fluid"> 
          <div  style="margin-top:20px"> <span style="padding-left:80%;font-weight:700;padding-top:20px">Outstanding : <?php echo "Rs. ".number_format($customer_details["outstanding"],2) ?> </span></div>
          <div class="table-outer"  style="margin-top:10px">
            	 <table id="table_report" class="table table-striped table-bordered table-hover" >
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                         <th class="center" width="15%">Item Name</th>
                        <th class="center" width="10%">Date</th>
                        <th class="center" width="10%">Qty</th>
						<th class="center" width="10%">Credit</th>
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
                   
           <div> <span style="padding-left:80%;font-weight:700;padding-top:0px">Outstanding : <?php echo "Rs. ".number_format($customer_details["outstanding"],2) ?> </span></div>

                       
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


<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript">
			$(function() {
            $('.start_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
                });	
            
            $('.end_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
               });	
			   
			    $('#record_type').select2({
					allowClear: true,
					placeholder: "- - Recordwise - - "}); // select box select2 plugin
				//get customer rensaction history using datatable ajax
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
								 "url" : '<?php echo base_url();?>customers/ajax_get_customer_transactions_history/<?php echo $customer_id; ?>/<?php echo $url; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" },  { "sClass": "center1" }, { "sClass": "center1" }, { "sClass": "center1" }, { "sClass": "center" }, { "sClass": "center" }
					],
							
				});
			//end
                
                
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
            function chk_search() // manual search function
	       {
		       var customer_id = "<?php echo $customer_id;?>";
			   var frm = document.transaction_form;
			   ids_person="";
               $("#record_type").each(function() {
                    ids_person +=$(this).val();
                });
			  
			  
               if(frm.record_type.value == "" && frm.start_date.value == "" && frm.end_date.value == "" )
                {
				    $.growl.error({ message: "You must select atleast one!" });
                }
			
		      else if( frm.start_date.value != "" && frm.end_date.value == "" )
		      {
			     $.growl.error({ message: "You must select end date!" });
              }
		      else if( frm.start_date.value == "" && frm.end_date.value != "" )
		      {
			     $.growl.error({ message: "You must select start date!" });
              }
		      else
		      {
                var url = "";
               
				url += (frm.record_type.value != "")?'/record_type/'+ids_person:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
             
			//  window.location.href = $("#base_url").val()+"/<?php //echo $this->router->fetch_method();?>/"+customer_id+url;
			   window.location.href= $("#base_url").val()+"/transactions/" + customer_id +url;
			  
			  
			   
		      }
	       }
           function reset_srh() // reset function 
	       {
		       var customer_id = "<?php echo $customer_id;?>";
			  window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method();?>/"+customer_id;
	       }
           function export_pdf() // download pdf document
            {
                 var frm = document.transaction_form;
                search_url="";
                search_url += (frm.record_type.value != "")?'/record_type/'+frm.record_type.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                var url = $("#base_url").val()+"/ajax_get_customer_transactions_history/option_type/pdf"+search_url;
                	window.open(url);
					}
        function export_csv() // download csv document
        {
              
             var frm = document.transaction_form;
                
                search_url="";
                search_url += (frm.record_type.value != "")?'/record_type/'+frm.record_type.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                var url = $("#base_url").val()+"/ajax_get_customer_transactions_history/option_type/csv"+search_url;
               window.open(url);
            
        }
</script>
</body>
</html>
