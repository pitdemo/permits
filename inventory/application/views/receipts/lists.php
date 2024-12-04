<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
<head>
<style type="text/css">
td.center1
{
		text-align:right;
}
.center_rupee
{
		text-align:left;
}
</style>
<?php if($this->session->userdata('session_user_type') == 'viewer'){?>
<body  oncontextmenu="return false">
<?php } ?>
<?php if($this->session->userdata('session_user_type') != 'viewer'){?>
<body >
<?php } ?>
<!--printfucntionality div  - soundarya-->
<div id="printableTable" style="display: none;">
</div>

<iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
<!--printfucntionality div  - soundarya-->
<div class="navbar navbar-inverse header-con">
    <?php $this->load->view('layouts/logo');?>
  <!--/.navbar-inner--> 
</div>
<div class="container-fluid" id="main-container"> <a id="menu-toggler" href="#"> <span></span> </a>
   <?php $this->load->view('layouts/menu');?>
  <div id="main-content" class="clearfix">
    <div id="breadcrumbs">
      <ul class="breadcrumb">
        <li class="active">Manage Receipts Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="receipt_form" id="receipt_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
        
         <div class="row-fluid">
         Search by &nbsp;&nbsp;  <select name="status" id="status" style="width:120px;">
                <option value="<?php echo STATUS_ACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_ACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_ACTIVE); ?></option>
                <option value="<?php echo STATUS_INACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_INACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_INACTIVE); ?></option>
            </select>&nbsp;&nbsp;
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Receipt start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="Receipt end date" >&nbsp;&nbsp;
               <select name="person[]" multiple="multiple" id="person" style="width:206px;margin-top:-10px">
			 	<option></option>
                       <?php
                        if(!empty($persons))
                        {
                            $srch_items = explode(",",$get['chk_person']);
                            foreach($persons as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['sales_person_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
             <select name="user_type" id="user_type">
                <option value="">Filter by user type</option>
            <?php
                $user_types = unserialize(USER_TYPES);
                foreach($user_types as $role)
                {
                    
            ?>
                    <option value="<?php echo $role ?>" <?php echo ($get['chk_usertype'] == $role)?'selected="selected"':"";?>><?php echo ucfirst($role); ?></option>
            <?php
                }          
            ?>
            </select>&nbsp;&nbsp; 
           
           
            
           
           
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>&nbsp;&nbsp;
            <?php if($this->session->userdata('session_user_type')!='viewer'){?>
            <button class="btn btn-info" type="button" id="print" onClick="print_table()" style="margin-bottom:10px;float:right">Print</button>&nbsp;&nbsp;

            <?php } ?>
            </div>
        <br>
         <?php if($this->session->userdata('session_user_type')!='viewer'){?>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>receipts/receipts_entry'" type="button">+ Create</button>
       <?php } ?>
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                 <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                    <th class="center" width="5%">Id</th>
                    <th class="center" width="20%">Name</th>
                    <th class="center" width="15%">Amt (Rs)</th>
                    <th class="center" width="5%">Attachment</th>
                    <th class="center" width="10%">User Type</th>
                    <th class="center" width="10%">Receipt Date</th>
                    <th class="center" width="10%">Entry Date</th>
                    <th class="center" width="15%">Remarks</th>
				   <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>      
                      <?php } ?>                                     
                    </tr>
                  </thead>
                  
               <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Sub Total : <br/><br/> Total :</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                         <th></th>
                      <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                       <th></th>  
                      <?php } ?> 
                       

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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>


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
};
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
//start
	
$('#person').select2({
allowClear: true,
placeholder: "- - Sales Personwise - - "}); // select box select2 plugin

