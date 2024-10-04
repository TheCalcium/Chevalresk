<?php
class Reponse
{
    private $id;
    private $idQuestion;
    private $texte;
    private $isTrue;
    function __construct($id, $idQuestion, $texte, $isTrue)
    {
        $this->id = $id;
        $this->idQuestion = $idQuestion;
        $this->texte = $texte;
        $this->isTrue = $isTrue;
    }
    function getIdQuestion()
    {
        return $this->idQuestion;
    }
    function getTexte()
    {
        return $this->texte;
    }
    function getId()
    {
        return $this->id;
    }
    function getIsTrue()
    {
        if ($this->isTrue == 0) {
            return false;
        }
        if ($this->isTrue == 1) {
            return True;
        }
    }

}