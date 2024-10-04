<?php

class elemPotion {
    private $idPotion;
    private $idElement;
    function __construct($idPotion,$idElement){
        $this->idPotion=$idPotion;
        $this->idElement=$idElement;
    }
    function getIdElement() {
        return $this->idElement;
      }
    function getIdPotion() {
      return $this->idPotion;
    }
}