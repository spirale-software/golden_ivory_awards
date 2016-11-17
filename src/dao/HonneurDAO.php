<?php namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Honneur.php';
include_once __DIR__ . '/DAO.php';

class HonneurDAO extends DAO {

    /**
     * Insert the variable $honneur in the DB.
     *
     * @param Honneur honneur . The honneur to insert in the DB.
     *
     * @return an exception if there is any problem with the insertion.
     */
    public function save(\G_I_A\Domain\Honneur $honneur) {
        $honneur_to_insert = array(
            'libelle' => $honneur->getLibelle(),
            'descriptif' => $honneur->getDescriptif(),
            'categorie_fk' => $honneur->getCategorieID());

        try {
            $this->getDb()->insert('t_honneur', $honneur_to_insert);

            // Insérer dans la table Image, l'image correspondante à cet honneur.
            $honneur_fk = $this->getDb()->lastInsertId();
            $image_to_insert = array(
                'fileName' => $honneur->getFileName(),
                'honneur_fk' => $honneur_fk
            );
            $this->getDb()->insert('t_image', $image_to_insert);
            
        } catch (Exception $ex) {
            $message = "dao.package -> HonneurDAO.class -> save.method :: "
                    . "le honneur n'a pas pu être inséré dans la BD";
            throw new DAOException($message);
        }
    }

    /**
     * Find Honneur according to a given ID.
     *
     * @return the given Honneur objet..
     * 
     */
    public function find_honneur_by_ID($id_honneur) {

        $sql = "SELECT * FROM t_honneur WHERE id = " . $id_honneur;

        $resultat = $this->getDb()->fetchAll($sql);

        $array_of_honneur = array();

        foreach ($resultat as $row) {
            $id = $row['id'];
            $array_of_honneur[$id] = $this->buildDomainObject($row);
        }

        return $array_of_honneur;
    }

    /**
     * Delete the variable $honneur in the DB.
     *
     * @param Honneur $nomine. The Honneur to delete in the DB.
     *
     * @return an exception if there is any problem with the suppression.
     */
    public function delete($id_honneur) {

        $honneur_to_delete = array('honneur_id' => $id_honneur);

        /* Supprimer également l'image(dans la table image) correspondante à cet
          honneur. */
        $sql = 'DELETE FROM t_image WHERE honneur_fk = ?';
        $this->getDb()->executeQuery($sql, array($id_honneur));

        try {
            $this->getDb()->delete('t_honneur', $honneur_to_delete);
        } catch (Exception $ex) {
            $message = "dao.package -> NomineDAO.class -> delete.method :: "
                    . "le nominé n'a pas pu être supprimé de la BD";
            throw new DAOException($message);
        }
    }

    /**
     * 
     */
    public function find_all() {

        $sql = 'SELECT * FROM t_honneur';

        $result = $this->getDb()->fetchAll($sql);

        $array_honneur = array();
        foreach ($result as $row) {
            $honneur_id = $row['honneur_id'];
            $honneur = $this->buildDomainObject($row);
            $array_honneur[$honneur_id] = $honneur;
        }
        return $array_honneur;
    }

    protected function buildDomainObject($row) {
        $honneur = new \G_I_A\Domain\Honneur();

        $honneur_id = $row['honneur_id'];
        
        $honneur->setId($honneur_id);
        $honneur->setLibelle($row['libelle']);
        $honneur->setDescriptif($row['descriptif']);

        // Chercher la catégorie de cette honneur
        $categorie_id = $row['categorie_fk'];
        $sql = 'SELECT * FROM t_categorie WHERE categorie_id = ?';
        $categorie_row = $this->getDb()->fetchAssoc($sql, array($categorie_id));
        $categorie = CategorieDAO::builDomain($categorie_row);

        $honneur->setCategorie($categorie);

        // Chercher le gagnant de cette honneur
        $nomine_id = $row['gagnant_fk'];
        if (!is_null($nomine_id)) {
            $sql = 'SELECT * FROM Nomine WHERE nomine_id = ?';
            $gagnant_row = $this->getDb()->fetchAssoc($sql, array(nomine_id));
            $gagnant = NomineDAO::builDomain($gagnant_row);

            $honneur->setGagnant($gagnant);
        }
        
        //Chercher l'image correspondante à cette honneur.
        $sql = 'SELECT fileName FROM t_image WHERE honneur_fk = ?';
        $_fileName = $this->getDb()->fetchAssoc($sql, array($honneur_id));
        $fileName = array_shift($_fileName);
        $honneur->setFileName($fileName);
                
        return $honneur;
    }
}
