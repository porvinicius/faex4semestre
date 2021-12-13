<?php

namespace App\Models\Entity;

use App\Core\Model;

class User extends Model
{
  protected string $primary = 'id';

  protected string $table = 'users';

  protected array $required = ['cpf_cnpj', 'name', 'birthday', 'rg', 'cep', 'street_number', 'phone_number', 'whatsapp_number', 'email', 'password_hash'];

  protected bool $timestamps = false;

  public static function has(string $field, $cpf)
  {
    $model = new User();
    $user = $model->select()->where($field, $cpf)->fetch();

    return !empty($user);
  }

  public function findByUserCpf($cpf)
  {
    $user = $this->select()->where('cpf_cnpj', $cpf)->fetch();
    return $user;
  }

  public function setPassword($password)
  {
    $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
  }

  public function Reserve()
  {
    return (new Reserve())->select()->where('user_id', $this->id)->fetch(true);
  }
}

