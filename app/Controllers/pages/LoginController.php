<?php

namespace App\Controllers\pages;

use App\Http\Request;
use App\Models\Entity\User;
use App\Session\flashMessage;
use App\Session\User\Login as LoginSession;

class LoginController extends PagesController
{
  public function index(Request $request)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;
    $this->render('pages/login', [
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
    ]);
  }

  public function login(Request $request)
  {
    $post = $request->getPostVars();
    $cpf = $post['cpf_cnpj'] ?? '';
    $password = $post['password'] ?? '';

    $model =  new User();
    $user = $model->findByUserCpf($cpf);

    if (!User::has('cpf_cnpj', $cpf) || !password_verify($password, $user->password_hash)) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'Invalid password or cpf/cnpj.']);
      $request->getRouter()->redirect('login');
    }

    LoginSession::login($user);

    $request->getRouter()->redirect('home');

  }

  public function logout($request)
  {
    LoginSession::logout();

    return $request->getRouter()->redirect('login');
  }
}