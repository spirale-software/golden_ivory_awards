<?php namespace G_I_A\Domain;

/**
 * 
 */
class Prix {
    
     /**
     * id du du Prix.
     *
     * @var integer
     */
    private $id;

     /**
     * libellé du Prix.
     *
     * @var string
     */
    private $libelle;
    
     /**
     * descriptif du Prix.
     *
     * @var string
     */
    private $descriptif;
    
     /**
     * id de la categorie du Prix.
     *
     * @var ineteger
     */
    private $categorieID;
    
    /**
     * libellé de la categorie à laquelle appartient le Prix.
     *
     * @var string
     */
    private $libelleCategorie;

     /**
     * id du nomine ayant gagné le Prix.
     *
     * @var integer
     */
    private $gagnantID;
    
     /**
     * id de la photo du Prix.
     *
     * @var integer
     */
    private $photoID;
    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getDescriptif() {
        return $this->descriptif;
    }

    function getCategorieID() {
        return $this->categorieID;
    }

    function getGagnantID() {
        return $this->gagnantID;
    }

    function getPhotoID() {
        return $this->photoID;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    function setCategorieID($categorieID) {
        $this->categorieID = $categorieID;
    }

    function setGagnantID($gagnantID) {
        $this->gagnantID = $gagnantID;
    }

    function setPhotoID($photoID) {
        $this->photoID = $photoID;
    }
    
     function getLibelleCategorie() {
        return $this->libelleCategorie;
    }

    function setLibelleCategorie($libelleCategorie) {
        $this->libelleCategorie = $libelleCategorie;
    }
}

