<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?php echo base_url();?>">
        <title>Welcome to Formwork</title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-style">

        <link href="<?php echo base_url();?>assets/css/simple-line-icons.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" id="main-style">
    <style type="text/css">
    .alert{
        width:50%;
    }
    </style>
      
    </head>

    <body class="login login-con">
        <div class="container">
            <div class="row">
                <div class="login-box col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                    <center><?php $this->load->view('layouts/msg');?></center>
                    <div class="header">
                        <h1><?php echo $this->lang->line('site_name'); ?></h1>
                    </div>

                    <form id='change_forgot_password' name="change_forgot_password" method="post" enctype="application/x-www-form-urlencoded">

                        <fieldset>
                            <div class="form-group first">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" class="form-control input-lg" id="new_password" placeholder="New Password" name="new_password" value="<?php echo set_value('new_password');?>" />    
                                </div>
                            </div>

                            <div class="form-group last">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" class="form-control input-lg" id="conf_password" placeholder="Confirm Password" name="conf_password"/>                       
                                </div>
                            </div>

                            <button type="submit" class="btn btn3 btn-lg col-xs-12">Update </button>
                        </fieldset> 
                    </form>
                </div>                
            </div><!--/row-->   
        </div><!--/container-->
    

        <!-- start: JavaScript-->
        <!--[if !IE]>-->

        <script src="<?php echo base_url();?>assets/js/jquery-2.1.1.min.js"></script>

        <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
        <script>
        $("#change_forgot_password").validate({
            rules:{
                new_password:{
                    required:true,
                    minlength:6,
                    maxlength:15
                },
                conf_password:{
                    required:true,
                    equalTo:'#new_password'
                }
            },
        errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        }
        });
        $.extend($.validator.messages, {
            required: "Required",
        });

        </script>

     
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>        

    
    </body>
</html>