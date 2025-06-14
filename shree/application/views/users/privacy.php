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
   
      <div class="container">
        <div class="text-center mb-4" style="display:<?php echo $show_logo; ?>;">
          <a href="." class="navbar-brand navbar-brand-autodark">
          <img src="<?php echo base_url();?>assets/img/logo.png" alt="Tabler" class="navbar-brand-image">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Privacy Policy</h2>      
            
            <center><?php $this->load->view('layouts/msg');?></center>

            <form id='forgot_password' name="forgot_password" method="post" enctype="application/x-www-form-urlencoded">
              <div class="mb-12">

              <b>1. Information We Collect</b> <p>
We may collect the following types of personal and system-related information:</p>

<p><b>a. User Information</b>
<ul>
    <li>Name, Email ID, Phone Number</li>
    <li>Employee ID and Department</li>
    <li>User Role (e.g., Custodian, Issuer, Safety Officer)</li>
</ul>
    </p>

<p><b>b. Permit Data</b>

<ul>
    <li>Permit details (Type, Department, Description, Status)</li>
    <li>Site Location (may include GPS data)</li>
    <li>Attachments (e.g., documents, photos, signatures)</li>
    <li>Time logs (creation, approval, closure)</li>
    </ul>
    </p>


<p><b>c. Device and App Usage Data</b>

<ul>
    <li>Device ID, OS version</li>
    <li>IP address</li>
    <li>App version, login timestamps</li>
    <li>Error and crash reports</li>
    </ul>
    </p>


<p><b>2. How We Use Your Information</b></p>
<p>We use the collected data to:</p>

<ul>
    <li>Create and manage permits.</li>
    <li>Authenticate and authorize users.</li>
    <li>Track and audit permit activities.</li>
    <li>Improve app performance and user experience.</li>
    <li>Send notifications (e.g., approvals, safety alerts).</li>
    </ul>


<p><b>3. Information Sharing</b></p><p>
We do not sell or rent your personal information. However, data may be shared with:

    <ul>
        <li>Authorized company personnel (based on role and access control)</li>
        <li>Legal or regulatory authorities when required by law</li>
        <li>Cloud service providers for secure hosting and backup</li>
</ul>    
</p>

<p><b>4. Data Storage and Security</b>
<ul>
    <li>Data is stored securely on [Cloud Provider Name] servers.</li>
<li>We use encryption (SSL/TLS) for data in transit and at rest.</li>
<li>Access is restricted using role-based authentication.</li>
</ul></p>

<p><b>5. User Rights</b>
You have the right to:

<ul><li>Access and update your personal data</li>
<li>Request data deletion (subject to approval policies)</li>
<li>Raise concerns via our support or data protection team</li>
</ul></p>

<p><b>6. Data Retention</b></p><p>
Permit data is retained as per legal and company compliance policies, usually for a minimum of [e.g., 5 years] unless requested otherwise by management.</p>


<p><b>7. Cookies & Tracking (if applicable on web app)</b></p><p>
Our web application may use session cookies to maintain login state. No third-party tracking cookies are used.
</p>

<p><b>8. Updates to the Privacy Policy</b></p><p>
We may update this privacy policy periodically. Users will be notified via email or app alert when significant changes are made.
</p>

<p><b>9. Contact Us</b></p><p>
For questions or concerns about this policy, please contact:

<p><b>PIT Infotech</b></p>
<p><b>info@pitinfotech.com</b></p>

</p>
                           
              </div>
                       
              <div class="form-footer" style="text-align:center;">  
                <a href="<?php echo base_url(); ?>users" style="color:red;">Sign In</a>
              </div>
            </form>
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