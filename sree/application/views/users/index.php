<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?php echo base_url();?>">
        <title>Welcome to <?php echo $this->lang->line('site_name'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-style">

        <link href="<?php echo base_url();?>assets/css/simple-line-icons.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" id="main-style">
    <style type="text/css">
    .alert{
        width:70%;
    }
    </style>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="login login-con">
        <div class="container">
            <div class="row">
                 
                <div class="login-box col-lg-4 col-lg-offset-4 col-sm-12 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        
                        <div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                        <center><?php $this->load->view('layouts/msg');?></center>
                    <div class="header">
                        <h2>Login</h2>
                    </div>
                    <form id='login' name="login" method="post" enctype="application/x-www-form-urlencoded">

                        <fieldset>
                            <div class="form-group first">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control input-lg" id="email_address" placeholder="Username" name="email_address" autocomplete="off"  value="" />  
                                </div>
                            </div>

                            <div class="form-group last">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                    <input type="password" autocomplete="off" class="form-control input-lg" id="pass_word" placeholder="Password" name="pass_word" value=""/>                        
                                </div>
                            </div>

                            <button type="submit" class="btn btn3 btn-lg col-xs-12">Login </button>
                            <!-- swathi - start -->
                            <div class="row">
                                <div class="col-xs-12 text-center"><br />
                                    <!-- <b><a style="color: black;" href="<?php echo base_url();?>users/forgot_password/">Forgot Password</a></b> -->
                                </div><!--/col-->
                            </div><!--/row-->  
                            <!-- swathi - end -->
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
        $("#login").validate({
            rules:{
                email_address:{
                    required:true
                },
                pass_word:{
                    required:true
                }
            },
            messages:
            {
                email_address:
                {
                    required:'Please enter your email',
                },
                pass_word:{
                    required:'Please enter your password'
                }
            },
        errorPlacement: function(error,element){
            error.appendTo(element.parent().parent());                        
        },
            submitHandler:function(){
                 $("#login button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing");
                login.submit();
            }
        });
      

        </script>

      
        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>        
        <script type="text/javascript">document.getElementById('email_address').focus(); </script>
        <!-- page scripts -->

        <!-- end: JavaScript-->

    </body>
</html>