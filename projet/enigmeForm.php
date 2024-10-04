<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';

//pour empecher de pouvoir farm en retournant sur la meme question sinon tu fait back et tu a infinit money
if(isset($_SESSION['enigme_visiter']) && isset($_SESSION['question_rep']) && $_SESSION['question_rep'] == $_SESSION["idQuestion"]) {
    $_SESSION["error"] = "Vous ne pouvez pas revenir à une question déjà répondue!";
    header("Location: quetesForm.php");
    exit(); 
}

$title = "Énigme";
$actionUrl = "enigme.php";
$difficulte = "";
$difficulteId="";
$question =  "";
$recompense =  "";
$estReussi =  "";
$questionId = $_SESSION["idQuestion"];
if (isset($_SESSION["idQuestion"])) {
  $enigme = enigmes()->get($questionId);

  $reponses = Reponses()->toListQuestion($questionId);
  $difficulteId = $enigme->getDifficulte();
  $question = $enigme->getQuestion();
  $recompense = $enigme->getPoints();
  $typeenigme = $enigme->getTypeEnigme()->getNom();
  

}
if ($difficulteId== 0){
  $difficulte = "Facile";
}
else if($difficulteId == 1) {
  $difficulte="Moyenne";
} else{
  $difficulte= "Difficile";
}
     
$leschoixHtml = "";
foreach ($reponses as $reponse ) {
  $idReponse=$reponse->getId();
  $choix=$reponse->getTexte();
  $estReussi =  $reponse->getIsTrue();
  $leschoixHtml .= "<div  class='reponse-enigme'>";
  $leschoixHtml .= "<input id='radio$idReponse' type='radio' name='reponse' class='' value='$estReussi'>";
  $leschoixHtml .= "<label for='radio$idReponse'>$choix</span>";
  $leschoixHtml .= "</div>";
}
$main = <<<HTML
   <div class="container">
    <div class="form-area">
        <span>$difficulte</span>
        <span class="enigmes-typeenigme">$typeenigme</span>
        <span class='enigme-titre'>$question</span>
        <br>
         <form method="post" action="$actionUrl">
          <div class="enigmes-quetes">
             <div class="enigmes-layout">
                 $leschoixHtml
             </div>
             
             
             <div class="confirmation-btn-layout">
                 <a href="./quetesForm" class="confirmation-btn confirmation-btn-red btn"><span class="panier-item-info-title" style="color:white;">Annuler</span></a>
                 <button type="submit" class="confirmation-btn btn"><span class="panier-item-info-title" style="color:white;">Soumettre</span></button>
             </div>
            </div>
         </form>
     </div>
   </div>
 HTML;

$otherScript = <<<HTML
  <script defer>
    $(document).ready(function() {
        initFormValidation();
    });
    
  </script>
  HTML;
include "views/master.php";
