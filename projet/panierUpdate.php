<?php
include_once "DAl/DB.php";
include_once "PHP/sessionManager.php";

userAccess();

$alias = $_SESSION["alias"];

$idItem = $_POST['id'];
$quantity = $_POST['quantity'];

Joueurs()->get($alias)->Panier()->update($idItem, $quantity);

