<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Reports</title>
<style type="text/css">


</style>
<style type="text/css" media="print">
        @page
        {
            size: auto; /* auto is the initial value */
            margin: 10mm 4mm 0mm 0mm; /* this affects the margin in the printer settings */
        }
        thead
        {
            display: table-header-group;
        }
       /* tfoot
        {
            display: table-footer-group;
        }*/
        
 table { font-family:Arial, Helvetica, sans-serif; font-size:9px !important; font-weight:normal !important;  }
td { height:10px !important; background-color:#FFF !important; }
td.white { background-color:white !important;}
th.head { background-color:#8DB4E2 !important; text-align:left !important; padding:2px !important; height:10px !important; }
th.sub_head { background-color:#DCE6F1; !important; text-align:center !important; padding:2px !important; height:10px !important; }
td.sub_td { padding-left:70px !important; color:#000 !important; }
td.td_height { height:20px !important; }
.heading { text-align:center !important; background-color:#244062 !important; font-size:10px !important; padding:2px !important;   font-weight:bold !important; color:#FFF !important; font-family:Arial, Helvetica, sans-serif; }

    </style>
</head>
<body>
	 <!-- div class="PrintOnly"> -->
     <!-- <img id="PrintLogo" src="<?php echo base_url();?>assets/images/logo.png" style="margin-bottom:15px;margin-left:200px">  -->
     <!-- </div> -->
    <?php
            
			if(!empty($sales_list))
			{
				$count=0;
				echo "<div class='heading'>Sales Report &nbsp;&nbsp;&nbsp;".date('d-m-Y')."</div>";
							echo "<table cellpadding='0' cellspacing='0'  align='center' width='100%' border='1px'>";
                            echo "<thead><tr><th  width='10%' class='sub_head'>Date</th><th  class='sub_head' width='22%'>Name of Customers</th><th class='sub_head' width='20%'>Items</th><th class='sub_head' width='10%'>Qty</th><th class='sub_head' width='10%'>Rate (Rs)</th><th class='sub_head' width='10%'>Amount (Rs)</th><th class='sub_head' width='18%'>Remarks</th></tr></thead>";
                            echo "<tbody>";
                foreach($sales_list as $list)
                {
					/*if($count%47 == 0)
					{*/
							
					//}
                     
                    echo "<tr><td align='center' width='10%'>".date('d-m-Y',strtotime($list['sales_date']))."</td><td align='center' class='td_height' width='22%'>".ucfirst($list['user_name'])."</td><td align='center' width='20%'>".ucfirst($list['item_name'])."</td><td align='center' width='10%'>".$list['qty']."</td><td align='center' width='10%'>".$list['rate']."</td><td align='center' width='10%'>".$list['amount']."</td><td align='center' width='18%'>".$list['remarks']."</td></tr>";
					
					
					/*$count++;
					if($count%47 == 0 || $count == count($sales_list) )
					{
						echo "</table>";
					}	 */ 
                }
                echo "</tbody>";
                echo "</table>";
			}
            else
            {
                echo "<tr><td align='center'colspan=6>No record found</td></tr>";
            }
		
	?>
</body>
</html>
