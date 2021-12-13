<?php

function dd($param = null) {
  if (is_array($param)) {
    foreach ($param as $p) {
      echo "<pre>";
      print_r($p);
      echo "</pre>";
    }
    die();
  }
  echo "<pre>";
  print_r($param);
  echo "</pre>"; die();
}

function betweenDate($day_init, $date_end) {
  $diference = strtotime($date_end) - strtotime($day_init);
  $days = floor($diference / (60 * 60 * 24));
  return $days;
}