<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);
$panier = $joueur->Panier()->toList();
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

foreach ($panier as $data) { 
    $item = $data["item"];
    $joueur->Panier()->acheter($item->getId(),$data["quantity"]);
}

redirect("./accueil.php");