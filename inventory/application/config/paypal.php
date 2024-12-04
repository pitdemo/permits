<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Sandbox / Test Mode
 * -------------------------
 * TRUE means you'll be hitting PayPal's sandbox/test servers.  FALSE means you'll be hitting the live servers.
 */
$config['Sandbox'] = TRUE;

/* 
 * PayPal API Version
 * ------------------
 * The library is currently using PayPal API version 98.0.  
 * You may adjust this value here and then pass it into the PayPal object when you create it within your scripts to override if necessary.
 */
$config['APIVersion'] = '98.0';

/*
 * PayPal Gateway API Credentials
 * ------------------------------
 * These are your PayPal API credentials for working with the PayPal gateway directly.
 * These are used any time you're using the parent PayPal class within the library.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may obtain these credentials by logging into the following with your PayPal account: https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-api-run
 */

$config['APIUsername'] = $config['Sandbox'] ? 'sutharsa.v-facilitator_api1.gmail.com' : 'PRODUCTION_USERNAME_GOES_HERE';//v.sutharsan-facilitator_api1.galaxyweblinks.co.in
$config['APIPassword'] = $config['Sandbox'] ? '1392374932' : 'PRODUCTION_PASSWORD_GOES_HERE';//1392117556
$config['APISignature'] = $config['Sandbox'] ? 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAbtAm9.J5nsYpaEPn6PQleE0Q6Bo' : 'PRODUCTION_SIGNATURE_GOES_HERE';//AFcWxV21C7fd0v3bYYYRCpSSRl31A0I-ICBNPodl1LxgBNDrQliuT2a7

/*
 * Payflow Gateway API Credentials
 * ------------------------------
 * These are the credentials you use for your PayPal Manager:  http://manager.paypal.com
 * These are used when you're working with the PayFlow child class.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 * You may use the same credentials you use to login to your PayPal Manager, 
 * or you may create API specific credentials from within your PayPal Manager account.
 */
/*$config['PayFlowUsername'] = $config['Sandbox'] ? 'palexanderpayflowtestapionly' : 'PRODUCTION_USERNAME_GOGES_HERE';
$config['PayFlowPassword'] = $config['Sandbox'] ? 'demopass123' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['PayFlowVendor'] = $config['Sandbox'] ? 'palexanderpayflowtest' : 'PRODUCTION_VENDOR_GOES_HERE';
$config['PayFlowPartner'] = $config['Sandbox'] ? 'PayPal' : 'PRODUCTION_PARTNER_GOES_HERE';*/

$config['PayFlowUsername'] = $config['Sandbox'] ? 'swighty1' : 'swighty1';
$config['PayFlowPassword'] = $config['Sandbox'] ? 'cworks2002' : 'cworks2002';
$config['PayFlowVendor'] = $config['Sandbox'] ? 'swighty1' : 'swighty1';
$config['PayFlowPartner'] = $config['Sandbox'] ? 'PayPal' : 'PayPal';

/*
 * PayPal Application ID
 * --------------------------------------
 * The application is only required with Adaptive Payments applications.
 * You obtain your application ID but submitting it for approval within your 
 * developer account at http://developer.paypal.com
 *
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * The sandbox value included here is a global value provided for developrs to use in the PayPal sandbox.
 */
$config['ApplicationID'] = $config['Sandbox'] ? 'APP-80W284485P519543T' : 'PRODUCTION_APP_ID_GOES_HERE';

/*
 * PayPal Developer Account Email Address
 * This is the email address that you use to sign in to http://developer.paypal.com
 */
$config['DeveloperEmailAccount'] = 'sutharsa.v@gmail.com';

/**
 * Third Party User Values
 * These can be setup here or within each caller directly when setting up the PayPal object.
 */
$config['DeviceID'] = '';

/**
 * Paypal url
 */
 
// $config['EndPoint'] =  $config['Sandbox'] ? 'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';

 $config['EndPoint'] =  $config['Sandbox'] ? 'https://pilot-payflowpro.paypal.com/' : 'https://payflowpro.paypal.com';

/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */