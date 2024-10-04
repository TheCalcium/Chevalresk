<?php
include_once "DAL/DB.php";
include_once 'php/sessionManager.php';
include_once 'php/formUtilities.php';

$_SESSION['estValide'] = false;

delete_session();
redirect('accueil.php');