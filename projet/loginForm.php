<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';

$title = "S'identifier";
$actionUrl = "login.php";

$AliasEmailError = isset($_SESSION['AliasEmailError']) ? $_SESSION['AliasEmailError'] : '';
$mdpError = isset($_SESSION['mdpError']) ? $_SESSION['mdpError'] : '';

delete_session();

$main = <<<HTML
  <div class="container">
    <div class="form-area">
        <form method="post" action="$actionUrl">
            <div class="form-group">
                <label class="sub-title" for="alias">Alias ou email</label>
                <input type='text'
                  name='aliasemail'
                  class="form-style"
                  required
                  RequireMessage = 'Veuillez entrer votre alias ou email'
                  InvalidMessage = 'Alias ou email invalide'
                  placeholder="Alias ou email"> 
            </div>
            <span class="form-group error">$AliasEmailError</span>
            <div class="form-group">
                <label class="sub-title" for="mdp">Mot de passe</label>
                <input  type='password' 
                    name='mdp' 
                    placeholder='Mot de passe'
                    class="form-style"
                    required
                    RequireMessage = 'Veuillez entrer votre mot de passe' >
            </div>
            <span class="form-group error">$mdpError</span>
            <div class="form-bottom">
                <input type='submit' name='submit' value="Connexion" class="btn">
                <p>Vous n'avez pas de compte ? <a class="link link-underline" href="inscription.php">S'inscrire</a></p>
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