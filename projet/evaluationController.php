<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$eval = null;
$error = null;

$joueur = null;
$item = null;
$commentaire = "";
$note = 0;
$action = null;

if (isset($_GET["idJoueur"])) {
    $search = Joueurs()->where([['id', '=', $_GET["idJoueur"]]]);
    
    if (count($search) > 0) 
        $joueur = $search[0];
    else 
        $joueur = null;
}
else {
    $error = "L'item n'existe pas";
}

if (isset($_GET["idItem"])) {
    $item = Items()->get($_GET["idItem"]);
}
else {
    $error = "L'item n'existe pas";
}

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}
else {
    $error = "Erreur action";
}

if (isset($_GET["commentaire"])) {
    $commentaire = $_GET["commentaire"];
}

if (isset($_GET["note"])) {
    $note = $_GET["note"];
}

if ($error != null) {
    var_dump($error);
    redirect("catalogue.php");
}

$eval = new Evaluation($item, $joueur, $commentaire, $note);

if ($_SESSION["alias"] == $joueur->getAlias() || Joueurs()->get($_SESSION["alias"])->getEstAdmin()) {
    switch ($action) {
        case "add":
            if (isset($_GET["commentaire"])) {
                $commentaire = $_GET["commentaire"];
            }
            else {
                $error = "Erreur commentaire";
            }
            
            if (isset($_GET["note"])) {
                $note = $_GET["note"];
            }
            else {
                $error = "Erreur note";
            }
            Evaluations()->add($eval);
            break;
        case "edit":
            Evaluations()->update($eval);
            break;
        case "remove":
            Evaluations()->remove($eval);
            break;
    }
}

$id = $item->getId();
redirect("./detailsItem.php?id=$id");
