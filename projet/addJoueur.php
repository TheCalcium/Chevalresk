<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';


function AliasExist($alias)
{
  $joueur = Joueurs()->get($alias);
  if ($joueur == null){
    return false;
  }
  return true;
}

function EmailExist($email)
{
  $joueur = Joueurs()->getByEmail($email);
  if ($joueur == null){
      return false;
  }
  return true;
}

if (isset($_POST['submit'])) {
  $alias = sanitizeString($_POST['alias']);
  $email = sanitizeString($_POST['email']);

  if (AliasExist($alias)) {
    $_SESSION['estValide'] = false;
    $_SESSION['AliasError'] = 'Cet alias existe déjà';
    redirect('inscription.php');
  }
  
  if (EmailExist($email)) {
    $_SESSION['estValide'] = false;
    $_SESSION['EmailError'] = 'Ce courriel est déjà utilisé';
    redirect('inscription.php');
  }

  $alias = $_POST["alias"];
  $nom = $_POST["nom"];
  $prenom = $_POST["prenom"];
  $email = strtolower($_POST["email"]);
  $mdp = $_POST["mdp"];

  echo $alias;
  echo $nom;
  echo $prenom;
  echo $email;

  $joueur = new Joueur($alias, $nom, $prenom, $email);
  Joueurs()->add($joueur, $mdp);

  $_SESSION['estValide'] = true;
  $_SESSION['estAlchimiste'] = Joueurs()->get($alias)->getEstAlchimiste();
  $_SESSION['estAdmin'] = Joueurs()->get($alias)->getEstAdmin();
  $_SESSION["alias"] = $alias;
  redirect('accueil.php');
}