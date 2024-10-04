<?php
abstract class Table {

  protected $db;

  function __construct($db) {
    $this->db = $db;
  }

  abstract public function get($id);
  abstract public function toList();
}

abstract class DynamicTable extends Table {

  abstract public function add($obj);
  abstract public function update($obj);
  abstract public function remove($obj);
}