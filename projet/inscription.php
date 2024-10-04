<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';

$title = "S'inscrire";
$actionUrl = "addJoueur.php";

$alias = isset($_SESSION['alias']) ? $_SESSION['alias'] : '';
$AliasError = isset($_SESSION['AliasError']) ? $_SESSION['AliasError'] : '';
$EmailError = isset($_SESSION['EmailError']) ? $_SESSION['EmailError'] : '';
$hidden_AliasError = isset($_SESSION['AliasError']) ? '' : 'hidden';
$hidden_EmailError = isset($_SESSION['EmailError']) ? '' : 'hidden';

delete_session();

$main = <<<HTML
<div class="container">
    <form class="form-area" method="post" action="$actionUrl">
        <div class="form-row">
            <fieldset class="form-group" >
                <label class="sub-title" for="alias">Alias</label>
                <input  type="text" 
                        class="form-style" 
                        name="alias" 
                        id="alias"
                        placeholder="Entrez un alias" 
                        required 
                        maxlength="16"
                        RequireMessage='Veuillez entrer un alias'
                        InvalidMessage='Veuillez entrer un alias plus court'/>
                <span class="form-group error $hidden_AliasError">$AliasError</span>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group">
                <label class="sub-title" for="prenom">Prénom</label>
                <input  type="text" 
                        class="form-style" 
                        name="prenom" 
                        id="prenom"
                        placeholder="Entrez votre prénom" 
                        required 
                        RequireMessage = 'Veuillez entrer votre prénom'
                        InvalidMessage = 'Prénom invalide'/>
            </fieldset>
            <fieldset class="form-group">
                <label class="sub-title" for="nom">Nom</label>
                <input  type="text" 
                        class="form-style" 
                        name="nom" 
                        id="nom"
                        placeholder="Entrez votre nom" 
                        required 
                        RequireMessage = 'Veuillez entrer votre nom'
                        InvalidMessage = 'Nom invalide'/>
                    </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group">
                <label class="sub-title" for="email">Adresse courriel</label>
                <input  type="email" 
                        class="form-style" 
                        name="email" 
                        id="email"
                        placeholder="Entrez une adresse courriel" 
                        required 
                        RequireMessage = 'Veuillez entrer votre courriel'
                        InvalidMessage = 'Courriel invalide'>
                        <span class="form-group error $hidden_EmailError">$EmailError</span>
            </fieldset>
            <fieldset class="form-group ">
                <label class="sub-title" for="matchedemail">Confirmer adresse courriel</label>
                <input  class="form-style MatchedInput" 
                        type="email" 
                        matchedInputId="email"
                        name="matchedemail" 
                        id="matchedemail" 
                        placeholder="Veuillez confirmer" 
                        required
                        RequireMessage='Veuillez entrer de nouveau votre courriel'
                        InvalidMessage="Les courriels ne correspondent pas" />
                        <span class="form-group error $hidden_EmailError">&nbsp</span>
            </fieldset>
        </div>
        <div class="form-row">
            <fieldset class="form-group">
                <label class="sub-title" for="mdp">Mot de passe</label>
                <input  type="password" 
                        class="form-style" 
                        name="mdp" 
                        id="mdp"
                        placeholder="Entrez un mot de passe" 
                        required 
                        RequireMessage = 'Veuillez entrer un mot de passe'
                        InvalidMessage = 'Mot de passe trop court'/>
            </fieldset>
            <fieldset class="form-group">
                <label class="sub-title" for="matchedPassword">Confirmer mot de passe</label>
                <input  class="form-style MatchedInput" 
                        type="password" 
                        matchedInputId="mdp"
                        name="matchedPassword" 
                        id="matchedPassword" 
                        placeholder="Veuillez confirmer"
                        required
                        InvalidMessage="Les mots de passe ne se correspondent pas" />
            </fieldset>
        </div>
        <div class="form-bottom">
            <input type='submit' name='submit' id='saveUser' value="Inscription" class="btn">
            <p>Vous avez un compte ? <a class="link link-underline" href="loginForm.php">S'identifier</a></p>
        </div>
    </form>
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