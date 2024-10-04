<?php
include_once "DAL/table.php";
include_once "DAL/models/item.php";

class Panier extends DynamicTable {

    private $idJoueur;

    function __construct($db, $idJoueur) {
        parent::__construct($db);
        $this->idJoueur = $idJoueur;
    }

    public function add($idItem) {
        return $this->db->call("add_panier",
        [
            "idJoueur" => $this->idJoueur,
            "idItem" => $idItem
        ]);
    }

    public function get($idItem) {
        $record = $this->db->selectWhere("panier", [
            ["idItem", "=", $idItem], 
            ["idJoueur", "=", $this->idJoueur]
        ]);

        if (count($record) > 0) $record = $record[0];
        else return null;
        
        return $record["quantite"];
    }

    public function update($idItem, $quantity = null) {
        return $this->db->call("update_panier",
        [
            "idJoueur" => $this->idJoueur,
            "idItem" => $idItem,
            "quantity" => $quantity
        ]);
    }

    public function remove($idItem) {
        return $this->db->call("remove_panier",
        [
            "idJoueur" => $this->idJoueur,
            "idItem" => $idItem
        ]);
    }

    public function acheter($idItem, $quantite) {
        return $this->db->call("acheter_panier",
        [
            "idJoueur" => $this->idJoueur,
            "idItem" => $idItem,
            "quantite"=> $quantite
        ]);
    }

    public function toList() {
        $list = [];
        $records = $this->db->selectWhere("panier", [["idJoueur", "=", $this->idJoueur]]);
        
        foreach($records as $record) {
            $item = Items()->get($record["idItem"]);
            $list[] = ["item" => $item, "quantity" => $record["quantite"]];
        }

        return $list;
    }
}