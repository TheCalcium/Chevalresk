<?php
class Item {
  // Properties
  private $id;
  private $nom;
  private $stock;
  private $typeItem;
  private $prix;
  private $photo;
  private $note;

  function __construct($nom, $stock, $typeItem, $prix, $photo, $note = 0, $id = null) {
    $this->id = $id;
    $this->nom = $nom;
    $this->stock = $stock;
    $this->typeItem = $typeItem;
    $this->prix = $prix;
    $this->photo = $photo;
    $this->note = $note;
  }
  // Setters & Getters
  function getId() {
    return $this->id;
  }
  function getNom() {
    return $this->nom;
  }
  function getStock() {
    return $this->stock;
  }
  function TypeItem() {
    return $this->typeItem;
  }
  function getPrix() { 
    return $this->prix;
  }
  function getPhoto() {
    return $this->photo;
  }
  function getNote() {
    return $this->note;
  }
}