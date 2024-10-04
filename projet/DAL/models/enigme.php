<?php
class Enigme {
  // Properties
  private $id;
  private $idDifficulte;
  private $points;
  private $typeEnigme;
  private $question;

  function __construct($id, $question, $idDifficulte, $points, $typeEnigme) {
    $this->id = $id;
    $this->question=$question;
    $this->idDifficulte = $idDifficulte;
    $this->points = $points;
    $this->typeEnigme = $typeEnigme;
}
  // Setters & Getters
  function getId() {
    return $this->id;
  }
  function getDifficulte() {
    return $this->idDifficulte;
  }
  function getPoints() {
    return $this->points;
  }     
  function getTypeEnigme() {
    return $this->typeEnigme;
  }
  function getQuestion() {
    return $this->question;
  }
}