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
        <li class="active">Manage Payments</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="payment_form" id="payment_form" method="post">
                <input type="hidden" id="base_url" value="<?php echo base_url().$this->router->fetch_class(); ?>" />
        <div class="row-fluid">
         Search by &nbsp;&nbsp;  <select name="status" id="status">
                <option value="">Filter by status</option>
                <option value="<?php echo STATUS_ACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_ACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_ACTIVE); ?></option>
                <option value="<?php echo STATUS_INACTIVE; ?>" <?php echo ($get['chk_status'] == STATUS_INACTIVE)?'selected="selected"':"";?>><?php echo ucfirst(STATUS_INACTIVE); ?></option>
            </select>&nbsp;&nbsp;
            <input type="text" style="width:125px"  name="start_date" class="start_date" value="<?php echo $get['chk_start_date'] ?>" placeholder="Payment start date" >&nbsp;&nbsp;
             <input type="text" style="width:125px" name="end_date" class="end_date" value="<?php echo $get['chk_end_date'] ?>" placeholder="Payment end date" >&nbsp;&nbsp;
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
            <a href="javascript:void(0);" onClick="reset_srh()">Reset</a>
        <br>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>customer_payments/payment_entry'" type="button">+ Create payment entry</button>
         <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="20%">Name</th>
                         <th class="center" width="15%">Payment Date</th>
                         <th class="center" width="10%">Amount</th>
				 <?php if($this->session->userdata('session_user_type')=='admin'){?>
                      <th class="center" width="10%">Status</th>                                           
                      <th class="center" width="15%">Action</th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
				              </tbody>
            </table>
          </div>
             
          <button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" onClick="export_pdf()" type="button">Export PDF</button>
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
								 "url" : '<?php echo base_url();?>customer_payments/ajax_get_payment_list/<?php echo $url; ?>',
								 "dataSrc": function(json) {
										return json.data;
								 },
							},
					"aoColumns": [
					{ "sClass": "center" }, { "sClass": "center" }, { "sClass": "center" },
				  <?php if($this->session->userdata('session_user_type')=='admin'){?>
					{ "sClass": "center" }, { "sClass": "center" }
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
			
			
			function change_status(id,element)
			{
                if(confirm("Do you wish to continue?"))
               {
				$.ajax({
					url: '<?php echo base_url();?>customer_payments/change_status',
					type: 'POST',
					data: {id:id },
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Payment status has been changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Payment status has been changed successfully.<br></div>');
						}
						
					}
					});
               }
                else
                    return false;
                
			}
           function chk_search() // manual search function
	       {
		      var frm = document.payment_form;
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
                 var frm = document.payment_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_payment_list/option_type/pdf"+search_url;
               	window.open(url,"_blank");
            }
        function export_csv() // download csv document
        {
             var frm = document.payment_form;
                search_url = (frm.status.value != "")?'/status/'+frm.status.value:"";
                search_url += (frm.user_type.value != "")?'/user_type/'+frm.user_type.value:"";
                search_url += (frm.start_date.value != "")?'/start/'+frm.start_date.value:"";
                search_url += (frm.end_date.value != "")?'/end/'+frm.end_date.value:"";
                
                var url = $("#base_url").val()+"/ajax_get_payment_list/option_type/csv"+search_url;
               	window.open(url);
        }
        
        
		</script>
</body>
</html>
