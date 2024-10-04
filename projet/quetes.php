<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';


userAccess();
$alias = $_SESSION["alias"];
function QuestionGeneratorRandom($alias)
{
    $error = null;
    $joueur = Joueurs()->get($alias);
    $joueurId = $joueur->getId();
    $questionId = enigmes()->randomQuestionAleatoire($joueurId);
    if (empty($questionId)) {
        $error = 'Vous avez déjà répondu à toutes les questions disponibles.';
        $_SESSION["error"]= $error; 
        redirect("quetesForm.php?error=$error");
    }
    else{
        $_SESSION["idQuestion"] = $questionId;
        if (isset($_SESSION["messagereponse"])) {
            unset( $_SESSION["messagereponse"] );
            }
        if (isset($_SESSION["error"])) {
            unset( $_SESSION["error"] );
            }
        if (isset($_SESSION["question_rep"])) {
            unset($_SESSION['question_rep']);
            }
        redirect('enigmeForm.php');
    }
}


function QuestionGenerator($difficulteId, $alias)
{   
    $error = null;
    $joueur = Joueurs()->get($alias);
    $joueurId = $joueur->getId();
    $questionId = enigmes()->randomQuestion($difficulteId, $joueurId);
    if (empty($questionId)) {
        $error = 'Vous avez déjà répondu à toutes les questions pour cette difficulté.';
        $_SESSION["error"]= $error; 
        redirect("quetesForm.php?error=$error");
    }
    else{
        $_SESSION["idQuestion"] = $questionId;
        if (isset($_SESSION["messagereponse"])) {
            unset( $_SESSION["messagereponse"] );
            }
        if (isset($_SESSION["error"])) {
            unset( $_SESSION["error"] );
            }
        if (isset($_SESSION["question_rep"])) {
            unset($_SESSION['question_rep']);
            }
        redirect('enigmeForm.php');
    }
}


if(isset($_POST['submit'])) {
    $id = $_POST['option'];
    $difficultesEnigmes = DifficultesEnigmes();
    if($id == "3") {
        QuestionGeneratorRandom($alias);
    }
    $difficulte = $difficultesEnigmes->get($id);
    if ($difficulte) {
        $difficulteId = $difficulte->getId();
        QuestionGenerator($difficulteId, $alias);
    }
}
