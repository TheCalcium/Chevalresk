<?php
include_once "DAL/table.php";
include_once "DAL/models/niveau.php";

class Niveaux extends Table {

    public function get($id) {
        $niveau = $this->db->selectWhere("niveauxjoueurs", [["id", "=", $id]]);
        
        if (count($niveau) > 0) $niveau = $niveau[0];
        else return null;
        
        return $this->parseData($niveau);
    }

    public function toList() {
        $list = [];
        $niveaux = $this->db->selectAll("typesitems");
        
        foreach($niveaux as $niveau) {
            $list[] = $this->parseData($niveau);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $niveaux = $this->db->selectWhere("typesitems", $conditions);
        
        foreach($niveaux as $niveau) {
            $list[] = $this->parseData($niveau);
        }

        return $list;
    }

    private function parseData($data) {
        return new Niveau (
            $data["id"],
            $data["niveau"]
        );
    }
}