<?php
// --- email template --- //
$to = _filterEmail($data[$i]["userprincipalname"][0]);

$from = "from_mailbox@somecompany.com";//fake email sender
$subject = "Password validity!"; //email subject

//Email message here, could be in HTML format
$message = "Hello,<br>" . PHP_EOL ;
$message.= "We are recommending to change your password.<br><br>" . PHP_EOL ;
$message.= "Your password is valid until: <b>" . $expiry->format(DATE_FORMAT) . "</b><br><br>" . PHP_EOL ;
$message.= "Have a nice day<br>" . PHP_EOL ;
$message.= "IT department<br>" . PHP_EOL ;
$message .= "<hr>";
$message .= "<font color=\"silver\" size=\"2\">Send for account: " . _filterEmail($data[$i]["userprincipalname"][0]) . "</font><br>" . PHP_EOL ;//

?>