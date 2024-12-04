<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');



/* End of file constants.php */
/* Location: ./application/config/constants.php */

date_default_timezone_set("Asia/Kolkata"); 
define('ITEM_CODE',100);
define('SITE_WORK','done');
//define('SITE_WORK','progress');
define('STATUS_ACTIVE','active');
define('STATUS_INACTIVE','inactive');
define('STATUS_DELETED','deleted');
define('ITEM_TYPES',serialize(array('Purchased','Manufactured','Service')));
define('USER_TYPES',serialize(array('supplier','customer')));
define('RECORD_TYPES',serialize(array('Purchase','Purchase Return','Sales','Sales Return','Payment','Payment Return','Credit','Debit','Credit Return','Debit Return')));
$user_roles_array = array('super_admin','admin','staff','viewer'); // please dont change the array order very important
define('USER_ROLES',serialize($user_roles_array));
$user_permissions_array = array('customers','items','suppliers','sales lists','purchase lists','daily receipt entry',
'manufacturing lists','expense entry','outstanding','negative outstanding','manufacturing report','inventory report','pending bills','sales person','ledger','expenses report');
define('USER_PERMISSIONS',serialize($user_permissions_array));
