<?php
include_once "DAL/table.php";
include_once "DAL/models/type.php";

class TypesElements extends Table {

    public function get($id) {
        $type = $this->db->selectWhere("typeselements", [["id", "=", $id]]);
        
        if (count($type) > 0) $type = $type[0];
        else return null;
        
        return $this->parseData($type);
    }

    public function toList() {
        $list = [];
        $types = $this->db->selectAll("typeselements");
        
        foreach($types as $type) {
            $list[] = $this->parseData($type);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $types = $this->db->selectWhere("typeselements", $conditions);
        
        foreach($types as $type) {
            $list[] = $this->parseData($type);
        }

        return $list;
    }

    private function parseData($data) {
        return new Type (
            $data["id"],
            $data["type"]
        );
    }
}