<?php

namespace App\Controllers\pages;

use App\Http\Request;
use App\Models\Entity\Reserve;
use App\Session\flashMessage;
use App\Session\User\Login;

class ReservesController extends PagesController
{
  public function index(Request $request)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;

    $model = (new Reserve())->select()->where('user_id', Login::id())->fetch(true);

    $reserves = [];

    foreach ($model as $reserve) {
      $reserves[] = $reserve->dataShare();
    }

    $this->render('pages/reserves', [
      'isLogged' => Login::isLogged()? 1: 'false',
      'role' => Login::role(),
      'number' => count($reserves),
      'reserves' => $reserves,
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
    ]);
  }

  public function create(Request $request, $id)
  {
    $post = $request->getPostVars();

    $checkin = $post['checkin'];
    $checkout = $post['checkout'];

    $dataAtual = date('Y-m-d');

    if ($checkin < $dataAtual or $checkout < $dataAtual or $checkin > $checkout) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'data de checkin ou checkout invalidas.']);
      $request->getRouter()->redirect('id.room', ['id' => $id]);
    };


    if (Reserve::verifyDate($checkin, $checkout, $id)) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'Já existe uma reserva para essa data']);
      $request->getRouter()->redirect('id.room', ['id' => $id]);
    }

    $reserve = new Reserve();

    $reserve->check_in = $checkin;
    $reserve->check_out = $checkout;
    $reserve->room_id = $id;
    $reserve->user_id = Login::id();

    $reserve->save();

    if ($reserve->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'Não foi possivel realizar uma reserva.']);
      $request->getRouter()->redirect('id.room', ['id' => $id]);
    }

    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'Reserva Realizada']);
    $request->getRouter()->redirect('id.room', ['id' => $id]);
  }
}