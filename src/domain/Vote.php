<?php namespace G_I_A\Domain;

/**
 * @OVERVIEW: Vote est une classe représentant le vote d'un utilisateur pour un 
 *              nominé.
 */
class Vote {
    
    /**
     * id du du vote.
     *
     * @var integer
     */
    private $id;
    
    /**
     * nominé à qui va le vote.
     *
     * @var integer
     */
    private $nomine;
    
    /**
     * utilisateur qui a donné son vote à un nominé.
     *
     * @var integer
     */
    private $utilisateur;
    
    function getId() {
        return $this->id;
    }

    function getNomine() {
        return $this->nomine;
    }

    function getUtilisateur() {
        return $this->utilisateur;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNomine($nomine) {
        $this->nomine = $nomine;
    }

    function setUtilisateur($utilisateur) {
        $this->utilisateur = $utilisateur;
    }
}
