<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$title = "Confirmation d'achat";

$alias = $_SESSION["alias"];
$panier = Joueurs()->get($alias)->Panier()->toList();
$joueur = Joueurs()->get($alias);
$solde = $joueur->getSolde();
$total = 0;
$idJoueur = $joueur->getId();

if (count($panier) < 1) {
    redirect("./panier");
}

foreach ($panier as $data) {
    $item = $data["item"];
    $prix = $item->getPrix();
    $quantite = $data["quantity"];
    $prixTotal = $prix * $quantite;
    $total += $prixTotal;
    $nom = $item->getNom();
    $error = null;

    if ($total > $solde) {
        $error = "Solde insufisant.";
    }

    if ($item->getStock() < $quantite) {
        $error = "Quantité en stock de l'item: <ins>$nom</ins> est inférieure à celle dans le panier.";
    }

    if($item->TypeItem()->getId() == 2 && !$joueur->getEstAlchimiste()){
        $error = "Vous n'êtes pas alchimiste et l'item: <ins>$nom</ins> est un item pour les alchimistes.";
    }

    if ($error != null) {
        redirect("./panier?error=$error");
    }
}


$soldeFinal = $solde - $total;
$main = <<<HTML
    <div class="confirmation-layout">
        <div class="confirmation-content">
            <div>
                <div class="confirmation-total">
                    <p class="panier-item-info-title">Prix Total:</p>
                    <p class="panier-item-info-title">$total $</p>
                </div>
                <div class="confirmation-total">
                    <p class="panier-item-info-title">Votre solde après:</p>
                    <p class="panier-item-info-title">$soldeFinal $</p>
                </div>
            </div>

            <div class="confirmation-btn-layout">
                <a href="./panierAcheter.php" class="confirmation-btn btn"><span class="panier-item-info-title" style="color:white;">Acheter</span></a>
                <a href="./panier.php" class="confirmation-btn confirmation-btn-red btn"><span class="panier-item-info-title" style="color:white;">Annuler</span></a>
            </div>
        </div>

        <div class="confirmation-error" >
           <b id='error'></b>
        </div>
    </div>
HTML;

include_once "views/master.php";
