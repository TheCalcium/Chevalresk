<?php
include_once "DAl/DB.php";

date_default_timezone_set('US/Eastern');
session_start();

function delete_session()
{
    session_destroy(); // effacer le fichier ../wamp64/tmp/sess_PHPSESSID
    session_start();
}

function redirect($url)
{
    header('location:' . $url);
    exit();
}

function userAccess()
{
    if (!isset($_SESSION['estValide'])) {
        redirect('loginForm.php');
    }
}

function alchemisteAccess()
{
    if (isset($_SESSION['alias'])) {
        if (!Joueurs()->get($_SESSION['alias'])->getEstAlchimiste())
            redirect('forbidden.php');
    } else
        redirect('loginForm.php');
}

function adminAccess()
{
    if (isset($_SESSION['estAdmin'])) {
        if (!(bool)$_SESSION['estAdmin'])
            redirect('forbidden.php');
    } else
        redirect('loginForm.php');
}
