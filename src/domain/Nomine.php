<?php namespace G_I_A\Domain;

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
     * @var G_I_A\Domain\Categorie
     */
    private $categorie;
    
    /**
     * nom du fichier image.
     *
     * @var string
     */
    private $fileName;
    
    /**
     * Recupère l'id de la catégorie lors de l'inscription d'un nouveau nominé 
     * via le formulaire.
     * 
     * @var integer
     */
    private $categorieID;
            
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

    function getCategorie() {
        return $this->categorie;
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

    function setCategorie(\G_I_A\Domain\Categorie $categorie) {
        $this->categorie = $categorie;
    }  
    
    function getFileName() {
        return $this->fileName;
    }

    function setFileName($fileName) {
        $this->fileName = $fileName;
    }
    
    function getCategorieID() {
        return $this->categorieID;
    }

    function setCategorieID($categorieID) {
        $this->categorieID = $categorieID;
    }
}

