<?php
include_once "DAL/table.php";
include_once "DAL/models/potion.php";

class potions extends DynamicTable {

    public function add($potion) {
        return $this->db->call("add_potion",
        [
            "nom" => $potion->getNom(),
            "stock" => $potion->getStock(),
            "idType" => $potion->TypeItem()->getId(),
            "prix" => $potion->getPrix(),
            "photo" => $potion->getPhoto(),
            "effet" => $potion->getEffet(),
            "duree" => $potion->getDuree(),
            "idTypePotion" => $potion->TypePotion()->getId(),
        ]);
    }

    public function get($id) {
        $potion = $this->db->selectWhere("potions", [["idItem", "=", $id]]);
        
        if (count($potion) > 0) $potion = $potion[0];
        else return null;

        return $this->parseData($potion);
    }

    public function update($potion) {
        throw new Exception("Not implemented");
    }

    public function remove($potion) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $potions = $this->db->selectAll("potions");
        
        foreach($potions as $potion) {
            $list[] = $this->parseData($potion);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $potions = $this->db->selectWhere("potions", $conditions);
        
        foreach($potions as $potion) {
            $list[] = $this->parseData($potion);
        }

        return $list;
    }

    private function parseData($data) {
        $item = Items()->get($data["idItem"]);
        return new Potion(
            $item,
            $data["effet"],
            $data["duree"],
            TypesPotions()->get($data["idType"]),
        );
    }
}