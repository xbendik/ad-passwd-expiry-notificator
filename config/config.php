<?php
// ----- SWITCH BETWEEN DEBUG MODE -----//
if(constant('DEBUG') == "on"){
  //DEBUG mode
  ini_set("display_errors", 1);
  error_reporting(E_ALL);
  ini_set('display_startup_errors', TRUE);
}
else{
  //normal mode
  ini_set("display_errors", 0);
  error_reporting(0);
  ini_set('display_startup_errors', FALSE);
}
// ----- END OF SWITCH BETWEEN DEBUG MODE -----//

?>