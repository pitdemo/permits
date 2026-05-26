<?php 
$page_name='Associate PI Account';
$this->load->view('layouts/header',array('page_name'=>$page_name)); ?>
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2-bootstrap.css" rel="stylesheet">
<style>
    .row{
        font-size:14px;
    }
</style>
<!-- start: Content -->
<div class="main create-con min-height">
    <div class="row">		
        <div class="col-lg-12">                
            <h1><?php echo $page_name;?></h1>
            <div class="panel panel-default">
			<?php $pi_account_number = isset($pi_account_num['fund_account_number'])?$pi_account_num['fund_account_number']:''; ?>
                <div class="acc-header">
                    <form role="form" id="form" name="form" method="post">
                        <div class="row">
                            <input type="hidden" id="id" name="id" value="<?php echo isset($accounts['id']) ? $accounts['id'] :'';?>" >
                            
                            <?php if( isset($accounts['id']) && $accounts['id'] !=''){ ?>
                                    <!--                  Edit FORM          -->
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">                                
                                    <label class="control-label">Account Name: </label>
                                    <br> 
                                    <span><input type="text" class="form-control" name="account_name" id="account_name" value="<?php echo $accounts['name'];?>"></span>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                    <label class="control-label">Account Type: </label>
                                    <br> 
                                    <span><?php echo $accounts['account_type'];?></span>
                                
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                    <label class="control-label">Fund Account No: </label>
                                    <br> 
                                    <span><?php echo $accounts['fund_account_number'] !=''?  $accounts['fund_account_number'] : '----------------------' ;?></span>
                                
                            </div>
                            
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                    <label class="control-label">PI Account No: </label>
                                    <br>
									<span>
									<?php if($pi_account_number!='') { ?><input type="hidden" name="associate_pi_number" value="<?php echo $pi_account_number; ?>" class="form-control associate_pi_number" id="associate_pi_number" data-account-text="<?php echo $pi_account_number; ?>" data-account-id="<?php echo $pi_account_number; ?>" disabled="disabled" /> <input type="hidden" name="select2_pi" value="1">
									<?php } else { ?>
									<input type="text" name="pi_number" value="" class="form-control" id="pi_number" />
									<input type="hidden" name="select2_pi" value="2">
									<?php } ?></span>
                                    <!--<span><?php //echo $accounts['pi_account_number'] !='' ?  $accounts['pi_account_number'] : '----------------------' ;?></span>-->
                                
                            </div>
                            <input type="hidden" value="<?php echo $accounts['tax_status'];?>" id="tax_status" name="tax_status">
                            <!--                  Edit FORM    FIRST ROW ENDS HERE      -->
                            <?php } ?>
                           
                        </div>
                        
                            <br>
                                
                        <div class="row">
                            
                              <!--                  Edit FORM    SECOND ROW       -->
                            <?php if( isset($accounts['id']) && $accounts['id'] !=''){ ?>
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                    <label class="control-label">Custodian: </label>
                                    <br> 
                                    <span><?php echo $accounts['custodian'];?></span>                                
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                    <label class="control-label" style="padding-right:10px;">Category: </label> <label  style="padding-right:30px; float:right; margin-left:10px;" class="rmd_hide">RMD:</label> 
                                    <br> 
                                    <span style="<?php echo $accounts['tax_status'] =='1' ?  'padding-right:45px' :'padding-right:10px';?>"><?php echo $accounts['tax_status'] =='1' ? 'Taxable' : 'Tax Deferred '.$accounts['tax_status'].'';?></span>                                                            
                                    <span class="rmd_hide"><?php echo $accounts['tax_status']==1? 'No' : 'Yes';?></span> 
                            </div>
                            
                            <?php }  ?>
                                    
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6 date_of_birth">
                                <div class="form-group">
                                    <label class="control-label">Date of Birth*</label>
                                    <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" placeholder="mm/dd/yyyy" id="dob" class="form-control" name="dob" tabindex="6" value="<?php echo isset($accounts['dob']) && $accounts['tax_status']>1 && $accounts['dob'] !='' && strtotime($accounts['dod'])>0 ? date("m/d/Y",strtotime($accounts['dob'])):'';?>" <?php echo ((isset($accounts['tax_status'])) ? $accounts['tax_status'] : '' )== 1 ? 'disabled' : '';?>>
                                    </div> 
                                    <label id="start_dt_error"></label>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6 date_of_death">
                                <div class="form-group">
                                    <label class="control-label">Date of Death</label>
                                    <div class="input-group date"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" placeholder="mm/dd/yyyy" id="dod" class="form-control" name="dod" tabindex="7" value="<?php echo isset($accounts['dod']) && $accounts['tax_status']>1 && $accounts['dod'] !='' && strtotime($accounts['dod'])>0 ? date("m/d/Y",strtotime($accounts['dod'])):'';?>" <?php echo ((isset($accounts['tax_status'])) ? $accounts['tax_status'] : '' )== 1 ? 'disabled' : '';?>>
                                    </div>
                                    <label id="end_dt_error"></label>
                                </div>
                            </div>
                                                        
                        </div>
                        
                        <!--<input type="hidden" name="account_type" id="account_type" value="pi">-->
						<input type="hidden" name="fund_account_no" id="fund_account_no" value="<?php echo ($accounts['fund_account_number']) ?  $accounts['fund_account_number'] : '' ;?>">
						<input type="hidden" name="custodian" id="custodian" value="<?php echo ($accounts['custodian']) ?  $accounts['custodian'] : '' ;?>">
						<input type="hidden" name="category" id="category" value="<?php echo $accounts['tax_status'] =='1' ? '1' : $accounts['tax_status'];?>">
                        
                        <br>
                        <button class="btn btn-sm btn-primary" type="submit" tabindex="8" ><i class="fa fa-dot-circle-o"></i> Match </button>
                        <a href='<?php echo base_url();?>accounts/index//filter_status/all/' class="btn btn-sm btn-danger" tabindex="9"><i class="fa fa-ban"></i> Back to home</a>
                        
                    </form>
