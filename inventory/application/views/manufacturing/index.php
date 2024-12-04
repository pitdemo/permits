<?php $this->load->view('layouts/header');?>
<style type="text/css">
    .sweet-alert {
        width:364px !important;
    }


#table_report td:nth-child(4)
{

 text-align:center !important;
}
#table_report td:nth-child(5)
{

 text-align:center !important;
}

</style>
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
        <li class="active">Manage Manufacture Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="manu_form" id="manu_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
         <div class="row-fluid">
         Search by &nbsp;&nbsp;  <select name="status" id="status" style="width:120px;">
                <option value="<?php echo STATUS_ACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_ACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_ACTIVE); ?></option>
                <option value="<?php echo STATUS_INACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_INACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_INACTIVE); ?></option>
            </select>&nbsp;&nbsp;
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="End date" >&nbsp;&nbsp;
         
            
            
            <select name="item_id[]" multiple="multiple" id="item_id" style="width:316px;margin-top:-10px">
			 	<option></option>
                       <?php
                        if(!empty($items))
                        {
                            $srch_items = explode(",",$get['chk_item_id']);
                            foreach($items as $item)
                            {
                        ?>
                           <option value="<?php echo $item['id']; ?>" <?php echo (in_array($item['id'],$srch_items))?'selected="selected"':"";?>><?php echo $item['item_code'].'-'.$item['item_name']; ?></option>
                        <?php
                            }
                        }
    
                        ?>
                    </select>&nbsp;&nbsp;
           
            <button class="btn btn-info" type="button" onClick="chk_search()" style="margin-bottom:10px;">Go</button>&nbsp;&nbsp;
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
            
            </div>
        <?php if($this->session->userdata('session_user_type')!='viewer'){?>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>manufacturing/manufacturing_entry'" type="button">+ Create</button>
        <?php } ?>
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                        <th class="center" width="10%">Id</th>
                        <th class="center" width="20%">Item Name</th>
                        <th class="center" width="10%">Quantity</th>
                        <th class="center" width="15%">Manufacture Date</th>
                        <th class="center" width="15%">Created</th>
                        <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>      
                      <?php } ?> 
                        <th class="center" width="10%">Action</th>  
                      </tr>
                  </thead>
                  <tbody>
				 </tbody>
                  <tfoot>
                    <tr>
                        <th colspan="2" style="text-align:right">Sub Total : <br/><br/> Total :</th>
                        <th></th>
                        <th></th>
                         <th></th>
                         <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                       <th></th>  
                      <?php } ?> 
                        <th></th>
                    </tr>
                </tfoot>
            </table>
          </div>
            <!-- export pdf or csv place -->
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


<style>
#table_report td
{
 text-align: left;
}
</style>

<script type="text/javascript">
$(function() 
{
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
	


$('#item_id').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin

	$('#table_report').dataTable( 
	{
		"processing": true,
		"serverSide": true,
		"aaSorting": [[ 3, "desc" ]],	
		 "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ],	
		"ajax": {url :"<?php echo base_url()?>manufacturing/datafetch<?php echo $uri_data;?>",type: "post"},
		"columns": 
		[
			{ "data": "id", "bVisible":false },
			{ "data": "item_name" },
			{ "data": "qty" },
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
			/*{
				"mRender":function(data,type,full)
				{
					var dateAr = full['manufacture_date'].split('-');
					var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
					return newDate;
				}
			},*/
			
			{ "data": "manufacture_date" },
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
							if(data == 'active')

                                {
                                   
							return '<img style="cursor:pointer;" onClick="change_status('+id+',this);"  src="<?php echo base_url()?>assets/images/active.png" style="cursor:pointer;" title="Change Inactive">';
								
                                }
                              if(data == 'inactive')
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
			{
				"mRender":function(data,type,full)
				{
					///return full['id']+'-two-'+full['item_id'];
					return '<div class="btn-group"><a href="javascript:void(0)" onclick="get_material_items('+full['id']+')" class="btn btn-mini btn-info" type="button" title="View"><i class="icon-eye-open bigger-120"></i></a></div>';
				}
			}
		],
		"footerCallback": function ( row, data, start, end, display ) 
		{
			var response = this.api().ajax.json();
			var qty_total = response['total_qty'];
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
			//
			// Update footer
			$( api.column(2 ).footer() ).html(
			//'Rs '+(pageTotal + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +' <br> Rs '+ total +'.00'
			''+pageTotal.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + '<br/><br/> ' + qty_total
			);
		}
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
            function get_material_items(manufacture_id,element) // get manufacture material items based on manufacture id(manufacture_material_items)
            {
				//alert(manufacture_id);
                 $.ajax({
                   url: '<?php echo base_url();?>manufacturing/ajax_get_manufacture_material_items',
                   type: 'POST',
                   async : false,
                   data: { manufacture_id:manufacture_id },
                   success: function(data){ 
                          swal({  
                                title: "Manufacture Details", 
                                text: data, 
                                html: true 
                        });
                     }
				 });            
            }
			
			function change_status(manufacture_id,element)
			{
                if(confirm("Do you wish to continue?"))
               {
                  
                   $.ajax({
					url: '<?php echo base_url();?>manufacturing/change_status',
					type: 'POST',
					data: { manufacture_id:manufacture_id},
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Manufacturing status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Manufacturing status has been changed successfully.<br></div>');
						}
						
					}
					});
                    
               }
                else
                    return false;
                
			}
           function chk_search() // manual search function
	       {
		     var frm = document.manu_form;
              ids="";
			  
			  
			  $("#item_id").each(function() {
                    ids +=$(this).val();
                });
                    
			  
               if(frm.item_id.value == "" && frm.status.value == ""  && frm.start_date.value == "" && frm.end_date.value == "" )
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
                url += (frm.item_id.value != "")?'/item_id/'+ids:"";
                url += (frm.status.value != "")?'/status/'+frm.status.value:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
		      }
	       }
           function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
                    
		</script>
</body>
</html>
