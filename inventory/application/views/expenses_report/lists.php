<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
    //echo $url;
?>
<body>
<?php /*if($this->session->userdata('session_user_type') == 'viewer'){?>
<body  oncontextmenu="return false">
<?php } ?>
<?php if($this->session->userdata('session_user_type') != 'viewer'){?>
<body >
<?php } */?>
<!--printfucntionality div  - soundarya-->
<!-- <div id="printableTable" style="display: none;">
</div>

<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe> -->
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li class="active">Manage Expenses Report</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="expense_report_form" id="expense_report_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
         Search by &nbsp;&nbsp;  <!-- <select name="status" id="status">
                <option value="">Filter by status</option>
                <option value="<?php echo STATUS_ACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_ACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_ACTIVE); ?></option>
                <option value="<?php echo STATUS_INACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_INACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_INACTIVE); ?></option>
            </select>&nbsp;&nbsp; -->
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Expense start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="Expense end date" >&nbsp;&nbsp;
            
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
             <?php /*if($this->session->userdata('session_user_type')!='viewer'){?>
            <button class="btn btn-info" type="button" id="print" onClick="print_table()" style="margin-bottom:10px;float:right">Print</button>&nbsp;&nbsp;

            <?php } */?>
        <br>

         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                        <th class="center" width="25%">Expense Category</th>
                         <th class="center" width="10%">Amount</th>
                         <th class="center" width="10%">Created</th>
				 
                                                                       
                    </tr>
                  </thead>
                   <tfoot>
                    <tr>
                        <th>Sub Total : <br/><br/> Total :</th>
                        <th></th>
                        <th></th>
                      
                       

                    </tr>
                </tfoot>
                  <tbody>
				              </tbody>
            </table>
          </div>
          <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_csv()" type="button">Export CSV</button>
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
  <!--/#main-content--> 
</div>
<!--/.fluid-container#main-container--> 

<!--<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> -->

<!--basic scripts--> 

<?php $this->load->view('layouts/footer_script');?>

<!--page specific plugin scripts--> 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
			$(function() {
				jQuery.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) 
	{
		if(oSettings.oFeatures.bServerSide === false)
		{
			var before = oSettings._iDisplayStart;
			oSettings.oApi._fnReDraw(oSettings);
			// iDisplayStart has been reset to zero - so lets change it back
			oSettings._iDisplayStart = before;
			oSettings.oApi._fnCalculateEnd(oSettings);
		}
// draw the 'current' page
oSettings.oApi._fnDraw(oSettings);
alert(oSettings);
};
            $('.start_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
					//maxDate: 0,
                });	
            
            $('.end_date').datetimepicker(
                {
                    format:'Y-m-d',
                    timepicker:false,
					//maxDate: 0,
               });	
				//start
					$('#table_report').DataTable( {
						"processing": true,
	                   /* "serverSide": true,*/
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>expenses_report/ajax_get_expenses_report_list/<?php echo $url;?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" },
				 					
					],
				'footerCallback': function( tfoot, data, start, end, display )  
				{

					  var overall_total = 0;
					  var response = this.api().ajax.json();
					  //var $th = $(tfoot).find('th');
						//$th.eq(1).html(response['total_amount']);
					  if(response){
							overall_total = response['total_amount'];
					  }
						
				   //overall_total = '290';
					var api = this.api(), data;
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) 
					{
						return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
						i : 0;
					};
					// Total over this page
					pageTotal = api
					.column( 1, { page: 'current'} )
					.data()
					.reduce( function (a, b) 
					{
						return intVal(a) + intVal(b);
					}, 0 );
					//console.log('Filll :'+full);
					// Update footer
					if(overall_total!='0')
					{
						overall_total = overall_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
						$( api.column( 1 ).footer() ).html(
						//'Rs '+(pageTotal + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +' <br> Rs '+ total +'.00'
						pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + '<br/><br/> '+overall_total
						);
					}
				}
							
				});
								
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
			/*function delete_item(expense_id,element)
			{
				
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>expenses/delete_item',
					type: 'POST',
					data: { expense_id:expense_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 } 
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Expense details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Expense details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			
			}*/
			/*function change_status(expense_id,element)
			{
				
                if(confirm("Do you wish to continue?"))
                {
				$.ajax({
					url: '<?php echo base_url();?>expenses/change_status',
					type: 'POST',
					data: { expense_id:expense_id },
					beforeSend: function() { $(element).attr('src','<?php echo base_url();?>'+'assets/images/loader.gif'); },
					success: function(msg){
						if($.trim(msg) == 'inactive')
						{
							
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/inactive.png');
							$(element).attr('title','Change Active');
						}
						else
						{
							
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/active.png');
							$(element).attr('title','Change Inactive');
						}
						
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Expense status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Expense status has been changed successfully.<br></div>');
						}
						
					}
					});
                }
                else
                    return false;
			}*/
           function chk_search() // manual search function
	       {
		      var frm = document.expense_report_form;
               if(frm.start_date.value == "" && frm.end_date.value == "")
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
               /* url += (frm.status.value != "")?'/status/'+frm.status.value:"";*/
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                //alert(url);return false;
                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
		      }
	       }
           function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
           /*function export_pdf() // download pdf document
            {
                 var frm = document.expense_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_expenses_list/option_type/pdf"+search_url;
               	window.open(url,"_blank");
            }*/
           function export_csv() // download csv document
           {
             var frm = document.expense_report_form;
                search_url = "";
                //search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_expenses_report_list/option_type/csv"+search_url;
               	window.open(url);
          }

          /*Fucntion for print button - soundarya*/
       /* function print_table()
        {
        	//alert("hfghg");return false;
        	 var frm = document.expense_form;
		     if( frm.start_date.value != "" && frm.end_date.value == "" )
		      {
			     $.growl.error({ message: "You must select end date!" });
              }
		      else if( frm.start_date.value == "" && frm.end_date.value != "" )
		      {
			     $.growl.error({ message: "You must select start date!" });
              }
		      else
		      {
               search_url = "";
               search_url += (frm.status.value != "")?'/status/'+frm.status.value:"";
               search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
               search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
               var url = $("#base_url").val()+"/print_ajax_expenses_list"+search_url;
               //alert(url);
               $.ajax({
                   url:url,
                   type:"POST",
                   	beforeSend:function(){
                    $("#print").text('Processing..');
                    $("#print").attr('disabled','disabled');
                },
                   success: function(msg) 
	               { 
	               	    $("#print").text('Print');
	               	    $("#print").prop('disabled', false);
	              		$('#printableTable').html(msg); 
	              		window.frames["print_frame"].document.body.innerHTML = document.getElementById("printableTable").innerHTML; 
	              		window.frames["print_frame"].window.focus(); 
	              		window.frames["print_frame"].window.print(); 
	              }
               });
             }

        }
        */
        
		</script>
</body>
</html>
