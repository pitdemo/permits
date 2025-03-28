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
        <li class="active">Manage Sales</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="items_form" id="items_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
        
         <div class="row-fluid">
         Search by &nbsp;&nbsp; 
            <input type="text" style="width:125px"  name="start_date" class="start_date"  id="start_date"  value="<?php echo $get['chk_start_date'] ?>" placeholder="Start Date"  readonly>&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date"  id="end_date"  value="<?php echo $get['chk_end_date'] ?>" placeholder="End date" readonly >&nbsp;&nbsp;
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
        <br>
<!--        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>sales/sales_entry'" type="button">+ Create</button>
-->       
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	<table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="5%">id</th>
                      <th class="center" width="5%">Code</th>
                      <th class="center" width="10%">Name</th>
                      <th class="center" width="10%">Opening Date</th>
                       <th class="center" width="10%">Opening Stock</th>
					   <th class="center" width="10%">Qty_in</th>
                       <th class="center" width="10%">Qty_Out</th>
                       <th class="center" width="10%">Closing Date</th>
                       <th class="center" width="10%">Closing Stock</th>
					                                   
                    </tr>
                  </thead>
                  <tbody>
                  		
				              </tbody>
            </table>
          </div>
             
          <!-- <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button> -->
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
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
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

/*
$('#end_date').datetimepicker(
{
	format:'Y-m-d',
	timepicker:false
});

    $("#start_date").datetimepicker({
		format:'Y-m-d',
	    timepicker:false,
        onSelect: function(){
		      var fecha = $(this).datetimepicker('getDate');
			console.log(fecha); 

           $("#end_date").datetimepicker("setDate", new Date(fecha.getTime()));

            $("#end_date").datetimepicker("setDate", "+30d");

        }

    });
	*/
	
	$('#start_date').on('change', function () {
		date2 = $("#start_date").val(); 
	    var get_current_date = formatDate(date2);
		console.log(get_current_date);
		var dateAr = get_current_date.split('-');
		var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
		var date = new Date(dateAr[0],dateAr[1]-1,dateAr[2]);
		var newdate = new Date(date);
		newdate.setDate(newdate.getDate() + 30); // minus the date
		var nd = new Date(newdate);
		var end_date = formatDate(nd);
		 $("#end_date").val(end_date);
		});

	
//start

$('#item_id').select2({
allowClear: true,
placeholder: "- - Itemwise - - "}); // select box select2 plugin

var table = "";
$('#table_report').dataTable( 
{
		"processing": true,
		"serverSide": true,
		"aaSorting": [[ 8, "desc" ]],
		"ajax": {url :"<?php echo base_url()?>inventory/datafetch<?php echo $uri_data;?>",type: "post"},
		"columns": 
		[
			{"data": "id","bVisible":false},
			{ "data": "item_code" },
			{ "data": "item_name" },
			{
			  "mRender":function(data,type,full)
		   {
			   	//	return '<a href="<?php echo base_url(); ?>items/item_history_stock/'+btoa(full['id'])+'<?php echo $uri_data;?>" target="_blank">'+full['opening_date']+'</a>';	
		       return  '<a href="<?php echo base_url()?>items/item_history_stock/'+btoa(full['id'])+'/start/'+'<?php echo $get['chk_start_date'] ?>'+'/end/'+'<?php echo $get['chk_end_date'] ?>'+' " target="_blank" >' +full['opening_date']+ '</a>';
		   }
		},
			
		{ 
				"mRender":function(data,type,full)
				{
					if(full['opening_stock'] ==   null)
					{
						return  0;
					}
					else
					{
						return full['opening_stock'] ;
					}
				} 
			},
			{ "data":"qty_in"},
			{ "data":"qty_out"},
			 {"data": "closing_date" },
				{ 
				"mRender":function(data,type,full)
				{
					if(full['closing_stock'] >= 0)
					{
						return full['closing_stock'];
					}
					else
					{
					return 0;
					}
				} 
			}
		],
		
	});
			
   });
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
		/* function getval(sel) {
       alert(sel.value);
    }	*/
			function delete_item(sales_id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>sales/delete_sales',
					type: 'POST',
					data: { sales_id:sales_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 } 
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Sales details has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Sales details has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
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
			function change_status(sales_id,element)
			{
                if(confirm("Do you wish to continue?"))
               {
                   var revert_back=2;
                   $.ajax({
					url: '<?php echo base_url();?>sales/change_status',
					type: 'POST',
					data: { sales_id:sales_id,revert_back:revert_back},
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Sales status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Sales status has been changed successfully.<br></div>');
						}
						
					}
					});
                    
               }
                else
                    return false;
                
			}
           function chk_search() // manual search function
	       {
		     var frm = document.items_form;
              ids="";
			  
			  $("#item_id").each(function() {
                    ids +=$(this).val();
                });
                    
			  
               if(frm.item_id.value == "" && frm.start_date.value == ""  && frm.end_date.value == "")
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
			
				else	if(  frm.start_date.value  >=  frm.end_date.value &&  frm.start_date.value != "" && frm.end_date.value != ""   )
						  {
							 $.growl.error({ message: "End date can not be before start date!" });
						  }
						
			
		      else
		      {
               
			    var url = "";
                url += (frm.item_id.value != "")?'/item_id/'+ids:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>"+url;
		      }
	       }
          function reset_srh() // reset function 
	       {
		      window.location.href = $("#base_url").val()+"/<?php echo $this->router->fetch_method()?>";
	       }
    
function export_csv() // download csv document
        {
              
             var frm = document.items_form;
                  ids="";
                $("#item_id").each(function() {
                    ids +=$(this).val();
                });
	
                search_url="";
				search_url += (frm.item_id.value != "")?'/item_id/'+ids:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_inventory_list/option_type/csv"+search_url;
                window.open(url);
            
        }



       
        
        
		</script>
</body>
</html>
