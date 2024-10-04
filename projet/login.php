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

function mdpOk($mdp)
{
    return Joueurs()->verify($_POST['alias'], $mdp);
}

if (isset($_POST['submit'])) {
    $aliasemail = sanitizeString($_POST['aliasemail']);

    if (!AliasExist($aliasemail)) {

        if (!EmailExist($aliasemail)) {
            $estValide = false;
            $_SESSION['AliasEmailError'] = 'Cet alias ou email n\'existe pas';
            redirect('loginForm.php');
        }
        else {
            $alias = Joueurs()->getByEmail($aliasemail)->getAlias();
        }
    }
    else {
        $alias = Joueurs()->get($aliasemail)->getAlias();
    }

    if (!Joueurs()->verify($alias, $_POST['mdp'])) {
        $estValide = false;
        $_SESSION['mdpError'] = 'Mot de passe incorrect';
        redirect('loginForm.php');
    }

    $_SESSION['estValide'] = true;
    $_SESSION['estAlchimiste'] = Joueurs()->get($alias)->getEstAlchimiste();
    $_SESSION['estAdmin'] = Joueurs()->get($alias)->getEstAdmin();
    $_SESSION["alias"] = $alias;
    redirect('accueil.php');
}