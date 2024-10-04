<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';


userAccess();

$alias = $_SESSION["alias"];
$joueur = Joueurs()->get($alias);
$joueurId = $joueur->getId();
$nbpoints = "";
if (isset($_SESSION["idQuestion"])) {
    $enigmeId = $_SESSION["idQuestion"];
    $enigme = enigmes()->get($enigmeId);
    $difficulteId = $enigme->getDifficulte();
}
if ($difficulteId==0){
    $nbpoints="50" ;
  }
  else if($difficulteId ==1) {
    $nbpoints="100" ;
  } else{
    $nbpoints="200" ;
  }

$answer = $_POST['reponse'];  
if ($answer) {          
    enigmes()->repondre_enigme($joueurId,$enigmeId,1);
    $_SESSION['enigme_visiter'] = true;
    $_SESSION['question_rep'] = $_SESSION["idQuestion"];
    redirect("./quetesForm.php?messagereponse=Bonne réponse! + {$nbpoints}$");
}
else {
    enigmes()->repondre_enigme($joueurId,$enigmeId,0);   
    $_SESSION['enigme_visiter'] = true;
    $_SESSION['question_rep'] = $_SESSION["idQuestion"];  
    redirect("./quetesForm.php?messagereponse=Mauvaise réponse!");
}



function ChangerSolde()
{

}

function DevenirAlchimiste()
{

}
// if(isset($_POST['submit'])) {
//     $difficulteId = $_POST['difficulte'];
//     if($id == "3") {
//       $id = RandomDifficulty();
//     }
//     $difficultesEnigmes->get($id);
    
// }
redirect("./enigmeForm.php");