<?php
include_once "DAL/table.php";
include_once "DAL/models/armure.php";

class Armures extends DynamicTable {

    public function add($armure) {
        return $this->db->call("add_armure",
        [
            "nom" => $armure->getNom(),
            "stock" => $armure->getStock(),
            "idType" => $armure->TypeItem()->getId(),
            "prix" => $armure->getPrix(),
            "photo" => $armure->getPhoto(),
            "matiere" => $armure->getMatiere(),
            "idTaille" => $armure->Taille()->getId()
        ]);
    }

    public function get($id) {
        $armure = $this->db->selectWhere("armures", [["idItem", "=", $id]]);
        
        if (count($armure) > 0) $armure = $armure[0];
        else return null;

        return $this->parseData($armure);
    }

    public function update($armure) {
        throw new Exception("Not implemented");
    }

    public function remove($armure) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $armures = $this->db->selectAll("armures");
        
        foreach($armures as $armure) {
            $list[] = $this->parseData($armure);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $armures = $this->db->selectWhere("armures", $conditions);
        
        foreach($armures as $armure) {
            $list[] = $this->parseData($armure);
        }

        return $list;
    }

    private function parseData($data) {
        $item = Items()->get($data["idItem"]);
        return new Armure(
            $item,
            $data["matiere"],
            Tailles()->get($data["idTaille"]),
        );
    }
}