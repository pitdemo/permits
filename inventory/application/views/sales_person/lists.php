<?php $this->load->view('layouts/header');?>
 <?php 
    $url_string=$_SERVER['REQUEST_URI'];
    $url=substr($url_string,strpos($url_string,$this->router->fetch_method())+strlen($this->router->fetch_method())+1); 
?>
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
        <li class="active">Manage Sales Persons</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    
    <div id="page-content" class="clearfix"> 
       <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>>
            <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="sales_form" id="sales_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
         <div class="row-fluid" style="margin-top : 20px"> 
         <?php if($this->session->userdata('session_user_type')!='viewer'){?>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>sales_person/create_sales_person'" type="button">+ Create</button>
        <?php } ?>
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="10%">Name</th>
                      <th class="center" width="10%">Customers</th>
                      <th class="center" width="10%">Outstanding</th>
                        <th class="center" width="10%">Suppliers</th>
                         <th class="center" width="10%">Outstanding</th>
                       <th class="center" width="10%">Contact no</th>
                        
                         <th class="center" width="10%">Created Date</th>
                         
                        
                        
				  <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>  
                          
                      <?php } ?>                                     
                    </tr>
                  </thead>
                  <tbody>
				              </tbody>
            </table>
          </div>
             
     <!--     <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button>
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
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.growl.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>css/jquery.growl.css" rel="stylesheet" type="text/css" />
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
				//start
					$('#table_report').dataTable( {
                        "aaSorting": [],
					
					"ajax": {
								 "url" : '<?php echo base_url();?>sales_person/ajax_get_sales_person_list/<?php echo $url; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center1" }, { "sClass": "center" },  { "sClass": "center1" }, { "sClass": "center" }, { "sClass": "center" }, 
				  <?php if($this->session->userdata('session_user_type')=='super_admin' || $this->session->userdata('session_user_type')=='admin'){?>
					 { "sClass": "center" }	
					 <?php } ?>							
					],
							
				});
			//end
				/*if(window.location.hash)
				{
					oTable1.fnFilter(window.location.hash.substring(1));
				}				*/
					
			});
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			
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
		function change_status(sales_person_id,element)
			{
                if(confirm("Do you wish to continue?"))
               {
                   //var revert_back=2;
                   $.ajax({
					url: '<?php echo base_url();?>sales_person/change_status',
					type: 'POST',
					data: { sales_person_id:sales_person_id},
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
		      var frm = document.sales_form;
               if(frm.status.value == "" && frm.user_type.value == "" && frm.start_date.value == "" && frm.end_date.value == "")
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
                url += (frm.status.value != "")?'/status/'+frm.status.value:"";
                url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
                url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
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
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_sales_person_list/option_type/pdf"+search_url;
               	window.open(url,"_blank");
            }
        function export_csv() // download csv document
        {
             var frm = document.sales_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_sales_person_list/option_type/csv"+search_url;
               	window.open(url);
        }
        
        
		</script>
</body>
</html>
