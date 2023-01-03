<?php

function strip($strip){
  $strip = strip_tags($strip);
  $strip = addslashes($strip);
  $strip = htmlspecialchars($strip);
  $stripped = htmlentities($strip);
  return $stripped
}
?>