<?php
include_once "DAL/DB.php";
include_once "PHP/sessionManager.php";
include_once 'php/formUtilities.php';

userAccess();

$title = "Quêtes";

$alias = $_SESSION["alias"];
$resultatreponse="";
$error = "";
if (isset($_GET["error"])) {
  $error = $_GET["error"];
}
if (isset($_GET["messagereponse"])) {
$resultatreponse = $_GET['messagereponse'];
}
$quete = "";
$hidden_QuestionGeneratorError = ($error == null) ? "hidden" : "";
$actionUrl = "quetes.php";

$resultateponseClass = ($resultatreponse == "Mauvaise réponse!") ? "message_mauvaise_reponse" : "message_reponse";
$quete .= <<<HTML
      <div class="container">
        <div class="form-area" id="options">
          <div class="quetes-infos-titre">Choisissez la difficulté de l'énigme</div><br>
            
              <form method="post" action="$actionUrl">
                <div  class="form-top">
                <div class="quetes-choix">
                <input  type="radio" id="facile" name="option" value="0" required>
                <label class="quetes-option-label" for="facile">Facile</label>
                <span class="quetes-recompense">50 écus</span><br>
                </div>
                <div class="quetes-choix">
                <input type="radio" id="moyenne" name="option" value="1" required>
                <label class="quetes-option-label" for="moyenne">Moyenne</label>
                <span class="quetes-recompense">100 écus</span><br>
                </div>
                <div class="quetes-choix">
                <input type="radio" id="difficile" name="option" value="2" required>
                <label class="quetes-option-label" for="difficile">Difficile</label>
                <span class="quetes-recompense">200 écus</span><br>
                </div>
                <div class="quetes-choix">
                <input type="radio" id="aleatoire" name="option" value="3" required>
                <label class="quetes-option-label" for="aleatoire">Aléatoire</label><br>
                <br>
                </div>
                </div>
               
                
                <div class="form-bottom">
                <span class="$resultateponseClass">$resultatreponse</span>
                <span class="error $hidden_QuestionGeneratorError">$error</span>
                  <input type='submit' name='submit' value="Commencer" class="btn">
                </div>
              </form>
              
           
          </div>
        </div>
      </div>
  
    HTML;


$main = <<<HTML
  <div>
    $quete
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