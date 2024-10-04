<?php
class Evaluation {
  // Properties
  private $item;
  private $joueur;
  private $commentaire;
  private $note;

  function __construct($item, $joueur, $commentaire, $note) {
    $this->item = $item;
    $this->joueur = $joueur;
    $this->commentaire = $commentaire;
    $this->note = $note;
}
  // Setters & Getters
  function getItem() {
    return $this->item;
  }
  function getJoueur() {
    return $this->joueur;
  }
  function getCommentaire() {
    return $this->commentaire;
  }
  function getNote() {
    return $this->note;
  }
}