<?php
include "DAL/DB.php";
include "php/formUtilities.php";

$title = "Catalogue";
$actionUrl = "catalogueFiltres.php";
$catalog  = "";
$typesIndex = array();
$trieIndex = 0;
$hidden_filtre = "hidden";
$search_content = "";
$items = Items()->toList();
$options = [
  0 => "Par type",
  1 => "Par nom",
  2 => "Par prix",
  3 => "Par note",
];

if (isset($_GET["types"])) {
  if ($_GET["types"] != null) {
    $typesIndex = explode(',', $_GET["types"]);
  }
}

if (isset($_GET["trie"])) {
  if ($_GET["trie"] != null) {
    $trieIndex = $_GET["trie"];
  }
}

if (isset($_GET["isopen"])) {
  if((bool) $_GET["isopen"]) {
    $hidden_filtre = "";
  }
}

if (isset($_GET["search"])) {
  if($_GET["search"] != null) {
    $search_content = $_GET["search"];
  }
}

// Filtre selon la recherche
$items = array_filter($items, function($item) use($search_content){ return str_contains(strtolower(no_Hyphens($item->getNom())), strtolower(no_Hyphens($search_content))); });

$filtre_types = "";
foreach(TypesItems()->toList() as $key => $type) {
  $id = $type->getId();
  $nom = $type->getNom()."s";

  if (in_array($type->getId(), $typesIndex)) {
    $hrefTypes = $typesIndex;
    unset($hrefTypes[array_search($id, $hrefTypes)]);
    
    $hrefTypes_str = implode("%2C", $hrefTypes);
    $types_str = (count($hrefTypes) > 0) ? "&types=$hrefTypes_str" : "";

    $href = "./catalogue.php?trie=$trieIndex$types_str&isopen=1";
    $filtre_types .= <<< HTML
      <a class='catalog-type select-none selected' href='$href'>$nom</a>
    HTML;
  }
  else {
    // Retire les items non selectionné si il y a des filtres
    if (count($typesIndex) > 0) {
      $items = array_filter($items, function($item) use($key){ return $item->TypeItem()->getId() != $key; });
    }

    $hrefTypes = $typesIndex;
    array_push($hrefTypes, $id);
    $hrefTypes = implode("%2C", $hrefTypes);

    $href = "./catalogue.php?trie=$trieIndex&types=$hrefTypes&isopen=1";
    $filtre_types .= <<< HTML
      <a class='catalog-type select-none' href='$href'>$nom</a>
    HTML;
  }
}

$select_options = "";
foreach($options as $key => $text) {

  if ($key == $trieIndex) {
    $select_options .= <<< HTML
      <option value="$key" selected>$text</option>
    HTML;
  }
  else {
    $select_options .= <<< HTML
      <option value="$key">$text</option>
    HTML;
  }
}

// Trie selon le mode choisi
switch ($trieIndex) {
  case 0:
    usort($items, function($item1, $item2) { return strcmp(no_Hyphens($item1->TypeItem()->getNom()), no_Hyphens($item2->TypeItem()->getNom())); });
    break;
    case 1:
    usort($items, function($item1, $item2) { return strcmp(no_Hyphens($item1->getNom()), no_Hyphens($item2->getNom())); });
    break;
  case 2:
    usort($items, function($item1, $item2) { return $item1->getPrix() - $item2->getPrix(); });
    break;
  case 3:
    usort($items, function($item1, $item2) { return $item2->getNote()*2 - $item1->getNote()*2; });
    break;
}

$catalog_count = count($items);


foreach($items as $item) {
    $photo = $item->getPhoto();
    $id = $item->getId();
    $nom = $item->getNom();
    $prix = $item->getPrix();
    $stock = $item->getStock();
    $type = $item->TypeItem()->getNom();
    $evaluations = Evaluations()->get($id);
    $nbevals =count($evaluations);
    $notes=[];
    $note=0;
    foreach ($evaluations as $evaluation){
      $notes[] = $evaluation->getNote();
    }
    if (count($notes) > 0){
      $note = round(array_sum($notes) / count($notes) * 2) / 2;
    }
    $etoiles_pleines = str_repeat("★", floor($note));
    $etoiles_moitiers = "";
    $etoiles_vides = str_repeat("☆", 5 - ceil($note));
    if (is_numeric($note) && floor($note) != $note){
      $etoiles_moitiers ="&#11242;";
    }
    
    $catalog .= <<< HTML
        <a class="catalog-card" href="detailsItem?id=$id">
          <img class="catalog-card-img" alt="$nom" src="./images/$photo">
          <span class="catalog-card-title">$nom</span>

          <div class="catalog-card-info">
            <span class="catalog-card-price">$prix écus</span>
            <span class="catalog-card-rating shapes" >$etoiles_pleines$etoiles_moitiers$etoiles_vides</span>
            
          </div>
          
          <div class="catalog-card-info">
              <span>$type</span>
              <span>$stock en stock</span>
              <span>($note etoiles)</span>
          </div>
        </a>
    HTML;
}


$main = <<< HTML
  <div class="catalog-header">
    <div class="catalog-header-top">
      <div class="catalog-input">
        <input class="form-style catalog-search" value="$search_content" type="text" placeholder="Recherche" id="catalog-search">
        <span class="catalog-count"> $catalog_count résultats</span>
      </div>
      <button class="btn btn-filtres select-none">Filtres</button>
    </div>

    <div class="catalog-header-bottom $hidden_filtre">
      <hr>
      <div class="catalog-filtres-container">
        <div class="catalog-select-container">
          <label for="trie">Trie:</label>
          <select class="catalog-select" name="trie" id="trie">
            $select_options
          </select>
        </div>
        <div class="catalog-types-container">
          $filtre_types
        </div>
      </div>
    </div>
  </div>
  <div class="catalog">
    $catalog
    <div class="catalog-empty-card"></div>
    <div class="catalog-empty-card"></div>
    <div class="catalog-empty-card"></div>
  </div>
HTML;

$otherScript = <<< HTML
  <script src="js/catalogue.js"></script>
HTML;

include "views/master.php";