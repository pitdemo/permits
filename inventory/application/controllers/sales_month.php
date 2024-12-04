<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**********************************************************************************************
 * Filename       : sales.php
 * Project        : Accounting Software
 * Creation Date  : 22-06-2015
 * Author         : K.Panneer selvam
 * Description    : Manage the sales details
*********************************************************************************************/  
class Sales_month extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('security_model','sales_model','supplier_model','items_model','customer_model','notes_model'));    
    $this->security_model->chk_admin_login();
  }

  public function index()
  {  
    redirect('sales_month/lists');
  }

  public function lists() // sales lists
  {
      $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
      $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));  
      //print_r($this->data['uri_data']);
      $where = $this->get_search_query($this->uri->segment_array());
      $this->data['get'] = $where[0];
      //print_r($this->data['get']);
      $end   = $this->data['get']['chk_start_date'];
      $start = $this->data['get']['chk_end_date'];
      $heading=array();

      if($start!=FALSE && $end!=FALSE)
      {

          $start    = new DateTime($start);
          $start->modify('first day of this month');
          $end      = new DateTime($end);
          $end->modify('first day of next month');
          $interval = DateInterval::createFromDateString('1 month');
          $period   = new DatePeriod($start, $interval, $end);

          foreach ($period as $dt) 
          {
              array_push($heading, $dt->format("F-Y"));
          } 
          
          $this->data['head_count']=(count($heading)+1);  

      }

      elseif($start=='' && $end=='')
      {
          $this->data['head_count']=11; 
      }

    $this->data['menu'] = 'sales_month';
    //$this->data['persons'] = $this->customer_model->get_active_sales_person_lists();
    $this->data['items'] = $this->items_model->get_active_item_lists(); // get items lists from items table
    $this->load->view('sales_month/lists',$this->data);
    }
