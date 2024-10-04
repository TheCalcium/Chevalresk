<?php
include_once "DAL/table.php";
include_once "DAL/models/arme.php";

class Armes extends DynamicTable {

    public function add($arme) {
        return $this->db->call("add_arme",
        [
            "nom" => $arme->getNom(),
            "stock" => $arme->getStock(),
            "idType" => $arme->TypeItem()->getId(),
            "prix" => $arme->getPrix(),
            "photo" => $arme->getPhoto(),
            "efficacite" => $arme->getEfficacite(),
            "genre" => $arme->Genre()->getNom(),
            "description" => $arme->getDescription(),
        ]);
    }

    public function get($id) {
        $arme = $this->db->selectWhere("armes", [["idItem", "=", $id]]);
        
        if (count($arme) > 0) $arme = $arme[0];
        else return null;

        return $this->parseData($arme);
    }

    public function update($arme) {
        throw new Exception("Not implemented");
    }

    public function remove($arme) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $armes = $this->db->selectAll("armes");
        
        foreach($armes as $arme) {
            $list[] = $this->parseData($arme);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $armes = $this->db->selectWhere("armes", $conditions);
        
        foreach($armes as $arme) {
            $list[] = $this->parseData($arme);
        }

        return $list;
    }

    private function parseData($data) {
        $item = Items()->get($data["idItem"]);
        return new Arme(
            $item,
            $data["efficacite"],
            Genres()->get($data["idGenre"]),
            $data["description"],
        );
    }
}