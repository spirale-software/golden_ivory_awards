<?php
namespace G_I_A\Domain;

/**
 * @OVERVIEW: Nomine est une classe représentant un nominé du festival.
 */
class Nomine {
    
     /**
     * id du nominé.
     *
     * @var integer
     */
    private $id;
    
     /**
     * nom du nominé.
     *
     * @var integer
     */
    private $nom;
    
     /**
     * texte décrivant le nominé.
     *
     * @var string
     */
    private $descriptif;
    
    /**
     * actualité concernant le nominé.
     *
     * @var string
     */
    private $actualite;
    
    /**
     * id de la catégorie à laquelle appartient le nominé.
     *
     * @var inetger
     */
    private $categorieID;
    
    /**
     * libelle de la catégorie à laquelle appartient le nominé.
     *
     * @var string
     */
    private $libelleCategorie;
    
    /**
     * id de la photo représentant le nominé.
     *
     * @var string
     */
    private $photoID;
    
    
    public function getId() {
        return $this->id;
    }
    
    public function getPhotoID() {
        return $this->photoID;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescriptif() {
        return $this->descriptif;
    }

    public function getActualite() {
        return $this->actualite;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    public function setActualite($actualite) {
        $this->actualite = $actualite;
    }  
    
    public function setCategorieID($categorieID) {
        $this->categorieID = $categorieID;
    }
    
    public function getCategorieID() {
        return $this->categorieID;
    }   
    
    public function setPhotoID($photoID) {
        return $this->photoID = $photoID;
    }   
    
    public function getLibelleCategorie() {
        return $this->libelleCategorie;
    }   
    
    public function setLibelleCategorie($libelleCategorie) {
        return $this->libelleCategorie = $libelleCategorie;
    }   
}

