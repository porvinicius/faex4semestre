<?php

namespace App\Controllers\pages;

use App\Http\Request;
use App\Models\Entity\Room;
use App\Session\flashMessage;
use App\Session\User\Login;

class RoomController extends PagesController
{
  public function index(Request $request, $id)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;

    $room = [(new Room())->select()->where('id', $id)->fetch()];

    if (empty($room[0]->id)) {
      $request->getRouter()->redirect('error', ['errorCode' => 404]);
    };

    $this->render('pages/room', [
      'isLogged' => Login::isLogged()? 1: 'false',
      'role' => Login::role(),
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
      'room' => $room
    ]);
  }
}