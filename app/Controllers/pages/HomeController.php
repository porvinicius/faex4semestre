<?php

namespace App\Controllers\pages;

use App\Models\Entity\Room;
use App\Session\User\Login;

class HomeController extends PagesController
{
  public function index()
  {
    $roomModel = (new Room())->select()->fetch(true);

    $rooms = [];


    foreach ($roomModel as $room) {
      $rooms[] = $room;
    }

    $this->render('pages/home', [
      'isLogged' => Login::isLogged()? 1: 'false',
      'role' => Login::role(),
      'countRoom' => count($rooms),
      'rooms' => $rooms,
    ]);
  }
}