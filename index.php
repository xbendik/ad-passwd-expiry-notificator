<?php
//@TODO set some info headers
//@TODO require once all necessary files here

// ----- LETS GO TO WORK ----- //
if(is_array($paths)){
  foreach($paths as $path){
    $ds=ldap_connect($server);
    $r=ldap_bind($ds, $user , $psw);
    $sr=ldap_search($ds, $path, $search);
    $data = ldap_get_entries($ds, $sr);

    for($i=0; $i<$data["count"]; $i++) {
      $pwdset = new DateTime(convert_AD_date($data[$i]["pwdlastset"][0]));
      $heslonastaveno = $pwdset->format('d. m. Y H:i:s');

      $expiry = new DateTime(convert_AD_date($data[$i]["pwdlastset"][0]));
      $expiry->modify('+' . PWD_VALID_DAYS . ' day');

      $notify_from = $pwdset->modify('+' . NOTIFY_DAYS . ' day');
      $end = $notify_from->format('Y-m-d H:i:s');

      $now = new DateTime("now");
      $now = $now->format('Y-m-d H:i:s');
      if($now > $end){
        //include email template here
        if(file_exists("./tempates/email_template_for_users.php")){
          require_once("./tempates/email_template_for_users.php");
        }
        else{
          echo "ERROR: file with email template for users doesnt exist!";
        }

        if(cs_mail($to, $subject, $message, "From: $from" . PHP_EOL)){
          $logtime = date(DATE_FORMAT_LOG . substr((string)microtime(), 1, 8));
          //email send
          $log = "$logtime OK: Send email \"Password validity\" to user " . htmlspecialchars($data[$i]["userprincipalname"][0]) . PHP_EOL;
        }
        else{
          //email was not send
          $logtime = date(DATE_FORMAT_LOG . substr((string)microtime(), 1, 8));
          $log = "$logtime ERROR: not send email \"Password validity\" to user " . htmlspecialchars($data[$i]["userprincipalname"][0]) . PHP_EOL;
        }
        //logging into file
        file_put_contents(dirname(__FILE__) . '/' . NAME_LOG_FILE . '.txt', $log, FILE_APPEND);

      }
      else{
        //password is OK,
        // @TODO udelat nastaveni, zda chteji odesilat email, ze ucet byl zkontrolovan
        //include email template here
        if(file_exists("./tempates/email_template_for_admins.php")){
          require_once("./tempates/email_template_for_admins.php");
        }
        else{
          echo "ERROR: file with email template for admins doesnt exist!";
        }

        if(cs_mail($to, $subject, $message, "From: $from" . PHP_EOL)){
          //email send
          $logtime = date(DATE_FORMAT_LOG . substr((string)microtime(), 1, 8));
          $log = "$logtime OK: send email for admins \"Account OK\" for user account " . htmlspecialchars($data[$i]["userprincipalname"][0]) . PHP_EOL;
        }
        else{
          //email was not send
          $logtime = date(DATE_FORMAT_LOG . substr((string)microtime(), 1, 8));
          $log = "$logtime ERROR: not send email for admins \"Account OK\" for user account " . htmlspecialchars($data[$i]["userprincipalname"][0]) . PHP_EOL;
        }
        // --- end of email template --- //
        //logging into file
        file_put_contents(dirname(__FILE__) . '/' . NAME_LOG_FILE . '.txt', $log, FILE_APPEND);
      }
    }
    ldap_close($ds);
  }
}
else{
  //@TODO vylepsi logovani pro presne zjisteni chyb
  $logtime = date(DATE_FORMAT_LOG . substr((string)microtime(), 1, 8));
  $log = "$logtime Chyba: missing path for accounts.";
  file_put_contents(dirname(__FILE__) . '/' . NAME_LOG_FILE . '.txt', $log, FILE_APPEND);
}
?>