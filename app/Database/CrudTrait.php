<?php


namespace App\Database;

use DateTime;
use PDOException;

trait CrudTrait
{

  protected ?PDOException $error = null;

  public function create(array $data): ?int
  {
    if ($this->timestamps) {
      $data["create_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
      $data["update_at"] = $data["create_at"];
    }

    try {
      $columns = implode(",", array_keys($data));
      $values = ":" . implode(", :", array_keys($data));

      $stmt = Connection::getInstance()->prepare("INSERT INTO  {$this->table} ({$columns}) values ({$values})");
      $stmt->execute($this->filter($data));

      return Connection::getInstance()->lastInsertId();
      
    } catch (PDOException $e) {
      $this->error = $e;
      return null;
    }
  }

  public function update(array $data, string $terms, string $params): ?int
  {
    if ($this->timestamps) {
      $data["updated_at"] = (new DateTime("now"))->format("Y-m-d H:i:s");
    }

    try {
      $dateSet = [];
      foreach ($data as $bind => $value) {
        $dateSet[] = "{$bind} = :{$bind}";
      }
      $dateSet = implode(", ", $dateSet);
      parse_str($params, $params);

      $stmt = Connection::getInstance()->prepare("UPDATE {$this->table} SET {$dateSet} WHERE {$terms}");
      $stmt->execute($this->filter(array_merge($data, $params)));
      return ($stmt->rowCount() ?? 1);
    } catch (PDOException $exception) {
      $this->error = $exception;
      return null;
    }
  }

  public function delete(string $terms, ?string $params): bool
  {
    try {
      $stmt = Connection::getInstance()->prepare("DELETE FROM {$this->table} WHERE {$terms}");
      if (!empty($params)) {
        parse_str($params, $params);
        $stmt->execute($params);
        return true;
      }

      $stmt->execute();
      return true;
    } catch (PDOException $e) {
      $this->error = $e;
      return false;
    }
  }

  public function filter(array $data): ?array
  {
    $filter = [];
    foreach ($data as $key => $value) {
      $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_DEFAULT));
    }
    return $filter;
  }
}