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
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getDescriptif() {
        return $this->descriptif;
    }

    function getActualite() {
        return $this->actualite;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    function setActualite($actualite) {
        $this->actualite = $actualite;
    }  
  
    public function setLibelleCategorie($libelle) {
        $this->libelleCategorie = $libelle;
    } 
    
    public function getLibelleCategorie() {
        return $this->libelleCategorie;
    }
    
    function setCategorieID($categorieID) {
        $this->categorieID = $categorieID;
    }
    
    function getCategorieID() {
        return $this->categorieID;
    }
    
}

