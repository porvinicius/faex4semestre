<?php

namespace App\Controllers\adm;

use App\Http\Request;
use App\Models\Entity\Reserve;
use App\Models\Entity\User;
use App\Session\User\Login;

class CheckInController extends AdmController
{
  public function index(Request $request)
  {

    $post = $request->getQueryParams();

    if (isset($post['search'])) {
      $search = trim(filter_var($post['search'], FILTER_SANITIZE_STRING));
    }

    if (empty($post['search'])) {
      $reserves = (new Reserve())->select()->fetch(true);
    } else {
      $model = (new User())->select()->where('cpf_cnpj', 'like', $search)->fetch();
      if (isset($model)) {
        $reserves = $model->Reserve();
      }
    }

    if (!isset($reserves)) {
      $status = 'true';
      $message = 'Não tem nunhuma reserva com esse cnpj/cnpj';
    }

    $reserve = [];
    foreach ($reserves as $reserveobj) {
      $reserve[] = $reserveobj->dataShare();
    }


    $this->render('adm/checkin', [
      'reserves' => $reserve,
      'number' => count($reserve),
      'userName' => Login::userName(),
      'status' => $status ?? '',
      'message' => $message ?? '',
    ]);
  }
}