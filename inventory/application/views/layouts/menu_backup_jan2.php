<?php
            // USER_ROLES defined in constant file
      $user_roles = unserialize(USER_ROLES);
      // USER_PERMISSIONS defined in constant file
      $user_permissions = unserialize(USER_PERMISSIONS);
      $allowed_tab_permission = $this->session->userdata('session_permissions');
      $allowed_tab_permissions = explode(',',$allowed_tab_permission);  
      
?>
<div id="sidebar"> 
    
    <!--#sidebar-shortcuts-->
     
    <ul class="nav nav-list">  
    <?php
            //$user_permissions[0] is customers(customers tab is only visible to authorized users)
    $array_order=array($user_permissions[0],$user_permissions[1],$user_permissions[2],$user_permissions[14]); //change for display report menu for all role user except viewer
    if($this->session->userdata('session_user_type')== $user_roles[0]  || array_intersect($array_order,$allowed_tab_permissions))
      {
      ?>
      <li <?php echo (in_array($menu,array('items','customers','suppliers','ledger'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i>
     
         <span>Master</span> <b class="arrow icon-angle-down"></b> </a>    <?php } ?>
         <ul class="submenu" <?php echo (in_array($menu,array('items','customers','suppliers','ledger'))?'style="display: block;"':"");?>>
   
        <?php
            //$user_permissions[0] is customers(customers tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[0],$allowed_tab_permissions))
       {
      ?>
         <li <?php echo ($menu == "customers")?'class="active"':"";?>> <a href="<?php echo base_url('customers'); ?>"> <i class="icon-double-angle-right"></i>Customers </a> </li>
         <?php } ?>
         
          <?php
    
            //$user_permissions[1] is items(items tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0] || in_array($user_permissions[1],$allowed_tab_permissions))
       {
    
       ?>
         <li <?php echo ($menu == "items")?'class="active"':"";?>> <a href="<?php echo base_url('items');?>"> <i class="icon-double-angle-right"></i> <span>Items</span> </a> </li>
          <?php } ?>
            <?php
            //$user_permissions[2] is suppliers(suppliers tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[2],$allowed_tab_permissions))
       {
       ?>
         <li <?php echo ($menu == "suppliers")?'class="active"':"";?>> <a href="<?php echo base_url('suppliers');?>"> <i class="icon-double-angle-right"></i> <span>Suppliers</span> </a> </li>
          <?php } ?>
          
           <?php
  //print_r($user_permissions);
  //  exit;
            //$user_permissions[1] is items(items tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  ||  in_array($user_permissions[14],$allowed_tab_permissions))
       {
    
       ?>
         <li <?php echo ($menu == "ledger")?'class="active"':"";?>> <a href="<?php echo base_url('ledger');?>"> <i class="icon-double-angle-right"></i> <span>Direct Ledger</span> </a> </li>
          <?php 
      
      } ?>
        </ul>
    </li> 
    
    <?php
    $array_order=array($user_permissions[3],$user_permissions[13]);
    if($this->session->userdata('session_user_type')== $user_roles[0]  || array_intersect($array_order,$allowed_tab_permissions))
       {
      ?>
    <li <?php echo (in_array($menu,array('sales','customer_payments','sales person'))?'class="active"':"");?>> <a href="<?php echo base_url('customer_payments'); ?>" class="dropdown-toggle"> <i class="icon-double-angle-right"></i>
     <span>Sales</span> <b class="arrow icon-angle-down"></b> </a><?php } ?>
       <ul class="submenu" <?php echo (in_array($menu,array('sales','customer_payments','sales person'))?'style="display: block;"':"");?>>
            <?php
      
      
            //$user_permissions[3] is sales lists(sales lists tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0] || in_array($user_permissions[3],$allowed_tab_permissions))
       {
      ?>
           <li <?php echo ($menu == "sales")?'class="active"':"";?>> <a href="<?php echo base_url('sales'); ?>"><i   class="icon-double-angle-right"></i> <span>Sales Lists</span> </a> </li>
             <?php } ?>
             
             
             
               <?php
            //$user_permissions[4] is customer payments(customer payments lists tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[4],$allowed_tab_permissions))
       {
      ?>
              <!-- <li <?php //echo ($menu == "customer_payments")?'class="active"':"";?>> <a href="<?php //echo base_url('customer_payments'); ?>"> <i  class="icon-double-angle-right"></i> <span>Customer Payments</span> </a> </li> -->  <?php } ?>
              
               <?php
            //$user_permissions[4] is customer payments(customer payments lists tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0] || in_array($user_permissions[13],$allowed_tab_permissions))
       {
      ?>
               <li <?php echo ($menu == "sales person")?'class="active"':"";?>> <a href="<?php  echo base_url('sales_person'); ?>"> <i  class="icon-double-angle-right"></i> <span>Sales Person</span> </a> </li>   <?php } ?>
             
        </ul>
    </li>  
    
    <?php
      $array_order=array($user_permissions[4]);
    if($this->session->userdata('session_user_type')== $user_roles[0] || array_intersect($array_order,$allowed_tab_permissions))
       {
      ?>  
    
   <li <?php echo (in_array($menu,array('purchase'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i> <span>Purchase</span> <b class="arrow icon-angle-down"></b> </a> <?php } ?>
     <ul class="submenu" <?php echo (in_array($menu,array('purchase'))?'style="display: block;"':"");?>>
      <?php
            //$user_permissions[5] is purchase lists(purchase lists tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[4],$allowed_tab_permissions))
       {
      ?>
          <li <?php echo ($menu == "purchase")?'class="active"':"";?>> <a href="<?php echo base_url(); ?>purchases"> <i class="icon-list-alt"></i> <span>Purchase Lists</span> </a> </li><?php } ?>
        </ul>
    </li> 
     <?php
        $array_order=array($user_permissions[5]);
    if($this->session->userdata('session_user_type')== $user_roles[0] ||  array_intersect($array_order,$allowed_tab_permissions))
       {
      ?> 
     <li <?php echo (in_array($menu,array('receipts'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i> <span>Receipts</span> <b class="arrow icon-angle-down"></b> </a> <?php } ?>
     <ul class="submenu" <?php echo (in_array($menu,array('receipts'))?'style="display: block;"':"");?>>
     <?php
            //$user_permissions[6] is daily receipt entry( daily receipt entry tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0] ||  in_array($user_permissions[5],$allowed_tab_permissions))
       {
      ?>
          <li <?php echo ($menu == "receipts")?'class="active"':"";?>> <a href="<?php echo base_url(); ?>receipts"> <i class="icon-list-alt"></i> <span></span> Daily Receipt Entry</a> </li> <?php } ?>
        </ul>
    </li> 
     <?php
       $array_order=array($user_permissions[6]);
    if($this->session->userdata('session_user_type')== $user_roles[0] || array_intersect($array_order,$allowed_tab_permissions))
       {
      ?> 
     <li <?php echo (in_array($menu,array('manufacture'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i> <span>Manufacture</span> <b class="arrow icon-angle-down"></b> </a> <?php } ?>
     <ul class="submenu" <?php echo (in_array($menu,array('manufacture'))?'style="display: block;"':"");?>>
      <?php
            //$user_permissions[7] is manufacturing lists(manufacturing lists tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[6],$allowed_tab_permissions))
       {
      ?>
          <li <?php echo ($menu == "manufacture")?'class="active"':"";?>> <a href="<?php echo base_url(); ?>manufacturing"> <i class="icon-list-alt"></i> <span>Manufacturing Lists</span> </a> </li>
            <?php } ?>
        </ul>
    </li>  
    
      <?php
       $array_order=array($user_permissions[7]);
    if($this->session->userdata('session_user_type')== $user_roles[0]  || array_intersect($array_order,$allowed_tab_permissions))
       {
      ?>    
   <li <?php echo (in_array($menu,array('expenses'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i>
      <span>Expenses</span> <b class="arrow icon-angle-down"></b> </a> <?php } ?>
      <ul class="submenu" <?php echo (in_array($menu,array('expenses'))?'style="display: block;"':"");?>>

           <?php
            //$user_permissions[8] is expense entry(expense entry tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  ||  in_array($user_permissions[7],$allowed_tab_permissions))
       {
      ?>  
          <li <?php echo ($menu == "expenses")?'class="active"':"";?>> <a href="<?php echo base_url(); ?>expenses"> <i class="icon-list-alt"></i> <span>Expenses Entry</span> </a> </li>
        <?php } ?></ul>
    </li>   
  
      <?php
       $array_order=array($user_permissions[8],$user_permissions[9],$user_permissions[10],$user_permissions[11],$user_permissions[12],$user_permissions[15]); //change for display report menu for all role user except viewer
    if($this->session->userdata('session_user_type')== $user_roles[0]  || $this->session->userdata('session_user_type')== $user_roles[1] || $this->session->userdata('session_user_type')== $user_roles[2] || array_intersect($array_order,$allowed_tab_permissions)) //change for display report menu for all role user except viewer
       {
      ?> 
        <li <?php echo (in_array($menu,array('outstanding','negative outstanding','manufacture_report','inventory_report','pending_bills','sales_month','outstanding_report','expenses_report'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i> <span>Reports</span> <b class="arrow icon-angle-down"></b> </a> <?php } ?>
         <ul class="submenu" <?php echo (in_array($menu,array('outstanding','negative outstanding','manufacture_report','inventory_report','pending_bills','sales_month','outstanding_report'))?'style="display: block;"':"");?>>
          
    <?php
            //$user_permissions[9] is sales report(sales report tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[8],$allowed_tab_permissions))
      {
      ?>  
          <li <?php echo ($menu == "outstanding")?'class="active"':"";?>> <a href="<?php echo  base_url(); ?>outstanding"> <i class="icon-double-angle-right"></i> Outstanding </a> </li> <?php
     }
      ?>



           <?php
            //$user_permissions[10] is Receipt Reports(Receipt Reports tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[9],$allowed_tab_permissions))
       {
      ?>  
          <li <?php echo ($menu == "negative outstanding")?'class="active"':"";?>> <a href="<?php echo  base_url(); ?>negative_outstanding"> <i class="icon-double-angle-right"></i>Negative Outstanding </a> </li><?php } ?>
           <?php
            //$user_permissions[11] is  Manufacture Reports ( Manufacture Reports  tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[10],$allowed_tab_permissions))
       {
      ?>  
          <li <?php echo ($menu == "manufacture_report")?'class="active"':"";?>> <a href="<?php echo  base_url(); ?>manufacturing_report"> <i class="icon-double-angle-right"></i> Manufacture </a> </li><?php } ?>
            <?php
            //$user_permissions[12] is  Inventory Reports( Inventory Reports  tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[11],$allowed_tab_permissions))
       {
      ?>  
          <li <?php echo ($menu == "inventory_report")?'class="active"':"";?>><a href="<?php echo  base_url(); ?>inventory"> <i class="icon-double-angle-right"></i> Inventory </a> </li><?php } ?>
            <?php
            //$user_permissions[13] is  Pending Bills( Pending Bills  tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[12],$allowed_tab_permissions))
       {
      ?>  
          <li <?php echo ($menu == "pending_bills")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Pending Bills </a> </li>
      <?php } ?>
        <?php
            //$user_permissions[9] is sales report(sales report tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0]  || in_array($user_permissions[8],$allowed_tab_permissions))
      {
      ?>  
          <li <?php echo ($menu == "sales_month")?'class="active"':"";?>> <a href="<?php echo  base_url(); ?>sales_month"> <i class="icon-double-angle-right"></i> Sales Month </a> </li> <?php
     }
      ?>
      <?php
     if($this->session->userdata('session_user_type') != $user_roles[3]  || in_array($user_permissions[15],$allowed_tab_permissions))
      {
      ?>  
          <li <?php echo ($menu == "expenses_report")?'class="active"':"";?>> <a href="<?php echo  base_url(); ?>expenses_report"> <i class="icon-double-angle-right"></i> Expenses Report </a> </li>
     <?php
      }
     ?>
         
      
        </ul>
         </li> 
     
       <?php
            //$user_roles[0] is admin role(users tab is only visible to admin)
      //$user_permissions[16] is  user_management(  user_management tab is only visible to authorized users)
    if($this->session->userdata('session_user_type')== $user_roles[0])
       {
      ?>
        <li <?php echo ($menu == "user_management")?'class="active"':"";?>> <a href="<?php echo base_url('user_management'); ?>"> <i class="icon-double-angle-right"></i>Users</a> </li>
     <?php
        } 
     ?>
     
           
         
    </ul>
    <!--/.nav-list-->
    
    <div id="sidebar-collapse"> <i class="icon-double-angle-left"></i> </div>
  </div>
