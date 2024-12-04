
<?php $this->load->view('layouts/header');?>


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
            <a href="<?php echo base_url();?>sales_person">Manage Sales Person</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Create Sales Person</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
    
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form name="customer_form" id="customer_form" action="" method="post">
            <input type="hidden" name="c_id" id="c_id" value="">
               <input type="hidden" name="f_id" id="f_id" value="" > 
          	<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending" style="width: 197px;">Sales person Name *</th>
                    	
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending" style="width: 197px;">Phone No.</th>
                    	
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 90px;">Action</th>
                        
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty"><input type="text" name="sales_person_name[]"></td>
            				<td valign="top" class="dataTables_empty"><input type="text" name="phone_no[]" value=""></td>
            				<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>
            			</tr>
            		</tbody>
            	</table>
            	<button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" type="submit">Submit</button>
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        </form>
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<script type="text/javascript" src="<?php echo base_url('js/jquery-1.11.0.min.js')?>"></script> 
<script type="text/javascript">
$(function(){
	
	$('#table_report').on('click','.remove',function(){
			if(confirm('Are you confirm?'))
			{
					$(this).parents('tr').remove();
			}
			else
				return false;
		});

	$('#add_more').click(function(){
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="text" name="sales_person_name[]"></td><td valign="top" class="dataTables_empty"><input type="text" name="phone_no[]"></td><td valign="top" class="dataTables_empty"><a href="javascript:void(0)" class="remove"><img src="<?php  echo base_url(); ?>images/remove_icon.png" width="20" alt="Remove"></a></td></tr>';
			$('#table_report tr:last').after(add_html);
		});
	
	$("#customer_form" ).submit(function( event ) {
			f=0;
	
	phone_err_invalid=0;
	msg='';
				$('input[name="sales_person_name[]"]').each(function(){
  				if($(this).val()=='')
  				{
  					 f++;	
  				}	
});
$('input[name="phone_no[]"]').each(function(){
  				if($(this).val()!='')
  				{
					 user_phone = $(this).val();
					 phone_pattern = /^\d{10}$/;
					 if(phone_pattern.test(user_phone)==false)
						 phone_err_invalid++;
  				}
				
});

if(f!=0)
	{
				msg+= "\n * Please fill all sales person names";
		}

if(phone_err_invalid!=0)
{
	 msg+="\n * Invalid phone number format(10 numbers only)";
	}
 
	
		
		if(f==0&&phone_err_invalid==0)
		{
					
					if($('#f_id').val()=='')
					{
						console.log('Form sub');
						
						$('#f_id').val(1);
						
						return true;
					}
					else
					{
						console.log('Form Not sub');
						
						return false;
					}
					
				}
			else
			{
					swal(msg); // sweetalert syntax
					return false;
				}
});		
		
		
})

</script>
	</body>
</html>
