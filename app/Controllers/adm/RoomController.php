<?php

namespace App\Controllers\adm;

use App\Http\Request;
use App\Http\Response;
use App\Models\Entity\Room;
use App\Session\flashMessage;
use App\Session\User\Login;

class RoomController extends AdmController
{

  public function index(Request $request)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;

    $model = (new Room())->select()->fetch(true);

    $rooms = [];

    foreach($model as $room) {
      $rooms[] = $room->data();
    }

    $this->render('adm/rooms', [
      'userName' => Login::userName(),
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
      'count' => count($rooms),
      'rooms' => $rooms
    ]);
  }

  public function indexAdd(Request $request)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;

    $this->render('adm/addroom', [
      'title' => 'Adicionando Quarto',
      'action' => 'add',
      'userName' => Login::userName(),
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
    ]);
  }

  public function addRoom(Request $request)
  {
    $post = $request->getPostVars();
    $name = $post['nome'];
    $peoples = $post['pessoas'];
    $local = $post['local'];
    $price = $post['price'];
    $status = $post['status'];

    $room = new Room();

    if (Room::has('name', $name)) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'this room already exists.']);
      $request->getRouter()->redirect('rooms.add');
    }

    $room->name = $name;
    $room->people = $peoples;
    $room->local = $local;
    $room->price = $price;
    $room->status = $status;

    $roomId = $room->save();

    if ($room->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'error when add room.']);
      $request->getRouter()->redirect('rooms.add');
    }
    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'Room created successfully.']);
    $request->getRouter()->redirect('rooms');
  }

  public function chengeStatus(Request $request, $id)
  {
    $susscess = 'success';

    $content = 'sucesso';
    try {
      $room = (new Room())->select()->where('id', $id)->fetch();

      if ($room->status == 'Livre') {
        $room->status = 'Ocupado';
      } else if ($room->status == 'Ocupado') {
        $room->status = 'Livre';
      }

      $room->save();

      if ($room->error()) {
        $susscess = 'error';
        $content = 'Teve um error ao mudar o status';
      }

    } catch (\Exception $e) {
      $susscess = 'error';
      $content = 'Teve um error ao mudar o status';
    }


    $json = ['status' => $susscess, 'message' => $content];

    new Response('200', json_encode($json), 'application/json');
  }

  public function edit(Request $request, $id)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;

    $room = (new Room())->select()->where('id', $id)->fetch();

    $room = [$room];

    $this->render('adm/addroom', [
      'title' => 'Editando Quarto',
      'action' => $room[0]->id.'/edit',
      'userName' => Login::userName(),
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
      'room' => $room
    ]);
  }

  public function editDo(Request $request, $id)
  {
    $post = $request->getPostVars();
    $name = $post['nome'];
    $peoples = $post['pessoas'];
    $local = $post['local'];
    $price = $post['price'];
    $status = $post['status'];

    $room = (new Room())->select()->where('id', $id)->fetch();

    $room->name = $name;
    $room->people = $peoples;
    $room->local = $local;
    $room->price = $price;
    $room->status = $status;

    $roomId = $room->save();

    if ($room->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'error when edit room.']);
      $request->getRouter()->redirect('rooms.edit');
    }
    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'Room edit successfully.']);
    $request->getRouter()->redirect('rooms');
  }


  public function destroy(Request $request, $id)
  {
    $room = (new Room())->select()->where('id', $id)->fetch();

    $room->destroy();

    if ($room->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'error when destroy room.']);
      $request->getRouter()->redirect('rooms');
    }
    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'Room destroy successfully.']);
    $request->getRouter()->redirect('rooms');
  }
}