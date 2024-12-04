<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**********************************************************************************************
 * Filename       : outstanding.php
 * Project        : Accounting Software
 * Creation Date  : 16-07-2015
 * Author         :G.Uma Maheswari
 * Description    : Manage the outstanding report
*********************************************************************************************/	
class Outstanding extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
		$this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model','outstanding_model','sales_person_model')); //load the model files here
		$this->security_model->chk_admin_login(); // check admin logged in or not
	}
   public function index()
    {
        redirect('outstanding/lists');
    }
	public function lists() // sales lists
    {
		$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
		$this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $where = $this->get_search_query($this->uri->segment_array());
		 $segment_array = $this->uri->segment_array();
        $this->data['get'] = $where[0];
		$this->data['menu'] = 'outstanding';
		$this->data['persons'] = $this->outstanding_model->get_active_customer_lists_all($segment_array);
		$this->data['salesman_list_customer'] = $this->outstanding_model->get_active_sales_person_customer_lists();
		$this->data['salesman_list_supplier'] = $this->outstanding_model->get_active_sales_person_supplier_lists();
		$this->data['person_suppliers'] = $this->outstanding_model->get_active_supplier_lists_all($segment_array);
		$this->load->view('outstanding/lists',$this->data);
    }
	
	public function salesman_list_customer($salesman_list_customer='',$persons_arr='')
	{
		if($persons_arr!='')
		{
			$persons_arr = explode(",",$persons_arr);
		}
		 $persons = $this->outstanding_model->get_active_customer_lists($salesman_list_customer);
 
                      
                        if(!empty($persons))
                        {
                           
                            foreach($persons as $item)
                            {
								$selected = (in_array($item['id'],$persons_arr)) ? 'selected="selected"' : '';
                        echo   '<option value="'.$item['id'].'" '.$selected.' >'. $item['customer_name'].'</option>';
						}
                 
						}
						
						
	
	}
	public function salesman_list_supplier($salesman_list_supplier='',$persons_arr='')
	{
		 $person_supplier = $this->outstanding_model->get_active_supplier_lists($salesman_list_supplier);
 
	
		if($persons_arr!='')
		{
			$persons_arr = explode(",",$persons_arr);
		}
                       
                        if(!empty($person_supplier))
                        {
                           
                            foreach($person_supplier as $item)
                            {
							$selected = (in_array($item['id'],$persons_arr)) ? 'selected="selected"' : '';	
                        echo   '<option value="'.$item['id'].'" '.$selected.' >'. $item['supplier_name'].'</option>';
						}
                   	}
						
						
	
	}
	
	 public function get_search_query($url)
	    {
		      $get = array(
					  'chk_person'=>"",
					   'chk_person_supplier'=>"",
					 'chk_usertype'=>"",
					 'chk_sales_person_customer'=>"",
					  'chk_sales_person_supplier'=>""
                   
              );
          	$person = array_search('person',$this->uri->segment_array());
			$person_supplier = array_search('person_supplier',$this->uri->segment_array());
			$sales_person_customer = array_search('sales_person_customer',$this->uri->segment_array());
			$sales_person_supplier = array_search('sales_person_supplier',$this->uri->segment_array());
            $user_type = array_search('user_type',$this->uri->segment_array());
			

            if($user_type!==FALSE)
            {
                $get['chk_usertype'] = $this->uri->segment($user_type+1);	
            }
			   if($person!==FALSE)
            {
                $get['chk_person'] = $this->uri->segment($person+1);	
            }
			
			   if($person_supplier!==FALSE)
            {
                $get['chk_person_supplier'] = $this->uri->segment($person_supplier+1);	
            }
			 if($sales_person_supplier!==FALSE)
            {
                $get['chk_sales_person_supplier'] = $this->uri->segment($sales_person_supplier+1);	
            }
			if($sales_person_customer!==FALSE)
            {
                $get['chk_sales_person_customer'] = $this->uri->segment($sales_person_customer+1);	
            }

            
                return array($get);
        }
	
		public function number_unformat($number, $dec_point = '.', $thousands_sep = ',') {
          return (float)str_replace(array($thousands_sep, $dec_point),
                              array('', '.'),
                              $number);
           }
	
	
 public function ajax_get_customers_list() // load bulk records to jquery data table using ajax
		 {
            $segment_array = $this->uri->segment_array();
            $lists = $this->outstanding_model->get_customers_lists($segment_array);
			#print_r( $lists);exit;
			$this->data['menu'] = 'outstanding';
			$this->data['active_tab'] = 'outstanding';
			$seg_url = array_search('user_type',$segment_array);
             $sales_list = array();
                foreach($lists as $list)
                {
					$sales_list[$list['id']]['id'] = $list['id'];
					 if($list['user_type']=='supplier')
                    {
                      $supplier_details   = $this->outstanding_model->get_supplier_details($list['user_id']);
                      $sales_list[$list['id']]['user_name'] = $supplier_details['supplier_name'];
                    }
                    else
                    {
                     $customer_details   = $this->outstanding_model->get_customer_details($list['user_id']);
                      $sales_list[$list['id']]['user_name'] = $customer_details['customer_name'];
                    }
					$salesman_details   = $this->outstanding_model->get_sales_person_details($list['sales_person_id']);
                    $sales_list[$list['id']]['sales_person_name'] = $salesman_details['sales_person_name'];
					$sales_list[$list['id']]['outstanding'] = $list['outstanding'];
					$sales_list[$list['id']]['record_type'] = $list['record_type'];
					$sales_list[$list['id']]['user_type'] = $list['user_type'];
					$sales_list[$list['id']]['amount'] = $list['amount'];
				    $sales_list[$list['id']]['date'] = $list['date'];
					 
				}
			  
				
            
                $json = "";
				#echo '<pre>';
				
				#print_r($sales_list);exit;
                        foreach($sales_list as $user)
                        {
							 if($user['user_type'] == 'supplier')
                                {
                                    $link = '<a href=\"'.base_url().'suppliers/outstanding_report/'.base64_encode($user['id']).'\">' .$user['user_name']. '</a>';
                                }
                                else
                                {
                                     $link = 	'<a href=\"'.base_url().'customers/outstanding_report/'.base64_encode($user['id']).'\">' .$user['user_name']. '</a>';
                                }
							#echo 'FF : '.$user['id'];
							$sales_lastthiry=$sales_thirytosixty=$sales=$sales_return=$sales_sixtytoninety=$sales_ninetytoonetwenty=$sales_aboveonetwenty=$total=0;
								
							$outstanding=$user['outstanding'];
							
							if($outstanding>0)
							{	
								$lists = $this->outstanding_model->get_customer_history($user['id']);
									
									 foreach($lists as $row)
									 {
						
													switch($row['record_type'])
													{
							case 'P':
								$record_type='Purchase';
								break;
							case 'S':
								$record_type='Sales';
								break;
							case 'M':
								$record_type='Manufacture';
								break;
							case 'PR':
								$record_type='<b>Purchase Return</b>';
								break;
							case 'SR':
								$record_type='<b>Sales Return</b>';
								break;
						   case 'R':
								$record_type='<b>Payment</b>';
								break;
						   case 'RR':
								$record_type='<b>Payment Return</b>';
								break;
						case 'LC':
								$record_type='<b>Credit</b>';
								break;
						case 'LCR':
								$record_type='<b>Credit Return</b>';
								break;
						case 'LD':
								$record_type='<b>Debit</b>';
								break;
						case 'LDR':
								$record_type='<b>Debit Return</b>';
								break;
				  }
													   
													
													 $today = date('Y-m-d'); //2015-10-20
			             $lastthiryday = date('Y-m-d', strtotime('-30 days', strtotime($today)));  //2015-09-20
						 $thirytosixty = date('Y-m-d', strtotime('-60 days', strtotime($today)));  // 2015-08-21
						 $sixtytoninety = date('Y-m-d', strtotime('-90 days', strtotime($today)));  // 2015-07-22
						 $ninetytoonetwenty = date('Y-m-d', strtotime('-120 days', strtotime($today)));  // 2015-06-22  
							 
							
						
							if ($row['date'] > $lastthiryday && $row['date'] <= $today)
							{
							    if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_lastthiry= $sales_lastthiry + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_lastthiry= $sales_lastthiry - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							
						    if (($row['date'] > $thirytosixty) && ($row['date'] <= $lastthiryday))
							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_thirytosixty= $sales_thirytosixty + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_thirytosixty= $sales_thirytosixty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							 
							 if (($row['date'] > $sixtytoninety) && ($row['date'] <= $thirytosixty))
							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_sixtytoninety= $sales_sixtytoninety + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_sixtytoninety= $sales_sixtytoninety - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							 if (($row['date'] > $ninetytoonetwenty) && ($row['date'] <= $sixtytoninety))

							{
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_ninetytoonetwenty= $sales_ninetytoonetwenty + $this->number_unformat($row['amount']); //add amount for sales
								else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_ninetytoonetwenty= $sales_ninetytoonetwenty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							if (($row['date'] <= $ninetytoonetwenty) )

							{
								
								if($row['record_type']=='S' || $row['record_type']=='LD')
                                    $sales_aboveonetwenty= $sales_aboveonetwenty + $this->number_unformat($row['amount']); //add amount for sales
							else if($row['record_type']=='SR'  || $row['record_type']=='LDR')
                                    $sales_aboveonetwenty= $sales_aboveonetwenty - $this->number_unformat($row['amount']); //decrese amount for sales return
							}
							
						}
					       
							 if( $outstanding != 0)
							  {
							  if($sales_lastthiry ==  $outstanding)
							  {
								 $sales_lastthiry = $sales_lastthiry ;
								 $sales_thirytosixty = 0;
								
							  }
							 else if($sales_lastthiry >  $outstanding && $sales_lastthiry != 0)
							  {
								$sales_lastthiry =  $outstanding;
								
							  }
							  
		  					}
		  
		  // sales_thirytosixty
		  if(($sales_lastthiry + $sales_thirytosixty) ==   $outstanding)
	 	  {
			 $sales_thirytosixty = $sales_thirytosixty;
			 $sales_sixtytoninety = 0;
		  }
		  
		  else if(( ($sales_lastthiry + $sales_thirytosixty) <  $outstanding) && $sales_thirytosixty != 0)
		  {
      		   $sales_thirytosixty =$sales_thirytosixty;
			  // $sales_thirytosixty =  $outstanding - ($sales_lastthiry + $sales_thirytosixty) ;
		  }
		  
		  else if( ($sales_lastthiry + $sales_thirytosixty) >  $outstanding)
		  {
			 $sales_thirytosixty =  $outstanding -($sales_lastthiry) ;
			
		  }
		  
		  
		   
		  //sales_sixtytoninety
		 if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety) ==  $outstanding)
	 	  {
			 
			 $sales_sixtytoninety = $sales_sixtytoninety;
			 $sales_ninetytoonetwenty = 0;
		  }
		  
		  else if( (( $sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety) <  $outstanding) && $sales_sixtytoninety != 0)
		  {
			  #$sales_sixtytoninety1 =  $outstanding - ($sales_lastthiry + $sales_thirytosixty +$sales_sixtytoninety) ;
			  $sales_sixtytoninety = $sales_sixtytoninety;
		  }
		  
		  else if( ($sales_lastthiry + $sales_thirytosixty +$sales_sixtytoninety) >  $outstanding)
		  {
			 $sales_sixtytoninety=  $outstanding -($sales_lastthiry + $sales_thirytosixty) ;
			 
		  } 
		  
		  //sales_ninetytoonetwenty
			if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety + $sales_ninetytoonetwenty) ==   $outstanding)
			  {
				 $sales_ninetytoonetwenty = $sales_ninetytoonetwenty;
				 $sales_aboveonetwenty=0;
			  }
		  
			 else if(( ($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety +$sales_ninetytoonetwenty) <  $outstanding) && $sales_ninetytoonetwenty != 0)
			  {
				
				$sales_ninetytoonetwenty = $sales_ninetytoonetwenty;
		       # $sales_aboveonetwenty =  $outstanding -($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety+$sales_ninetytoonetwenty) ;

			  }
			  
			  else if( ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty) >  $outstanding)
			  {
				
				 $sales_ninetytoonetwenty=  $outstanding -($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety ) ;
				 
			  }
			  
			  
			   //sales_aboveonetwenty
			if(($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety + $sales_ninetytoonetwenty + $sales_aboveonetwenty) ==   $outstanding)
			  {
				 $sales_aboveonetwenty = $sales_aboveonetwenty;
			  }
		  
			 else if(( ($sales_lastthiry + $sales_thirytosixty + $sales_sixtytoninety +$sales_ninetytoonetwenty + $sales_aboveonetwenty) <  $outstanding) && $sales_aboveonetwenty != 0)
			  {
				$sales_aboveonetwenty = $sales_aboveonetwenty;
				
			  }
			  
			  else if( ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty + $sales_aboveonetwenty) >  $outstanding)
			  {
				
				 $sales_aboveonetwenty =  $outstanding - ($sales_lastthiry + $sales_thirytosixty+$sales_sixtytoninety +$sales_ninetytoonetwenty) ;
				
				 
			  }
					
					 if( $outstanding < 0)
		{
			$total = $outstanding;
			$sales_lastthiry=$sales_thirytosixty=$sales=$sales_return=$sales_sixtytoninety=$sales_ninetytoonetwenty=$sales_aboveonetwenty=0;
		}
		else
		{ 
			 $total=   $sales_lastthiry+$sales_thirytosixty+$sales=$sales_return+$sales_sixtytoninety+$sales_ninetytoonetwenty+$sales_aboveonetwenty;
		}	
		
							
							}
							else
							$list_csv = array();
						$list_csv[$user['id']]['id'] = $user['id'];
						$list_csv[$user['id']]['user_name'] = $user['user_name'];
						$list_csv[$user['id']]['sales_person_name'] = $user['sales_person_name'];
						$list_csv[$user['id']]['outstanding'] = $outstanding;
						$list_csv[$user['id']]['sales_lastthiry'] = $sales_lastthiry;
						$list_csv[$user['id']]['sales_thirytosixty'] = $sales_thirytosixty;
						$list_csv[$user['id']]['sales_sixtytoninety'] = $sales_sixtytoninety;
						$list_csv[$user['id']]['sales_ninetytoonetwenty'] = $sales_ninetytoonetwenty;
						$list_csv[$user['id']]['sales_aboveonetwenty'] = $sales_aboveonetwenty;
						$list_csv[$user['id']]['total'] = $total;	
						#echo "<pre>";
						#print_r($list_csv);exit;
						
							$total=$outstanding;
							#echo '<br /> Result : '.$sales_lastthiry.' = '.$sales_thirytosixty.' = '.$sales.' = '.$sales_return.' = '.$sales_sixtytoninety.' - '.$sales_ninetytoonetwenty.' = '.$sales_aboveonetwenty;			
										

								    $json .= '[
                                         "'.$user['id'].'",
										 "'.$link.'",
										  "'.$user['sales_person_name'].'",
										 "'.(($outstanding==0)?'0': number_format($outstanding,2)).'",
										  "'.(($sales_lastthiry==0)?'0': number_format($sales_lastthiry,2)).'",
										   "'.(($sales_thirytosixty==0)?'0': number_format($sales_thirytosixty,2)).'",
										    "'.(($sales_sixtytoninety==0)?'0': number_format($sales_sixtytoninety,2)).'",
											 "'.(($sales_ninetytoonetwenty==0)?'0': number_format($sales_ninetytoonetwenty,2)).'",
											  "'.(($sales_aboveonetwenty==0)?'0': number_format($sales_aboveonetwenty,2)).'",
											   "'.(($total==0)?'0': number_format($total,2)).'"
										
                        ],';
						
					 $sum_outstanding = $sum_sales_lastthiry =$sum_sales_thirytosixty =$sum_sales_ninetytoonetwenty=$sum_sales_aboveonetwenty= $sum_sales_sixtytoninety =$sum_total=0;
			
			foreach($list_csv as $num => $values) {
				$sum_outstanding += $values[ 'outstanding' ];
				$sum_sales_lastthiry += $values[ 'sales_lastthiry' ];
				$sum_sales_thirytosixty += $values[ 'sales_thirytosixty' ];
				$sum_sales_sixtytoninety += $values[ 'sales_sixtytoninety' ];
				$sum_sales_ninetytoonetwenty += $values[ 'sales_ninetytoonetwenty' ];
				$sum_sales_aboveonetwenty += $values[ 'sales_aboveonetwenty' ];
				$sum_total += $values[ 'total' ];
			
			}	
	
					 }
			
			

		#echo number_format($sum_sales_aboveonetwenty,2); exit;		
		   $option = array_search('option_type',$segment_array); // print pdf option
           if($option!==FALSE)
		   {
                $option_type = $this->uri->segment($option+1);
                if($option_type=='pdf')
                {
                    $this->data['sales_list'] = $sales_list;
                    $html = $this->load->view('sales/print_to_pdf',$this->data,true);
					$pdf_filename  ='sales_report.pdf';
					$this->load->library('dompdf_lib');
					$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, true);
                }
                else if($option_type=='csv')
                {
					
				    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=outstanding_report.csv");
                    // Disable caching
                    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
                    header("Pragma: no-cache"); // HTTP 1.0
                    header("Expires: 0"); // Proxies
					$heading = array('ID','Name','Sales Person','Outstanding','sales_lastthiry','sales_thirytosixty','sales_sixtytoninety','sales_ninetytoonetwenty','sales_aboveonetwenty','total');
					$footer = array('','','Total',number_format($sum_outstanding,2),number_format($sum_sales_lastthiry,2),number_format($sum_sales_thirytosixty,2),number_format($sum_sales_sixtytoninety,2),number_format($sum_sales_ninetytoonetwenty,2),number_format($sum_sales_aboveonetwenty,2),number_format($sum_total,2));
                    $this->outputCSV($list_csv,$heading,$footer);
                    exit;
                }
            }
			
                   
                echo '{ 
                            "recordsTotal": '.count($sales_list).',
                        "data":[ 
                                '.rtrim($json,",").']}';
                 
		 exit;		
	}
			
	  public function outputCSV($data,$header,$footer) // export data using CSV
        {
		  $output = fopen("php://output", "w");
		  
		  fputcsv($output, $header);
          foreach ($data as $row) 
		  {
		  fputcsv($output, $row); // here you can change delimiter/enclosure
		  }
		  fputcsv($output, $footer);
		  fclose($output);
	   }		
	
		
}

?>