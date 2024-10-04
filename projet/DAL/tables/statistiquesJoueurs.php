<?php
include_once "DAL/table.php";
include_once "DAL/models/statJoueur.php";

class StatistiquesJoueurs extends DynamicTable {

    protected $tableName = "StatistiqueJoueur";

    public function add($statJoueur) {
        return $this->db->call("add_statistique", [
            "dateCreation" => $statJoueur->getDateCreation(),
            "nbAchats" => $statJoueur->getNbAchats(),
            "itemsInventaire" => $statJoueur->getItemsInventaire(),
            "nbConcoctions" => $statJoueur->getNbConcoctions(),
            "progressionEnigmes" => $statJoueur->getProgressionEnigmes(),
            "nbEvaluations" => $statJoueur->getNbEvaluations(),
            "totalEcusDepense" => $statJoueur->getTotalEcusDepense()
        ]);
    }

    public function get($idJoueur) {
        $statistique = $this->db->selectWhere($this->tableName, [["idJoueur", "=", $idJoueur]]);
        
        if (count($statistique) > 0) $statistique = $statistique[0];
        else return null;
        
        return $this->parseData($statistique);
    }

    public function update($statJoueur) {
        throw new Exception("Not implemented");
    }

    public function remove($idJoueur) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $stats = $this->db->selectAll($this->tableName);
        
        foreach($stats as $stat) {
            $list[] = $this->parseData($stat);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $stats = $this->db->selectWhere($this->tableName, $conditions);
        
        foreach($stats as $stat) {
            $list[] = $this->parseData($stat);
        }

        return $list;
    }

    private function parseData($data) {
        return new statJoueur(
            $data['dateCreation'],
            $data['nbAchats'],
            $data['itemsInventaire'],
            $data['nbConcoctions'],
            $data['progressionEnigmes'],
            $data['nbEvaluations'],
            $data['totalEcusDepense']
        );
    }
}
?>