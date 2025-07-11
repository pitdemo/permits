<?php
//include_once APPPATH.'/third_party/mpdf60/mpdf.php';
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************************************************
 * Filename       : Transactions.php
 * Project        : PMS
 * Creation Date  : 06-20-2016
 * Author         : Anantha Kumar RJ
 * Description    : Manageing Transaction Data's
*********************************************************************************************/	

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

//require_once(APPPATH . 'third_party/firebase-jwt/vendor/autoload.php');
//require_once(APPPATH . 'third_party/firebase-jwt/start.php');

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

		#phpinfo(); exit;

		#echo '<pre>'; print_r(end($test)); exit;

	}

	public function rename()
	{
			$i=1;
			$path=UPLODPATH.'uploads/sops_wi/1/';

		if ($handle = opendir($path)) {
		while (false !== ($fileName = readdir($handle))) {
		if($fileName != '.' && $fileName != '..') {
			$newName = str_replace("SKU#","",$fileName);
			#rename($path.$fileName, $path.$i.'.jpeg');

			$i++;
		}
		}
		closedir($handle);

		echo 'Rename is done';

		exit;
}

	}

	public function adobe2()
	{

		echo 'AA '.$_SERVER['DOCUMENT_ROOT']; exit;
		$source = UPLODPATH.'uploads/permits/7/CP-PRC1_1751082640.pdf';
		$target= UPLODPATH.'uploads/permits/';

		exec('/usr/local/bin/convert "'.$source .'" -colorspace RGB -res "'.$target.'"');


	}

	public function adobe()
	{

		$this->load->library('Authorization_Token');


		$token_data['user_id'] = 1001;
		$token_data['fullname'] = 'Hello World'; 
		$token_data['email'] = 'helloworld@gmail.com';

		$payload = [
    "iss" => "A57523C26863CCDF0A495C4B@AdobeOrg", // from json
    "sub" => "A4F023E26863CD240A495E38@techacct.adobe.com", // from json
    "aud" => "https://ims-na1.adobelogin.com/c/9c29d62518cc404e9bb8720ceb265a1d", // from json
    "exp" => time() + 60 * 60,
    "https://ims-na1.adobelogin.com/s/ent_documentcloud_sdk" => true
];

		#$tokenData = $this->authorization_token->generateToken($payload);

		#echo 'AA '.$tokenData; exit;

		$client_id='9c29d62518cc404e9bb8720ceb265a1d';

		$client_secret='p8e-_kY_91Xymq2OteJHKLri8VLA71l9-sin';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://pdf-services-ue1.adobe.io/token');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
			'client_id' => $client_id,
			'client_secret' => $client_secret
		]));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$erorr= curl_error($ch);

		echo '<br /> Error '.$erorr; 
		$data = json_decode($response, true);

		echo '<pre>';
		#@print_r($data);
		$accessToken = $data['access_token'];

		echo "Access Token: $accessToken";

		echo '<br />---------------------------------';



		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://pdf-services-ue1.adobe.io/assets');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer $accessToken",
			"x-api-key: ".$client_id,
			"Content-Type: application/json"
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
			'mediaType' =>"application/pdf"
		]));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$erorr= curl_error($ch);
		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		echo '<br /> Error '.$erorr; 
		echo '<br /> statusCode '.$statusCode;
		
		$data = json_decode($response, true);
		$uploadUrl = $data['uploadUri'];
		$assetId = $data['assetID'];

		echo '<br /> Asset ID '.$assetId;

		echo '<br />-----------------------------------';
	
		$pdfFilePath = 'https://sclptw.in/uploads/sops_wi/aaaaaa.pdf';
		$pdfFilePath = UPLODPATH.'uploads/permits/7/CP-PRC1_1751082640.pdf';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uploadUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PUT, true);
		curl_setopt($ch, CURLOPT_INFILE, fopen($pdfFilePath, 'r'));
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($pdfFilePath));
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Content-Type: application/pdf'
		]);

		$response = curl_exec($ch);

		echo '<br />File Uploaded Response '; $response;

		print_r($response);

		$statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		echo '<br /> File Uploaded statusCode '.$statusCode;
		
		echo '<br />-----------------------------------';
		echo '<br />-----------------------------------';

		
		
		$convertUrl = 'https://pdf-services.adobe.io/operation/exportpdf';

		$payload = json_encode([
			"inputs" => [
				[
					"assetID" => $assetId,
					"mediaType" => "application/pdf"
				]
			],
			"outputFormat" => "image/jpeg"
		]);

		$ch = curl_init($convertUrl);
		curl_setopt_array($ch, [
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer $accessToken",
				"x-api-key: $client_id",
				"Content-Type: application/json"
			],
			CURLOPT_POSTFIELDS => $payload
		]);

		$response = curl_exec($ch);
		curl_close($ch);
		$data = json_decode($response, true);

		if (!isset($data['jobID'])) {
			die("❌ Failed to start image conversion.\n$response");
		}

		$jobId = $data['jobID'];
		echo "⏳ Conversion job started. Job ID: $jobId\n";



		exit;
	}

	public function pdf2()
	{

		include_once APPPATH.'/third_party/pdf/mpdf.php';

		$path = UPLODPATH.'uploads/permits/7/CP-PRC1_1751082640.pdf';

		exit;

	}

	function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start /B ". $cmd, "r"));  
    } 
    else { 
        exec($cmd . " > /dev/null &");   
    } 
	return;
}

	public function pdf()
	{


		if (class_exists('Imagick')) {
    echo "Imagick is installed and working.";
} else {
    echo "Imagick is NOT installed.";
}


			$path = UPLODPATH.'uploads/permits/7/CP-PRC1_1751082640.pdf';
			$path2= UPLODPATH.'uploads/permits/7/';
			//header("Content-Type: application/pdf");
			//readfile($path);


			/*$CurlConnect = curl_init();
curl_setopt($CurlConnect, CURLOPT_URL, $path);
curl_setopt($CurlConnect, CURLOPT_RETURNTRANSFER, 1 );
$file_contents = curl_exec($CurlConnect);
curl_close($CurlConnect);
$CurlConnect = null;
echo $file_contents; exit;*/

			/*$html = ob_get_contents();
			ob_end_clean();

			$mpdf=new mPDF();
			$mpdf->WriteHTML($html);
			$mpdf->Output($path2,'F');*/

			#$path = UPLODPATH.'uploads/permits/101/CP-MEC17_1746770733.pdf';
			#$path2= UPLODPATH.'uploads/permits/101/';

			echo 'AA '.substr(php_uname(), 0, 7);

						// create Imagick object
			//$imagick = new Imagick($path);
			#$noOfPagesInPDF = $imagick->getNumberImages(); 

			$cmd = "magick identify " . chr(34) . $path . "[0]" . chr(34) . " -background white -flatten -resample " . chr(34) . "300x300" . chr(34) . " -thumbnail " . chr(34) . "102x102" . chr(34) . " -format jpg -write " . chr(34) . $path2 . chr(34);
			$this->execInBackground($cmd);

			#echo 'AA '.$noOfPagesInPDF;
			// Reads image from PDF
			#$imagick->readImage($path);
			// Writes an image
			#$imagick->writeImages($path2.'converted.jpg', false);

			#header("Content-Type: application/pdf");

			#readfile($path);
			

			exit;


	}
	
	public function newsendmail()
	{
	    
            	    // recipient email address
            $to = "ananthakumar7@gmail.com";
            
            // subject of the email
            $subject = "Email with Attachment";
            
            // message body
            $message = "This is a sample email with attachment.";
            
            // from
            $from = "ak@yopmail.com";
            
            // boundary
            $boundary = uniqid();
            
            // header information
            $headers = "From: $from\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\".$boundary.\"\r\n";
            
            // attachment
            $attachment = chunk_split(base64_encode(file_get_contents('uploads/permits/79/permit1744525324.pdf')));
            
            // message with attachment
            $message = "--".$boundary."\r\n";
            $message .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $message .= chunk_split(base64_encode($message));
            $message .= "--".$boundary."\r\n";
            $message .= "Content-Type: application/octet-stream; name=\"file.pdf\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "Content-Disposition: attachment; filename=\"file.pdf\"\r\n\r\n";
            $message .= $attachment."\r\n";
            $message .= "--".$boundary."--";
            
            // send email
            if (mail($to, $subject, $message, $headers)) {
                echo "Email with attachment sent successfully.";
            } else {
                echo "Failed to send email with attachment.";
            }
            
            exit;

	}
	
	
	public function sendmail()
	{
		
		$subject='Mail SubectAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
		$message=' Mail SubectMail Subect Mail SubectMail SubectMail Subect Mail Subect';
		$permit_no=123;
		$from_name='AK';
		$from_mail=$replyto='ak@yopmail.com';
		 
		 $uid = md5(uniqid(time()));
		 
		 $filename='uploads/permits/79/permit1744525324.pdf';

        $header = "From: ".$from_name." <".$from_mail.">\n";
        $header .= "Reply-To: ".$replyto."\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\n\n";
        $emessage= "--".$uid."\n";
        $emessage.= "Content-type:text/plain; charset=iso-8859-1\n";
        $emessage.= "Content-Transfer-Encoding: 7bit\n\n";
        $emessage .= $message."\n\n";
        $emessage.= "--".$uid."\n";
        //$emessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\n"; // use different content types here
        $emessage .= "Content-Transfer-Encoding: base64\n";
       // $emessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\n\n";
      //  $emessage .= $content."\n\n";
        $emessage .= "--".$uid."--";
        mail('ananthakumar7@gmail.com',$subject,$emessage,$header);

		exit;
	}

	public function info()
	{

		phpinfo();

		exit;
	}
	
	public function smtp()
	{
		$mail_subject='Mail Subect zzzzzzzzzzzzzzzzz';
		$mail_desc=' Mail SubectMail Subect Mail SubectMail SubectMail Subect Mail Subect';
		$permit_no=123;

		$config = array();
		$config['useragent'] = "Sree Cements Online Permit System";
	   // $config['mailpath'] = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "mail.pitinfotech.com";
		$config['smtp_user'] = 'permits@pitinfotech.com';
		$config['smtp_pass'] = 'zy}FL^~[nQxx';        
		$config['smtp_port']= "465";
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$config['newline']  = "\r\n";
		$config['validate']     = true;
		$config['wordwrap'] = TRUE;
	//	$config['send_multipart'] = FALSE;
		$config['mailtype'] = 'html'; 
		$config['smtp_crypto'] = 'ssl';
		
		echo '<pre>'; print_r($config);
		$this->load->library('email');
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");  
		$this->email->subject($mail_subject);
		$this->email->message($mail_desc);
	   $this->email->from('ak@yopmail.com','AK Kumar');
		
	
	
	
		$this->email->to('ananthakumar7@gmail.com');
		$this->email->send();  

		echo 'Debugger '.$this->email->print_debugger();

		$this->session->set_flashdata('success','Permit Info of '.$permit_no.' mail has been sent to the selected users');  

		$ret=array('status'=>false,'print_out'=>'');	

		echo json_encode($ret);

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
		$this->email->clear(TRUE);
		$this->email->set_newline("\r\n");  
		$this->email->subject($mail_subject);
		$this->email->message($mail_desc);
		$this->email->from('ak@yopmail.com','AK Kumar');
		#$this->email->from('email@ttaswebsite.com','AK');
		
		
		#$this->email->attach('repo/files/10027308.pdf');         // Add attachments
		#$this->email->attach('https://candidatepool.com.au/candidatepool/repo/files/10027308.pdf');    // Optional name
		
	
		$this->email->to('ananthakumar7@yopmail.com');
		$this->email->send();  

		echo 'Debuggersssssss '.$this->email->print_debugger();

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
