<?php

class DifficulteEnigme{
    private $id;
    private $difficulte;
    private $points;
    function __construct($id,$difficulte,$points){
        $this->id=$id;
        $this->difficulte=$difficulte;
        $this->points=$points;
    }
    function getId() {
        return $this->id;
    }
    function getDifficulte() {
        return $this->difficulte;
    }
    function getPoints() {
        return $this->points;
    }
}