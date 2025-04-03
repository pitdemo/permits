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

		$test=json_decode('{"a":"24-05-2023","b":"25-05-2023","c":"","d":"","e":"","f":""}',true);

		$test=array_filter($test);

		#echo '<pre>'; print_r(end($test)); exit;

	}

	public function import_tags()
	{
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'/uploads/tags.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		
		#echo '<pre>'; print_r($data); #exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			
			  
			  #echo '<pre>'; print_r($data); exit;
			  	
			 
			  $zone_name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[1]));

			  $name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[3]));		

			  $tag_no=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[2]));		

			  if($name!='')
			  {	  
				$dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>'name = "'.$zone_name.'" AND status="'.STATUS_ACTIVE.'"','table'=>ZONES));

				  if($dept->num_rows()>0)
				  {
						$fet=$dept->row_array();

						$zone_id=$fet['id'];  
				  }
				  else
				  {
						$ins=array('name'=>$zone_name,'modified'=>date('Y-m-d H:i:s'));  
						
						$this->db->insert(ZONES,$ins);
					  
					  	$zone_id = $this->db->insert_id();

						echo '<br /> New Zone '.$zone_name;
				  }

				  $ins=array('zone_id'=>$zone_id,'equipment_name'=>$tag_no,'equipment_number'=>$name,'status'=>STATUS_ACTIVE,'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'));				
				
				   $this->db->insert(EIP_CHECKLISTS,$ins);

					#echo '<br /> '.$this->db->last_query();

					//exit;
				  
				 } else {
					echo 'End'; exit;
				 }
				#  print_r(fgetcsv($fp));
		  }
			
		
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
	
	
	public function import_users()
	{

		//SELECT d.name as Dept_name,u.first_name,u.email_address,u.mobile_number,u.is_isolator as Isolator,u.is_safety as Safety  FROM `users` u INNER JOIN departments d where d.id=u.department_id
		
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'uploads/dalmiausers.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		
		echo '<pre>'; print_r($data);exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			
			  
			  #echo '<pre>'; print_r($data); exit;
			  $department_name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[4]));
			  
			  $name=trim(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[1]));
			  
			  $username=trim(strtolower(preg_replace( '/[\x00-\x1F\x80-\xFF]/', ' ',$data[2])));

			  if($username!='')
			  {	  
					  $mobile_no=trim($data[3]);

					  $is_isolator='No';#$data[5];	

					  $rand = '123456'; #rand();

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
	  
					$dept=$this->public_model->get_data(array('select'=>'id','where_condition'=>'name = "'.$department_name.'"','table'=>DEPARTMENTS));

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
				  }
			  	
			  	  #$username = 'ananthakumar7@gmail.com';	

				  $ins=array('email_address'=>$username,'department_id'=>$department_id,'first_name'=>$name,'is_isolator'=>$is_isolator,'mobile_number'=>$mobile_no,'status'=>STATUS_ACTIVE,'created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'),'pass_word'=>$pass_word);
					
					// Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: <info@dalmiacements.com>' . "\r\n";
					
					$subject = 'Online Permit System Login Credential';			

					#mail($username,$subject,$message,$headers);			  

					#exit;			  
				  
				    $this->db->insert(USERS,$ins);

				  
				 } 
				#  print_r(fgetcsv($fp));
		  }
			
		
	}

	public function import_contractors()
	{
		
		$this->load->library('csvimport');
		
		$file=UPLODPATH.'uploads/contractors.csv';
		
		#$data = $this->csvimport->get_array($file);
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		#echo '<pre>'; print_r($data); exit;
		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);

			  $name = $data[0];

			  $contact_no = '';#$data[4];
			  
				if($name!='')
				{
				
				  $ins=array('name'=>$name,'contact_no'=>$contact_no,'status'=>STATUS_ACTIVE,'modified'=>date('Y-m-d H:i:s'));
			  
			  	  $this->db->insert(CONTRACTORS,$ins);
			  }		
				#  print_r(fgetcsv($fp));
		  }
			
		
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

	public function update_sops()
	{

		$datas=$this->public_model->join_fetch_data(array('select'=>'j.id,j.sop,s.sl_no,s.id as sop_id','table1'=>SOPS.' s','table2'=>JOBS.' j','join_type'=>'inner','join_on'=>'j.sop=s.id','where'=>'1=1','order_by'=>'j.id','order'=>'asc','num_rows'=>false,'group_by'=>'j.sop'))->result_array();



		#echo $this->db->last_query(); exit;

		foreach($datas as $data):

				$job_id=$data['id'];

				$sl_no=$data['sl_no'];

				$sop=$data['sop'];

				$s=$this->public_model->get_data(array('select'=>'id','where_condition'=>' sl_no  = "'.$sl_no.'"','table'=>'sops_new'))->row_array();
				

				if($s){

					$new_sop_id=$s['id'];

					$data=array('sop'=>$new_sop_id);

					$whr=array('sop'=>$sop);

				#	$this->db->update(JOBS,$data,$whr);
				}



		endforeach;

		echo 'Done';

		exit;
	}

	public function wi()
	{


		$path = './uploads/sops_wi/';
		#$files = scandir($path);
		#$dh = opendir($path);


		$this->load->library('csvimport');
		
		$file=UPLODPATH.'uploads/sops/wi.csv';
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		 echo '<pre>'; #print_r($data); exit;


		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);			

			  $file_name=trim(str_replace('/','',trim($data[1])).'.pdf');

			  $file_path=$path.$file_name;

			 # echo $file_path; exit;

			  if(file_exists($file_path)){

				$sl_no=trim($data[1]);

				$description=trim($data[0]);

				$department_id=$data[2];

				echo '<br /> AA '.$description.' = '.$sl_no.' = '.$department_id.' = '.$file_path;

				$ins=array('department_id'=>$department_id,'modified'=>date('Y-m-d H:i:s'),'created'=>date('Y-m-d H:i:s'),'sl_no'=>$sl_no,'description'=>$description,'file_name'=>$file_name,'record_type'=>WORK_INSTRUCTIONS);  
						
				#$this->db->insert(SOPS,$ins);

				#echo '<br /> Not Available '.$file_path; 
			  }
			  
		  }
		#print_r($files); exit;


		echo '<br /> End'; exit;

		
	}

	public function sops()
	{
		$path = './uploads/sops_wi/';
		#$files = scandir($path);
		#$dh = opendir($path);


		$this->load->library('csvimport');
		
		$file=UPLODPATH.'uploads/sops/sops.csv';
		
		 $fp = fopen($file, 'r');
								  
		 $data=fgetcsv($fp,0,',');
		
		 echo '<pre>'; #print_r($data); exit;


		  while(! feof($fp))
		  {
			  $data=fgetcsv($fp);

			  $file_name=trim(str_replace('/','',$data[1]).'.pdf');

			  $file_path=$path.$file_name;

			 # echo $file_path; exit;

			  if(file_exists($file_path)){

				$sl_no=$data[1];

				$description=trim($data[0]);

				$department_id=$data[2];

				echo '<br /> AA '.$description.' = '.$sl_no.' = '.$department_id;

				$ins=array('department_id'=>$department_id,'modified'=>date('Y-m-d H:i:s'),'created'=>date('Y-m-d H:i:s'),'sl_no'=>$sl_no,'description'=>$description,'file_name'=>$file_name);  
						
				#$this->db->insert(SOPS,$ins);

				#echo '<br /> Not Available '.$file_path; 
			  }
			  
		  }
		#print_r($files); exit;


		echo '<br /> End'; exit;

		$fetch=$this->public_model->get_data(array('select'=>'*','where_condition'=>'1=1','table'=>SOPS))->result_array();;

	#	print_r($fetch);

		foreach($fetch as $fet):

			$path = str_replace('/','',$fet['sl_no']).'.pdf';

			$up="UPDATE dml_".SOPS." SET file_name='".$path."' WHERE id='".$fet['id']."'";

			#$this->db->query($up);
			
			echo '<br /> SS '.$fet['sl_no'].' - '.str_replace('/','',$fet['sl_no']);

		endforeach;

		exit;
	}

}
