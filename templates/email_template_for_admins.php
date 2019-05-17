<?php
// --- email template for admins--- //
$to = "someone@somecompany.com"; //email will be sent for this
$from = "some_mailbox@somecompany.com"; //fake sender this email
$subject = "ADPEN - account OK"; // email subject

// email message, could be in HTML format
$message = "Hello,<br>" . PHP_EOL ;
$message.= " this is controll email from ADPEN.<br><br>" . PHP_EOL ;
$message.= "There was checked user account " . $data[$i]["userprincipalname"][0] . ", where password will expire in <b>" . $expiry->format(DATE_FORMAT) . "</b><br>" . PHP_EOL ;
$message.= "This account is allright.<br><br>" . PHP_EOL ;
$message.= "Have a nice day<br>" . PHP_EOL ;
$message.= "IT department<br>" . PHP_EOL ;

?>