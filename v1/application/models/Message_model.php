<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : public_model.php
 * Project        : PMS
 * Creation Date  : 06-02-2016
 * Author         : Anantha Kumar RJ
 * Description    : Write a common module to use anywhere in the project
*********************************************************************************************/	
class Message_model extends CI_Model
{
	

	public	function __construct()
	{
		parent::__construct();
        $message='';
	}
	
	// Message function
    public function insert_message($message_type)
	{
		$company_id=$this->session->userdata('companies_id');
		$user_id=$this->session->userdata('user_id');
        $user_first_name=$this->session->userdata('first_name');
		$insert_message_data = $insert_notes_data=array();
		extract($message_type);
		if($type=='acc_add_csv_import')
		{
			foreach($new_accounts as $fund_acc_no=>$account_name)
			{
				$status_and_account_num = explode('||',$account_name);
				$format = ' '.ACCOUNT_ADD_MSG.' %s' ;	
				$url="<a href='BASE_URLaccounts/index/filter_status/".$status_and_account_num[1]."/search/".$fund_acc_no."/' target='_blank' alt='View'>".$status_and_account_num[0]."</a>";
			 	$message = sprintf($format, $url);
				
				$insert_message_data[]=array(
							'companies_id'=>$company_id,
							'fund_account_number'=>$fund_acc_no,
							'user_id'=>$user_id,
							'message'=>$message,
							'created'=>date('Y-m-d H:i:s')
					);
				 //Add Notes to the account
				 if(isset($is_notes_add))
				 {
					$notes_message=' '.ACCOUNT_ADD_MSG. ' '.$fund_acc_no. ' imported by '.$user_first_name;
					$insert_notes_data[]=array(
								'companies_id'=>$company_id,
							    'record_type'=>($record_type)?$record_type:'',
								'fund_account_number'=>$fund_acc_no,
								'user_id'=>$user_id,
								'notes'=>$notes_message,
								'created'=>date('Y-m-d H:i:s')
							);
				 }
			}
		}
		else if($type=='acc_add_manual')
		{
			 $account_name = $account_name;
			 $format = ' '.ACCOUNT_ADD_MSG.' %s' ;
			 $url="<a href='BASE_URLaccounts/index/filter_status/".STATUS_CONFIRMED."/search/".$fund_account_num."/' target='_blank' alt='View'>".$account_name."</a>";
			 $message = sprintf($format, $url);
			 $insert_message_data[]=array(
							'companies_id'=>$company_id,
							'fund_account_number'=>$fund_account_num,
							'user_id'=>$user_id,
							'message'=>$message,
							'created'=>date('Y-m-d H:i:s')
					);
			 if(isset($is_notes_add))
			 {
				$notes_message=' '.ACCOUNT_ADD_MSG. ' '.$fund_account_num. ' by '.$user_first_name;
				$insert_notes_data[]=array(
							'companies_id'=>$company_id,
							'record_type'=>($record_type)?$record_type:'',
							'fund_account_number'=>$fund_account_num,
							'user_id'=>$user_id,
							'notes'=>$notes_message,
							'created'=>date('Y-m-d H:i:s')
						);
			 }		 
		}
		else if($type=='import_zip')
		  {
			  $fund_account_ids = explode(',',$fund_account_ids);
		   foreach($fund_account_ids as $fund_acc_no)
		   {
			$format="Please review new ".$record." for %s"; 
			if($record=='account')
			$url="<a href='BASE_URLaccounts/index/filter_status/".STATUS_PENDING."/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
			$message = sprintf($format,$url);
			//Add Notes to the account
			if(isset($is_notes_add))
			{
			 $notes_message=sprintf(IMPORT_ACCOUNT. ' through ZIP',$this->session->userdata('first_name'));
			 $insert_notes_data[]=array(
				'companies_id'=>$company_id,
				'fund_account_number'=>$fund_acc_no,
				'user_id'=>$user_id,
				'notes'=>$notes_message,
				'created'=>date('Y-m-d')
			   );
			}
			$insert_message_data[]=array(
			   'companies_id'=>$company_id,
			   'fund_account_number'=>$fund_acc_no,
			   'user_id'=>$user_id,
			   'message'=>$message,
			   'created'=>date('Y-m-d')
			 );
		   }
		  }
		  else if($type=='notes_add_create_transaction')
		  {
		  		//echo '<pre>';print_r($transaction_datas);exit;
		  		foreach($transaction_datas as $transaction_data)
				{
					if(isset($is_notes_add))
					{
						if(isset($csv_and_bd))
						{
							$format = 'The transaction account number %s has moved to BD by %s';
							$notes_message = sprintf($format, $transaction_data['AccountNumber'], $user_first_name);
						}
						else
						{
							$format = 'The new transaction has created %s for account id %s by %s';
							$notes_message = sprintf($format, $transaction_data['TransactionID'], $transaction_data['AccountId'], $user_first_name);
						}
				  		
					 	$insert_notes_data[]=array(
							'companies_id'=>$company_id,
							'record_type'=>($record_type)?$record_type:'',
							'fund_account_number'=>($transaction_data['AccountNumber'])?$transaction_data['AccountNumber']:'',
							'user_id'=>$user_id,
							'notes'=>$notes_message,
							'created'=>date('Y-m-d H:i:s')
						   );
					}
				}
		  }
		  else
		  {
		   foreach($fund_and_pi_account_ids as $fund_acc_no=>$pi_acc_no)
		   {
			switch ($type) 
			{ 
			 case 'match':
				$url="<a href='BASE_URLaccounts/index/filter_status/all/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is matched to %s by %s';
				  $message = sprintf($format, $url, $pi_acc_no, $user_first_name);
				}
				else
				{
				  $format = 'The %s fund account id is matched by %s';
				  $message = sprintf($format, $url, $user_first_name);
				}
			  break;
			 case 'closed':
				$url="<a href='BASE_URLaccounts/index/filter_status/all/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is closed to %s by %s';
				  $message = sprintf($format, $url, $pi_acc_no, $user_first_name);
				}
				else
				{
				  $format = 'The %s fund account id is closed by %s';
				  $message = sprintf($format, $url, $user_first_name);
				}
			  break;
			 case 'opened':
				$url="<a href='BASE_URLaccounts/index/filter_status/all/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is opened to %s by %s';
				  $message = sprintf($format, $url, $pi_acc_no, $user_first_name);
				}
				else
				{
				  $format = 'The %s fund account id is opened by %s';
				  $message = sprintf($format, $url, $user_first_name);
				}
			  break;
			  case 'denied':
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is denied to %s by %s';
				  $message = sprintf($format, $fund_acc_no, $pi_acc_no, $user_first_name);
				}
				else
				{
				  $format = 'The %s fund account id is denied by %s';
				  $message = sprintf($format, $fund_acc_no, $user_first_name);
				}
			  break;
			  case 'unmatch':
				$url="<a href='BASE_URLaccounts/index/filter_status/".STATUS_PENDING."/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is unmatched to %s by %s';
				  $message = sprintf($format, $url, $pi_acc_no, $user_first_name);
				}
				else
				{
				  $format = 'The %s fund account id is unmatched by %s';
				  $message = sprintf($format, $url, $user_first_name);
				}
			  break;
			  case 'associate_pi_account':
			  	$url="<a href='BASE_URLaccounts/index/filter_status/all/search/".$fund_acc_no."/' target='_blank' alt='View'>".$fund_acc_no."</a>";
				if($pi_acc_no!='')
				{
				  $format = 'The %s fund account id is associated with %s by %s';
				  $message = sprintf($format, $url, $pi_acc_no, $user_first_name);
				}
			  break;
			  default:
			  break;
			}
			$insert_message_data[]=array(
			   'companies_id'=>$company_id,
			   'fund_account_number'=>$fund_acc_no,
			   'user_id'=>$user_id,
			   'message'=>$message,
			   'created'=>date('Y-m-d')
			 );
		   }
		  }
		  
		  //Insert Messages
		  if(count($insert_message_data)>0)
		  $this->db->insert_batch(MESSAGE,$insert_message_data);
		  
		  //Insert Notes
		  if(count($insert_notes_data)>0)
		  $this->db->insert_batch(NOTES,$insert_notes_data);
			}
		}