<!--                    Form ENDS here -->
                </div>

            </div>
        </div><!--/col-->

    </div><!--/row-->

</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>

<script src="<?php echo base_url(); ?>assets/js/accounts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>

<script>
	function check_tax_status()
	{
		 if($("#tax_status").val()==1)
		 {
		 	$( ".date_of_birth" ).hide();
			$( ".date_of_death" ).hide();
		 }
		 else  
		 {
		 	$( ".date_of_birth" ).show();
			$( ".date_of_death" ).show();
		 }
	}
    $(document).ready(function() { 
	   <?php if( isset($accounts['id']) && $accounts['id'] !=''){ ?>
	    var check_taxable = '<?php echo ((isset($accounts['tax_status'])) ? $accounts['tax_status'] : '' )== 1 ? 'taxable' : '';?>';
		
		if(check_taxable=='taxable')
		{
			$(".rmd_hide").hide();
			$(".date_of_birth").hide();
			$(".date_of_death").hide();
		}
		  
        <?php } ?>
        $('#pi').prop('checked',true);
        //Account selection between PI or Non PI
        $('input[name=pi]').on('change',function(){
              pi_acc($(this));
        });
        
        function pi_acc($param){
            if($param.val()=='pi'){
                $('#account_type').val('pi');
                $('#pi_account_number').rules('add','required');                    
                $('#pi_account_number').prop('disabled',false).val('');
            }
            if($param.val()=='non-pi'){
                $('#account_type').val('non-pi');
                $('#pi_account_number').rules('remove','required');
                $('#pi_account_number').prop('disabled',true).val('');
            }
        }

        // validate signup form on keyup and submit
        $("#form").validate({
            rules: {
                account_name: { 
                    required:true,
                    minlength:5,
                    maxlength:75,
                  },
				pi_number: 
				{ 
					pi_format:true, 
					minlength:5,
					maxlength:75 
				},
                dob: { 
                    required:function(){
                        return $('#tax_status').val()!='1'   
                    },
					date_validation:
					{
						depends: function () {
                    		return $('#tax_status').val()!='1';
                		}
					}
                },
                dod:{
                    required:function(){
                      return $('#tax_status').val()!='1'   
                    },
					date_validation:
					{
						depends: function () {
                    		return $('#tax_status').val()!='1';
                		}
					}
                }

            },
			messages:{
				account_name: {
					required:"Required"
				}
            },
            errorPlacement:function(error,element){                
                if(element.attr("name") == "dob"){
                    error.appendTo("#start_dt_error");
                }
                else if(element.attr("name") == "dod"){
                    error.appendTo("#end_dt_error");
                }
                else {
                    error.insertAfter(element)
                }
            },
            submitHandler: function()
            {
                $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled');
                //Formatting data for ajax sending
                var data = new FormData();					
                var $inputs = $('form#form :input');
                $inputs.each(function() {
                    data.append(this.name,$(this).val());
                });	

                if($('#id').val()=='')
                    data.append('submit','insert');
                else
                    data.append('submit','update');
                
                $.ajax({
                    url: base_url+'accounts/pi_associate_form_action',
                    type: 'POST',
                    "beforeSend": function(){ },
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false, // Don't process the files
                    contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                    success: function(data, textStatus, jqXHR)
                    {
                        $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Done");							
                        if(data){
                            window.location.href='<?php echo base_url();?>accounts/index//filter_status/all/';
                        }
                    },
                    error: function(data, textStatus,errorThrown)
                    {
                        //$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").prop('disabled',false);
                        $('#error').show();

                        $('#error_msg').html(data.failure);

                    }
                });
            }			
        });
		
				$.validator.addMethod("date_validation",
								function(value, element) {
									return value.match(/^(0[1-9]|1[012])[/](0[1-9]|[12][0-9]|3[01])[/](19|20)\d\d+$/);
												},
								"Please enter correct date in the format(mm/dd/yyyy)"
							
							 );
			$.validator.addMethod('pi_format',function(value, element){
            return this.optional(element)	|| /^[a-z0-9]+-PI$/i.test(value);
        },"Please follow this format xxxxxxx-PI ");
    });
</script>

<?php $this->load->view('layouts/footer'); ?>