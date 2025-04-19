<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<?php
$show_logo=(isset($_GET['mode']) && $_GET['mode']=='mobile') ? 'none' : 'block';
?>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Welcome to <?php echo $this->lang->line('site_name'); ?></title>
    <link rel="icon" href="<?php echo base_url(); ?>assets/img/Daco_4764006.png" sizes="16x16" >
    <!-- CSS files -->
    <link href="<?php echo base_url();?>assets/latest/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/latest/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/latest/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/latest/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/latest/css/demo.min.css?1692870487" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/latest/css/custom.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
   
      .navbar-brand-image{
        height:7rem !important;
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="<?php echo base_url();?>assets/latest/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4" style="display:<?php echo $show_logo; ?>;">
          <a href="." class="navbar-brand navbar-brand-autodark">
          <img src="<?php echo base_url();?>assets/img/logo.png" alt="Tabler" class="navbar-brand-image">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Recover to your account</h2>      
            
            <center><?php $this->load->view('layouts/msg');?></center>

            <form id='forgot_password' name="forgot_password" method="post" enctype="application/x-www-form-urlencoded">
              <div class="mb-3">
                <label class="form-label">Email address OR Employee ID</label>         
                <div class="input-group input-group-flat">       
                        <input type="text" class="form-control input-lg" id="email_address" placeholder="your@email.com OR Employee ID" name="email_address" autocomplete="off" value="<?php echo set_value('email_address');?>" />        
                </div>                  
              </div>
                       
              <div class="form-footer" style="text-align:center;">               
                <button type="submit" class="btn btn-primary w-100">Forgot </button> 
                <br /><br />
                <a href="<?php echo base_url(); ?>users" style="color:red;">Sign In</a>
              </div>
            </form>
          </div>        
        </div>       
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?php echo base_url();?>assets/latest/js/tabler.min.js?1692870487" defer></script>
    <script src="<?php echo base_url();?>assets/latest/js/demo.min.js?1692870487" defer></script>
    <script src="<?php echo base_url();?>assets/latest/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/latest/js/jquery.validate.min.js"></script>
    <script>
                var base_url="<?php echo base_url();?>";
                $("#forgot_password").validate({
                    rules:{
                        email_address:{
                            required:true
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
                            window.location.href='<?php echo base_url(); ?>';
                                                
                        },
                        error: function(data, textStatus,errorThrown)
                        {
                           
                        }
                    });
                        return false;
                    }
                });
               /* $.extend($.validator.messages, {
                    required: "Required",
                });*/

            </script>
    <script type="text/javascript">document.getElementById('email_address').focus(); </script>

  </body>
</html>