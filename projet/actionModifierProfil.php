<?php
include_once "DAL/DB.php";
include "PHP/sessionManager.php";
//coder une protection

if (isset($_POST['action'])) {
    if ($_POST['action'] == "verifPw") {
        $alias = $_SESSION["alias"];
        $pw = $_POST["pw"];
        $result = Joueurs()->verifyPassword(Joueurs()->get($alias)->getId(), $pw);

        if ($result == true) {
            echo 1;
        }
        if ($result == False) {
            echo 0;
        }
    }

    if ($_POST['action'] == "verifEmail") {
        $alias = $_SESSION["alias"];
        $email = $_POST["email"];
        $joueur=Joueurs()->getByEmail($email);
        
        
        if ($joueur == null) {
            echo 1;
        }else{
            if($joueur->getAlias()== $alias){
                echo 1;
            }else{
                echo 0;
            }
            
        }
    }
} else {

    $alias = $_SESSION["alias"];
    $joueur = Joueurs()->get($alias);

    $nom = $joueur->getNom();
    $prenom = $joueur->getPrenom();
    $email = $joueur->getEmail();

    if (isset($_POST["nom"])) {
        $nom = $_POST["nom"];
    }
    if (isset($_POST["prenom"])) {
        $prenom = $_POST["prenom"];
    }
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
    }

    $motDePasse = null;
    if (isset($_POST["mdp"])) {
        $motDePasse = $_POST["mdp"];
    }

    Joueurs()->updateJoueur($joueur->getId(), $nom, $prenom, $email);

    if ($motDePasse != null) {
        Joueurs()->updatePassword($joueur->getId(),$motDePasse);

    }

  redirect("profil.php");
}

