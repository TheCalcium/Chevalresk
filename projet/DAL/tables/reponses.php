<?php
include_once "DAL/table.php";
include_once "DAL/models/reponse.php";

class Reponses extends Table {

    public function get($id) {
        $type = $this->db->selectWhere("Reponses", [["id", "=", $id]]);
        
        if (count($type) > 0) $type = $type[0];
        else return null;
        
        return $this->parseData($type);
    }

    public function toList() {
        $list = [];
        $types = $this->db->selectAll("reponses");
        
        foreach($types as $type) {
            $list[] = $this->parseData($type);
        }

        return $list;
    }
    public function toListQuestion($id){
        $list= $this->where([["idQuestion", "=", $id]]);
        return $list;
    }

    public function where($conditions) {
        $list = [];
        $reponses = $this->db->selectWhere("reponses", $conditions);
        
        foreach($reponses as $reponse) {
            $list[] = $this->parseData($reponse);
        }
        return $list;
    }

    private function parseData($data) {
        return new Reponse (
            $data["id"],
            $data["idQuestion"],
            $data["texte"],
            $data['isTrue']
        );
    }
}