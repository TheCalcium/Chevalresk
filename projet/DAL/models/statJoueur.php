<?php

class statJoueur
{
    // Properties
    private $dateCreation;
    private $nbAchats;
    private $itemsInventaire;
    private $nbConcoctions;
    private $progressionEnigmes;
    private $nbEvaluations;
    private $totalEcusDepense;


    function __construct($dateCreation, $nbAchats, $itemsInventaire, $nbConcoctions, $progressionEnigmes, $nbEvaluations, $totalEcusDepense) {
        $this->dateCreation = $dateCreation;
        $this->nbAchats = $nbAchats;
        $this->itemsInventaire = $itemsInventaire;
        $this->nbConcoctions = $nbConcoctions;
        $this->progressionEnigmes = $progressionEnigmes;
        $this->nbEvaluations = $nbEvaluations;
        $this->totalEcusDepense = $totalEcusDepense;
    }

    // Setters & Getters
    function getDateCreation()
    {
      return $this->dateCreation;
    }
    function getNbAchats()
    {
      return $this->nbAchats;
    }
  
    function getItemsInventaire()
    {
      return $this->itemsInventaire;
    }
  
    function getNbConcoctions()
    {
      return $this->nbConcoctions;
    }
  
    function getProgressionEnigmes()
    {
      return $this->progressionEnigmes;
    }
  
    function getNbEvaluations()
    {
      return $this->nbEvaluations;
    }
  
    function getTotalEcusDepense()
    {
      return $this->totalEcusDepense;
    }
}