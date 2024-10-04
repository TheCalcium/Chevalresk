<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$title = "Panier";
$error = null;
if (isset($_GET["error"])) {
    $error = $_GET["error"];
}

$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);
$panier = $joueur->Panier()->toList();
$items = "";
$pay_content = "";
$total = 0;

$panier_vide = (count($panier) < 1) ? "" : "hidden";
$panier_plein = (count($panier) < 1) ? "hidden" : "";
$error_hidden = ($error == null) ? "hidden" : "";

foreach ($panier as $data) {
    $item = $data["item"];
    $id = $item->getId();
    $photo = $item->getPhoto();
    $prix = $item->getPrix();
    $nom = $item->getNom();
    $quantite = $data["quantity"];
    $prixTotal = $prix * $quantite;
    $total += $prixTotal;
    $type = $item->TypeItem()->getNom();
    $stock = $item->getStock();

    $items .= <<< HTML
        <div class='panier-item panier-item-$id'>
            <img class='panier-item-img' alt='$nom' src='./images/{$photo}'>
            <div class='panier-item-content'> 
                <div class='panier-item-info-layout'>
                    <div class='panier-item-info-title'>
                        <span>{$nom}</span>
                        <span class='panier-item-total-$id'>{$prixTotal}$</span>
                    </div>
                    <div class='panier-item-info-subtitle'>
                        <span>$type</span>
                        <span class='panier-item-prix-$id' >{$prix}$</span>
                    </div>
                </div>
                <div class='panier-item-quantity-info'>
                    <span class='panier-item-stock'>Stock: $stock</span>
                    <span class='panier-item-modify'>
                        <i class="fa-solid fa-plus panier-item-btn panier-item-btn-add" idItem='$id'></i>
                        <div contentEditable='true' id='panier-item-quantity-$id' class='panier-item-quantity' idItem='$id'>{$quantite}</div>
                        <i class="fa-solid fa-minus panier-item-btn panier-item-btn-sub" idItem='$id'></i>
                    </span>
                </div>
            </div>
        </div>
    HTML;

    $pay_content .= <<< HTML
        <div class="panier-item-info-subtitle pay-content-$id">
            <span>
                <span class="panier-item-info-quantity-$id">$quantite</span>x $nom
            </span>
            <span class="panier-item-info-total-$id">$prixTotal$</span>
        </div>
    HTML;
}

$main = <<<HTML
    <div class="panier">
        <div class="panier-layout">
            <div class="panier-list">
                <span class="$panier_vide panier-vide">Votre panier est vide.</span>
                <span class="panier-error $error_hidden">$error</span>
                $items
            </div>

            <div class="panier-layout-pay $panier_plein">
                <div class="panier-pay-content-layout">
                    $pay_content
                </div>
               
                <div class="panier-suivant-layout">
                    <div class="panier-pay-content-layout-row panier-item-info-title" style="float:rigtht" >
                            <span>Total:</span>
                            <span id="panier-total">$total$</span>
                    </div>
                    <br>
                    <a class="panier-acheter-btn btn" href="panierConfirmation.php" ><p style="margin:auto; font-family">Suivant</p> </a>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;

$otherScript= <<<HTML
    <script src="js/panier.js"></script>
HTML;

include "views/master.php";