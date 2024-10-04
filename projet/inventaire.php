<?php
include_once "DAL/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$title = "Inventaire";

$alias = $_SESSION["alias"];

$catalog = "";

foreach (Joueurs()->get($alias)->Inventaire()->toList() as $data) {
    $item = $data['item'];
    $photo = $item->getPhoto();
    $nom = $item->getNom();
    $quantite=$data['quantity'];
   
    $catalog .= <<< HTML
        <div class="catalog-card">
            <img class="catalog-card-img" src="./images/$photo">
            <span class="catalog-card-title">$nom</span>
            <div class="catalog-card-info">
              <span class="catalog-card-price">Quantité:</span>
              <span class="catalog-card-rating">$quantite</span>
            </div>
        </div>
    HTML;
}

$main = <<<HTML
 

  <div class="catalog">
    $catalog
    <div class="catalog-empty-card"></div>
    <div class="catalog-empty-card"></div>
    <div class="catalog-empty-card"></div>
  </div>
HTML;
include "views/master.php";