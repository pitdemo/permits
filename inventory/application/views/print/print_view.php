<?php 
$this->load->view("print/printview_header");
?>
<style type="text/css">
.col_lalign{
    padding-left: 5px;
}
.col_ralign{
    padding-right: 2px;
}
</style>  
<?php
$class = $this->router->fetch_class();  
/*echo $class;  
echo "<pre>";
print_r($receipts_list);*/
if($class == "sales")
{
   // echo "ghdfhfg";
if(!empty($sales_list))
{
				$count=0;
                
				echo "<div class='heading'>Sales Report : &nbsp;&nbsp;&nbsp;".date('d-m-Y',strtotime($start))."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".date('d-m-Y',strtotime($end))."</div>";
							echo "<table cellpadding='0' cellspacing='0'  align='center' width='100%' border='1px'>";
                            echo "<thead><tr><th  width='10%' class='sub_head'>Date</th><th  class='sub_head' width='20%'>Name of Customers</th><th class='sub_head' width='16%'>Items</th><th class='sub_head' width='5%'>Qty</th><th class='sub_head' width='6%'>Rate (Rs)</th><th class='sub_head' width='8%'>Amount (Rs)</th><th class='sub_head' width='15%'>Remarks</th><th class='sub_head' width=10%></th><th class='sub_head' width=10%></th></tr></thead>";
                            echo "<tbody>";
                foreach($sales_list as $list)
                {
					/*if($count%47 == 0)
					{*/
							
					//}
                    
                    echo "<tr><td align='center' width='10%'>".date('d-m-Y',strtotime($list['sales_date']))."</td><td align='center' class='td_height' width='20%'>".ucfirst($list['user_name'])."</td><td align='center' width='16%' >".ucfirst($list['item_name'])."</td><td align='center' width='5%'>".$list['qty']."</td><td align='center' width='6%'>".$list['rate']."</td><td align='center' width='8%'>".$list['amount']."</td><td align='center' width='15%' >".$list['remarks']."</td><td align='center' width='10%'></td><td align='center' width='10%'></td></tr>";
					
					
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
{               if(!empty($start) && !empty($end))
                {
                echo "<div class='heading'>Sales Report : &nbsp;&nbsp;&nbsp;".$start."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".$end."</div>";
                }
                else
                {
                   echo "<div class='heading'>Sales Report : &nbsprecords until&nbsp;".date('d-m-Y')."</div>";     
                }
                echo "<tr><td colspan='7'><center>No record found</center></td></tr>";
}
}
else if($class == "receipts")
{
    if(!empty($receipts_list))
  {
                $count=0;
                $total_amount = 0;
                $page = 1;
                $amount = 0;
                //$total_rec_count = count($receipts_list);
                //echo $total_rec_count;//exit;
                echo "<div class='heading'>Receipts Report &nbsp;&nbsp;&nbsp;".date('d-m-Y',strtotime($start))."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".date('d-m-Y',strtotime($end))."</div>";
                            echo "<table cellpadding='0' cellspacing='0'  align='center' width='100%' border='1px'>";
                            echo "<thead><tr><th  width='20%' class='sub_head'>Date</th><th  class='sub_head' width='30%'>Name of Customers</th><th class='sub_head' width='15%'>Amount(Rs)</th><th class='sub_head' width='20%'>Remarks</th><th class='sub_head' width=15%></th></tr></thead>";
                            echo "<tbody>";
                foreach($receipts_list as $list)
                {
                    //echo $list['amount'];
                    $count++;
                    $val=str_replace(',','',$list['amount']);
                    $total_amount = $total_amount + $val;
                    $amount = $amount + $val;
                    echo "<tr><td align='center' width='20%'>".date('d-m-Y',strtotime($list['receipt_date']))."</td><td align='center' class='td_height' width='30%'>".ucfirst($list['user_name'])."</td><td align='center' width='15%' >".$list['amount']."</td><td align='center' width='20%'>".$list['remarks']."</td><td align='center' width='15%'></td></tr>"; 
                    //echo $count;echo $page;
                    if($page == 1 && $count == 45 )
                    {
                        echo "<tr><td></td><td align='right' width='30%' ><b>Total: </b></td><td align='right' width='15%'><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                        $page++;
                        $count = 0;
                        $amount = 0;
                    }
                    else if($page > 1 && $count == 46)
                    {
                        echo "<tr><td></td><td align='right' width='30%' ><b>Total: </b></td><td align='right' width='15%'><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                        $page++;
                        $count = 0;
                        $amount = 0;
                    }

                }
                echo "<tr><td></td><td align='right' width='30%'  ><b>Total: </b></td><td align='right' width='15%' ><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                echo "<tr><td></td><td align='right' width='30%' ><b>Grand Total: </b></td><td align='right' width='15%' ><b>Rs: ".number_format($total_amount,2)."</b></td><td></td><td></td></tr>";

                echo "</tbody>";
                echo "</table>";
    }
    else
    {           if(!empty($start) && !empty($end))
                {
                echo "<div class='heading'>Receipts Report : &nbsp;&nbsp;&nbsp;".$start."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".$end."</div>";    
                }
                else
                {
                   echo "<div class='heading'>Receipts Report :&nbsprecords until&nbsp;".date('d-m-Y')."</div>";     
                }
                echo "<tr><td colspan='5'><center>No record found</center></td></tr>";
    }


}
else if($class == "expenses")
{
    if(!empty($expenses_list))
  {
                $count=0;
                $total_amount = 0;
                $page = 1;
                $amount = 0;
                //$total_rec_count = count($receipts_list);
                //echo $total_rec_count;//exit;
                echo "<div class='heading'>Expenses Report &nbsp;&nbsp;&nbsp;".date('d-m-Y',strtotime($start))."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".date('d-m-Y',strtotime($end))."</div>";
                            echo "<table cellpadding='0' cellspacing='0'  align='center' width='100%' border='1px'>";
                            echo "<thead><tr><th  width='20%' class='sub_head'>Date</th><th  class='sub_head' width='30%'>Expense Category</th><th class='sub_head' width='15%'>Amount(Rs)</th><th class='sub_head' width='20%'>Description</th><th class='sub_head' width=15%></th></tr></thead>";
                            echo "<tbody>";
                foreach($expenses_list as $list)
                {
                    //echo $list['amount'];
                    $count++;
                    $val=str_replace(',','',$list['amount']);
                    $total_amount = $total_amount + $val;
                    $amount = $amount + $val;
                    echo "<tr><td align='center' width='20%'>".date('d-m-Y',strtotime($list['expense_date']))."</td><td align='center' class='td_height' width='30%'>".ucfirst($list['expense_category_name'])."</td><td align='center' width='15%' >".$list['amount']."</td><td align='center' width='20%'>".$list['description']."</td><td align='center' width='15%'></td></tr>"; 
                    //echo $count;echo $page;
                    if($page == 1 && $count == 45 )
                    {
                        echo "<tr><td></td><td align='right' width='30%' ><b>Total: </b></td><td align='right' width='15%'><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                        $page++;
                        $count = 0;
                        $amount = 0;
                    }
                    else if($page > 1 && $count == 46)
                    {
                        echo "<tr><td></td><td align='right' width='30%'  ><b>Total: </b></td><td align='right' width='15%'><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                        $page++;
                        $count = 0;
                        $amount = 0;
                    }

                }
                echo "<tr><td></td><td align='right' width='30%' ><b>Total: </b></td><td align='right' width='15%' ><b>Rs: ".number_format($amount,2)."</b></td><td></td><td></td></tr>";
                echo "<tr><td></td><td align='right' width='30%' ><b>Grand Total: </b></td><td align='right' width='15%' ><b>Rs: ".number_format($total_amount,2)."</b></td><td></td><td></td></tr>";

                echo "</tbody>";
                echo "</table>";
    }
    else
    {           if(!empty($start) && !empty($end))
                {
                echo "<div class='heading'>Receipts Report : &nbsp;&nbsp;&nbsp;".$start."&nbsp;&nbsp;&nbsp - &nbsp;&nbsp;&nbsp".$end."</div>";    
                }
                else
                {
                   echo "<div class='heading'>Receipts Report :&nbsprecords until&nbsp;".date('d-m-Y')."</div>";     
                }
                echo "<tr><td colspan='5'><center>No record found</center></td></tr>";
    }


}
		
?>
</body>
</html>
