<?php $this->load->view('layouts/admin_header',array('page_name'=>'Listing')); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
            <div class="right-side strech">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <!--breadcrumbs start -->
                            <ul class="breadcrumb">
                                <li ><a href="javascript:void(0);"><i class="fa fa-home"></i>Checklists</a></li>
                                <li><a href="javascript:void(0);">Permits</a></li>
                                <li><a href="<?php echo base_url(); ?>checklists/permit_checklists/">Checklists</a></li>
                                <li class="active"><a href="javascript:void(0);">Form</a></li>
                            </ul>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--progress bar start-->
                                    <section class="panel">
                                        
                                        <div class="panel-body">
                                        
                                       	<form name="form" id='form' method="post" enctype="application/x-www-form-urlencoded">
						<div class="acc-header">
                            	
                           <div class="row">

			    <div class="col-sm-12">

			        <div class="panel panel-default">
			            
			            <div class="panel-body">
                        
                        <?php $this->load->view('layouts/msg');?>
                        
			                <div class="row">

                            <div class="col-sm-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Select Permit*</label>
                                        <select class="form-control" name="permit_id" id="permit_id">
                                                <option value="">- - Select Permit - - </option>
                                                <?php 
                                                
                                                $val=(isset($info['permit_id'])) ? $info['permit_id'] : '';
                                                if(!empty($departments)){
                                                    foreach($departments as $list){?>
                                                <option value="<?php echo $list['id'];?>" <?php if(isset($val) && $val==$list['id']) { ?> selected="selected" <?php } ?>><?php echo $list['name'];?></option>
                                                <?php }} ?>
                                        </select>       
                                    </div>
                            </div>                           
                            <div class="col-sm-8">

                                <div class="form-group has-feedback">
                                    <label for="name">Checklist Name*</label>
                                        <input type="text" placeholder="Checklist name" class="form-control" value="<?php echo set_value('name',(isset($info['name'])) ? $info['name'] : ''); ?>" 
                                        name="name" id="name" >
                                        <?php echo form_error('name');?>
                                </div>

                            </div>

                            <div class="col-sm-4">
                                    <div class="form-group has-feedback">
                                        <label for="name">Select Additional Inputs (If any)</label>
                                        <select class="form-control additional_inputs" name="additional_inputs">
                                                <option value="">- - Select Additional Input - - </option>
                                                <?php  
                                                $val=(isset($info['additional_inputs'])) ? $info['additional_inputs'] : '';
                                                $additional_inputs=unserialize(CHECKLISTSADDITIONALINPUTS);
                                                    foreach($additional_inputs as $key => $value){?>
                                                <option value="<?php echo $key;?>" <?php echo $val==$key ? 'selected' : ''; ?>><?php echo $value;?></option>
                                                <?php } ?>
                                        </select>       
                                    </div>
                            </div>
                            <div class="col-sm-4" style="display:<?php echo $val<=1 ? 'none' : 'block' ?>;" id="input_infos_container">
                                    <div class="form-group has-feedback">
                                        <label for="name">Input Info*</label>
                                        <span id="input_info_2">
                                            <?php
                                            if($val>1) { 
                                            $val=(isset($info['input_infos'])) ? json_decode($info['input_infos'],true) : array(); } else {
                                                $val=array();
                                            }


                                            for($i=0;$i<=2;$i++) {

                                                $value=(isset($val[$i]) && $val[$i]!='') ? $val[$i] : '';
                                            ?>

                                                <input type="text" placeholder="Input Info Label" class="form-control" value="<?php echo $value; ?>" 
                                                name="input_infos[]" id="input_infos<?php echo $i; ?>" > <br />
                                            <?php
                                            }
                                            ?>
                                        </span>


                                    </div>
                            </div>

			                </div><!--/row-->

                           
			            </div>
			        </div>
			    </div><!--/col-->

			    <!--/col-->

			</div>
                           <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-dot-circle-o"></i> Submit</button>
                           <a  class="btn btn-sm btn-danger" href="<?php echo base_url();?>checklists/permit_checklists"><i class="fa fa-ban"> Cancel</i></a>                         
                            
						</div>
						</form>      
                                        </div>
                                    </section>
                                    <!--progress bar end-->

                                </div>
                            </div>

                            
                        </div>
                    </div>

                </section>
            </div>
            <!-- Right side column. Contains the navbar and content of the page -->
            
        </div>
<?php $this->load->view('layouts/footer'); ?>        
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function() {


    $('.additional_inputs').change(function(){

        var val=$(this).val();

        $('#input_infos_container').hide();

        if(val>1){
            $('#input_infos_container').show();
        }

    });

    $("#form").validate({ 
			rules: {
                name:{
                    required:true
                },
                permit_id:{
                    required:true
                },
                'input_infos[]': { required:function(element) { if($('#input_infos_container').is(':visible')==true) return true; else return false; },minlength:2 },	
            },
			messages:
			{
				name:{
                    required:'Required'
                },
                permit_id:{
                    required:'Required'
                }
			},
		errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
        submitHandler:function(){
                 $("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                form.submit();
        }
    });
    });

</script>