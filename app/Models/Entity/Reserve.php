<?php

namespace App\Models\Entity;

use App\Core\Model;

class Reserve extends Model
{
  protected string $primary = 'id';

  protected string $table = 'reserves';

  protected array $required = ['user_id', 'check_in', 'check_out', 'room_id'];

  protected bool $timestamps = false;

  public static function verifyDate($checkin, $checkout, $id)
  {
    $model = new Reserve();

    $op1 = $model->select()->where('room_id', $id)->between('check_in', $checkin, $checkout, '\'')->fetch();
    $model = new Reserve();
    $op2 = $model->select()->where('room_id', $id)->between('check_out', $checkin, $checkout, '\'')->fetch();
    $model = new Reserve();
    $op3 = $model->select()->where('room_id', $id)->where('check_in', '<', $checkin)->where('check_out', '>', $checkout)->fetch();

    if (!empty($op1->id) or !empty($op2->id) or !empty($op3->id)) {
      return true;
    }

    return false;
  }

  public function User()
  {
    return (new User())->select()->where('id', $this->user_id)->fetch();
  }

  public function Room()
  {
    return (new Room())->select()->where('id', $this->room_id)->fetch();
  }

  public function dataShare()
  {
    $data = get_object_vars($this->data());


    $data['days'] = betweenDate($data['check_in'], $data['check_out']);


    $data['user'] = get_object_vars($this->User()->data());

    $data['room'] = get_object_vars($this->Room()->data());

    unset($data['user']['password_hash']);

    return $data;
  }

}