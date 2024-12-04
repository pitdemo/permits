<?php $this->load->view('layouts/header');?>
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
        <li class="active">Manage Items</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      <div class="alert alert-info" id="succ_msg" <?php echo ($this->session->flashdata('message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('message')!='')?$this->session->flashdata('message'):'';?></span><br></div>
      <div class="alert alert-error" id="err_msg" <?php echo ($this->session->flashdata('error_message') == '')?'style="display:none;"':'';?>><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><span id="message"><?php echo ($this->session->flashdata('error_message')!='')?$this->session->flashdata('error_message'):'';?></span><br></div>
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
          <form name="employee" id="employee" action="<?php echo base_url();?>admin/category/bulk_deactive" method="post">
        <div class="row-fluid">
        <br>
        <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>items/create_item'" type="button">+ Create Item</button>
          
          <!--<div class="table-header"> Category List </div>-->
          <div class="table-outer">
            	 <table id="table_report" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <!--<th class="center" width="10%"><label><input type="checkbox" name="checkall" id="checkall" class="ace" /><span class="lbl"></span> </label></th>-->
                      <th class="center" width="20%">Item Code</th>
                      <th class="center" width="25%">Name</th>
                       <th class="center" width="20%">Item Type</th>
                      <th class="center" width="10%">Status</th>                                           
                      <th class="center" width="30%">Action</th>
                    </tr>
                  </thead>
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
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
			$(function() {
				var oTable1 = $('#table_report').dataTable( {
					"aaSorting": []
				} );
				$('#employee').submit(function(){ 
					if($('[name="check_delete[]"]:checked').length == 0)
					{
						alert("You must select atleast one!");
						return false;
					}
				});						
				if(window.location.hash)
				{
					oTable1.fnFilter(window.location.hash.substring(1));
				}				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
				//$('[data-rel=tooltip]').tooltip();
				
				/*$('#page-content').slimScroll({
			        height: '480px',					
			    });*/
					
			})
			function fnGetSelected( oTableLocal )
			{
				return oTableLocal.$('tr.row_selected');
			}
			function delete_category(category_id,element)
			{
				var choice=confirm("Do you wish to continue?");
				if (choice==true)
				{
					var oTable = $('#table_report').dataTable();
					$(element).parents('tr').addClass('row_selected');
					var anSelected = fnGetSelected( oTable );
					$.ajax({
					url: '<?php echo base_url();?>admin/category/delete_category',
					type: 'POST',
					data: { category_id:category_id },
					success: function(){
						if ( anSelected.length !== 0 )
						 {
							oTable.fnDeleteRow( anSelected[0] );
						 }
						 
						if($("div").find("#succ_msg").attr("class") == "alert alert-info" )
						{
							$("#succ_msg").show();
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category has been deleted successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category has been deleted successfully.<br></div>');
						}
					}
					});										
				}
				else
				{
					return false;
				}
			}
			function change_status(category_id,element)
			{
				$.ajax({
					url: '<?php echo base_url();?>admin/category/change_status',
					type: 'POST',
					data: { category_id:category_id },
					beforeSend: function() { $(element).attr('src','<?php echo base_url();?>'+'assets/images/loader.gif'); },
					success: function(msg){
						if($.trim(msg) == '2')
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
							$("#succ_msg").html('<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category status has been Changed successfully.<br>');
						}
						else {
							$("#page-content").prepend('<div id="succ_msg" class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>Category status has been Changed successfully.<br></div>');
						}
						
					}
					});
			}
			
			function uncheck()
			{
				if($('[name="check_delete[]"]').length == $('[name="check_delete[]"]:checked').length)
				{
					document.getElementById('checkall').checked=true;
				}
				else
				{
					$('#checkall').attr('checked',false);
				}
			}
		</script>
</body>
</html>
