<?php namespace G_I_A\Domain;
use \Symfony\Component\Security\Core\User\UserInterface;

/**
 * @OVERVIEW: Utilisateur est une classe représentant un utilisateur du système.
 */
class Utilisateur implements UserInterface{
    
     /**
     * id du de l'utilisateur.
     *
     * @var integer
     */
    private $id_usr;
    
     /**
     * role occupé par l'utilisateur
      * values : USR_ROLE or ADMIN_ROLE.
     *
     * @var string
     */
    private $role;
    
     /**
     * prénom de l'utilisateur.
     *
     * @var string
     */
    private $prenom;
    
    /**
     * email de l'utilisateur.
     *
     * @var string
     */
    private $email;
    
    /**
     * mot de passe de l'utilisateur.
     *
     * @var string
     */
    private $password;
    
    private $salt;
    
   
    function getId_usr() {
        return $this->id_usr;
    }

    function getRole() {
        return $this->role;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    function getSalt() {
        return $this->salt;
    }

    function setId_usr($id_usr) {
        $this->id_usr = $id_usr;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles() {
        return array($this->getRole());
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername() {
        $this->getEmail();
    }
    
    /**
     * {@inheritDoc}
     */
    public function eraseCredentials() {
        
    }
}
