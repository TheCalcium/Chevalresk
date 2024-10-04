<?php
include_once "item.php";

class Armure extends Item {
  // Properties
  private $matiere;
  private $taille;

  function __construct($item, $matiere, $taille) {
    parent::__construct($item->getNom(), $item->getStock(), $item->TypeItem(), $item->getPrix(), $item->getPhoto(), $item->getNote(), $item->getId());

    $this->matiere = $matiere;
    $this->taille = $taille;
  }

  // Setters & Getters
  function getMatiere() {
    return $this->matiere;
  }     
  function Taille() {
    return $this->taille;
  }
}