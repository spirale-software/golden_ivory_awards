<?php

namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Nomine.php';
include_once __DIR__ . '/DAO.php';
include_once __DIR__ . '/../exception/DAOException.php';

/**
 * @OVERVIEW: NomineDAO représente le Data Access Objet(DAO) utilisé pour 
 *             l'accès à la BD.
 */
class NomineDAO extends DAO {

    /**
     * Insert the variable $nomine in the DB.
     *
     * @param Nomine $nomine. The nomine to insert in the DB.
     *
     * @return an exception if there is any problem with the insertion.
     */
    public function save($nomine) {
        $nomine_to_insert = array(
            'nom' => $nomine->getNom(),
            'categorie_nomine' => $nomine->getCategorie(),
            'descriptif' => $nomine->getDescriptif(),
            'actualite' => $nomine->getActualite());
        try {
            $this->getDb()->insert('t_nomine', $nomine_to_insert);
        } catch (Exception $ex) {
            $message = "dao.package -> NomineDAO.class -> save.method :: "
                    . "le nominé n'a pas pu être inséré dans la BD";
            throw new DAOException($message);
        }
    }

    /**
     * Delete the variable $nomine in the DB.
     *
     * @param Nomine $nomine. The nomine to delete in the DB.
     *
     * @return an exception if there is any problem with the suppression.
     */
    public function delete(\G_I_A\Domain\Nomine $nomine) {

        $nomine_to_delete = array('id_nomine' => $nomine->getId());
        try {
            $this->getDb()->delete('t_nomine', $nomine_to_delete);
        } catch (Exception $ex) {
            $message = "dao.package -> NomineDAO.class -> delete.method :: "
                    . "le nominé n'a pas pu être supprimé de la BD";
            throw new DAOException($message);
        }
    }

    /**
     * Edit the variable $nomine in the DB.
     *
     * @param Nomine $nomine. The nomine to edit in the DB.
     *
     * @return an exception if there is any problem with the edition.
     */
    public function edit(\G_I_A\Domain\Nomine $nomine) {

        $nomineData = array(
            'nom' => $nomine->getNom(),
            'categorie_nomine' => $nomine->getCategorie(),
            'descriptif' => $nomine->getDescriptif(),
            'actualite' => $nomine->getActualite());

        $nomine_to_update = array('id_nomine' => $nomine->getId());

        try {
            $this->getDb()->update('t_nomine', $nomineData, $nomine_to_update);
        } catch (Exception $ex) {
            $message = "dao.package -> NomineDAO.class -> edit.method :: "
                    . "le nominé n'a pas pu être mis à jour dan la BD";
            throw new DAOException($message);
        }
    }

    /**
     * Find all Nomine in DB.
     *
     * @return an array of Nomine objet..
     */
    public function find_all_nomine() {

            $sql = "SELECT * FROM t_nomine";
            $attribute = 'All';
            
            return $this->find($sql, $attribute);
    }

    /**
     * Find Nomine according to a given ID.
     *
     * @return the given Nomine objet..
     * 
     */
    public function find_nomine_by_ID($id_nomine) {

        $sql = "SELECT * FROM t_nomine WHERE id_nomine = " . $id_nomine;
        $attribute = 'ID';

        return $this->find($sql, $attribute);
    }

    /**
     * Find Nomine according to a given categorie.
     *
     * @return an array of Nomine objet who are in the same categorie..
     * 
     */
    public function find_nomine_by_categorie($categorie) {

        $sql = "SELECT * FROM t_nomine WHERE categorie_nomine = "
                . $categorie;
        $attribute = 'Categorie';

        return $this->find($sql, $attribute);
    }

    /**
     * Creates a Nomine object based on a DB row.
     *
     * @param array $row The DB row containing Nomine data.
     * @return \G_I_A\Domain\Nomine
     */
    protected function buildDomainObject($row) {
        $nomine = new \G_I_A\Domain\Nomine();

        $nomine->setId($row['id_nomine']);
        $nomine->setNom($row['nom']);
        $nomine->setCategorie($row['categorie_nomine']);
        $nomine->setDescriptif($row['descriptif']);
        $nomine->setActualite($row['actualite']);

        return $nomine;
    }

    /**
     * Creates an array of Nomine object based on a DB row.
     *
     * @param request $sql, $attribute specifie about what is the condition in 
     *          sql request.
     * @return an array of Nomine object
     * 
     * @expectedException DAOException
     */
    private function find($sql, $attribute) {

        try {
            $nomines = $this->getDb()->fetchAll($sql);

            $array_of_nomines = array();

            foreach ($nomines as $row) {
                $id = $row['id_nomine'];
                $array_of_nomines[$id] = $this->buildDomainObject($row);
            }

            return $array_of_nomines;
        } catch (Exception $ex) {

            $message = "dao.package -> NomineDAO.class -> findAll.method :: "
                    . "Impossible de récupérer tous les nominés de la BD à "
                    . "partir de la" . $attribute;
            throw new DAOException($message);
        }
    }

}