var table = "";
$('#table_report').dataTable( 
{
	"processing": true,
	"serverSide": true,
	"aaSorting": [[ 0, "desc" ]],	
	"ajax": {url :"<?php echo base_url()?>receipts/datafetch/<?php echo $uri_data;?>",type: "post"},
	"columns": 
	[
		{"data": "id","bVisible":false},
		{
			"mRender":function(data,type,full)
			{
				if(full['supplier_name']== null)
				{
					return full['customer_name'];
				}
				else
				{
					return full['supplier_name'];
				}
			}
		},
		{ "data": "amount" },
		{ "data": "attachment" },
		{ "data": "user_type" },
		/*{
			"mRender":function(data,type,full)
			{
				var dateAr = full['receipt_date'].split('-');
				var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
				return newDate;
			}
		},*/
		{ "data": "receipt_date" },
		
			{ 
				"mRender":function(data,type,full)
				{
				var date_created = full['created'];
				var dateAr1 = date_created.split('-');
				var sYear = dateAr1[0];
				var sMonth = dateAr1[1].toString();
				var dateAr2 = dateAr1[2].split(" ");
				var sDay = dateAr2[0];
	   			
				var created_date = sYear + '-' + sMonth + '-'+ sDay ;
				return 	created_date;
					
				} 
			},
		{
			"mRender":function (data,type,full)        
			{
				if(full['remarks']== null)
				{
					return '---';
				}
				else
				{
					return full['remarks'];
				}
			}
		},
		   <?php if($this->session->userdata('session_user_type')=='super_admin'){?>
		{
			"mRender": 	function (data,type,full)                              
			{
				var data = full['status'];
				var id = full['id'];
				var current = new Date();
				var get_current_date = formatDate(current);
				 // Days you want to subtract
				var dateAr = get_current_date.split('-');
				var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
				var date = new Date(dateAr[0],dateAr[1]-1,dateAr[2]);
				var get_current_date_new = formatDate(date);
				var newdate = new Date(date);
				newdate.setDate(newdate.getDate() - 6); // minus the date
				var nd = new Date(newdate);
				var last_six = formatDate(nd);
				//return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
			if(data == 'active')
                                {
                                    return '<img style="cursor:pointer;" onClick="change_status('+id+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
                                }
                                else
                                {
                                   return '<img src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active">';
                                }
			}
		},
		<?php } ?>
		<?php if($this->session->userdata('session_user_type')=='admin'){?>
		{
			"mRender": 	function (data,type,full)                              
			{
				var data = full['status'];
				var id = full['id'];
				var current = new Date();
				var get_current_date = formatDate(current);
				 // Days you want to subtract
				var dateAr = get_current_date.split('-');
				var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
				var date = new Date(dateAr[0],dateAr[1]-1,dateAr[2]);
				var get_current_date_new = formatDate(date);
				var newdate = new Date(date);
				newdate.setDate(newdate.getDate() - 6); // minus the date
				var nd = new Date(newdate);
				var last_six = formatDate(nd);
				var date_created = full['created'];

				//Plus the Date

				var cal_six =new Date(date_created);
				cal_six.setDate(cal_six.getDate() + (6));
				var last_date = formatDate(cal_six);




				var dateAr1 = date_created.split('-');
				var sYear = dateAr1[0];
				var sMonth = (Number(dateAr1[1])).toString();
				var dateAr2 = dateAr1[2].split(" ");
				var sDay = dateAr2[0];
	   			
				var created_date = sYear + '-0' + sMonth + '-'+ sDay ;
				//return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
				if(data == 'active')

                                {
                                    // if(created_date > last_six && created_date <= get_current_date_new)
								  // if((last_six <= created_date) && (created_date <=get_current_date_new ))

								  if(last_date >= get_current_date_new)
									{
									return '<img style="cursor:pointer;" onClick="change_status('+id+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
									}
									else
									{
									return '<img src="<?php echo base_url()?>assets/images/expired.png" title="Date Expired" style="cursor:pointer;">';
									}
                                }
                              if(data == 'inactive')
                                {
                                   return '<img src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active">';
                                }
			}
		},
		<?php } ?>
	],
	"footerCallback": function ( row, data, start, end, display) 
	{
		var response = this.api().ajax.json();
		var overall_total = response['total_amount'];
			
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
		.column( 2, { page: 'current'} )
		.data()
		.reduce( function (a, b) 
		{
			return intVal(a) + intVal(b);
		}, 0 );
		//console.log('Filll :'+full);
		// Update footer
		$( api.column( 2 ).footer() ).html(
		
		
		//'Rs '+(pageTotal + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +' <br> Rs '+ total +'.00'
		pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + '<br/><br/> '+overall_total
		);
	}
});
			
});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
			   function delete_item(receipt_id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>receipts/delete_receipt',
					type: 'POST',
					data: { receipt_id:receipt_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 } 
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Receipt details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Receipt details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			}
			function change_status(receipt_id,element)
			{
                if(confirm("Do you wish to continue?"))
               {
				$.ajax({
					url: '<?php echo base_url();?>receipts/change_status',
					type: 'POST',
					data: { receipt_id:receipt_id },
					beforeSend: function() { $(element).attr('src','<?php echo base_url();?>'+'assets/images/loader.gif'); },
					success: function(msg){
						if($.trim(msg) == 'inactive')
						{
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/inactive.png');
							$(element).attr('title','Change Active');
							$(element).removeAttr('onclick');
						}
						else
						{
							$(element).attr('src','<?php echo base_url();?>'+'assets/images/active.png');
							$(element).attr('title','Change Inactive');
						}
						
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Receipt status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Receipt status has been changed successfully.<br></div>');
						}
						
					}
					});
               }
                else
                    return false;
                
			}
           function chk_search() // manual search function
	       {
		     var frm = document.receipt_form;
             
			   ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });
			  
                    
			  
               if( frm.status.value == "" && frm.user_type.value == "" && frm.start_date.value == "" && frm.end_date.value == "" && frm.person.value == "")
                {
				    $.growl.error({ message: "You must select atleast one!" });
                }
				 else if( frm.person.value != "" && frm.user_type.value == "" )
		      {
			     $.growl.error({ message: "You must select user type!" });
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
                url += (frm.status.value != "")?'/status/'+frm.status.value:"";
                url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
				url += (frm.person.value != "")?'/person/'+ids_person:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
		      }
	       }
		   function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

           function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
           function export_pdf() // download pdf document
            {
			
                 var frm = document.receipt_form;
               
			   ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });
			  
			
                search_url="";
                search_url += (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
				search_url += (frm.person.value != "")?'/person/'+ids_person:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_receipt_list/option_type/pdf"+search_url;
                	window.open(url);
					}
        function export_csv() // download csv document
        {
              
             var frm = document.receipt_form;
                
				
				 ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });
			  
                search_url="";
                search_url += (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
				search_url += (frm.person.value != "")?'/person/'+ids_person:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_receipt_list/option_type/csv"+search_url;
               window.open(url);
            
        }

        /*Fucntion for print button - soundarya*/
        function print_table()
        {
        	var frm = document.receipt_form;
        	 ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });


              if( frm.status.value == "" && frm.user_type.value == "" && frm.start_date.value == "" && frm.end_date.value == "" && frm.person.value == "")
              {
				 $.growl.error({ message: "You must select atleast one!" });
              }
				 else if( frm.person.value != "" && frm.user_type.value == "" )
		      {
			     $.growl.error({ message: "You must select user type!" });
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
               search_url = "";
               search_url += (frm.status.value != "")?'/status/'+frm.status.value:"";
               search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
               search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
               search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
               search_url += (frm.person.value != "")?'/person/'+ids_person:"";
               var url = $("#base_url").val()+"/print_ajax_receipt_list"+search_url;
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
       
        
        
		</script>
</body>
</html>
