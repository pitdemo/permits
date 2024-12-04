
<?php $this->load->view('layouts/header');?>
<style type="text/css">
input[type="text"] { width:150px; }
select{width:150px;}
.sub_nav1_outer{ width:100%; float:left;  margin-top:42px; }
.sub_nav1{ width:100%; max-width:750px; float:left ; }
.sub_nav1 ul{ margin:0px 0px 0px 60px; padding:0px; float:left; width:100%; }
.sub_nav1 li{ margin:0px; padding:0px; float:left; list-style-type:none; margin-left:1px; }
.sub_nav1 li a{ color:#fff; font-size:18px; display:block; text-decoration:none; padding:11px 44px; /* Firefox v4.0+ , Safari v5.1+ , Chrome v10.0+, IE v10+ and by Opera v10.5+ */
text-shadow:1px 1px 4px rgba(0,0,0,0.2); transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;-webkit-transition: all .2s ease-in-out; padding:11px 44px 11px 43px\0/; *padding:11px 43px 11px 43px;
-ms-filter:"progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true)";zoom:1;
filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true);}
.sub_nav1 li a:hover { background-color:#fff; color:#0b6cbc;border-radius: 18px;}
.sub_nav1 li a.active1{ background-color:#fff; color:#0b6cbc;border-radius: 18px;}
</style>

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
            <a href="<?php echo base_url();?>sales">Manage Customer</a>
            <span class="divider"><i class="icon-angle-right"></i></span>
         </li>
        <li class="active">Customer Payments</li>
      </ul>
      <!--.breadcrumb-->
      
      
    </div>
    <div id="page-content" class="clearfix"> 

        
      <!--/.page-header-->
     
      <div class="row-fluid"> 
        <!--PAGE CONTENT BEGINS HERE-->
        
        <div class="row-fluid">
          <div class="page-header position-relative" style="border-bottom:none !important;">
           
          </div>
          <div class="row-fluid" > 
            <!--PAGE CONTENT BEGINS HERE-->
          <aside class="sub_nav1" >
<ul class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;	border-radius: 18px;">

<!--<li ><a href="exams_list.html" >Exams</a></li>
<li><a href="questions_list.html" class="active1">Questions</a></li>
<li><a href="reports.html">Reports</a></li>-->

<li ><a href="javascript:void(0);" class="<?php echo ($active_tab == 'general_settings')?"active1":"";?>">General Settings</a></li>
<li><a href="javascript:void(0);" class="<?php echo ($active_tab == 'contacts')?"active1":"";?>">Contacts</a></li>
<li><a href="javascript:void(0);" class="<?php echo ($active_tab == 'transactions')?"active1":"";?>">Transactions</a></li>
<li><a href="javascript:void(0);" class="<?php echo ($active_tab == 'sales_order')?"active1":"";?>">sales order</a></li>


</ul>
</aside>

          
                       
        <!--PAGE CONTENT ENDS HERE--> 
      </div>
      <div class="clearfix"></div><br/><br/>
       <?php $this->load->view('layouts/footer');?>
    </div>
    <!--/#page-content--> 
  </div>
  <!--/#main-content--> 
</div>
<?php $this->load->view('layouts/footer_script');?>

	</body>
</html>
