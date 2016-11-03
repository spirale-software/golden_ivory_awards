<?php namespace G_I_A\DAO;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

include_once __DIR__ . '/../domain/Utilisateur.php';
include_once __DIR__ . '/DAO.php';

class UtilisateurDAO extends DAO implements UserProviderInterface {

    /**
     * {@inheritDoc}
     */
    protected function buildDomainObject($row) {
        $utilisateur = new \G_I_A\Domain\Utilisateur();
        
        $utilisateur->setId($row['id']);
        $utilisateur->setEmail($row['email']);
        $utilisateur->setPassword($row['password']);
        $utilisateur->setPrenom($row['prenom']);
        $utilisateur->setSalt($row['salt']);
        $utilisateur->setRole($row['role']);
        
        return $utilisateur;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username) {
        echo $username;
        $username = 'admin@admin.com';
        $sql = "SELECT * FROM t_utilisateur WHERE email = ?";
        
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row) {
            return $this->buildDomainObject($row);
        }
        else{
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {
        
        return 'G_I_A\Domain\Utilisateur' === $class;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user) {

        $class = get_class($user);
        
        if (!$this->supportsClass($class)) {
            echo $class;
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }
}
