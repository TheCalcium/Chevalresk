<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$title = "Confirmation du retrait";

$idItem = null;
if (isset($_GET["idItem"])) {
    $idItem = $_GET["idItem"];
}
else {
    redirect("catalogue.php");
}

$idJoueur = null;
if (isset($_GET["idJoueur"])) {
    $idJoueur = $_GET["idJoueur"];
}
else {
    redirect("./detailsItem.php?id=$idItem");
}


$main = <<<HTML
    <div class="confirmation-layout">
        <div class="confirmation-content">
            <div>
                <p class="panier-item-info-title" style="text-align:center;">Voulez-vous retirer l'évaluation ?</p>
            </div>

            <div class="confirmation-btn-layout">
                <a href="./detailsItem.php?idItem=$idItem&idJoueur=$idJoueur" class="confirmation-btn btn"><span class="panier-item-info-title" style="color:white;">Annuler</span></a>
                <a href="./evaluationController.php?idItem=$idItem&idJoueur=$idJoueur&action=remove" class="confirmation-btn confirmation-btn-red btn"><span class="panier-item-info-title" style="color:white;">Retirer</span></a>
            </div>
        </div>
    </div>
HTML;

include_once "views/master.php";
