<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';

userAccess();

$action = null;
$item = null;
$joueur = null;

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    redirect("./catalogue.php");
}

if (isset($_GET["idItem"])) {
    $item = Items()->get($_GET["idItem"]);
}
else {
    redirect("./catalogue.php");
}

if ($item != null) {
    $idItem = $item->getId();

    $search = Joueurs()->where([['id', '=', $_GET["idJoueur"]]]);
    if (count($search) > 0) 
        $joueur = $search[0];
    else {
        redirect("./detailsItem?idItem=$idItem");
    }
}
else {
    redirect("./catalogue.php");
}

$idJoueur = $joueur->getId();
$evalText = "";
$note = 0;
$nom = $item->getNom();
$title = "Évaluer: $nom";

switch ($action) {
    case "add":
        if ($joueur->Inventaire()->get($idItem) == null) {
            redirect("./detailsItem?idItem=$idItem");
        }
        break;
    case "edit":
            $eval = Evaluations()->Where([['idItem', '=', $idItem], ['idJoueur', '=', $joueur->getId()]]);
            if (count($eval) < 1) {
                redirect("./detailsItem?idItem=$idItem");
            }

            $evalText = $eval[0]->getCommentaire();
            $note = $eval[0]->getNote();
        break;
    default:
        redirect("./detailsItem?idItem=$idItem");
        break;
}

$rates = "";
for ($i = 5; $i > 0; $i--) {
    if (floor($note) == $i) {
        $rates .= <<< HTML
            <input value="$i" name="note" id="star$i" type="radio" checked>
            <label title="text" for="star$i"></label>
        HTML;
    }
    else {
        $rates .= <<< HTML
            <input value="$i" name="note" id="star$i" type="radio">
            <label title="text" for="star$i"></label>
        HTML;
    }
}

$main = <<< HTML
    <div class="container">
        <form class="form-area" method="get" action="evaluationController.php">
            <input type="hidden" name="idItem" value="$idItem">
            <input type="hidden" name="idJoueur" value="$idJoueur">
            <input type="hidden" name="action" value="$action">
            <div class="centered-row semibold">
                <span class="large-text">Note:</span>
                <div class="rating">
                    $rates
                </div>
            </div>
            <br>
            <span class="sub-title large-text">Commentaire:</span>
            <textarea idItem="textarea" name="commentaire" class="textarea-vertical" maxlength="1000">$evalText</textarea>
            <span class="margin-left"><span idItem="char-count">0</span>/1000</span>
            <input type="submit" class="btn-nomargin" value="Envoyer"/>
        </form>
    </div>
HTML;

$otherScript = <<< HTML
    <script>
        $(document).ready(function () {
            $("textarea").keyup(function(){
                $("#char-count").text(this.value.length);
            });
            $("textarea").keydown(function(){
                $("#char-count").text(this.value.length);
            });
        });
    </script>
HTML;

include "views/master.php";