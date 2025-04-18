<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
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
        <li class="active">Manage Customer</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="sales_form" id="sales_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
         Search by &nbsp;&nbsp;  <select name="status" id="status">
                <option value="<?php echo STATUS_ACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_ACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_ACTIVE); ?></option>
                <option value="<?php echo STATUS_INACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_INACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_INACTIVE); ?></option>
            </select>&nbsp;&nbsp;
            <!--<input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Sales start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="Sales end date" >&nbsp;&nbsp;-->
           <select name="user_type[]" multiple="multiple" id="user_type" style="width:380px;margin-top:-10px">
			 	<option></option>
                       <?php
                        if(!empty($persons))
                        {
                            $srch_items = explode(",",$get['chk_usertype']);
                            foreach($persons as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['sales_person_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
           
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
        <br>
         <?php if($this->session->userdata('session_user_type')!='viewer'){?>
      <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>customers/create_customer'" type="button">+ Create Customer</button>
      <?php } ?>
<!--          <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php //echo base_url();?>customers/bulk_insert'" type="button">Import data from CSV</button>
-->         <!--<div class="table-header"> Category List </div>-->
		<style>
        #table_report td
        {
         text-align: center;
        }
        </style>
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                        <th class="center" width="10%">Customer ID</th>
                        <th class="center" width="20%">Name</th>
                          <th class="center" width="10%">Date</th>
                        <th class="center" width="10%">Sales Person</th>
                        <th class="center" width="10%">Outstanding</th>
                         <th class="center" width="10%">Contact No</th>
				 	 <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>
                      <?php } ?> 
                       <?php if($this->session->userdata('session_user_type')=='super_admin' ){?>
                      <th class="center" width="10%">Action</th> 
                      <?php } ?>      
                                                          
                    </tr>
                  </thead>
                  <tbody>
				 </tbody>
            </table>
          </div>
             
         <!-- <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button>
             <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_csv()" type="button">Export CSV</button>-->
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>js/numeral.min.js"></script>

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
	
$('#user_type').select2({
allowClear: true,
placeholder: "- - Sales Personwise - - "}); // select box select2 plugin


$('#item_id').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin


var table = "";
$('#table_report').dataTable( 
{
	"processing": true,
	"serverSide": true,
	"aaSorting": [[ 0, "desc" ]],
	<?php if($this->session->userdata('session_user_type')=='super_admin'){?>
		 "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7 ] } ],	
		 <?php } ?>
	"ajax": {url :"<?php echo base_url()?>customers/datafetch/<?php echo $uri_data;?>",type: "post"},
	
	"columns": 
	[
		{ "data": "id" },
	
		{		
				"mRender": 	function (data,type,full)                              
				{
					var id = full['id'];
					var encodedString = btoa(full['id']);
					//console.log(encodedString); 
					//return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
					//return '<a href=<?php echo base_url()?>customers/edit_customer/'+encodedString+' class="btn btn-mini btn-info" type="button" title="Edit"><i class="icon-edit bigger-120"></i></a><button type="button" style="cursor:pointer;" onClick="delete_item('+id+');" class="btn btn-mini btn-danger" title="Delete"><i class="icon-trash bigger-120"></i></button>';
					return '<a href="<?php echo base_url()?>customers/transactions/'+encodedString+'">'+full['customer_name']+'</a>';
				}
			},
		
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
		{ "data": "sales_person_name" },
			{ 
				"mRender":function(data,type,full)
				{
					
					
					if(full['outstanding'] == '')
					{
						return '---';
					}
					else
					{
						var id = full['id'];
						var encodedString = btoa(full['id']);
					//	var total =parseFloat(full['outstanding']).toFixed(2);
						var total = numeral(full['outstanding']).format('0,0.00');
						//return string;
						return '<a href="<?php echo base_url()?>customers/outstanding_report/'+encodedString+'">'+total+'</a>';
					}
				} 
			},
			
	
		
		{
				"mRender":function (data,type,full)        
				{
					if(full['phone_no']== null)
					{
						return '---';
					}
					else
					{
						return full['phone_no'];
					}
				}
			},
			
			
			  <?php if($this->session->userdata('session_user_type')=='super_admin'){?>
			{		
				"mRender": 	function (data,type,full)                              
				{
					//console.log(full['status']);
					var data = full['status'];
					var id = full['id'];
					//return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
					if(data == 'inactive')
					{
						return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/inactive.png" title="Change Active" alt="no image"></a>';
					}
					else
					return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
				}
			},
			
			{		
				"mRender": 	function (data,type,full)                              
				{
					var id = full['id'];
					var encodedString = btoa(full['id']);
					console.log(encodedString); 
					//return '<a href="javascript:void(0)" onclick="change_status('+id+',this)"><img id="status_img" src="<?php echo base_url()?>assets/images/active.png" title="Change Inactive" alt="no image"></a>';
					return '<div class="btn-group"><a href=<?php echo base_url()?>customers/edit_customer/'+encodedString+' class="btn btn-mini btn-info" type="button" title="Edit"><i class="icon-edit bigger-120"></i></a><button type="button" style="cursor:pointer;" onClick="delete_item('+id+');" class="btn btn-mini btn-danger" title="Delete"><i class="icon-trash bigger-120"></i></button></div>';
				}
			},
			
			<?php  } ?>
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

				// Plus the Date

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

                            // Status Change function

								if(last_date >= get_current_date_new)
									{
									//alert("in");
								return '<img style="cursor:pointer;" onClick="change_status('+id+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
									}
									else
									{
										//alert("out");
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

});
			
});







function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
			function delete_item(customer_id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>customers/delete_item',
					type: 'POST',
					data: { customer_id:customer_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 }
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			}
			function change_status(customer_id,element)
			{
				var table = $('#table_report').dataTable();
                if(confirm("Do you wish to continue?"))
                {
				$.ajax({
					url: '<?php echo base_url();?>customers/change_status',
					type: 'POST',
					data: { customer_id:customer_id },
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Customer status has been changed successfully.<br></div>');
						}
						table.fnStandingRedraw();
					}
					});
                }
                else
                    return false;
			}
           function chk_search() // manual search function
	       {
		      var frm = document.sales_form;
			   ids="";
              $("#user_type").each(function() {
                    ids +=$(this).val();
                });
               if(frm.status.value == "" && frm.user_type.value == "" )
                {
				    $.growl.error({ message: "You must select atleast one!" });
                }
		     
		      else
		      {
                var url = "";
                url += (frm.status.value != "")?'/status/'+frm.status.value:"";
				  url += (frm.user_type.value != "")?'/user_type/'+ids:"";
                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
		      }
	       }
		   
           function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
           function export_pdf() // download pdf document
            {
                 var frm = document.sales_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
                var url = $("#base_url").val()+"/ajax_get_customers_list/option_type/pdf"+search_url;
               	window.open(url,"_blank");
            }
        function export_csv() // download csv document
        {
             var frm = document.sales_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
              //  search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
              //  search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_customers_list/option_type/csv"+search_url;
               	window.open(url);
        }
        
        
		</script>
</body>
</html>
