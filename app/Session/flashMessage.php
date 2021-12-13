<?php

namespace App\Session;

class flashMessage
{
  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  public function get($key)
  {
    $value = $_SESSION[$key] ?? false;
    if ($value) {
      return;
    }
    unset($_SESSION[$key]);
    return $value;
  }
}