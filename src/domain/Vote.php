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
    private $nomine_fk;

    /**
     * utilisateur qui a donné son vote à un nominé.
     *
     * @var integer
     */
    private $user_fk;

    
    function getId() {
        return $this->id;
    }

    function getNomineID() {
        return $this->nomineID;
    }

    function getUserID() {
        return $this->userID;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNomineID($nomineID) {
        $this->nomineID = $nomineID;
    }

    function setUserID($userID) {
        $this->userID = $userID;
    }
}
