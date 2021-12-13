<?php

namespace App\Core;

use App\Database\Connection;
use App\Database\CrudTrait;
use PDO;
use PDOException;

class Model
{

  use CrudTrait;

  protected string $table;

  protected string $primary = 'id';

  protected array $required = [];

  protected bool $timestamps = true;

  protected string $query;

  protected ?array $params = null;

  protected string $group = '';

  protected string $order = '';

  protected string $limit = '';

  protected string $offset = '';

  protected string $where = '';

  protected string $join = '';

  protected ?PDOException $error = null;

  protected  ?object $data;

  public function __set($name, $value) {
    if (empty($this->data)) {
      $this->data = new \stdClass();
    }
    $this->data->$name = $value;
  }

  public function __isset($name)
  {
    return isset($this->data->$name);
  }

  public function __get($name)
  {
    $method = $this->toCamelCase($name);
    if (method_exists($this, $method)) {
      return $this->$method();
    }

    if (method_exists($this, $name)) {
      return $this->$name();
    }

    return ($this->data->$name ?? null);
  }

  public function columns($mode = PDO::FETCH_OBJ): array {
    $stmt = Connection::getInstance()->prepare("DESCRIBE {$this->table}");
    $stmt->execute($this->params);
    return $stmt->fetchAll($mode);
  }

  public function data(): ?object {
    return $this->data;
  }

  public function error() {
    return $this->error? $this->error: false;
  }

  public function select(array $columns = ["*"]): Model
  {
    $this->query = "SELECT ".implode(",", $columns)." FROM $this->table";
    return $this;
  }

  public function selectRaw(string $select): Model
  {
    $this->query = "SELECT {$select} FROM {$this->table}";
    return $this;
  }


  public function find(?string $terms = '', ?string $params = null, string $columns = "*"): Model {
    if (!empty($terms)) {
      $this->query = "SELECT {$columns} FROM {$this->table} where {$terms}";
      parse_str($params, $this->params);
      return $this;
    }

    $this->query = "SELECT {$columns} from {$this->table}";
    return $this;
  }

  public function findById(int $id, string $columns = "*"): ?Model
  {
    return $this->find("{$this->primary} = :id", "id={$id}", $columns)->fetch();
  }

  public function where(string $field, string $param, ?string $value = null): ?Model
  {
    if (empty($value)) {
      $value = $param;
      $param = '=';
    }

    if (empty($this->where)) {
      $this->where = " WHERE {$field} {$param} :".str_replace(".", "_", mb_strtolower($field));
    } else {
      $this->where .= " AND {$field} {$param} :".str_replace(".", "_", mb_strtolower($field));
    }

    $params = str_replace(".", "_", mb_strtolower($field))."={$value}";
    $this->setPrams($params);
    parse_str($params, $this->params);
    if ($param === 'like') {
      $end = end($this->params);
      $this->params[array_key_last($this->params)] = "%{$end}%";
    }
    return $this;
  }

  public function between($field, $value, $value2, $arround = '')
  {
    if (empty($this->where)) {
      $this->where = " WHERE ({$field} BETWEEN ".':'.str_replace(".", "_", mb_strtolower($field.'a')) ." AND :".str_replace(".", "_", mb_strtolower($field.'b')).")";
    } else {
      $this->where .= " AND ({$field} BETWEEN ".':'.str_replace(".", "_", mb_strtolower($field.'a')) ." AND :".str_replace(".", "_", mb_strtolower($field.'b')).")";
    }

    $params = str_replace(".", "_", mb_strtolower($field.'a'))."={$value}&".str_replace(".", "_", mb_strtolower($field.'b'))."={$value2}";
    $this->setPrams($params);
    parse_str($params, $this->params);
    return $this;
  }

  public function group(string $column): ?Model
  {
    $this->group = " GROUP BY {$column}";
    return $this;
  }

  public function order(string $columnOrder): ?Model
  {
    $this->order = " ORDER BY {$columnOrder}";
    return $this;
  }

  public function limit(int $limit): Model {
    $this->limit = " LIMIT {$limit}";
    return $this;
  }

  public function offset(int $offset): Model
  {
    $this->offset = " OFFSET {$offset}";
    return $this;
  }

  public function fetch(bool $all = false)
  {
    try {
      $stmt = Connection::getInstance()->prepare($this->query . $this->join . $this->where . $this->group . $this->order . $this->limit . $this->offset.';');
      $stmt->execute($this->params);

      if (!$stmt->rowCount()) {
        return null;
      }

      if ($all) {
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
      }

      return $stmt->fetchObject(static::class);

    } catch (PDOException $e) {
      $this->error = $e;
      return null;
    }
  }

  public function count(): int
  {
    $stmt = Connection::getInstance()->prepare($this->query . $this->join . $this->where . $this->group . $this->order . $this->limit . $this->offset);
    $stmt->execute($this->params);
    return $stmt->rowCount();
  }

  public function join(string $table, string $columnJoin, string $param, string $columnTable, ?string $tabledefault = null): ?Model
  {
    if (empty($tabledefault)) {
      $tabledefault = $this->table;
    }
    $this->join .= " INNER JOIN {$table} ON {$table}.{$columnJoin} {$param} {$tabledefault}.{$columnTable}";
    return $this;
  }

  public function leftJoin(string $table, string $columnJoin, string $param, string $columnTable): ?Model
  {
    $this->join = " LEFT OUTER JOIN {$table} ON {$table}.{$columnJoin} {$param} {$this->table}.{$columnTable}";
    return $this;
  }

  public function rightJoin(string $table, string $columnJoin, string $param, string $columnTable): ?Model
  {
    $this->join = " RIGHT OUTER JOIN {$table} ON {$table}.{$columnJoin} {$param} {$this->table}.{$columnTable}";
    return $this;
  }

  public function save(): bool
  {
    $primary = $this->primary;
    $id = null;

    try {
      if (!$this->required()) {
        throw new \Exception("Preencha os campos necessarios");
      }

      if (!empty($this->data->$primary)) {
        $id = $this->data->$primary;

        $this->update($this->safe(), "{$this->primary} = :id", "id={$id}");
      }

      if (empty($this->data->$primary)) {
        $id = $this->create($this->safe());
      }

      if (!$id) {
        return false;
      }


      $this->data = $this->findById($id)->data();

      return true;
    } catch (PDOException $e) {
      $this->error = $e;
      return false;
    }
  }

  public function destroy(): bool
  {
    $primary = $this->primary;
    $id = $this->data->$primary;

    if (empty($id)) {
      return false;
    }

    return $this->delete("{$this->primary} = :id", "id={$id}");
  }

  public function required(): bool
  {
    $data = (array)$this->data();
    foreach ($this->required as $field) {
      if (empty($data[$field])) {
        if (!is_int($data[$field])) {
          return false;
        }
      }
    }
    return true;
  }

  public function safe(): array
  {
    $safe = (array)$this->data;

    unset($safe[$this->primary]);
    return $safe;
  }

  protected function toCamelCase($string) {
    $camelcase = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    $camelcase[0] = strtolower($camelcase[0]);
    return $camelcase;
  }

  private function setPrams(string &$params)
  {
    if (!empty($this->params)) {
      foreach($this->params as $key => $value) {
        $params .= "&{$key}={$value}";
      }
    }
  }
}