<?php
include_once "item.php";

class Potion extends Item {
  // Properties
  private $effet;
  private $duree;
  private $typePotion;

  function __construct($item, $effet, $duree, $typePotion) {
    parent::__construct($item->getNom(), $item->getStock(), $item->TypeItem(), $item->getPrix(), $item->getPhoto(), $item->getNote(), $item->getId());

    $this->effet = $effet;
    $this->duree = $duree;
    $this->typePotion = $typePotion;
  }
  // Setters & Getters
  function getEffet() {
    return $this->effet;
  }     
  function getDuree() {
    return $this->duree;
  }
  function TypePotion() {
    return $this->typePotion;
  }
}