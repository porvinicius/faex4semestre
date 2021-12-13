<?php

namespace App\Controllers\pages;

use App\Http\Request;
use App\Models\Entity\User;
use App\Session\flashMessage;

class RegisterController extends PagesController
{
  public function index(Request $request)
  {
    $statusMessage = (new flashMessage)->get('statusMessage') ?? false;
    $this->render('pages/register', [
      'status' => $statusMessage['status'] ?? '',
      'message' => $statusMessage['message'] ?? '',
    ]);
  }

  public function register(Request $request)
  {
    $post = $request->getPostVars();
    $name = $post['name'];
    $birthday = $post['birthday'];
    $rg = $post['rg'];
    $cpf_cnpj = $post['cpf_cnpj'];
    $cep = $post['cep'];
    $street_number = $post['street_number'];
    $phone_number = $post['phone_number'];
    $whatsapp_number = $post['whatsapp_number'];
    $email = $post['email'];
    $password = $post['password'];

    $user = new User();

    if (User::has('cpf_cnpj', $cpf_cnpj)) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'this user already exists.']);
      $request->getRouter()->redirect('register');
    }
    if (User::has('email', $email)) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'this email already exists.']);
      $request->getRouter()->redirect('register');
    }

    $user->cpf_cnpj = $cpf_cnpj;
    $user->name = $name;
    $user->birthday = $birthday;
    $user->rg = $rg;
    $user->cep = $cep;
    $user->street_number = $street_number;
    $user->phone_number = $phone_number;
    $user->whatsapp_number = $whatsapp_number;
    $user->email = $email;
    $user->setPassword($password);

    $userCpf = $user->save();

    if ($user->error()) {
      flashMessage::set('statusMessage', ['status' => 'error', 'message'=> 'error when registering user.']);

      $request->getRouter()->redirect('register');
    }
    flashMessage::set('statusMessage', ['status' => 'success', 'message'=> 'User created successfully, please login below.']);
    $request->getRouter()->redirect('login');
  }
}