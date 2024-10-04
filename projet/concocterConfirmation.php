<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

alchemisteAccess();

$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);

$potions = $_POST["potions"];
$elemCount = [];

var_dump($potions);

foreach ($potions as $arr) {
    $idPotion = (int)$arr["id"];
    $quantity = (int)$arr["quantity"];
    
    $potion = Potions()->get($idPotion);

    foreach (ElementsPotions()->get($idPotion) as $elemPotion) {
        $idElem = $elemPotion->getIdElement();
        $count = $joueur->Inventaire()->get($idElem);
        if ($count == null) {
            $nom = Elements()->get($idElem)->getNom();
            header('HTTP/1.1 500 Internal Server Booboo');
            die("°Vous n'avez pas de {$nom}");
        }

        if (array_key_exists($idElem, $elemCount)) {
            $elemCount[$idElem] += $quantity;
        }
        else {
            $elemCount[$idElem] = $quantity;
        }
    }
}

foreach ($elemCount as $id => $count) {
    $nom = Elements()->get($id)->getNom();
    $countInv = $joueur->Inventaire()->get($id);
    $diff = $count - $countInv;

    if ($countInv < $count) {
        header('HTTP/1.1 500 Internal Server Booboo');
        die("°Il vous manque $diff {$nom}");
    }
}