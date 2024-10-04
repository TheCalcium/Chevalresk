<?php
include_once "DAL/DB.php";
include "PHP/sessionManager.php";

userAccess();
$erreur="";
if(isset($_GET["erreur"])){
    $erreur=$_GET["erreur"];
}
$alias = $_SESSION["alias"];
$joueur=Joueurs()->get($alias);
$prenom=$joueur->getPrenom();
$nom=$joueur->getNom();
$mail=$joueur->getEmail();


$main = <<< HTML
<div class="container"> 
    <form class="form-area" method="post" action="actionModifierProfil.php">
        <div class="form-row"  >
            <fieldset class="form-group">
                <label class="sub-title" for="prenom">Prénom</label>
                <input type="text" required name="prenom" value=$prenom class="form-style" >

            </fieldset>
            <fieldset class="form-group">
                <label class="sub-title">Nom</label>
                <input type="text" value=$nom class="form-style" required name="nom">

            </fieldset>
           
        </div> 
        <div class="form-row">
            <fieldset class="form-group">
                <label class="sub-title">Adresse courriel</label>
                <input id="email" type="text" value=$mail class="form-style" required name="email">

            </fieldset>
           
        </div>
        <div class="form-bottom">
            <div style="Display:flex;align-items: center;">
                <span class="panier-item-info-title">Modifier mot de passe</span>
                <ion-icon id="modPw" style="font-size:1.75em; cursor:pointer; margin-top:0.1em;" name="chevron-forward-outline"></ion-icon>
                
            </div>
            

        </div>
        <div class="form-row" id="hiddenZone">
            <fieldset class="form-group">
                <label class="sub-title">Ancien mot de passe</label>
                <input id="oldmdp" type="password" class="form-style" >

            </fieldset>
           
        </div>
        <div class="form-row" id="hiddenZone">
            <fieldset class="form-group">
                <label class="sub-title">Mot de passe</label>
                <input id="mdp" type="password" class="form-style" name="mdp">

            </fieldset>
           
        </div>
        <div class="form-row" id="hiddenZone">
            <fieldset class="form-group">
                    <label class="sub-title">Confirmer mot de passe</label>
                    <input id="mdpConfirm" type="password" class="form-style">

            </fieldset>
           
        </div>
        <div class="form-bottom">  
            <input id="submitProfil" type="submit" class="btn">
            <span id="erreur" class="panier-error">$erreur</span>

        </div>
        
    </form>
</div>
HTML;

$otherScript= <<<HTML
    <script src="js/profil.js"></script>
HTML;


include "views/master.php";