/*
    public function sales_history($qty='NULL') //show the item purchase and sales history
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
        $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['qty'] = array('qty'=>$qty);
        $this->data['menu'] = 'sales_month';
        $this->data['details'] = $this->customer_model->get_active_sales_lists($where[0]);
        $this->load->view('sales_month/sales_history',$this->data);       
    }*/

    public function sales_history() //show the item purchase and sales history
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
        $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['menu'] = 'sales_month';
        $this->data['details'] = $this->customer_model->get_active_sales_lists($where[0]);
        //print_r($this->data['details']);
        $this->load->view('sales_month/sales_history',$this->data);       
    }

    public function customer_history($qty='NULL') //show the item purchase and sales history
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
        $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['qty'] = array('qty'=>$qty);
        $this->data['menu'] = 'sales_month';
        // print_r($this->data);
        // exit;
        $this->data['details'] = $this->customer_model->get_active_sales_lists($where[0]);
        $this->load->view('sales_month/customer_history',$this->data);       
    }

    public function ajax_sales_history() //show the item purchase and sales history
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
        $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        //print_r($this->data['uri_data']);
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        //print_r($this->data['get']);
        $this->data['menu'] = 'sales_month';
        $details = $this->customer_model->get_ajax_active_sales_lists($where[0]);
        $json = "";

        foreach($details as $row)
            {
              
              if($row['customer_name']!='')
              {
                $row['customers_name']=$row['customer_name'];
              }
              elseif($row['supplier_name']!='')
              {
                 $row['customers_name']=$row['supplier_name'];
              }

              $json .= '[
                            "'.$row['customers_name'].'",
                            "'.$row['sales_date'].'",
                            "'.$row['qty'].'"                    
                           
                        ],';
        }

            echo   '{ 
                          "recordsTotal": '.count($details).',
                        "data":[ 
                            '.rtrim($json,",").']}';
                exit;
    } 

    public function ajax_customer_history($qty='NULL') //show the item purchase and sales history
    {
        $url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method();
        $this->data['uri_data'] = str_replace($url,'',base_url(uri_string()));
        $where = $this->get_search_query($this->uri->segment_array());
        $this->data['get'] = $where[0];
        $this->data['menu'] = 'sales_month';
        $details = $this->customer_model->get_ajax_active_customer_lists($where[0]);
        $json = "";

        foreach($details as $row)
            {
              
              if($row['customer_name']!='')
              {
                $row['customers_name']=$row['customer_name'];
              }
              elseif($row['supplier_name']!='')
              {
                 $row['customers_name']=$row['supplier_name'];
              }

              $json .= '[
                            "'.$row['customers_name'].'",
                            "'.$row['sales_date'].'",
                            "'.$row['qty'].'"                    
                           
                        ],';
        }

            echo   '{ 
                          "recordsTotal": '.count($details).',
                        "data":[ 
                            '.rtrim($json,",").']}';
                exit;
    } 

    public function get_search_query($url)
    {

        $get = array(
                //'chk_person'=>"",
                'chk_sales_id'=>"",
                'chk_item_id'=>"",
                'chk_start_date'=>"",
                'chk_end_date'=>"",
                'chk_sales_date'=>""
        );
        $item = array_search('item_id',$this->uri->segment_array());
        $customerid= array_search('customer_id',$this->uri->segment_array());
        $sales = array_search('sales_person_id',$this->uri->segment_array());
        $sales_date = array_search('sales_date',$this->uri->segment_array());
        //$person = array_search('person',$this->uri->segment_array());
        $date_from = array_search('start',$this->uri->segment_array());
        $date_end = array_search('end',$this->uri->segment_array());

        if($item!==FALSE)
        {
          $get['chk_item_id'] = $this->uri->segment($item+1); 
        }
        if($sales!==FALSE)
        {
          $get['chk_sales_id'] = $this->uri->segment($sales+1); 
        }
        if($sales!==FALSE)
        {
          $get['chk_sales_date'] = $this->uri->segment($sales_date+1);  
        }
        /*  if($person!==FALSE)
        {
            $get['chk_person'] = $this->uri->segment($person+1);  
        }*/
        if($date_from!==FALSE)
        {
            $get['chk_start_date'] = $this->uri->segment($date_from+1); 
        }
        if($date_end!==FALSE)
        {
            $get['chk_end_date'] = $this->uri->segment($date_end+1);  
        }
        if($customerid!==FALSE)
        {
          $get['chk_customer_id'] = $this->uri->segment($customerid+1);  
        }
        
        return array($get);
    }

    public function datafetch()
    {  
        $segment_array = $this->uri->segment_array();
        $requestData= $_REQUEST;
        $where_condition='';
        $start = array_search('end',$segment_array); //print start option
        $end = array_search('start',$segment_array); //print end option
        $heading = array();
        $year=array();
        $month= array();
        $start_date=$this->uri->segment($start+1);
        $end_date=$this->uri->segment($end+1);


        if($start!=FALSE && $end!=FALSE)
        {
        $start    = new DateTime($start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

            foreach ($period as $dt) 
            {
            array_push($heading, $dt->format("F-Y"));
            array_push($year, $dt->format("Y"));
            array_push($month, $dt->format("m"));
            }   

      }
     
      else
      {
        $end_date = date('Y-m-d');
        $start_date = date("Y-m-d", strtotime("-9 months", strtotime($end_date)));
        $start    = new DateTime($start_date);
        $start->modify('first day of this month');
        $end      = new DateTime($end_date);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

          foreach ($period as $dt) 
          {
          array_push($heading, $dt->format("F-Y"));
          array_push($year, $dt->format("Y"));
          array_push($month, $dt->format("m"));
      } 

    }
    $count=count($year);
  
    /////////////DEFAULT SEARCH//////////////////////////////
    if( trim(@$requestData['search']['value']) != "" )//!empty(trim($requestData['search']['value']))
    {  
      $requestData['search']['value'] = addslashes($requestData['search']['value']);
      $search_value = trim($requestData['search']['value']);
      // $where_condition.= "(sp.sales_person_name LIKE '%".$search_value."%' OR i.item_name LIKE '%".$search_value."%' ) AND ";
      $where_condition.= "(sp.sales_person_name LIKE '%".$search_value."%' OR i.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%') AND ";
    }
    /////////////DEFAULT SEARCH//////////////////////////////

    /////////////SEARCH PERSON//////////////////////////////
   /* $user_keyword = array_search('person',$segment_array);
    if ($user_keyword !== FALSE)
    {
      $keyword = $this->uri->segment($user_keyword+1);
      if($keyword!='')
      $where_condition.="(sp.id IN (".$keyword.") ) AND" ;
    } */
    /////////////SEARCH PERSON//////////////////////////////


    /////////////SEARCH ITEM//////////////////////////////
    $user_keyword = array_search('item_id',$segment_array);
    if ($user_keyword !== FALSE)
    {
      $keyword = $this->uri->segment($user_keyword+1);
      if($keyword!='')
      $where_condition.="(i.id IN (".$keyword.")) AND" ;
    } 
    /////////////SEARCH ITEM//////////////////////////////
      //$this->db->select('suppliers_table.id as supid,suppliers_table.supplier_name,customers_table.id as cusid,customers_table.customer_name,sales_table.sales_date,sales_table.qty');
      $this->db->select('sales_table.sales_person_id,sales_table.sales_date,sales_table.item_id,sp.sales_person_name,i.item_name,suppliers_table.id as supid,suppliers_table.supplier_name,customers_table.id as cusid,customers_table.customer_name');  
      $this->db->from('sales sales_table');
      $this->db->join('sales_person_tbl sp','sp.id=sales_table.sales_person_id');
      $this->db->join('items i','i.id=sales_table.item_id');
      $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ','left');
      $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ','left');
      $this->db->where('sales_table.status =  "active" AND sp.status="active" AND i.status="active"');
      $this->db->where('sales_table.sales_person_id !=', 0);
  
    ///////////FILTER & FETCH LIMITED RECORD/////////// 
    if($start!=FALSE && $end!=FALSE)
    { 
        $this->db->where('sales_table.sales_date >=', $start_date);
        $this->db->where('sales_table.sales_date <=', $end_date);   
    }
    else
    {     
        $this->db->where('sales_date BETWEEN DATE_SUB(NOW(), INTERVAL 10 MONTH) AND NOW()');      
    }

    if($where_condition!='')
    {
      $where_condition = rtrim($where_condition,'AND ');
      $this->db->where($where_condition);
    }

    $option = array_search('option_type',$segment_array);
  
   /* if($option=='')//order by asc or desc
    {
      if($requestData['order'][0]['column']==0)
      {
        $this->db->order_by('sp.sales_person_name'."   ".$requestData['order'][0]['dir']);
      }
      elseif($requestData['order'][0]['column']==1)
      {
        $this->db->order_by('i.item_name'."   ".$requestData['order'][0]['dir']);
      }
    }*/
    $this->db->order_by('i.item_name','asc');

    $query = $this->db->get();
    //echo $this->db->last_query();
    $row = $query->result_array();
    //print_r($row);

    $result = array();

    $result4 = array();

    $result5 = array();

    $final=array();

    $person_ids = array();

    $items_ids =array();

    foreach($row as $value)
    {
      $item_id = $value['item_id'];

      //echo $item_id;
      if(!in_array($item_id,$person_ids))
      {
        $items_ids[] =array('item_id'=>$item_id,'item_name'=> $value['item_name'] );
        $person_ids[] = $item_id;
      }
    }
    //print_r($items_ids);
   foreach ($items_ids as $id) {
          $cus_details = array();
          //$id['item_name'];
          if($option!='')
          {
            $result['item_name'] = $id['item_name'];
          }
          else if($option == '')
          {
            $result['item_name'] ='<p data-yourattr="item" class="item">'.$id['item_name'].'</p>';
          }
          $heading_flip  = array_flip($heading);
          $head_val    = array_fill_keys(array_keys($heading_flip), " ");
          $result_head_val = array_merge($result,$head_val);
          //$get_sales_persons= $this->db->select('sales_person_tbl.sales_person_name,sales_person_tbl.id')->from('sales_person_tbl')->join('sales','sales.sales_person_id=sales_person_tbl.id')->where("item_id", $id['item_id'])->where("DATE_FORMAT(sales_date,'%Y-%m-%d') >=",$start_date)->where("DATE_FORMAT(sales_date,'%Y-%m-%d') <=",$end_date)->group_by('sales_person_name')->get()->result_array();
          $this->db->select('sales_person_tbl.sales_person_name,sales_person_tbl.id');
          $this->db->from('sales_person_tbl');
          $this->db->join('sales','sales.sales_person_id=sales_person_tbl.id');
          // $this->db->join('items','items.id=sales.item_id');
          $this->db->where("item_id", $id['item_id']);
          $this->db->where("DATE_FORMAT(sales_date,'%Y-%m-%d') >=",$start_date);
          $this->db->where("DATE_FORMAT(sales_date,'%Y-%m-%d') <=",$end_date);
          if( trim(@$requestData['search']['value']) != "" )//!empty(trim($requestData['search']['value']))
            {   
              $this->db->join('items','items.id=sales.item_id');
              $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales.user_id AND sales.user_type= "supplier" ','left');
              $this->db->join('customers customers_table', 'customers_table.id=sales.user_id AND sales.user_type= "customer" ','left');
              $search_value = trim($requestData['search']['value']);
              //$where_condition.= "(sp.sales_person_name LIKE '%".$search_value."%' OR i.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%') AND ";
              $where = "(sales_person_tbl.sales_person_name LIKE '%".$search_value."%' OR items.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' ) ";
              $this->db->where($where);
            }
          $this->db->group_by('sales_person_name');
          $get_sales_person=$this->db->get();
          //echo $this->db->last_query();
          $get_sales_persons = $get_sales_person->result_array();
          array_push($final, $result_head_val);
          
        
          foreach($get_sales_persons as $sales_person)
          {
            $title=array();
            $sales_person_name = $sales_person['sales_person_name'];
            $sales_person_id = $sales_person['id'];
            if($option !='')
            {
              $result1['person_name'] = $sales_person_name;
            }
            else if($option == '')
            {
              $result1['person_name']= "<p data-yourattr='item'><b>Sales Person Name:</b> ". $sales_person_name."</p>";
            }
            $heading_flip  = array_flip($heading);
            $head_val    = array_fill_keys(array_keys($heading_flip), " ");
            $result_person_val = array_merge($result1,$head_val);
            array_push($final, $result_person_val);
            $this->db->select('suppliers_table.id as supid,suppliers_table.supplier_name,customers_table.id as cusid,customers_table.customer_name,sales_table.sales_date,sales_table.qty');
            //$this->db->select('sales_table.sales_date,sales_table.qty');
            $this->db->from('sales sales_table');
            $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ','left');
            $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ','left');
            $this->db->where('sales_table.sales_date >=',$start_date);
            $this->db->where('sales_table.sales_date <=',$end_date);
            $this->db->where('sales_table.sales_person_id', $sales_person_id);
            $this->db->where('sales_table.item_id', $id['item_id']);
           if( trim(@$requestData['search']['value']) != "" )//!empty(trim($requestData['search']['value']))
            { 
              $this->db->join('sales_person_tbl','sales_table.sales_person_id=sales_person_tbl.id');
              $this->db->join('items','items.id=sales_table.item_id');
              $search_value = trim($requestData['search']['value']);
              //$where_condition.= "(sp.sales_person_name LIKE '%".$search_value."%' OR i.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%') AND ";
              $where = "(sales_person_tbl.sales_person_name LIKE '%".$search_value."%' OR items.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%' ) ";
              //$where_condition.= "(sp.sales_person_name LIKE '%".$search_value."%' OR i.item_name LIKE '%".$search_value."%' OR suppliers_table.supplier_name LIKE '%".$search_value."%' OR customers_table.customer_name LIKE '%".$search_value."%') AND ";
              $this->db->where($where);
            }
            $this->db->where('sales_table.status =  "active" ');
            $this->db->group_by('sales_table.user_id');
            $query_result = $this->db->get();

            $result2['customer_datails'] = $query_result->result_array();
            //print_r( $result2['customer_datails']);
            if($option !='')
            {
               $head=array('Customer name');

               foreach ($heading as $key => $value) {
              
                array_push($title,date("M-Y", strtotime($value)));

               }
            }
            else if($option == '')
            {
               $head=array('<b>Customer name</b>');

               foreach ($heading as $key => $value) {
              
                array_push($title,'<b>'.date("M-Y", strtotime($value)).'</b>');

               }
            }
            $cus_title =array_merge($head,$title);
              
            array_push($final,$cus_title);

            

            foreach( $result2['customer_datails'] as $res)
            {

              $heading_flip  = array_flip($heading);
              if(!empty($res['cusid']))
              { 
              $cus_id = $res['cusid'];
              }
              else if(!empty($res['supid']))
              {
              $cus_id = $res['supid'];
              }
              //echo $cus_id;

              $head_val    = array_fill_keys(array_keys($heading_flip), 0);
              
             
              
              $qry = $this->db->query("SELECT item_id,sales_person_id as `s`,DATE_FORMAT(sales_date,'%M-%Y') as `month_name`,SUM(qty) as `total_qty`,sales_date as `date` FROM `sales` WHERE `sales_person_id` = '$sales_person_id' AND `item_id` = '".$id["item_id"]."' AND `user_id` = '$cus_id' AND DATE_FORMAT(sales_date,'%Y-%m-%d') >='$start_date' AND DATE_FORMAT(sales_date,'%Y-%m-%d')<='$end_date' AND `status` = 'active'  group by DATE_FORMAT(sales_date,'%M-%Y') order by Month(sales_date),YEAR(sales_date)");
              
              $result_array = $qry->result_array();
              //print_r($result_array);
               
              $array_combine = array_column($result_array,'month_name');
         
              $month=array();
              
                foreach($result_array as $k=>$fetch)/*setting link for quantity*/
                { 
                   $month_name = $fetch['month_name'];
                    if($option =='')
                    {
                      if(!empty($res['customer_name']))
                      {
                         //echo "customer";
                         $result4['name'] = "<a href=".base_url()."customers/transactions/".base64_encode($cus_id)."/record_type/S/start/$start_date/end/$end_date/sales_person_id/$sales_person_id/item_id/".$id['item_id']." target='_blank'>". $res['customer_name']."</a>";

                      }
                      else if(!empty($res['supplier_name']))
                      {
                        //echo "supplier";
                        $result4['name'] = "<a href=".base_url()."suppliers/transactions/".base64_encode($cus_id)."/record_type/S/start/$start_date/end/$end_date/sales_person_id/$sales_person_id/item_id/".$id['item_id']." target='_blank'>".$res['supplier_name']."</a>";
                      }
                    }
                    else if($option !='')
                    {
                      if(!empty($res['customer_name']))
                      {
                         //echo "customer";
                         $result4['name'] = $res['customer_name'];

                      }
                      else if(!empty($res['supplier_name']))
                      {
                        //echo "supplier";
                        $result4['name'] = $res['supplier_name'];
                      }
                    }

                    if($option !='')
                    {
                      //$date_qty = $fetch['date'].'/'.$fetch['total_qty'];
                      $date_qty = $fetch['total_qty'];
                    }
                    else if($option == '')
                    {
                      $date_qty ="<a href=".base_url()."sales_month/sales_history/sales_person_id/$sales_person_id/item_id/".$id['item_id']."/customer_id/$cus_id/sales_date/$month_name/start/$start_date/end/$end_date target='_blank'>".$fetch['total_qty']."</a>";;
                    }
                    $result5=array_merge($result4,$head_val);
                    $month[$fetch['month_name']] = $date_qty;
                    $result6 = array_replace($result5, $month);

              
                }
            
              array_push($final,$result6);
             
            }
            
          }

        }
      
        //$input = array_map("unserialize", array_unique(array_map("serialize", $final)));//removing duplicate
        $input = array_map("unserialize", array_map("serialize", $final));//removing duplicate
        
        $total_count=count($input);
        
        $grid_value2=array();

        foreach ($input as $key => $value) /*combing result and header values*/
        {
              array_push($grid_value2,array_values($value));
        }
        $total_count=count($grid_value2);

        if($option == '')
        { 
            $grid_value2=array_slice($grid_value2,$requestData['start'],$requestData['length']);//setting length
        }
        $title=array();

        $head=array('Salesperson name');

        foreach ($heading as $key => $value) {
          
          array_push($title,date("M-Y", strtotime($value)));

        }
        $heading=array_merge($head,$title);
       /* echo "<pre>";
        print_r($heading);
        echo "<pre>";
        print_r($grid_value2);
        exit;*/
        if($option!==FALSE)
        {
                    $option_type = $this->uri->segment($option+1);        
                    if($option_type=='csv')
                    {
                        //$this->outputCSV($heading,$grid_value2);
                      $this->outputCSV($grid_value2);
                        exit;
                    }
        }

        $count=count($heading);

        ///////////SUM COLUMN BASED ON CONDITION/////////// 
            $json_data = array(

            "draw"             => intval( $requestData['draw'] ),   
           // "recordsTotal"     => intval( $total_count ), 
            "recordsTotal"     => intval( $total_count ),
            "recordsFiltered"  => intval( $total_count), 
            "data"             => $grid_value2,
            "header"           =>$heading,
            "header_count"     =>$count,
            );

      echo json_encode($json_data);
       
  }
  
  public function outputCSV($data) // export data using CSV
  {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=sales_list.csv");
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        $output = fopen("php://output", "w");
        //fputcsv($output, $heading);
        //fputcsv($output);
            foreach ($data as $row) {
        fputcsv($output, $row); // here you can change delimiter/enclosure
        }
        fclose($output);
  }
  public function user_data()
  {
        $this->db->select('sales_table.id,sales_table.user_id,sales_table.item_id,sales_table.user_type,suppliers_table.id AS sid,suppliers_table.sales_person_id as sp_id,customers_table.id AS cid,customers_table.sales_person_id as cs_id');      
        $this->db->from('sales sales_table');
        $this->db->join('suppliers suppliers_table', 'suppliers_table.id=sales_table.user_id AND sales_table.user_type= "supplier" ', 'left');
        $this->db->join('customers customers_table', 'customers_table.id=sales_table.user_id AND sales_table.user_type= "customer" ', 'left');   
        $this->db->order_by('sales_table.id','asc');
        $query = $this->db->get();
        $row = $query->result_array();
        $h=array();
        $s=array();
        echo'<pre>';
        // print_r($row);

        foreach ($row as $key => $value) {
          echo'<pre>';
        if($value['user_type']=='customer' && $value['id']>16015 )
        {
          $this->db->set('sales_person_id',$value['cs_id']); //value that used to update column  
          $this->db->where('id', $value['id']); //which row want to upgrade  
          $this->db->update('sales');

        }
        // if($value['user_type']=='supplier' && $value['id']>16015)
        // {
        //   // echo 'supplier';
        //   print_r($value['sid']);
        //   print_r($value['sp_id']);
        //         // $this->db->set('sales_person_id',$value['sp_id']); //value that used to update column  
        //         // $this->db->where('id', $value['id']); //which row want to upgrade  
        //         // $this->db->update('sales');
        // }
          // print_r($value);
        // 
        //     // if($value['sp_id']!='')
        //     // {
        //     //     echo 'supp';
        //     //     print($value['sp_id']);
                
        //     //     // $this->db->set('sales_id',$value['sp_id']); //value that used to update column  
        //     //     // $this->db->where('id', $value['id']); //which row want to upgrade  
        //     //     // $this->db->update('sales');
        //     // }
        //     if($value['cs_id']!='')
        //     {
        //         echo 'cust';
        //         print_r(count($value['cs_id']));
        //         // print_r($value['cs_id']);

        //         // $this->db->set('sales_id',$value['cs_id']); //value that used to update column  
        //         // $this->db->where('id', $value['id']); //which row want to upgrade  
        //         // $this->db->update('sales');

        //     }       
        }    
        exit;
     }


}

   