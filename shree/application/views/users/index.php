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
            <h2 class="h2 text-center mb-4">Login to your account</h2>      
            
            <center><?php $this->load->view('layouts/msg');?></center>

            <form id='login' name="login" method="post" enctype="application/x-www-form-urlencoded">
              <div class="mb-3">
                <label class="form-label">Email address OR Employee ID</label>         
                <div class="input-group input-group-flat">       
                        <input type="text" class="form-control input-lg" id="email_address" placeholder="your@email.com OR Employee ID" name="email_address" autocomplete="off" value="<?php echo set_value('email_address');?>" />        
                </div>                  
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password                
                </label>
                <div class="input-group input-group-flat">
                <input type="password" autocomplete="off" class="form-control input-lg" id="pass_word" placeholder="Password" name="pass_word"/>           
                   <span class="input-group-text">
                    <a href="#" class="link-secondary" title="Show Password" data-bs-toggle="tooltip" ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </a>
                  </span>                     
                </div>
              </div>             
              <div class="form-footer" style="text-align:center;">               
                <button type="submit" class="btn btn-primary w-100">Sign in </button>
                <br /><br />
                <a href="<?php echo base_url(); ?>users/forgot" style="color:red;">Forgot Password</a>
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
        
        $(document).ready(function(){
            
            $('.link-secondary').click(function(){
                var x = document.getElementById("pass_word");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            });

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

        });

    </script>
    <script type="text/javascript">document.getElementById('email_address').focus(); </script>

  </body>
</html>