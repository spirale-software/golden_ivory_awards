<?php namespace G_I_A\Domain;

/**
 * @OVERVIEW: Categorie représente la catégorie à laquelle appartient un nominé.
 */
 class Categorie {
     
     /**
     * id de la Categorie.
     *
     * @var integer
     */
     private $id;
     
     /**
     * libelle de la Categorie.
     *
     * @var string
     */
     private $libelle;
     
     function getId() {
         return $this->id;
     }

     function getLibelle() {
         return $this->libelle;
     }

     function setId($id) {
         $this->id = $id;
     }

     function setLibelle($libelle) {
         $this->libelle = $libelle;
     }
 }