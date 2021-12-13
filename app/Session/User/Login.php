<?php

namespace App\Session\User;

class Login
{
  private static function init()
  {
    if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public static function login($obUser)
  {
    self::init();


    $_SESSION['login']['user'] = [
      'id' => $obUser->id,
      'cpf_cnpj' => $obUser->cpf_cnpj,
      'user' => $obUser->name,
      'phone_number' => $obUser->phone_number,
      'role' => $obUser->role,
      'whatsapp_number' => $obUser->whatsapp_number,
      'email' => $obUser->email,
    ];

    return true;
  }

  public static function isLogged(): bool
  {
    self::init();

    return isset($_SESSION['login']['user']['id']);
  }

  public static function logout(): bool
  {
    self::init();

    unset($_SESSION['login']['user']);

    return true;
  }

  public static function role()
  {
    return $_SESSION['login']['user']['role'] ?? false;
  }

  public static function userName(): string
  {
    return $_SESSION['login']['user']['user'] ?? false;
  }

  public static function id()
  {
    return $_SESSION['login']['user']['id'] ?? false;
  }

}