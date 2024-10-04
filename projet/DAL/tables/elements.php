<?php
include_once "DAL/table.php";
include_once "DAL/models/element.php";

class elements extends DynamicTable {

    public function add($element) {
        return $this->db->call("add_element",
        [
            "nom" => $element->getNom(),
            "stock" => $element->getStock(),
            "idType" => $element->TypeItem()->getId(),
            "prix" => $element->getPrix(),
            "photo" => $element->getPhoto(),
            "idTypeElement" => $element->TypeElement()->getId(),
            "rarete" => $element->getRarete(),
            "dangerosite" => $element->getDangerosite(),
        ]);
    }

    public function get($id) {
        $element = $this->db->selectWhere("elements", [["idItem", "=", $id]]);
        
        if (count($element) > 0) $element = $element[0];
        else return null;

        return $this->parseData($element);
    }

    public function update($element) {
        throw new Exception("Not implemented");
    }

    public function remove($element) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $elements = $this->db->selectAll("elements");
        
        foreach($elements as $element) {
            $list[] = $this->parseData($element);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $elements = $this->db->selectWhere("elements", $conditions);
        
        foreach($elements as $element) {
            $list[] = $this->parseData($element);
        }

        return $list;
    }

    private function parseData($data) {
        $item = Items()->get($data["idItem"]);
        return new Element(
            $item,
            TypesElements()->get($data["idType"]),
            $data["rarete"],
            $data["dangerosite"],
        );
    }
}