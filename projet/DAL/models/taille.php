<?php
class Taille {
  // Properties
  private $id;
  private $nom;

  function __construct($id, $nom) {
    $this->id = $id;
    $this->nom = $nom;
  }
  
  // Setters & Getters
  function getId() {
    return $this->id;
  }     
  function getNom() {
    return $this->nom;
  }
}