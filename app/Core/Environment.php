<?php

namespace App\Core;

class Environment
{
  public static function load($path): void
  {
    $pattern = '/([^\=]*)\=[^\n]*/';

    $envFile = $path."/.env";
    $lines = file($envFile);;
    foreach ($lines as $line) {
      preg_match($pattern, $line, $matches);

      if (!empty($matches)) putenv(trim($line));
    }

  }
}