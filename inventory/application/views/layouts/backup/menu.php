<div id="sidebar"> 
    
    <!--#sidebar-shortcuts-->
    
    <ul class="nav nav-list">               
		<li <?php echo ($menu == "items")?'class="active"':"";?>> <a href="<?php echo base_url('items');?>"> <i class="icon-list-alt"></i> <span>Items</span> </a> </li>
	  	<li <?php echo ($menu == "sales")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-list-alt"></i> <span>Sales</span> </a> </li>
		<li <?php echo ($menu == "purchase")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-list-alt"></i> <span>Purchase</span> </a> </li>
		<li <?php echo ($menu == "receipts")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-list-alt"></i> <span>Receipts</span> </a> </li>
		<li <?php echo ($menu == "manufacture")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-list-alt"></i> <span>Manufacture</span> </a> </li>
		<li <?php echo ($menu == "expenses")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-list-alt"></i> <span>Expenses</span> </a> </li>
        <li <?php echo (in_array($menu,array('sales_report','receipts_report','manufacture_report','inventory_report','pending_bills','outstanding_report'))?'class="active"':"");?>> <a href="#" class="dropdown-toggle"> <i class="icon-double-angle-right"></i> <span>Reports</span> <b class="arrow icon-angle-down"></b> </a>
         <ul class="submenu" <?php echo (in_array($menu,array('sales_report','receipts_report','manufacture_report','inventory_report','pending_bills','outstanding_report'))?'style="display: block;"':"");?>>
          <li <?php echo ($menu == "sales_report")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Sales Reports </a> </li>
          <li <?php echo ($menu == "receipts_report")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Receipt Reports </a> </li>
          <li <?php echo ($menu == "manufacture_report")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Manufacture Reports </a> </li>
          <li <?php echo ($menu == "inventory_report")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Inventory Reports </a> </li>
          <li <?php echo ($menu == "pending_bills")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Pending Bills </a> </li>
          <li <?php echo ($menu == "outstanding_report")?'class="active"':"";?>> <a href="javascript:void(0);"> <i class="icon-double-angle-right"></i> Outstanding Reports </a> </li>
        </ul>
         </li> 
    </ul>
    <!--/.nav-list-->
    
    <div id="sidebar-collapse"> <i class="icon-double-angle-left"></i> </div>
  </div>
