<?php $this->load->view('layouts/header');?>
<style>
div.custom_file_upload {
	width: 230px;
	height: 20px;
	margin-bottom: 25px;
}

input.file {
	width: 150px;
	height: 20px;
	border: 1px solid #BBB;
	border-right: 0;
	color: #888;
	padding: 5px;
	
	-webkit-border-top-left-radius: 5px;
	-webkit-border-bottom-left-radius: 5px;
	-moz-border-radius-topleft: 5px;
	-moz-border-radius-bottomleft: 5px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	
	outline: none;
}

div.file_upload {
	width: 80px;
	height: 24px;
	background: #7abcff;
	background: -moz-linear-gradient(top,  #7abcff 0%, #60abf8 44%, #4096ee 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#7abcff), color-stop(44%,#60abf8), color-stop(100%,#4096ee));
	background: -webkit-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: -o-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: -ms-linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	background: linear-gradient(top,  #7abcff 0%,#60abf8 44%,#4096ee 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7abcff', endColorstr='#4096ee',GradientType=0 );

	display: inline;
	position: absolute;
	overflow: hidden;
	cursor: pointer;
	
	-webkit-border-top-right-radius: 5px;
	-webkit-border-bottom-right-radius: 5px;
	-moz-border-radius-topright: 5px;
	-moz-border-radius-bottomright: 5px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 2px;
	
	font-weight: bold;
	color: #FFF;
	text-align: center;
	padding-top: 8px;
}
div.file_upload:before {
	content: 'UPLOAD';
	position: absolute;
	left: 0; right: 0;
	text-align: center;
	
	cursor: pointer;
}

div.file_upload input {
	position: relative;
	height: 25px;
	width: 250px;
	display: inline;
	cursor: pointer;
	opacity: 0;
}
</style>

<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
</script>
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
      	 <li>
            <a href="<?php echo base_url();?>items">Manage Items</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Bulk Import</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Bulk Import</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="item_form" id="item_form" action="" method="post" enctype="multipart/form-data">
         		 <div class="control-group">
            	<div class="custom_file_upload">
	<input type="text" class="file" name="file_info">
	<div class="file_upload">
		<input type="file" id="file_upload" name="file_upload">
	</div>
</div>
<span class="notes">Allowed File Types : csv</span>
</div>
                  
                   <div class="control-group">
                    <div class="controls">
                    <button type="submit" name="add" class="btn btn-info"> Submit <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button><img id="loading" src="<?php echo base_url();?>assets/images/ajax_loader.GIF" style="display:none;" > &nbsp;&nbsp;
                    <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>admin/courses'"> Cancel </button>
                    </div>
                </div>
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        
        <!--PAGE CONTENT ENDS HERE--> 
        </form>
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
		<script type="text/javascript">
				$(document).ready(function(){
					
					var validator = $("#item_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							file_upload:
							{
								required:true,
								extension:"csv",
							},
					},
					messages:
					{
						file_upload:
						{
							required: 'Required',
							extension:'Import only .csv file'
						},
					},
					
					errorPlacement: function(error, element)
					{			
							if (element.attr("name") == "file_upload")
							{
									error.insertAfter($('.custom_file_upload'));
							}
							else{			
								error.insertAfter(element);
							}						
					},
					
					submitHandler: function()
					{
						document.item_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
						
					});
					
				   
				});
		
		</script> 
	</body>
</html>
