
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
            <a href="<?php echo base_url();?>items">Manage Items</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Create Item</li>
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
            <form name="item_form" id="item_form" action="" method="post">
              <input type="hidden" name="f_id" id="f_id" value="" >  
              <button class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;" onClick="window.location.href='<?php echo base_url();?>items/bulk_insert'" type="button">Import data from CSV</button><br>
            <input type="hidden" name="last_item_code" id="last_item_code" value="<?php echo $item_code; ?>">
         		<table id="table_report" class="table table-striped table-bordered table-hover dataTable" aria-describedby="table_report_info">
                  <thead>
                    <tr role="row">
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Code: activate to sort column ascending" style="width: 197px;">Item Code</th>
                    	<th class="center" width="25%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending" style="width: 250px;">Name *</th>
                    	<th class="center" width="20%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Item Type: activate to sort column ascending" style="width: 197px;">Item Type</th>
                    	<th class="center" width="10%" role="columnheader" tabindex="0" aria-controls="table_report" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 90px;">Action</th>
                    </tr>
                  </thead>
                  
            		<tbody role="alert" aria-live="polite" aria-relevant="all">
            			<tr class="odd">
            				<td valign="top" class="dataTables_empty"><input type="text" class="itemcode" readonly="readonly" name="itemcode[]" value="<?php echo ($item_code) ? $item_code : ''; ?>"></td>
            				<td valign="top" class="dataTables_empty"><input type="text" name="itemname[]" value=""></td>
            				<td valign="top" class="dataTables_empty">
            					<select name="itemtype[]">
            					<?php
            						$item_types = unserialize(ITEM_TYPES);
            						foreach($item_types as $item)
            						{
            					?>
            						<option value="<?php echo $item; ?>"><?php echo ucfirst($item); ?></option>
            				<?php
            					}
            				?>
		            					</select>
            				</td>
            				<td valign="top" class="dataTables_empty"><a href="javascript:void(0);" id="add_more"><img src="<?php echo base_url(); ?>images/add_more.png" width="20" alt="Add More" ></a></td>
            			</tr>
            		</tbody>
            	</table>
            	<button class="btn btn-info" style="float:left; margin-left:10px; margin-top:10px;" type="submit">Submit</button>
                <img id="loader_icon" src="<?php echo base_url(); ?>assets/images/loader.gif" style="margin-top:20px;display:none">
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
	var item_code = $("#last_item_code").val();
	$('#table_report').on('click','.remove',function(){
		if(confirm('Are you confirm?'))
		{
			 var item_no = $("#last_item_code").val();
				
				$(this).parents('tr').remove();
				$('#table_report tbody tr').each(function(){
						$(this).find('input:first').val(item_no);
						item_no++
					});
					item_code = item_no-1;
			}
			else
				return false;
		});
	$('#add_more').click(function(){
				item_code++;
			var add_html = '<tr class="odd"><td valign="top" class="dataTables_empty"><input type="text" name="itemcode[]" value="'+item_code+'" readonly="readonly"></td><td valign="top" class="dataTables_empty"><input type="text" name="itemname[]" value=""></td><td valign="top" class="dataTables_empty"><select name="itemtype[]"><?php foreach($item_types as $item){?><option value="<?php echo $item; ?>"><?php echo ucfirst($item); ?></option><?php } ?></select></td><td valign="top" class="dataTables_empty"><a href="javascript:void(0)" class="remove"><img src="<?php  echo base_url(); ?>images/remove_icon.png" width="20" alt="Remove"></a></td></tr>';
			$('#table_report tr:last').after(add_html);
		});
	
	$( "#item_form" ).submit(function( event ) {
        
		f=0;
  				$('input[name="itemname[]"]').each(function(){
  				if($(this).val()=='')
  				{
  					 f++;	
  				}	
});

	if(f==0)
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
        swal("Please fill all item names !");  // sweetalert syntax
        return false;
    }
});		
		
		
})

</script>
	</body>
</html>
