<?php

namespace App\Models\Entity;

use App\Core\Model;

class Room extends Model
{
  protected string $primary = 'id';

  protected string $table = 'rooms';

  protected array $required = ['name', 'people', 'local', 'price', 'status'];

  protected bool $timestamps = false;

  public static function has(string $field, $value)
  {
    $model = new Room();
    $room = $model->select()->where($field, $value)->fetch();

    return !empty($room);
  }


  public function Reserve()
  {
    return (new Reserve())->select()->where($this->id, 'room_id')->fetch();
  }
}