<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

alchemisteAccess();

$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);

$potions = $_POST["potions"];

foreach ($potions as $arr) {
    $idPotion = (int)$arr["id"];
    $quantity = (int)$arr["quantity"];

    
        ElementsPotions()->concocterPotion($idPotion, $joueur->getId(),$quantity);
    
}