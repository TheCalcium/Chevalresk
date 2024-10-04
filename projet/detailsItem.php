<?php
include_once "DAL/DB.php";
include "php/formUtilities.php";
include_once 'php/sessionManager.php';

$title = "Détails";

$joueur = null;
if (isset($_SESSION["alias"])) {
    $alias = $_SESSION["alias"];
    $joueur = Joueurs()->get($alias);
}

if (isset($_GET["id"])) {
    if ($_GET["id"] == null) {
        redirect("catalogue.php");
    }

    $id = $_GET["id"];
    $item = Items()->get($id);

    if ($item == null) {
        redirect("catalogue.php");
    }
} else {
    redirect("catalogue.php");
}

$nom = $item->getNom();
$stock = $item->getStock();
$typeId = $item->TypeItem()->getId();
$typeItem = $item->TypeItem()->getNom();
$prix = $item->getPrix();
$photo = $item->getPhoto();
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
$noteEtoiler = "($note)";
$noteEtoiler .= str_repeat("★", floor($note));
if(is_numeric($note) && floor($note) != $note){
    $noteEtoiler .= "&#11242;";
}
$noteEtoiler .= str_repeat("☆", 5 - ceil($note));
$noteEtoiler .= " $nbevals évaluations";

$infos = [
    "Note" => $noteEtoiler,
    "Quantité en stock" => $stock,
    "Type de l'item" => $typeItem,
];

switch ($typeId) {
    case 0:
        $item = Armes()->get($id);
        $efficacite = $item->getEfficacite();
        $genre = $item->Genre()->getNom();
        $description = $item->getDescription();

        $infos["Efficacité"] = $efficacite;
        $infos["Genre"] = $genre;
        $infos["Description"] = $description;
        break;
    case 1:
        $item = Armures()->get($id);
        $matiere = $item->getMatiere();
        $taille = $item->Taille()->getNom();

        $infos["Matière"] = $matiere;
        $infos["Taille"] = $taille;
        break;
    case 2:
        $item = Elements()->get($id);
        $typeElement = $item->TypeElement()->getNom();
        $rarete = $item->getRarete();
        $dangerosite = $item->getDangerosite();

        $infos["Type d'élément"] = $typeElement;
        $infos["Rareté"] = $rarete;
        $infos["Dangerosité"] = $dangerosite;
        break;
    case 3:
        $item = Potions()->get($id);
        $effet = $item->getEffet();
        $duree = $item->getDuree();
        $typePotion = $item->TypePotion()->getNom();

        $infos["Type de potion"] = $typePotion;
        $infos["Durée"] = $duree;
        $infos["Effet"] = $effet;
        break;
}



$infoHtml = "";
foreach ($infos as $key => $val) {
    $infoHtml .= <<<HTML
    <span class="details-info-row">
        <span class="details-info-title">
            $key:
        </span>
        <span class="details-info-data shapes">
            $val
        </span>
    </span>
    HTML;
}

$idJoueur = $joueur->getId();
$evalBtn = '';
$dansInventaire = ($joueur->Inventaire()->get($id) != null);
$estPasEvaluer = (Evaluations()->Where([['idItem', '=', $id], ['idJoueur', '=', $joueur->getId()]]) == null);
if ($dansInventaire != null && $estPasEvaluer) {
    $evalBtn = "<a href='./evaluationForm.php?idJoueur=$idJoueur&idItem=$id&action=add' class='btn select-none'>Écrire une évaluation</a>";
}

$evalsJoueurs = "";
foreach ($evaluations as $eval){
    $nomjoueur = $eval->getJoueur()->getAlias();
    $idJoueurEval = $eval->getJoueur()->getId();
    $commentaire = $eval->getCommentaire();
    $note = $eval->getNote();
    $note = (int)$note;
    $noteEtoiler = "($note) ";
    $noteEtoiler .= str_repeat("★", $note);
    $noteEtoiler .= str_repeat("☆", 5 - ceil($note));
    $edit = "";
    if ($nomjoueur == $_SESSION["alias"] || Joueurs()->get($_SESSION["alias"])->getEstAdmin()) {
        $edit.= <<< HTML
            <div>
                <a href="./evaluationForm.php?idJoueur=$idJoueurEval&idItem=$id&action=edit" title="Modifier">
                    <i class="icon fa-solid fa-pen-to-square"></i>
                </a>
                <a href="./evaluationConfirmation.php?idJoueur=$idJoueurEval&idItem=$id" title="Retirer">
                    <i class="icon fa-solid fa-trash"></i>
                </a>
            </div>
        HTML;
    }
    
    $evalsJoueurs .= <<<HTML
        <div class="details-item-container">
            <div class="details-info-container">
                <div class="flex-row">
                    <div class="catalog-card-title">
                        <span>$nomjoueur</span>
                    </div>
                    $edit
                </div>
                <span > $noteEtoiler</span>
                <hr>
                <div class="details-info">
                   $commentaire
                </div>
            </div>
        </div>
    HTML;
}

$main = <<<HTML
    <div class="details-container">
        <div class="details-item-container">
            <img class="details-img" src="./images/$photo">
            <div class="details-info-container">
                <div class="details-title">
                    <span>$nom</span>
                    <span>$prix$</span>
                </div>
                <hr>
                <div class="details-info">
                    $infoHtml
                </div>
                <div class="details-btn-container select-none">
                    <span id="addPanierBtn" class="btn details-panier-btn">Ajouter au panier</span>
                </div>
            </div>
        </div>
    </div>
    <div class="evaluation-header details-item-lenght">
        <h2>Évaluations</h2>
        $evalBtn
    </div>
    <hr class="details-item-lenght">
    <div class="scroll-list">
        $evalsJoueurs
    </div>
    <div> 
HTML;

if ($joueur != null) {
    $addPanierScript = <<<JAVASCRIPT
        let btn = document.querySelector("#addPanierBtn");
        btn.addEventListener("click", () => {
            $.ajax({
                url: 'panierAdd.php',
                method: 'POST',
                data: {
                    id: $id
                }
            });
        });
    JAVASCRIPT;
} else {
    $addPanierScript = <<<JAVASCRIPT
        let btn = document.querySelector("#addPanierBtn");
        btn.addEventListener("click", () => {
            location.href = "./loginForm.php";
        });
    JAVASCRIPT;
}

$otherScript = <<<HTML
    <script>
        $(document).ready(function () {
            $addPanierScript
        });
    </script>
HTML;

include "views/master.php";