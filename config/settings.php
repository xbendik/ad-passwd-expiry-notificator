<?php
//------ SETTINGS -----//
//@TODO some header about licence, author, etc here

//application settings
setlocale(LC_ALL, 'en_US'); //set locale
define("DEBUG", "on"); //here is set for debug mode (value "on" should be for testing mode only!
define("EMAIL_FOR_ADMIN", "on"); //turn on/off sending email for admins, just for sure, that every account was tested.
define("ERROR_REPLY", "somemailbox@somedomain.com"); //here is set for sending returned error mesage from mailserver, if will be some error with delivering/non existing mailbox, etc...
define("BCC", "somemailbox@somedomain.com"); //here is set for sending BCCs while checked accounts, so you make be sure, that affected user has notification email about expiring password
define("DATE_FORMAT", "d. m. Y H:i:s"); // date format, which will be included in all emails, this is date standard format
define("DATE_FORMAT_LOG", "Y-m-d H:i:s"); // date format, which will be in log file only
define("NAME_LOG_FILE", "log_" . date("Y-n-d"); //here is set, how logfile will be named this format look like this: "log_2015-12-20"
define("PWD_VALID_DAYS", "30"); //here is set, how many days is valid domain users password
define("NOTIFY_DAYS", "26"); //here is set, from how many days from beggining which was password set, will be user notify
if(!defined('PHP_EOL')){define('PHP_EOL', strtoupper(substr(PHP_OS,0,3) == 'WIN') ? "\r\n" : "\n");} //End of line define

//LDAP Settings
$server = "ldap://domaincontroler.somecompany.ad"; //LDAP server
$user = "login@somecompany.ad"; //login into LDAP server
$psw = "password"; //password for $user
$search = "(&(objectClass=user)(objectCategory=person)(|(mail=*)(telephonenumber=*)(mailNickname=*))(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";//LDAP query for search any active user

?>