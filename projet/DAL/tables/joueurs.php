<?php
include_once "DAL/table.php";
include_once "DAL/tables/panier.php";
include_once "DAL/tables/inventaire.php";
include_once "DAL/models/joueur.php";

class Joueurs extends DynamicTable {

    public function add($joueur, $mdp = null) {
        return $this->db->call("add_joueur", 
        [
            "alias" => $joueur->getAlias(),
            "nom" => $joueur->getNom(),
            "prenom" => $joueur->getPrenom(),
            "email" => $joueur->getEmail(),
            "mdp" => $mdp
        ]);
    }

    public function get($alias) {
        $joueur = $this->db->selectWhere("joueurs", [["alias", "=", $alias]]);
        
        if (count($joueur) > 0) $joueur = $joueur[0];
        else return null;
        
        return $this->parseData($joueur);
    }

    public function getById($id) {
        $joueur = $this->db->selectWhere("joueurs", [["id", "=", $id]]);
        
        if (count($joueur) > 0) $joueur = $joueur[0];
        else return null;
        
        return $this->parseData($joueur);
    }
    


    public function getByEmail($email) {
        $joueur = $this->db->selectWhere("joueurs", [["email", "=", strtolower($email)]]);
        
        if (count($joueur) > 0) $joueur = $joueur[0];
        else return null;
        
        return $this->parseData($joueur);
    }

    public function update($joueur) {
        throw new Exception("Not implemented");
    }

    public function remove($joueur) {
        throw new Exception("Not implemented");
    }

    public function toList() {
        $list = [];
        $joueurs = $this->db->selectAll("joueurs");
        
        foreach($joueurs as $joueur) {
            $list[] = $this->parseData($joueur);
        }

        return $list;
    }

    public function where($conditions) {
        $list = [];
        $joueurs = $this->db->selectWhere("joueurs", $conditions);
        
        foreach($joueurs as $joueur) {
            $list[] = $this->parseData($joueur);
        }

        return $list;
    }
    public function updateJoueur($idJoueur, $nom,$prenom,$email){

        $this->db->call("modify_joueur",
        [
            "idJoueur"=>$idJoueur,
            "nom"=>$nom,
            "prenom"=>$prenom,
            "email"=>$email
        ]);

    }
    public function updatePassword($idJoueur, $pw){

        $this->db->call("modify_password",
        [
            "idJoueur"=>$idJoueur,
            "motdepasse"=>$pw
        ]);

    }
    public function verifyPassword($idJoueur, $pw){
        $result= $this->db->call("verify_password",
        [
            "idJoueur"=>$idJoueur,
            "motdepasse"=>$pw
        ]);
        return (bool)$result[0][0];
    }


    public function verify($alias, $mdp) {
        $result = $this->db->call("verify_joueur", 
        [
            "alias" => $alias, 
            "mdp" => $mdp
        ]);

        return (bool)$result[0][0];
    }

    private function parseData($data) {
        return new Joueur(
            $data['alias'], 
            $data['nom'], 
            $data['prenom'], 
            $data['email'], 
            $data['solde'],
            Niveaux()->Get($data['idNiveau']), 
            $data['estAlchimiste'], 
            $data['estAdmin'], 
            new Panier($this->db, $data['id']),
            new Inventaire($this->db, $data['id']),  
            $data['id']
        );
    }
}