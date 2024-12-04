<?php $this->load->view('layouts/header');?>
<style type="text/css">
    .sweet-alert {
        width:364px !important;
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
        <li class="active">Manufacture Report</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="manf_form" id="manf_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid" style="margin-top : 20px">
         <div class="row-fluid">
         Search by &nbsp;&nbsp; 
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Start Date" >&nbsp;&nbsp;
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
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                        <th class="center" width="10%">Id</th>
                         <th class="center" width="15%">Item Code</th>
                        <th class="center" width="20%">Item Name</th>
                        <th class="center" width="10%">Qty In</th>
                        <th class="center" width="10%">Qty Out</th>
                        <th class="center" width="15%">Manufacture Date</th>
                           <!--<th class="center" width="10%">Action</th>-->
                       
                      </tr>
                  </thead>
                  <tbody>
				 </tbody>
                  <tfoot>
                    <tr>
                       
                        <th></th>
                         <th colspan="2" style="text-align:right">Sub Total : <br/><br/> Total :</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <!-- <th></th>-->
                        
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
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script> 

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
		"aaSorting": [[ 5, "desc" ]],
	
		 //"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6 ] } ],	
		"ajax": {url :"<?php echo base_url()?>manufacturing_report/datafetch/<?php echo $uri_data;?>",type: "post"},
		"columns": 
		[
			{ "data": "id", "bVisible":false },
			{ "data": "item_code" },
			{ "data": "item_name" },
			{ "data": "qty_in" },
			{ "data": "qty_out" },
			/*{
				"mRender":function(data,type,full)
				{
					var dateAr = full['manufacture_date'].split('-');
					var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0]; 
					return newDate;
				}
			},*/
			
			{ "data": "manf_date" },
			/*{
				"mRender":function(data,type,full)
				{
					///return full['id']+'-two-'+full['item_id'];
					return '<div class="btn-group"><a href="javascript:void(0)" onclick="get_material_items('+full['id']+')" class="btn btn-mini btn-info" type="button" title="View"><i class="icon-eye-open bigger-120"></i></a></div>';
				}
			}*/
			
		],
		"footerCallback": function ( row, data, start, end, display ) 
		{
			var response = this.api().ajax.json();
			var qty_total_in = response['total_qty_in'];
			var qty_total_out = response['total_qty_out'];
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
			.column( 3, { page: 'current'} )
			.data()
			.reduce( function (a, b) 
			{
				return intVal(a) + intVal(b);
			}, 0 );
			//
			// Total over this page
			pageTotal_qty = api
			.column( 4, { page: 'current'} )
			.data()
			.reduce( function (a, b) 
			{
				return intVal(a) + intVal(b);
			}, 0 );
			//
			// Update footer
			$( api.column(3 ).footer() ).html(
			//'Rs '+(pageTotal + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +' <br> Rs '+ total +'.00'
			''+pageTotal.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + '<br/><br/> ' + qty_total_in
			);
			
			$( api.column(4 ).footer() ).html(
			//'Rs '+(pageTotal + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") +' <br> Rs '+ total +'.00'
			''+pageTotal_qty.toFixed(0).replace(/(\d)(?=(\d{3})+\.)/g, '$1,') + '<br/><br/> ' + qty_total_out
			);
		}
	});
});			function fnGetSelected( oTableLocal )
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
                 
				 function chk_search() // manual search function
	       {
		     var frm = document.manf_form;
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
       
       
           
		</script>
</body>
</html>
