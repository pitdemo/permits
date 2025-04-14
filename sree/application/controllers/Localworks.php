<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Transactions.php
 * Project        : PMS
 * Creation Date  : 06-20-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Transaction Data's
*********************************************************************************************/	

class Localworks extends CI_Controller {

	function __construct()
	{
		parent::__construct(); 
        $this->load->model(array('public_model'));
		$this->data=array('controller'=>$this->router->fetch_class().'/');
		
		$arr=array(123,456,'','',789,1010);

		$arr=array_values(array_filter($arr));

		$test=json_decode('{"a":"24-05-2023","b":"25-05-2023","c":"","d":"","e":"","f":""}',true);

		$test=array_filter($test);

		#echo '<pre>'; print_r(end($test)); exit;

	}

	public function info()
	{

		phpinfo();

		exit;
	}

	public function share()
	{
		
		$mail_subject='Mail Subect';
		$mail_desc=' Mail SubectMail Subect Mail SubectMail SubectMail Subect Mail Subect';
		$permit_no=123;
		$config = array();
		$config['useragent'] = "Sree Cements Online Permit System";
		$config['protocol']		= 'mail';
		$config['charset']		= 'iso-8859-1';
		$config['wordwrap']		= TRUE;
		$config['mailtype'] 	= 'html';
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");  
		$this->email->subject($mail_subject);
		$this->email->message($mail_desc);
		$this->email->from('ak@yopmail.com','AK Kumar');
		#$this->email->from('email@ttaswebsite.com','AK');
		
		
		#$this->email->attach('repo/files/10027308.pdf');         // Add attachments
		#$this->email->attach('https://candidatepool.com.au/candidatepool/repo/files/10027308.pdf');    // Optional name
		
	
		$this->email->to('ananthakumar7@gmail.com');
		$this->email->send();  

		echo 'Debugger '.$this->email->print_debugger();

		$this->session->set_flashdata('success','Permit Info of '.$permit_no.' mail has been sent to the selected users');  

		$ret=array('status'=>false,'print_out'=>'');	

		echo json_encode($ret);

		exit;
	}

