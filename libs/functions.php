<?php
// ----- OWN HELPER FUNCTIONS -----//
/**
 * function ldap_escape
 * @author Chris Wright
 * @version 2.0
 * @param string $subject The subject string
 * @param bool $dn Treat subject as a DN if TRUE
 * @param string|array $ignore Set of characters to leave untouched
 * @return string The escaped string
 */
function ldap_escape($subject, $dn = TRUE, $ignore = NULL){
  // The base array of characters to escape
  // Flip to keys for easy use of unset()
  $search = array_flip($dn ? array('\\', ',', '=', '+', '<', '>', ';', '"', '#') : array('\\', '*', '(', ')', "\x00"));

  // Process characters to ignore
  if(is_array($ignore)){
    $ignore = array_values($ignore);
  }
  for($char = 0; isset($ignore[$char]); $char++){
    unset($search[$ignore[$char]]);
  }

  // Flip $search back to values and build $replace array
  $search = array_keys($search);
  $replace = array();
  foreach ($search as $char) {
    $replace[] = sprintf('\\%02x', ord($char));
  }

  // Do the main replacement
  $result = str_replace($search, $replace, $subject);

  // Encode leading/trailing spaces in DN values
  if($dn){
    if($result[0] == ' '){
      $result = '\\20'.substr($result, 1);
    }
    if($result[strlen($result) - 1] == ' '){
      $result = substr($result, 0, -1).'\\20';
    }
  }
  return $result;
}

/**
 * function convert_AD_date
 * @author morecavalier.com
 * @version 1.0
 * @URL http://morecavalier.com/index.php?whom=Apps%2FLDAP+timestamp+converter
 * @param string $ad_date The timestamp from AD
 * @return string The formated timestamp "Y-m-d H:i:s"
 */

function convert_AD_date($ad_date){
	if($ad_date == 0){
		return '0000-00-00';
	}
	$secsAfterADEpoch = $ad_date / (10000000);
	$AD2Unix=((1970-1601) * 365 - 3 + round((1970-1601)/4)) * 86400;
	$unixTimeStamp=intval($secsAfterADEpoch-$AD2Unix);
	$myDate = date("Y-m-d H:i:s", $unixTimeStamp); // formatted date

	return $myDate;
}

// convert charset to UTF-8
function autoUTF($s){
  // detection of UTF-8
  if(preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
    return $s;

  // detection of WINDOWS-1250
  if(preg_match('#[\x7F-\x9F\xBC]#', $s))
    return iconv('WINDOWS-1250', 'UTF-8', $s);

  // premise ISO-8859-2
    return iconv('ISO-8859-2', 'UTF-8', $s);
}

//email function for correct charset settings
function cs_mail($to, $subject, $message, $head = ""){
  $subject = "=?utf-8?B?".base64_encode(autoUTF ($subject))."?=";
  $head .= "MIME-Version: 1.0\n";
  $head .= "Content-Type: text/html; charset=\"utf-8\"\n";
  $head .= "Content-Transfer-Encoding: base64\n";
  $head .= "X-Priority: 1 (Highest)\n";
  $head .= "X-MSMail-Priority: High\n";
  $head .= "Importance: High\n";
  $head .= "Bcc: " . BCC . "\n";
  $message = base64_encode (autoUTF ($message));
  return mail($to, $subject, $message, $head, "-f " . ERROR_REPLY);
}

//escaping email address, for secure reason only
function _filterEmail($email){
  $rule = array("\r" => '',
                "\n" => '',
                "\t" => '',
                '"'  => '',
                ','  => '',
                '<'  => '',
                '>'  => '',
  );

  return strtr($email, $rule);
}
// ----- END OF OWN HELPER FUNCTIONS -----//

?>