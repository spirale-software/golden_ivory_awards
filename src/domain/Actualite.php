<?php namespace G_I_A\Domain;

/**
 * OVERVIEW: Actualite est un type de données représentant une actualité du 
 *          moment.
 */
class Actualite {

    /**
     * id de l'actualité.
     *
     * @var integer
     */
    private $id;
    
    /**
     * titre de l'actualité.
     *
     * @var string
     */
    private $titre;
    
    /**
     * descriptif de l'actualité.
     *
     * @var string
     */
    private $descriptif;
    
    /**
     * date à laquelle l'actualité a été écrite.
     *
     * @var Date
     */
    private $date;
    
    /**
     * image associée à cette actualite.
     *
     * @var string
     */
    private $fileName;
    
    function getId() {
        return $this->actualite_id;
    }

    function getTitre() {
        return $this->titre;
    }

    function getDescriptif() {
        return $this->descriptif;
    }

    function getDate() {
        return $this->date;
    }

    function setId($actualite_id) {
        $this->actualite_id = $actualite_id;
    }

    function setTitre($titre) {
        $this->titre = $titre;
    }

    function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    function setDate(Date $date) {
        $this->date = $date;
    }
    
    function getFileName() {
        return $this->fileName;
    }

    function setFileName($fileName) {
        $this->fileName = $fileName;
    }
}