	public function printout()
	{

		$job_id=73;

		$where='i.job_id="'.$job_id.'"';

		#$fet=$this->public_model->get_data(array('select'=>'*','where_condition'=>$where,'table'=>JOBSISOLATION,'column'=>'id','dir'=>'asc'))->row_array();

		$req=array(
			'select'=>'i.*,j.permit_no,j.acceptance_performing_id',
			'where'=>$where,
			'table1'=>JOBS.' j',
			'table2'=>JOBSISOLATION.' i',
			'join_on'=>'i.job_id=j.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$job_info = $this->public_model->join_fetch_data($req)->row_array();    

		$this->data['records']=$job_info;

		$where='1=1';

		$req=array(
			'select'=>'u.first_name,d.name as department_name,u.id',
			'where'=>$where,
			'table1'=>USERS.' u',
			'table2'=>DEPARTMENTS.' d',
			'join_on'=>'u.department_id=d.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$users_info = $this->public_model->join_fetch_data($req)->result_array();    

		$this->data['users_info']=$users_info;

		#echo '<pre>'; print_r($users_info); exit;

		$this->load->view('jobs/printout_electrical',$this->data);
	}

	public function group()
	{

		$req=array(
			'select'=>'i.id,i.first_name as text,j.name as group_name',
			'where'=>array('i.status !='=>'deleted'),
			'table1'=>USERS.' i',
			'table2'=>ISSUERS.' j',
			'join_on'=>'i.is_issuer=j.id ',
			'join_type'=>'inner',
			'num_rows'=>false
		);
		$user_details = $this->public_model->join_fetch_data($req)->result_array();      

		$group_by_column=array_column($user_details,'group_name');

		$group_by_column=array_unique($group_by_column);

		$final_results=array();

		echo '<pre>'; 

		foreach($group_by_column as $key => $group_text):

		
			$results=array();

			$results['text']=$group_text;

			$users = array_filter($user_details, function($val) use($group_text) {
				return ($val['group_name']==$group_text);
				});

			$results['children']=array_values($users);

			array_push($final_results,$results);

		endforeach;

		print_r($final_results);

		print_r($group_by_column); exit;



		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: inventran@gmail.com' . "\r\n";

		mail('anantha@yopmail.com','SMTP Test','SMTP Testing',$headers);

	
		echo 'Yes';

		$req=array(
			'to'=>'ananthakumar7@gmail.com',
			'subject'=>'Password Reset',
			'first_name'=>'AK',
			'url'=>base_url().'users/change_forgot_password/email/',
		);
		$req['mail_content']=$this->load->view("email_templates/forgot_password", $req, TRUE);

		#$this->public_model->send_email($req);

		exit;
	}


	public function eip_no()
	{


			$subscription_history=array(
                'select'  =>'j.id,j.department_id,d.name',              
                'table1'=>JOBSISOLATION.' j',
                'table2'=>DEPARTMENTS.' d',
				'join_on'=>'d.id=j.department_id',
                'join_type'=>'inner',
                'num_rows'=>false,
				'order_by'=>'d.id',
				'order'=>'asc',
				'where'=>'d.id=j.department_id'				
            );
			
            $subs_history_qry=$this->public_model->join_fetch_data($subscription_history);

            #echo $this->db->last_query(); exit;
			
			$datas=$subs_history_qry->result_array();


			foreach($datas as $data):

				$dept=strtoupper(substr($data['name'],0,2));

				$id=$data['id'];

				$array=array('eip_no'=>$dept.$id,'eip_no_sec'=>$id);


				//$this->db->where('id',$id);

				//$this->db->update(JOBSISOLATION,$array);

				#echo $this->db->last_query(); exit;

			endforeach;
			

			exit;	

	}


	public function get_max_permit_id($array_args)
	{
		extract($array_args);
		
			$qry=$this->db->query("SELECT MAX(eip_no_sec)+1 as permit_no FROM ".$this->db->dbprefix.JOBSISOLATION." WHERE department_id='".$department_id."'");
			
			#echo $this->db->last_query(); exit;
			$fet=$qry->row_array();	
			
			if($fet['permit_no']=='')
			$fet['permit_no']='1';

			if($this->session->userdata('department_name')=='Power Plant')
			$dept='PP';
			else				
			$dept=substr($this->session->userdata('department_name'),0,2);
			
			return strtoupper($dept.$fet['permit_no']);
			
			#$this->data['permit_no']=strtoupper(substr($this->session->userdata('department_name'),0,2).$fet['permit_no']);
	}

	public function import_permit_checklists()
	{
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'documents/permit_checklists.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		
		echo '<pre>'; print_r($data); #exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			
			  
			  echo '<pre>'; print_r($data); #exit;
			  $name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[0]));	
			  $permit_id=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[1]));

			  if($name!='')
			  {	 
				  $ins=array('permit_id'=>$permit_id,'name'=>$name,'status'=>STATUS_ACTIVE,'modified'=>date('Y-m-d H:i:s'));				
				
				  # $this->db->insert(PERMITS_CHECKLISTS,$ins);

					#echo '<br /> '.$this->db->last_query();

					//exit;
				  
				 } else {
					echo 'End'; exit;
				 }
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	public function import_tags()
	{
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'documents/power/tags_revised.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		
		#echo '<pre>'; print_r(count($data)); exit;
		$r=1;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			
			  
			  #echo '<pre>'; print_r($data); exit;
			  $name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[0]));			
			 
			  $zone_name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[1]));

			  $eq_desc=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[2]));

			  if($name!='')
			  {	  
				$dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>'name = "'.$zone_name.'" AND plant_type="pp"','table'=>ZONES));

				  if($dept->num_rows()>0)
				  {
						$fet=$dept->row_array();

						$zone_id=$fet['id'];  
				  }
				  else
				  {
						$ins=array('name'=>$zone_name,'modified'=>date('Y-m-d H:i:s'),'plant_type'=>'pp');  
						
						$this->db->insert(ZONES,$ins);
					  
					  	$zone_id = $this->db->insert_id();

						echo '<br /> New Zone '.$zone_name;
				  }

				  $ins=array('zone_id'=>$zone_id,'equipment_name'=>$name,'equipment_number'=>$eq_desc,'status'=>STATUS_ACTIVE,'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'),'plant_type'=>'pp');				
				
				    #$this->db->insert(EIP_CHECKLISTS,$ins);

					#echo '<br /> '.$this->db->last_query();

					//exit;
				  
				 } else {
					print_r($data);
					echo 'End '.$r; exit;
				 }

				 $r++;
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	
	
	public function import_users()
	{

		//SELECT d.name as Dept_name,u.first_name,u.email_address,u.mobile_number,u.is_isolator as Isolator,u.is_safety as Safety  FROM `users` u INNER JOIN departments d where d.id=u.department_id
		
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'documents/users_2.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		
		#echo '<pre>'; print_r($data); #exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			
			  
			#  echo '<pre>'; print_r($data); #exit;
			  $department_name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[4]));			
			  $emp_id=$data[0];  
			  $name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[1]));	
			  $department_id=$data[2];		  
			  $username=trim(strtolower(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[3])));

			  if($username!='')
			  {	  
					  $mobile_no=trim($data[4]);

					  $is_isolator=$data[5];	

					  $rand = '1234'; #rand();

					  $pass_word=base64_encode($rand);


						$message = "
						<html>
						<head>
						<title>HTML email</title>
						</head>
						<body>
						<p> Dear ".$name.",</p>
						<p>Your account has been successfully created by <b>Super admin</b. </p><p>Please use this login credentials to access <b>Online Permit System</b></p>
						<p>
				Username : ".$username."</p>
			<p>
				Password :".$rand."</p>
			<p>
				Login URL : <a class='link' href='".base_url()."'' style=\"color:#0e76bc;\" title=\"Login URL\">".base_url()."</a></p>

				<p>&nbsp;</p>

				<p>Regards,</p>
				<p>Online Permit System Team</p>
						</body>
						</html>
						";
	  
				/*	$dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>'name = "'.$department_name.'"','table'=>DEPARTMENTS));

				  if($dept->num_rows()>0)
				  {
						$fet=$dept->row_array();
						$department_id=$fet['id'];  
				  }
				  else
				  {
						$ins=array('name'=>$department_name,'modified'=>date('Y-m-d H:i:s'));  
						
						$this->db->insert(DEPARTMENTS,$ins);
					  
					  	$department_id = $this->db->insert_id();
				  }*/
				  

			  	  #$username = 'ananthakumar7@gmail.com';	

				  $ins=array('email_address'=>$username,'department_id'=>$department_id,'first_name'=>$name,'is_isolator'=>$is_isolator,'mobile_number'=>$mobile_no,'status'=>STATUS_ACTIVE,'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'),'pass_word'=>$pass_word,'employee_id'=>$emp_id);
					
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: <info@dalmiacements.com>' . "\r\n";
					
					$subject = 'Online Permit System Login Credential';			

					#mail($username,$subject,$message,$headers);			  

					#exit;			  
				  
				   # $this->db->insert(USERS,$ins);

					#echo '<br /> '.$this->db->last_query();

					//exit;
				  
				 } else {
					echo 'End'; exit;
				 }
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	public function import_contractors()
	{
		
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'documents/contractors.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		#echo '<pre>'; print_r($data); exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);

			  $name = $data[1];

			  $contact_no = '';#$data[4];
			  
				if($name!='')
				{
				
				  $ins=array('name'=>$name,'contact_no'=>$contact_no,'status'=>STATUS_ACTIVE,'modified'=>date('Y-m-d H:i:s'));
			  
			  	#  $this->db->insert(CONTRACTORS,$ins);
			  }		
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	public function user_isolations()
	{

		$lists=$this->public_model->get_data(array('select'=>'id','where_condition'=>'1=1','table'=>USERS))->result_array();

		$user_id=597;

		print_r($lists);

		$filter = array_search($user_id, array_column($lists, 'id'));

		echo '<pre>'; print_r($filter);

		exit;

		foreach($lists as $list):

			$user_id=$list['id'];

			$ins=array('user_id'=>$user_id,'isolation_id'=>7);
			  
			//$this->db->insert(USERISOLATION,$ins);

		endforeach;

		echo 'End';

		exit;

	}


	public function import_locations()
	{
		
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'uploads/Locations.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		echo '<pre>'; 
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);
			 #print_r($data); exit;
			  
			  $region_name=$data[0];
			  
			  $state_name=$data[1];
			  
			  $dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>'name = "'.$region_name.'"','table'=>'regions'));
				
				echo '<br /> Query : '.$this->db->last_query(); 
			  if($dept->num_rows()>0)
			  {
					$fet=$dept->row_array();
					$region_id=$fet['id'];  
			  }
			  else
			  {
					$ins=array('name'=>$region_name,'modified'=>date('Y-m-d H:i:s'));  
					
					echo 'Yes '.$region_name; exit;
					#$this->db->insert('regions',$ins);
				  
				  #	$region_id = $this->db->insert_id();
			  }
			  
			  $dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>' state_name  = "'.$state_name.'" AND 
			  region_id = "'.$region_id.'"','table'=>'region_states'));
			  
			  if($dept->num_rows()==0)
			  {
				  $ins=array('state_name'=>$state_name,'region_id'=>$region_id);
				  
				  $this->db->insert('region_states',$ins);
			  }
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	public function sops()
	{

		$fetch=$this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>SOPS))->result_array();;

	#	print_r($fetch);

		foreach($fetch as $fet):

			$path = str_replace('/','',$fet['sl_no']).'.pdf';

			$up="UPDATE dml_".SOPS." SET file_name='".$path."' WHERE id='".$fet['id']."'";

			$this->db->query($up);
			
			echo '<br /> SS '.$fet['sl_no'].' - '.str_replace('/','',$fet['sl_no']);

		endforeach;

		exit;
	}

}
