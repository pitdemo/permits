<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
<style type="text/css">

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
        <li class="active">Item History</li>
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
        <br>
        <!-- purchase history table -->
            <?php
                $this->load->model('items_model');
                $item_details = $this->items_model->get_item_details($item_id);
				 $item_history_details = $this->items_model->get_item_history($item_id);
            ?>
          <div class="table-header"><?php echo ucfirst($item_details['item_name']); ?>  -  History <span style="float:right">| Closing Stock - <span id="stock"></span> &nbsp;&nbsp;</span> <span style="float:right">Opening Stock - <?php echo ($opening_stock  >= 0 ) ? $opening_stock : 0; ?> &nbsp;&nbsp;</span></div>
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="10%">ID</th>
                      <th class="center" width="20%">Date</th>
                      <th class="center" width="15%">Quantity In</th>
                       <th class="center" width="15%">Quantity Out</th>
                        <th class="center" width="15%">Record Type</th>
                      <th class="center" width="10%">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  		
				</tbody>
            </table>
            
           
          </div>
          <br>
          <div class="table-header"><?php echo ucfirst($item_details['item_name']); ?>  -  History <span style="float:right">| Closing Stock -<span id="stock1"></span> &nbsp;&nbsp;</span> <span style="float:right">Opening Stock - <?php echo ($opening_stock  >= 0 ) ? $opening_stock : 0; ?> &nbsp;&nbsp;</span></div>
          
          </br>
          <div class="clearfix"></div>
          <?php
		   echo '<table id="table_report2" align="center" class="table table-striped table-bordered table-hover" style="auto;width:30%;margin-top:15px"><tr>
   
   <tr><td colspan="2" ><p style="text-align:center;"><b>Profit Details</b></p></td></tr>
 </tr><tr><td align="left" > <b>Sales </b> </td><td>&nbsp;'.'Rs.   '.(($sales=='')?'0.00': number_format($sales, 2)).'</td></tr><tr><td align="left"  ><b>Purchase</b></td><td>&nbsp;'.'Rs.   '.(($purchase=='')?'0.00': number_format($purchase, 2)).'</td></tr><tr><td align="left"><b>Profit</b></td><td>&nbsp;'.'Rs.   '.(($profit=='')?'0.00': number_format($profit, 2)).'</td></tr></table>';
       
        echo "</table>"; ?>
            
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
<script src="<?php echo base_url(); ?>/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
			$(function() {
				//get item history using datatable ajax
					$('#table_report').dataTable( {
                        "aaSorting": [],
                        "pageLength": 50,
					
					"ajax": {
								 "url" : '<?php echo base_url();?>items/ajax_get_item_history_stock/<?php echo $uri_data; ?>',
								 "dataSrc": function(json) {
                  var lastElement = json.data[json.data.length-1];
                  var result = /[^,]*$/.exec(lastElement)[0];
                  console.log(result);
                  document.getElementById("stock").innerHTML=(result);
                  document.getElementById("stock1").innerHTML=(result);
        
                  return json.data;
								 },
							},
					"aoColumns": [
		                                 
					
					 { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" },  
					/* {
					   "fnCreatedCell": function(nTd, sData, oData, iRow, iCol)
                                       {
                                           $(nTd).css('text-align', 'center');
                                       },
                                        "mRender": function (data,type,full) { 
                                            if(data  >= 0)                        
								 						return data;
								 				else
								 						return 0;
                                            }
								    }*/
					],
							
				});
			//end
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
            function get_material_items(manufacture_id,element) // get manufacture material items based on manufacture id(manufacture_material_items)
            {
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
		     var frm = document.items_form;
              ids="";
			   ids_person="";
               $("#person").each(function() {
                    ids_person +=$(this).val();
                });
			  
			  $("#item_id").each(function() {
                    ids +=$(this).val();
                });
                    
			  
               if( frm.start_date.value == "" && frm.end_date.value == "")
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
