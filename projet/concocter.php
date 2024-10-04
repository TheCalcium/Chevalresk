<?php
include_once "DAL/DB.php";
include_once "PHP/sessionManager.php";

alchemisteAccess();

$title = "Concoteur de potions";

$alias = $_SESSION["alias"];
$_SESSION["Concoction"] = [];

$potionsElements = [
    Potions()->toList()[0]->getId() => [Elements()->toList()[1], Elements()->toList()[5]],
    Potions()->toList()[1]->getId() => [Elements()->toList()[2], Elements()->toList()[6]],
    Potions()->toList()[2]->getId() => [Elements()->toList()[3], Elements()->toList()[7]],
    Potions()->toList()[3]->getId() => [Elements()->toList()[4], Elements()->toList()[8]],
    Potions()->toList()[4]->getId() => [Elements()->toList()[5], Elements()->toList()[9]],
    Potions()->toList()[5]->getId() => [Elements()->toList()[6], Elements()->toList()[10]],
    Potions()->toList()[6]->getId() => [Elements()->toList()[1], Elements()->toList()[11]],
    Potions()->toList()[7]->getId() => [Elements()->toList()[4], Elements()->toList()[12]],
    Potions()->toList()[8]->getId() => [Elements()->toList()[7], Elements()->toList()[13]],
    Potions()->toList()[9]->getId() => [Elements()->toList()[8], Elements()->toList()[14]],
];

$potionsElements = ElementsPotions()->toList();

$recettes = "";
$count = 0;
foreach ($potionsElements as $idPotion => $elems) {

    $materiauxInsufisant = false;

    $imgElems = "";
    for ($i = 0; $i < count($elems); $i++) {
        $materiauxInsufisant = $materiauxInsufisant || Joueurs()->get($alias)->Inventaire()->get($elems[$i]->getId()) == null;
        
        // icon +
        if ($i > 0 && $i < count($elems)) {
            $imgElems .= <<< HTML
                            <i class="fa-solid fa-plus recette-icon"></i>
            HTML;
        }

        // img
        $idElem = $elems[$i]->getId();
        $nomElem = $elems[$i]->getNom();
        $photoElem = $elems[$i]->getPhoto();
        $imgElems .= <<< HTML
            <img class="recette-img elem-img-$idPotion select-none" idElement="$idElem" alt="$nomElem" title="$nomElem" src="./images/$photoElem">
        HTML;
    }

    $recette_modify = <<< HTML
        <div class='recette-modify'>
          <i class="fa-solid fa-plus recette-btn recette-btn-add" idPotion='$idPotion'></i>
           
            <div class='recette-quantity' id='recette-quantity-$idPotion' contentEditable='true' idPotion='$idPotion'>0</div>
            <i class="fa-solid fa-minus recette-btn recette-btn-remove" idPotion='$idPotion'></i>
        </div>
    HTML;

    if ($materiauxInsufisant) {
        $recette_modify = <<< HTML
            <div class="recette-modify">
                <span class="error">Matériaux insufisants</span>
            </div>
        HTML;
    }

    $potion = Potions()->get($idPotion);
    $nomPotion = $potion->getNom();
    $photoPotion = $potion->getPhoto();
    if ($count > 0) $recettes.= "<hr>";
    $recettes .= <<< HTML
        <div class="recette">
            <div class="recette-info">
                $imgElems
                <i class="fa-solid fa-arrow-right  recette-icon"></i>
                <img class="recette-img potion-img-$idPotion select-none" alt="$nomPotion" title="$nomPotion" src="./images/$photoPotion">
            </div>
            $recette_modify
        </div>
    HTML;
    
    $count++;
}

$main = <<< HTML
    <span id="error-concocter" class="error"></span>
    <div class="concoteur-container">
        <div class="potions-container">
            <div class="potions-list container">
                <span class="potions-title">Recettes</span>
                <div class="potions-list-content">
                    $recettes
                </div>
            </div>
            <div class="potions-cart container">
                <span class="potions-title">Ingrédients</span>
                <div class="potions-cart-elements"></div>
                <hr>
                <span class="potions-title">Résultat</span>
                <div class="potions-cart-potions"></div>
            </div>
        </div>    
        <button id="btn-confirmation" class="btn potions-btn select-none">Concocter</button>
    </div>
HTML;

$otherScript = <<< HTML
  <script src="js/concocter.js"></script>
HTML;

include "views/master.php";