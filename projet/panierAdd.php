<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$alias = $_SESSION["alias"];
$idItem = $_POST['id'];

Joueurs()->get($alias)->Panier()->add($idItem);
