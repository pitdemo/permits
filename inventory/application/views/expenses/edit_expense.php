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
            <a href="<?php echo base_url();?>expenses">Manage Expenses</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Edit Expense Details</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 
      
      <!--/.page-header-->
      
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative">
            <h1>Edit Expense Details</h1>
          </div>
          <div class="row-fluid"> 
            <!--PAGE CONTENT BEGINS HERE-->
            <form class="form-horizontal" action="" method="post" name="expense_form" id="expense_form">
            <div class="control-group">
      								<label class="control-label" for="form-field-1">Category<sup>*</sup></label>
                <div class="controls">
                    <select name="category_id" id="category_id" style="width:220px">
                       <?php
                            // display expense category based on optgroup
                        if(!empty($categories))
                        {
                            echo "<optgroup label='Category Name'>";
                            foreach($categories as $category)
                            {
                                $selected_opt='';
                               
                                    if($expense_details['category_id']==$category['id'])
                                        $selected_opt = "selected='selected'";
                             // end
                        ?>
                           <option value="<?php echo $category['id']; ?>-s" <?php echo $selected_opt; ?>><?php echo ucfirst($category['expense_category']); ?></option>
                        <?php
                            }
                            echo "</optgroup>";
                        }
    
                        ?>
                       
                       
                    </select>   													
                    <?php echo form_error('category_id');?>
                </div>
            </div>
            
          
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Expense date<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="expense_date" id="expense_date" class="expense_entry_date" placeholder="Expense date" value="<?php echo set_value('expense_date',isset($expense_details['expense_date'])? $expense_details['expense_date'] : ''); ?>" >
                    <?php echo form_error('expense_date');?>
                </div>
            </div>
            
            <div class="control-group">
      		    <label class="control-label" for="form-field-1">Amount<sup>*</sup></label>
                <div class="controls">
				   <input type="text"  name="amount" id="amount" class="amount_box" placeholder="Amount" value="<?php echo set_value('amount',isset($expense_details['amount'])? $expense_details['amount'] : ''); ?>" >
                    <?php echo form_error('amount');?>
                </div>
            </div>
            
             <div class="control-group">
      		    <label class="control-label" for="form-field-1">Description<sup>*</sup></label>
                <div class="controls">
				   <textarea rows="2" name="description" id="description"  placeholder="Description"><?php echo set_value('description',isset($expense_details['description'])? $expense_details['description'] : ''); ?></textarea>
                    <?php echo form_error('description');?>
                </div>
            </div>
            
      <div class="control-group">
        <div class="controls">       
      <button type="submit" name="add" class="btn btn-info" > Update <span class="right"><i class="fa fa-arrow-right mr-10 mt-10" style="font-size:16px;"></i></span></button> &nbsp;&nbsp;
      <button class="btn" type="reset" onClick="window.location.href='<?php echo base_url();?>expenses'"> Cancel </button>
      </div>
      </div>
      <aside class="clear"></aside>
    </form>
            
            <!--PAGE CONTENT ENDS HERE--> 
          </div>
        </div>
        
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
      <!--/row--> 
    </div>
    <!--/#page-content--> 
    
    <!--/#ace-settings-container--> 
  </div>
  <!--/#main-content--> 
</div>
<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
	<?php $this->load->view('layouts/footer_script');?> 
		<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.validate.min.js'></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/jquery.datetimepicker.css"/>
<script src="<?php echo base_url();?>js/jquery.datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>js/accounting.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/select2.css"/>
<script src="<?php echo base_url();?>js/select2.min.js" type="text/javascript"></script>
		<script type="text/javascript">
				$(document).ready(function(){
                   
                    $('select').select2(); // select box select2 plugin
                    
                    // date picker for expense date
                    $('.expense_entry_date').datetimepicker(
                        {
	                       format:'Y-m-d',
	                       //minDate : 0,
                          timepicker:false,
						  maxDate: 0,
                        });	
                    
                   
                        //end
                   // amount conversion script code
                        $(".amount_box").blur(function(){
                          res =  accounting.formatMoney($(this).val(),'');
                          $(this).val(res);
                        });
                    //end	
                    // form validation start
					var validator = $("#expense_form").validate({
					errorClass:'error-val',
					ignore: "",
						rules:
					{
							category_id:
							{
								required:true
							},
                            expense_date:
                            {
                                required:true,
                            },
							description:
                            {
                                required:true,
                            },
							amount:
                            {
                                required:true,
                            },
                           
                            
                            
					},
					messages:
					{
						category_id:
						{
							required: 'Please choose expense categoty'
						},
                        expense_date:
                        {
                            required:'Please choose expense date',
                        },
						 description:
                        {
                            required:'Please fill the description field',
                        },
						 amount:
                        {
                            required:'Please fill the description field',
                        },
                      
					},
					errorPlacement: function(error, element)
					{						
						error.insertAfter(element);						
					},
					submitHandler: function()
					{
						document.expense_form.submit();
						$('button[type=submit], input[type=submit]').attr('disabled',true);
					},
						wrapper: "div"
					});
				});
		
		</script>
 </body>
</html>
