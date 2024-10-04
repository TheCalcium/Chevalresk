<?php
include "DAL/DB.php";
include_once 'php/sessionManager.php';

$title = "Accueil";

$connect_btn_accueil = <<< HTML
  <a class="btn accueil-btn select-none" href="./inscription">S'inscrire</a>
HTML;

if (isset($_SESSION["alias"])) {
  $connect_btn_accueil = <<< HTML
    <a class="btn accueil-btn select-none" href="./catalogue">Voir le catalogue</a>
  HTML;
}

$main = <<<HTML
  <div class="container">
    <div class="accueil">
      <span class="accueil-title" style="width: fit-content; margin:auto;" >Plongez dans l’univers épique de Chevalresk, un RPG captivant où courage, stratégie et potions magiques se mêlent pour une aventure inoubliable !</span>
        $connect_btn_accueil
    </div>
  </div>
HTML;
include "views/master.php";