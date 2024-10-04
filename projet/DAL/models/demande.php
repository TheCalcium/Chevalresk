<?php
class Demande {
  // Properties
  private $id;
  private $joueur;
  private $date;
  private $etat;
  private $message;

  function __construct($id, $joueur, $date, $etat, $message) {
    $this->id = $id;
    $this->joueur = $joueur;
    $this->date = $date;
    $this->etat = $etat;
    $this->message = $message;
  } 
  // Setters & Getters
  function getId() {
    return $this->id;
  }
  function getDate() {
    return $this->date;
  }     
  function getEtat() {
    return $this->etat;
  }
  function getMessage() {
    return $this->message;
  }
}