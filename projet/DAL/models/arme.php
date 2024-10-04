<?php
include_once "DAL/models/item.php";

class Arme extends Item {
  // Properties
  private $efficacite;
  private $genre;
  private $description;

  function __construct($item, $efficacite, $genre, $description) {
    parent::__construct($item->getNom(), $item->getStock(), $item->TypeItem(), $item->getPrix(), $item->getPhoto(), $item->getNote(), $item->getId());

    $this->efficacite = $efficacite;
    $this->genre = $genre;
    $this->description = $description;
  }
  
  // Setters & Getters
  function getEfficacite() {
    return $this->efficacite;
  }     
  function Genre() {
    return $this->genre;
  }
  function getDescription() {
    return $this->description;
  }
}