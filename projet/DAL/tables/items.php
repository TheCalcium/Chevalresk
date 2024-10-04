<?php
include_once "DAL/table.php";
include_once "DAL/models/item.php";

class Items extends DynamicTable {

    public function add($item) {
        throw new Exception("Can't directly add to Items");
    }

    public function get($id) {
        $item = $this->db->selectWhere("items", [["id", "=", $id]]);
        
        if (count($item) > 0) $item = $item[0];
        else return null;
        
        return $this->parseData($item);
    }

    public function update($item) {
        throw new Exception("Not implemented");
    }

    public function remove($item) {
        throw new Exception("Can't directly remove to Items");
    }

    public function toList() {
        $list = [];
        $items = $this->db->selectAll("items");
        
        foreach($items as $item) {
            $list[] = $this->parseData($item);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $items = $this->db->selectWhere("items", $conditions);
        
        foreach($items as $item) {
            $list[] = $this->parseData($item);
        }

        return $list;
    }

    private function parseData($data) {
        $notes = [];
        $evals = $this->db->selectWhere("evaluations", [
            ["idItem", "=", $data['id']]
        ]);
        foreach ($evals as $eval) {
            $notes[] = $eval['note'];
        }
        if (count($notes) > 0)
            $note = round(array_sum($notes) / count($notes) * 2) / 2;
        else
            $note = 0;

        return new Item(
            $data['nom'], 
            $data['stock'], 
            TypesItems()->get($data['idType']),
            $data['prix'],
            $data['photo'], 
            $note,
            $data['id'],
        );
    }
}