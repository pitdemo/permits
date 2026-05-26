<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to <?php echo $this->lang->line('site_name'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-style">

<!--         <link href="<?php echo base_url();?>assets/css/simple-line-icons.css" rel="stylesheet">
 -->        <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" id="main-style">
        <style type="text/css">
            .alert{
                width:50%;
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
                <div class="login-box col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div><div>&nbsp;</div>
                    <center><?php $this->load->view('layouts/msg');?></center>
                    <div class="header">
                        <h2>Forgot Password</h2>
                    </div>

                    <form id="forgot_password" name="forgot_password" method="post" enctype="application/x-www-form-urlencoded">

                        <fieldset>
                            <div class="form-group first">
                                <div class="input-group col-sm-12">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control input-lg" name="email_address" id="email_address" placeholder="Email"/> 
                                </div>
                            </div>

                            <button type="submit" class="btn btn3 btn-lg col-xs-12">Submit</button>
                                <div class="row">
                                    <div class="col-xs-12 text-center"><br />
                                        <b><a style="color: black;" href="<?php echo base_url();?>users/">Login</a></b>
                                    </div><!--/col-->

                                </div><!--/row-->   

                        </fieldset> 

                    </form>

                </div>
            </div><!--/row-->   
        </div><!--/container-->

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <span class="sub-head"><strong>Reset Password</strong></span>
                    </div>
                    <div class="modal-body">
                        
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                        <button data-dismiss="modal" class="btn btn1" type="button" onClick="window.location.href='<?php echo base_url();?>users';">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div><!--/container-->


            <!-- start: JavaScript-->
            <!--[if !IE]>-->

            <script src="<?php echo base_url();?>assets/js/jquery-2.1.1.min.js"></script>

            <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
            <script>
                var base_url="<?php echo base_url();?>";
                $("#forgot_password").validate({
                    rules:{
                        email_address:{
                            required:true,
                            email:true
                        },
                    },
                    messages:
                    {
                        email_address:
                        {
                            required:'Please enter your email',
                        },
                    },
                    errorPlacement: function(error,element){
                        error.appendTo(element.parent().parent());                        
                    },
                    submitHandler:function(){
                        $("#forgot_password button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").attr('disabled','disabled');
                        var data = new FormData();                  
                        var $inputs = $('form#forgot_password :input');
                         $inputs.each(function() {
                                data.append(this.name,$(this).val());
                         });        
                     
                    $.ajax({
                        url: base_url+'users/forgot_mail',
                        type: 'POST',
                        "beforeSend": function(){ },
                        data: data,
                        cache: false,
                        processData: false, // Don't process the files
                        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
                        success: function(data, textStatus, jqXHR)
                        {
                            var data=data.trim();
                            if(data=='true'){
                                $('.btn1').show();
                                $('#myModal').modal('show');
                                $('.modal-body').html('We have sent you email to reset your password, please check your mailbox');
                                $("#forgot_password button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Done").attr('disabled','disabled');
                                return false;
                            }
                            else{
                                $('.modal-body').html(data);
                                $('.btn1').hide();
                                $('#myModal').modal('show');
                                $("#forgot_password button[type='submit']").html("Submit").prop('disabled',false);                                
                            }
                            //$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Done").prop('disabled',false);                            
                        },
                        error: function(data, textStatus,errorThrown)
                        {
                            //$("#form button[type='submit']").html("<i class=\"fa fa-dot-circle-o\"></i> Processing").prop('disabled',false);
                        }
                    });
                        return false;
                    }
                });
               /* $.extend($.validator.messages, {
                    required: "Required",
                });*/

            </script>

            
            <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>        

            <!-- page scripts -->

            <!-- end: JavaScript-->

            </body>
        </html>