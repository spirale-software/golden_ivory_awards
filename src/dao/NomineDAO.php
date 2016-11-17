<?php

namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Nomine.php';
include_once __DIR__ . '/DAO.php';
include_once __DIR__ . '/../exception/DAOException.php';
include_once __DIR__ . '/CategorieDAO.php';

/**
 * @OVERVIEW: NomineDAO représente le Data Access Objet(DAO) utilisé pour 
 *             l'accès à la BD.
 */
class NomineDAO extends DAO {

    /**
     * Insert the variable $nomine in the DB.
     *
     * @param Nomine $nomine . The nomine to insert in the DB.
     *
     * @return an exception if there is any problem with the insertion.
     */
    public function save($nomine) {
        $nomine_to_insert = array(
            'nom' => $nomine->getNom(),
            'categorie_fk' => $nomine->getCategorieID(),
            'descriptif' => $nomine->getDescriptif(),
            'actualite' => $nomine->getActualite());
        try {
            $this->getDb()->insert('t_nomine', $nomine_to_insert);

            //Inserer l'image ce nomine dans la BD.
            $image_to_insert = array(
                'fileName' => $nomine->getFileName(),
                'nomine_fk' => $this->getDb()->lastInsertId()
            );
            $this->getDb()->insert('t_image', $image_to_insert);
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
     */
    public function delete(\G_I_A\Domain\Nomine $nomine) {
      
        // Supprimer l'image correspondante à ce nominé dans la BD.         
        $image_to_delete = array('nomine_fk' => $nomine->getId());
        $this->getDb()->delete('t_image', $image_to_delete);
        
        // Suppremer le nomine concerné dans la BD.
        $nomine_to_delete = array('nomine_id' => $nomine->getId());
        $this->getDb()->delete('t_nomine', $nomine_to_delete);
    }

    /**
     * Edit the variable $nomine in the DB.
     *
     * @param Nomine $nomine. The nomine to edit in the DB.
     *
     * @return an exception if there is any problem with the edition.
     */
    public function edit(\G_I_A\Domain\Nomine $nomine) {

        // Modifier la photo de ce nomine si nécessaire.
        $sql = 'SELECT fileName FROM t_image WHERE nomine_fk = ?';
        $_fileName = $this->getDb()->fetchAssoc($sql, array($nomine->getId()));
        $current_fileName = array_shift($_fileName);
        if ($nomine->getFileName() != $current_fileName) {
            
            $imageData = array(
                'fileName' => $nomine->getFileName()
            );
            $image_to_update = array('nomine_fk' => $nomine->getId());
            $this->getDb()->update('t_image', $imageData , $image_to_update);
        }
        
        // Modifier les données du nominé proprement dites.
        $nomineData = array(
            'nom' => $nomine->getNom(),
            'categorie_fk' => $nomine->getCategorieID(),
            'descriptif' => $nomine->getDescriptif(),
            'actualite' => $nomine->getActualite());
        $nomine_to_update = array('nomine_id' => $nomine->getId());
        $this->getDb()->update('t_nomine', $nomineData, $nomine_to_update);
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

        $sql = "SELECT * FROM t_nomine WHERE nomine_id = " . $id_nomine;
        $attribute = 'ID';

        return $this->find($sql, $attribute);
    }

    /**
     * Find Nomine according to a given categorie.
     *
     * @return an array of Nomine objet who are in the same categorie..
     * 
     */
    public function find_nomine_by_categorie($id_categorie) {

        $sql = "SELECT * FROM t_nomine WHERE categorieID = "
                . $id_categorie;
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

        //return $this->builDomain($row);

        $nomine = new \G_I_A\Domain\Nomine();

        $nomine_id = $row['nomine_id'];

        // Chercher la categorie 
        $categorie_id = $row['categorie_fk'];
        $sql = 'SELECT * FROM t_categorie WHERE categorie_id = ?';
        $categorie_row = $this->getDb()->fetchAssoc($sql, array($categorie_id));
        $categorie = \G_I_A\DAO\CategorieDAO::builDomain($categorie_row);

        // Chercher l'image correspondante à ce nomine.
        $sql = 'SELECT fileName FROM t_image WHERE nomine_fk = ?';
        $_fileName = $this->getDb()->fetchAssoc($sql, array($nomine_id));
        $fileName = array_shift($_fileName);

        $nomine->setId($nomine_id);
        $nomine->setNom($row['nom']);
        $nomine->setCategorie($categorie);
        $nomine->setDescriptif($row['descriptif']);
        $nomine->setActualite($row['actualite']);
        $nomine->setFileName($fileName);

        return $nomine;
    }

    public static function builDomain($row) {

        $nomine = new \G_I_A\Domain\Nomine();

        $nomine_id = $row['nomine_id'];

        // Chercher la categorie 
        $categorie_id = $row['categorie_fk'];
        $sql = 'SELECT * FROM t_categorie WHERE categorie_id = ?';
        $categorie_row = $this->getDb()->fetchAssoc($sql, $categorie_id);
        $categorie = \G_I_A\DAO\CategorieDAO::builDomain($categorie_row);

        // Chercher l'image de cette categorie
        $sql = 'SELECT * FROM t_image WHERE nomine_fk = ?';
        $image_row = $this->getDb()->fetchAssoc($sql, array($nomine_id));

        $nomine->setId($nomine_id);
        $nomine->setNom($row['nom']);
        $nomine->setCategorie($categorie);
        $nomine->setDescriptif($row['descriptif']);
        $nomine->setActualite($row['actualite']);
        $nomine->setFileName($image_row['fileName']);

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
                $id = $row['nomine_id'];
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
