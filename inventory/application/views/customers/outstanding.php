
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
            <a href="<?php echo base_url();?>outstanding">Customer</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
		 <li>
		 	<?php echo ucfirst($customer_details['customer_name']); ?>
			<span class="divider"><i class="icon-angle-right"></i></span>
		 </li>
        <li class="active">Customer Outstanding</li>
        
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
         <?php /*?><div class="row-fluid">
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
            
            </div><?php */?>
        <div class="row-fluid"> 
          <div  style="margin-top:20px"> <span style="padding-left:80%;font-weight:700;padding-top:20px">Outstanding : <?php echo "Rs. ".number_format($customer_details["outstanding"],2) ?> </span></div>
          <div class="table-outer"  style="margin-top:10px">
            	 <?php /*?><table id="table_report" class="table table-striped table-bordered table-hover" >
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                         <th class="center" width="25%">Date</th>
                      	<th class="center" width="10%">Amount</th>
                        <th class="center" width="10%">Record Type</th>
                    </tr>
                  </thead>
                  
                    
                 
                  <tbody>
				</tbody>
            </table><?php */?>
          </div>
         
          <div class="clearfix"></div>
		 <?php
		if($customer_details["outstanding"] > 0)
		{
		  $outstanding_total =$sales_lastthiry+$sales_thirytosixty+$sales_sixtytoninety+$sales_ninetytoonetwenty+$sales_aboveonetwenty;
		  
		   echo '<table id="table_report2" align="center" class="table table-striped table-bordered table-hover" style="auto;width:70%;margin-top:15px"><tr>
   
   <tr><td colspan="6" ><p style="text-align:center;"><b>Amount</b></p></td>
   </tr>
   <tr><td> 0 - 30 </td><td>30 - 60</td><td>60 - 90</td><td>90 - 120</td><td> >120</td><td>Total </td></tr>
   <tr><td>&nbsp;'.(($sales_lastthiry=='')?'0.00': number_format($sales_lastthiry, 2)).'</td>
   <td>&nbsp;'.(($sales_thirytosixty=='')?'0.00': number_format($sales_thirytosixty, 2)).'</td>   
   <td>&nbsp;'.(($sales_sixtytoninety=='')?'0.00': number_format($sales_sixtytoninety, 2)).'</td>
   <td>&nbsp;'.(($sales_ninetytoonetwenty=='')?'0.00': number_format($sales_ninetytoonetwenty, 2)).'</td>
     <td>&nbsp;'.(($sales_aboveonetwenty=='')?'0.00': number_format($sales_aboveonetwenty, 2)).'</td>
	   <td>&nbsp;'.(number_format($outstanding_total,2)).'</td>
   </tr></table>';
       
        echo "</table>";
		}
		else
		{
		
		$sales_lastthiry=$sales_thirytosixty=$sales=$sales_return=$sales_sixtytoninety=$sales_ninetytoonetwenty=$sales_aboveonetwenty=0;
		  $outstanding_total =$sales_lastthiry+$sales_thirytosixty+$sales_sixtytoninety+$sales_ninetytoonetwenty+$sales_aboveonetwenty;
		  
		   echo '<table id="table_report2" align="center" class="table table-striped table-bordered table-hover" style="auto;width:70%;margin-top:15px"><tr>
   
   <tr><td colspan="6" ><p style="text-align:center;"><b>Amount</b></p></td>
   </tr>
   <tr><td> 0 - 30 </td><td>30 - 60</td><td>60 - 90</td><td>90 - 120</td><td> >120</td><td>Total </td></tr>
   <tr><td>&nbsp;'.'Rs.   '.(($sales_lastthiry=='')?'0.00': number_format($sales_lastthiry, 2)).'</td>
   <td>&nbsp;'.(($sales_thirytosixty=='')?'0.00': number_format($sales_thirytosixty, 2)).'</td>   
   <td>&nbsp;'.(($sales_sixtytoninety=='')?'0.00': number_format($sales_sixtytoninety, 2)).'</td>
   <td>&nbsp;'.(($sales_ninetytoonetwenty=='')?'0.00': number_format($sales_ninetytoonetwenty, 2)).'</td>
     <td>&nbsp;'.(($sales_aboveonetwenty=='')?'0.00': number_format($sales_aboveonetwenty, 2)).'</td>
	   <td>&nbsp;'.(number_format($customer_details["outstanding"],2)).'</td>
   </tr></table>';
       
        echo "</table>";	
		}
		 ?>
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
						
						
						
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>outstanding/ajax_get_customer_outstanding_history/<?php echo $customer_id; ?>/<?php echo $url; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }
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
