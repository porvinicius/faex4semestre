<?php

namespace App\Controllers\adm;

use App\Http\Request;
use App\Models\Entity\Reserve;
use App\Session\flashMessage;
use App\Session\User\Login;

class ReserveController extends AdmController
{
  public function index()
  {

    $reserves = (new Reserve())->select()->fetch(true);

    $reserve = [];
    foreach ($reserves as $reserveobj) {
      $reserve[] = $reserveobj->dataShare();
    }


    $this->render('adm/reserves', [
      'reserves' => $reserve,
      'number' => count($reserve),
      'userName' => Login::userName()
    ]);
  }

  public function remove(Request $request, $id)
  {
    $reserves = (new Reserve())->select()->where('id', $id)->fetch();

    $reserves->destroy();

    if ($reserves->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'error when destroy reserve.']);
      $request->getRouter()->redirect('checkout');
    }
    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'Reserve destroy successfully.']);
    $request->getRouter()->redirect('checkout');
  }
}