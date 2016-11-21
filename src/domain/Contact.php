<?php namespace G_I_A\Domain;

/**
 * OVERVIEW: Contact est un type de données représentant un contact d'un user 
 *          vers l'administratrice.
 */
class Contact {
    
    /**
     * email du user.
     *
     * @var string
     */
    private $email;
    
    /**
     * prénom du user.
     *
     * @var string
     */
    private $prenom;
    
    /**
     * message du user.
     *
     * @var string
     */
    private $message;
    
    function getEmail() {
        return $this->email;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getMessage() {
        return $this->message;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setMessage($message) {
        $this->message = $message;
    }
}

