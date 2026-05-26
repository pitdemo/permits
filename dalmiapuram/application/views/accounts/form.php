<?php 
$page_name='Create Account';
if(!empty($accounts)){
    $page_name='View/Edit Account';
}
$this->load->view('layouts/header',array('page_name'=>$page_name)); ?>
<link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
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
                <div class="acc-header">
                    <form role="form" id="form" name="form" method="post">
                        <div class="row">
                            <input type="hidden" id="id" name="id" value="<?php echo isset($accounts['id']) ? $accounts['id'] :'';?>" >
                            
                            <?php if( isset($accounts['id']) && $accounts['id'] !=''){ ?>
                                    <!--                  Edit FORM          -->
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">                                
                                    <label class="control-label">Account Name: </label>
                                    <br> 
                                    <span><input type="text" class="form-control" placeholder="" name="name" tabindex="2" value="<?php echo ($accounts['name'])?$accounts['name']:'';?>"></span>
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
                                    <span><?php echo $accounts['pi_account_number'] !='' ?  $accounts['pi_account_number'] : '----------------------' ;?></span>
                                
                            </div>
                            <input type="hidden" value="<?php echo $accounts['tax_status'];?>" id="tax_status" name="tax_status">
                            <!--                  Edit FORM    FIRST ROW ENDS HERE      -->
                            <?php } else { ?>
                                <!--                            ADD FORM STARTS HERE    -->
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                <div class="form-group">                                    
                                    
                                    <label class="control-label">Account Name*</label>
                                    <input type="text" class="form-control" placeholder="" id="name" name="name" tabindex="2" value="">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                <label class="control-label">Select Account</label>
                                <br>
                                <input type="radio"  value="pi" name="pi" id="pi" tabindex="3" >  
                                <label class="control-label" for="pi"><?php echo PI; ?></label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                <input type="radio"  value="non-pi" name="pi" id="non-pi" tabindex="4">
                                <label class="control-label" for="non_PI"><?php echo NonPI; ?></label>
                            </div>

                            
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Funding Account No*</label>
                                    <input type="text" class="form-control" placeholder="" name="fund_account_number" id="fund_account_number"  tabindex="4">
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">PI Account No</label>
                                    <input type="text" class="form-control" placeholder="" name="pi_account_number" id="pi_account_number" tabindex="4" value="">
                                    <span style="font-size:12px;"> Ex: XXXXXXX-PI</span>
                                </div>
                            </div>
                            <!--                            ADD FIRST FORM ENDS HERE    -->
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
                            
                            <?php } else { ?>
                                    <!--                            ADD FORM SECOND ROW         -->
                            <div class="col-lg-3 col-md-2 col-sm-4 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Custodian</label>
                                    <div class="input-group date"> 
                                    <select class="form-control" name="custodian" id="custodian" tabindex="5" style="width: 260px;">  
                                    	<?php
										$custodians=unserialize(CUSTODIANS);
										foreach($custodians as $custodian):
										?>	                                          	
                                        <option value="<?php echo $custodian; ?>" ><?php echo $custodian; ?></option>
                                        <?php
										endforeach;
										?>
                                    </select>
                                    </div>
                                  
                                </div>
                            </div>                            
                          		  <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                                <div class="form-group">
                                    <label class="control-label">Category*</label>
                                    <select class="form-control" name="tax_status" id="tax_status" tabindex="5" onchange="check_tax_status();">                                            	
                                        <option value="" selected>Select</option>
                                        <option value="1">Taxable</option>
                                        <option value="2">Tax Deferred 2</option>
										<option value="3">Tax Deferred 3</option>
                                    </select>
                                </div>
                            </div>

                            <?php } ?>  
                                
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
                        
                        <input type="hidden" name="account_type" id="account_type" value="pi">
                        
                        <?php if(!empty($accounts)) {?>
						<br />
                        <button class="btn btn-sm btn-primary" type="submit" tabindex="8" ><i class="fa fa-dot-circle-o"></i> Save </button>
                        <a href='<?php echo base_url();?>accounts/index//filter_status/all/' class="btn btn-sm btn-danger" tabindex="9"><i class="fa fa-ban"></i> Back to home</a>
                        <?php } else { ?>
                        <button class="btn btn-sm btn-primary" type="submit" tabindex="8" ><i class="fa fa-dot-circle-o"></i> Submit</button>
                        <button class="btn btn-sm btn-danger" type="reset" tabindex="9"><i class="fa fa-ban" ></i> Reset</button>
                        <?php }  ?>

                    </form>
<!--                    Form ENDS here -->
                </div>

            </div>
        </div><!--/col-->

    </div><!--/row-->

</div>
<!-- end: Content -->

<?php $this->load->view('layouts/footer_script'); ?>


<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
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
				$("#custodian option[value='Alternative Investment']").show();
            }
            if($param.val()=='non-pi'){
                $('#account_type').val('non-pi');
                $('#pi_account_number').rules('remove','required');
                $('#pi_account_number').prop('disabled',true).val('');
				$("#custodian option[value='Alternative Investment']").hide();
            }
        }
        

        //Datepicker from today's date
        /*var date = new Date();
        var currentMonth = date.getMonth();
        var currentDate = date.getDate();
        var currentYear = date.getFullYear();
        //Date of Birth
        $('#dob').datepicker({
            autoclose:true,
            clearBtn:true,
            minDate: new Date(currentYear, currentMonth, currentDate),
            endDate:new Date(currentYear, currentMonth, currentDate),
        });*/
        
        //Date of Death 
        /*$('#dod').datepicker({
            autoclose:true,
            clearBtn:true,
            minDate: new Date(currentYear, currentMonth, currentDate),
            startDate:new Date(currentYear, currentMonth, currentDate),
        });*/

        // validate signup form on keyup and submit
        $("#form").validate({
            rules: {
                name: { 
                    required:true,
                    minlength:5,
                    maxlength:75,
                  },
                pi_account_number: { required:true,pi_format:true, minlength:5,maxlength:75,remote: {
                    url:base_url+"accounts/ajax_data_exists/id/"+$('#id').val(),
                    type:"post",
                    data:{
                        pi_account_number: function(){
                            return $("#pi_account_number").val();
                        }
                    },
                    async:false 
                } },
                fund_account_number: { required:true,
                  minlength:5,maxlength:75,remote: {
                    url:base_url+"accounts/ajax_data_exists/id/"+$('#id').val(),
                    type:"post",
                    data:{
                        fund_account_number: function(){
                            return $("#fund_account_number").val();
                        }
                    },
                    async:false 
                } },                
                pi: { required:true },
                tax_status: { required:true },
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
                pi_account_number:{
                    remote:"Given PI account number already exists."
                },
                fund_account_number:{
                    remote:"Given funding account number already exists."
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
                    url: base_url+'accounts/form_action',
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
                            window.location.href='<?php echo base_url();?>accounts';
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
		
        $.extend($.validator.messages, {
            required: "Required",
            remote:"GIve Account Number Already Exists! Please Check...!"
        });
        $.validator.addMethod('name_format',function(value, element){
            return this.optional(element)	|| /^[a-zA-Z\s.']+$/i .test(value);
        },"Please enter Only Characters");
        
        $.validator.addMethod('pi_format',function(value, element){
            return this.optional(element)	|| /^[a-z0-9]+-PI$/i.test(value);
        },"Please follow this format xxxxxxx-PI ");
        
    });
</script>

<?php $this->load->view('layouts/footer'); ?>