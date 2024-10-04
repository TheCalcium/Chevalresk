<?php
include_once "DAL/DB.php";
include "PHP/sessionManager.php";

userAccess();
$title = "Votre profil";
$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);
$solde = $joueur->getSolde();
$niveau = $joueur->Niveau()->getNom();
$prenom = $joueur->getPrenom();
$nom = $joueur->getNom();
$courriel = $joueur->getEmail();
$role = "Joueur régulier";
if($joueur->getEstAlchimiste()){
    $role = "Alchimiste";
}
else if($joueur->getEstAdmin()){
    $role = "Administrateur";
}
else if($joueur->getEstAlchimiste() && $joueur->getEstAdmin()){
    $role = "Alchimiste / Administrateur";
}
$idJoueur = $joueur->getId();
$stats = StatistiquesJoueurs()->get($idJoueur);
$creationJoueur = $stats->getDateCreation(); #Compte créé (date)
$nbAchats = $stats->getNbAchats(); #Nombre d'achats
$nbItemInv = $stats->getItemsInventaire(); #Nombre d'item dans l'inventaire actuellement
$nbPotionsConc = $stats->getNbConcoctions(); #Nombre de potions concoctées
$progEnigmes = $stats->getProgressionEnigmes(); #"Facile: XX% | Moyenne: XX% | Difficile: XX% | Total: XX%" Progression des énigmes
$nbEval = $stats->getNbEvaluations(); #Nombre d'évalutions
$totalDepense = $stats->getTotalEcusDepense(); #Total dépensé
if(!$joueur->getEstAlchimiste()){
    $nbPotionsConc = "Non appliquable";
}
if($stats->getProgressionEnigmes() == null){
    $progEnigmes = "Aucune progression effectuée";
}

$main = <<<HTML
<div class="container">
    <div class="form-area">
        <div class="quetes-infos-titre">Informations de base</div>
        <br>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="alias">Alias</label>
                <span>$alias</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="solde">Solde</label>
                <span>$solde$</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="niveau">Niveau</label>
                <span>$niveau</span>
            </fieldset>
        </div>
        <hr>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="prenom">Prénom</label>
                <span>$prenom</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="nom">Nom</label>
                <span>$nom</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="role">Rôle</label>
                <span>$role</span>
            </fieldset>
        </div>
        <hr>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="email">Adresse courriel</label>
                <span>$courriel</span>
            </fieldset>
        </div>
        <a class="btn" href="./modifierProfil">Modifier le profil</a>
    </div>
</div>
<br>
<div class="container">
    <div class="form-area">
        <div class="quetes-infos-titre">Statistiques</div>
        <br>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="creationJoueur">Date d'inscription</label>
                <span>$creationJoueur</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="nbAchats">Achats effectués</label>
                <span>$nbAchats</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="totalDepense">Écus dépensés</label>
                <span>$totalDepense$</span>
            </fieldset>
        </div>
        <hr>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="nbItemInv">Objets dans l'inventaire</label>
                <span>$nbItemInv</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="nbPotionsConc">Potions concoctées</label>
                <span>$nbPotionsConc</span>
            </fieldset>
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="nbEval">Évaluations publiées</label>
                <span>$nbEval</span>
            </fieldset>
        </div>
        <hr>
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="profil-sub-title" for="progEnigmes">Progression des énigmes</label>
                <span>$progEnigmes</span>
            </fieldset>
        </div>
    </div>
</div>
HTML;



include "views/master.php";