<?php namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Prix.php';
include_once __DIR__ . '/DAO.php';

class PrixDAO extends DAO {
    
    /**
     * Insert the variable $prix in the DB.
     *
     * @param Prix prix . The prix to insert in the DB.
     *
     * @return an exception if there is any problem with the insertion.
     */
    public function save($prix) {
        $prix_to_insert = array(
            'libelle' => $prix->getLibelle(),
            'descriptif' => $prix->getDescriptif(),
            'categorieID' => $prix->getCategorieID(),
            'photoID' => $prix->getPhotoID());
        try {
            $this->getDb()->insert('t_prix', $prix_to_insert);
        } catch (Exception $ex) {
            $message = "dao.package -> PrixDAO.class -> save.method :: "
                    . "le prix n'a pas pu être inséré dans la BD";
            throw new DAOException($message);
        }
    }

    /**
     * 
     */
    public function find_all() {

        $sql = 'SELECT * FROM t_prix';
        
        $result = $this->getDb()->fetchAll($sql);
   
        $array_prix = array();
        foreach ($result as $row) {
            $prix_id = $row['id'];
            $prix = $this->buildDomainObject($row);
            $array_prix[$prix_id] = $prix;
        }
        return $array_prix;
    }

    protected function buildDomainObject($row) {
        $prix = new \G_I_A\Domain\Prix();

        $prix->setId($row['id']);
        $prix->setLibelle($row['libelle']);
        $prix->setDescriptif($row['descriptif']);
        $prix->setCategorieID($row['categorieID']);
        $prix->setGagnantID($row['gagnantID']);
        $prix->setPhotoID($row['photoID']);
        
        return $prix;
    }
}
