<?php
include_once "DAL/DB.php";
include_once "php/sessionManager.php";
include_once "php/formUtilities.php";

$header_title = "Chevaleresk";
$hidden_profile = "hidden";
$hidden_admin = "hidden";
$alias = "";
$solde = "";
$niveau = "";
$menu_admin = "";

$admin_links = [
    "Items" => "#",
    "Joueurs" => "#",
    "Demandes" => "#",

];

$connect_btn = <<< HTML
    <a class="btn disconnect-btn select-none" href="./loginForm.php" >S'identifier</a>
HTML;

if (isset($_SESSION["alias"])) {
    $alias = $_SESSION["alias"];
    $joueur = Joueurs()->get($alias);
    $solde = $joueur->getSolde();
    $niveau = $joueur->Niveau()->getNom();
    $hidden_profile = "";

    $connect_btn = <<< HTML
        <a class="btn disconnect-btn select-none" href="./logout.php" >Se déconnecter</a>
    HTML;

    $links = [
        "Accueil" => "./accueil.php",
        "Catalogue" => "./catalogue.php",
        "Inventaire" => "./inventaire.php",
        "Profil" => "./profil.php",
        "Demandes" => "#",
        "Quêtes" => "./quetesForm.php",
       
        
    ];

    if ($joueur->getEstAlchimiste()) {
        $links = [
            "Accueil" => "./accueil.php",
            "Catalogue" => "./catalogue.php",
            "Inventaire" => "./inventaire.php",
            "Profil" => "./profil.php",
            "Demandes" => "#",
            "Quêtes" => "./quetesForm.php",
            "Concocter" => "./concocter",
           
        ];
    }

    if ($joueur->getEstAdmin()) {

        $menu_admin_links = "";
    
        foreach ($admin_links as $key => $val) 
            $menu_admin_links .= "<a class='menu-item select-none' href='$val'>$key</a>";
    
        $menu_admin = <<< HTML
            <span id="menu-admin-btn" class="menu-item select-none">
                Panneau Admin
                <ion-icon id="menu-admin-btn-arrow" name="chevron-forward-outline"></ion-icon> 
            </span>
    
            <div class="menu-admin hidden">
                $menu_admin_links
            </div>
        HTML;
    }
}
else{
    $links = [
        "Accueil" => "./accueil.php",
        "Catalogue" => "./catalogue.php",
    ];
}

$menu_links = "";
foreach ($links as $key => $val) {
    $menu_links .= "<a class='menu-item select-none' href='$val'>$key</a>";
}

$header = <<< HTML
    <div id="navbar" class="navbar"> 
        <div class="navbar-left">
            <div id="menu-btn">
                <div id="burger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            
            <a id="header-title" class="select-none" href="./accueil.php">
                $header_title
            </a>
        </div>

        <div class="navbar-right">
            <a id="cart-btn" href="./panier.php">
                <ion-icon name="cart"></ion-icon>
                <span class="select-none">
                    Panier
                </span>
            </a>
        </div>
    </div>

    <div class="menu">
        <div class="menu-top">
            <div class="menu-profile $hidden_profile">
                <a href="profil.php" >
                <ion-icon class="menu-profile-img" name="person"></ion-icon></a>

                <div class="menu-profile-info">
                    <b>$alias</b>
                    <span>$solde$</span>
                </div>

                <div class="menu-profile-info">
                    <b>Niveau</b>
                    <span>$niveau</span>
                </div>
            </div>

            <div class="menu-links">
                $menu_links
                $menu_admin
            </div>
        </div>
        
        <div class="menu-bottom">
            $connect_btn
        </div>
    </div>
HTML;