<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
  private static ?PDO $instance;
  
  private static ?PDOException $error = null;

  private function __construct(){}
  private function __clone(){}

  public static function getInstance(): ?PDO {
      if (empty(self::$instance)) {
//        try {
          self::$instance = new PDO(
            getenv("DATABASE_DRIVE") . ":host=" . getenv("DATABASE_HOST") . ";dbname=" . getenv("DATABASE_NAME") . ";port=" . getenv("DATABASE_PORT"),
            getenv("DATABASE_USERNAME"),
            getenv("DATABASE_PASSWORD"),
            [
              PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
              PDO::ATTR_CASE => PDO::CASE_NATURAL
            ]
          );
//        } catch (PDOException $e) {
//          self::$error = $e;
//        }
      }
      return self::$instance;
  }


  public static function getError(): ?PDOException
  {
    return self::$error;
  }
}