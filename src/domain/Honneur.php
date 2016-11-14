<?php namespace G_I_A\Domain;

/**
 * OVERVIEW: Honneur est une classe représentant un honneur à gagner à la fin de la
 *          compétition.
 */
class Honneur {
    
     /**
     * id du de l'Honneur.
     *
     * @var integer
     */
    private $id;

     /**
     * libellé du Honneur.
     *
     * @var string
     */
    private $libelle;
    
     /**
     * descriptif du Honneur.
     *
     * @var string
     */
    private $descriptif;
    
     /**
     * la categorie à laquelle appartient l'Honneur.
     *
     * @var G_I_A\Domain\Categorie
     */
    private $categorie;

     /**
     * nomine ayant gagné l'Honneur.
     *
     * @var G_I_A\Domain\Nomine
     */
    private $gagnant;
    
    /**
     * nom du fichier image de l'Honneur.
     *
     * @var string
     */
    private $fileName;
    
    /**
     * Permet de récupérer l'id de la catégorie au moment du remplissage du 
     * formulaire.
     * 
     * @var string 
     */
    private $categorieID;
    
    function getId() {
        return $this->id;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getDescriptif() {
        return $this->descriptif;
    }

    function getCategorie() {
        return $this->categorie;
    }

    function getGagnant() {
        return $this->gagnant;
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

    function setCategorie(\G_I_A\Domain\Categorie $categorie) {
        $this->categorie = $categorie;
    }

    function setGagnant(\G_I_A\Domain\Nomine $gagnant) {
        $this->gagnant = $gagnant;
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

