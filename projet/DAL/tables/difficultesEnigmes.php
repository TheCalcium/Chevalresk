<?php
include_once "DAL/table.php";
include_once "DAL/models/difficulteEnigme.php";

class DifficultesEnimges extends Table{

    public function get($id) {
        $difficulte = $this->db->selectWhere("DifficultesEnigmes", [["id", "=", $id]]);
        
        if (count($difficulte) > 0) $element = $difficulte[0];
        else return null;

        return $this->parseData($element);
    }
    public function toList() {
        $list = [];
        $types = $this->db->selectAll("difficultesEnigmes");
        
        foreach($types as $type) {
            $list[] = $this->parseData($type);
        }

        return $list;
    }

    private function parseData($data) {
        return new DifficulteEnigme (
            $data["id"],
            $data["difficulte"],
            $data["points"]
        );
    }


}