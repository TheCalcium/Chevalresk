<?php
include_once "DAL/table.php";
include_once "DAL/models/elemPotion.php";

Class ElementsPotions extends Table{

    public function get($idPotion) {
        $elemPotion = $this->db->selectWhere("elementPotion", [["idPotion", "=", $idPotion]]);
        
        if (count($elemPotion) <= 0)
            return null;

        $list=[];
        foreach($elemPotion as $elem){
            array_push($list,$this->parseData($elem));
        }
        return $list;
    }
    public function toList() {
        $list = [];
        $elementPotion = $this->db->selectAll("elementPotion");
        
        foreach($elementPotion as $elem) {
            $elemPot = $this->parseData($elem);

            if (!array_key_exists($elemPot->getIdPotion(), $list)) {
                $list[$elemPot->getIdPotion()] = [Elements()->get($elemPot->getIdElement())];
            }
            else {
                array_push($list[$elemPot->getIdPotion()], Elements()->get($elemPot->getIdElement()));
            }
        }

        return $list;
    }
    public function concocterPotion($idPotion, $idJoueur,$quantite)
    {
        $this->db->call(
            "concocter_potion",
            [
                "idPotion" => $idPotion,
                "idJoueur" => $idJoueur,
                "quantite" => $quantite
            ]
        );
    }
    private function parseData($data) {
        return new elemPotion(
            $data['idPotion'],
            $data['idElement']
        );
    }
}
