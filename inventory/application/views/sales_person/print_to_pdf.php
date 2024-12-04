<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sales Reports</title>
<style type="text/css">
table { font-family:Arial, Helvetica, sans-serif; font-size:7px !important; font-weight:normal !important;  }
td { height:10px !important; background-color:#FFF !important; }
td.white { background-color:white !important;}
th.head { background-color:#8DB4E2 !important; text-align:left !important; padding:2px !important; height:10px !important; }
th.sub_head { background-color:#DCE6F1; !important; text-align:center !important; padding:2px !important; height:10px !important; }
td.sub_td { padding-left:70px !important; color:#000 !important; }
td.td_height { height:20px !important; }
.heading { background-color:#244062 !important; font-size:10px !important; padding:2px !important;   font-weight:bold !important; color:#FFF !important; font-family:Arial, Helvetica, sans-serif; }
</style>
</head>
<body>
    <img src="<?php echo base_url(); ?>assets/images/logo.png" style="margin-bottom:15px;margin-left:200px">
    <?php
			
			echo "<div class='heading'>Sales Report &nbsp;&nbsp;&nbsp;".date('d-m-Y')."</div>";
            echo "<table cellpadding='0' cellspacing='0'  align='center' width='100%'>";
            echo "<tr><th  width='25%' class='sub_head'>Name</th><th class='sub_head' width='10%'>Created Date</th><th class='sub_head' width='10%'>Contact number</th><th class='sub_head' width='10%'>Status</th></tr>";
			if(!empty($sales_list))
			{
                foreach($sales_list as $list)
                {
                     
                    echo "<tr><td align='center' class='td_height' width='25%'>".ucfirst($list['sales_person_name'])."</td><td align='center' width='10%'>".date('d-m-Y',strtotime($list['created']))."</td><td align='center' width='10%'>".$list['phone_no']."</td><td align='center' width='10%'>".ucfirst($list['status'])."</td></tr>";	  
                }
				echo "</table>";
			
			}
            else
            {
                echo "<tr><td align='center' colspan=7>No record found</td></tr>";
            }
		
	?>
</body>
</html>
