<?php
// maakt SQL injectie niet mogelijk
function strip($strip){
  $strip = strip_tags($strip);
  $strip = addslashes($strip);
  $strip = htmlspecialchars($strip);
  $stripped = htmlentities($strip);
  return $stripped;
}

// uitloggen
function uitloggen(){
  session_unset();
  session_destroy();
  header('location index.php');
}
?>