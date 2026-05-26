<?php
$lang['language_key'] = 'The actual message to be shown';
$lang['site_name']='Online Permit System';


														//Define Mysql Table Names
														/************************/
define('BRANCH_NAME','Dalmiapuram');
define('EMERGENCY_CONTACT_NUMBER','<span style="font-size:9px;">Emergeny contac number : cell : 9629222100 / 222 / PA system 9 Ref No: WI-33(P1-14:AM 7) Rev No: 01 Dt. 30.06.2016&nbsp;
KLK Mines - 98652 77804, 
KVK Mines - 98651 96203, 
PNR Mines - 98652 77806, 
PTK Mines - 98652 77805</span>');

define('PERMISSION_MSG','Sorry, you don\'t have permission to initiate new permit. Please contact your responsible person');

define('SOPS','sops');
define('WORK_INSTRUCTIONS','work_instructions');
define('USERS','users');
define('NOTES','notes');
define('DEPARTMENTS','departments');
define('JOBS','jobs');
define('JOBSHISTORY','jobs_history');
define('ZONES','zones');
define('CONTRACTORS','contractors');
define('JOBSISOLATION','jobs_isoloations');
define('JOBSISOLATION_REISOLATIONS','jobs_isoloations_reisolations');
define('JOBSISOLATIONHISTORY','jobs_isoloations_history');
define('JOBSISOLATIONRELATIONS','jobs_isolations_relations');
define('ISOLATION','isolations');
define('ISOLATIONDEPARTMENTS','isolation_departments');
define('USERISOLATION','users_isolations');
define('YES','Yes');
define('NO','No');
define('EIP_CHECKLIST_MAX_ROWS',20);
define('EIP_CHECKLIST_ADDITIONAL_ROWS_START',500);
define('EIP_CHECKLIST_ADDITIONAL_ROWS_END',510);

define('EIP_CHECKLISTS','eip_checklists');
define('ELECTRICALPERMITS','electrical_permits');
define('ELECTRICALJOBSHISTORY','electrical_jobs_history');
#define('ELECTRICALISOLATIONRELATIONS','electrical_isolations_relations');

define('CONFINEDPERMITS','confined_permits');
define('CONFINEDJOBSHISTORY','confined_jobs_history');
define('CONFINEDISOLATIONRELATIONS','confined_isolations_relations');

define('UTPUMPSPERMITS','utpumps_permits');
define('UTPUMPSPERMITSHISTORY','utpumps_permits_history');

define('EXCAVATIONPERMITS','excavation_permits');
define('EXCAVATIONPERMITSHISTORY','excavation_permits_history');

define('ERROR_LOGS','error_logs');

define('PERMITS',serialize(array(JOBS=>'Combined',CONFINEDPERMITS=>'Confined',ELECTRICALPERMITS=>'Electrical',UTPUMPSPERMITS=>'UTP',EXCAVATIONPERMITS=>'Excavation')));
##define('PERMITS',serialize(array(EXCAVATIONPERMITS=>'Excavation')));

														/************************/	
													//Define Constant Values Were we using in DB
define('STATUS_ACTIVE','active');
define('STATUS_INACTIVE','inactive');
define('STATUS_CLOSED','Closed');
define('STATUS_DELETED','deleted');
define('STATUS_PENDING','pending');
define('STATUS_CONFIRMED','confirmed');
define('TAXABLE','Taxable');
define('TAX_DEFERRED','Tax Deferred');
define('STATUS_OPENED','open');
define('STATUS_WAITING','waiting');
define('STATUS_DENIED','denied');
define('STATUS_MATCHED','matched');
define('STATUS_MATCH_CONFIRMED','match_confirmed');
define('STATUS_EXCLUDED','excluded');
define('STATUS_APPROVED','approved');
define('STATUS_UPLOADED','uploaded');
define('STATUS_NEW','new');
define('STATUS_LATE','late');
define('WAITING','Waiting');
define('APPROVED','Approved');

define('READ','read');
define('WRITE','write');


//SMS Msg
//SMS Msg
#define('PATOIA_WAITING_APPROVAL','Dear %s, Please proceed %s No. %s Initiator : %s');
define('PATOIA_WAITING_APPROVAL','Dear Sir, Please proceed Permit No. %s Initiator : %s.');

#define('IATOPA_APPROVAL','Dear %s, %s No. %s approved by %s');
define('IATOPA_APPROVAL','Dear Sir, Permit No. %s approved by %s.');


#define('PATOIA_WAITING_CANCEL_REQUEST','Dear %s, Please proceed %s No. %s is Waiting for Cancellation approval by : %s');
define('PATOIA_WAITING_CANCEL_REQUEST','Dear Sir, Please proceed Permit No. %s is Waiting for Cancellation approval by : %s');

#define('PATOIA_WAITING_COMPLETION_REQUEST','Dear %s, Please proceed %s No. %s is Waiting for Completion approval by : %s');
define('PATOIA_WAITING_COMPLETION_REQUEST','Dear Sir, Please proceed Permit No. %s is Waiting for Completion approval by : %s.');

#define('IATOPA_CANCEL_APPROVAL','Dear %s, %s No.%s cancellation request approved by %s');
define('IATOPA_CANCEL_APPROVAL','Dear Sir, General Work Permit No.%s cancellation request approved by %s.');

#define('IATOPA_COMPLETION_APPROVAL','Dear %s, %s No.%s completion request approved by %s');
define('IATOPA_COMPLETION_APPROVAL','Dear Sir, Permit No.%s completion request approved by %s.');

#define('PATOIA_WAITING_EXTEND_APPROVAL','Dear %s, Please proceed %s No. %s is Waiting for extended approval by : %s');
define('PATOIA_WAITING_EXTEND_APPROVAL','Dear Sir, Please proceed Permit No. %s is Waiting for extended approval by : %s.');


#define('IATOPA_ACCEPT_EXTEND_APPROVAL','Dear %s, %s No.%s extended request approved by %s');

define('IATOPA_ACCEPT_EXTEND_APPROVAL','Dear %s, Please proceed Permit No. %s is Waiting for extended approval by : %s.');


#define('PATOIA_SELF_CANCELLED','Dear %s, %s No.%s self cancelled by %s');
define('PATOIA_SELF_CANCELLED','Dear Sir, Permit No.%s self cancelled by %s.');

#define('DEPT_TO_PA','Dear %s, %s No.%s Department clearance is completed. Waiting for IA approval');
define('DEPT_TO_PA','Dear Sir, EIP No. %s Department clearance is completed and EIP is closed');

#define('EIP_PA_TO_ISO','Dear %s, Please proceed %s No. %s is Waiting for isolation approval by : %s');
define('EIP_PA_TO_ISO','Dear Sir, EIP No. %s is Waiting for isolation approval by : %s');

#define('EIP_ISO_TO_PA','Dear %s, %s No. %s isolation request approved by : %s');
define('EIP_ISO_TO_PA','Dear Sir, EIP No. %s isolation request approved by : %s');

#define('EIP_ISO_TO_PA_COMPLETED','Dear %s, %s No. %s isolation approval is completed. Waiting for IA approval');
define('EIP_ISO_TO_PA_COMPLETED','Dear Sir, EIP No. %s isolation approval is completed. Waiting for IA approval.');

#define('EIP_DEPT_TO_PA','Dear %s, %s No. %s Department clearance is completed and EIP is closed');
define('EIP_DEPT_TO_PA','Dear %s, EIP No. %s Department clearance is completed and EIP is closed');



$job_approvals=array(1=>'Waiting IA Acceptance',2=>'Approved IA Acceptance',3=>'Waiting IA Completion',4=>'Approved IA Completion',5=>'Waiting IA Cancellation',6=>'Approved IA Cancellation',7=>'Waiting IA Extended','8'=>'Approved IA Extended',9=>'Auto Closed',10=>'Self Cancel',11=>'Request Rejected by IA',); // Dont change this order
define('JOBAPPROVALS',serialize($job_approvals));
define('JOBAPPROVALS_COLOR',serialize(array($job_approvals[1]=>'btn btn-sm btn-html5 text',$job_approvals[2]=>'btn btn-sm btn-vine text',$job_approvals[3]=>'btn btn-sm btn-youtube text',$job_approvals[5]=>'btn btn-sm btn-html5 text',$job_approvals[4]=>'btn btn-sm btn-xing',$job_approvals[6]=>'btn btn-sm btn-spotify text',$job_approvals[7]=>'btn btn-sm btn-youtube text',$job_approvals[8]=>'btn btn-sm btn-dropbox text',$job_approvals[9]=>'btn btn-sm btn-html5 text',$job_approvals[10]=>'btn btn-sm btn-html5 text',$job_approvals[11]=>'btn btn-sm btn-html5 text')));


$job_approvals=array(1=>'Waiting Dept Clearance',2=>'Approved Dept Acceptance',3=>'Waiting IA Completion',4=>'Approved IA Completion',5=>'Auto Closed',6=>'Self Cancel'); // Dont change this order

define('EXCAVATION_JOBAPPROVALS',serialize($job_approvals));

define('EXCAVATION_CLOSED_STATUS',serialize(array(4,5,6)));


define('EXCAVATION_JOBAPPROVALS_COLOR',serialize(array($job_approvals[1]=>'btn btn-sm btn-html5 text',$job_approvals[2]=>'btn btn-sm btn-vine text',$job_approvals[3]=>'btn btn-sm btn-youtube text',$job_approvals[5]=>'btn btn-sm btn-html5 text',$job_approvals[4]=>'btn btn-sm btn-xing',$job_approvals[6]=>'btn btn-sm btn-spotify text')));

$job_status=array(4,6,9);

define('JOB_STATUS',serialize($job_status));

$closed_permits=array(4=>'Completed',6=>'Cancelled');	//Cancellation, Completed & Auto Closed ,9=>'Auto Closed'
define('CLOSED_PERMITS',serialize($closed_permits));

$eip_approvals=array(1=>'Waiting IA Remarks Acceptance',2=>'Approved IA Remarks',3=>'Waiting Isolation Acceptance',4=>'Approved Isolation ',
5=>'Approved IA Setion (D) Approval',6=>'Approved PA Section (D)',7=>'Waiting Energization Approval',8=>'Energization Approval Completed',9=>'Waiting IA Section (G) Approval',10=>'Waiting Department Section (G) Approval',11=>'Approved Section (G)',12=>'Self Cancel'); // Dont change this order
define('EIPAPPROVALS',serialize($eip_approvals));

define('EIPAPPROVALS_COLOR',serialize(array($eip_approvals[1]=>'btn btn-sm btn-html5 text',$eip_approvals[2]=>'btn btn-sm btn-vine text',$eip_approvals[3]=>'btn btn-sm btn-youtube text',$eip_approvals[4]=>'btn btn-sm btn-xing',$eip_approvals[5]=>'btn btn-sm btn-vine text',$eip_approvals[6]=>'btn btn-sm btn-spotify text',$eip_approvals[7]=>'btn btn-sm btn-xing text',
$eip_approvals[8]=>'btn btn-sm btn-dropbox text',$eip_approvals[9]=>'btn btn-sm btn-html5 text',
$eip_approvals[10]=>'btn btn-sm btn-html5 text',$eip_approvals[11]=>'btn btn-sm btn-vine text',$eip_approvals[12]=>'btn btn-sm btn-html5 text')));

//confined permits only
$job_approvals=array(1=>'Waiting SA Acceptance',2=>'Approved SA Acceptance',3=>'Waiting IA Acceptance',4=>'Approved IA Acceptance',5=>'Waiting IA Completion',6=>'Approved IA Completion',7=>'Waiting IA Cancellation',8=>'Approved IA Cancellation',9=>'Waiting SA Extended',10=>'Approved SA Extended',11=>'Waiting IA Extended',12=>'Approved IA Extended',13=>'Self Cancel'); // Dont change this order
define('CONFINED_JOBAPPROVALS',serialize($job_approvals));

define('CONFINED_JOB_STATUS',serialize(array(6,8,13)));

$closed_permits=array(6=>'Completed',8=>'Cancelled');	//Cancellation, Completed & Auto Closed ,9=>'Auto Closed'
define('CONFINED_CLOSED_PERMITS',serialize($closed_permits));
define('CONFINED_CLOSE_PERMITS',serialize(array(6,8,13)));
define('CLOSED_JOBS',serialize(array(9,10,4,6)));

define('CONFINED_JOBAPPROVALS_COLOR',serialize(array($job_approvals[1]=>'btn btn-sm btn-html5 text',$job_approvals[2]=>'btn btn-sm btn-vine text',$job_approvals[3]=>'btn btn-sm btn-youtube text',$job_approvals[5]=>'btn btn-sm btn-html5 text',$job_approvals[4]=>'btn btn-sm btn-xing',$job_approvals[6]=>'btn btn-sm btn-spotify text',$job_approvals[7]=>'btn btn-sm btn-youtube text',$job_approvals[8]=>'btn btn-sm btn-dropbox text',$job_approvals[9]=>'btn btn-sm btn-html5 text',$job_approvals[10]=>'btn btn-sm btn-vine text',
	$job_approvals[11]=>'btn btn-sm btn-html5 text',$job_approvals[12]=>'btn btn-sm btn-vine text',$job_approvals[13]=>'btn-sm btn-dropbox text')));



#define('JOBAPPROVALS_COLOR',serialize(array($job_approvals[2]=>'btn btn-sm btn-tumblr text',$job_approvals[3]=>'btn btn-sm btn-html5 text',$job_approvals[1]=>'btn btn-sm btn-youtube text',$job_approvals[5]=>'btn btn-sm btn-dribbble text',$job_approvals[6]=>'btn btn-sm btn-spotify text',$subscription_status[6]=>'btn btn-sm btn-vine text',$subscription_status[7]=>'btn btn-sm btn-xing text',$subscription_status[8]=>'btn btn-sm btn-dropbox text',$subscription_status[9]=>'btn btn-sm btn-instagram text',$subscription_status[10]=>'btn btn-sm btn-vk text')));

//madusudhanan
define('STATUS_ALL','all');									/*********************************************/
														//Define constant values for User Role
define('SA','Super Admin');
define('CIO','Chief Investment Officer');
define('DCS','Director of Client Services');
define('DCR','Director of Client Reporting');
define('CCO','Chief Compliance Officer');
//Form use only
$user_roles=array('IA'=>'Iussing Authority','PA'=>'Performing Authority','SFA'=>'Safety Authority');
define('USER_ROLES',serialize($user_roles));
													/*********************************************/
															//GLOBAL MESSAGES
//Define constant values for Login
define('LOGIN_ERROR','Invalid Credentials! Please check!');
define('LOGIN_SUCCESS','Login Successful');
define('WRNG_PASSWD','Invalid Current Password! Please Check!');
define('ACC_DISABLED','You account is disabled! Please Contact Admin');

//Define constant values for CRUD
define('DB_UPDATE','MODULE updated successfully!'); // MODULE will be replaced with Controller name
define('DB_ADD','MODULE added successfully!'); // MODULE will be replaced with Controller name
define('DB_FAILED','Data upload failed / improper fields. Please check and try again');
define('DB_DELETE','MODULE deleted successfully!'); // MODULE will be replaced with Controller name
define('REQUIRED','You must select atleast one');
//madusudhanan account add
define('ACCOUNT_ADD_MSG','New Account created for');
define('ACCOUNT_EDIT_NOTES','has been accessed by');

//Define constant values for Password Updation
define('CHNG_PASSWD','Password updated!');
define('FGT_PASSWORD','Forgot password changed successfully !');
define('LOGOUT','Logged out successfully!');

//Define constant values for notes
define('NEW_USER','Added new user successfully!');
define('UPD_USER','Updated the user info!');
define('DEL_USER','Deleted the user!');
define('NEW_COMPANY','Added new company successfully!');
define('DEL_COMPANY','Deleted new company successfully!');

//Define constant for Mail Problems
define('MAIL_PROB','E-Mail not sent successfully...!');
define('DATE_FORMAT','d-m-Y');




#define('EIP_OTHER_DEPARTMENT','7,9');
define('EIP_OTHER_DEPARTMENT','2,3');
define('EIP_TECHNICAL',1);
define('EIP_ELECTRICAL',14);
define('EIP_CIVIL',12);
define('EIP_INSTRUMENTAL',15);
define('EIP_MECHANICAL',16);
define('EIP_UTILITIES',27);
define('EIP_PROCESS',7);
define('EIP_PROCESS_NEW',11);
define('EIP_POWER_PLANT',9);
define('EIP_SAFETY',19);
define('EIP_PRODUCTION',11);
define('EIP_IT',21);
define('EIP_CPP',9);
define('EIP_PACKING_OPERATION',17);
define('EIP_MINES',20);
define('EIP_ELECTRICAL_INSTRUMENTAL',14);

define('EIP_COMPLETED_DEPARTMENTS',serialize(array(EIP_ELECTRICAL,EIP_INSTRUMENTAL,EIP_MECHANICAL,EIP_UTILITIES,EIP_PROCESS)));

define('PERMIT_CLOSE_AFTER',26);

define('INVALID_ISSUING_AUTHORITY', 'Issuing authority changed. You can\'t ACTION job!');

define('ADMIN', 'admin'); 

define('IA_USERS','404,410');

?>