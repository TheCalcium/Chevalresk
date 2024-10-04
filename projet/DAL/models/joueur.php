<?php
class Joueur
{
  // Properties
  private $id;
  private $alias;
  private $nom;
  private $prenom;
  private $email;
  private $solde;
  private $niveau;
  private $estAlchimiste;
  private $estAdmin;
  private $panier;
  private $inventaire;

  function __construct($alias, $nom, $prenom, $email, $solde = null, $niveau = null, $estAlchimiste = null, $estAdmin = null, $panier = null, $inventaire = null, $id = null)
  {
    $this->id = $id;
    $this->alias = $alias;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->email = $email;
    $this->solde = $solde;
    $this->niveau = $niveau;
    $this->estAlchimiste = $estAlchimiste;
    $this->estAdmin = $estAdmin;
    $this->panier = $panier;
    $this->inventaire = $inventaire;
  }

  // Setters & Getters
  function getId()
  {
    return $this->id;
  }
  function getAlias()
  {
    return $this->alias;
  }

  function getNom()
  {
    return $this->nom;
  }

  function getPrenom()
  {
    return $this->prenom;
  }

  function getEmail()
  {
    return $this->email;
  }

  function getSolde()
  {
    return $this->solde;
  }

  function Niveau()
  {
    return $this->niveau;
  }

  function getEstAlchimiste()
  {
    return $this->estAlchimiste;
  }

  function getEstAdmin()
  {
    return $this->estAdmin;
  }

  function Panier()
  {
    return $this->panier;
  }
  
  function Inventaire()
  {
    return $this->inventaire;
  }
}