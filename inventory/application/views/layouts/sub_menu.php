<style type="text/css">
input[type="text"] { width:150px; }
select{width:150px;}
.sub_nav1_outer{ width:100%; float:left;  margin-top:42px; }
.sub_nav1{ width:100%; max-width:740px; float:left ; }
.sub_nav1 ul{ margin:0px 0px 0px 80px; padding:0px; float:left; width:100%; }
.sub_nav1 li{ margin:0px; padding:0px; float:left; list-style-type:none; margin-left:1px; }
.sub_nav1 li a{ color:#fff; font-size:18px; display:block; text-decoration:none; padding:11px 44px; /* Firefox v4.0+ , Safari v5.1+ , Chrome v10.0+, IE v10+ and by Opera v10.5+ */
text-shadow:1px 1px 4px rgba(0,0,0,0.2); transition: all .2s ease-in-out;-moz-transition: all .2s ease-in-out;-webkit-transition: all .2s ease-in-out; padding:11px 44px 11px 43px\0/; *padding:11px 43px 11px 43px;
-ms-filter:"progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true)";zoom:1;
filter:progid:DXImageTransform.Microsoft.dropshadow(OffX=1,OffY=1,Color=#33000000,Positive=true);}
.sub_nav1 li a:hover { background-color:#fff; color:#0b6cbc;border-radius: 18px;}
.sub_nav1 li a.active1{ background-color:#fff; color:#0b6cbc;border-radius: 18px;}
</style>
<aside class="sub_nav1" >
<ul class="btn btn-info" style="float:right; margin-left:10px; margin-bottom:10px;	border-radius: 18px;">


<li ><a href="<?php echo base_url();?>customers/customer_general_settings/<?php echo $customer_id;?>" class="<?php echo ($active_tab == 'general_settings')?"active1":"";?>">General Settings</a></li>
<?php /*?><li><a href="<?php echo base_url();?>customers/payments/<?php echo $customer_id;?>" class="<?php echo ($active_tab == 'payments')?"active1":"";?>">Payments</a></li><?php */?>
<li><a href="<?php echo base_url();?>customers/transactions/<?php echo $customer_id;?>" class="<?php echo ($active_tab == 'transactions')?"active1":"";?>">Transactions</a></li>
<li><a href="<?php echo base_url();?>customers/graph/<?php echo $customer_id;?>" class="<?php echo ($active_tab == 'graph')?"active1":"";?>">Graph</a></li>
<li><a href="<?php echo base_url();?>customers/outstanding_report/<?php echo $customer_id;?>" class="<?php echo ($active_tab == 'outstanding')?"active1":"";?>">Outstanding</a></li>

</ul>
</aside>