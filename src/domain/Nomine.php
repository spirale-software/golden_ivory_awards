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
     * catégorie à laquelle appartient le nominé.
     *
     * @var int
     */
    private $categorie;
    
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

    function getCategorie() {
        return $this->categorie;
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

    function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    function setDescriptif($descriptif) {
        $this->descriptif = $descriptif;
    }

    function setActualite($actualite) {
        $this->actualite = $actualite;
    }
}

