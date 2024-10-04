<?php
include_once "DAl/table.php";
include_once "DAL/models/evaluation.php";

class Evaluations extends DynamicTable{

    private $idJoueur;

    function __construct($db) {
        parent::__construct($db);
    }

    public function get($idItem) {

        $list = [];
        $records = $this->db->selectWhere("evaluations", [
            ["idItem", "=", $idItem]
        ]);
        
        foreach($records as $record) {
            $list[] = $this->parseData($record);
        }

        return $list;
    }

    public function add($evaluation) {
        return $this->db->call("add_evaluation",
        [
            "idItem" => $evaluation->getItem()->getId(),
            "idJoueur" => $evaluation->getJoueur()->getId(),
            "commentaire" => $evaluation->getCommentaire(),
            "note" => $evaluation->getNote()
        ]);
    }

    public function update($evaluation) {
        return $this->db->call("update_evaluation",
        [
            "idItem" => $evaluation->getItem()->getId(),
            "idJoueur" => $evaluation->getJoueur()->getId(),
            "commentaire" => $evaluation->getCommentaire(),
            "note" => $evaluation->getNote()
        ]);
    }

    public function remove($evaluation) {
        return $this->db->call("remove_evaluation",
        [
            "idItem" => $evaluation->getItem()->getId(),
            "idJoueur" => $evaluation->getJoueur()->getId()
        ]);
    }

    public function toList() {
        $list = [];
        $records = $this->db->selectAll("items");
        
        foreach($records as $record) {
            $list[] = $this->parseData($record);
        }

        return $list;
    }

    public function Where($conditions) {
        $list = [];
        $records = $this->db->selectWhere("evaluations", $conditions);
        
        foreach($records as $record) {
            $list[] = $this->parseData($record);
        }

        return $list;
    }

    private function parseData($data) {
        return new Evaluation(
            Items()->Get($data['idItem']),
            Joueurs()->getById($data['idJoueur']),
            $data['commentaire'], 
            $data['note']
        );
    }
}