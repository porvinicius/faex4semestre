<?php

namespace App\Controllers\adm;

use App\Models\Entity\User;
use App\Session\User\Login;

class ClienteController extends AdmController
{
  public function index()
  {

    $clientsModel = (new User())->select()->fetch(true);

    $clients = [];

    foreach ($clientsModel as $client) {
      $clients[] = $client->data();
    }



    $this->render('adm/clientes', [
      'userName' => Login::userName(),
      'clientsNumber' => count($clients),
      'clients' => $clients
    ]);
  }
}