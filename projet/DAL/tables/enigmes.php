<?php
include_once "DAL/table.php";
include_once "DAL/models/enigme.php";

class enigmes extends DynamicTable{
    public function add($enigme) {
        throw new Exception("Not implemented");
        // return $this->db->call("add_element",
        // [
        //     "idDifficulte" => $enigme->getDifficulte()->getId(),
        //     "idType" => $enigme->getTypeEnigme()->getId()
        // ]);
    }
    public function get($id) {
        $enigme = $this->db->selectWhere("enigmes", [["id", "=", $id]]);
        
        if (count($enigme) > 0) $enigme = $enigme[0];
        else return null;

        return $this->parseData($enigme);
    }
    public function remove($obj){
        throw new Exception("Not implemented");
    }
    public function update($obj){
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $items = $this->db->selectAll("enigmes");
        
        foreach($items as $item) {
            $list[] = $this->parseData($item);
        }

        return $list;
    }
    public function repondre_enigme($idJoueur,$idEnigme,$estReussi){
        $enigme= $this->db->call("repondre_enigme",
        [
            "idJoueur" => $idJoueur,
            "idEnigme" => $idEnigme,
            "estReussi" => $estReussi
        ]);
    }
    public function randomQuestion($idDifficulte,$idJoueur){
        $enigme= $this->db->call("random_enigme",
        [
            "idDifficulte" => $idDifficulte,
            "idJoueur" => $idJoueur
        ]);
        
        return $enigme[0][0];
    }
    public function randomQuestionAleatoire($idJoueur){
        $enigme= $this->db->call("random_enigmeAleatoire",
        [
            "idJoueur" => $idJoueur
        ]);
        
        return $enigme[0][0];
    }
    public function where($conditions) {
        $list = [];
        $items = $this->db->selectWhere("enigmes", $conditions);
        
        foreach($items as $item) {
            $list[] = $this->parseData($item);
        }

        return $list;
    }
    private function parseData($data) {
        return new Enigme(
            $data['id'],
            $data['question'],
            $data['idDifficulte'],
            DifficultesEnigmes()->get($data['idDifficulte'])->getPoints(),
            TypesEnigmes()->get($data['idType'])
        );
    }
    
}