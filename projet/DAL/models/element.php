<?php
include_once "item.php";

class Element extends Item {
  // Properties
  private $typeElement;
  private $rarete;
  private $dangerosite;

  function __construct($item, $typeElement, $rarete, $dangerosite) {
    parent::__construct($item->getNom(), $item->getStock(), $item->TypeItem(), $item->getPrix(), $item->getPhoto(), $item->getNote(), $item->getId());

    $this->typeElement = $typeElement;
    $this->rarete = $rarete;
    $this->dangerosite = $dangerosite;
}
  // Setters & Getters
  function TypeElement() {
    return $this->typeElement;
  }
  function getRarete() {
    return $this->rarete;
  }
  function getDangerosite() {
    return $this->dangerosite;
  }     
}