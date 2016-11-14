<?php

namespace G_I_A\DAO;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

include_once __DIR__ . '/../domain/User.php';
include_once __DIR__ . '/DAO.php';

class UserDAO extends DAO implements UserProviderInterface {

    /**
     * {@inheritDoc}
     */
    protected function buildDomainObject($row) {
        $user = new \G_I_A\Domain\User();

        $user($row['id']);
        $user->setEmail($row['email']);
        $user->setPwd($row['pwd']);
        $user->setPrenom($row['prenom']);
        $user->setSalt($row['salt']);
        $user->setRole($row['role']);
        return $user;
    }

    /**
     * {@inheritDoc}
     * 
     * @param string $username
     * @return type
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username) {
        echo $username;
        $username = 'admin@admin.com';
        $sql = "SELECT * FROM t_user WHERE email = ?";

        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class) {

        return 'G_I_A\Domain\User' === $class;
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
